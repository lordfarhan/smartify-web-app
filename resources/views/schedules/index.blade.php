@extends('layouts.app')

@section('head')
	<!-- fullCalendar -->
	<link href="{{ asset('fullcalendar/core/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('fullcalendar/daygrid/main.css') }}" rel='stylesheet' />
	<link href="{{ asset('fullcalendar/timegrid/main.css') }}" rel='stylesheet' />
	<link href="{{ asset('fullcalendar/bootstrap/main.css') }}" rel='stylesheet' />

@endsection

@section('title')
    Schedules
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<div class="response"></div>
		<div id='calendar'></div>  
	</div>
</div>
@endsection

@section('scripts')	
	<script src='{{ asset('fullcalendar/core/main.js') }}'></script>
	<script src='{{ asset('fullcalendar/daygrid/main.js') }}'></script>
	<script src='{{ asset('fullcalendar/timegrid/main.js') }}'></script>
	<script src='{{ asset('fullcalendar/bootstrap/main.js') }}'></script>
	
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				plugins: ['timeGrid', 'bootstrap' ],
				defaultView: 'timeGridWeek',
				themeSystem: 'bootstrap',
				events: {
					url: 'schedules.all',
					failure: function() {
						alert('there was an error while fetching events!');
					}
				},
				eventRender: function (info) {
					$(info.el).tooltip({ 
						title: info.event.title,
						placement: 'top',
						trigger: 'hover',
						container: 'body' 
					});     
				},
				nowIndicator: true,
				eventTimeFormat: {
					hour: '2-digit',
					minute: '2-digit',
					meridiem: false
				}
			});

			calendar.render();
		});
	</script>
@endsection