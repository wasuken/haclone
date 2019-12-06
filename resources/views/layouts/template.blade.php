<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">
			<!-- ここにヘッダを入れる。 -->
			<nav class="navbar bg-dark">
				<h4><a class="nav-link" href="/">{{ config('app.name', 'Laravel') }}</a></h4>
				<div class="row">
					<a class="nav-link" href="/newsList">popular</a>
					<a class="nav-link" href="/newsList?order=latest">new</a>
					<a class="nav-link" href="/comments">comments</a>
					<a class="nav-link" href="/news/create">post</a>
				</div>
				<div class="row">
					@guest
					<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
					<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @else
					<a class="nav-link" href="javascript:void(0)">{{ Auth::user()->name }}</a>
					<div>
						<a class="nav-link" href="{{ route('logout') }}"
						   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
					@endguest
				</div>
			</nav>
			<main class="py-4">
				@if ($errors->any())
					<div>
						@foreach ($errors->all() as $error)
							<div class="alert alert-danger">{{ $error }}</div>
						@endforeach
					</div>
				@endif
				@yield('content')
			</main>
		</div>
	</body>
</html>
