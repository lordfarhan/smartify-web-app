@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
@endsection

@section('title')
  {{__('common.institutions.index.title')}}
@endsection

@section('content')
  @if ($message = Session::get('success'))
    <div class="alert alert-success mt-2">
      <p>{{ $message }}</p>
    </div>
  @endif
  <div class="card">
    <div class="card-header">
      @can('grade-create')
      <a class="btn btn-success" href="{{ route('institutions.create') }}"> {{__('common.institutions.actions.create')}}</a>
      @endcan
    </div>
      <div class="card-body">
        <table id="table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th width="20px">{{__('common.institutions.attributes.no')}}</th>
              <th>{{__('common.institutions.attributes.image')}}</th>
              <th>{{__('common.institutions.attributes.name')}}</th>
              <th>{{__('common.institutions.attributes.description')}}</th>
              <th width="69px">{{__('common.institutions.attributes.action')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($institutions as $key => $institution)
              <tr>
                <td>{{ ++$key }}</td>
                <td><img src="{{ asset("storage/". $institution->image) }}" class="img-square elevation-2" alt="Institution Image" height="80" width="80"></td>
                <td>{{$institution->name}}</td>
                <td>{{$institution->description}}</td>
                <td>
                  {{-- <a class="btn btn-primary" href="{{ route('institutions.show', $institution->id) }}"><i class="fa fa-eye"></i></a> --}}
                  @can('grade-edit')
                      <a class="btn btn-warning" href="{{ route('institutions.edit', $institution->id) }}"><i class="fa fa-pen"></i></a>
                  @endcan
                  @can('grade-delete')
                      {!! Form::open(['method' => 'DELETE','route' => ['institutions.destroy', $institution->id],'style'=>'display:inline']) !!}
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
  </div>
@endsection

@section('scripts')
  <!-- DataTables -->
  <script src="{{ asset("lte/plugins/datatables/jquery.dataTables.min.js") }}""></script>
  <script src="{{ asset("lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}""></script>
  <script src="{{ asset("lte/plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script>
  <script src="{{ asset("lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}"></script>
  <script>
    $(function () {
      $("#table").DataTable({
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