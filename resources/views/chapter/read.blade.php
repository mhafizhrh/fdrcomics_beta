@extends('layout')
@section('content')
<div class="content-wrapper">
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
    <div class="content px-0 mx-0">
    	<div class="row justify-content-center px-0 mx-0">
    		<div class="col-md-6 col-sm-12 col-12 px-0 mx-0">
		    	@foreach($chapter->chapterContent as $chapterContent)
		        <img src="{{ asset('storage/'.$chapterContent->img_path) }}" class="img-fluid">
		        @endforeach
		    </div>
		</div>
    </div>
</div>
@endsection
