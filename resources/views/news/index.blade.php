@extends('layouts.template')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<form action="/search" class="form-group">
							<input style="width:30%;" class="form-controll" name="q" type="text"
								   placeholder="キーワード" required/>
							<input class="btn-primary" type="submit" value="検索"/>
						</form>
					</div>
				</div>

				<div class="card">
					<div class="card-header">News</div>
					<div class="card-body">
						@php
						$cnt = 1;
						@endphp
						@foreach ($newsList as $news)
							<div>
								<p style="display:block;float:left;">{{$cnt++}}.</p>
								<div>
									<a href="{{$news->url}}">
										{{mb_strlen($news->title) > 35? mb_substr($news->title, 0, 35) . '...':$news->title}}
									</a>
									<a class="badge badge-secondary" href="/search?domain={{$news->domain}}">
										({{$news->domain}})
									</a>
									<div>
										<small class="bg-gradient-light">
											<a href="/news?id={{$news->id}}">{{$news->created_at}}</a>
										</small>
									</div>
								</div>
							</div>
						@endforeach
					</div>
					<div class="card-header">
						@php
						$params = [];
						if(isset($domain)) $params['domain'] = $domain;
						if(isset($q)) $params['q'] = $q;
						@endphp
						{{$newsList->appends($params)->links()}}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
