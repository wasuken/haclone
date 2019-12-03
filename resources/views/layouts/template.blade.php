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
			<nav class="navbar navbar-expand-lg navbar-light bg-dark">
				<h4><a class="nav-link" href="/">{{ config('app.name', 'Laravel') }}</a></h4>
				<a class="nav-link" href="/news">new</a>
				<a class="nav-link" href="/popular">popular</a>
				<a class="nav-link" href="/comments">comments</a>
			</nav>
			<main class="py-4">
				@yield('content')
			</main>
		</div>
	</body>
</html>
