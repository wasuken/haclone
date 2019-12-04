@extends('layouts.template')

@php
use App\User;
@endphp
@section('content')
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Reply</div>
				<div class="card-body">
					<div class="card">
						<div class="card-header">{{User::find($toComment->user_id)->name}}</div>
						<div class="card-body">
							{{$toComment->contents}}
						</div>
					</div>
					<form action="/comment" method="POST">
						@csrf
						<input name="parentId" type="hidden" value="{{$parentId}}"/>
						<input name="newsId" type="hidden" value="{{$newsId}}"/>
						<textarea placeholder="リプライ" class="form-control"
								  id="commentText" name="commentText" rows="3"></textarea>
						<input class="btn-primary" type="submit" value="送信"/>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
