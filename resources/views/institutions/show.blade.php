@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
@endsection

@section('title')
    {{__('common.institutions.show.title')}}
@endsection

@section('content')
  @if ($message = Session::get('success'))
  <div class="alert alert-success mt-2">
    <p>{{ $message }}</p>
  </div>
  @endif
  @if ($message = Session::get('error'))
  <div class="alert alert-danger mt-2">
    <p>{{ $message }}</p>
  </div>
  @endif
  <div class="card">
    <div class="card-header">
      <button class="btn btn-success btn-import-key"> {{__('common.institutions.actions.import')}}</button>
    </div>
    <div class="card-body">
      <table id="table" class="table table-borderless table-hover">
        <thead class="thead-light" >
          <tr>
            <th width="20px">{{__('common.institutions.attributes.no')}}</th>
            <th>{{__('common.institutions.attributes.code')}}</th>
            <th>{{__('common.institutions.attributes.is_activated')}}</th>
            <th>{{__('common.institutions.attributes.activated_by')}}</th>
            <th width="20px">{{__('common.institutions.attributes.action')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($activation_codes as $index => $code)
            <tr>
              <td>{{$index++}}</td>
              <td>{{$code->code}}</td>
              <td>@if ($code->user_id == null)
                <i class="text-danger fas fa-times-circle"></i>
              @else
                <i class="text-success fas fa-check-circle"></i>
              @endif</td>
              <td>@if ($code->user_id != null)
                <a href="{{route('users.show', $code->user->id)}}" class="text-bold">{{$code->user->name}}</a></td>
              @endif
              <td>
                <form action="/institutions/remove-activation-code" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{$code->id}}">
                  <button class="btn btn-sm btn-danger elevation-2" type="submit"><i class="fa fa-trash-alt"></i></button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('modals')
<div id="import-keys-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form id="import-keys-modal-form" action="/institutions/add-activation-code" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h4>{{__('common.institutions.actions.import')}}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          {{__('common.institutions.show.add_from_file')}}
          <input type="file" name="file" class="form-control">
          <br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">{{__('common.institutions.actions.cancel')}}</button>
          <button type="submit" class="btn btn-success btn-edit-chapter">{{__('common.institutions.actions.import')}}</button>
        </div>
      </div>
    </form>
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

    $(document).on('click', '.btn-import-key', function () {
      $('#import-keys-modal').modal('show');
    })
  </script>
@endsection