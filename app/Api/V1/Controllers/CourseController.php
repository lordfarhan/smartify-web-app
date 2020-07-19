<?php

namespace App\Api\V1\Controllers;

use App\ChapterEnrollment;
use App\Course;
use App\CourseEnrollment;
use App\CourseReview;
use App\Grade;
use App\Http\Controllers\Controller;
use App\Institution;
use App\SubChapter;
use App\SubChapterEnrollment;
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
      $public_courses = Course::where('type', '0')->where('status', '1')->where('institution_id', 1)->get();
      $institution_courses = Course::whereNotIn('id', Course::where('type', '0')->where('institution_id', 1)->pluck('id'))->where('status', '1')->whereIn('institution_id', Institution::whereIn('id', Auth::user()->institutions->pluck('institution_id'))->pluck('id'))->get();

      foreach ($public_courses as $index => $course) {
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
        if (in_array(Auth::user()->id, $course->enrollments->pluck('user_id')->toArray())) {
          $course['enrolled'] = 1;
          $subChaptersCount = SubChapter::whereIn('chapter_id', $course->chapters->pluck('id'))->count();

          $courseEnrollmentId = CourseEnrollment::where('user_id', Auth::user()->id)->where('course_id', $course->id)->pluck('id')->first();
          $chapterEnrollmentIds = ChapterEnrollment::where('course_enrollment_id', $courseEnrollmentId)->pluck('id');
          $subChapterFinishedCount = SubChapterEnrollment::whereIn('chapter_enrollment_id', $chapterEnrollmentIds)->count();
          $course['lesson_count'] = $subChaptersCount;
          $course['finished_count'] = $subChapterFinishedCount;
        } else {
          $course['enrolled'] = 0;
          $course['lesson_count'] = 0;
          $course['finished_count'] = 0;
        }
        array_except($course, 'chapters');
      }
      foreach ($institution_courses as $index => $course) {
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
        if (in_array(Auth::user()->id, $course->enrollments->pluck('user_id')->toArray())) {
          $course['enrolled'] = 1;
          $subChaptersCount = SubChapter::whereIn('chapter_id', $course->chapters->pluck('id'))->count();

          $courseEnrollmentId = CourseEnrollment::where('user_id', Auth::user()->id)->where('course_id', $course->id)->pluck('id')->first();
          $chapterEnrollmentIds = ChapterEnrollment::where('course_enrollment_id', $courseEnrollmentId)->pluck('id');
          $subChapterFinishedCount = SubChapterEnrollment::whereIn('chapter_enrollment_id', $chapterEnrollmentIds)->count();
          $course['lesson_count'] = $subChaptersCount;
          $course['finished_count'] = $subChapterFinishedCount;
        } else {
          $course['enrolled'] = 0;
          $course['lesson_count'] = 0;
          $course['finished_count'] = 0;
        }
        array_except($course, 'chapters');
      }

      $courses = array_merge($public_courses->toArray(), $institution_courses->toArray());

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
        if (in_array(Auth::user()->id, $course->enrollments->pluck('user_id')->toArray())) {
          $course['enrolled'] = 1;
          $subChaptersCount = SubChapter::whereIn('chapter_id', $course->chapters->pluck('id'))->count();

          $courseEnrollmentId = CourseEnrollment::where('user_id', Auth::user()->id)->where('course_id', $course->id)->pluck('id')->first();
          $chapterEnrollmentIds = ChapterEnrollment::where('course_enrollment_id', $courseEnrollmentId)->pluck('id');
          $subChapterFinishedCount = SubChapterEnrollment::whereIn('chapter_enrollment_id', $chapterEnrollmentIds)->count();
          $course['lesson_count'] = $subChaptersCount;
          $course['finished_count'] = $subChapterFinishedCount;
        } else {
          $course['enrolled'] = 0;
          $course['lesson_count'] = 0;
          $course['finished_count'] = 0;
        }
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
  public function enroll(Request $request)
  {
    $input = $request->only('id', 'enrollment_key');

    $course = Course::find($input['id']);
    if ($course->type == '1') {
      $rules = [
        'id' => 'required',
        'enrollment_key' => 'required',
      ];

      $validator = Validator::make($input, $rules);

      if ($validator->fails() || $input['enrollment_key'] != $course->enrollment_key) {
        return response()->json([
          'success' => false,
          'message' => 'Enrolmment key is wrong',
          'result' => null
        ], 402);
      }
    } else {
      $rules = [
        'id' => 'required',
      ];

      $validator = Validator::make($input, $rules);
    }

    try {
      $course_enrollment = CourseEnrollment::where('user_id', Auth::user()->id)->where('course_id', $input['id'])->pluck('id')->first();
      if ($course_enrollment == null) {
        CourseEnrollment::create(['user_id' => Auth::user()->id, 'course_id' => $input['id']]);

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
        if (in_array(Auth::user()->id, $course->enrollments->pluck('user_id')->toArray())) {
          $course['enrolled'] = 1;
        } else {
          $course['enrolled'] = 0;
        }

        return response()->json([
          'success' => true,
          'message' => 'Successfully enrolled.',
          'result' => [
            $course
          ]
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
      if (in_array(Auth::user()->id, $course->enrollments->pluck('user_id')->toArray())) {
        $course['enrolled'] = 1;
        $subChaptersCount = SubChapter::whereIn('chapter_id', $course->chapters->pluck('id'))->count();

        $courseEnrollmentId = CourseEnrollment::where('user_id', Auth::user()->id)->where('course_id', $course->id)->pluck('id')->first();
        $chapterEnrollmentIds = ChapterEnrollment::where('course_enrollment_id', $courseEnrollmentId)->pluck('id');
        $subChapterFinishedCount = SubChapterEnrollment::whereIn('chapter_enrollment_id', $chapterEnrollmentIds)->count();
        $course['lesson_count'] = $subChaptersCount;
        $course['finished_count'] = $subChapterFinishedCount;
      } else {
        $course['enrolled'] = 0;
        $course['lesson_count'] = 0;
        $course['finished_count'] = 0;
      }

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
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  public function members(Request $request, $id)
  {
    try {
      $course = Course::find($id);
      $enrollments = $course->enrollments;

      foreach ($enrollments as $enrollment) {
        $enrollment['name'] = $enrollment->user->name;
        $enrollment['email'] = $enrollment->user->email;
        $enrollment['phone'] = $enrollment->user->phone;
        $enrollment['image'] = url('storage/' . $enrollment->user->image);
        $enrollment['email_verified_at'] = $enrollment->user->email_verified_at;
        $enrollment['date_of_birth'] = $enrollment->user->date_of_birth;
        $enrollment['image'] = url('storage/' . $enrollment->user->image);
        $enrollment['village'] = $enrollment->user->village != null ? ucwords(strtolower($enrollment->user->village->name)) : null;
        $enrollment['district'] = $enrollment->user->village != null ? ucwords(strtolower($enrollment->user->village->district->name)) : null;
        $enrollment['regency'] = $enrollment->user->village != null ? ucwords(strtolower($enrollment->user->village->district->regency->name)) : null;
        $enrollment['province'] = $enrollment->user->village != null ? ucwords(strtolower($enrollment->user->village->district->regency->province->name)) : null;
        $enrollment['role'] = $enrollment->user->getRoleNames()[0];
        $enrollment['created_at'] = $enrollment->user->created_at;
        $enrollment['updated_at'] = $enrollment->user->updated_at;
        array_except($enrollment, 'user');
      }

      return response()->json([
        'success' => false,
        'message' => 'Successfully fetched members.',
        'result' => $enrollments
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }
}
