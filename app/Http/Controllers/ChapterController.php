<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ChapterController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:chapter-list|chapter-create|chapter-edit|chapter-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:chapter-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:chapter-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:chapter-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return redirect()->route('courses.index');
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
      'course_id' => 'required',
      'chapter' => 'required|numeric|min:1',
      'title' => 'required',
      'attachment_title' => 'required',
      'attachment' => 'mimes:pdf'
    );

    if (empty($request->file('attachment'))) {
      unset($validation['attachment_title']);
    }

    $this->validate($request, $validation);

    $course = Course::find($request->course_id);
    $input = $request->all();

    $subject = $course->subject->subject;
    $grade = $course->grade->grade;
    $author = $course->author->name;

    $courseName = preg_replace('/\s+/', '', $subject) . '_' . preg_replace('/\s+/', '', $grade) . '_' . preg_replace('/\s+/', '', $author);

    if (!empty($request->file('attachment'))) {
      $attachment = $request->file('attachment');
      $attachmentName = 'chapterAttachment' . Carbon::now()->format('YmdHis') . '_' . $courseName . '_' . $request->chapter . '.' . $attachment->getClientOriginalExtension();
      $attachment->move(storage_path('app/public/chapters/attachments/'), $attachmentName);
      $input['attachment'] = 'chapters/attachments/' . $attachmentName;
    } else {
      $input = array_except($input, array('attachment'));
    }

    Chapter::create($input);

    return back()->with('success', 'Chapter added successfully');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $validation = array(
      'course_id' => 'required',
      'chapter' => 'required|numeric|min:1',
      'title' => 'required',
      'attachment_title' => 'required',
      'attachment' => 'mimes:pdf'
    );

    if (empty($request->file('attachment'))) {
      unset($validation['attachment_title']);
    }

    $this->validate($request, $validation);

    $chapter = Chapter::find($request->id);
    $course = Course::find($request->course_id);
    $input = $request->all();

    $subject = $course->subject->subject;
    $grade = $course->grade->grade;
    $author = $course->author->name;

    $courseName = preg_replace('/\s+/', '', $subject) . '_' . preg_replace('/\s+/', '', $grade) . '_' . preg_replace('/\s+/', '', $author);

    if (!empty($request->file('attachment'))) {
      // Deleting existing attachment
      if (File::exists(storage_path('app/public/' . $chapter->attachment))) {
        File::delete(storage_path('app/public/' . $chapter->attachment));
      }
      $chapter->attachment = null;

      $attachment = $request->file('attachment');
      $attachmentName = 'chapterAttachment' . Carbon::now()->format('YmdHis') . '_' . $courseName . '_' . $request->chapter . '.' . $attachment->getClientOriginalExtension();
      $attachment->move(storage_path('app/public/chapters/attachments/'), $attachmentName);
      $input['attachment'] = 'chapters/attachments/' . $attachmentName;
    } else {
      $input = array_except($input, array('attachment'));
    }

    $chapter->update($input);

    return back()->with('success', 'Chapter updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $chapter = Chapter::find($request->id);
    if (File::exists(storage_path('app/public/' . $chapter->attachment))) {
      File::delete(storage_path('app/public/' . $chapter->attachment));
    }
    $chapter->delete();
    return back()->with('success', 'Chapter deleted successfully');
  }

  public function deleteFile(Request $request)
  {
    $chapter = Chapter::find($request->id);

    if (File::exists(storage_path('app/public/' . $chapter->attachment))) {
      File::delete(storage_path('app/public/' . $chapter->attachment));
    }
    $chapter->attachment = null;
    $chapter->attachment_title = null;
    $chapter->update();

    return back()->with('success', 'Deleted file successfully');
  }
}
