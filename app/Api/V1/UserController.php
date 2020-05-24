<?php

namespace App\Api\V1;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller {

  /**
   * Update name.
   *
   * @param  Request $request, 
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateName(Request $request) {
    $user = User::find(Auth::user()->id);

    $rules = [
        'name' => 'required',
        'token' => 'required'
    ];

    $validator = Validator::make($request->only('name'), $rules);

    if($validator->fails()) {
      return response()->json(['success'=> false, 'message'=> $validator->messages()]);
    }

    $input = $request->only('name');
    $input['name'] = ucwords(strtolower($input['name']));

    try {
      $user->update($input);
      return response()->json(['success' => true, 'message'=> "You have successfully updated name."]);
    } catch(Exception $e) {
      return response()->json(['success' => false, 'message'=> $e->getMessage()]);
    }
  }

  /**
   * Update image.
   *
   * @param  Request $request, 
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateImage(Request $request) {
    $user = User::find(Auth::user()->id);

    $rules = [
        'image'=> 'mimes:jpg,JPEG,PNG,png,jpeg,JPG',
        'token' => 'required'
    ];

    $validator = Validator::make($request->only('image'), $rules);

    if($validator->fails()) {
      return response()->json(['success'=> false, 'message'=> $validator->messages()]);
    }

    $input = $request->only('image');

    // Deleting existing image
    if (File::exists(storage_path('app/public/' . $user->image))) {
      File::delete(storage_path('app/public/' . $user->image));
    }
    $image = $request->file('image');
    $imageName = 'userImage'. Carbon::now()->format('YmdHis'). '_' .preg_replace('/\s+/', '', request('name')) . '.' . 'png';
    Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(storage_path('app/public/users/') . $imageName);
    $input['image'] = 'users/' . $imageName;

    try {
      $user->update($input);
      return response()->json(['success' => true, 'message'=> "You have successfully updated image."]);
    } catch(Exception $e) {
      return response()->json(['success' => false, 'message'=> $e->getMessage()]);
    }
  }

  /**
   * Update address.
   *
   * @param  Request $request, 
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateAddress(Request $request) {
    $user = User::find(Auth::user()->id);
    
    $rules = [
      'address' => 'required',
      'village_id' => 'required',
      'token' => 'required'
    ];

    $validator = Validator::make($request->only('address', 'village_id'), $rules);

    if($validator->fails()) {
      return response()->json(['success'=> false, 'message'=> $validator->messages()]);
    }

    $input = $request->only('address', 'village_id');

    try {
      $user->update($input);
      return response()->json(['success' => true, 'message'=> "You have successfully updated name."]);
    } catch(Exception $e) {
      return response()->json(['success' => false, 'message'=> $e->getMessage()]);
    }
  }

  /**
   * Update date of birth format d/m/Y ex: 12/05/2000.
   *
   * @param  Request $request, 
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateDateOfBirth(Request $request) {
    $user = User::find(Auth::user()->id);

    $rules = [
      'date_of_birth' => 'required|before:today',
      'token' => 'required'
    ];

    $validator = Validator::make($request->only('date_of_birth'), $rules);

    if($validator->fails()) {
      return response()->json(['success' => false, 'message' => 'Date is invalid']);
    }

    $input = $request->only('date_of_birth');
    $input['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $input['date_of_birth']);

    try {
      $user->update($input);
      return response()->json([
        'success' => true,
        'message' => 'You have successfully updated date of birth.'
      ]);
    } catch(Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  /**
   * Update gender.
   *
   * @param  Request $request, 
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateGender(Request $request) {
    $user = User::find(Auth::user()->id);

    $input = $request->only('gender');
    
    $rules = [
      'gender' => 'required'
    ];

    $validator = Validator::make($input, $rules);

    if($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => 'Input is invalid'
      ]);
    }

    try {
      $user->update($input);
      return response()->json([
        'success' => true,
        'message' => 'You have successfully updated gender.'
      ]);
    } catch(Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ]);
    }
  }
}