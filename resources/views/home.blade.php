@extends('layout')
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Home</h1>
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
                        <h3 class="card-title">Recent Update</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($comics as $key)
                            <div class="col-md-6 mb-2">
                                <h5 class="mt-0"><a href="{{ route('comics', $key->id) }}">{{ $key->title }}</a></h5>
                                <img src="@if ($key->img_path) {{ asset('storage/'.$key->img_path) }} @else {{ asset('storage/images/sancomics_cover.png') }} @endif" width="100" class="img-thumbnail float-left mr-2">
                                <ul class="list-unstyled">
                                    @foreach ($key->chapters as $key)
                                    <li>
                                        <a href="{{ route('read', $key->id) }}">Chapter {{ $key->chapter }}</a>
                                        <span class="float-right">{{ $key->updated_at->diffForHumans() }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {{ $comics->links() }}
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
                                            <h6 class="mt-0 mb-1 two-line-text"><a href="{{ route('comics', $key->chapter->comic->id) }}">{{ $key->chapter->comic->title }}</a></h6>
                                            Chapter {{ $key->chapter->chapter }}
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