<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller 
{
  /**
   * API Verify User
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function verify($verification_code)
  {
    $check = DB::table('user_verifications')->where('token', $verification_code)->first();

    if(!is_null($check)){
      $user = User::find($check->user_id);

      if(!$user->email_verified_at == null){
        return response()->json([
          'success'=> true,
          'message'=> 'Account already verified.'
        ]);
      }

      $user->update(['email_verified_at' => Carbon::now()]);
      DB::table('user_verifications')->where('token',$verification_code)->delete();

      return response()->json([
        'success' => true,
        'message' => 'You have successfully verified your email address.'
      ]);
    }
    return response()->json(['success'=> false, 'message' => "Verification code is invalid."]);
  }
}