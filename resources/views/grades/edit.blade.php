@extends('layouts.app')

@section('title')
  {{__('common.grades.edit.title')}}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      {{ Form::model($grade, ['method' => 'PATCH','route' => ['grades.update', $grade->id]]) }}
        <div class="card">
          <div class="card-header">
            <a href="{{ route('grades.index') }}" class="btn btn-outline-info">{{__('common.grades.actions.back')}}</a>
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
                  {{ Form::label('grade', __('common.grades.attributes.grade')) }}
                  {{ Form::text('grade', $grade->grade, array('placeholder' => __('common.grades.attributes.grade_placeholder'), 'class' => 'form-control')) }}
                </div>
                <div class="form-group">
                  {{ Form::label('educational_stage', __('common.grades.attributes.educational_stage')) }}
                  {{ Form::select('educational_stage', ['0' => 'SD/MI', '1' => 'SMP/MTs', '2' => 'SMA/SMK/MA'], $grade->educational_stage, ['class' => 'form-control', 'placeholder' => __('common.grades.attributes.educational_stage_placeholder')]) }}
                </div>
                <div class="form-group">
                  {{ Form::label('information', __('common.grades.attributes.information')) }}
                  {{ Form::text('information', $grade->information, array('placeholder' => __('common.grades.attributes.information_placeholder'), 'class' => 'form-control')) }}
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
              {{ Form::submit(__('common.grades.actions.process'), ['class' => 'btn btn-primary pull-right']) }}
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@endsection