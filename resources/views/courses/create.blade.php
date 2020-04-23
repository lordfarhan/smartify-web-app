@extends('layouts.app')

@section('head')
	<!-- daterange picker -->
	<link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('title')
    Create Course
@endsection

@section('content')
	<div class="row" onload="checkAttachment()">
		<div class="col-12">
			{{ Form::open(array('route' => 'courses.store','method'=>'POST', 'files' => true)) }}
				<div class="card">
					<div class="card-header">
						<a href="{{ route('courses.index') }}" class="btn btn-outline-info">Back</a>
					</div>
					<div class="card-body">
						@if(!empty($errors->all()))
						<div class="alert alert-danger">
							{{ Html::ul($errors->all())}}
						</div>
						@endif
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('author_id', 'Author') }}
									{{ Form::select('author_id', $authors, null, array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('subject_id', 'Subject') }}
									{{ Form::select('subject_id', $subjects, null, array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{ Form::label('grade_id', 'Grade') }}
									{{ Form::select('grade_id', $grades, null, array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{ Form::label('section', 'Section (optional)') }}
									{{ Form::select('section', ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'], null, array('class' => 'form-control', 'placeholder' => 'None')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('type', 'Type') }}
									{{ Form::select('type', ['0' => 'Public', '1' => 'Private'], '0', array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('enrollment_key', 'Enrollment Key (only for private type') }}
									{{ Form::text('enrollment_key', null, array('placeholder' => 'Leave empty if your course is public', 'class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('status', 'Status') }}
									{{ Form::select('status', ['0' => 'Draft', '1' => 'Published'], '0', array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('institution_id', 'Institution') }}
									{{ Form::select('institution_id', $institutions, null, array('class' => 'form-control')) }}
								</div>
							</div>
							<div id="attachment-title-div" class="col-md-6">
								<div class="form-group">
									{{ Form::label('attachment_title', 'Attachment Title') }}
									{{ Form::text('attachment_title', null, array('placeholder' => 'Course attachment title', 'class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('image', 'Image (optional)') }}
									{{ Form::file('image', ['class'=>'form-control']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('attachment', 'Attachment (optional)') }}
									{{ Form::file('attachment', ['id' => 'attachment', 'class'=>'form-control']) }}
								</div>
							</div>
						</div>
					</div>
				</div>
				@can('schedule-create')
				<div class="card">
					<div class="card-header text-bold">
						Schedule
					</div>
					<div class="card-body">
						<div class="row" id="schedule-row">
							<div class="col-md-6 mb-3">
								<label for="datepicker">Date</label>
								<div class="input-group date" id="datepicker-date" data-target-input="nearest">
									<input name="date[]" type="text" class="form-control datetimepicker-input" placeholder="Date" data-target="#datepicker-date"/>
									<div class="input-group-append" data-target="#datepicker-date" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<label for="start_time[]">Start Course</label>
								<div class="input-group date" id="timepicker-start" data-target-input="nearest">
									<input name="start_time[]" type="text" class="form-control datetimepicker-input" placeholder="Start" data-target="#timepicker-start"/>
									<div class="input-group-append" data-target="#timepicker-start" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<label for="end_time[]">End Course</label>
								<div class="input-group date" id="timepicker-end" data-target-input="nearest">
									<input name="end_time[]" type="text" class="form-control datetimepicker-input" placeholder="End" data-target="#timepicker-end"/>
									<div class="input-group-append" data-target="#timepicker-end" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<label for="add-schedule-row" class="text-white">Add Day</label>
								<button id="add-schedule-row" type="button" class="btn btn-primary col-12">Add Day</i></button>
							</div>
						</div>
						<div id="new-schedule-row"></div>
						<div id="new-schedule-script"></div>
					</div>
					<div class="card-footer text-right">
						{{ Form::submit('Process', ['class' => 'btn btn-primary pull-right']) }}
					</div>
				</div>
				@endcan
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
			checkAttachment();
			$.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
				format: "HH:mm"
			});
		};

		$(document).ready(function(){
			$("#attachment").change(function(){
				checkAttachment();
			});
		});
		
		function checkAttachment() {
			var x = document.getElementById("attachment-title-div");
			if (document.getElementById("attachment").files.length == 0 ){
				x.style.visibility = "hidden";
			} else {
				x.style.visibility = "visible";
			}
		};
	</script>

	{{-- Schedules --}}
	<script type="text/javascript">
		// add row
		var i = 1
		$("#add-schedule-row").click(function () {
			var html = '';
			html += '<div class="row" id="schedule-row">';
			html +=	'<div class="col-md-6 mb-3">'
			html +=	'<div class="input-group date" id="datepicker-date'+i+'" data-target-input="nearest">'
			html +=	'<input name="date[]" type="text" class="form-control datetimepicker-input" placeholder="Date" data-target="#datepicker-date'+i+'"/>'
			html +=	'<div class="input-group-append" data-target="#datepicker-date'+i+'" data-toggle="datetimepicker">'
			html += '<div onclick="setCalendarFormat('+i+');" class="input-group-text"><i class="far fa-calendar-alt"></i></div>'
			html += '</div>'
			html += '</div>'
			html += '</div>'
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

		function setCalendarFormat(id){
			return $("#datepicker-date"+id).datetimepicker({ format: "LL" })
		}

		$(function () { $("#datepicker-date").datetimepicker({ format: "LL" }) })
	</script>
@endsection