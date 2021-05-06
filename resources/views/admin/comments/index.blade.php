@extends('admin.layout')
@section('content-header')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-4">
				<h1 class="m-0">Comments</h1>
			</div>
			<div class="col-sm-8">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
					<li class="breadcrumb-item active"><a href="{{ route('admin.comments') }}">Comments</a></li>
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
						@foreach ($comments as $key)
						<div class="post">
							<div class="user-block">
								<img class="img-circle img-bordered-sm" src="@if($key->user->img_path) {{ asset('storage/'. $key->user->img_path) }} @else {{ asset('storage/images/fdrcomics-logo.png') }}@endif" alt="user image">
								<span class="username">
									<a href="#">{{ $key->user->name }}</a>
									<form class="float-right" method="post" action="{{ route('comment.delete', $key->id) }}">
										@csrf
										@method('delete')
										<button class="btn btn-link btn-sm py-0 my-0 confirm-delete"><i class="fas fa-times"></i></button>
									</form>
								</span>
								<span class="description">{{ $key->created_at->diffForHumans() }}</span>
							</div>
							<p>
								{!! $key->comment !!}
							</p>
							<p>
								<a href="{{ route('comments', $key->chapter_id) . '#comment-card' }}" class="link-black text-sm mr-2" target="_blank"><i class="fas fa-share mr-1"></i> Go to comment</a>
							</p>
						</div>
						@endforeach
						{{ $comments->links() }}
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