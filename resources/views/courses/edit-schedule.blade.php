@extends('layouts.app')

@section('head')
	<!-- daterange picker -->
	<link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('title')
    Edit Course
@endsection

@section('content')
    <div class="row" onload="setDefaultTimepicker()">
        <div class="col-12">
            {{ Form::open(array('route' => 'courses.updateSchedule','method'=>'POST')) }}
			<div class="card">
				<div class="card-header">
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-info">Back</a>
                </div>
				<div class="card-body">
					<input value="{{$course->id}}" name="id" type="hidden">
					@foreach ($course->schedules as $index => $schedule)
					<div class="row" id="schedule-row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::select('day[]', $days, $schedule->day, array('class' => 'form-control schedule-list', 'placeholder' => 'Select day')) }}
							</div>
						</div>
						<div class="col-md-2">
							<div class="input-group date" id="timepicker-start{{$index}}" data-target-input="nearest">
								<input value="{{\Carbon\Carbon::parse($schedule->start_time)->format('H:i')}}" name="start_time[]" type="text" class="form-control datetimepicker-input" placeholder="Start" data-target="#timepicker-start{{$index}}"/>
								<div class="input-group-append" data-target="#timepicker-start{{$index}}" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="far fa-clock"></i></div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="input-group date" id="timepicker-end{{$index}}" data-target-input="nearest">
								<input value="{{\Carbon\Carbon::parse($schedule->end_time)->format('H:i')}}" name="end_time[]" type="text" class="form-control datetimepicker-input" placeholder="End" data-target="#timepicker-end{{$index}}"/>
								<div class="input-group-append" data-target="#timepicker-end{{$index}}" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="far fa-clock"></i></div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<button id="remove-schedule-row" type="button" class="btn btn-danger col-12">Remove</i></button>
						</div>
					</div>
					@endforeach
					<div id="new-schedule-row"></div>
					<div id="new-schedule-script"></div>
				</div>
				<div class="card-footer text-right">
					{{ Form::submit('Process', ['class' => 'btn btn-primary pull-right']) }}
				</div>
			</div>
			{{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
	<!-- InputMask -->
	<script src="{{asset('lte/plugins/moment/moment.min.js')}}"></script>
	<script src="{{asset('lte/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
	<!-- date-range-picker -->
	<script src="{{asset('lte/plugins/daterangepicker/daterangepicker.js')}}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
	
	<script type="text/javascript">
        window.onload = function() {
			$.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
				format: "HH:mm"
			});
        };

		function setDefaultTimepicker() {
			$.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
				format: "HH:mm"
			});
		};
	
		var i = 100
		$("#add-schedule-row").click(function () {
			var html = '';
			html += '<div class="row" id="schedule-row">';
			html += '<div class="col-md-6">';
			html += '<div class="form-group">';
			html += '{{ Form::select("day[]", $days, null, array("class" => "form-control schedule-list", "placeholder" => "Select day")) }}';
			html += '</div>';
			html += '</div>';
			html += '<div class="col-md-2">';
			html += '<div class="input-group date" id="timepicker-start'+i+'" data-target-input="nearest">';
			html += '<input name="start_time[]" type="text" class="form-control datetimepicker-input" placeholder="Start" data-target="#timepicker-start' + i + '"/>';
			html += '<div class="input-group-append" data-target="#timepicker-start'+i+'" data-toggle="datetimepicker">';
			html += '<div class="input-group-text"><i class="far fa-clock"></i></div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="col-md-2">';
			html += '<div class="input-group date" id="timepicker-end'+i+'" data-target-input="nearest">';
			html += '<input name="end_time[]" type="text" class="form-control datetimepicker-input" placeholder="End" data-target="#timepicker-end' + i + '"/>';
			html += '<div class="input-group-append" data-target="#timepicker-end'+i+'" data-toggle="datetimepicker">';
			html += '<div class="input-group-text"><i class="far fa-clock"></i></div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="col-md-2">';
			html += '<button id="remove-schedule-row" type="button" class="btn btn-danger col-12">Remove</i></button>';
			html += '</div>';
			html += '</div>';

			$('#new-schedule-row').append(html);
			i++;
		});

    	// remove row
    	$(document).on('click', '#remove-schedule-row', function () {
        	$(this).closest('#schedule-row').remove();
		});
	</script>
@endsection