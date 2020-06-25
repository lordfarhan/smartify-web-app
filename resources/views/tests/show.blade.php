@extends('layouts/app')

@section('title')
  {{__('common.tests.show.title')}}
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<a href="{{ route('courses.show', $course_id) }}" class="btn btn-outline-info">{{__('common.tests.actions.back')}}</a>
				</div>
				<div class="card-body">
					<h3 class="profile-coursename text-center">{{ $test->title }}</h3>
      
          <p class="text-muted text-center">
            @if ($test->assign == '0')
              <label class="badge badge-warning">{{__('common.tests.attributes.test_not_assigned')}}</label>
            @else
              <label class="badge badge-success">{{__('common.tests.attributes.test_assigned')}}</label>
            @endif
          </p>
					<ul class="list-group list-group-unbordered mb-3">
						<li class="list-group-item">
							<b>Type</b> <a class="float-right">
								@if ($test->type == '0')
									{{__('common.tests.attributes.test_type_chapter')}}
								@elseif($test->type == '1')
                {{__('common.tests.attributes.test_type_middle')}}
								@else
                {{__('common.tests.attributes.test_type_final')}}
								@endif</a>
						</li>
						@if (!empty($test->description))
						<li class="list-group-item">
							<b>{{__('common.tests.attributes.description')}}</b> <a class="float-right">
								{{$test->description}}
							</a>
						</li>
						@endif
					</ul>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					@if(!empty($errors->all()))
						<div class="alert alert-danger">
							{{ Html::ul($errors->all())}}
						</div>
					@endif
					<div class="timeline">
						<div class="time-label">
							<span class="bg-green">{{__('common.tests.show.questions')}}</span>
						</div>
						@can('question-list')
							@foreach ($questions as $question)
								<div>
									<i class="fas bg-blue">{{ $question->order }}</i>
									<div class="timeline-item">
										<h3 class="timeline-header"><a href="#">{{ $question->question }}</a></h3>
	
										<div class="timeline-body">
											@if (!empty($question->question_image))
												<img class="img-fluid" src="{{asset('storage/' . $question->question_image)}}" alt="#">
											@endif
											<ul class="list-group list-group-unbordered mb-3">
												<li class="list-group-item">
													<b>{{__('common.tests.attributes.correct_answer')}}</b> <a class="text-success float-right">{{ $question->correct_answer }}</a>
												</li>
												@foreach (explode("; ", ltrim($question->incorrect_answers)) as $index => $incorrect_answer)
													<li class="list-group-item">
														<b>@if ($index == 0)
															{{__('common.tests.attributes.incorrect_answers')}}
														@endif</b> <a class="text-danger float-right">{{ $incorrect_answer }}</a>
													</li>
												@endforeach
											</ul>
										</div>
										<div class="timeline-footer">
											@can('question-edit')										
												<a class="btn btn-warning btn-sm" href="{{route('questions.edit', $question->id)}}">{{__('common.tests.actions.edit')}}</a>
											@endcan
											@can('question-delete')
												<a class="delete-question-modal btn btn-danger btn-sm" data-id="{{$question->id}}">{{__('common.tests.actions.delete')}}</a>
											@endcan
										</div>
									</div>
								</div>
							@endforeach
						@endcan
						@can('question-create')
							<div>
								<i class="fas fa-plus bg-maroon"></i>
								<div class="timeline-item">
									<h3 class="timeline-header"><a href="#">{{__('common.tests.show.add_question')}}</a></h3>

									<div class="timeline-body">
										{{-- Add sub chapter --}}
										{{ Form::open(array('route' => 'questions.store', 'method'=>'POST', 'files' => true)) }}
										{{ Form::hidden('test_id', $test->id) }}
										<div class="row">
											<div class="col-md-2">
												<div class="form-group">
													{{ Form::number('order', null, array('placeholder' => __('common.tests.attributes.order_placeholder'), 'class' => 'form-control')) }}
												</div>
											</div>
											<div class="col-md-10">
												<div class="form-group">
													{{ Form::text('question', null, array('placeholder' => __('common.tests.attributes.question_placeholder'), 'class' => 'form-control')) }}
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">{{__('common.tests.attributes.question_image_placeholder')}}</label>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_audio" class="custom-file-input" id="question_audio">
														<label class="custom-file-label" for="question_audio">{{__('common.tests.attributes.question_audio_placeholder')}}</label>
													</div>
												</div>
											</div>
											<div class="col-md-12 ml-1">
												<label for="">{{__('common.tests.attributes.correct_answer')}}</label>
											</div>
											{{-- Correct answer --}}
											<div class="col-md-12">
												<div class="form-group">
													{{ Form::text('correct_answer', null, array('placeholder' => __('common.tests.attributes.correct_answer_placeholder'), 'class' => 'form-control')) }}
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<div class="custom-control custom-radio">
														<input class="custom-control-input" type="radio" id="multiple" name="type" value="multiple" onclick="checkType()" checked>
														<label for="multiple" class="custom-control-label">{{__('common.tests.attributes.multiple_choice')}}</label>
													</div>
													<div class="custom-control custom-radio">
														<input class="custom-control-input" type="radio" id="boolean" name="type" value="boolean" onclick="checkType()">
														<label for="boolean" class="custom-control-label">{{__('common.tests.attributes.true_or_false')}}</label>
													</div>
												</div>
											</div>
											{{-- <div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose image</label>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose audio</label>
													</div>
												</div>
											</div> --}}
											<div class="col-md-12 ml-1">
												<label for="">{{__('common.tests.attributes.incorrect_answers')}}</label>
											</div>
											{{-- 1st incorrect answer --}}
											<div class="col-md-12">
												<div class="form-group">
													{{ Form::text('incorrect_answer_1', null, array('id' => 'incorrect_answer_1', 'placeholder' => __('common.tests.attributes.incorrect_answer_1'), 'class' => 'form-control')) }}
												</div>
											</div>
											{{-- <div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose image</label>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose audio</label>
													</div>
												</div>
											</div> --}}
											{{-- 2nd incorrect answer --}}
											<div class="col-md-12">
												<div class="form-group">
													{{ Form::text('incorrect_answer_2', null, array('id' => 'incorrect_answer_2', 'placeholder' => __('common.tests.attributes.incorrect_answer_2'), 'class' => 'form-control')) }}
												</div>
											</div>
											{{-- <div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose image</label>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose audio</label>
													</div>
												</div>
											</div> --}}
											{{-- 3rd incorrect answer --}}
											<div class="col-md-12">
												<div class="form-group">
													{{ Form::text('incorrect_answer_3', null, array('id' => 'incorrect_answer_3', 'placeholder' => __('common.tests.attributes.incorrect_answer_3'), 'class' => 'form-control')) }}
												</div>
											</div>
											{{-- <div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose image</label>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose audio</label>
													</div>
												</div>
											</div> --}}
											{{-- 4th incorrect answer --}}
											<div class="col-md-12">
												<div class="form-group">
													{{ Form::text('incorrect_answer_4', null, array('id' => 'incorrect_answer_4', 'placeholder' => __('common.tests.attributes.incorrect_answer_4'), 'class' => 'form-control')) }}
												</div>
											</div>
											{{-- <div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose image</label>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<div class="custom-file">
														<input type="file" name="question_image" class="custom-file-input" id="question_image">
														<label class="custom-file-label" for="question_image">Choose audio</label>
													</div>
												</div>
											</div> --}}
										</div>
										{{-- Add sub chapter --}}
									</div>
									<div class="timeline-footer">
										<button class="btn btn-sm btn-primary col-12" type="submit"></i>{{__('common.tests.actions.process')}}</button>
									</div>
									{{ Form::close() }}
								</div>
							</div>
						@endcan
						<div>
							<i class="fas fa-check bg-green"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('modals')
<div id="question-delete-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form id="question-modal-form" action="/questions.delete" method="POST">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h4>{{__('common.tests.show.be_careful')}}</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					{{__('common.tests.show.be_careful_msg')}}
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-sm-10">
								<input value="" type="hidden" name="id" id="id-delete-question">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.tests.actions.cancel')}}</button>
					<button type="submit" class="btn btn-danger btn-edit-chapter">{{__('common.tests.actions.delete')}}</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		function checkType() {
			var multiple = document.getElementById("multiple");
			var boolean = document.getElementById("boolean");
			var secondIncorrectAnswer = document.getElementById("incorrect_answer_2");
			var thirdIncorrectAnswer = document.getElementById("incorrect_answer_3");
			var fourthIncorrectAnswer = document.getElementById("incorrect_answer_4");
			secondIncorrectAnswer.style.display = boolean.checked ? "none" : "block";
			thirdIncorrectAnswer.style.display = boolean.checked ? "none" : "block";
			fourthIncorrectAnswer.style.display = boolean.checked ? "none" : "block";
		}

		// Delete question modal
    $(document).on('click', '.delete-question-modal', function() {
      $('#id-delete-question').val($(this).data('id'));
      $('#question-delete-modal').modal('show');
    });
	</script>
@endsection