<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Institution;
use App\InstitutionActivationCode;
use App\UserInstitution;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstitutionController extends Controller
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

  public function browse(Request $request)
  {
    try {
      $institution_ids = UserInstitution::where('user_id', Auth::user()->id)->pluck('institution_id');
      $institutions = Institution::whereNotIn('id', $institution_ids)->get();
      foreach ($institutions as $institution) {
        $institution['enrolled'] = 0;
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

  public function enroll(Request $request)
  {
    $input = $request->only('institution_id', 'code');
    $rules = [
      'institution_id' => 'required',
      'code' => 'required'
    ];

    $validator = Validator::make($input, $rules);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validator->messages(),
        'result' => null
      ]);
    }

    try {
      $activation_code = InstitutionActivationCode::where('institution_id', $input['institution_id'])->where('code', $input['code'])->first();
      if ($activation_code == null) {
        return response()->json([
          'success' => false,
          'message' => 'You are not allowed to join this institution.',
          'result' => null
        ], 403);
      } elseif ($activation_code->user_id == null) {
        UserInstitution::create([
          'user_id' => Auth::user()->id,
          'institution_id' => $input['institution_id']
        ]);
        return response()->json([
          'success' => true,
          'message' => 'Successfully enrolled to institution.',
          'result' => null
        ], 200);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Code had been used',
          'result' => null
        ], 428);
      }
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }
}
