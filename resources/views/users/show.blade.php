@extends('layouts.app')

@section('title')
  {{__('common.users.show.title')}}
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-header">
        <a href="{{ route('users.index') }}" class="btn btn-outline-info">{{__('common.users.actions.back')}}</a>
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
            <b>{{__('common.users.show.joined_at')}}</b> <a class="float-right">{{ \Carbon\Carbon::parse($user->created_at)->format("M, d Y H:i:s") }}</a>
          </li>
          <li class="list-group-item">
            <b>{{__('common.users.show.last_update')}}</b> <a class="float-right">{{ \Carbon\Carbon::parse($user->updated_at)->format("M, d Y H:i:s") }}</a>
          </li>
        </ul>

        <a href="{{ route('me.edit') }}" class="btn btn-primary btn-block"><b>Edit</b></a>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- About Me Box -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{__('common.users.show.about')}}</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <strong><i class="fas fa-briefcase mr-1"></i> {{__('common.users.attributes.institution')}}</strong>
        <p class="text-muted">
        @if (count($user->institutions) == 0)
          {{__('common.users.show.empty')}}
        @else
          @foreach ($user->institutions as $index => $institution)
            <label class="badge badge-success">{{ $institution->institution->name }}</label>
          @endforeach
        @endif
        </p>
        <hr>

				<strong><i class="fas fa-envelope mr-1"></i> {{__('common.users.attributes.email')}}</strong>
        <p class="text-muted">
          @if ($user->email == null)
            {{__('common.users.show.empty')}}
          @else
            {{$user->email}}
          @endif
        </p>
        <hr>

        <strong><i class="fas fa-phone-alt mr-1"></i> {{__('common.users.attributes.phone')}}</strong>
        <p class="text-muted">
          @if ($user->phone == null)
            {{__('common.users.show.empty')}}
          @else
            {{$user->phone}}
          @endif
        </p>
        <hr>

        <strong><i class="fas fa-map-marker-alt mr-1"></i> {{__('common.users.attributes.address')}}</strong>
        <p class="text-muted">
          @if ($user->address == null)
            {{__('common.users.show.empty')}}
          @else
            {{$user->address}}
          @endif
        </p>
        <hr>

        <strong><i class="fas fa-calendar-alt mr-1"></i> {{__('common.users.attributes.date_of_birth')}}</strong>
        <p class="text-muted">
          @if ($user->date_of_birth == null)
            {{__('common.users.show.empty')}}
          @else
            {{\Carbon\Carbon::parse($user->date_of_birth)->format("M, d Y") . ' (' . \Carbon\Carbon::parse($user->date_of_birth)->age . ')'}}
          @endif
        </p>
        <hr>

        <strong><i class="fas fa-venus-mars mr-1"></i> {{__('common.users.attributes.gender')}}</strong>
				<p class="text-muted">
            @if ($user->gender == 0)
              {{__('common.users.show.gender_male')}}
            @elseif ($user->gender == 1)
              {{__('common.users.show.gender_female')}}
            @else
              {{__('common.users.show.gender_undefined')}}
            @endif
				</p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection