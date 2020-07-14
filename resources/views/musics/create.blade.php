@extends('layouts.app')

@section('title')
  Create
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::open(array('route' => 'musics.store', 'method'=>'POST', 'files' => true)) }}
				<div class="card">
					<div class="card-header">
						<a href="{{ route('musics.index') }}" class="btn btn-outline-info"> Back</a>
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
									{{ Form::label('title', 'Title') }}
									{{ Form::text('title', null, array('placeholder' => 'Insert Title', 'class' => 'form-control')) }}
								</div>
								<div class="form-group">
									{{ Form::label('artist', 'Artist') }}
									{{ Form::text('artist', null, array('placeholder' => 'Insert Artist', 'class' => 'form-control')) }}
                </div>
                <div class="form-group">
									{{ Form::label('cover', 'Cover') }}
									{{ Form::file('cover', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
									{{ Form::label('url', 'Url') }}
									{{ Form::text('url', null, array('placeholder' => 'Insert Url', 'class' => 'form-control')) }}
                </div>
                <div class="form-group">
									{{ Form::label('file', 'File') }}
									{{ Form::file('file', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
									{{ Form::label('year', 'Year') }}
									{{ Form::text('year', null, array('placeholder' => 'Insert Year', 'class' => 'form-control')) }}
                </div>
                <div class="form-group">
									{{ Form::label('license', 'License') }}
									{{ Form::text('license', null, array('placeholder' => 'Insert License', 'class' => 'form-control')) }}
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