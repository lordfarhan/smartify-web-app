@extends('layouts.app')

@section('title')
    Edit Grade
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{ Form::model($grade, ['method' => 'PATCH','route' => ['grades.update', $grade->id]]) }}
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('grades.index') }}" class="btn btn-outline-info">Back</a>
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
                                {{ Form::label('grade', 'Grade') }}
                                {{ Form::text('grade', $grade->grade, array('placeholder' => 'Grade', 'class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('educational_stage', 'Educational Stage') }}
                                {{ Form::select('educational_stage', ['0' => 'SD/MI', '1' => 'SMP/MTs', '2' => 'SMA/SMK/MA'], $grade->educational_stage, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('information', 'Information') }}
                                {{ Form::text('information', $grade->information, array('placeholder' => 'Optional information about subject', 'class' => 'form-control')) }}
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