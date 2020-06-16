<?php

namespace App\Api\V1\Controllers;

use App\Course;
use App\CourseEnrollment;
use App\CourseReview;
use App\Grade;
use App\Http\Controllers\Controller;
use App\Institution;
use App\Subject;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
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
   * API to get featured courses
   * 
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function featured(Request $request)
  {
    try {
      $courses = Course::where('type', '0')->where('institution_id', 1)->get();
      foreach ($courses as $index => $course) {
        if ($course->image != null) {
          $course['image'] = url('storage/' . $course->image);
        }
        if ($course->attachment != null) {
          $course['attachment'] = url('storage/' . $course->attachment);
        }
        // $course['created_at'] = Carbon::parse($course->created_at)->format('d/m/Y');
        // $course['updated_at'] = Carbon::parse($course->updated_at)->format('d/m/Y');
        $course['institution'] = Institution::find($course->institution_id)->name;
        $course['author'] = User::find($course->author_id)->name;
        $course['author_image'] = url('storage/' . User::find($course->author_id)->image);
        $course['subject'] = Subject::find($course->subject_id)->subject;
        $course['grade'] = Grade::find($course->grade_id)->grade . " " . Grade::find($course->grade_id)->getEducationalStage();
        $course['enrolled'] = in_array(Auth::user()->id, $course->enrollments->pluck('user_id')->toArray());
      }

      if (count($courses) > 0) {
        return response()->json([
          'success' => true,
          'message' => 'Successfully retrieved courses',
          'result' => $courses
        ], 200);
      } else {
        return response()->json([
          'success' => true,
          'message' => 'No course found',
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
   * API get courses, on success return course list
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function owned(Request $request)
  {
    try {
      $user = Auth::user();
      $course_ids = CourseEnrollment::where('user_id', $user->id)->pluck('course_id');
      $courses = Course::whereIn('id', $course_ids)->get();
      foreach ($courses as $index => $course) {
        if ($course->image != null) {
          $course['image'] = url('storage/' . $course->image);
        }
        if ($course->attachment != null) {
          $course['attachment'] = url('storage/' . $course->attachment);
        }
        // $course['created_at'] = Carbon::parse($course->created_at)->format('d/m/Y');
        // $course['updated_at'] = Carbon::parse($course->updated_at)->format('d/m/Y');
        $course['institution'] = Institution::find($course->institution_id)->name;
        $course['author'] = User::find($course->author_id)->name;
        $course['author_image'] = url('storage/' . User::find($course->author_id)->image);
        $course['subject'] = Subject::find($course->subject_id)->subject;
        $course['grade'] = Grade::find($course->grade_id)->grade . " " . Grade::find($course->grade_id)->getEducationalStage();
        $course['enrolled'] = in_array(Auth::user()->id, $course->enrollments->pluck('user_id')->toArray());
      }

      if (count($courses) > 0) {
        return response()->json([
          'success' => true,
          'message' => 'Successfully retrieved courses',
          'result' => $courses
        ], 200);
      } else {
        return response()->json([
          'success' => true,
          'message' => 'No course found',
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

  /**
   * API to enroll course, on success return true
   * 
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function enroll(Request $request, $id)
  {
    $course = Course::find($id);
    if ($course->type == '1') {
      $rules = [
        'enrollment_key' => 'required',
      ];

      $input = $request->only('enrollment_key');
      $validator = Validator::make($input, $rules);

      if ($validator->fails() || $input['enrollment_key'] != $course->enrollment_key) {
        return response()->json([
          'success' => false,
          'message' => 'Enrolmment key is wrong',
          'result' => null
        ], 402);
      }
    }

    try {
      $course_enrollment = CourseEnrollment::where('user_id', Auth::user()->id)->where('course_id', $id)->pluck('id')->first();
      if ($course_enrollment == null) {
        CourseEnrollment::create(['user_id' => Auth::user()->id, 'course_id' => $id]);
        return response()->json([
          'success' => true,
          'message' => 'Successfully enrolled.',
          'result' => null
        ], 200);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'The course has been enrolled before.',
          'result' => null
        ], 403);
      }
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Something error happened, please try again later.',
        'result' => null
      ], 500);
    }
  }

  /**
   * API to get course by id
   * 
   * @param Request $request
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getById(Request $request, $id)
  {
    try {
      $course = Course::find($id);
      if ($course->image != null) {
        $course['image'] = url('storage/' . $course->image);
      }
      if ($course->attachment != null) {
        $course['attachment'] = url('storage/' . $course->attachment);
      }
      // $course['created_at'] = Carbon::parse($course->created_at)->format('d/m/Y');
      // $course['updated_at'] = Carbon::parse($course->updated_at)->format('d/m/Y');
      $course['institution'] = Institution::find($course->institution_id)->name;
      $course['author'] = User::find($course->author_id)->name;
      $course['author_image'] = url('storage/' . User::find($course->author_id)->image);
      $course['subject'] = Subject::find($course->subject_id)->subject;
      $course['grade'] = Grade::find($course->grade_id)->grade . " " . Grade::find($course->grade_id)->getEducationalStage();      
      $course['enrolled'] = in_array(Auth::user()->id, $course->enrollments->pluck('user_id')->toArray());

      if ($course != null) {
        return response()->json([
          'success' => true,
          'message' => 'Successfully retrieved courses',
          'result' => [
            $course
          ]
        ], 200);
      } else {
        return response()->json([
          'success' => true,
          'message' => 'Course not found',
          'result' => null
        ], 404);
      }
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => "Process error, please try again later.".$e->getMessage(),
        'result' => null
      ], 500);
    }
  }
}
