<?php

namespace App\Api\V1\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class LogoutController extends Controller {
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
   * Log out
   * Invalidate the token, so user cannot use it anymore
   * They have to relogin to get a new token
   *
   * @param Request $request
   */
  public function logout(Request $request) {
    // $this->validate($request, ['token' => 'required']);
    
    try {
        JWTAuth::invalidate($request->input('token'));
        return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
    } catch (JWTException $e) {
        // something went wrong whilst attempting to encode the token
        return response()->json(['success' => false, 'message' => 'Failed to logout, please try again.'], 500);
    }
  }
}