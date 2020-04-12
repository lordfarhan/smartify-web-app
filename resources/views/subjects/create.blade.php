@extends('layouts.app')

@section('title')
    Create Subject
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			{{ Form::open(array('route' => 'subjects.store','method'=>'POST')) }}
				<div class="card">
					<div class="card-header">
						<a href="{{ route('subjects.index') }}" class="btn btn-outline-info">Back</a>
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
									{{ Form::label('subject', 'Subject') }}
									{{ Form::text('subject', null, array('placeholder' => 'Pendidikan Informatika','class' => 'form-control')) }}
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