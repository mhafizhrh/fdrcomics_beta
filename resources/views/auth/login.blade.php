@extends('layout')
@section('sub-title', 'Login')
@section('content')

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-4">
				@error('username')
				    <div class="alert alert-danger"><i class="fa fa-times-circle"></i> {{ $message }}</div>
				@enderror
				@if(session('status'))
					<div class="form-group">
						<div class="alert alert-success">{{ session('status') }}</div>
					</div>
				@endif
				<div class="card">
					<div class="card-body">
						<form method="post" action="{{ route('login.validate') }}">
							@csrf
							<div class="form-group text-center">
								<h3>SANCOMICS</h3>
								<label>- Login -</label>
							</div>
							<div class="form-group">
								<input type="text" name="username" class="form-control" placeholder="Username" required="">
							</div>
							<div class="form-group">
								<input type="password" name="password" class="form-control" placeholder="Password" required="">
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-block">Login</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection