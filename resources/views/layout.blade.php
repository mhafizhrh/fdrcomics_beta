<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>{{ config('app.name') }} | @yield('sub-title', '404 Not Found')</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/fontawesome.min.css" integrity="sha512-OdEXQYCOldjqUEsuMKsZRj93Ht23QRlhIb8E/X0sbwZhme8eUw6g8q7AdxGJKakcBbv7+/PX0Gc2btf7Ru8cZA==" crossorigin="anonymous" />
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset('storage/assets/css/custom.styles.css') }}">

	<style>
		
	</style>
</head>

<body>
	<div class="mb-3">
	  	<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
	  		<!-- <div class="container"> -->
		    	<a class="navbar-brand" href="/">{{ config('app.name') }}</a>
		    	<!-- <img src="/docs/4.0/assets/brand/bootstrap-solid.svg" width="30" height="30" alt=""> -->
		    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse offcanvas-collapse" id="navbarNav">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active"><a href="{{ route('home') }}" class="nav-link bg-dark">Home</a></li>
						@if (Auth::check() && Auth::user()->level == 'admin')
						<li class="nav-item"><a href="{{ route('comic.create') }}" class="nav-link bg-dark">New Comic</a></li>
						@endif
						<li class="nav-item dropdown">
					        <a class="nav-link dropdown-toggle bg-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					          	@if (Auth::check())
					          		<i class="fa fa-user"></i>
					          		{{ Auth::user()->username }}
					          	@else
					          		<i class="fa fa-user-times"></i>
					          		Guest
					          	@endif
					        </a>
					        <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
					        	@if (!Auth::check())
					          	<a class="dropdown-item text-white" href="{{ route('login') }}"><i class="fa fa-sign-in-alt"></i> Login</a>
					          	<a class="dropdown-item text-white" href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Register</a>
					          	@else
					          	<a class="dropdown-item text-white" href="{{ route('user.history') }}"><i class="fa fa-history"></i> History</a>
					          	<a class="dropdown-item text-white" href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a>
					          	@endif
					        </div>
					    </li>
					</ul>
					<!-- <form class="form-inline ml-auto">
					    <div class="input-group">
					    	<input type="text" name="" class="form-control" placeholder="Search comic...">
					    	<div class="input-group-append">
					    		<button class="btn btn-sm btn-success"><i class="fa fa-search"></i></button>
					    	</div>
					    </div>
					</form> -->
				</div>
		    <!-- </div> -->
	  	</nav>
	</div>

	<div class="container-fluid">
		@yield('content')
	</div>

	<footer class="bg-dark text-white mt-3">
		<div class="container p-4">
			<div class="row">
				<div class="col-lg-6 col-12">
					<h5>Footer Content</h5>
					<p class="text-justify">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</p>
				</div>
				<div class="col-lg-3 col-6">
					<h5 class="text-uppercase">Links</h5>
					<ul class="list-unstyled mb-0">
						<li><a href="#" class="text-white">Link 1</a></li>
						<li><a href="#" class="text-white">Link 2</a></li>
						<li><a href="#" class="text-white">Link 3</a></li>
					</ul>
				</div>
				<div class="col-lg-3 col-6">
					<h5 class="text-uppercase">Links</h5>
					<ul class="list-unstyled mb-0">
						<li><a href="#" class="text-white">Link 1</a></li>
						<li><a href="#" class="text-white">Link 2</a></li>
						<li><a href="#" class="text-white">Link 3</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="text-center p-3 bg-secondary">
			&copy; {{ date('Y') }} Copyright : 
			<a href="https://sancomics.xyz" class="text-light">sancomics.xyz</a>
		</div>
	</footer>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
	<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
	<script>

		$(".js-example-tokenizer").select2({
		    tags: true,
		    tokenSeparators: [',', ' ']
		})

		$('.confirm-delete').on('click', function(e){
			e.preventDefault();
			Swal.fire({
			    title: 'Are you sure?',
			    text: "You won't be able to revert this!",
			    icon: 'warning',
			    showCancelButton: true,
			    confirmButtonColor: '#3085d6',
			    cancelButtonColor: '#d33',
			    confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			    if (result.value) {
			       
			       $(this).parents('form').submit();
			    } else {

			    	return false;
			    }
			})
		})

		$('.confirm-delete-anchor').on('click', function(e){
			e.preventDefault();
			Swal.fire({
			    title: 'Are you sure?',
			    text: "You won't be able to revert this!",
			    icon: 'warning',
			    showCancelButton: true,
			    confirmButtonColor: '#3085d6',
			    cancelButtonColor: '#d33',
			    confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			    if (result.value) {
			       
			       window.location.href = $(this)[0].href;
			       console.log($(this)[0].href);
			    } else {

			    	return false;
			    }
			})
		})
	</script>
</body>

</html>