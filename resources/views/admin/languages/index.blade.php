@extends('admin.layout')
@section('content-header')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-4">
				<h1 class="m-0">Languages</h1>
			</div>
			<div class="col-sm-8">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
					<li class="breadcrumb-item active"><a href="{{ route('admin.languages') }}">Languages</a></li>
				</ol>
			</div>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<a href="{{ route('admin.languages.new') }}" class="btn btn-default mb-1"><i class="fa fa-plus-square"></i> New Language</a>
				@if(session('success'))
				<div class="alert alert-success mb-1">{{ session('success') }}</div>
				@endif
				<div class="card">
					<div class="card-body">
						<input type="text" id="keyword" class="form-control mb-1" placeholder="Search...">
						<ul class="list-group" id="list">
							@foreach ($languages as $key)
							<li class="list-group-item">
								<i class="flag-icon flag-icon-{{ $key->flag_icon_code }}"></i> {{ $key->language }}
								<div class="dropdown float-right">
									<a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="sr-only">Options</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="{{ route('admin.languages.edit', $key->id) }}">Edit</a>
										<form method="post" action="{{ route('admin.languages.delete', $key->id) }}">
											@csrf
											@method('delete')
											<button class="dropdown-item">Delete</button>
										</form>
									</div>
								</div>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
  $("#keyword").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#list li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection