@extends('layouts.template')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">News</div>
					<div class="card-body">
						<ul>
							@php
							$cnt = 1;
							@endphp
							@foreach ($newsList as $news)
								<div>
									<div>
										{{$cnt++}}.
										<a href="{{$news->url}}">
											{{$news->title}}
										</a>
										<a class="badge badge-secondary" href="/search?domain={{$news->domain}}">
											({{$news->domain}})
										</a>
									</div>
									<div>
										<small class="bg-gradient-light">
											<a href="/news?id={{$news->id}}">{{$news->created_at}}</a>
										</small>
									</div>
								</div>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
