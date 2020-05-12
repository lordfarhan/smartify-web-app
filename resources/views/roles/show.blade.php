@extends('layouts.app')

@section('title')
  {{__('common.roles.show.title')}}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="{{ route('roles.index') }}" class="btn btn-outline-info">{{__('common.roles.actions.back')}}</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="name">{{__('common.roles.attributes.name')}}</label>
                <input id="name" type="text" value="{{ $role['name'] }}" class="form-control" disabled />
              </div>
              <div class="form-group">
                <strong>{{__('common.roles.attributes.permission')}}:</strong>
                @if(!empty($rolePermissions))
                  @foreach($rolePermissions as $v)
                    <label class="label label-success">{{ $v->name }},</label>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection