@extends('layouts.app')

@section('title')
  {{__('common.roles.edit.title')}}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      {{ Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) }}
      <div class="card">
        <div class="card-header">
            <a href="{{ route('roles.index') }}" class="btn btn-outline-info">{{__('common.roles.actions.back')}}</a>
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
                {{ Form::label('name', __('common.roles.attributes.name')) }}
                {{ Form::text('name', $role->name, array('placeholder' => __('common.roles.attributes.name_placeholder'), 'class' => 'form-control')) }}
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                {{ Form::label('permission', __('common.roles.attributes.permission')) }}
                <div class="row">
                @foreach($permission as $value)
                  <div class="card card-body col-md-3">
                    <div class="custom-control custom-switch">
                      <input name="permission[]" type="checkbox" class="custom-control-input" id="{{ $value->id }}" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                      <label class="custom-control-label" for="{{ $value->id }}">{{ $value->name }}</label>
                    </div>
                  </div>
                @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          {{ Form::submit(__('common.roles.actions.process'), ['class' => 'btn btn-primary pull-right']) }}
        </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
@endsection