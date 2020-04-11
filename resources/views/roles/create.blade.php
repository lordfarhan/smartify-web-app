@extends('layouts.app')

@section('title')
    Create Role
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::open(array('route' => 'roles.store','method'=>'POST')) }}
				<div class="card">
					<div class="card-header">
						<a href="{{ route('roles.index') }}" class="btn btn-outline-info">Back</a>
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
									{{ Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									{{ Form::label('permission', 'Permission') }}
									@foreach($permission as $value)
										{{-- {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'form-control')) }} --}}
										<div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="{{ $value->id }}" value="{{ $value->id }}">
                      <label class="custom-control-label" for="{{ $value->id }}">{{ $value->name }}</label>
                    </div>
										<br/>
									@endforeach
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