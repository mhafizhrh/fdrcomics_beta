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
				<a href="{{ route('admin.languages') }}" class="btn btn-default mb-1"><i class="fa fa-arrow-left"></i> Back</a>
				@if ($errors->any())
				<div class="alert alert-danger mb-1">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				@if(session('success'))
				<div class="alert alert-success mb-1">{{ session('success') }}</div>
				@endif
				<div class="card">
					<div class="card-body">
						<form method="post" action="{{ route('admin.languages.store') }}">
							@csrf
							<div class="form-group row">
								<label class="col-md-4">Flag Icon Code</label>
								<div class="col-md-8">
									<div class="input-group">
										<input type="text" name="flag_icon_code" class="form-control" id="flag-icon-code">
										<div class="input-group-append">
											<span id="flag-icon-preview" class="input-group-text">Preview</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4">Language</label>
								<div class="col-md-8">
									<input type="text" name="language" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-8 offset-md-4">
									<button class="btn btn-default">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script>
	$("#flag-icon-code").on('keyup', function() {
		const flagIconCode = $(this).val();
		console.log(flagIconCode);
		$("#flag-icon-preview").html(`<i class="flag-icon flag-icon-`+flagIconCode+`"></i>`);
	})
</script>
@endsection