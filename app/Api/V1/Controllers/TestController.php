<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Mark;
use App\Test;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
      $tests = Test::where('course_id', $course_id)->orderBy('order')->get();

      foreach ($tests as $key => $test) {
        $mark = Mark::where('user_id', Auth::user()->id)->where('test_id', $test->id)->first();
        if ($mark == null) {
          $test['attempted'] = '0';
          $test['mark'] = 0;
        } else {
          $test['attempted'] = '1';
          $test['mark'] = $mark->score;
        }
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

  /**
   * API to attempt the test
   */
  public function attempt(Request $request, $course_id, $test_id)
  {
    try {
      $existed = Mark::where('user_id', Auth::user()->id)->where('test_id', $test_id)->first();
      if ($existed == null) {
        $mark = Mark::create([
          'attempted' => '0',
          'user_id' => Auth::user()->id,
          'test_id' => $test_id,
          'score' => 0
        ]);
        return response()->json([
          'success' => true,
          'message' => 'Successfully attempted',
          'result' => [
            $mark
          ]
        ], 200);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Test has been attempted',
          'result' => null
        ], 403);
      }
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  /**
   * API to submit the test
   */
  public function submit(Request $request, $course_id, $test_id)
  {
    $input = $request->only('score');
    $rules = [
      'score' => 'required'
    ];
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
      $errorString = implode(",", $validator->messages()->all());
      return response()->json(['success' => false, 'message' => $errorString], 428);
    }

    try {
      $mark = Mark::where('user_id', Auth::user()->id)->where('test_id', $test_id)->first();
      if ($mark->attempted == '0') {
        $mark->attempted = '1';
        $mark->score = $request->score;
        $mark->update();
        return response()->json([
          'success' => true,
          'message' => 'Successfully marked',
          'result' => [
            $mark
          ]
        ], 200);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Test has been marked',
          'result' => null
        ], 403);
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
