@extends('layouts.app')

@section('title')
    Edit Subject
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{ Form::model($subject, ['method' => 'PATCH','route' => ['subjects.update', $subject->id]]) }}
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-info">Back</a>
                </div>
                <div class="card-body">
                    @if(!empty($errors->all()))
                    <div class="alert alert-danger">
                        {{ Html::ul($errors->all())}}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('subject', 'Subject') }}
                                {{ Form::text('subject', $subject->subject, array('placeholder' => 'subject', 'class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('information', 'Information') }}
                                {{ Form::text('information', $subject->information, array('placeholder' => 'Optional information about subject', 'class' => 'form-control')) }}
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