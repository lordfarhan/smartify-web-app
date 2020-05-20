@extends('layouts.app')

@section('head')
	<!-- fullCalendar -->
	<link href="{{ asset('fullcalendar/core/main.css') }}" rel='stylesheet' />
  <link href="{{ asset('fullcalendar/daygrid/main.css') }}" rel='stylesheet' />
	<link href="{{ asset('fullcalendar/timegrid/main.css') }}" rel='stylesheet' />
	<link href="{{ asset('fullcalendar/bootstrap/main.css') }}" rel='stylesheet' />

@endsection

@section('title')
    {{__('common.schedules.index.title')}}
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
					url: '/schedules.all',
					failure: function() {
						alert('there was an error while fetching events!');
					}
				},
        editable: false, // Don't allow editing of events
        handleWindowResize: true,
        weekends: true, // Show/Hide weekends
        // header: true, // Show/Hide buttons/titles
        minTime: '07:00:00', // Start time for the calendar
        maxTime: '22:00:00', // End time for the calendar
        weekNumbers: true,
				eventRender: function (info) {
					$(info.el).tooltip({ 
						title: info.event.title,
						placement: 'top',
						trigger: 'hover',
						container: 'body' 
					});     
				},
				eventClick: function(info) {
					window.location.href = 'schedules/' + info.event.id + '/attendances/create/';
					info.el.style.borderColor = 'red';
				},
				dayClick: function(date, jsEvent, view) { 
					alert('Clicked on: ' + date.getDate()+"/"+date.getMonth()+"/"+date.getFullYear());  
				},
				nowIndicator: true,
        eventTimeFormat: { // like '14:30:00'
          hour: '2-digit',
          minute: '2-digit',
          meridiem: false
        }
			});

			calendar.render();
		});
	</script>
@endsection