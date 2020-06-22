<?php

namespace App\Api\V1\Controllers;

use App\Chapter;
use App\ChapterEnrollment;
use App\Http\Controllers\Controller;
use App\SubChapterEnrollment;
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

      foreach ($chapters as $key => $chapter) {
        if ($chapter->attachment != null) {
          $chapter['attachment'] = url('storage/' . $chapter->attachment);
        }
        $chapter_enrollment = $chapter->chapterEnrollment;
        if ($chapter_enrollment != null) {
          $chapter['finished_count'] = SubChapterEnrollment::where('chapter_enrollment_id', $chapter->chapterEnrollment->id)->count();
        } else {
          $chapter['finished_count'] = 0;
        }
        $chapter['sub_chapters'] = $chapter->subChapters;
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
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }
}
