@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
@endsection

@section('title')
  Musics
@endsection

@section('content')
  @if ($message = Session::get('success'))
    <div class="alert alert-success mt-2">
      <p>{{ $message }}</p>
    </div>
  @endif
  <div class="card">
    <div class="card-header">
      @can('music-create')
      <a class="btn btn-success" href="{{ route('musics.create') }}"> Create</a>
      @endcan
    </div>
    <div class="card-body">
      <table id="table" class="table table-borderless table-hover">
        <thead class="thead-light" >
          <tr>
            <th width="20px">#</th>
            <th>Cover</th>
            <th>Title</th>
            <th>Artist</th>
            <th>Year</th>
            <th width="87px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($musics as $key => $music)
            <tr>
              <td>{{ ++$key }}</td>
              <td><img src="{{ asset("storage/". $music->cover) }}" class="img-square elevation-2" alt="music cover" height="80" width="80"></td>
              <td>{{$music->title}}</td>
              <td>{{$music->artist}}</td>
              <td>{{$music->year}}</td>
              <td>
                {{-- <a class="btn btn-sm btn-primary" href="{{ route('musics.show', $music->id) }}"><i class="fa fa-key"></i></a> --}}
                @can('music-edit')
                    <a class="btn btn-sm btn-warning elevation-2 text-white" href="{{ route('musics.edit', $music->id) }}"><i class="fa fa-pen-alt"></i></a>
                @endcan
                @can('music-delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['musics.destroy', $music->id],'style'=>'display:inline']) !!}
                        <button class="btn btn-sm btn-danger elevation-2" type="submit"><i class="fa fa-trash-alt"></i></button>
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