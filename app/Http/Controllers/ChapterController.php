<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Course;
use Illuminate\Http\Request;

class ChapterController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
            'chapter' => 'required',
            'title' => 'required'
        ]);

        Chapter::create($request->all());

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
        $chapter = Chapter::find($request->id);

        $this->validate($request, [
            'course_id' => 'required',
            'chapter' => 'required',
            'title' => 'required'
        ]);

        $chapter->course_id = $request->course_id;
        $chapter->chapter = $request->chapter;
        $chapter->title = $request->title;

        $chapter->save();

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
        $chapter->delete();
        return back()->with('success', 'Chapter deleted successfully');
    }
}
