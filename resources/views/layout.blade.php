<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('storage') }}/AdminLTE/plugins/fontawesome-free/css/all.min.css">
        <!-- summernote -->
  		<link rel="stylesheet" href="{{ asset('storage') }}/AdminLTE/plugins/summernote/summernote-bs4.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('storage') }}/AdminLTE/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
        <style>
        	a:visited { color: #f0f0f0; }
        </style>
    </head>
    <body class="hold-transition sidebar-mini sidebar-collapse dark-mode">
		<div class="wrapper">
		    <!-- Navbar -->
		    <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
		        <!-- Left navbar links -->
		        <ul class="navbar-nav">
		            <li class="nav-item">
		                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		            </li>
		            <li class="nav-item d-none d-sm-inline-block">
		                <a href="{{ route('home') }}" class="nav-link">Home</a>
		            </li>
		            <li class="nav-item d-none d-sm-inline-block">
		                <a href="#" class="nav-link">Contact</a>
		            </li>
		        </ul>
		        <!-- Right navbar links -->
		        <ul class="navbar-nav ml-auto">
		            <!-- Navbar Search -->
		            <li class="nav-item">
		                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
		                <i class="fas fa-search"></i>
		                </a>
		                <div class="navbar-search-block">
		                    <form class="form-inline">
		                        <div class="input-group input-group-sm">
		                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
		                            <div class="input-group-append">
		                                <button class="btn btn-navbar" type="submit">
		                                <i class="fas fa-search"></i>
		                                </button>
		                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
		                                <i class="fas fa-times"></i>
		                                </button>
		                            </div>
		                        </div>
		                    </form>
		                </div>
		            </li>
		            <li class="nav-item">
		                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
		                <i class="fas fa-expand-arrows-alt"></i>
		                </a>
		            </li>
		            <li class="nav-item">
		                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
		                <i class="fas fa-th-large"></i>
		                </a>
		            </li>
		        </ul>
		    </nav>
		    <!-- /.navbar -->
		    <!-- Main Sidebar Container -->
		    <aside class="main-sidebar sidebar-dark-primary elevation-4">
		        <!-- Brand Logo -->
		        <a href="{{ route('home') }}" class="brand-link">
		        <img src="{{ asset('storage') }}/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
		        </a>
		        <!-- Sidebar -->
		        <div class="sidebar">
		            <!-- Sidebar user panel (optional) -->
		            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
		                <div class="image">
		                    <img src="{{ asset('storage') }}/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
		                </div>
		                <div class="info">
		                	@if (Auth::check())
		                    <p class="d-block">{{ Auth::user()->username }}</p>
		                    @else
		                    <a href="{{ route('login') }}" class="d-block"><i class="fas fa-lock"></i> Login</a>
		                    @endif
		                </div>
		            </div>
		            <!-- Sidebar Menu -->
		            <nav class="mt-2">
		                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		                    <!-- Add icons to the links using the .nav-icon class
		                        with font-awesome or any other icon font library -->
		                    <li class="nav-item">
		                        <a href="{{ route('home') }}" class="nav-link">
		                            <i class="nav-icon fas fa-home"></i>
		                            <p>
		                                Home
		                                <!-- <span class="right badge badge-danger">New</span> -->
		                            </p>
		                        </a>
		                    </li>
		                    @if (Auth::check())
		                    <li class="nav-item">
		                        <a href="#" class="nav-link">
		                            <i class="nav-icon fas fa-book"></i>
		                            <p>
		                                Bookmarks
		                            </p>
		                        </a>
		                    </li>
		                    <li class="nav-item">
		                        <a href="#" class="nav-link">
		                            <i class="nav-icon fas fa-history"></i>
		                            <p>
		                                History
		                            </p>
		                        </a>
		                    </li>
		                    <li class="nav-item">
		                        <a href="#" class="nav-link">
		                            <i class="nav-icon fas fa-user"></i>
		                            <p>
		                                My Profile
		                            </p>
		                        </a>
		                    </li>
		                    <li class="nav-item">
		                        <a href="{{ route('logout') }}" class="nav-link">
		                            <i class="nav-icon fas fa-power-off"></i>
		                            <p>
		                                Logout
		                            </p>
		                        </a>
		                    </li>
		                    @else
		                    <li class="nav-item">
		                    	<a href="{{ route('login') }}" class="nav-link">
		                    		<i class="nav-icon fas fa-lock"></i>
		                    		<p>
		                    			Login
		                    		</p>
		                    	</a>
		                    </li>
		                    @endif
		                </ul>
		            </nav>
		            <!-- /.sidebar-menu -->
		        </div>
		        <!-- /.sidebar -->
		    </aside>
		    <!-- Content Wrapper. Contains page content -->
		    @yield('content')
		    <!-- Control Sidebar -->
		    <aside class="control-sidebar control-sidebar-dark">
		        <!-- Control sidebar content goes here -->
		        <div class="p-3">
		            <h5>Title</h5>
		            <p>Sidebar content</p>
		        </div>
		    </aside>
		    <!-- /.control-sidebar -->
		    <!-- Main Footer -->
		    <footer class="main-footer">
		        <!-- To the right -->
		        <div class="float-right d-none d-sm-inline">
		            Anything you want
		        </div>
		        <!-- Default to the left -->
		        <strong>Copyright &copy; 2021 <a href="https://sancomics.xyz">SANComics</a>.</strong> All rights reserved.
		    </footer>
		</div>
        <!-- jQuery -->
        <script src="{{ asset('storage') }}/AdminLTE/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('storage') }}/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('storage') }}/AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        <!-- Summernote -->
		<script src="{{ asset('storage') }}/AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('storage') }}/AdminLTE/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('storage') }}/AdminLTE/dist/js/demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
        <script>
        	$(document).ready(function() {
			    $('#datatables').DataTable();
			} );

			$(function () {
			  	bsCustomFileInput.init();
			});

			$(function () {
			    // Summernote
			    $('#summernote').summernote()
			})
        </script>
    </body>
</html>