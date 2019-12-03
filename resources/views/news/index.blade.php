@extends('layouts.template')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Dashboard</div>

					<div class="card-body">
						<ul>
							@foreach ($newsList as $news)
								<div>
									<p>url:{{$news->url}}</p>
									<p>title:{{$news->title}}</p>
									<p>domain:{{$news->domain}}</p>
								</div>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
