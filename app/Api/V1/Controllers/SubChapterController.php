<?php

namespace App\Api\V1\Controllers;

use App\ChapterEnrollment;
use App\CourseEnrollment;
use App\Http\Controllers\Controller;
use App\SubChapter;
use App\SubChapterEnrollment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

  /**
   * API to finish the sub chapter 
   * 
   * @param int $sub_chapter_id as $id
   */
  public function finish(Request $request, $course_id, $chapter_id, $sub_chapter_id)
  {
    $course_enrollment = CourseEnrollment::where('user_id', Auth::user()->id)
      ->where('course_id', $course_id)->first();
    if ($course_enrollment == null) {
      return response()->json([
        'success' => false,
        'message' => "Error",
        'result' => null
      ], 500);
    }

    $chapter_enrollment = ChapterEnrollment::where('course_enrollment_id', $course_enrollment->id)
      ->where('chapter_id', $chapter_id)->first();

    if ($chapter_enrollment == null) {
      try {
        $data = array(
          'course_enrollment_id' => $course_enrollment->id,
          'chapter_id' => $chapter_id
        );
        $chapter_enrollment = ChapterEnrollment::create($data);
      } catch (Exception $e) {
        return response()->json([
          'success' => false,
          'message' => $e->getMessage(),
          'result' => null
        ], 500);
      }
    }
    $sub_chapter_enrollment = SubChapterEnrollment::where('chapter_enrollment_id', $chapter_enrollment->id)
      ->where('sub_chapter_id', $sub_chapter_id)->first();

    if ($sub_chapter_enrollment == null) {
      try {
        $data = array(
          'chapter_enrollment_id' => $chapter_enrollment->id,
          'sub_chapter_id' => $sub_chapter_id,
          'status' => '1'
        );
        $sub_chapter_enrollment = SubChapterEnrollment::create($data);

        return response()->json([
          'success' => true,
          'message' => 'Successfully finish sub chapter.',
          'result' => [
            $sub_chapter_enrollment->subChapter
          ]
        ], 200);
      } catch (Exception $e) {
        return response()->json([
          'success' => false,
          'message' => $e->getMessage(),
          'result' => null
        ], 500);
      }
    } else {
      return response()->json([
        'success' => false,
        'message' => 'You have finished this chapter.',
        'result' => null
      ], 403);
    }
  }
}
