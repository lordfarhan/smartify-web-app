@extends('layouts.app')

@section('title')
    Edit Grade
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{ Form::model($institution, ['method' => 'PATCH','route' => ['institutions.update', $institution->id], 'files' => true]) }}
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('institutions.index') }}" class="btn btn-outline-info">Back</a>
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
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', $institution->name, array('placeholder' => 'Codeiva Edu','class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('description', 'Description') }}
                                {{ Form::text('description', $institution->description, array('placeholder' => 'Optional information about institution','class' => 'form-control')) }}
                            </div>
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