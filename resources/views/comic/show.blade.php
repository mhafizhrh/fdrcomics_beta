@extends('layout')
@section('sub-title', $comic->title)
@section('content')

<div class="row">
	<div class="col-md-4">
		<div class="card bg-dark text-white mb-3">
			<div class="card-header">{{ $comic->type }}</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-md-6 col-6">
						<img src="{{ asset('storage/'.$comic->cover_img_url) }}" class="img-thumbnail img-fluid mb-3">
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 col-6">Title</label>
					<div class=" col-md-8 col-6">
						{{ $comic->title }}
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 col-6">Author</label>
					<div class=" col-md-8 col-6">
						{{ $comic->author }}
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 col-6">Genre</label>
					<div class=" col-md-8 col-6">
						@foreach($comic->comicGenre as $genre)

							<a class="badge badge-success" href="{{ url('#') }}">{{ $genre->genre->genre }}</a>

						@endforeach
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 col-6">Rating</label>
					<div class=" col-md-8 col-6">
						{{ $comic->rating }}/10
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 col-6">Total Chapter</label>
					<div class=" col-md-8 col-6">
						{{ $comic->totalChapter() }}
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 col-6">Status</label>
					<div class=" col-md-8 col-6">
						{{ $comic->status }}
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 col-6">Latest Update</label>
					<div class=" col-md-8 col-6">
						@if ($comic->chapter->count() >= 1)
						{{ $comic->chapter->max('updated_at')->diffForHumans() }} | {{ $comic->chapter->max('updated_at')->format('d/m/Y H:i A') }}
						@endif
					</div>
				</div>
				@if (Auth::check())
				@if (Auth::user()->level === 'admin')
				<div class="row">
					<div class="col">
						<a href="{{ route('comic.edit', $comic->id) }}" class="btn btn-warning btn-block mt-3">Edit Comic</a>
					</div>
					<div class="col">
						<button class="btn btn-danger btn-block mt-3">Delete Comic</button>
					</div>
				</div>
				@endif
				@endif
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card bg-dark text-white mb-3">
			<div class="card-header">Synopsis</div>
			<div class="card-body text-justify">
				{!! $comic->synopsis !!}
			</div>
		</div>
		<div class="card bg-dark text-white">
			<div class="card-header">Chapters</div>
			<div class="card-body">
				@if (Auth::check() && Auth::user()->level == 'admin')
				<a href="{{ route('chapter.create', $comic->id) }}" class="btn btn-primary mb-3">New Chapter</a>
				@endif
				<div class="table-responsive">
				<table class="table">
					<thead class="thead-light">
						<tr>
							<th>Language</th>
							<th>Chapter</th>
							<th><div class="float-right">Last Update</div></th>
							@if (Auth::check() && Auth::user()->level == 'admin')
							<th><div class="float-right">Settings</div></th>
							@endif
						</tr>
					</thead>
					<tbody>
						@if ($comic->chapter->count() >= 1)
						@foreach($comic->chapter as $chapter)

						@if (Auth::check() && Auth::user()->level == 'admin')
						<tr>
							<td>{{ Str::upper($chapter->language) }}</td>
							<td><a href="{{ route('chapter.read', $chapter->id) }}" class="chapter-anchor text-white">Chapter {{ $chapter->chapter }} @if ($chapter->chapter_title != null) - {{ $chapter->chapter_title }} @endif</a></td>
							<td><div class="float-right"> {{ $chapter->updated_at->diffForHumans() }}</div></td>
							@if (Auth::check() && Auth::user()->level == 'admin')
							<td>
								<button class="btn btn-light dropdown-toggle float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <i class="fa fa-cog"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								    <a class="dropdown-item" href="{{ route('chapter.edit', $chapter->id) }}">Edit</a>
								    <form method="post" action="{{ route('chapter.delete') }}">@csrf @method('DELETE') <input type="text" name="chapter_id" value="{{ $chapter->id }}" readonly="" hidden=""> <button class="dropdown-item" style="cursor: pointer">Delete</button></form>
								</div>
							</td>
							@endif
						</tr>
						@else
							@if ($chapter->chapterContent->count() >= 1)
							<tr>
								<td>{{ Str::upper($chapter->language) }}</td>
								<td><a href="{{ route('chapter.read', $chapter->id) }}" class="chapter-anchor text-white">Chapter {{ $chapter->chapter }} @if ($chapter->chapter_title != null) - {{ $chapter->chapter_title }} @endif</a></td>
								<td><div class="float-right"> {{ $chapter->updated_at->diffForHumans() }}</div></td>
							</tr>
							@endif
						@endif

						@endforeach
						@endif
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection