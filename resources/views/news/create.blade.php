@extends('layouts.template')

@php
use App\User;
@endphp
@section('content')
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Post News</div>
				<div class="card-body">
					<div class="input-group col-md-12">
						<form action="/news" method="POST" style="width:70%;">
							@csrf
							<input class="form-control" name="url" type="url" value="" placeholder="url" />
							<div class="input-group-append">
								<input class="btn-primary" type="submit" value="送信"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
