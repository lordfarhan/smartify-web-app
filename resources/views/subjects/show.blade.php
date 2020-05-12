@extends('layouts.app')

@section('title')
  {{__('common.subjects.show.title')}}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="{{ route('subjects.index') }}" class="btn btn-outline-info">{{__('common.subjects.actions.back')}}</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="name">{{__('common.subjects.attributes.subject')}}</label>
                <input id="name" type="text" value="{{ $subject['subject'] }}" class="form-control" disabled />
              </div>
              <div class="form-group">
                <label for="name">{{__('common.subjects.attributes.information')}}</label>
                <input id="name" type="text" value="{{ $subject['information'] }}" class="form-control" disabled />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection