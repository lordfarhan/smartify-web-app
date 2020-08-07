@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
@endsection

@section('title')
  {{__('common.quotes.index.title')}}
@endsection

@section('content')
  @if ($message = Session::get('success'))
    <div class="alert alert-success mt-2">
      <p>{{ $message }}</p>
    </div>
  @endif
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          @can('quote-create')
          <a class="btn btn-success" href="{{ route('quotes.create') }}"> {{__('common.actions.create')}}</a>
          @endcan
        </div>
        <div class="card-body">
          <table id="table" class="table table-borderless table-hover">
            <thead class="thead-light" >
              <tr>
                <th width="20px">#</th>
                <th>{{__('common.quotes.attributes.category')}}</th>
                <th>{{__('common.quotes.attributes.quote')}}</th>
                <th>{{__('common.quotes.attributes.author')}}</th>
                <th>{{__('common.quotes.attributes.image')}}</th>
                <th width="87px">{{__('common.actions.action')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($quotes as $key => $quote)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{$quote->category->name}}</td>
                  <td>{!! $quote->quote !!}</td>
                  <td>{{$quote->author}}</td>
                  @if (filter_var($quote->image, FILTER_VALIDATE_URL))
                    <td><img src="{{ $quote->image }}" class="img-square elevation-2" alt="Quote Image" height="80" width="80"></td>
                  @else
                    <td><img src="{{ asset("storage/". $quote->image) }}" class="img-square elevation-2" alt="Quote Image" height="80" width="80"></td>
                  @endif
                  <td>
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('quotes.show', $quote->id) }}"><i class="fa fa-key"></i></a> --}}
                    @can('quote-edit')
                        <a class="btn btn-sm btn-warning elevation-2 text-white" href="{{ route('quotes.edit', $quote->id) }}"><i class="fa fa-pen-alt"></i></a>
                    @endcan
                    @can('quote-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['quotes.destroy', $quote->id],'style'=>'display:inline']) !!}
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
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          @can('quote-create')
          <a class="btn btn-success" href="{{ route('quote-categories.create') }}"> {{__('common.actions.create')}}</a>
          @endcan
        </div>
        <div class="card-body">
          <table id="table1" class="table table-borderless table-hover">
            <thead class="thead-light" >
              <tr>
                <th width="20px">#</th>
                <th>{{__('common.quotes.attributes.name')}}</th>
                <th>{{__('common.quotes.attributes.image')}}</th>
                <th width="87px">{{__('common.actions.action')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($quote_categories as $key => $category)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{$category->name}}</td>
                  @if (filter_var($category->image, FILTER_VALIDATE_URL))
                    <td><img src="{{ $category->image }}" class="img-square elevation-2" alt="Category Image" height="80" width="80"></td>
                  @else
                    <td><img src="{{ asset("storage/". $category->image) }}" class="img-square elevation-2" alt="Category Image" height="80" width="80"></td>
                  @endif
                  <td>
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('quoteCategories.show', $quote->id) }}"><i class="fa fa-key"></i></a> --}}
                    @can('quote-edit')
                        <a class="btn btn-sm btn-warning elevation-2 text-white" href="{{ route('quote-categories.edit', $category->id) }}"><i class="fa fa-pen-alt"></i></a>
                    @endcan
                    @can('quote-delete')
                    <a class="btn btn-sm btn-danger elevation-2 text-white" href="{{ route('quote-categories.destroy', $category->id) }}"><i class="fa fa-trash-alt"></i></a>
                    @endcan
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
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
      $("#table1").DataTable({
        "responsive": true,
        "searching": false,
        "lengthChange": false,
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