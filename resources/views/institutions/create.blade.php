@extends('layouts.app')

@section('title')
  {{__('common.institutions.create.title')}}
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::open(array('route' => 'institutions.store', 'method'=>'POST', 'files' => true)) }}
				<div class="card">
					<div class="card-header">
						<a href="{{ route('institutions.index') }}" class="btn btn-outline-info">{{__('common.institutions.actions.back')}}</a>
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
									{{ Form::label('name', __('common.institutions.attributes.name')) }}
									{{ Form::text('name', null, array('placeholder' => __('common.institutions.attributes.name_placeholder'), 'class' => 'form-control')) }}
								</div>
								<div class="form-group">
									{{ Form::label('description', __('common.institutions.attributes.description')) }}
									{{ Form::text('description', null, array('placeholder' => __('common.institutions.attributes.description_placeholder'), 'class' => 'form-control')) }}
                </div>
                <div class="form-group">
									{{ Form::label('image', __('common.institutions.attributes.image')) }}
									{{ Form::file('image', ['class'=>'form-control']) }}
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer text-right">
						{{ Form::submit(__('common.institutions.actions.process'), ['class' => 'btn btn-primary pull-right']) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@endsection