@extends('layouts.app')

@section('title')
    Create Course
@endsection

@section('content')
	<div class="row" onload="checkAttachment()">
		<div class="col-12">
			{{ Form::open(array('route' => 'courses.store','method'=>'POST', 'files' => true)) }}
				<div class="card">
					<div class="card-header">
						<a href="{{ route('courses.index') }}" class="btn btn-outline-info">Back</a>
					</div>
					<div class="card-body">
						@if(!empty($errors->all()))
						<div class="alert alert-danger">
							{{ Html::ul($errors->all())}}
						</div>
						@endif
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('author_id', 'Author') }}
									{{ Form::select('author_id', $authors, null, array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('subject_id', 'Subject') }}
									{{ Form::select('subject_id', $subjects, null, array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('grade_id', 'Grade') }}
									{{ Form::select('grade_id', $grades, null, array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('type', 'Type') }}
									{{ Form::select('type', ['0' => 'Public', '1' => 'Private'], '0', array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('enrollment_key', 'Enrollment Key') }}
									{{ Form::text('enrollment_key', null, array('placeholder' => 'Leave empty if your course is public', 'class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('status', 'Status') }}
									{{ Form::select('status', ['0' => 'Draft', '1' => 'Published'], '0', array('class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('vendor', 'Vendor') }}
									{{ Form::text('vendor', 'Codeiva Edu Team', array('placeholder' => 'Codeiva Edu Team','class' => 'form-control')) }}
								</div>
							</div>
							<div id="attachment-title-div" class="col-md-6">
								<div class="form-group">
									{{ Form::label('attachment_title', 'Attachment Title') }}
									{{ Form::text('attachment_title', null, array('placeholder' => 'Course attachment title', 'class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('image', 'Image') }}
									{{ Form::file('image', ['class'=>'form-control']) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('attachment', 'Attachment') }}
									{{ Form::file('attachment', ['id' => 'attachment', 'class'=>'form-control']) }}
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

@section('scripts')
	<script type="text/javascript">
		window.onload = function() {
			checkAttachment();
		};

		$(document).ready(function(){
			$("#attachment").change(function(){
				checkAttachment();
			});
		});
		
		function checkAttachment() {
			var x = document.getElementById("attachment-title-div");
			if (document.getElementById("attachment").files.length == 0 ){
				x.style.visibility = "hidden";
			} else {
				x.style.visibility = "visible";
			}
		};
	</script>
@endsection