<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Course;
use App\Schedule;
use App\User;
use App\UserInstitution;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AttendanceController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:attendance-list|attendance-create|attendance-edit|attendance-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:attendance-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:attendance-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:attendance-delete', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return redirect()->route('schedules.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($course_id, $schedule_id)
  {
    $schedule = Schedule::find($schedule_id);
    if (count($schedule->attendances) == 0) {
      if (Auth::user()->hasRole('Master')) {
        $signers = User::role(['Master', 'senior teacher', 'teacher'])->pluck('name', 'id')->all();
      } else {
        $user_ids = $schedule->course->author_id;
        $signers = User::whereIn('id', $user_ids)->role(['senior teacher', 'teacher'])->pluck('name', 'id');
      }
      return view('attendances.create', compact('schedule', 'signers'));
    } else {
      $course_id = $schedule->course->id;
      return redirect("courses/$course_id/schedules/$id/attendances");
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validation = [
      'schedule_id' => 'required',
    ];

    foreach ($request->input('student') as $index => $student) {
      $validation["student.{$index}"] = 'required';
    }

    $this->validate($request, $validation);

    $students = $request->input('student');
    $status = $request->input('status');

    foreach ($students as $index => $student) {
      $attendance = new Attendance();
      $attendance->user_id = $student;
      $attendance->schedule_id = $request->schedule_id;
      $attendance->status = (empty($status[$index]) ? '0' : '1');
      $attendance->save();
    }

    $schedule = Schedule::find($request->schedule_id);

    return redirect()->route('courses.show', $schedule->course->id);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Attendance  $attendance
   * @return \Illuminate\Http\Response
   */
  public function show($course_id, $schedule_id)
  {
    $schedule = Schedule::find($schedule_id);
    return view('attendances.show', compact('schedule'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Attendance  $attendance
   * @return \Illuminate\Http\Response
   */
  public function edit($course_id, $schedule_id)
  {
    $schedule = Schedule::find($schedule_id);
    return view('attendances.edit', compact('schedule'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Attendance  $attendance
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $validation = [
      'schedule_id' => 'required',
    ];

    foreach ($request->input('student') as $index => $student) {
      $validation["student.{$index}"] = 'required';
    }

    $this->validate($request, $validation);

    $students = $request->input('student');
    $status = $request->input('status');

    foreach ($students as $index => $student) {
      $oldAttendance = Attendance::where('schedule_id', $request->schedule_id)->where('user_id', $student)->first();
      if($oldAttendance == null) {
        $attendance = new Attendance();
        $attendance->user_id = $student;
        $attendance->schedule_id = $request->schedule_id;
        $attendance->status = (empty($status[$index]) ? '0' : '1');
        $attendance->save();
      } else {
        $oldAttendance->status = (empty($status[$index]) ? '0' : '1');
        $oldAttendance->update();
      }
    }

    $schedule = Schedule::find($request->schedule_id);

    return redirect()->route('courses.show', $schedule->course->id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Attendance  $attendance
   * @return \Illuminate\Http\Response
   */
  public function destroy(Attendance $attendance)
  {
    //
  }
}
