@extends('layouts/app')

@section('title')
    Edit Question
@endsection

@section('content')
<div class="row" onload="checkType()">
    <div class="col-12">
        {{ Form::model($question, ['method' => 'PATCH','route' => ['questions.update', $question->id], 'files' => true]) }}
        <div class="card">
            <div class="card-header">
                <a href="/courses/{{$question->test->course->id}}/tests/{{$question->test->id}}" class="btn btn-outline-info">Back</a>
            </div>
            <div class="card-body">
                @if(!empty($errors->all()))
                <div class="alert alert-danger">
                    {{ Html::ul($errors->all())}}
                </div>
                @endif
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::number('order', $question->order, array('placeholder' => 'Question order', 'class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            {{ Form::text('question', $question->question, array('placeholder' => 'Put question here', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    {{-- Question Image --}}
                    <div class="col-md-6">
                        <div class="row">
                            <div class="@if(!empty($question->question_image)) col-md-6 @else col-md-12 @endif">
                                <div class="form-group">
                                    {{ Form::label('question_image', 'Question Image') }}
                                    {{ Form::file('question_image', ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($question->question_image))
                                <div class="form-group">
                                    {{ Form::label('ex_question_image', 'Existing Question Image') }} <a class="float-right" href="/questions.delete-file/{{ $question->id }}/question-image">Delete</a>
                                    <input name="ex_question_image" class="form-control" type="text" value="{{ $question->question_image }}" disabled>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Question Audio --}}
                    <div class="col-md-6">
                        <div class="row">
                            <div class="@if(!empty($question->question_audio)) col-md-6 @else col-md-12 @endif">
                                <div class="form-group">
                                    {{ Form::label('question_audio', 'Question Audio') }}
                                    {{ Form::file('question_audio', ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($question->question_audio))
                                <div class="form-group">
                                    {{ Form::label('ex_question_audio', 'Existing Question Audio') }} <a class="float-right" href="/questions.delete-file/{{ $question->id }}/question-audio">Delete</a>
                                    <input name="ex_question_audio" class="form-control" type="text" value="{{ $question->question_audio }}" disabled>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 ml-1">
                        <label for="">Correct Answer</label>
                    </div>
                    {{-- Correct answer --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::text('correct_answer', $question->correct_answer, array('placeholder' => 'This form is the correct answer of it question', 'class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="multiple" name="type" value="0" {{$question->type == '0' ? 'checked' : ''}} onclick="checkType()">
                                <label for="multiple" class="custom-control-label">Multiple Choice</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="boolean" name="type" value="1" {{$question->type == '1' ? 'checked' : ''}} onclick="checkType()">
                                <label for="boolean" class="custom-control-label">True or False</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ml-1">
                        <label for="">Incorrect Answers</label>
                    </div>
                    {{-- 1st incorrect answer --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::text('incorrect_answer_1', explode('; ', $question->incorrect_answers)[0], array('id' => 'incorrect_answer_1', 'placeholder' => 'This form is for first incorrect answer', 'class' => 'form-control')) }}
                        </div>
                    </div>
                    {{-- 2nd incorrect answer --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::text('incorrect_answer_2', $question->type == '0' ? explode('; ', $question->incorrect_answers)[1] : null, array('id' => 'incorrect_answer_2', 'placeholder' => 'This form is for second incorrect answer', 'class' => 'form-control')) }}
                        </div>
                    </div>
                    {{-- 3rd incorrect answer --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::text('incorrect_answer_3', $question->type == '0' ? explode('; ', $question->incorrect_answers)[2] : null, array('id' => 'incorrect_answer_3', 'placeholder' => 'This form is for third incorrect answer', 'class' => 'form-control')) }}
                        </div>
                    </div>
                    {{-- 4th incorrect answer --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::text('incorrect_answer_4', $question->type == '0' ? explode('; ', $question->incorrect_answers)[3] : null, array('id' => 'incorrect_answer_4', 'placeholder' => 'This form is for fourth incorrect answer', 'class' => 'form-control')) }}
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="question_image" class="custom-file-input" id="question_image">
                                <label class="custom-file-label" for="question_image">Choose image</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="question_image" class="custom-file-input" id="question_image">
                                <label class="custom-file-label" for="question_image">Choose audio</label>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="card-footer text-right">
                {{ Form::submit('Process', ['class' => 'btn btn-primary pull-right']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        window.onload = function() {
            checkType();
        };
		function checkType() {
			var multiple = document.getElementById("multiple");
			var boolean = document.getElementById("boolean");
			var secondIncorrectAnswer = document.getElementById("incorrect_answer_2");
			var thirdIncorrectAnswer = document.getElementById("incorrect_answer_3");
			var fourthIncorrectAnswer = document.getElementById("incorrect_answer_4");
			secondIncorrectAnswer.style.display = boolean.checked ? "none" : "block";
			thirdIncorrectAnswer.style.display = boolean.checked ? "none" : "block";
			fourthIncorrectAnswer.style.display = boolean.checked ? "none" : "block";
		}
	</script>
@endsection