@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
@endsection

@section('title')
  {{__('common.users.index.title')}}
@endsection

@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success mt-2">
  <p>{{ $message }}</p>
</div>
@endif

<div class="card">
  <div class="card-header">
    @can('user-create')
      <a class="btn btn-success" href="{{ route('users.create') }}"> {{__('common.users.actions.create')}}</a>      
    @endcan
  </div>
  <div class="card-body">
    <table id="table1" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th width="20px">{{__('common.users.attributes.no')}}</th>
          <th>{{__('common.users.attributes.institution')}}</th>
          <th>{{__('common.users.attributes.name')}}</th>
          {{-- <th>{{__('common.users.attributes.image')}}</th> --}}
          <th>{{__('common.users.attributes.email')}}</th>
          <th>{{__('common.users.attributes.phone')}}</th>
          <th>{{__('common.users.attributes.address')}}</th>
          <th>{{__('common.users.attributes.roles')}}</th>
          <th width="117px">{{__('common.users.attributes.action')}}</th>
        </tr>
      </thead>
    
      <tbody>
        @foreach ($data as $key => $user)
          <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $user->institution->name }}</td>
            <td>{{ $user->name }}</td>
            {{-- <td><img src="{{ asset("storage/". $user->image) }}" class="img-square elevation-2" alt="User Image" height="80" width="80"></td> --}}
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->address }}</td>
            <td>
              @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                @endforeach
              @endif
            </td>
            <td>
              <a class="btn btn-primary" href="{{ route('users.show',$user->id) }}"><i class="fa fa-eye"></i></a>
              @can('user-edit')
                <a class="btn btn-warning" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-pen"></i></a>                
              @endcan
              @can('user-delete')
                {{ Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) }}
                  <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                {{ Form::close() }}
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