@extends('layouts.app')

@section('title')
  {{__('common.grades.show.title')}}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="{{ route('grades.index') }}" class="btn btn-outline-info">{{__('common.grades.actions.back')}}</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="name">{{__('common.grades.attributes.grade')}}</label>
                <input id="name" type="text" value="{{ $grade['grade'] }}" class="form-control" disabled />
              </div>
              <div class="form-group">
                <label for="name">{{__('common.grades.attributes.educational_stage')}}</label>
                <input id="name" type="text" value="{{ $grade->getEducationalStage() }}" class="form-control" disabled />
              </div>
              <div class="form-group">
                <label for="name">{{__('common.grades.attributes.information')}}</label>
                <input id="name" type="text" value="{{ $grade['information'] }}" class="form-control" disabled />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection