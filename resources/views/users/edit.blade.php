@extends('layouts.app')

@section('title')
	Edit User
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id], 'files' => true]) }}
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
									{{ Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'User Name']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('email', 'Email') }}
									{{ Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'user@domain.com']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('phone', 'Phone') }}
									{{ Form::text('phone', $user->phone, ['class' => 'form-control', 'placeholder' => '081111111']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('address', 'Address') }}
									{{ Form::text('address', $user->address, ['class' => 'form-control', 'placeholder' => 'Some Location']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('date_of_birth', 'Date of Birth') }}
									{{ Form::date('date_of_birth', \Carbon\Carbon::parse($user->date_of_birth), ['class' => 'form-control']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('gender', 'Gender') }}
									{{ Form::select('gender', ['0' => 'Male', '1' => 'Female'], $user->gender, ['class' => 'form-control']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('roles', 'Roles') }}
									{{ Form::select('roles[]', $roles, $userRole, array('class' => 'form-control')) }}
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
									{{ Form::password('password', array('placeholder' => 'Empty if you do not desire to change password', 'class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('confirm-password', 'Confirm Password') }}
									{{ Form::password('confirm-password', array('placeholder' => 'Empty if you do not desire to change password','class' => 'form-control')) }}
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

{{-- @section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone:</strong>
            {!! Form::text('phone', null, array('placeholder' => 'Phone','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Address:</strong>
            {!! Form::text('address', null, array('placeholder' => 'Address','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}

@endsection --}}