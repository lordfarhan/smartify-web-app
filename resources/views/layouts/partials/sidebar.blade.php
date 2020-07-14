<aside class="main-sidebar sidebar-light-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{ route('dashboard') }}" class="brand-link">
		<img src="{{ asset("lte/dist/img/AdminLTELogo.png") }}" alt="Smartify Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Smartify</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ asset("storage/". Auth::user()->image) }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">{{ Auth::user()->name }}</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
							with font-awesome or any other icon font library -->
				<li class="nav-item">
					<a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							{{__('common.sidebar.dashboard')}}
						</p>
					</a>
				</li>

				{{-- Institutes --}}
				@can('institution-list')
				<li class="nav-item">
					<a href="{{ route('institutions.index') }}" class="nav-link {{ request()->is('institutions') ? 'active' : '' }}">
						<i class="nav-icon fas fa-briefcase"></i>
						<p>
							{{__('common.sidebar.institutions')}}
						</p>
					</a>
				</li>
				@endcan

				{{-- Users --}}
				@can('user-list')
				<li class="nav-item">
					<a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
						<i class="nav-icon fas fa-user"></i>
						<p>
							{{__('common.sidebar.users')}}
						</p>
					</a>
				</li>
				@endcan

				{{-- Roles --}}
				@can('role-list')
				<li class="nav-item">
					<a href="{{ route('roles.index') }}" class="nav-link {{ request()->is('roles') ? 'active' : '' }}">
						<i class="nav-icon fas fa-users"></i>
						<p>
							{{__('common.sidebar.roles')}}
						</p>
					</a>
				</li>
				@endcan

				{{-- Academic --}}
        <li class="nav-header">{{__('common.sidebar.academic')}}</li>

        {{-- Teachers --}}
				@can('user-list')
				<li class="nav-item">
					<a href="{{ route('teachers.index') }}" class="nav-link {{ request()->is('teachers') ? 'active' : '' }}">
						<i class="nav-icon fas fa-chalkboard-teacher"></i>
						<p>
							{{__('common.sidebar.teachers')}}
						</p>
					</a>
				</li>
				@endcan

        {{-- Students --}}
				@can('user-list')
				<li class="nav-item">
					<a href="{{ route('students.index') }}" class="nav-link {{ request()->is('students') ? 'active' : '' }}">
						<i class="nav-icon fas fa-user-graduate"></i>
						<p>
							{{__('common.sidebar.students')}}
						</p>
					</a>
				</li>
				@endcan
        
				@can('subject-list')
					<li class="nav-item">
						<a href="{{ route('subjects.index') }}" class="nav-link {{ request()->is('subjects') ? 'active' : '' }}">
							<i class="nav-icon fas fa-paragraph"></i>
							<p>{{__('common.sidebar.subjects')}}</p>
						</a>
					</li>
				@endcan

				@can('grade-list')
					<li class="nav-item">
						<a href="{{ route('grades.index') }}" class="nav-link {{ request()->is('grades') ? 'active' : '' }}">
							<i class="nav-icon fas fa-chalkboard"></i>
							<p>{{__('common.sidebar.grades')}}</p>
						</a>
					</li>
				@endcan

				@can('course-list')
					<li class="nav-item">
						<a href="{{ route('courses.index') }}" class="nav-link {{ request()->is('courses') ? 'active' : '' }}">
							<i class="nav-icon fas fa-book"></i>
							<p>{{__('common.sidebar.courses')}}</p>
						</a>
					</li>
				@endcan

				{{-- Schedules & Calendar --}}
				@can('schedule-list')					
				<li class="nav-item">
					<a href="{{ route('schedules.index') }}" class="nav-link {{ request()->is('schedules') ? 'active' : '' }}">
						<i class="nav-icon far fa-calendar-alt"></i>
						<p>
							{{__('common.sidebar.schedules')}}
						</p>
					</a>
				</li>
        @endcan
        
        {{-- Utilisites --}}
        <li class="nav-header">{{__('common.sidebar.utilities')}}</li>

        @can('music-list')          
        <li class="nav-item">
					<a href="{{route('musics.index')}}" class="nav-link {{ request()->is('musics') ? 'active' : '' }}">
						<i class="nav-icon fas fa-music"></i>
						<p>
							{{__('common.sidebar.musics')}}
						</p>
					</a>
        </li>
        @endcan

        {{-- Settings --}}
				<li class="nav-item">
					<a href="{{route('settings.index')}}" class="nav-link {{ request()->is('settings') ? 'active' : '' }}">
						<i class="nav-icon fas fa-cog"></i>
						<p>
							{{__('common.sidebar.settings')}}
						</p>
					</a>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>