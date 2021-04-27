@extends('layout')
@section('sub-title', 'Reading History')
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
	<div class="col-md-12 px-0-sm">
		<div class="bg-dark text-white mb-3 py-1 px-3">
			<h5 class="mt-3">History</h5>
			<hr class="bg-white">
			<div class="row">
				@foreach ($history as $key)
				<div class="col-lg-2 col-md-2 col-sm-6 col-6">
					<div class="card bg-dark border-light text-center text-white mb-2">
						<img src="{{ asset('storage/'.$key->chapter->comic->cover_img_url) }}" class="card-img-top" style="width: 100%; height: 200px; object-fit: cover;">
						<div class="card-body px-2 py-2">
							<h5 class="one-line-text"><a href="{{ route('comic.show', $key->chapter->comic->id) }}">{{ $key->chapter->comic->title }}</a></h5>
							<hr class="bg-white">
							<h6><a href="{{ route('chapter.read', $key->chapter->id) }}">Chapter {{ $key->chapter->chapter }}</a></h6>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection