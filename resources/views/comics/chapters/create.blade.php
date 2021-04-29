@extends('layout')
@section('sub-title', $comic->title)
@section('content')

<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card bg-dark text-white">
			<div class="card-header">Title</div>
			<div class="card-body">
				<form method="post" action="{{ route('chapter.store', $comic->id) }}" enctype="multipart/form-data">
				@csrf
				<div class="row mb-3 justify-content-center">
					<div class="col-md-3">
						<img src="{{ asset('storage/'.$comic->cover_img_url) }}" class="img-thumbnail img-fluid w-100">
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Title</label>
					<div class="col-md-8">
						<input type="text" name="title" class="form-control" readonly="" required="" value="{{ $comic->title }}">
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Chapter</label>
					<div class="col-md-3">
						<input type="number" name="chapter" class="form-control" required="">
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Chapter Title</label>
					<div class="col-md-8">
						<input type="text" name="chapter_title" class="form-control">
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Language</label>
					<div class="col-md-8">
						<select class="form-control" name="language" required="">
							<option value="en">English</option>
							<option value="id">Indonesian</option>
						</select>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Upload Image</label>
					<div class="col-md-8">
						<div>
						<input type="file" name="image[]" class="form-control" required="" multiple="">
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4"></label>
					<div class="col-md-8">
						<button class="btn btn-success btn-block">Submit</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection