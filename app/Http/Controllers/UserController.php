<?php

namespace App\Http\Controllers;

use App\Institution;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->institution->id == 1) {
            $data = User::orderBy('id', 'desc')->get();
        } else {
            $data = User::where('institution_id', Auth::user()->institution->id)->orderBy('id', 'desc')->get();
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
        if(Auth::user()->roles('master')) {
            $roles = Role::pluck('name', 'name')->all();
            $institutions = Institution::pluck('name', 'id')->all();
        } else {
            $roles = Role::whereNotIn('name', ['master'])->pluck('name', 'name')->all();
            $institutions = Institution::whereNotIn('id', [1])->pluck('name', 'id')->all();
        }
        $institutions = Institution::pluck('name', 'id')->all();
        return view('users.create', compact('institutions', 'roles'));
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
            'address' => 'required',
            'institution_id' => 'required',
            'roles' => 'required',
            'image'=> 'mimes:jpg,png,jpeg,JPG',
        ]);

        $input = $request->all();

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $imageName = preg_replace('/\s+/', '', request('name')) . '.' . 'png';
            Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(storage_path('app/public/users/') . $imageName);
            $input['image'] = 'users/' . $imageName;
        }
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

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
        if(Auth::user()->roles('master')) {
            $roles = Role::pluck('name', 'name')->all();
            $institutions = Institution::pluck('name', 'id')->all();
        } else {
            $roles = Role::whereNotIn('name', ['master'])->pluck('name', 'name')->all();
            $institutions = Institution::whereNotIn('id', [1])->pluck('name', 'id')->all();
        }
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'institutions', 'roles', 'userRole'));
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

        if (request('email') == $user->email) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'same:confirm-password',
                'phone' => 'required',
                'address' => 'required',
                'institution_id' => 'required',
                'roles' => 'required',
                'image'=> 'mimes:jpg,png,jpeg,JPG',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'same:confirm-password',
                'phone' => 'required',
                'address' => 'required',
                'institution_id' => 'required',
                'roles' => 'required',
                'image'=>'mimes:jpg,png,jpeg,JPG',
            ]);
        }

        $input = $request->all();

        if (!empty($request->file('image'))) {
            // Deleting existing image
            if (File::exists(storage_path('app/public/' . $user->image))) {
                File::delete(storage_path('app/public/' . $user->image));
            }
            $image = $request->file('image');
            $imageName = preg_replace('/\s+/', '', request('name')) . '.' . 'png';
            Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(storage_path('app/public/users/') . $imageName);
            $input['image'] = 'users/' . $imageName;
        } else {
            $input = array_except($input, array('image'));
        }

        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input,array('password'));    
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
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
}
