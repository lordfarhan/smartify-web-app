<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Test;
use Exception;
use Illuminate\Http\Request;

class TestController extends Controller
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
   * API to get test by course id
   */
  public function getByCourseId(Request $request, $course_id)
  {
    try {
      $tests = Test::where('course_id', $course_id)->get();

      foreach($tests as $key => $test) {
        // if($test->attachment != null) {
        //   $test['attachment'] = url('storage/'.$test->attachment);
        // }
      }

      if (count($tests) > 0) {
        return response()->json([
          'success' => true,
          'message' => 'Successfully retrieved tests',
          'result' => $tests
        ], 200);
      } else {
        return response()->json([
          'success' => true,
          'message' => 'No test found',
          'result' => null
        ], 204);
      }
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => "Process error, please try again later.",
        'result' => null
      ], 500);
    }
  }
}
