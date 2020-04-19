@extends('layouts.app')

@section('title')
    Create Institution
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::open(array('route' => 'institutions.store', 'method'=>'POST', 'files' => true)) }}
				<div class="card">
					<div class="card-header">
						<a href="{{ route('institutions.index') }}" class="btn btn-outline-info">Back</a>
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
									{{ Form::label('name', 'Name') }}
									{{ Form::text('name', null, array('placeholder' => 'Codeiva Edu','class' => 'form-control')) }}
								</div>
								<div class="form-group">
									{{ Form::label('description', 'Description') }}
									{{ Form::text('description', null, array('placeholder' => 'Optional information about institution','class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
									{{ Form::label('image', 'Image') }}
									{{ Form::file('image', ['class'=>'form-control']) }}
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer text-right">
						{{ Form::submit('Process', ['class' => 'btn btn-primary pull-right']) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@endsection