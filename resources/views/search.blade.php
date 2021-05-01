@extends('layout')
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1 class="m-0">Search</h1>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Search</li>
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a href="#result" class="nav-link active" data-toggle="tab">Result</a></li>
                            <li class="nav-item"><a href="#filter" class="nav-link" data-toggle="tab">Filter</a></li>
                        </ul>
                        <!-- <h3 class="card-title">Filter</h3> -->
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="result">
                                <div class="row">
                                    @foreach ($comics as $key)
                                    <div class="col-md-6 mb-2">
                                        <form method="post" action="{{ route('comics.bookmark', $key->id) }}">
                                            @csrf
                                            @if (Auth::check() && $key->bookmark)
                                            <button class="btn btn-danger btn-sm float-right confirm-delete">
                                            <i class="fas fa-trash"></i>
                                            </button>
                                            @else
                                            <button class="btn btn-info btn-sm float-right">
                                            <i class="fas fa-book"></i>
                                            </button>
                                            @endif
                                        </form>
                                        <h5 class="mt-0 text-row-2"><a href="{{ route('comics', $key->id) }}">{{ $key->title }}</a></h5>
                                        <img src="@if ($key->img_path) {{ asset('storage/'.$key->img_path) }} @else {{ asset('storage/images/sancomics_cover.png') }} @endif" width="100" class="img-thumbnail float-left mr-2">
                                        <ul class="list-unstyled">
                                            @foreach ($key->chapters as $key)
                                            <li>
                                                <a href="{{ route('read', $key->id) }}">[{{ Str::upper($key->languages->code) }}] Chapter {{ $key->chapter }}</a>
                                                <span class="float-right">{{ $key->updated_at->diffForHumans() }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                    @if ($comics->count() <= 0)
                                    <div class="col-md-12">
                                        <div class="alert alert-default text-warning">
                                            <i class="fas fa-exclamation-triangle"></i> The filter didn't find any results.
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        {{ $comics->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="filter">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="get">
                                            <div class="form-group row">
                                                <label class="col-md-4">Title</label>
                                                <div class="col-md-8 row">
                                                    <input type="text" name="title" class="form-control" value="{{ $request->title }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">Genres</label>
                                                <div class="col-md-8 row">
                                                    <!-- <input type="checkbox" name="genres[]" value="" hidden="" checked=""> -->
                                                    @foreach ($genres as $key)
                                                    <div class="col-md-3 col-sm-4 col-6">
                                                        <input type="checkbox" value="{{ $key->id }}" name="genres[]" @if ($request->genres && in_array($key->id, $request->genres)) checked @endif> {{ $key->name }}
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <button class="btn btn-default offset-md-4">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Weekly Popular Chapter</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    @foreach ($weeklyPopularChapters as $key)
                                    <li class="media mb-2">
                                        <img src="{{ asset('storage/'. $key->chapter->comic->img_path) }}" class="mr-3" style="width: 64px; height: 64px; object-fit: cover;">
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1 text-row-2"><a href="{{ route('comics', $key->chapter->comic->id) }}">{{ $key->chapter->comic->title }}</a></h6>
                                            <a href="{{ route('read', $key->chapter->id) }}">Chapter {{ $key->chapter->chapter }}</a>
                                            <span class="float-right"><i class="fas fa-eye"></i> {{ number_format($key->visitedCount, 0, ',', '.') }}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Popular Comics</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    @foreach ($popularComics as $key)
                                    <li class="media mb-2">
                                        <img src="{{ asset('storage/'. $key->comic->img_path) }}" class="mr-3" style="width: 64px; height: 64px; object-fit: cover;">
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1 two-line-text"><a href="{{ route('comics', $key->comic->id) }}">{{ $key->comic->title }}</a></h6>
                                            <span><i class="fas fa-users"></i> {{ number_format($key->userBookmarks, 0, ',', '.') }}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection