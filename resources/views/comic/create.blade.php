@extends('layout')
@section('sub-title', 'New Comic')
@section('content')

<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card bg-dark text-white">
			<div class="card-header">New Comic</div>
			<div class="card-body">
				<form method="post" enctype="multipart/form-data">
				@csrf
				<div class="row mb-3">
					<label class="col-md-4">Type</label>
					<div class="col-md-8">
						<select class="form-control" name="type">
							<option>Manga</option>
							<option>Manhua</option>
							<option>Manhwa</option>
						</select>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Title</label>
					<div class="col-md-8">
						<input type="text" name="title" class="form-control" required="">
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Author</label>
					<div class="col-md-8">
						<input type="text" name="author" class="form-control" required="">
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Genre</label>
					<div class="col-md-8">
						<select class="form-control js-example-tokenizer" name="genre[]" multiple="">
							@foreach($genres as $genre)
							<option value="{{ $genre->id }}">{{ $genre->genre }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Synopsis</label>
					<div class="col-md-8">
						<textarea name="synopsis" class="form-control" rows="5"></textarea>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Rating</label>
					<div class="col-md-8">
						<input type="number" name="rating" class="form-control" required="">
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Upload Cover</label>
					<div class="col-md-8">
						<div>
						<input type="file" name="cover_img_url" class="form-control" required="" >
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<label class="col-md-4">Status</label>
					<div class="col-md-8">
						<input type="text" name="status" class="form-control" required="">
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