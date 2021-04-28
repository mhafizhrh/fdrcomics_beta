@extends('layout')
@section('sub-title', $comic->title)
@section('content')

<div class="row">
	<div class="col-md-4">
		<div class="card bg-dark text-white mb-2">
			<div class="card-header">{{ $comic->type }}</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-md-6 col-6">
						<img src="{{ asset('storage/'.$comic->cover_img_url) }}" class="img-thumbnail img-fluid mb-2">
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
				<div class="row">
					<label class="col-md-4 col-4">Chapter</label>
					<div class=" col-md-8 col-8">
						<select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
							@foreach($comic->chapter as $ch)
							<option value="{{ route('chapter.edit', $ch->id) }}" @if ($ch->chapter == $chapter->chapter) selected @endif>
								[{{ Str::upper($ch->language) }}] 
								Chapter {{ $ch->chapter }} @if ($ch->chapter_title != null) - {{ $ch->chapter_title }} @endif
							</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<form method="post" action="{{ route('chapter.delete') }}">
							@csrf
							@method('delete')
							<input type="text" name="chapter_id" value="{{ $chapter->id }}" readonly="" hidden="">
							<button class="btn btn-danger btn-block mt-3">Delete Chapter</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card bg-dark text-white">
			<div class="card-header">
				[{{ Str::upper($ch->language) }}] 
				Chapter {{ $ch->chapter }} @if ($ch->chapter_title != null) - {{ $ch->chapter_title }} @endif
			</div>
			<div class="card-body">
				
				@if (session('status'))
				<div class="form-group">
					<div class="alert alert-success">{{ session('status') }}</div>
				</div>
				@endif
				<div class="form-group">
					<div class="alert alert-info mb-2">
						<i class="fa fa-info-circle"></i> Information
						<ul>
							<li>Drag to reorder file.</li>
							<li>Click/Tap List to view image</li>
						</ul>
					</div>
					<form method="post" action="{{ route('chapter.content.store', $chapter->id) }}" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-md-9 col-12 mb-2">
								<input type="file" name="image[]" class="form-control form-control-sm" multiple="">
							</div>
							<div class="col-md-3 col-12">
								<button class="btn btn-success btn-block float-right">Upload Image</button>
							</div>
						</div>
					</form>
					<form method="post" action="{{ route('comic.chapter.content.update', ['comic_id' => $comic->id, 'title' => Str::lower(Str::of($comic->title)->replace(' ', '-')), 'chapter' => $chapter->chapter]) }}">
						@csrf
						@method('PUT')
							<div class="list-group mb-2" id="fileSortable" style="max-height: 500px; overflow-y: scroll;">
								@foreach($chapter->chapterContent as $chapterContent)

									<div class="list-group-item text-dark" style="cursor: move">
										<i class="fa fa-arrows-alt"></i>

										{{ Str::of($chapterContent->img_path)->explode('/')[count(Str::of($chapterContent->img_path)->explode('/'))-1] }}

										<a href="{{ route('chapter.content.delete', ['chapter_id' => $chapter->id, 'chapter_content_id' => $chapterContent->id]) }}" class="btn btn-danger btn-sm float-right confirm-delete-anchor" id="confirm-delete-anchor-{{ $loop->iteration }}">
											<i class="fa fa-trash"></i>
										</a>

										<button type="button" class="btn btn-info btn-sm float-right mx-1" data-toggle="modal" data-target="#img-modal-{{ $loop->iteration }}"><i class=" fa fa-eye"></i></button>
									</div>
									<div class="modal fade modal-img" id="img-modal-{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									    <div class="modal-dialog modal-dialog-centered" role="document">
									        <div class="modal-content">
									            <div class="modal-header bg-dark text-white">
									                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									                <span aria-hidden="true"><i class="fa fa-times text-white"></i></span>
									                </button>
									            </div>
									            <div class="modal-body p-0">
									                <img src="{{ asset('storage/'.$chapterContent->img_path) }}" class="img-responsive w-100 m-0">
									            </div>
									        </div>
									    </div>
									</div>

								@endforeach
							</div>
							<button class="btn btn-success btn-block mb-2">Save File Order</button>
					</form>
					<form method="post" action="{{ route('chapter.content.delete.all', $chapter->id) }}">
						@csrf
						@method('DELETE')
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-danger btn-block float-left confirm-delete">Delete All Image</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <link rel="stylesheet" href="{{ asset('assets/js/listview-sorting-ordering/css/mobiscroll.jquery.min.css') }}"> -->
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <script src="{{ asset('assets/js/listview-sorting-ordering/js/mobiscroll.jquery.min.js') }}"></script> -->
<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
<script type="text/javascript">

	Sortable.create(fileSortable, {
		swap: true,
		swapClass: "highlight",
		animation: 150
	})

	$(".sortable").sortable({
		items: '> :not(.modal-img)'
	});
	$(".sortable").disableSelection();
</script>

@endsection