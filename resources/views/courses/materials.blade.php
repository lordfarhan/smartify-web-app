@extends('layouts.app')

@section('title')
  {{$sub_chapter->title . " - " . __('common.courses.show.materials')}}
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
<div class="row">
  <div class="col-md-12">
    <div class="timeline">
      <div class="time-label">
        <span class="bg-green">{{__('common.courses.show.materials')}}</span>
      </div>
      @can('material-list')
        {{-- Populating sub chapters --}}
        @foreach ($sub_chapter->materials->sortBy('order') as $material)
          <div>
            <i class="fas bg-blue">{{ $material->order }}</i>
            <div class="timeline-item">
              {{-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> --}}
              <h3 class="timeline-header"><a>{{__('common.courses.attributes.material_order') . " " . $material->order }}</a></h3>

              <div class="timeline-body">
                {!! $material->content !!}
              </div>

              <div class="timeline-footer bg-light">
                <button type="button" class="edit-material btn btn-warning btn-sm text-white mr-2" data-id="{{$material->id}}" data-order="{{$material->order}}" data-content="{{$material->content}}">{{__('common.courses.actions.edit')}}</a>
                <button type="button" class="delete-material btn btn-danger btn-sm" data-id="{{ $material->id }}">{{__('common.courses.actions.delete')}}</button>
              </div>
            </div>
          </div>
        @endforeach
      @endcan
      @can('material-create')
        <div>
          <i class="fas fa-plus bg-maroon"></i>
          <div class="timeline-item">
            <h3 class="timeline-header"><a href="#">{{__('common.courses.actions.add')}}</a></h3>

            <div class="timeline-body">
              {{-- Add sub chapter --}}
              {{ Form::open(array('route' => 'materials.store', 'method'=>'POST')) }}
              {{ Form::hidden('sub_chapter_id', $sub_chapter->id) }}
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::number('order', null, array('placeholder' => __('common.courses.attributes.material_order'), 'class' => 'form-control')) }}
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <textarea name="content" id="content" cols="30" rows="10"></textarea>
                  </div>
                </div>
              </div>
              {{-- Add sub chapter --}}
              <button class="btn btn-sm btn-primary col-12" type="submit"></i>{{__('common.courses.actions.process')}}</button>
            </div>
            {{ Form::close() }}
          </div>
        </div>
      @endcan
      <div>
        <i class="fas fa-check bg-green"></i>
      </div>
    </div>
  </div>
</div>
@endsection

@section('modals')
  <div id="material-delete-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      {{Form::open(array('route' => 'materials.delete', 'method' => 'POST'))}}
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4>{{__('common.courses.show.be_careful')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            {{__('common.courses.show.be_careful_msg')}}
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <div class="col-sm-10">
                  <input value="" type="hidden" name="id" id="id-delete-material">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.courses.actions.cancel')}}</button>
            <button type="submit" class="btn btn-danger">{{__('common.courses.actions.delete')}}</button>
          </div>
        </div>
      {{Form::close()}}
    </div>
  </div>

  <div id="material-edit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
      {{Form::open(array('route' => 'materials.update', 'method' => 'POST'))}}
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h4>{{__('common.courses.actions.edit')}}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <div class="col-sm-12">
                <input value="" type="hidden" name="id" id="id-edit-material">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-12" for="order-edit-material">{{__('common.courses.attributes.material_order')}}:</label>
              <div class="col-md-12">
                <input value="" type="number" name="order" class="form-control" id="order-edit-material">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-12" for="content">{{__('common.courses.attributes.material_content')}}:</label>
              <div class="col-md-12">
                <textarea name="content" id="content-edit-material" cols="30" rows="10"></textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.courses.actions.cancel')}}</button>
          <button type="submit" class="btn btn-primary btn-edit-sub-chapter">{{__('common.courses.actions.process')}}</button>
        </div>
      </div>
      {{Form::close()}}
    </div>
  </div>
@endsection

@section('scripts')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
  CKEDITOR.replace( 'content', options );
  CKEDITOR.replace( 'content-edit-material', options );

  // Delete material modal
  $(document).on('click', '.delete-material', function() {
    $('#id-delete-material').val($(this).data('id'));
    $('#material-delete-modal').modal('show');
  });

  // Update material
  $(document).on('click', '.edit-material', function() {
    $('#id-edit-material').val($(this).data('id'));
    $('#order-edit-material').val($(this).data('order'));
    CKEDITOR.instances['content-edit-material'].setData($(this).data('content'));
    $('#material-edit-modal').modal('show');
  })
</script>
@endsection