<?php

namespace App\Api\V1\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;

class ForgotPasswordController extends Controller
{
  /**
   * API Recover Password
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function recover(Request $request)
  {
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        $error_message = "Your email address was not found.";
        return response()->json(['success' => false, 'message' => $error_message], 401);
    }

    try {
        Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject('Your Password Reset Link');
        });

    } catch (\Exception $e) {
        //Return with error
        $error_message = $e->getMessage();
        return response()->json(['success' => false, 'message' => $error_message], 401);
    }

    return response()->json([
        'success' => true, 'message'=> 'A reset email has been sent! Please check your email.'
    ]);
  }
}
