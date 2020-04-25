@extends('layouts.app')

@section('title')
	Create User
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::open(array('route' => 'users.store', 'method' => 'post', 'files' => true)) }}
				<div class="card">
					<div class="card-header">
						<a href="{{ route('users.index') }}" class="btn btn-outline-info">Back</a>
					</div>
					<div class="card-body">
						@if (!empty($errors->all()))
							<div class="alert alert-danger">
								{{ Html::ul($errors->all()) }}
							</div>
						@endif
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('name', 'Name') }}
									{{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'User Name']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('email', 'Email') }}
									{{ Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'user@domain.com']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('phone', 'Phone') }}
									{{ Form::text('phone', '', ['class' => 'form-control', 'placeholder' => '081100000']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('address', 'Address') }}
									{{ Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Location Unknown']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('roles', 'Roles') }}
									{{ Form::select('roles[]', $roles, [], array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('institution_id', 'Institution') }}
									{{ Form::select('institution_id', $institutions, null, array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{ Form::label('date_of_birth', 'Date of Birth') }}
									{{ Form::date('date_of_birth', \Carbon\Carbon::now(), ['class' => 'form-control']) }}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{ Form::label('gender', 'Gender') }}
									{{ Form::select('gender', ['0' => 'Male', '1' => 'Female'], '0', ['class' => 'form-control']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('image', 'Image') }}
									{{ Form::file('image', ['class'=>'form-control']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('password', 'Password') }}
									{{ Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('confirm-password', 'Confirm Password') }}
									{{ Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) }}
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