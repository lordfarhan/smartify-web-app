<?php

namespace App\Http\Controllers;

use App\Course;
use App\Grade;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
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
            $image = $request->file('image');
            $imageName = $courseName . '.' . 'png';
            Image::make($image->getRealPath())->encode('png')->fit(1200, 600)->save(public_path('storage/courses/images/') . $imageName);
            $input['image'] = 'courses/images/' . $imageName;
        } else {
            $input = array_except($input, array('image'));
        }

        if (!empty($request->file('attachment'))) {
            $attachment = $request->file('attachment');
            $attachmentName = $courseName . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(public_path('storage/courses/attachments/'), $attachmentName);
            $input['attachment'] = 'courses/attachments/' . $attachmentName;
        } else {
            $input = array_except($input, array('attachment'));
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
            if (File::exists(public_path('storage/' . $course->image))) {
                File::delete(public_path('storage/' . $course->image));
            }
            $course->image = null;

            $image = $request->file('image');
            $imageName = $courseName . '.' . 'png';
            Image::make($image->getRealPath())->encode('png')->fit(1200, 600)->save(public_path('storage/courses/images/') . $imageName);
            $input['image'] = 'courses/images/' . $imageName;
        }

        if (!empty($request->file('attachment'))) {

            // Deleting existing attachment
            if (File::exists(public_path('storage/' . $course->attachment))) {
                File::delete(public_path('storage/' . $course->attachment));
            }
            $course->attachment = null;

            $attachment = $request->file('attachment');
            $attachmentName = $courseName . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(public_path('storage/courses/attachments/'), $attachmentName);
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
        if (File::exists(public_path('storage/' . $course->image))) {
            File::delete(public_path('storage/' . $course->image));
        }

        if (File::exists(public_path('storage/' . $course->attachment))) {
            File::delete(public_path('storage/' . $course->attachment));
        }

        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }

    public function deleteFile($id, $type) {
        $course = Course::find($id);
        
        if($type == 'image') {
            if (File::exists(public_path('storage/' . $course->image))) {
                File::delete(public_path('storage/' . $course->image));
            }
            $course->image = null;
        } else if ($type == 'attachment') {
            if (File::exists(public_path('storage/' . $course->attachment))) {
                File::delete(public_path('storage/' . $course->attachment));
            }
            $course->attachment = null;
            $course->attachment_title = null;
        }
        $course->update();

        return back()->with('success', 'Deleted file successfully');
    }
}
