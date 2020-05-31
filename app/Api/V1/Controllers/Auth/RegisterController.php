<?php

namespace App\Api\V1\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmailAddress;
use App\User;
use App\UserInstitution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
  /**
   * API Register
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function register(Request $request)
  {
    $credentials = $request->only('name', 'email', 'phone', 'password');
    
    $rules = [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'phone' => 'required|unique:users,phone',
      'password' => 'required'
    ];

    $validator = Validator::make($credentials, $rules);
    if($validator->fails()) {
      $errorString = implode(", ",$validator->messages()->all());
      return response()->json(['success'=> false, 'message'=> $errorString], 401);
    }

    $name = $request->name;
    $email = $request->email;
    $password = $request->password;

    $verification_code = str_random(100); //Generate verification code

    try{
      $data = [
        'level' => 'success',
        'introLines' => [
          'Please click the button below to verify your email address.'
        ],
        'actionText' => 'Verify Email Address',
        'actionUrl' => url("api/verify/$verification_code"),
        'outroLines' => [
          'If you did not create an account, no further action is required.'
        ],
      ];
      Mail::to($email)->send(new VerifyEmailAddress($data));

      $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
      DB::table('user_verifications')->insert(['user_id' => $user->id, 'token' => $verification_code]);

      UserInstitution::create(['user_id' => $user->id, 'institution_id' => 1]);
      $user->assignRole('student');
      
      return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.'], 200);
    }
    catch (Exception $e){
      return response()->json(['success' => false, 'message' => 'Failed to register, please try again.'], 500);
    }
    
  }
}