<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Question;
use Exception;

class QuestionController extends Controller
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
   * API for fetching questions
   * 
   * @param $test_id
   */
  public function getByTestId($id, $test_id)
  {
    try {
      $questions = Question::where('test_id', $test_id)->orderBy('order')->get();

      // foreach ($questions as $question) {
      //   $question['incorrect_answers'] = explode('; ', $question['incorrect_answers']);
      // }

      return response()->json([
        'success' => true,
        'message' => 'Successfully fetched questions',
        'result' => $questions
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ]);
    }
  }
}
