@extends('layout')
@section('content-header')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-4">
				<h1 class="m-0">Read</h1>
			</div>
			<div class="col-sm-8">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
					<li class="breadcrumb-item">Read</li>
					<li class="breadcrumb-item"><a href="{{ route('comics', $chapter->comic->id) }}">{{ $chapter->comic->title }}</a></li>
					<li class="breadcrumb-item active">Chapter {{ $chapter->chapter }}</li>
				</ol>
			</div>
		</div>
	</div>
</div>
@endsection
@section('content.class')
@section('content')
<div class="content px-0 mx-0 mt-3">
	<div class="container-fluid px-0 mx-0">
		<div class="row justify-content-center px-0 mx-0">
			<div class="col-md-6">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<select class="form-control mb-2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="chapter-select">
							@foreach ($chapter->comic->chapters as $key)
							<option value="{{ route('read', $key->id) }}" @if ($key->id == $chapter->id) selected @endif>
								Chapter {{ $key->chapter }} @if ($key->title) {{ '- ' . $key->title }} @endif
							</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12 col-sm-12 col-12">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-6">
								<button type="button" class="btn btn-primary btn-block float-right mb-2" onclick="previousBtn()" id="prevBtn"><i class="fas fa-arrow-left"></i> Previous</button>
							</div>
							<div class="col-md-6 col-sm-6 col-6">
								<button type="button" class="btn btn-primary btn-block float-right mb-2" onclick="nextBtn()" id="nextBtn">Next <i class="fas fa-arrow-right"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12 col-sm-12 col-12 px-0 mx-0">
						@foreach($chapter->chapterContent as $chapterContent)
						<img src="{{ asset('storage/'.$chapterContent->img_path) }}" class="img-fluid mb-2">
						@endforeach
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12">
						<select class="form-control mb-2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="chapter-select2">
							@foreach ($chapter->comic->chapters as $key)
							<option value="{{ route('read', $key->id) }}" @if ($key->id == $chapter->id) selected @endif>
								Chapter {{ $key->chapter }} @if ($key->title) {{ '- ' . $key->title }} @endif
							</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12 col-sm-12 col-12">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-6">
								<button type="button" class="btn btn-primary btn-block float-right mb-2" onclick="previousBtn()" id="prevBtn2"><i class="fas fa-arrow-left"></i> Previous</button>
							</div>
							<div class="col-md-6 col-sm-6 col-6">
								<button type="button" class="btn btn-primary btn-block float-right mb-2" onclick="nextBtn()" id="nextBtn2">Next <i class="fas fa-arrow-right"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12 col-sm-12 col-12">
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
									<img class="img-circle img-sm" src="@if ($key->user->img_path) {{ asset('storage/' . $key->user->img_path) }} @else {{ asset('storage/images/sancomics_cover.png') }} @endif" alt="User Image">
									<div class="comment-text">
										<span class="username">
											{{ $key->user->name }}
											@if (Auth::check() && Auth::user()->id === $key->user_id)
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
								<form action="{{ route('comment.store', $chapter->id) }}" method="post">
									@csrf
									<img class="img-fluid img-circle img-sm" src="@if (Auth::user()->img_path) {{ asset('storage/' . Auth::user()->img_path) }} @else {{ asset('storage/images/sancomics_cover.png') }} @endif" alt="Alt Text">
									<div class="img-push">
										<!-- <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment" name="comment"> -->
										<div class="input-group">
											<textarea class="form-control" rows="3" placeholder="Press enter to post comment" name="comment"></textarea>
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
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('storage') }}/AdminLTE/plugins/jquery/jquery.min.js"></script>
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
	if ($("#chapter-select")[0].options[$("#chapter-select")[0].selectedIndex + 1]) {
		$("#nextBtn").attr('disabled', true);
	}
	if ($("#chapter-select")[0].options[$("#chapter-select")[0].selectedIndex - 1]) {
		$("#prevBtn").attr('disabled', true);
	}
	// SECOND BTN
	if ($("#chapter-select2")[0].options[$("#chapter-select2")[0].selectedIndex + 1]) {
		$("#nextBtn2").attr('disabled', true);
	}
	if ($("#chapter-select2")[0].options[$("#chapter-select2")[0].selectedIndex - 1]) {
		$("#prevBtn2").attr('disabled', true);
	}
})
function previousBtn() {
	const chapterSelect = $("#chapter-select");
	const previousSelected = (chapterSelect[0].selectedIndex + 1);
	const url = chapterSelect[0].options[previousSelected].value;
	console.log(previousSelected);
	if (url) {
		window.location = url;
	}
}
function nextBtn() {
	const chapterSelect = $("#chapter-select");
	const nextSelected = (chapterSelect[0].selectedIndex - 1);
	const url = chapterSelect[0].options[nextSelected].value;
	console.log(nextSelected);
	if (url) {
		window.location = url;
	}
}
</script>
@endsection