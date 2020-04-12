<?php

namespace App\Http\Controllers;

use App\Course;
use App\Grade;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
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
        $courses = Course::orderBy('id', 'desc')->paginate(5);
        return view('courses.index', compact('courses'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = User::pluck('name', 'id')->all();
        $subjects = Subject::pluck('subject', 'id')->all();
        $grades = Grade::pluck('grade', 'id')->all();
        return view('courses.create', ['authors' => $authors, 'subjects' => $subjects, 'grades' => $grades]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'author_id' => 'required',
            'subject_id' => 'required',
            'grade_id' => 'required',
            'status' => 'required',
        ]);

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $courseName = request('author_id') . '-' . request('subject_id') . '-' . request('grade_id');
            $imageName = $courseName . '.' . $image->getClientOriginalExtension();
            Image::make($image->getRealPath())->fit(1200, 600)->save(public_path('storage/courses/') . $imageName);
            $input = $request->all();
            $input['image'] = 'courses/' . $imageName;
        } else {
            $input = $request->all();
        }

        Course::create($input);
        
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
        $authors = User::pluck('name', 'id')->all();
        $subjects = Subject::pluck('subject', 'id')->all();
        $grades = Grade::pluck('grade', 'id')->all();
        return view('courses.edit', ['course' => $course, 'authors' => $authors, 'subjects' => $subjects, 'grades' => $grades]);
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
        $this->validate($request, [
            'author_id' => 'required',
            'subject_id' => 'required',
            'grade_id' => 'required',
            'status' => 'required',
        ]);

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $courseName = request('author_id') . '-' . request('subject_id') . '-' . request('grade_id');
            $imageName = $courseName . '.' . $image->getClientOriginalExtension();
            Image::make($image->getRealPath())->fit(1200, 600)->save(public_path('storage/courses/') . $imageName);
            $input = $request->all();
            $input['image'] = 'courses/' . $imageName;
        } else {
            $input = $request->all();
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
        $course->delete();
        
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }
}
