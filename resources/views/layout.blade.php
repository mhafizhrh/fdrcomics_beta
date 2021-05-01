<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ config('app.name') }}</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
		<style>
			.text-row-1 {
				overflow: hidden;
				text-overflow: ellipsis;
				display: -webkit-box;
				-webkit-line-clamp: 1;
				-webkit-box-orient: vertical;
			}

			.text-row-2 {
				overflow: hidden;
				text-overflow: ellipsis;
				display: -webkit-box;
				-webkit-line-clamp: 2;
				-webkit-box-orient: vertical;
			}

			.text-row-10 {
				overflow: hidden;
				text-overflow: ellipsis;
				display: -webkit-box;
				-webkit-line-clamp: 10;
				-webkit-box-orient: vertical;
			}
		</style>
	</head>
	<body class="hold-transition layout-top-nav">
		<div class="wrapper">
			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand-md navbar-light">
				<div class="container">
					<a href="{{ route('home') }}" class="navbar-brand">
						<img src="{{ asset('storage/images/sancomics_logo.png') }}" alt="SANComics Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
						<span class="brand-text font-weight-light">{{ config('app.name') }}</span>
					</a>
					<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse order-3" id="navbarCollapse">
						<!-- Left navbar links -->
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a href="{{ route('home') }}" class="nav-link">
									<i class="nav-icon fas fa-home"></i>
									Home
								</a>
							</li>
							@if (Auth::check())
							<li class="nav-item">
								<a href="{{ route('user.bookmarks') }}" class="nav-link">
									<i class="nav-icon fas fa-book"></i>
									Bookmarks
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('user.history') }}" class="nav-link">
									<i class="nav-icon fas fa-history"></i>
									History
								</a>
							</li>
							<li class="nav-item dropdown text-dark">
								<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-user"></i> {{ Auth::user()->username }}</a>
								<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
									<li><a href="{{ route('user.settings') }}" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
									<li><a href="{{ route('logout') }}" class="dropdown-item"><i class="fas fa-power-off"></i> Logout</a></li>
								</ul>
							</li>
							@else
							<li class="nav-item">
								<a href="{{ route('login') }}" class="nav-link">
									<i class="nav-icon fas fa-sign-in-alt"></i>
									Login
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('register') }}" class="nav-link">
									<i class="nav-icon fas fa-user-plus"></i>
									Register
								</a>
							</li>
							@endif
						</ul>
						<!-- SEARCH FORM -->
						<form class="form-inline ml-0 ml-md-3" method="get" action="{{ route('search') }}">
							<div class="input-group input-group-sm">
								<input class="form-control" type="search" name="title" placeholder="Search" aria-label="Search">
								<div class="input-group-append">
									<button class="btn btn-navbar" type="submit">
									<i class="fas fa-search"></i>
									</button>
								</div>
							</div>
						</form>
					</div>
					<!-- Right navbar links -->
					<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
						<!-- <li class="nav-item">
							<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
								<i class="fas fa-th-large"></i>
							</a>
						</li> -->
						<li class="nav-item ml-3">
							<div class="custom-control custom-switch custom-switch-off-light custom-switch-on-dark">
								<input type="checkbox" class="custom-control-input" id="customSwitch3">
								<label class="custom-control-label" for="customSwitch3">Dark Mode</label>
							</div>
						</li>
					</ul>
				</div>
			</nav>
			<!-- /.navbar -->
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				@yield('content-header')
				<!-- /.content-header -->
				<!-- Main content -->
				@yield('content')
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
				<div class="p-3">
					<h1>Hello World</h1>
				</div>
			</aside>
			<!-- /.control-sidebar -->
			<!-- Main Footer -->
			<footer class="main-footer">
				<!-- To the right -->
				<div class="float-right d-none d-sm-inline">
					Developed by <a href="#about-me">Fizh vi Britannia</a>
				</div>
				<!-- Default to the left -->
				<strong>Copyright &copy; 2021 <a href="https://sancomics.xyz">SANComics</a>.</strong> All rights reserved.
			</footer>
		</div>
		<!-- ./wrapper -->
		<!-- REQUIRED SCRIPTS -->
		<!-- jQuery -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<!-- AdminLTE App -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
		<!-- Bootstrap Switch -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
		
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js"></script>
	</body>
	<script>
		$(function () {
		  	bsCustomFileInput.init();
		});

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
		
		$("#customSwitch3").change(function(){
			if ($(this).prop('checked')) {
				$("body").addClass('dark-mode');
				window.localStorage.setItem("theme", "dark-mode");
				$(".custom-control-label").html("Dark Mode");
				$(".main-header").addClass('navbar-dark');
				$(".main-header").removeClass('navbar-light');
			} else {
				$("body").removeClass('dark-mode');
				window.localStorage.setItem("theme", "");
				$(".custom-control-label").html("Light Mode");
				$(".main-header").addClass('navbar-light');
				$(".main-header").removeClass('navbar-dark');
			}
		})


		if (window.localStorage.getItem("theme")) {

			$("#customSwitch3").attr('checked', true);
			$("body").addClass("dark-mode");
			$(".custom-control-label").html("Dark Mode");
			$(".main-header").addClass('navbar-dark');
			$(".main-header").removeClass('navbar-light');
		} else {

			$(".custom-control-label").html("Light Mode");
		}
	</script>
</html>