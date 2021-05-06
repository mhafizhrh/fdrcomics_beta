@extends('layout')
@section('title', $comic->title)
@section('description', strip_tags($comic->synopsis))
@section('keywords') {{ Str::of($comic->title)->replace(' ', ',') }} @foreach ($comic->comicGenre as $key),{{ $key->genre->name }}@endforeach @endsection
@section('image', asset('storage/' . $comic->img_path))
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1 class="m-0">Comics</h1>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Comics</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img src="{{ asset('storage/'.$comic->img_path) }}" class="img-fluid img-thumbnail mb-1" style="max-width: 200px; object-fit: cover;">
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-8 text-center">
                                    <form method="post" action="{{ route('comics.bookmark', $comic->id) }}" class="float-right">
                                        @csrf
                                        @if ($bookmark)
                                        <button class="btn btn-success mb-1"><i class="fas fa-check"></i> Bookmarked</button>
                                        @else
                                        <button class="btn btn-primary mb-1"><i class="fas fa-book"></i> Bookmark</button>
                                        @endif
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <form method="post" action="{{ route('comics.rating', $comic->id) }}">
                                        @csrf
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rating</span>
                                            </div>
                                            <select class="form-control" name="rating" onchange="this.form.submit()">
                                                <option value="unrate" selected="">Rate</option>
                                                @for ($i = 10; $i >= 1; $i--)
                                                
                                                <option @if($rating && $rating->rating == $i) selected @endif>{{ $i }}</option>
                                                
                                                @endfor
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <hr class="bg-light">
                                    <div class="row">
                                        <label class="col-md-4 mb-0">Title</label>
                                        <div class="col-md-8 mb-3">
                                            {{ $comic->title }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 mb-0">Author</label>
                                        <div class="col-md-8 mb-3">
                                            {{ $comic->authors->name }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 mb-0">Main Language</label>
                                        <div class="col-md-8 mb-3">
                                            <i class="flag-icon flag-icon-{{ $comic->languages->flag_icon_code }}"></i> {{ $comic->languages->language }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 mb-0">Genre</label>
                                        <div class="col-md-8 mb-3">
                                            @foreach ($comic->comicGenre as $key)
                                            <a href="{{ route('search', ['genres[]' => $key->genre_id]) }}" class="badge badge-info">
                                                {{ $key->genre->name }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 mb-0">Status</label>
                                        <div class="col-md-8 mb-3">
                                            {{ $comic->status }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 mb-0">Rating</label>
                                        <div class="col-md-8 mb-3">
                                            {{ round($comic->ratings()->rating, 2) }} (Rated by {{ $comic->ratings()->users }} participants)
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 mb-0">Synopsis</label>
                                        <div class="col-md-8 mb-3">
                                            {!! $comic->synopsis !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chapters</h3>
                </div>
                <div class="card-body">
                    <input type="text" id="keyword" placeholder="Search chapter..." class="form-control mb-2">
                    <ul class="list-group" id="chapter-list" style="max-height: 1000px; overflow: auto;">
                        @foreach ($comic->chapters as $key)
                        <li class="list-group-item">
                            <span class="float-right">{{ $key->updated_at->diffForHumans() }}</span>
                            <a href="{{ route('read', $key->id) }}"><i class="flag-icon flag-icon-{{ $key->languages->flag_icon_code }}"></i> Chapter {{ $key->chapter }} @if ($key->title) - {{ $key->title }} @endif</a>
                        </li>
                        @endforeach
                    </ul>
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
$("#chapter-list li").filter(function() {
$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
});
});
});
</script>
@endsection