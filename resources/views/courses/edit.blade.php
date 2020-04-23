@extends('layouts.app')

@section('title')
    Edit Course
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{ Form::model($course, ['method' => 'PATCH','route' => ['courses.update', $course->id], 'files' => true]) }}
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-info">Back</a>
                </div>
                <div class="card-body">
                    @if(!empty($errors->all()))
                    <div class="alert alert-danger">
                        {{ Html::ul($errors->all())}}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('author_id', 'Author') }}
                                {{ Form::select('author_id', $authors, $course->author_id, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('subject_id', 'Subject') }}
                                {{ Form::select('subject_id', $subjects, $course->subject_id, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('grade_id', 'Grade') }}
                                {{ Form::select('grade_id', $grades, $course->grade_id, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('section', 'Section (optional)') }}
                                {{ Form::select('section', ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'], $course->section, array('class' => 'form-control', 'placeholder' => 'None')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('type', 'Type (only for private type)') }}
                                {{ Form::select('type', ['0' => 'Public', '1' => 'Private'], $course->type, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('enrollment_key', 'Enrollment Key') }}
                                {{ Form::text('enrollment_key', $course->enrollment_key, array('placeholder' => 'Leave empty if your course is public', 'class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('status', 'Status') }}
                                {{ Form::select('status', ['0' => 'Draft', '1' => 'Published'], $course->status, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('institution_id', 'Institution') }}
                                {{ Form::select('institution_id', $institutions, $course->institution_id, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div id="attachment-title-div" class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('attachment_title', 'Attachment Title') }}
                                {{ Form::text('attachment_title', $course->attachment_title, array('placeholder' => 'Course attachment title', 'class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="@if(!empty($course->image)) col-md-6 @else col-md-12 @endif">
                                    <div class="form-group">
                                        {{ Form::label('image', 'Image (optional)') }}
                                        {{ Form::file('image', ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if (!empty($course->image))
                                    <div class="form-group">
                                        {{ Form::label('ex_image', 'Existing Image') }} <a class="float-right" href="/courses.delete-file/{{ $course->id }}/image">Delete</a>
                                        <input name="ex_image" class="form-control" type="text" value="{{ $course->image }}" disabled>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="@if(!empty($course->attachment)) col-md-6 @else col-md-12 @endif">
                                    <div class="form-group">
                                        {{ Form::label('attachment', 'Attachment (optional)') }}
                                        {{ Form::file('attachment', ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if (!empty($course->attachment))
                                    <div class="form-group">
                                        {{ Form::label('ex_attachment', 'Existing Attachment') }} <a class="float-right" href="/courses.delete-file/{{ $course->id }}/attachment">Delete</a>
                                        <input name="ex_attachment" class="form-control" type="text" value="{{ $course->attachment }}" disabled>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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
            checkAttachment();
        };

        $(document).ready(function(){
            $("#attachment").change(function(){
                checkAttachment();
            });
        });
        
        function checkAttachment() {
            var x = document.getElementById("attachment-title-div");
            if (document.getElementById("attachment").files.length == 0 ){
                x.style.visibility = "hidden";
            } else {
                x.style.visibility = "visible";
            }
        };
    </script>
@endsection