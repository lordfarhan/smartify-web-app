<?php

namespace App\Http\Controllers;

use App\Course;
use App\Grade;
use App\Institution;
use App\Schedule;
use App\Subject;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grades = Grade::all();
        if(Auth::user()->institution->id != 1) {
            $courses = Course::where('institution_id', Auth::user()->institution->id)->orderBy('id', 'desc')->paginate(5);
        } else {
            $courses = Course::orderBy('id', 'desc')->paginate(5);
        }
        return view('courses.index', compact('grades', 'courses'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->institution->id != 1) {
            $institutions = Institution::where('id', Auth::user()->institution->id)->pluck('name', 'id');
            $authors = User::where('institution_id', Auth::user()->institution->id)->role(['senior teacher', 'teacher'])->pluck('name', 'id')->all();
        } else {
            $institutions = Institution::pluck('name', 'id')->all();
            $authors = User::role(['master', 'senior teacher', 'teacher'])->pluck('name', 'id')->all();
        }
        $subjects = Subject::pluck('subject', 'id')->all();
        $grades = Grade::pluck('grade', 'id')->all();
        $days = array('0' => 'Ahad', '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabo', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu');
        return view('courses.create', ['institutions' => $institutions, 'authors' => $authors, 'subjects' => $subjects, 'grades' => $grades, 'days' => $days]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = array(
            'author_id' => 'required',
            'subject_id' => 'required',
            'grade_id' => 'required',
            'type' => 'required',
            'enrollment_key' => 'required|max:12',
            'status' => 'required',
            'image'=>'mimes:jpg,png,jpeg,JPG',
            'attachment_title' => 'required',
            'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx'
        );

        // Schedule insertion
        $dates = $request->input('date');
        $start_times = $request->input('start_time');
        $end_times = $request->input('end_time');

        if($dates[0] != null || $start_times[0] != null || $end_times[0] != null) {
            foreach($dates as $index => $date) {
                $validation["date.{$index}"] = 'required';
                $validation["start_time.{$index}"] = 'required';
                $validation["end_time.{$index}"] = 'required';
            }
        }
        
        if($request->type == '0') {
            unset($validation['enrollment_key']);
        }
        if(empty($request->file('attachment'))) {
            unset($validation['attachment_title']);
        }
        $this->validate($request, $validation);

        $input = $request->all();

        $author = User::where('id', request('author_id'))->value('name');
        $subject = Subject::where('id', request('subject_id'))->value('subject');
        $grade = Grade::where('id', request('grade_id'))->value('grade');

        $courseName = preg_replace('/\s+/', '', $subject) . '-' . preg_replace('/\s+/', '', $grade) . '-' . preg_replace('/\s+/', '', $author);

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $imageName = $courseName . '.' . 'png';
            Image::make($image->getRealPath())->encode('png')->fit(1200, 600)->save(storage_path('app/public/courses/images/') . $imageName);
            $input['image'] = 'courses/images/' . $imageName;
        } else {
            $input = array_except($input, array('image'));
        }

        if (!empty($request->file('attachment'))) {
            $attachment = $request->file('attachment');
            $attachmentName = $courseName . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(storage_path('app/public/courses/attachments/'), $attachmentName);
            $input['attachment'] = 'courses/attachments/' . $attachmentName;
        } else {
            $input = array_except($input, array('attachment'));
        }

        $course = Course::create($input);

        if($dates[0] != null || $start_times[0] != null || $end_times[0] != null) {
            foreach($dates as $index => $date) {
                $schedule = new Schedule();
                $schedule->course_id = $course->id;
                $schedule->date = Carbon::parse($date);
                $schedule->start_time = Carbon::createFromTimeString($start_times[$index].":00", 'Asia/Jakarta');
                $schedule->end_time = Carbon::createFromTimeString($end_times[$index].":00", 'Asia/Jakarta');
                $schedule->save();
            }
        }
        
        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        if(Auth::user()->institution->id != 1) {
            $institutions = Institution::where('id', Auth::user()->institution->id)->pluck('name', 'id');
            $authors = User::where('institution_id', Auth::user()->institution->id)->role(['senior teacher', 'teacher'])->pluck('name', 'id')->all();
        } else {
            $institutions = Institution::pluck('name', 'id')->all();
            $authors = User::role(['master', 'senior teacher', 'teacher'])->pluck('name', 'id')->all();
        }
        $subjects = Subject::pluck('subject', 'id')->all();
        $grades = Grade::pluck('grade', 'id')->all();
        return view('courses.edit', ['institutions' => $institutions, 'course' => $course, 'authors' => $authors, 'subjects' => $subjects, 'grades' => $grades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validation = array(
            'author_id' => 'required',
            'subject_id' => 'required',
            'grade_id' => 'required',
            'type' => 'required',
            'enrollment_key' => 'required|max:12',
            'status' => 'required',
            'image'=>'mimes:jpg,png,jpeg,JPG',
            'attachment_title' => 'required',
            'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx'
        );

        if($request->type == '0') {
            unset($validation['enrollment_key']);
        }
        if (empty($request->file('attachment'))) {
            unset($validation['attachment_title']);
        }
        $this->validate($request, $validation);

        $input = $request->all();
        
        $author = User::where('id', request('author_id'))->value('name');
        $subject = Subject::where('id', request('subject_id'))->value('subject');
        $grade = Grade::where('id', request('grade_id'))->value('grade');

        $courseName = preg_replace('/\s+/', '', $subject) . '-' . preg_replace('/\s+/', '', $grade) . '-' . preg_replace('/\s+/', '', $author);

        if (!empty($request->file('image'))) {

            // Deleting existing image
            if (File::exists(storage_path('app/public/' . $course->image))) {
                File::delete(storage_path('app/public/' . $course->image));
            }
            $course->image = null;

            $image = $request->file('image');
            $imageName = $courseName . '.' . 'png';
            Image::make($image->getRealPath())->encode('png')->fit(1200, 600)->save(storage_path('app/public/courses/images/') . $imageName);
            $input['image'] = 'courses/images/' . $imageName;
        }

        if (!empty($request->file('attachment'))) {

            // Deleting existing attachment
            if (File::exists(storage_path('app/public/' . $course->attachment))) {
                File::delete(storage_path('app/public/' . $course->attachment));
            }
            $course->attachment = null;

            $attachment = $request->file('attachment');
            $attachmentName = $courseName . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(storage_path('app/public/courses/attachments/'), $attachmentName);
            $input['attachment'] = 'courses/attachments/' . $attachmentName;
        }

        $course->update($input);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if (File::exists(storage_path('app/public/' . $course->image))) {
            File::delete(storage_path('app/public/' . $course->image));
        }

        if (File::exists(storage_path('app/public/' . $course->attachment))) {
            File::delete(storage_path('app/public/' . $course->attachment));
        }

        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }

    public function deleteFile($id, $type) {
        $course = Course::find($id);
        
        if($type == 'image') {
            if (File::exists(storage_path('app/public/' . $course->image))) {
                File::delete(storage_path('app/public/' . $course->image));
            }
            $course->image = null;
        } else if ($type == 'attachment') {
            if (File::exists(storage_path('app/public/' . $course->attachment))) {
                File::delete(storage_path('app/public/' . $course->attachment));
            }
            $course->attachment = null;
            $course->attachment_title = null;
        }
        $course->update();

        return back()->with('success', 'Deleted file successfully');
    }

    public function editSchedule($id) {
        $course = Course::find($id);
        return view('courses.edit-schedule', ['course' => $course]);
    }

    public function updateSchedule(Request $request) {
        $validation = array();
        // Schedule insertion
        $dates = $request->input('date');
        $start_times = $request->input('start_time');
        $end_times = $request->input('end_time');

        if($dates[0] != null || $start_times[0] != null || $end_times[0] != null) {
            foreach($dates as $index => $date) {
                $validation["date.{$index}"] = 'required';
                $validation["start_time.{$index}"] = 'required';
                $validation["end_time.{$index}"] = 'required';
            }
        }

        $this->validate($request, $validation);

        Schedule::where('course_id', $request->id)->delete();

        if($dates[0] != null || $start_times[0] != null || $end_times[0] != null) {
            foreach($dates as $index => $date) {
                $schedule = new Schedule();
                $schedule->course_id = $request->id;
                $schedule->date = Carbon::parse($date);
                $schedule->start_time = Carbon::createFromTimeString($start_times[$index].":00", 'Asia/Jakarta');
                $schedule->end_time = Carbon::createFromTimeString($end_times[$index].":00", 'Asia/Jakarta');
                $schedule->save();
            }
        }

        return redirect()->route('courses.index')->with('success', 'Course schedule updated successfully');
    }
}
