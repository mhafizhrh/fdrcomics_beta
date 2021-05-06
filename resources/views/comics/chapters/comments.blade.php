@extends('layout')
@section('title', $comments->first()->chapter->comic->title . ' in ' . $comments->first()->chapter->languages->language)
@section('description', strip_tags($comments->first()->chapter->comic->synopsis))
@section('keywords') {{ Str::of($comments->first()->chapter->comic->title)->replace(' ', ',') }} @foreach ($comments->first()->chapter->comic->comicGenre as $key),{{ $key->genre->name }}@endforeach, {{ $comments->first()->chapter->languages->language }} @endsection
@section('image', asset('storage/' . $comments->first()->chapter->comic->img_path))
@section('content-header')
<div class="content-header">
	<div class="row mb-2">
		<div class="col-sm-4 col-4">
			<h1 class="m-0">Comments</h1>
		</div>
		<div class="col-sm-8 col-8">
			<ol class="breadcrumb float-sm-right float-right">
				<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
				<li class="breadcrumb-item">Comments</li>
				<li class="breadcrumb-item active"><a href="{{ route('read', $comments->first()->chapter->id) }}">{{ $comments->first()->chapter->comic->title }} Chapter {{ $comments->first()->chapter->chapter }}</a></li>
			</ol>
		</div>
	</div>
</div>
@endsection
@section('content.class')
@section('content')
<div class="content">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-body">
					<div class="form-group row">
						<label class="col-md-4 col-sm-4 col-4">Title</label>
						<div class="col-md-8 col-sm-8 col-8">
							<i class="flag-icon flag-icon-{{ $comments->first()->chapter->comic->languages->flag_icon_code }}"></i> <a href="{{ route('comics', $comments->first()->chapter->comic->id) }}">{{ $comments->first()->chapter->comic->title }}</a>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 col-sm-4 col-4">Chapter</label>
						<div class="col-md-8 col-sm-8 col-8">
							{{ $comments->first()->chapter->chapter }}
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 col-sm-4 col-4">Translate</label>
						<div class="col-md-8 col-sm-8 col-8">
							<i class="flag-icon flag-icon-{{ $comments->first()->chapter->languages->flag_icon_code }}"></i> {{ $comments->first()->chapter->languages->language }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card" id="comment-card">
				<div class="card-header">
					<h3 class="card-title">Comments</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool btn-tool-comment" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
					</div>
				</div>
				<div class="card-body card-comments">
					<div class="card-comment">
						@foreach ($comments as $key)
						<img class="img-circle img-sm" src="@if ($key->user->img_path) {{ asset('storage/' . $key->user->img_path) }} @else {{ asset('storage/images/fdrcomics-logo.png') }} @endif" alt="User Image">
						<div class="comment-text">
							<span class="username">
								{{ $key->user->name }}
								@if (Auth::check() && Auth::user()->id === $key->user_id || Auth::user()->role == 'admin')
								<form class="float-right" method="post" action="{{ route('comment.delete', $key->id) }}">
									@csrf
									@method('delete')
									<button class="btn btn-link btn-sm py-0 my-0 confirm-delete"><i class="fas fa-times"></i></button>
								</form>
								@endif
								<span class="text-muted float-right">{{ $key->created_at->diffForHumans() }}</span>
							</span>
							<div class="text-row-10" onclick="toggleEllipsis()">{!! $key->comment !!}</div>
						</div>
						@endforeach
					</div>
				</div>
				<div class="card-footer">
					@if (Auth::check())
					<form action="{{ route('comment.store', $comments->first()->chapter->id) }}" method="post">
						@csrf
						<img class="img-fluid img-circle img-sm" src="@if (Auth::user()->img_path) {{ asset('storage/' . Auth::user()->img_path) }} @else {{ asset('storage/images/fdrcomics-logo.png') }} @endif" alt="Alt Text">
						<div class="img-push">
							<!-- <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment" name="comment"> -->
							<div class="input-group">
								<textarea class="form-control" rows="3" placeholder="Comment here..." name="comment"></textarea>
								<div class="input-group-append">
									<button class="btn btn-default"><i class="fas fa-paper-plane"></i></button>
								</div>
							</div>
						</div>
					</form>
					@else
					<a href="{{ route('login') }}">Login</a> to comment. or <a href="{{ route('register') }}">Register</a> an account.
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6 offset-md-3">
			{{ $comments->links() }}
		</div>
	</div>
</div>
@endsection
@section('js')
<script>
$(document).ready(function(){
	$(".btn-tool-comment").on('click', function(){
		if (window.localStorage.getItem("comment") == "collapsed-card") {
			window.localStorage.setItem("comment", "");
		} else {
			window.localStorage.setItem("comment", "collapsed-card");
		}
	});
	$("#comment-card").addClass(window.localStorage.getItem("comment"));
	console.log(window.localStorage.getItem("comment"));
})
</script>
@endsection