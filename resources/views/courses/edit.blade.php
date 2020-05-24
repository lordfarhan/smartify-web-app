@extends('layouts.app')

@section('title')
  {{__('common.courses.edit.title')}}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      {{ Form::model($course, ['method' => 'PATCH','route' => ['courses.update', $course->id], 'files' => true]) }}
        <div class="card">
          <div class="card-header">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-info">{{__('common.courses.actions.back')}}</a>
          </div>
          <div class="card-body">
            @if(!empty($errors->all()))
            <div class="alert alert-danger">
                {{ Html::ul($errors->all())}}
            </div>
            @endif
            <div class="row">
              @if (Auth::user()->roles('master'))
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('institution_id', __('common.courses.attributes.institution')) }}
                    {{ Form::select('institution_id', $institutions, $course->institution_id, array('class' => 'form-control', 'placeholder' => __('common.courses.attributes.institution_placeholder'))) }}
                  </div>
                </div>
              @endif
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('author_id', __('common.courses.attributes.author')) }}
                  {{ Form::select('author_id', $authors, $course->author_id, array('class' => 'form-control', 'placholder' => __('common.courses.attributes.author_placeholder'))) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('subject_id', __('common.courses.attributes.subject')) }}
                  {{ Form::select('subject_id', $subjects, $course->subject_id, array('class' => 'form-control', 'placeholder' => __('common.courses.attributes.subject_placeholder'))) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('grade_id', __('common.courses.attributes.grade')) }}
                  {{ Form::select('grade_id', $grades, $course->grade_id, array('class' => 'form-control', 'placeholder' => __('common.courses.attributes.grade_placeholder'))) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('section', __('common.courses.attributes.section')) }}
                  {{ Form::text('section', $course->section, array('class' => 'form-control', 'placeholder' => __('common.courses.attributes.section_placeholder'))) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('type', __('common.courses.attributes.type')) }}
                  {{ Form::select('type', ['0' => 'Public', '1' => 'Private'], $course->type, array('class' => 'form-control', 'placeholder' => __('common.courses.attributes.type_placeholder'))) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('enrollment_key', __('common.courses.attributes.enrollment_key')) }}
                  {{ Form::text('enrollment_key', $course->enrollment_key, array('placeholder' => __('common.courses.attributes.enrollment_key_placeholder'), 'class' => 'form-control')) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('status', __('common.courses.attributes.status')) }}
                  {{ Form::select('status', ['0' => 'Draft', '1' => 'Published'], $course->status, array('class' => 'form-control', 'placeholder' => __('common.courses.attributes.status_placeholder'))) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="@if(!empty($course->image)) col-md-6 @else col-md-12 @endif">
                    <div class="form-group">
                      {{ Form::label('image', __('common.courses.attributes.image')) }}
                      {{ Form::file('image', ['class'=>'form-control']) }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    @if (!empty($course->image))
                      <div class="form-group">
                        {{ Form::label('ex_image', __('common.courses.attributes.existing_image')) }} <a class="float-right" href="/courses.delete-file/{{ $course->id }}/image">Delete</a>
                        <input name="ex_image" class="form-control" type="text" value="{{ $course->image }}" disabled>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="@if(!empty($course->attachment)) col-md-6 @else col-md-12 @endif">
                    <div class="form-group">
                      {{ Form::label('attachment', __('common.courses.attributes.attachment')) }}
                      {{ Form::file('attachment', ['class'=>'form-control']) }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    @if (!empty($course->attachment))
                      <div class="form-group">
                        {{ Form::label('ex_attachment', __('common.courses.attributes.existing_attachment')) }} <a class="float-right" href="/courses.delete-file/{{ $course->id }}/attachment">Delete</a>
                        <input name="ex_attachment" class="form-control" type="text" value="{{ $course->attachment }}" disabled>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              <div id="attachment-title-div" class="col-md-6">
                <div class="form-group">
                  {{ Form::label('attachment_title', __('common.courses.attributes.attachment_title')) }}
                  {{ Form::text('attachment_title', $course->attachment_title, array('placeholder' => __('common.courses.attributes.attachment_title_placeholder'), 'class' => 'form-control')) }}
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            {{ Form::submit(__('common.courses.actions.process'), ['class' => 'btn btn-primary pull-right']) }}
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