@extends('layout')
@section('sub-title', $chapter->comic->title . ' Chapter ' . $chapter->chapter)
@section('content')

<div class="row justify-content-center">
	<div class="col-md-6 col-12">
		<nav aria-label="breadcrumb sticky-top">
		    <ol class="breadcrumb">
		     	<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
		    	<li class="breadcrumb-item"><a href="{{ route('comic.show', ['comic_id' => $chapter->comic->id, 'title' => '#comments']) }}">{{ $chapter->comic->title }}</a></li>
		    	<li class="breadcrumb-item active" aria-current="page">Chapter {{ $chapter->chapter }} @if ($chapter->chapter_title != null) - {{ $chapter->chapter_title }} @endif</li>
		    </ol>
		</nav>
	</div>
</div>
<div class="row justify-content-center">
	<div class="col-md-6 col-12 mb-3">
		<div class="row">
			<div class="col-md-6 col-12">
				<select class="form-control mb-2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
					@foreach($chapters as $ch)
					@if ($ch->chapterContent->count() >= 1)
					<option value="{{ route('chapter.read', $ch->id) }}" @if ($ch->chapter == $chapter->chapter) selected @endif>
						[{{ Str::upper($ch->language) }}]
						Chapter {{ $ch->chapter }}
						@if ($ch->chapter_title != null) - {{ $ch->chapter_title }} @endif
					</option>
					@endif
					@endforeach
				</select>
			</div>
			@if ($chapter->nextChapter() && $chapter->nextChapter()->chapterContent->count() >= 1)
			<div class="col col-6"> 
				<a href="{{ route('chapter.read', $chapter->nextChapter()->id) }}" class="btn btn-success btn-block">Next Chapter</a>
			</div>
			@endif
			@if ($chapter->previousChapter() && $chapter->previousChapter()->chapterContent->count() >= 1)
			<div class="col col-6"> 
				<a href="{{ route('chapter.read', $chapter->previousChapter()->id) }}" class="btn btn-success btn-block">Previous Chapter</a>
			</div>
			@endif
		</div>
	</div>
</div>
<div class="row justify-content-center">
	<div class="col-md-6 col-12 px-xs-0 mb-2">
		@foreach($chapter->chapterContent as $chapterContent)
		<img src="{{ asset('storage/'.$chapterContent->img_path) }}" class="img-fluid">
		@endforeach
	</div>
</div>
<div class="row justify-content-center">
	<div class="col-md-6 col-12 mb-3">
		<div class="row">
			<div class="col-md-6 col-12">
				<select class="form-control mb-2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
					@foreach($chapters as $ch)
					@if ($ch->chapterContent->count() >= 1)
					<option value="{{ route('chapter.read', $ch->id) }}" @if ($ch->chapter == $chapter->chapter) selected @endif>
						[{{ Str::upper($ch->language) }}]
						Chapter {{ $ch->chapter }}
						@if ($ch->chapter_title != null) - {{ $ch->chapter_title }} @endif
					</option>
					@endif
					@endforeach
				</select>
			</div>
			@if ($chapter->nextChapter() && $chapter->nextChapter()->chapterContent->count() >= 1)
			<div class="col col-6"> 
				<a href="{{ route('chapter.read', $chapter->nextChapter()->id) }}" class="btn btn-success btn-block">Next Chapter</a>
			</div>
			@endif
			@if ($chapter->previousChapter() && $chapter->previousChapter()->chapterContent->count() >= 1)
			<div class="col col-6"> 
				<a href="{{ route('chapter.read', $chapter->previousChapter()->id) }}" class="btn btn-success btn-block">Previous Chapter</a>
			</div>
			@endif
		</div>
	</div>
</div>
<div class="row justify-content-center">
	<!-- <div class="col-md-6">
		<button type="button" class="btn btn-primary mb-2" data-toggle="collapse" data-target="#comment" aria-expanded="false" aria-controls="comment">Show Comments</button>
	</div> -->
	<div class="col-md-6 col-12" id="comment">
		<div class="card bg-secondary sticky-top">
			<div class="card-body">
				<form method="post" action="{{ route('comment.store', $chapter->id) }}">
				@csrf
				@if (Auth::check())
				<div class="form-group">
					<label class="text-white">Comment :</label>
					<textarea class="form-control" rows="5" name="comment" required=""></textarea>
				</div>
				<div class="form-group">
					<button class="btn btn-light">Submit</button>
				</div>
				@else
				<div class="alert alert-info">Please <a href="{{ route('login') }}">Login</a> to comment. Or <a href="#">Register</a> an account first.</div>
				@endif
				<div class="form-group">
					<div class="list-group">
					@php
						$paginateComment = $chapter->comments()->paginate(15);
						$paginateComment->appends(['sort' => 'votes']);
					@endphp
					@foreach($paginateComment as $comment)

					<li class="list-group-item flex-column align-items-start">
						<div class="d-flex w-100 justify-content-between">
							<h6 class="mb-1">{{ '@' . $comment->user->username }} @if($comment->user->level == 'admin') [Admin] @endif</h6>
							<small>{{ $comment->created_at->diffForHumans() }}</small>
						</div>
						<p class="mb-1">
							{!! $comment->comment !!}
						</p>
						<small class="text-muted">- text small -</small>
					</li>

					@endforeach

					</div>
				</div>
				<div class="form-group">
					{{ $paginateComment->links() }}
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- <link rel="stylesheet" href="{{ asset('assets/js/listview-sorting-ordering/css/mobiscroll.jquery.min.css') }}"> -->
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <script src="{{ asset('assets/js/listview-sorting-ordering/js/mobiscroll.jquery.min.js') }}"></script> -->

<script>
	$(".resizable").resizable();
</script>

@endsection