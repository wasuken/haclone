@extends('layouts.template')

@php
use App\User;
@endphp
@section('content')
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">News</div>
				<div class="card-body">
					<p><a href="{{$news->url}}">{{$news->title}}</a></p>
					<form action="/comment" method="POST">
						@csrf
						<input name="newsId" type="hidden" value="{{$news->id}}"/>
						<textarea placeholder="コメント" class="form-control" id="commentText" name="commentText" rows="3"></textarea>
						<input class="btn-primary" type="submit" value="送信"/>
					</form>
					@foreach($comments as $comment)
						<div class="card">
							<h5 class="card-header">{{User::find($comment->user_id)->name}}</h5>
							<div class="card-body">
								{{$comment->contents}}
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection
