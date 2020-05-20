@extends('layouts.app')

@section('title')
    {{__('common.courses.show.title')}}
@endsection

@section('content')
  <div class="row">
    <div class="col-3">
      <div class="card card-primary card-outline">
        <div class="card-header">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-info">{{__('common.courses.actions.back')}}</a>
        </div>
        <div class="card-body box-profile">
          @if (!empty($course->image))
            <div class="text-center">
              <img class="img-fluid"
                  src="{{ asset("storage/". $course->image) }}"
                  alt="course profile picture">
            </div>                        
          @endif
      
          <h3 class="profile-coursename text-center">{{ $course->subject->subject . ' - ' . $course->grade->grade . ' ' . $course->grade->getEducationalStage() . ' ' . $course->section }}</h3>
      
          <p class="text-muted text-center">
            @if ($course->status == '0')
              <label class="badge badge-warning">DRAFT</label>
            @else
              <label class="badge badge-success">PUBLISHED</label>
            @endif
          </p>
      
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>{{__('common.courses.attributes.author')}}</b> <a class="float-right">{{ $course->author->name }}</a>
            </li>
            <li class="list-group-item">
              <b>{{__('common.courses.attributes.institution')}}</b> <a class="float-right">{{ $course->institution->name }}</a>
            </li>
            @foreach ($course->schedules as $index => $schedule)
              <li class="list-group-item">
                <b>@if ($index == 0)
                    {{__('common.courses.attributes.schedule')}}
                @endif</b> <a class="float-right">{{ \Carbon\Carbon::parse($schedule->date)->format('M, d Y') . ' (' .\Carbon\Carbon::parse($schedule->start_time)->format('H:i') .' - '.\Carbon\Carbon::parse($schedule->end_time)->format('H:i') . ')' }}</a>
              </li>
            @endforeach
            <li class="list-group-item">
              <b>{{__('common.courses.show.created_at')}}</b> <a class="float-right">{{ \Carbon\Carbon::parse($course->created_at)->format("M, d Y H:i:s") }}</a>
            </li>
            <li class="list-group-item">
              <b>{{__('common.courses.show.updated_at')}}</b> <a class="float-right">{{ \Carbon\Carbon::parse($course->updated_at)->format("M, d Y H:i:s") }}</a>
            </li>
          </ul>
      
          <a href="#" class="btn btn-primary btn-block"><b>{{__('common.courses.actions.open')}}</b></a>
        </div>
        <!-- /.card-body -->
      </div>
    </div>

    {{-- Course contents --}}
    <div class="col-9">
      <div class="card card">
        <div class="card-header">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#chapters" data-toggle="tab">Chapters</a></li>
            <li class="nav-item"><a class="nav-link" href="#tests" data-toggle="tab">Tests</a></li>
            <li class="nav-item"><a class="nav-link" href="#members" data-toggle="tab">Members</a></li>
            <li class="nav-item"><a class="nav-link" href="#attendances" data-toggle="tab">Attendances</a></li>
            <li class="nav-item"><a class="nav-link" href="#forum" data-toggle="tab">Forum</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">

            <div class="active tab-pane" id="chapters">

              {{-- Populating chapters and sub chapters --}}
              <div class="row">
                @if(!empty($errors->all()))
                <div class="col-md-12">
                  <div class="card alert alert-danger">
                    {{ Html::ul($errors->all())}}
                  </div>
                </div>
                @endif
                @can('chapter-list')
                  @foreach ($course->chapters as $chapter)
                    <div class="col-md-12">
                      <div class="card card-success">
                        <div class="card-header">
                          <h3 class="card-title text-bold">{{ __('common.courses.attributes.chapter'). ' ' . $chapter->chapter . ' - ' . $chapter->title }}</h3>
                          <div class="card-tools">
                            @can('chapter-edit')
                              <button type="button" data-course_id="{{ $course->id }}" data-id="{{ $chapter->id }}" data-chapter="{{ $chapter->chapter }}" data-title="{{ $chapter->title }}" data-attachment="{{ $chapter->attachment }}" data-attachment_title="{{ $chapter->attachment_title }}" class="edit-chapter-modal btn btn-tool"><i class="fas fa-pen-alt"></i></button>
                            @endcan
                            @can('chapter-delete')
                              <button type="button" data-id="{{ $chapter->id }}" class="delete-chapter-modal btn btn-tool"><i class="fas fa-trash-alt"></i></button>
                            @endcan
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="timeline">
                            <div class="time-label">
                              <span class="bg-green">{{__('common.courses.show.sub_chapters')}}</span>
                            </div>
                            @can('sub-chapter-list')
                              {{-- Populating sub chapters --}}
                              @foreach ($chapter->sub_chapters as $sub_chapter)
                                <div>
                                  <i class="fas bg-blue">{{ $sub_chapter->sub_chapter }}</i>
                                  <div class="timeline-item">
                                    {{-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> --}}
                                    <h3 class="timeline-header"><a href="#">{{ $sub_chapter->title }}</a></h3>
                  
                                    <div class="timeline-body">
                                      @if (!empty($sub_chapter->materials))
                                        <div class="embed-responsive embed-responsive-16by9">
                                          <iframe class="embed-responsive-item" src="{{$sub_chapter->materials}}" frameborder="0" allowfullscreen=""></iframe>
                                        </div>
                                      @endif
                                    </div>
                                    <div class="timeline-footer">
                                      <a class="btn btn-sm btn-primary">{{__('common.courses.actions.open')}}</a>
                                      <a class="edit-sub-chapter-modal btn btn-warning btn-sm" data-id="{{$sub_chapter->id}}" data-chapter_id="{{$chapter->id}}" data-sub_chapter="{{$sub_chapter->sub_chapter}}" data-title="{{$sub_chapter->title}}" data-materials="{{$sub_chapter->materials}}">{{__('common.courses.actions.edit')}}</a>
                                      <a class="delete-sub-chapter-modal btn btn-danger btn-sm" data-id="{{$sub_chapter->id}}">{{__('common.courses.actions.delete')}}</a>
                                    </div>
                                  </div>
                                </div>
                              @endforeach
                            @endcan
                            @can('sub-chapter-create')
                              <div>
                                <i class="fas fa-plus bg-maroon"></i>
                                <div class="timeline-item">
                                  <h3 class="timeline-header"><a href="#">{{__('common.courses.show.add_sub_chapter')}}</a></h3>
                
                                  <div class="timeline-body">
                                    {{-- Add sub chapter --}}
                                    {{ Form::open(array('route' => 'sub-chapters.store', 'method'=>'POST', 'files' => true)) }}
                                    {{ Form::hidden('chapter_id', $chapter->id) }}
                                    <div class="row">
                                      <div class="col-md-2">
                                        <div class="form-group">
                                          {{ Form::text('sub_chapter', null, array('placeholder' => __('common.courses.attributes.sub_chapter_placeholder'), 'class' => 'form-control')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-10">
                                        <div class="form-group">
                                          {{ Form::text('title', null, array('placeholder' => __('common.courses.attributes.sub_chapter_title_placeholder'), 'class' => 'form-control')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          {{ Form::text('materials', null, array('placeholder' => __('common.courses.attributes.materials_placeholder'), 'class' => 'form-control')) }}
                                        </div>
                                      </div>
                                    </div>
                                    {{-- Add sub chapter --}}
                                    <button class="btn btn-sm btn-primary col-12" type="submit"></i>{{__('common.courses.actions.process')}}</button>
                                  </div>
                                  {{ Form::close() }}
                                </div>
                              </div>
                            @endcan
                            @can('chapter-list')
                              @if (!empty($chapter->attachment))
                                <div class="time-label">
                                  <span class="bg-green">{{__('common.courses.attributes.attachment')}}</span>
                                </div>
                                <div>
                                  <i class="fas fa-paperclip bg-purple"></i>
                                  <div class="timeline-item">
                                    {{-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> --}}
                                    <h3 class="timeline-header"><a href="#">{{ $chapter->attachment_title }}</a></h3>
                  
                                    <div class="timeline-body">
                                      {{ $chapter->attachment }}
                                    </div>
                                    <div class="timeline-footer">
                                      <a href="{{asset('storage/' . $chapter->attachment)}}" class="btn btn-primary btn-sm">{{__('common.courses.actions.open')}}</a>
                                      <a data-id="{{ $chapter->id }}" class="delete-chapter-file-modal btn btn-danger btn-sm">{{__('common.courses.actions.delete')}}</a>
                                    </div>
                                  </div>
                                </div>
                              @endif
                            @endcan
                            <div>
                              <i class="fas fa-check bg-green"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endcan

              </div>
              {{-- Add Chapter Form --}}
              @can('chapter-create')
              <div id="accordion">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4 class="card-title text-center">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="text-center">
                        {{__('common.courses.show.add_chapter')}}
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="card-body">
                      {{ Form::open(array('route' => 'chapters.store', 'method'=>'POST', 'files' => true)) }}
                      {{ Form::hidden('course_id', $course->id) }}
                      <div class="row">
                        <div class="col-md-2">
                          <div class="form-group">
                            {{ Form::text('chapter', null, array('placeholder' => __('common.courses.attributes.chapter_placeholder'), 'class' => 'form-control')) }}
                          </div>
                        </div>
                        <div class="col-md-10">
                          <div class="form-group">
                            {{ Form::text('title', null, array('placeholder' => __('common.courses.attributes.chapter_title_placeholder'), 'class' => 'form-control')) }}
                          </div>
                        </div>
                        <div id="attachment-title-div" class="col-md-5">
                          <div class="form-group">
                            {{ Form::text('attachment_title', null, array('placeholder' => __('common.courses.attributes.attachment_title_placeholder'), 'class' => 'form-control')) }}
                          </div>
                        </div>
                        <div id="attachment-div" class="col-md-5">
                          <div class="form-group">
                            {{ Form::file('attachment', ['id' => 'attachment', 'class' => 'form-control']) }}
                          </div>
                        </div>
                        <div class="col-md-2">
                          <button class="btn btn-primary col-12" type="submit">{{__('common.courses.actions.process')}}</button>
                        </div>
                      </div>
                      {{ Form::close() }}
                    </div>
                  </div>
                </div>
              </div>
              @endcan
              {{-- Add Chapter Form --}}

            </div>

            <div class="tab-pane" id="tests">
              <div class="row">
                @if(!empty($errors->all()))
                <div class="col-md-12">
                  <div class="card alert alert-danger">
                    {{ Html::ul($errors->all())}}
                  </div>
                </div>
                @endif
                {{-- test list --}}
                @can('test-list')
                  @foreach ($course->tests as $test)
                    <div class="col-md-12">
                      <div class="card card-success">
                        <div class="card-header">
                          <h3 class="card-title text-bold">{{ $test->title }}</h3>
                          <div class="card-tools">
                            @can('test-edit')
                              <button type="button" data-course_id="{{ $course->id }}" data-id="{{ $test->id }}" data-order="{{$test->order}}" data-title="{{ $test->title }}" data-type="{{ $test->type }}" data-assign="{{ $test->assign }}" data-description="{{ $test->description }}" class="edit-test-modal btn btn-tool"><i class="fas fa-pen-alt"></i></button>
                            @endcan
                            @can('test-delete')
                              <button type="button" data-id="{{ $test->id }}" class="delete-test-modal btn btn-tool"><i class="fas fa-trash-alt"></i></button>
                            @endcan
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                          </div>
                        </div>
                        <div class="card-body">
                          <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                              <b>Type</b> <a class="float-right">
                                @if ($test->type == '0')
                                  {{__('common.courses.attributes.test_type_chapter')}}
                                @elseif($test->type == '1')
                                  {{__('common.courses.attributes.test_type_middle')}}
                                @else
                                  {{__('common.courses.attributes.test_type_final')}}
                                @endif</a>
                            </li>
                            <li class="list-group-item">
                              <b>{{__('common.courses.attributes.test_assign')}}</b> <a class="float-right">
                                @if ($test->assign == '0')
                                  <label class="badge badge-warning">{{__('common.courses.attributes.test_not_assigned')}}</label>
                                @else
                                  <label class="badge badge-success">{{__('common.courses.attributes.test_assigned')}}</label>
                                @endif
                              </a>
                            </li>
                            @if (!empty($test->description))
                            <li class="list-group-item">
                              <b>{{__('common.courses.attributes.description')}}</b> <a class="float-right">
                                {{$test->description}}
                              </a>
                            </li>
                            @endif
                          </ul>
                        </div>
                        <div class="card-footer">
                          <a class="btn btn-primary" href="/courses/{{$course->id}}/tests/{{$test->id}}">{{__('common.courses.actions.open')}}</a>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endcan
              </div>

              {{-- Create test --}}
              @can('test-create')
              <div id="accordion">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4 class="card-title text-center">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="text-center">
                        {{__('common.courses.show.add_test')}}
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="card-body">
                      {{ Form::open(array('route' => 'tests.store', 'method'=>'POST')) }}
                      {{ Form::hidden('course_id', $course->id) }}
                      <div class="row">
                        <div class="col-md-2">
                          <div class="form-group">
                            {{ Form::number('order', null, array('placeholder' => __('common.courses.attributes.test_order'), 'class' => 'form-control')) }}
                          </div>
                        </div>
                        <div class="col-md-10">
                          <div class="form-group">
                            {{ Form::text('title', null, array('placeholder' => __('common.courses.attributes.test_title'), 'class' => 'form-control')) }}
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {{ Form::select('type', ['0' => __('common.courses.attributes.test_type_chapter'), '1' => __('common.courses.attributes.test_type_middle'), '2' => __('common.courses.attributes.test_type_final')], null, array('class' => 'form-control', 'placeholder' => __('common.courses.attributes.test_type'))) }}
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {{ Form::select('assign', ['0' => __('common.courses.attributes.test_not_assigned'), '1' => __('common.courses.attributes.test_assigned')], null, array('class' => 'form-control')) }}
                          </div>
                        </div>
                        <div class="col-md-10">
                          <div class="form-group">
                            {{ Form::text('description', null, array('placeholder' => __('common.courses.attributes.description'), 'class' => 'form-control')) }}
                          </div>
                        </div>
                        <div class="col-md-2">
                          <button class="btn btn-primary col-12" type="submit">{{__('common.courses.actions.process')}}</button>
                        </div>
                      </div>
                      {{ Form::close() }}
                    </div>
                  </div>
                </div>
              </div>
              @endcan
            </div>

            <div class="tab-pane" id="members">
              <div class="row">
                @if(!empty($errors->all()))
                <div class="col-md-12">
                  <div class="card alert alert-danger">
                    {{ Html::ul($errors->all())}}
                  </div>
                </div>
                @endif
                @foreach ($course->enrollments as $enrollment)
                  <div class="col-md-12">
                    <div class="card card-body">
                      <div class="row">
                        <div class="col-md-1">
                          <img src="{{ asset("storage/". $enrollment->user->image) }}" class="img-fluid img-circle elevation-2" alt="User Image" height="80" width="80">
                        </div>
                        <div class="col-md-11">
                          <a href="{{route('users.show', $enrollment->user->id)}}" class="text-bold">{{ $enrollment->user->name }}</a>
                          <p>{{ $enrollment->user->phone }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="tab-pane" id="attendances">
              <div class="row">
                @if(!empty($errors->all()))
                <div class="col-md-12">
                  <div class="card alert alert-danger">
                    {{ Html::ul($errors->all())}}
                  </div>
                </div>
                @endif
                @foreach ($course->schedules as $schedule)
                  @if (count($schedule->attendances) != 0)
                    @foreach ($schedule->attendances->groupBy('date') as $date => $attendance)
                    <div class="col-md-12">
                      <div class="card card-body">
                        <div class="row">
                          <div class="col-md-2">
                            <a href="/courses/{{$course->id}}/schedules/{{$schedule->id}}/attendances">{{\Carbon\Carbon::parse($date)->format('d M Y')}}</a>
                          </div>
                          <div class="col-md-10">
                            <label class="badge badge-success">{{__('common.courses.attributes.present')}} : {{ $attendance->where('status', '1')->count() - 1}}</label>
                            <label class="badge badge-danger">{{__('common.courses.attributes.absent')}} : {{ $attendance->where('status', '0')->count() }}</label>
                            <a href="{{route('users.show', \App\User::find($attendance->last()['user_id'])->id)}}"><label class="badge badge-primary">{{__('common.courses.attributes.signer')}} : {{ \App\User::find($attendance->last()['user_id'])->name }}</label></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  @else
                    <div class="col-md-12">
                      <div class="card card-body">
                        <div class="row">
                          <div class="col-md-2">
                            <a href="/schedules/{{$schedule->id}}/attendances/create/">{{\Carbon\Carbon::parse($schedule->date)->format('d M Y')}}</a>
                          </div>
                          <div class="col-md-10">
                            <label class="badge badge-info">{{__('common.courses.attributes.not_yet_reported')}}</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>

            <div class="tab-pane" id="forum">
              <!-- Post -->
              <div class="row">
                @if(!empty($errors->all()))
                <div class="col-md-12">
                  <div class="card alert alert-danger">
                    {{ Html::ul($errors->all())}}
                  </div>
                </div>
                @endif
                @foreach ($course->forumPosts as $post)
                <div class="col-md-1">
                  <div class="card card-body p-0 card-warning card-outline text-center">
                    <p class="mb-1" style="font-size: 20px">{{$post->forumReplies->count()}}</p>
                    <p style="font-size: 10px">{{__('common.courses.attributes.votes')}}</p>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="card card-body p-0 card-success card-outline text-center">
                    <p class="mb-1" style="font-size: 20px">{{$post->forumReplies->count()}}</p>
                    <p style="font-size: 10px">{{__('common.courses.attributes.replies')}}</p>
                  </div>
                </div>
                <div class="col-md-10">
                  <a class="col-md-12" style="font-size: 28px;" href="/courses/{{$course->id}}/forum/{{$post->slug}}">
                    {{$post->title}}
                  </a>
                  <p class="col-md-12 text-right" style="font-size: 12px;">{{__('common.courses.attributes.asked_by')}} <a style="font-size: 12px;" href="{{route('users.show', $post->user->id)}}">{{$post->user->name}}</a> {{__('common.courses.attributes.on')}} {{\Carbon\Carbon::parse($post->updated_at)->format('M d, Y')}}</p>
                </div>
                @endforeach
                <div class="col-md-12">
                  <a href="/courses/{{$course->id}}/forum/create" class="col-md-12 btn btn-primary">{{__('common.courses.actions.post')}}</a>
                </div>
              </div>
              <!-- /.post -->

            </div>
          </div>
        </div><!-- /.card-body -->
      </div>
    </div>
  </div>
@endsection

@section('modals')
  <div id="chapter-edit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <form id="chapter-modal-form" action="/chapters.edit" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4>{{__('common.courses.show.edit_chapter')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <input value="" id="course-id-edit-chapter" name="course_id" type="hidden">
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <input value="" type="hidden" name="id" id="id-edit-chapter">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="chapter">{{__('common.courses.attributes.chapter')}}:</label>
                <div class="col-md-12">
                  <input value="" type="text" name="chapter" class="form-control" id="chapter-edit-chapter">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="title">{{__('common.courses.attributes.title')}}:</label>
                <div class="col-md-12">
                  <input value="" type="text" name="title" class="form-control" id="title-edit-chapter">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="attachment">{{__('common.courses.attributes.attachment')}}:</label>
                <div class="col-md-12">
                  <input value="" type="file" name="attachment" class="form-control" id="attachment-edit-chapter">
                </div>
              </div>
              <div id="existing-attachment-edit-chapter-div" class="form-group">
                <label class="control-label col-md-6" for="ex_attachment">{{__('common.courses.attributes.existing_attachment')}}:</label>
                <a id="delete-button-edit-chapter" class="btn btn-sm float-right" href="url"><i class="fas fa-times"></i></a>
                <div class="col-md-12">
                  <input value="" type="text" name="ex_attachment" class="col-md-12 form-control" id="existing-attachment-edit-chapter" disabled>
                </div>
              </div>
              <div id="attachment-title-edit-chapter-div" class="form-group">
                <label class="control-label col-md-12" for="attachment_title">{{__('common.courses.attributes.attachment_title')}}:</label>
                <div class="col-md-12">
                  <input value="" type="text" name="attachment_title" class="form-control" id="attachment-title-edit-chapter">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.courses.actions.cancel')}}</button>
            <button type="submit" class="btn btn-primary btn-edit-chapter">{{__('common.courses.actions.process')}}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div id="chapter-delete-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <form id="chapter-modal-form" action="/chapters.delete" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4>{{__('common.courses.show.be_careful')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            {{__('common.courses.show.be_careful_msg')}}
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <div class="col-sm-10">
                  <input value="" type="hidden" name="id" id="id-delete-chapter">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.courses.actions.cancel')}}</button>
            <button type="submit" class="btn btn-danger btn-edit-chapter">{{__('common.courses.actions.delete')}}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div id="chapter-file-delete-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <form id="chapter-modal-form" action="/chapters.delete-file" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4>{{__('common.courses.show.be_careful')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            {{__('common.courses.show.be_careful_msg')}}
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <div class="col-sm-10">
                  <input value="" type="hidden" name="id" id="id-delete-file-chapter">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.courses.actions.cancel')}}</button>
            <button type="submit" class="btn btn-danger btn-edit-chapter">{{__('common.courses.actions.delete')}}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div id="test-edit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <form id="test-modal-form" action="/tests.edit" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4>{{__('common.courses.show.edit_test')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <input value="" id="course-id-edit-test" name="course_id" type="hidden">
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <input value="" type="hidden" name="id" id="id-edit-test">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="order">{{__('common.courses.attributes.test_order')}}:</label>
                <div class="col-md-12">
                  <input value="" type="number" name="order" class="form-control" id="order-edit-test">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="title">{{__('common.courses.attributes.title')}}:</label>
                <div class="col-md-12">
                  <input value="" type="text" name="title" class="form-control" id="title-edit-test">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="type">{{__('common.courses.attributes.type')}}:</label>
                <div class="col-md-12">
                  {{Form::select('type', ['0' => 'Chapter Test', '1' => 'Mid Test', '2' => 'Final Test'], null, array('id' => 'type-edit-test', 'class' => 'form-control'))}}
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="assign">{{__('common.courses.attributes.test_assign')}}:</label>
                <div class="col-md-12">
                  {{Form::select('assign', ['0' => 'Not Assigned', '1' => 'Assigned'], null, array('id' => 'assign-edit-test', 'class' => 'form-control'))}}
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="description">{{__('common.courses.attributes.description')}}:</label>
                <div class="col-md-12">
                  <input value="" type="text" name="description" class="form-control" id="description-edit-test">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.courses.actions.cancel')}}</button>
            <button type="submit" class="btn btn-primary btn-edit-chapter">{{__('common.courses.actions.process')}}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div id="test-delete-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <form id="test-modal-form" action="/tests.delete" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4>{{__('common.courses.show.be_careful')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            {{__('common.courses.show.be_careful_msg')}}
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <div class="col-sm-10">
                  <input value="" type="hidden" name="id" id="id-delete-test">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.courses.actions.cancel')}}</button>
            <button type="submit" class="btn btn-danger btn-edit-chapter">{{__('common.courses.actions.delete')}}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div id="sub-chapter-edit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <form id="sub-chapter-modal-form" action="/sub-chapters.edit" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4>{{__('common.courses.show.edit_sub_chapter')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <input value="" id="chapter-id-edit-sub-chapter" name="chapter_id" type="hidden">
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <input value="" type="hidden" name="id" id="id-edit-sub-chapter">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="sub_chapter">{{__('common.courses.attributes.sub_chapter')}}:</label>
                <div class="col-md-12">
                  <input value="" type="text" name="sub_chapter" class="form-control" id="chapter-edit-sub-chapter">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-12" for="title">{{__('common.courses.attributes.title')}}:</label>
                <div class="col-md-12">
                  <input value="" type="text" name="title" class="form-control" id="title-edit-sub-chapter">
                </div>
              </div>
              <div id="attachment-title-edit-chapter-div" class="form-group">
                <label class="control-label col-md-2" for="materials">{{__('common.courses.attributes.materials')}}:</label>
                <div class="col-md-12">
                  <input value="" type="text" name="materials" class="form-control" id="materials-edit-sub-chapter">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.courses.actions.cancel')}}</button>
            <button type="submit" class="btn btn-primary btn-edit-sub-chapter">{{__('common.courses.actions.process')}}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div id="sub-chapter-delete-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <form id="sub-chapter-modal-form" action="/sub-chapters.delete" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4>{{__('common.courses.show.be_careful')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            {{__('common.courses.show.be_careful_msg')}}
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <div class="col-sm-10">
                  <input value="" type="hidden" name="id" id="id-delete-sub-chapter">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">{{__('common.courses.actions.cancel')}}</button>
            <button type="submit" class="btn btn-danger btn-edit-chapter">{{__('common.courses.actions.delete')}}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    // Edit Data (Modal and function edit data)
    var ex_attachment = document.getElementById('existing-attachment-edit-chapter-div');
    var attachment_title = document.getElementById('attachment-title-edit-chapter-div')
    $(document).on('click', '.edit-chapter-modal', function() {
      $("#delete-button-edit-chapter").attr("href", "/chapters.delete-file/" + $(this).data('id'));
      $('#course-id-edit-chapter').val($(this).data('course_id'));
      $('#id-edit-chapter').val($(this).data('id'));
      $('#chapter-edit-chapter').val($(this).data('chapter'));
      $('#title-edit-chapter').val($(this).data('title'));
      $('#attachment-title-edit-chapter').val($(this).data('attachment_title'));
      $('#existing-attachment-edit-chapter').val($(this).data('attachment'));
      if ($(this).data('attachment') === "") {
        ex_attachment.style.display = "none";
      }
      $('#chapter-edit-modal').modal('show');
    });

    function checkAttachmentEdit() {
      if (document.getElementById("attachment-edit-chapter").files.length == 0 ){
        attachment_title.style.display = "none";
      } else {
        attachment_title.style.display = "block";
      }
    }

    // Delete chapter modal
    $(document).on('click', '.delete-chapter-modal', function() {
      $('#id-delete-chapter').val($(this).data('id'));
      $('#chapter-delete-modal').modal('show');
    });

    // Delete chapter attachment
    $(document).on('click', '.delete-chapter-file-modal', function() {
      $('#id-delete-file-chapter').val($(this).data('id'));
      $('#chapter-file-delete-modal').modal('show');
    });

    // Edit test modal
    $(document).on('click', '.edit-test-modal', function() {
      $('#course-id-edit-test').val($(this).data('course_id'));
      $('#id-edit-test').val($(this).data('id'));
      $('#order-edit-test').val($(this).data('order'));
      $('#title-edit-test').val($(this).data('title'));
      $('#type-edit-test').val($(this).data('type'));
      $('#assign-edit-test').val($(this).data('assign'));
      $('#description-edit-test').val($(this).data('description'));
      $('#test-edit-modal').modal('show');
    });

    // Delete chapter modal
    $(document).on('click', '.delete-test-modal', function() {
      $('#id-delete-test').val($(this).data('id'));
      $('#test-delete-modal').modal('show');
    });

    // Edit sub chapter modal
    $(document).on('click', '.edit-sub-chapter-modal', function() {
      $('#chapter-id-edit-sub-chapter').val($(this).data('chapter_id'));
      $('#id-edit-sub-chapter').val($(this).data('id'));
      $('#chapter-edit-sub-chapter').val($(this).data('sub_chapter'));
      $('#title-edit-sub-chapter').val($(this).data('title'));
      $('#materials-edit-sub-chapter').val($(this).data('materials'));
      $('#sub-chapter-edit-modal').modal('show');
    });

    // Delete sub chapter modal
    $(document).on('click', '.delete-sub-chapter-modal', function() {
      $('#id-delete-sub-chapter').val($(this).data('id'));
      $('#sub-chapter-delete-modal').modal('show');
    });
  </script>

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
      var y = document.getElementById("attachment-div");
      if (document.getElementById("attachment").files.length == 0 ){
        x.style.display = "none";
        y.classList.remove('col-md-5');
        y.classList.add('col-md-10');
      } else {
        x.style.display = "block";
        y.classList.remove('col-md-10');
        y.classList.add('col-md-5');
      }
    };
  </script>
@endsection