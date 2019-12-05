@extends('layouts.template')

@php
use App\User;
use App\News;
@endphp
@section('content')
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">News</div>
				<div class="card-body">
					@foreach($comments as $comment)
						<div class="card">
							<div class="card-header">
								{{User::find($comment->user_id)->name}}
								<small>{{$comment->created_at}}</small>
							</div>
							<div class="card-body">
								{{$comment->contents}}
							</div>
							<div class="card-footer">
								<a href="/news?id={{$comment->news_id}}">{{News::find($comment->news_id)->title}}</a>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection
