
@extends('layouts.app')

@section('head')
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{ asset("lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{ asset("lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
	<!-- JQVMap -->
	<link rel="stylesheet" href="{{ asset("lte/plugins/jqvmap/jqvmap.min.css") }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset("lte/dist/css/adminlte.min.css") }}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ asset("lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ asset("lte/plugins/daterangepicker/daterangepicker.css") }}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ asset("lte/plugins/summernote/summernote-bs4.css") }}">
@endsection

@section('content')
	<!-- Small boxes (Stat box) -->
	<div class="row">
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-info">
				<div class="inner">
					<h3>{{ \Illuminate\Support\Facades\Auth::user()->hasRole('Master') ? \App\Course::count() : \App\Course::whereIn('institution_id', Auth::user()->institutions->pluck('institution_id'))->count() }}</h3>
					<p>{{__('common.dashboard.courses')}}</p>
				</div>
				<div class="icon">
					<i class="ion ion-ios-book"></i>
				</div>
				<a href="{{route('courses.index')}}" class="small-box-footer">{{__('common.dashboard.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-success">
				<div class="inner">
					{{-- <h3>53<sup style="font-size: 20px">%</sup></h3> --}}
          {{-- <h3>{{\Illuminate\Support\Facades\Auth::user()->hasRole('Master') ? \App\Schedule::count() : \App\Schedule::whereIn('course_id', \App\Course::whereIn('institution_id', Auth::user()->institutions->pluck('institution_id')))->count()}}</h3> --}}
          <h3>N/a</h3>
          
					<p>{{__('common.dashboard.schedules')}}</p>
				</div>
				<div class="icon">
					<i class="ion ion-android-calendar"></i>
				</div>
				<a href="{{route('schedules.index')}}" class="small-box-footer">{{__('common.dashboard.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-warning">
				<div class="inner">
					<h3>{{ \Illuminate\Support\Facades\Auth::user()->hasRole('Master') ? \App\User::count() : \App\UserInstitution::whereIn('institution_id', Auth::user()->institutions->pluck('institution_id'))->count() }}</h3>
					<p>{{__('common.dashboard.users')}}</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<a href="{{route('users.index')}}" class="small-box-footer">{{__('common.dashboard.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-danger">
				<div class="inner">
					<h3>N/a</h3>

					<p>None</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="#" class="small-box-footer">{{__('common.dashboard.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
	</div>
	<!-- /.row -->
	
@endsection

@section('scripts')
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ asset("lte/plugins/jquery-ui/jquery-ui.min.js") }}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- ChartJS -->
	<script src="{{ asset("lte/plugins/chart.js/Chart.min.js") }}"></script>
	<!-- Sparkline -->
	<script src="{{ asset("lte/plugins/sparklines/sparkline.js") }}"></script>
	<!-- JQVMap -->
	<script src="{{ asset("lte/plugins/jqvmap/jquery.vmap.min.js") }}"></script>
	<script src="{{ asset("lte/plugins/jqvmap/maps/jquery.vmap.usa.js") }}"></script>
	<!-- jQuery Knob Chart -->
	<script src="{{ asset("lte/plugins/jquery-knob/jquery.knob.min.js") }}"></script>
	<!-- daterangepicker -->
	<script src="{{ asset("lte/plugins/moment/moment.min.js") }}"></script>
	<script src="{{ asset("lte/plugins/daterangepicker/daterangepicker.js") }}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ asset("lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
	<!-- Summernote -->
	<script src="{{ asset("lte/plugins/summernote/summernote-bs4.min.js") }}"></script>
	<!-- overlayScrollbars -->
	<script src="{{ asset("lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="{{ asset("lte/dist/js/pages/dashboard.js") }}"></script>
@endsection