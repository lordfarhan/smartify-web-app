<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Institution;
use App\User;
use App\UserInstitution;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('jwt.auth', []);
  }

  /**
   * API Recover Password
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function me(Request $request)
  {
    // $this->validate($request, ['token' => 'required']);

    $user = Auth::user()->toArray();
    $user['email_verified_at'] = Carbon::parse(Auth::user()->email_verified_at)->format('d/m/Y');
    $user['date_of_birth'] = Carbon::parse(Auth::user()->date_of_birth)->format('d/m/Y');
    $user['image'] = url('storage/' . Auth::user()->image);
    $user['village'] = Auth::user()->village != null ? ucwords(strtolower(Auth::user()->village->name)) : null;
    $user['district'] = Auth::user()->village != null ? ucwords(strtolower(Auth::user()->village->district->name)) : null;
    $user['regency'] = Auth::user()->village != null ? ucwords(strtolower(Auth::user()->village->district->regency->name)) : null;
    $user['province'] = Auth::user()->village != null ? ucwords(strtolower(Auth::user()->village->district->regency->province->name)) : null;
    $user['roles'] = Auth::user()->getRoleNames();
    $user['institutions'] = Institution::whereIn('id', Auth::user()->institutions->pluck('institution_id'))->pluck('name');
    $user['created_at'] = Carbon::parse(Auth::user()->created_at)->format('d/m/Y');
    $user['updated_at'] = Carbon::parse(Auth::user()->updated_at)->format('d/m/Y');

    try {
      return response()->json([
        'success' => true,
        'message' => 'Successfully fetched user data',
        'user' => $user
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'user' => null
      ], 500);
    }
  }

  /**
   * Update name.
   *
   * @param  Request $request, 
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(Request $request, $field)
  {
    $rules = array();

    $user = User::find(Auth::user()->id);
    $input = array();

    switch ($field) {
      case "name":
        $rules = [
          'name' => 'required',
        ];
        $input = $request->only('name');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
          return response()->json(['success' => false, 'message' => $validator->messages(), 'result' => null]);
        }

        $input['name'] = ucwords(strtolower($input['name']));
        break;
      case "image":
        $rules = [
          'image' => 'required|mimes:jpg,JPEG,PNG,png,jpeg,JPG',
        ];
        $input = $request->only('image');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
          return response()->json(['success' => false, 'message' => $validator->messages(), 'result' => null]);
        }

        // Deleting existing image
        if (File::exists(storage_path('app/public/' . $user->image))) {
          File::delete(storage_path('app/public/' . $user->image));
        }
        $image = $request->file('image');
        $imageName = 'userImage' . Carbon::now()->format('YmdHis') . '_' . preg_replace('/\s+/', '', $user->name) . '.' . 'png';
        Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(storage_path('app/public/users/') . $imageName);
        $input['image'] = 'users/' . $imageName;
        break;
      case "address":
        $rules = [
          'address' => 'required',
          'village_id' => 'required',
        ];
        $input = $request->only('address', 'village_id');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
          return response()->json(['success' => false, 'message' => $validator->messages(), 'result' => null]);
        }

        break;
      case "birthdate":
        $rules = [
          'date_of_birth' => 'required|before:today',
        ];
        $input = $request->only('date_of_birth');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
          return response()->json(['success' => false, 'message' => $validator->messages(), 'result' => null]);
        }

        $input['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $input['date_of_birth']);
        break;
      case "gender":
        $rules = [
          'gender' => 'required'
        ];
        $input = $request->only('gender');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
          return response()->json(['success' => false, 'message' => $validator->messages(), 'result' => null]);
        }

        break;
    }

    try {
      $user->update($input);
      $userArray = $user->toArray();
      $userArray['email_verified_at'] = Carbon::parse($user->email_verified_at)->format('d/m/Y');
      $userArray['date_of_birth'] = Carbon::parse($user->date_of_birth)->format('d/m/Y');
      $userArray['image'] = url('storage/' . $user->image);
      $userArray['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
      $userArray['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
      $userArray['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
      $userArray['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
      $userArray['roles'] = $user->getRoleNames();
      $userArray['institutions'] = Institution::whereIn('id', $user->institutions->pluck('institution_id'))->pluck('name');
      $userArray['created_at'] = Carbon::parse($user->created_at)->format('d/m/Y');
      $userArray['updated_at'] = Carbon::parse($user->updated_at)->format('d/m/Y');

      return response()->json([
        'success' => true,
        'message' => "You have successfully updated your data.",
        'user' => $userArray
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'user' => null
      ]);
    }
  }

  public function institutions(Request $request)
  {
    try {
      $institution_ids = UserInstitution::where('user_id', Auth::user()->id)->pluck('institution_id');
      $institutions = Institution::whereIn('id', $institution_ids)->get();
      foreach ($institutions as $institution) {
        $institution['enrolled'] = 1;
      }
      return response()->json([
        'success' => true,
        'message' => 'Successfully fetched user institutions',
        'result' => $institutions
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }
}
