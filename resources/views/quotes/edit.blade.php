@extends('layouts.app')

@section('title')
  {{__('common.quotes.edit.title')}}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      {{ Form::model($quote, ['method' => 'PATCH','route' => ['quotes.update', $quote->id], 'files' => true]) }}
      <div class="card">
        <div class="card-header">
          <a href="{{ route('quotes.index') }}" class="btn btn-outline-info">{{__('common.actions.back')}}</a>
        </div>
        <div class="card-body">
          @if(!empty($errors->all()))
          <div class="alert alert-danger">
            {{ Html::ul($errors->all())}}
          </div>
          @endif
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                {{ Form::label('quote_category_id', __('common.quotes.attributes.category')) }}
                {{ Form::select('quote_category_id', $categories, $quote->quote_category_id, array('class' => 'form-control', 'placeholder' => __('common.quotes.attributes.category'))) }}
              </div>
              <div class="form-group">
                {{ Form::label('quote', __('common.quotes.attributes.quote')) }}
                {{ Form::textarea('quote', $quote->quote, array('placeholder' => __('common.quotes.attributes.quote'),'class' => 'form-control')) }}
              </div>
              <div class="form-group">
                {{ Form::label('author', __('common.quotes.attributes.author')) }}
                {{ Form::text('author', $quote->author, array('placeholder' => __('common.quotes.attributes.author'),'class' => 'form-control')) }}
              </div>
              <div class="form-group">
                {{ Form::label('image', __('common.quotes.attributes.image')) }}
                {{ Form::file('image', ['class'=>'form-control']) }}
              </div>
              <div class="form-group">
                {{ Form::text('image_url', $quote->image, array('placeholder' => __('common.quotes.attributes.image') . ' URL', 'class' => 'form-control')) }}
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          {{ Form::submit(__('common.actions.process'), ['class' => 'btn btn-primary pull-right']) }}
        </div>
      </div>
      {{ Form::close() }}
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
  CKEDITOR.replace( 'quote', options );
</script>
@endsection