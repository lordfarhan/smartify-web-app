@extends('layouts/app')

@section('title')
  {{__('common.tests.show.title')}}
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<a href="{{ route('courses.show', $test->course_id) }}" class="btn btn-outline-info">{{__('common.tests.actions.back')}}</a>
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
          @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
              <p>{{ $message }}</p>
            </div>
          @endif
          <table id="table1" class="table table-borderless table-hover">
            <thead class="thead-light">
              <tr>
                <th width="20px">{{__('common.users.attributes.no')}}</th>
                <th>{{__('common.users.attributes.name')}}</th>
                <th width="120px">{{__('common.courses.attributes.test_mark')}}</th>
                <th width="87px">{{__('common.courses.attributes.action')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($marks as $key => $mark)
              <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $mark->user->name }}</td>
                <td>{{ floatval($mark->score/10) }}</td>
                <td>
                  <a class="delete-mark-modal btn btn-danger btn-sm" href="/courses/{{$test->course_id}}/tests/{{$test->id}}/submissions/{{$mark->id}}/delete">{{__('common.tests.actions.delete')}}</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
				</div>
			</div>
		</div>
	</div>
@endsection