@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
@endsection

@section('title')
    Courses Management
@endsection

@section('content')
@if ($message = Session::get('success'))
	<div class="alert alert-success mt-2">
		<p>{{ $message }}</p>
	</div>
@endif

<div class="card">
	<div class="card-header">
		@can('course-create')
			<a class="btn btn-success" href="{{ route('courses.create') }}"> Create New course</a>
		@endcan
	</div>
	<div class="card-body">
		<table id="table1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="20px">No</th>
					<th>Subject</th>
					<th>Grade</th>
					<th>Author</th>
					<th>Type</th>
					<th>Status</th>
					<th>Vendor</th>
					<th>Image</th>
					<th width="162px">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($courses as $key => $course)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $course->subject->subject }}</td>
					<td>{{ $course->grade->grade }}</td>
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
					<td>{{ $course->vendor }}</td>
					<td><img src="{{ asset("storage/". $course->image) }}" class="img-fluid elevation-2" alt="Course Image" height="80" width="80"></td>
					<td>
						<a class="btn btn-primary" href="{{ route('courses.show', $course->id) }}"><i class="fa fa-eye"></i></a>
						@can('course-edit')
							<a class="btn btn-warning" href="{{ route('courses.edit', $course->id) }}"><i class="fa fa-pen"></i></a>
							<a class="btn btn-warning" href="/courses/{{$course->id}}/schedule"><i class="fas fa-calendar"></i></a>
						@endcan
						@can('course-delete')
							{!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $course->id],'style'=>'display:inline']) !!}
								<button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
							{!! Form::close() !!}
						@endcan
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
{!! $courses->render() !!}
@endsection

@section('scripts')
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
@endsection