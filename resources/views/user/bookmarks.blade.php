@extends('layout')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1 class="m-0">Bookmarks</h1>
                </div>
                <div class="col-sm-8">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Bookmarks</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bookmarks</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled">
                                    @foreach ($bookmarks as $key)
                                    <li class="media mb-2">
                                        <img class="mr-3 img-cover" src="{{ asset('storage/'.$key->comic->img_path) }}" alt="{{ $key->comic->title }} cover">
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-0 text-row-1"><i class="flag-icon flag-icon-{{ $key->comic->languages->flag_icon_code }}"></i> <a href="{{ route('comics', $key->comic->id) }}">{{ $key->comic->title }}</a></h5>
                                            <div>
                                                <form method="post" action="{{ route('comics.bookmark', $key->comic->id) }}" class="float-right">
                                                    @csrf
                                                    @if (Auth::check() && $key->comic->bookmark)
                                                    <a href="javascript:void(0);" class="badge badge-success" onclick="$(this).parents('form').submit();"><i class="fa fa-check"></i> Bookmarked</a>
                                                    @else
                                                    <a href="javascript:void(0);" class="badge badge-primary" onclick="$(this).parents('form').submit();"><i class="fa fa-book"></i> Bookmark</a>
                                                    @endif
                                                </form>
                                                Rating : {{ round($key->comic->ratings()->rating, 2) }}
                                            </div>
                                            <ul class="list-unstyled">
                                                @foreach ($key->comic->chapters()->limit(4)->get() as $key)
                                                <li>
                                                    <a href="{{ route('read', $key->comic->id) }}">
                                                        <i class="flag-icon flag-icon-{{ $key->languages->flag_icon_code }}"></i> Chapter {{ $key->chapter }}
                                                    </a>
                                                    <span class="float-right">{{ $key->updated_at->diffForHumans() }}</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-12">
                                {{ $bookmarks->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection