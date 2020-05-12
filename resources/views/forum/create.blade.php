@extends('layouts.app')

@section('title')
    {{__('common.forum.create.title')}}
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		{{ Form::open(array('route' => 'forumPosts.store', 'method'=>'POST', 'files' => true)) }}
			<div class="card">
				<div class="card-header">
					<a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-info">{{__('common.forum.actions.back')}}</a>
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
								<label>{{__('common.forum.attributes.title')}}</label>
								<input type="text" name="title" class="form-control" placeholder="{{__('common.forum.attributes.title_placeholder')}}">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>{{__('common.forum.attributes.content')}}</label>
								<textarea class="form-control" name="content" rows="6" placeholder="{{__('common.forum.attributes.content_placeholder')}}"></textarea>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label for="attachment">{{__('common.forum.attributes.attachment')}}</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" name="attachment" class="custom-file-input" id="attachment">
										<label class="custom-file-label" for="attachment">{{__('common.forum.attributes.attachment_placeholder')}}</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-right">
					{{ Form::submit(__('common.forum.actions.process'), ['class' => 'btn btn-primary pull-right']) }}
				</div>
			</div>
		{{ Form::close() }}
	</div>
</div>
@endsection