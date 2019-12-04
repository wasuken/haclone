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
					@foreach($comments as $comment)
						{{User::find($comment->user_id)->name}}>{{$comment->contents}}
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection
