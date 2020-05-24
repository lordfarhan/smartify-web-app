@extends('layouts.app')

@section('title')
	{{__('common.users.create.title')}}
@endsection

@section('head')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset("lte/plugins/select2/css/select2.min.css")}}">
  <link rel="stylesheet" href="{{asset("lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::open(array('route' => 'users.store', 'method' => 'post', 'files' => true)) }}
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
              @if (Auth::user()->hasRole('Master'))
							<div class="col-md-12">
                <div class="form-group">
                  <label>{{__('common.users.attributes.institution')}}</label>
                  <select class="select2bs4" multiple="multiple" data-placeholder="Select Institutions"
                          style="width: 100%;" name="institution_id[]">
                    @foreach ($institutions as $institution)
                      <option value="{{$institution->id}}">{{$institution->name}}</option>
                    @endforeach
                  </select>
                </div>
							</div>
              @endif
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('name', __('common.users.attributes.name')) }}
									{{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('common.users.attributes.name_placeholder')]) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('email', __('common.users.attributes.email')) }}
									{{ Form::text('email', '', ['class' => 'form-control', 'placeholder' => __('common.users.attributes.email_placeholder')]) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('phone', __('common.users.attributes.phone')) }}
									{{ Form::text('phone', '', ['class' => 'form-control', 'placeholder' => __('common.users.attributes.phone_placeholder')]) }}
								</div>
              </div>
              <div class="col-md-6">
								<div class="form-group">
									{{ Form::label('roles', __('common.users.attributes.roles')) }}
									{{ Form::select('roles[]', $roles, [], array('class' => 'custom-select')) }}
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									{{ Form::label('address', __('common.users.attributes.address')) }}
									{{ Form::text('address', '', ['class' => 'form-control', 'placeholder' => __('common.users.attributes.address_placeholder')]) }}
								</div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>{{__('common.users.attributes.province')}}</label>
                  <select name="province_id" id="province" data-placeholder="{{__('common.users.attributes.province_placeholder')}}" class="custom-select">
                    <option value="">{{__('common.users.attributes.province_placeholder')}}</option>
                    @foreach ($provinces as $province)
                      <option value="{{$province->id}}">{{$province->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
								<div class="form-group">
                  <label>{{__('common.users.attributes.regency')}}</label>
                  <select name="regency_id" id="regency" class="custom-select">
                    <option value="">{{__('common.users.attributes.regency_placeholder')}}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
								<div class="form-group">
                  <label>{{__('common.users.attributes.district')}}</label>
                  <select name="district_id" id="district" class="custom-select">
                    <option value="">{{__('common.users.attributes.district_placeholder')}}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
								<div class="form-group">
                  <label>{{__('common.users.attributes.village')}}</label>
                  <select name="village_id" id="village" class="custom-select">
                    <option value="">{{__('common.users.attributes.village_placeholder')}}</option>
                  </select>
                </div>
              </div>
							<div class="col-md-3">
								<div class="form-group">
									{{ Form::label('date_of_birth', __('common.users.attributes.date_of_birth')) }}
									{{ Form::date('date_of_birth', \Carbon\Carbon::now(), ['class' => 'form-control']) }}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{ Form::label('gender', __('common.users.attributes.gender')) }}
									{{ Form::select('gender', ['0' => 'Male', '1' => 'Female'], null, ['class' => 'form-control', 'placeholder' => __('common.users.attributes.gender_placeholder')]) }}
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

@section('scripts')
  <!-- Select2 -->
  <script src="{{asset("lte/plugins/select2/js/select2.full.min.js")}}"></script>
  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    })
  </script>
  <script type="text/javascript">
    $("#province").change(function(){
        $.ajax({
            url: '/administratives/provinces/' + $(this).val() + '/regencies',
            method: 'GET',
            success: function(data) {
                $('#regency').html(data.html);
            }
        });
    });
    $("#regency").change(function(){
        $.ajax({
            url: '/administratives/regencies/' + $(this).val() + '/districts',
            method: 'GET',
            success: function(data) {
                $('#district').html(data.html);
            }
        });
    });
    $("#district").change(function(){
        $.ajax({
            url: '/administratives/districts/' + $(this).val() + '/villages',
            method: 'GET',
            success: function(data) {
                $('#village').html(data.html);
            }
        });
    });
  </script>
@endsection