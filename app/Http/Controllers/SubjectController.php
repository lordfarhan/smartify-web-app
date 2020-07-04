<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:subject-list|subject-create|subject-edit|subject-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:subject-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:subject-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:subject-delete', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $subjects = Subject::orderBy('subject', 'desc')->get();

    return view('subjects.index', compact('subjects'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('subjects.create');
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
      'subject' => 'required|unique:subjects,subject'
    ]);

    Subject::create($request->all());

    return redirect()->route('subjects.index')->with('success', 'Subject created successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Subject  $subject
   * @return \Illuminate\Http\Response
   */
  public function show(Subject $subject)
  {
    return view('subjects.show', compact('subject'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Subject  $subject
   * @return \Illuminate\Http\Response
   */
  public function edit(Subject $subject)
  {
    return view('subjects.edit', compact('subject'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Subject  $subject
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Subject $subject)
  {
    $this->validate($request, [
      'subject' => 'required|unique:subjects,subject'
    ]);

    $subject->update($request->all());

    return redirect()->route('subjects.index')->with('success', 'Subject updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Subject  $subject
   * @return \Illuminate\Http\Response
   */
  public function destroy(Subject $subject)
  {
    $subject->delete();

    return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully');
  }
}
