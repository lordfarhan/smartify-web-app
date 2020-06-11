<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\SubChapter;
use Exception;
use Illuminate\Http\Request;

class SubChapterController extends Controller
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
   * API to get sub chapter by chapter id
   * 
   * @param Request $request
   * @param int $course_id
   * @param int $chapter_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getByChapterId(Request $request, $course_id, $chapter_id)
  {
    try {
      $sub_chapters = SubChapter::where('chapter_id', $chapter_id)->get();

      if (count($sub_chapters) > 0) {
        return response()->json([
          'success' => true,
          'message' => 'Successfully retrieved sub chapters',
          'result' => $sub_chapters
        ], 200);
      } else {
        return response()->json([
          'success' => true,
          'message' => 'No sub chapter found',
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
