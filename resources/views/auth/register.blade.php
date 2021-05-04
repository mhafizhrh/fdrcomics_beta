@extends('layout')
@section('sub-title', 'Register')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Register</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
				<div class="col-md-4">
					@if ($errors->any())
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					<div class="card">
						<div class="card-body">
							<form method="post" action="{{ route('register.store') }}">
								@csrf
								<div class="form-group text-center">
									<h3>SANCOMICS</h3>
									<label>- Register -</label>
								</div>
								<div class="form-group">
									<input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required="">
								</div>
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="Your@email.com" value="{{ old('email') }}" required="">
								</div>
								<div class="form-group">
									<input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required="">
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Password" required="">
								</div>
								<div class="form-group">
									<input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation" required="">
								</div>
								<div class="form-group">
									<button class="btn btn-primary btn-block">Register</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
@endsection