@extends('layouts.app')

@section('head')
	<!-- daterange picker -->
	<link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
	<!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  
  {{-- Data tables --}}
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset("lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
@endsection

@section('title')
    Record Attendance - {{\Carbon\Carbon::parse($schedule->date)->format('d M Y')}}
@endsection

@section('content')
  <div class="col-12">
    {{ Form::open(array('route' => 'attendances.store', 'method'=>'POST')) }}
    <div class="form-group">
      <input name="schedule_id" type="hidden" value="{{$schedule->id}}">
    </div>
    <div class="card">
      <div class="card-header">
          <a href="{{route('schedules.index')}}" class="btn btn-outline-info">Back</a>
      </div>
      <div class="card-body">
        @if(!empty($errors->all()))
        <div class="alert alert-danger">
          {{ Html::ul($errors->all())}}
        </div>
        @endif
        <h3>Student of {{ $schedule->course->subject->subject . " - " . $schedule->course->grade->grade . " " . $schedule->course->grade->getEducationalStage() }}</h3>
        <table id="table2" class="table table-borderless table-hover">
          <thead class="thead-light">
            <tr>
              <th width="20px">No</th>
              <th>Student Name</th>
              <th>Attendance Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($schedule->course->enrollments as $key => $course_enrollment)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $course_enrollment->user->name }}</td>
              <td>
                <div class="p-0 m-0 form-group">
                  <input name="student[{{$key}}]" type="hidden" value="{{$course_enrollment->user->id}}">
                </div>
                <div class="mb-0 form-group clearfix">
                  <div class="icheck-emerland d-inline">
                    <input name="status[{{$key}}]" type="checkbox" value="1" id="checkboxPresent-{{$key}}">
                    <label for="checkboxPresent-{{$key}}" style="font-weight: 500">
                      Present
                    </label>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="form-group mt-3">
            {{ Form::label('signer', 'Signer') }}
            {{ Form::select('signer', $signers, \Auth::user(), array('class' => 'form-control')) }}
        </div>
      </div>
      <div class="card-footer text-right">
        {{ Form::submit('Process', ['class' => 'btn btn-primary pull-right']) }}
      </div>
    </div>
    {{ Form::close() }}
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

    <!-- DataTables -->
    <script src="{{ asset("lte/plugins/datatables/jquery.dataTables.min.js") }}""></script>
    <script src="{{ asset("lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}""></script>
    <script src="{{ asset("lte/plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script>
    <script src="{{ asset("lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}"></script>
    <script>
        $(function () {
        $("#table1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#table2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        });
    </script>

    <script type="text/javascript">
        $(function () { $("#datepicker-date").datetimepicker({ format: "LL" }) })
    </script>
@endsection