<?php

namespace App\Api\V1;

use App\Http\Controllers\Controller;
use App\Institution;
use App\Mail\VerifyEmailAddress;
use Illuminate\Http\Request;

use App\User;
use App\UserInstitution;
use Carbon\Carbon;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
// use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class AuthController extends Controller
{

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

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {
      $this->validate($request, ['token' => 'required']);
      
      try {
          JWTAuth::invalidate($request->input('token'));
          return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
      } catch (JWTException $e) {
          // something went wrong whilst attempting to encode the token
          return response()->json(['success' => false, 'message' => 'Failed to logout, please try again.'], 500);
      }
    }

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
          return response()->json(['success'=> false, 'message'=> $validator->messages()]);
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
        
        return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.']);
      }
      catch (Exception $e){
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
      }
      
    }

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

    /**
     * API Recover Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request) {
      $this->validate($request, ['token' => 'required']);

      $user = Auth::user()->toArray();
      $user['image'] = url('storage/'.Auth::user()->image);
      $user['village'] = Auth::user()->village != null ? ucwords(strtolower(Auth::user()->village->first()->name)) : null;
      $user['district'] = Auth::user()->village != null ? ucwords(strtolower(Auth::user()->village->first()->district->name)) : null;
      $user['regency'] = Auth::user()->village != null ? ucwords(strtolower(Auth::user()->village->first()->district->regency->name)) : null;
      $user['province'] = Auth::user()->village != null ? ucwords(strtolower(Auth::user()->village->first()->district->regency->province->name)) : null;
      $user['institutions'] = Institution::whereIn('id', Auth::user()->institutions->pluck('institution_id'))->pluck('name');
      
      try {
        return response()->json([
          'success' => true,
          'message' => 'Successfully fetched user data',
          'user' => $user
        ]);
      } catch(Exception $e) {
        return response()->json([
          'success' => false,
          'message' => $e->getMessage(),
          'user' => null
        ]);
      }
    }
}
