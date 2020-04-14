<?php

namespace App\Http\Controllers;

use App\Course;
use App\SubChapter;
use Illuminate\Http\Request;

class SubChapterController extends Controller
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
        $this->validate($request, [
            'chapter_id' => 'required',
            'sub_chapter' => 'required',
            'title' => 'required'
        ]);

        SubChapter::create($request->all());

        return back()->with('success', 'Sub chapter added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubChapter  $subChapter
     * @return \Illuminate\Http\Response
     */
    public function show(SubChapter $subChapter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubChapter  $subChapter
     * @return \Illuminate\Http\Response
     */
    public function edit(SubChapter $subChapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubChapter  $subChapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubChapter $subChapter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubChapter  $subChapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubChapter $subChapter)
    {
        //
    }
}
