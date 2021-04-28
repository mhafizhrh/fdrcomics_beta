@extends('layout')
@section('sub-title', $chapter->comic->title . ' Chapter ' . $chapter->chapter)
@section('content')

<div class="row justify-content-center">
	<div class="col-md-6 col-12 px-xs-0 mb-2">
		@foreach($chapter->chapterContent as $chapterContent)
		<img src="{{ asset('storage/'.$chapterContent->img_path) }}" class="img-fluid">
		@endforeach
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