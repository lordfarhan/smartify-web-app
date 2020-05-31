<?php

namespace App\Api\V1\Controllers\Auth;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshController extends Controller
{
  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
    try {
      $token = JWTAuth::parseToken()->refresh();
      return response()->json([
        'success' => true,
        'message' => $token,
      ], 200);
    } catch (JWTException $e) {
      return response()->json([
        'success' => true,
        'message' => 'Failed to refresh, please try again.',
      ], 500);
    }
  }
}
