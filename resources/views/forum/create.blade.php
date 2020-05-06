@extends('layouts.app')

@section('title')
    Create Post
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		{{ Form::open(array('route' => 'forumPosts.store', 'method'=>'POST', 'files' => true)) }}
			<div class="card">
				<div class="card-header">
					<a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-info">Back</a>
				</div>
				<div class="card-body">
					@if(!empty($errors->all()))
					<div class="alert alert-danger">
						{{ Html::ul($errors->all())}}
					</div>
					@endif
					<div class="row">
						<input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
						<input name="course_id" type="hidden" value="{{ $course->id }}">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Title</label>
								<input type="text" name="title" class="form-control" placeholder="Good Title">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Content</label>
								<textarea class="form-control" name="content" rows="6" placeholder="Write your thought here"></textarea>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label for="attachment">Attachment</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" name="attachment" class="custom-file-input" id="attachment">
										<label class="custom-file-label" for="attachment">File or image is allowed</label>
									</div>
								</div>
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