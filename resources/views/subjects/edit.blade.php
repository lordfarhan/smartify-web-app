@extends('layouts.app')

@section('title')
  {{__('common.subjects.edit.title')}}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      {{ Form::model($subject, ['method' => 'PATCH','route' => ['subjects.update', $subject->id]]) }}
        <div class="card">
          <div class="card-header">
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-info">{{__('common.subjects.actions.back')}}</a>
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
                  {{ Form::label('subject', __('common.subjects.attributes.subject')) }}
                  {{ Form::text('subject', $subject->subject, array('placeholder' => __('common.subjects.attributes.subject_placeholder'), 'class' => 'form-control')) }}
                </div>
                <div class="form-group">
                  {{ Form::label('information', __('common.subjects.attributes.information')) }}
                  {{ Form::text('information', $subject->information, array('placeholder' => __('common.subjects.attributes.information_placeholder'), 'class' => 'form-control')) }}
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
              {{ Form::submit(__('common.subjects.actions.process'), ['class' => 'btn btn-primary pull-right']) }}
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@endsection