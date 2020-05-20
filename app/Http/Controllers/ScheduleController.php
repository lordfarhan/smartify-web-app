<?php

namespace App\Http\Controllers;

use App\Course;
use App\Schedule;
use App\Services\CalendarService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Schedule::all();
        
        if(request()->ajax()) {
            if(Auth::user()->institution->id == 1){
                $data = Schedule::all();
            } else {
                $course_ids = Course::where('institution_id', Auth::user()->institution->id)->pluck('id');
                $data = Schedule::whereIn('course_id', $course_ids)->get();
            }
            return Response::json($data);
        }
        return view('schedules/index');
    }

    public function getScheduleData() {
        if(Auth::user()->institution->id == 1){
            $schedules = Schedule::all();
        } else {
            $course_ids = Course::where('institution_id', Auth::user()->institution->id)->pluck('id');
            $schedules = Schedule::whereIn('course_id', $course_ids)->get();
        }
        $scheduleData = array();
        foreach ($schedules as $schedule) {
            $e = array();
            $e['id'] = $schedule->id;
            $e['title'] = $schedule->course->subject->subject . " - " . $schedule->course->grade->grade . ' ' . $schedule->course->grade->getEducationalStage();
            $e['start'] = Carbon::parse($schedule->date)->format('Y-m-d')." ".Carbon::parse($schedule->start_time)->format('H:i:s');
            $e['end'] = Carbon::parse($schedule->date)->format('Y-m-d')." ".Carbon::parse($schedule->end_time)->format('H:i:s');
            // $e['url'] = route('courses.show', $schedule->course->id);
            $e['color'] = 'green';

            array_push($scheduleData, $e);
        }
        return json_encode($scheduleData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
