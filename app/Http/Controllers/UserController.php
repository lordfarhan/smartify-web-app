<?php

namespace App\Http\Controllers;

use App\Institution;
use App\Province;
use App\User;
use App\UserInstitution;
use App\Village;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:user-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::user()->hasRole('Master')) {
      $data = User::orderBy('id', 'desc')->get();
    } else {
      $user_ids = UserInstitution::where('institution_id', Auth::user()->institutions->pluck('institution_id'))->pluck('user_id');
      $data = User::whereIn('id', $user_ids)->orderBy('id', 'desc')->get();
    }
    return view('users.index', compact('data'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if (Auth::user()->hasRole('Master')) {
      $roles = Role::pluck('name', 'name')->all();
    } else {
      $roles = Role::whereNotIn('name', ['Master'])->pluck('name', 'name')->all();
    }
    $institutions = Institution::all();
    $provinces = Province::all();
    return view('users.create', compact('institutions', 'roles', 'provinces'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|same:confirm-password',
      'phone' => 'required|unique:users,phone',
      'roles' => 'required',
      'image' => 'mimes:jpg,png,jpeg,JPG',
    ]);

    $input = $request->all();
    $input['name'] = ucwords(strtolower($input['name']));

    if (!empty($request->file('image'))) {
      $image = $request->file('image');
      $imageName = 'userImage' . Carbon::now()->format('YmdHis') . '_' . preg_replace('/\s+/', '', request('name')) . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(storage_path('app/public/users/') . $imageName);
      $input['image'] = 'users/' . $imageName;
    }
    $input['password'] = Hash::make($input['password']);

    $user = User::create($input);
    $user->assignRole($request->input('roles'));

    $institution_ids = $request->input('institution_id');

    if ($institution_ids != null) {
      foreach ($institution_ids as $index => $institution_id) {
        $user_institution = new UserInstitution();
        $user_institution->user_id = $user->id;
        $user_institution->institution_id = $institution_id;
        $user_institution->save();
      }
    }

    return redirect()->route('users.index')
      ->with('success', 'User created successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::find($id);
    return view('users.show', compact('user'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = User::find($id);
    if (Auth::user()->hasRole('Master')) {
      $roles = Role::pluck('name', 'name')->all();
    } else {
      $roles = Role::whereNotIn('name', ['Master'])->pluck('name', 'name')->all();
    }
    $institutions = Institution::all();
    $userRole = $user->roles->pluck('name', 'name')->all();
    $provinces = Province::all();
    $village = Village::find($user->village_id);
    return view('users.edit', compact('user', 'institutions', 'roles', 'userRole', 'provinces', 'village'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $user = User::find($id);

    $rules = array(
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'same:confirm-password',
      'phone' => 'required|unique:users,phone',
      'address' => 'required',
      'roles' => 'required',
      'image' => 'mimes:jpg,png,jpeg,JPG'
    );
    if (request('email') == $user->email) {
      $rules['email'] = 'required|email';
    }
    if (request('phone') == $user->phone) {
      $rules['phone'] = 'required';
    }
    $this->validate($request, $rules);

    $input = $request->all();
    $input['name'] = ucwords(strtolower($input['name']));

    if (!empty($request->file('image'))) {
      // Deleting existing image
      if (File::exists(storage_path('app/public/' . $user->image))) {
        File::delete(storage_path('app/public/' . $user->image));
      }
      $image = $request->file('image');
      $imageName = 'userImage' . Carbon::now()->format('YmdHis') . '_' . preg_replace('/\s+/', '', request('name')) . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(storage_path('app/public/users/') . $imageName);
      $input['image'] = 'users/' . $imageName;
    } else {
      $input = array_except($input, array('image'));
    }

    if (!empty($input['password'])) {
      $input['password'] = Hash::make($input['password']);
    } else {
      $input = array_except($input, array('password'));
    }

    $user->update($input);
    DB::table('model_has_roles')->where('model_id', $id)->delete();

    $user->assignRole($request->input('roles'));

    /**start user institution(s) data */
    $old_institutions = $user->institutions;
    $institution_ids = $request->input('institution_id');

    $old_institution_ids = $old_institutions->pluck('institution_id');
    $saved_institution_ids = array();

    if ($institution_ids != null) {
      foreach ($institution_ids as $i => $institution_id) {
        foreach ($old_institution_ids as $j => $old_institution_id) {
          if ($institution_id == $old_institution_id) {
            array_push($saved_institution_ids, $institution_id);
            unset($institution_ids[$i]);
            break;
          }
        }
      }
    }

    // Delete unselected institution
    UserInstitution::where('user_id', $user->id)->whereNotIn('institution_id', $saved_institution_ids)->delete();

    // Save new selected institution
    if ($institution_ids != null) {
      foreach ($institution_ids as $index => $institution_id) {
        $user_institution = new UserInstitution();
        $user_institution->user_id = $user->id;
        $user_institution->institution_id = $institution_id;
        $user_institution->save();
      }
    }
    /**end of saving user institutions */

    return redirect()->route('users.index')
      ->with('success', 'User updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::find($id);
    if (File::exists(storage_path('app/public/' . $user->image))) {
      File::delete(storage_path('app/public/' . $user->image));
    }
    $user->delete();
    return redirect()->route('users.index')
      ->with('success', 'User deleted successfully');
  }

  /**
   * Display the user info.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function me(Request $request)
  {
    $user = User::find(Auth::user()->id);
    return view('users.show', compact('user'));
  }
}
