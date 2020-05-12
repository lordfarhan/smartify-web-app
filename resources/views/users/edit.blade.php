@extends('layouts.app')

@section('title')
	{{__('common.users.edit.title')}}
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id], 'files' => true]) }}
				<div class="card">
					<div class="card-header">
						<a href="{{ route('users.index') }}" class="btn btn-outline-info">{{__('common.users.actions.back')}}</a>
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
									{{ Form::label('name', __('common.users.attributes.name')) }}
									{{ Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => __('common.users.attributes.name_placeholder')]) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('email', __('common.users.attributes.email')) }}
									{{ Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => __('common.users.attributes.email_placeholder')]) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('phone', __('common.users.attributes.phone')) }}
									{{ Form::text('phone', $user->phone, ['class' => 'form-control', 'placeholder' => __('common.users.attributes.phone_placeholder')]) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('address', __('common.users.attributes.address')) }}
									{{ Form::text('address', $user->address, ['class' => 'form-control', 'placeholder' => __('common.users.attributes.address_placeholder')]) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('roles', __('common.users.attributes.roles')) }}
									{{ Form::select('roles[]', $roles, $userRole, array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('institution_id', __('common.users.attributes.institution')) }}
									{{ Form::select('institution_id', $institutions, $user->institution_id, array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{ Form::label('date_of_birth', __('common.users.attributes.date_of_birth')) }}
									{{ Form::date('date_of_birth', \Carbon\Carbon::parse($user->date_of_birth), ['class' => 'form-control']) }}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{ Form::label('gender', __('common.users.attributes.gender')) }}
									{{ Form::select('gender', ['0' => 'Male', '1' => 'Female'], $user->gender, ['class' => 'form-control', 'placeholder' => __('common.users.attributes.gender_placeholder')]) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('image', __('common.users.attributes.image')) }}
									{{ Form::file('image', ['class'=>'form-control']) }}        
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('password', __('common.users.attributes.password')) }}
									{{ Form::password('password', array('placeholder' => __('common.users.attributes.password_placeholder'), 'class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('confirm-password', __('common.users.attributes.confirm_password')) }}
									{{ Form::password('confirm-password', array('placeholder' => __('common.users.attributes.confirm_password_placeholder'), 'class' => 'form-control')) }}
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer text-right">
						{{ Form::submit(__('common.users.actions.process'), ['class' => 'btn btn-primary pull-right']) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@endsection