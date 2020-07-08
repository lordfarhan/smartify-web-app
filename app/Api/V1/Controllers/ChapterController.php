<?php

namespace App\Api\V1\Controllers;

use App\Chapter;
use App\ChapterEnrollment;
use App\CourseEnrollment;
use App\Http\Controllers\Controller;
use App\SubChapterEnrollment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
      $chapters = Chapter::where('course_id', $course_id)->orderBy('chapter', 'asc')->get();

      if (count($chapters) > 0) {
        foreach ($chapters as $key => $chapter) {
          if ($chapter->attachment != null) {
            $chapter['attachment'] = url('storage/' . $chapter->attachment);
          }

          $course_enrollment = CourseEnrollment::where('user_id', Auth::user()->id)->where('course_id', $chapter->course->id)->first();
          if ($course_enrollment != null) {
            $chapter_enrollment = ChapterEnrollment::where('course_enrollment_id', $course_enrollment->id)->where('chapter_id', $chapter->id)->first();
            if ($chapter_enrollment != null) {
              $chapter['finished_count'] = SubChapterEnrollment::where('chapter_enrollment_id', $chapter_enrollment->id)->count();
            } else {
              $chapter['finished_count'] = 0;
            }
            if ($chapter->subChapters != null) {
              $chapter['sub_chapters'] = $chapter->subChapters->sortBy('sub_chapter');
            } else {
              $chapter['sub_chapters'] = array();
            }
          } else {
            $chapter['finished_count'] = 0;
            $chapter['sub_chapters'] = array();
          }
          array_except($chapter, 'course');
        }
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
