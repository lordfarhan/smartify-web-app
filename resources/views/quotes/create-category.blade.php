@extends('layouts.app')

@section('title')
  {{__('common.quotes.create.title')}}
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::open(array('route' => 'quote-categories.store', 'method'=>'POST', 'files' => true)) }}
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
									{{ Form::label('name', __('common.quotes.attributes.name')) }}
									{{ Form::text('name', null, array('placeholder' => __('common.quotes.attributes.name'), 'class' => 'form-control')) }}
                </div>
                <div class="form-group">
									{{ Form::label('image', __('common.quotes.attributes.image')) }}
									{{ Form::file('image', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
									{{ Form::text('image_url', null, array('placeholder' => __('common.quotes.attributes.image') . ' URL', 'class' => 'form-control')) }}
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