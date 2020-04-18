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
							Dashboard
						</p>
					</a>
				</li>

				{{-- Users --}}
				@can('user-list')
				<li class="nav-item">
					<a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
						<i class="nav-icon fas fa-user"></i>
						<p>
							Users
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
							Roles
						</p>
					</a>
				</li>
				@endcan

				{{-- Academic --}}
				<li class="nav-item has-treeview {{ request()->is('subjects') || request()->is('grades') || request()->is('courses') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ request()->is('subjects') || request()->is('grades') || request()->is('courses') ? 'active' : '' }}">
						<i class="nav-icon fas fa-book"></i>
						<p>
							Academic
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						@can('subject-list')
							<li class="nav-item">
								<a href="{{ route('subjects.index') }}" class="nav-link {{ request()->is('subjects') ? 'active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Subjects</p>
								</a>
							</li>
						@endcan

						@can('grade-list')
							<li class="nav-item">
								<a href="{{ route('grades.index') }}" class="nav-link {{ request()->is('grades') ? 'active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Grade</p>
								</a>
							</li>
						@endcan

						@can('course-list')
							<li class="nav-item">
								<a href="{{ route('courses.index') }}" class="nav-link {{ request()->is('courses') ? 'active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Courses</p>
								</a>
							</li>
						@endcan
					</ul>
				</li>

				{{-- Schedules & Calendar --}}
				@can('schedule-list')					
				<li class="nav-item">
					<a href="{{ route('schedules.index') }}" class="nav-link {{ request()->is('schedules') ? 'active' : '' }}">
						<i class="nav-icon far fa-calendar-alt"></i>
						<p>
							Schedules
						</p>
					</a>
				</li>
				@endcan

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>