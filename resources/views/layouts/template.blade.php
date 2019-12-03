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
			<div class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="collapse navbar-collapse" id="Navber">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">{{ config('app.name', 'Laravel') }} <span class="sr-only">(current)</span></a></li>
						<li><a href="#">リンク</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">ドロップダウン <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">メニュー1</a></li>
								<li><a href="#">メニュー2</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#">その他</a></li>
							</ul>
						</li>
						<li class="disabled">
							<a href="#">無効</a>
						</li>
					</ul>
					<form class="navbar-form navbar-right">
						<div class="form-group">
							<input type="search" class="form-control" placeholder="検索..." aria-label="検索...">
						</div>
						<button type="submit" class="btn btn-success">検索</button>
					</form>
				</div>
			</div>
			<main class="py-4">
				@yield('content')
			</main>
		</div>
	</body>
</html>
