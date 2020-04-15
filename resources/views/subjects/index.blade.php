@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
@endsection

@section('title')
    Subjects Management
@endsection

@section('content')
@if ($message = Session::get('success'))
	<div class="alert alert-success mt-2">
		<p>{{ $message }}</p>
	</div>
@endif

<div class="card">
	<div class="card-header">
		@can('subject-create')
			<a class="btn btn-success" href="{{ route('subjects.create') }}"> Create New subject</a>
		@endcan
	</div>
	<div class="card-body">
		<table id="table1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="20px">No</th>
					<th>Name</th>
					<th>Information</th>
					<th width="117px">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($subjects as $key => $subject)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $subject->subject }}</td>
					<td>{{ $subject->information }}</td>
					<td>
						<a class="btn btn-primary" href="{{ route('subjects.show', $subject->id) }}"><i class="fa fa-eye"></i></a>
						@can('subject-edit')
							<a class="btn btn-warning" href="{{ route('subjects.edit', $subject->id) }}"><i class="fa fa-pen"></i></a>
						@endcan
						@can('subject-delete')
							{!! Form::open(['method' => 'DELETE','route' => ['subjects.destroy', $subject->id],'style'=>'display:inline']) !!}
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
{!! $subjects->render() !!}
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