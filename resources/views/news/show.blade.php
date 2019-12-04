@extends('layouts.template')

@php
use App\User;
use App\Helpers\Helper;
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

					{!! Helper::CommentsTreeToHtml($commentsTree) !!}
				</div>
			</div>
		</div>
	</div>
@endsection
