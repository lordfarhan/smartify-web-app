<?php

namespace App\Api\V1\Controllers;

use App\Chapter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ChapterController extends Controller
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
   * API to get chapter by course id.
   * 
   * @param Request $request
   * @param int $course_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getByCourseId(Request $request, $course_id)
  {
    try {
      $chapters = Chapter::where('course_id', $course_id)->get();

      foreach($chapters as $key => $chapter) {
        if($chapter->attachment != null) {
          $chapter['attachment'] = url('storage/'.$chapter->attachment);
        }
        $chapter['sub_chapters'] = $chapter->sub_chapters;
      }

      if (count($chapters) > 0) {
        return response()->json([
          'success' => true,
          'message' => 'Successfully retrieved chapters',
          'result' => $chapters
        ], 200);
      } else {
        return response()->json([
          'success' => true,
          'message' => 'No chapter found',
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
