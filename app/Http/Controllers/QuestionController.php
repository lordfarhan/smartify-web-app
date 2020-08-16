<?php

namespace App\Http\Controllers;

use App\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class QuestionController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:question-list|question-create|question-edit|question-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:question-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:question-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:question-delete', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return route('courses.index');
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
    $validation = [
      'test_id' => 'required',
      'order' => 'required|numeric',
      'type' => 'required',
      'question' => 'required',
      'question_image' => 'mimes:jpg,png,jpeg,JPG',
      'question_audio' => 'mimes:mp3,wav',
      'correct_answer' => 'required',
      'incorrect_answer_1' => 'required',
      'incorrect_answer_2' => 'required',
      'incorrect_answer_3' => 'required',
    ];

    $testName = $request->test_id . '_' . $request->order . '_' . Str::random();
    $input = $request->all();

    if ($request->type == 'boolean') {
      unset($validation['incorrect_answer_2']);
      unset($request['incorrect_answer_2']);
      unset($validation['incorrect_answer_3']);
      unset($request['incorrect_answer_3']);
      unset($validation['incorrect_answer_4']);
      unset($request['incorrect_answer_4']);
      $input['incorrect_answers'] = "$request->incorrect_answer_1";
    } else {
      if($request->incorrect_answer_4 != null) {
        $input['incorrect_answers'] = "$request->incorrect_answer_1; $request->incorrect_answer_2; $request->incorrect_answer_3; $request->incorrect_answer_4";
      } else {
        $input['incorrect_answers'] = "$request->incorrect_answer_1; $request->incorrect_answer_2; $request->incorrect_answer_3";
      }
    }

    $this->validate($request, $validation);

    if (!empty($request->file('question_image'))) {
      $image = $request->file('question_image');
      $imageName = 'testQuestionImage' . Carbon::now()->format('YmdHis') . '_' . $testName . 'png';
      Image::make($image->getRealPath())->encode('png')->resize(400, null, function ($constraint) {
        $constraint->aspectRatio();
      })->save(storage_path('app/public/tests/questions/images/') . $imageName);
      $input['question_image'] = 'tests/questions/images/' . $imageName;
    } else {
      $input = array_except($input, array('question_image'));
    }

    if (!empty($request->file('question_audio'))) {
      $audio = $request->file('question_audio');
      $audioName = 'testQuestionAudio' . Carbon::now()->format('YmdHis') . '_' . $testName . $audio->getClientOriginalExtension();
      $audio->move(storage_path('app/public/tests/questions/audios/'), $audioName);
      $input['question_audio'] = 'tests/questions/audios/' . $audioName;
    } else {
      $input = array_except($input, array('question_audio'));
    }

    Question::create($input);

    return back()->with('success', 'Question added successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Question  $question
   * @return \Illuminate\Http\Response
   */
  public function show(Question $question)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Question  $question
   * @return \Illuminate\Http\Response
   */
  public function edit(Question $question)
  {
    return view('questions.edit', compact('question'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Question  $question
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Question $question)
  {
    $validation = [
      'test_id' => 'required',
      'order' => 'required|numeric',
      'type' => 'required',
      'question' => 'required',
      'question_image' => 'mimes:jpg,png,jpeg,JPG',
      'question_audio' => 'mimes:mp3,wav',
      'correct_answer' => 'required',
      'incorrect_answer_1' => 'required',
      'incorrect_answer_2' => 'required',
      'incorrect_answer_3' => 'required',
    ];

    $testName = $request->test_id . '_' . $request->order . '_' . Str::random();
    $input = $request->all();

    if ($request->type == '1') {
      unset($validation['incorrect_answer_2']);
      unset($request['incorrect_answer_2']);
      unset($validation['incorrect_answer_3']);
      unset($request['incorrect_answer_3']);
      unset($validation['incorrect_answer_4']);
      unset($request['incorrect_answer_4']);
      $input['incorrect_answers'] = "$request->incorrect_answer_1";
    } else {
      if($request->incorrect_answer_4 != null) {
        $input['incorrect_answers'] = "$request->incorrect_answer_1; $request->incorrect_answer_2; $request->incorrect_answer_3; $request->incorrect_answer_4";
      } else {
        $input['incorrect_answers'] = "$request->incorrect_answer_1; $request->incorrect_answer_2; $request->incorrect_answer_3";
      }
    }

    $this->validate($request, $validation);

    if (!empty($request->file('question_image'))) {

      // Deleting existing question image
      if (File::exists(storage_path('app/public/' . $question->question_image))) {
        File::delete(storage_path('app/public/' . $question->question_image));
      }
      $question->question_image = null;

      $image = $request->file('question_image');
      $imageName = 'testQuestionImage' . Carbon::now()->format('YmdHis') . '_' . $testName . 'png';
      Image::make($image->getRealPath())->encode('png')->resize(400, null, function ($constraint) {
        $constraint->aspectRatio();
      })->save(storage_path('app/public/tests/questions/images/') . $imageName);
      $input['question_image'] = 'tests/questions/images/' . $imageName;
    } else {
      unset($input['question_image']);
    }

    if (!empty($request->file('question_audio'))) {

      // Deleting existing question audio
      if (File::exists(storage_path('app/public/' . $question->question_audio))) {
        File::delete(storage_path('app/public/' . $question->question_audio));
      }

      $question->question_audio = null;
      $audio = $request->file('question_audio');
      $audioName = 'testQuestionAudio' . Carbon::now()->format('YmdHis') . '_' . $testName . $audio->getClientOriginalExtension();
      $audio->move(storage_path('app/public/tests/questions/audios/'), $audioName);
      $input['question_audio'] = 'tests/questions/audios/' . $audioName;
    } else {
      unset($input['question_audio']);
    }

    $question->update($input);

    return redirect('/courses/' . $question->test->course->id . '/tests/' . $question->test->id)->with('success', 'Question updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $question = Question::find($request->id);
    if (File::exists(storage_path('app/public/' . $question->question_image))) {
      File::delete(storage_path('app/public/' . $question->question_image));
    }
    if (File::exists(storage_path('app/public/' . $question->question_audio))) {
      File::delete(storage_path('app/public/' . $question->question_audio));
    }
    $question->delete();
    return back()->with('success', 'Question deleted successfully');
  }

  public function deleteFile($id, $type)
  {
    $question = Question::find($id);

    if ($type == 'question-image') {
      if (File::exists(storage_path('app/public/' . $question->question_image))) {
        File::delete(storage_path('app/public/' . $question->question_image));
      }
      $question->question_image = null;
    } else if ($type == 'question-audio') {
      if (File::exists(storage_path('app/public/' . $question->question_audio))) {
        File::delete(storage_path('app/public/' . $question->question_audio));
      }
      $question->question_audio = null;
    }

    $question->update();

    return back()->with('success', 'Deleted file successfully');
  }
}
