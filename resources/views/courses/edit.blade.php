@extends('layouts.app')

@section('title')
    Edit Course
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{ Form::model($course, ['method' => 'PATCH','route' => ['courses.update', $course->id]]) }}
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
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('grade_id', 'Grade') }}
                                {{ Form::select('grade_id', $grades, $course->grade_id, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('type', 'Type') }}
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
                                {{ Form::label('vendor', 'Vendor') }}
                                {{ Form::text('vendor', $course->vendor, array('placeholder' => 'Codeiva Edu Team','class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('image', 'Image') }}
                                {{ Form::file('image', ['class'=>'form-control']) }}
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