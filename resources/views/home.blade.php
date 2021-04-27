@extends('layout')
@section('sub-title', 'Home')
@section('content')

<style>
	a {
		color: white;
	}

	a:visited {
		color: #f0f0f0;
	}
</style>

<div class="row">
	<div class="col-md-8 pr-md-1">
		<div class="row">
			<div class="col-md-12 px-0-sm">
				<div class="bg-dark text-white mb-3 py-1 px-3">
					<h5 class="mt-3"><a class="btn btn-light" data-toggle="collapse" href="#advanced_search" role="button" aria-expanded="false" aria-controls="advanced_search"><i class="fa fa-search"></i> Advanced Search</a></h5>
					<hr class="bg-white">
					<div class="row">
						<div class="col-md-12 collapse" id="advanced_search">
							<form method="post" action="{{ route('search.filter') }}">
								@csrf
								<div class="form-group row">
									<label class="col-md-4">Title</label>
									<div class="col-md-8">
										<input type="text" name="title" class="form-control">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-4">Type</label>
									<div class="col-md-8">
										<select class="form-control" name="type">
											@foreach ($comics->unique('type') as $comic)
											<option>{{ $comic->type }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-4">Genre</label>
									<div class="col-md-8 row">
										@foreach ($genresUnique as $genre)
										<div class="col-md-3">
											<input type="checkbox" name="genre[]" value="{{ $genre->id }}">
											{{ $genre->genre }}
										</div>
										@endforeach
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-success btn-block"><i class=" fa fa-search"></i> Search</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 px-0-sm">
				<div class="bg-dark text-white mb-3 py-1 px-3">
					<h5 class="mt-3">Latest Updates</h5>
					<hr class="bg-white">
					<div class="row">
						@foreach ($comics as $comic)
							@if ($comic->chapter->count() >= 1)
								<div class="col-md-12 mb-2">
									<div class="row">
										<div class="col-md-3 col-4">
											<img src="{{ asset('storage/'.$comic->cover_img_url) }}" class="img-thumbnail img-cover-home">
										</div>
										<div class="col-md-9 col-8">
											<h5 class="one-line-text"><a href="{{ route('comic.show', $comic->id) }}">{{ $comic->title }}</a></h5>
											<ul class="list-unstyled">
												@foreach ($comic->chapter as $chapter)

													@if ($chapter->chapterContent->count() >= 1)

														<li>
															<a href="{{ route('chapter.read', $chapter->id) }}">[{{ Str::upper($chapter->language) }}] Chapter {{ $chapter->chapter }}</a>
															<span class="float-right">{{ $chapter->chapterContent->max('updated_at')->diffForHumans() }}</span>
														</li>

													@endif
												@endforeach
											</ul>
										</div>
									</div>
								</div>
							@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 pl-md-1">
		<div class="row">
			<div class="col-md-12 px-0-sm">
				<div class="bg-dark text-white mb-3 py-1 px-3">
					<h5 class="mt-3">Popular Chapter</h5>
					<hr class="bg-white">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-sm">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th>Title</th>
										<th>Chapter</th>
										@if (Auth::check() && Auth::user()->level == 'admin')
										<th class="text-center">Total Visited</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach ($popularChapter as $popChapter)
										<tr>
											<td class="text-center">{{ $loop->iteration }}</td>
											<td><a href="{{ route('comic.show', $popChapter->chapter->comic->id) }}">{{ $popChapter->chapter->comic->title }}</a></td>
											<td>Chapter {{ $popChapter->chapter->chapter }}</a></td>
											@if (Auth::check() && Auth::user()->level == 'admin')
											<td class="text-center">{{ $popChapter->count }}</td>
											@endif
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 px-0-sm">
				<div class="bg-dark text-white mb-3 py-1 px-3">
					<h5 class="mt-3">Genres</h5>
					<hr class="bg-white">
					<div class="row">
						<div class="col-md-12">
							@foreach($genresUnique as $genre)

								<a href="{{ route('search', ['type' => '*', 'title' => '*', 'genre' => $genre->id]) }}" class="btn btn-light text-dark mb-1">{{ $genre->genre }} <span class="badge badge-info">{{ $genre->totalGenreUsed->count() }}</span></a>

							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection