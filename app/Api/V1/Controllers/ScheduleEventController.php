<?php

namespace App\Api\V1\Controllers;

use App\ChapterEnrollment;
use App\Course;
use App\CourseEnrollment;
use App\Grade;
use App\Http\Controllers\Controller;
use App\Institution;
use App\Schedule;
use App\SubChapter;
use App\SubChapterEnrollment;
use App\Subject;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleEventController extends Controller
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

  public function get(Request $request)
  {
    try {
      $user = Auth::user();
      $course_ids = CourseEnrollment::where('user_id', $user->id)->pluck('course_id');
      $courses = Course::whereIn('id', $course_ids)->get();
      $schedule_events = array();
      foreach ($courses as $index => $course) {
        $events = Schedule::where('course_id', $course->id)->get();
        foreach ($events as $index => $event) {
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
          array_except($course, 'enrollments');
          array_except($course, 'chapters');
          $event['course'] = $course;
          array_push($schedule_events, $event);
        }
      }

      return response()->json([
        'success' => true,
        'message' => 'Successfully retrieved schedule events',
        'result' => $schedule_events
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
