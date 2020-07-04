<?php

namespace App\Http\Controllers;

use App\Course;
use App\SubChapter;
use Illuminate\Http\Request;

class SubChapterController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:sub-chapter-list|sub-chapter-create|sub-chapter-edit|sub-chapter-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:sub-chapter-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:sub-chapter-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:sub-chapter-delete', ['only' => ['destroy']]);
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
  public function update(Request $request)
  {
    $this->validate($request, [
      'chapter_id' => 'required',
      'sub_chapter' => 'required',
      'title' => 'required'
    ]);

    $sub_chapter = SubChapter::find($request->id);
    $sub_chapter->update($request->all());

    return back()->with('success', 'Sub chapter updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\SubChapter  $subChapter
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $sub_chapter = SubChapter::find($request->id);
    $sub_chapter->delete();
    return back()->with('success', 'Sub chapter deleted successfully');
  }
}
