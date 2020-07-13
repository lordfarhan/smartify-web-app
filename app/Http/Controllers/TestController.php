<?php

namespace App\Http\Controllers;

use App\Mark;
use App\Question;
use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:test-list|test-create|test-edit|test-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:test-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:test-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:test-delete', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
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
      'order' => 'required|numeric',
      'title' => 'required',
      'description' => 'required',
      'type' => 'required',
      'assign' => 'required',
      'duration' => 'required|numeric|min:1'
    );

    $this->validate($request, $validation);

    Test::create($request->all());

    return back()->with('success', 'Test added successfully');
  }

  public function show($course_id, $id)
  {
    $test = Test::find($id);
    $questions = Question::where('test_id', $id)->orderBy('order')->get();
    return view('tests.show', compact('course_id', 'test', 'questions'));
  }

  public function openSubmissions($course_id, $id)
  {
    $test = Test::find($id);
    $marks = Mark::where('test_id', $test->id)->get();
    return view('tests.submissions', compact('test', 'marks'));
  }

  public function deleteMark($course_id, $id, $mark_id)
  {
    Mark::find($mark_id)->delete();
    return back()->with('success', 'Successfully deleted mark');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Test  $test
   * @return \Illuminate\Http\Response
   */
  public function edit(Test $test)
  {
    //
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
      'order' => 'required|numeric',
      'title' => 'required',
      'description' => 'required',
      'type' => 'required',
      'assign' => 'required',
      'duration' => 'required|numeric|min:1'
    );

    $this->validate($request, $validation);

    $test = Test::find($request->id);

    $test->update($request->all());

    return back()->with('success', 'Test updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Test  $test
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $test = Test::find($request->id);
    $test->delete();
    return back()->with('success', 'Test deleted successfully');
  }
}
