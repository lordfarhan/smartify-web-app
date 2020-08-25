@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
@endsection

@section('title')
    {{__('common.courses.index.title')}}
@endsection

@section('content')
@if ($message = Session::get('success'))
	<div class="alert alert-success mt-2">
		<p>{{ $message }}</p>
	</div>
@endif
@if(!empty($errors->all()))
  <div class="alert alert-danger">
    {{ Html::ul($errors->all())}}
  </div>
@endif
<div class="card">
	<div class="card-header">
		@can('course-create')
      <a class="btn btn-success" href="{{ route('courses.create') }}"> {{__('common.courses.actions.create')}}</a>
    @endcan
	</div>
	<div class="card-body">
    <table id="table1" class="table table-borderless table-hover">
      <thead class="thead-light">
        <tr>
          <th width="20px">{{__('common.courses.attributes.no')}}</th>
          <th>{{__('common.courses.attributes.institution')}}</th>
          <th>{{__('common.courses.attributes.subject')}}</th>
          <th>{{__('common.courses.attributes.grade')}}</th>
          <th>{{__('common.courses.attributes.name')}}</th>
          <th>{{__('common.courses.attributes.author')}}</th>
          <th>{{__('common.courses.attributes.type')}}</th>
          <th>{{__('common.courses.attributes.status')}}</th>
          {{-- <th>{{__('common.courses.attributes.image')}}</th> --}}
          <th width="154px">{{__('common.courses.attributes.action')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($courses as $key => $course)
        <tr>
          <td>{{ ++$key}}</td>
          <td>{{ $course->institution == null ? '' : $course->institution->name }}</td>
          <td>{{ $course->subject->subject }}</td>
          <td>{{ $course->grade->grade . ' ' . $course->section }}</td>
          <td>{{ $course->name }}</td>
          <td>{{ $course->author->name }}</td>
          <td>
            @if ($course->type == '0')
              <label class="badge badge-success"><i class="fas fa-globe"></i> PUBLIC</label>
            @else
              <label class="badge badge-success"><i class="fas fa-lock"></i> PRIVATE</label>
            @endif
          </td>
          <td>
            @if ($course->status == '0')
              <label class="badge badge-warning"><i class="fas fa-folder"></i> DRAFT</label>
            @else
              <label class="badge badge-success"><i class="fas fa-upload"></i> PUBLISHED</label>
            @endif
          </td>
          {{-- <td><img src="{{ asset("storage/". $course->image) }}" class="img-fluid elevation-2" alt="Course Image" height="80" width="80"></td> --}}
          <td>
            <a class="btn btn-primary btn-sm elevation-2" href="{{ route('courses.show', $course->id) }}"><i class="fa fa-eye"></i></a>
            @can('course-create')
            {{Form::open(array('route' => 'courses.replicate', 'method'=>'POST', 'style'=>'display:inline'))}}
              <input name="id" type="hidden" value="{{$course->id}}">
              <button class="btn btn-primary btn-sm elevation-2" type="submit"><i class="fa fa-clone"></i></button>
            {{Form::close()}}
            @endcan
            @can('course-edit')
              <a class="btn btn-warning text-white btn-sm elevation-2" href="{{ route('courses.edit', $course->id) }}"><i class="fa fa-pen-alt"></i></a>
            @endcan
            @can('schedule-edit')
              <a class="btn btn-warning text-white btn-sm elevation-2" href="/courses/{{$course->id}}/schedule"><i class="far fa-calendar-alt"></i></a>
            @endcan
            @can('course-delete')
              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $course->id],'style'=>'display:inline']) !!}
                <button class="btn btn-danger btn-sm elevation-2" type="submit"><i class="fa fa-trash"></i></button>
              {!! Form::close() !!}
            @endcan
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
	</div>
</div>
@endsection

@section('scripts')
  <!-- DataTables -->
  <script src="{{ asset("lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
  <script src="{{ asset("lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>
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
@endsection