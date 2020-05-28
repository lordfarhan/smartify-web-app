<?php

namespace App\Api\V1\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller {
  /**
   * API Login, on success return JWT Auth token
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');
    
    $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    $validator = Validator::make($credentials, $rules);
    if($validator->fails()) {
        return response()->json(['success'=> false, 'message'=> $validator->messages()], 401);
    }
    
    try {
        // attempt to verify the credentials and create a token for the user
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['success' => false, 'message' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 404);
        }
        //if you reached here then user has been authenticated
        if (empty(auth()->user()->email_verified_at))
        {
            return response()->json(['success' => false, 'message' => 'Your have not verified your email.'], 401);
        }
    } catch (JWTException $e) {
        // something went wrong whilst attempting to encode the token
        return response()->json(['success' => false, 'message' => 'Failed to login, please try again.'], 500);
    }

    // all good so return the token
    return response()->json(['success' => true, 'message' => $token ], 200);
  }
}