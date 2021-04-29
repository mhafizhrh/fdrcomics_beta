@extends('layout')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1 class="m-0">Comics</h1>
                </div>
                <div class="col-sm-8">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Comics</li>
                        <li class="breadcrumb-item">{{ $comic->title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <form method="post" action="{{ route('comics.rating', $comic->id) }}">
                            @csrf
                            <div class="input-group w-50 float-right">
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
                        <form method="post" action="{{ route('comics.bookmark', $comic->id) }}">
                            @csrf
                            @if ($bookmark)
                            <button class="btn btn-primary"><i class="fas fa-check"></i> Bookmarked</button>
                            @else
                            <button class="btn btn-info"><i class="fas fa-book"></i> Bookmark</button>
                            @endif
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <img src="{{ asset('storage/'.$comic->img_path) }}" class="img-thumbnail mb-2" style="max-width: 200px; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Title</label>
                                    <div class="col-md-8">
                                        {{ $comic->title }}
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Author</label>
                                    <div class="col-md-8">
                                        {{ $comic->authors->name }}
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Language</label>
                                    <div class="col-md-8">
                                        {{ $comic->languages->language }}
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Genre</label>
                                    <div class="col-md-8">
                                        @foreach ($comic->comicGenre as $key)
                                        <a href="#" class="badge badge-info">{{ $key->genre->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Status</label>
                                    <div class="col-md-8">
                                       {{ $comic->status }}
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Rating</label>
                                    <div class="col-md-8">
                                       {{ round($comic->ratings()->rating, 2) }} (Rated by {{ $comic->ratings()->users }} participants)
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Synopsis</label>
                                    <div class="col-md-8" style="max-height: 500px; overflow-y: auto;">
                                        {!! $comic->synopsis !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($comic->chapters as $key)
                            <li class="list-group-item">
                                <span class="float-right">{{ $key->updated_at->diffForHumans() }}</span>
                                <a href="{{ route('read', $key->id) }}">Chapter {{ $key->chapter }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
