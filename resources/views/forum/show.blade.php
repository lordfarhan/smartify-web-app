@extends('layouts.app')

@section('title')

@endsection

@section('content')
	<div class="row">
		@if(!empty($errors->all()))
		<div class="col-md-12">
			<div class="card alert alert-danger">
				{{ Html::ul($errors->all())}}
			</div>
		</div>
		@endif
		<div class="col-md-12">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<a href="{{ route('courses.show', $forumPost->course->id) }}" class="btn btn-outline-info">{{__('common.forum.actions.back')}}</a>
				</div>
				<div class="card-body">
					<h3>{{$forumPost->title}}</h3>
					<p>{{$forumPost->content}}</p>
					@if ($forumPost->attachment != null)
						@if (File::extension($forumPost->attachment) == 'jpg' || File::extension($forumPost->attachment) == 'png' || File::extension($forumPost->attachment) == 'jpeg' || File::extension($forumPost->attachment) == 'JPG')
							<img src="{{ asset("storage/". $forumPost->attachment) }}" class="img-fluid elevation-2 mb-3" alt="Forum Post Image">
						@else
						<div class="card card-body p-2">
							<a style="font-size: 14px;" href="{{asset("storage/". $forumPost->attachment)}}">{{__('common.forum.actions.download')}} <i class="fas fa-download"></i></a>
						</div>
						@endif
					@endif
					<div class="row">
						<div class="col-sm-6">
							@if (Auth::user()->id == $forumPost->user_id)
								<a class="text-info" style="font-size: 12px;" href="/courses/{{$forumPost->course->id}}/forum/{{$forumPost->slug}}/edit">{{__('common.forum.actions.edit')}}</a>
								<a class="text-danger" style="font-size: 12px;" href="/courses/{{$forumPost->course->id}}/forum/{{$forumPost->slug}}/delete">{{__('common.forum.actions.delete')}}</a>
							@endif
						</div>
						<div class="col-sm-6">
							<p class="text-right mb-1" style="font-size: 12px;">{{__('common.forum.show.asked_by')}} <a style="font-size: 12px;" href="{{route('users.show', $forumPost->user->id)}}">{{$forumPost->user->name}}</a> {{__('common.forum.show.on')}} {{\Carbon\Carbon::parse($forumPost->updated_at)->format('M d, Y')}}{{$forumPost->created_at == $forumPost->updated_at ? '' : ' - ' . __('common.forum.show.edited') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			@foreach ($forumPost->forumReplies->whereNull('forum_reply_id') as $reply)
				<div class="card">
					<div class="card-body">
						<p>{{$reply->content}}</p>
						@if ($reply->attachment != null)
							@if (File::extension($reply->attachment) == 'jpg' || File::extension($reply->attachment) == 'png' || File::extension($reply->attachment) == 'jpeg' || File::extension($reply->attachment) == 'JPG')
								<img src="{{ asset("storage/". $reply->attachment) }}" class="img-fluid elevation-2 mb-3" alt="Forum Reply Image">
							@else
							<div class="card card-body p-2">
								<a style="font-size: 14px;" href="{{asset("storage/". $reply->attachment)}}">{{__('common.forum.actions.download')}} <i class="fas fa-download"></i></a>
							</div>
							@endif
						@endif
						<div class="row">
							<div class="col-sm-6">
								@if (Auth::user()->id == $reply->user_id)
									<a class="text-danger" style="font-size: 12px;" href="/courses/{{$forumPost->course->id}}/forum/{{$forumPost->slug}}/replies/{{$reply->id}}/delete">{{__('common.forum.actions.delete')}}</a>
								@endif
							</div>
							<div class="col-sm-6">
								<p class="text-right mb-1" style="font-size: 12px;">{{__('common.forum.show.replied_by')}} <a style="font-size: 12px;" href="{{route('users.show', $reply->user->id)}}">{{$reply->user->name}}</a> {{__('common.forum.show.on')}} {{\Carbon\Carbon::parse($reply->updated_at)->format('M d, Y')}}{{$reply->created_at == $reply->updated_at ? '' : ' - ' . __('common.forum.show.edited')}}</p>
							</div>
						</div>
					</div>
					<div class="card-footer" style="background-color: #f8f8f8">
						<div class="col-sm-12">
							@if ($reply->forumReplies->count() > 0)								
							<ul class="list-group list-group-unbordered mb-2">
								@foreach ($reply->forumReplies as $childReply)
									<li class="list-group-item" style="background-color: #f8f8f8">
										<p class="ml-4 mb-0" style="font-size: 14px;">{{$childReply->content}} - <a style="font-size: 12px;" href="{{route('users.show', $childReply->user->id)}}">{{$childReply->user->name}}</a> {{__('common.forum.show.on')}} {{\Carbon\Carbon::parse($childReply->updated_at)->format('M d, Y')}}{{$childReply->created_at == $childReply->updated_at ? '' : ' - ' . __('common.forum.show.edited')}}
										@if (Auth::user()->id == $childReply->user_id)
											<a class="text-danger" style="font-size: 12px;" href="/courses/{{$forumPost->course->id}}/forum/{{$forumPost->slug}}/replies/{{$childReply->id}}/delete">{{__('common.forum.actions.delete')}}</a>
										@endif
										</p>
									</li>
								@endforeach
							</ul>
							@endif
						</div>
						<a href="#" class="btn-reply-modal mr-2" data-user_id="{{Auth::user()->id}}" data-forum_post_id="{{$forumPost->id}}" data-forum_reply_id="{{$reply->id}}" style="float: right;">{{__('common.forum.actions.reply')}}</a>
					</div>
				</div>
			@endforeach
		</div>
				
		<div class="col-md-12 mt-3 mb-3">
			<h5 class="ml-1">{{__('common.forum.show.replies')}}</h5>
			{{Form::open(array('route' => 'forumReplies.store', 'method'=>'POST', 'files' => true))}}
			<div class="row">
				<input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
				<input name="forum_post_id" type="hidden" value="{{ $forumPost->id }}">
				<div class="col-sm-12">
					<div class="form-group">
						<textarea class="form-control" name="content" rows="6" placeholder="{{__('common.forum.attributes.reply_placeholder')}}"></textarea>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<div class="input-group">
							<div class="custom-file">
								<input type="file" name="attachment" class="custom-file-input" id="attachment">
								<label class="custom-file-label" for="attachment">{{__('common.forum.attributes.attachment_placeholder')}}</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					{{ Form::submit(__('common.forum.actions.reply'), ['class' => 'btn btn-primary pull-right']) }}
				</div>
			</div>
			{{Form::close()}}
		</div>
	</div>
@endsection

@section('modals')
	<div id="reply-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
			{{Form::open(array('route' => 'forumReplies.store', 'method'=>'POST', 'files' => true))}}
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4>{{__('common.forum.attributes.reply')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
						<div class="row">
							<input name="user_id" id="id-user-reply-modal" type="hidden" value="">
							<input name="forum_post_id" id="id-forum-post-reply-modal" type="hidden" value="">
							<input name="forum_reply_id" id="id-forum-reply-reply-modal" type="hidden" value="">
							<div class="col-sm-12">
								<div class="form-group">
									<textarea class="form-control" name="content" rows="6" placeholder="{{__('common.forum.attributes.reply_placeholder')}}"></textarea>
								</div>
							</div>
						</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.forum.actions.cancel')}}</button>
            <button type="submit" class="btn btn-primary btn-edit-chapter">{{__('common.forum.actions.reply')}}</button>
          </div>
				</div>
			{{Form::close()}}
    </div>
  </div>
@endsection

@section('scripts')
		<script type="text/javascript">
			$(document).on('click', '.btn-reply-modal', function() {
				$('#id-user-reply-modal').val($(this).data('user_id'));
				$('#id-forum-post-reply-modal').val($(this).data('forum_post_id'));
				$('#id-forum-reply-reply-modal').val($(this).data('forum_reply_id'));
				$('#reply-modal').modal('show');
			});
		</script>
@endsection