<footer class="main-footer">
	<!-- To the right -->
	<div class="float-right d-none d-sm-inline">
		<a href="{{ route('logout') }}"
			onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
			{{ __('Logout') }}
		</a>

		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
		</form>
	</div>
	<!-- Default to the left -->
	<strong>Smartify v0.8.20.05.20 - Copyright &copy; 2020 <a href="https://codeiva.com">Codeiva</a>.</strong> All rights reserved.
</footer>