@extends('layouts.app')

@section('title')
    Edit Post
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		{{ Form::model($forumPost, ['method' => 'PATCH','route' => ['forumPosts.update', $forumPost->id], 'files' => true]) }}
			<div class="card">
				<div class="card-header">
					<a href="{{ route('courses.show', $forumPost->course->id) }}" class="btn btn-outline-info">Back</a>
				</div>
				<div class="card-body">
					@if(!empty($errors->all()))
					<div class="alert alert-danger">
						{{ Html::ul($errors->all())}}
					</div>
					@endif
					<div class="row">
						<input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
						<input name="course_id" type="hidden" value="{{ $forumPost->course->id }}">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Title</label>
								<input type="text" name="title" value="{{$forumPost->title}}" class="form-control" placeholder="Good Title">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Content</label>
								<textarea class="form-control" name="content" rows="6" placeholder="Write your thought here">{{$forumPost->content}}</textarea>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label for="attachment">Attachment (leave empty if you make no change)</label>
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