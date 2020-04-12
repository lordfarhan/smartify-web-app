@extends('layouts.app')

@section('title')
    User Detail
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-header">
        <a href="{{ route('users.index') }}" class="btn btn-outline-info">Back</a>
      </div>
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle"
               src="{{ asset("storage/". $user->image) }}"
               alt="User profile picture">
        </div>

        <h3 class="profile-username text-center">{{ $user->name }}</h3>

        <p class="text-muted text-center">
					@if(!empty($user->getRoleNames()))
						@foreach($user->getRoleNames() as $v)
								<label class="badge badge-success">{{ $v }}</label>
						@endforeach
					@endif
				</p>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Joined at</b> <a class="float-right">{{ \Carbon\Carbon::parse($user->created_at)->format("M, d Y H:i:s") }}</a>
          </li>
          <li class="list-group-item">
            <b>Last Update</b> <a class="float-right">{{ \Carbon\Carbon::parse($user->updated_at)->format("M, d Y H:i:s") }}</a>
          </li>
        </ul>

        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- About Me Box -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">About Me</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
				<strong><i class="fas fa-envelope mr-1"></i> E-Mail</strong>
        <p class="text-muted">{{$user->email}}</p>
        <hr>

        <strong><i class="fas fa-phone-alt mr-1"></i> Phone</strong>
        <p class="text-muted">{{$user->phone}}</p>
        <hr>

        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
        <p class="text-muted">{{$user->address}}</p>
        <hr>

        <strong><i class="fas fa-calendar-alt mr-1"></i> Date of Birth</strong>
        <p class="text-muted">
          {{\Carbon\Carbon::parse($user->date_of_birth)->format("M, d Y")}}
        </p>
        <hr>

        <strong><i class="fas fa-venus-mars mr-1"></i> Gender</strong>
				<p class="text-muted">
					<?php if($user->gender == "0") {
							echo 'Male';
					 	} else if ($user->gender == 1) {
							echo 'Female';
						} else {
              echo 'Undefined';
            } ?>
				</p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection