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
            <div class="col-md-12">
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
                                    <div class="col-md-12">
                                        <ul class="list-unstyled">
                                            @foreach ($comics as $key)
                                            <li class="media mb-2">
                                                <img class="mr-3 img-cover" src="{{ asset('storage/'.$key->img_path) }}" alt="{{ $key->title }} cover">
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-0 text-row-1"><i class="flag-icon flag-icon-{{ $key->languages->flag_icon_code }}"></i> <a href="{{ route('comics', $key->id) }}">{{ $key->title }}</a></h5>
                                                    <div>
                                                        <form method="post" action="{{ route('comics.bookmark', $key->id) }}" class="float-right">
                                                            @csrf
                                                            @if (Auth::check() && $key->bookmark)
                                                            <a href="javascript:void(0);" class="badge badge-success" onclick="$(this).parents('form').submit();"><i class="fa fa-check"></i> Bookmarked</a>
                                                            @else
                                                            <a href="javascript:void(0);" class="badge badge-primary" onclick="$(this).parents('form').submit();"><i class="fa fa-book"></i> Bookmark</a>
                                                            @endif
                                                        </form>
                                                        Rating : {{ round($key->ratings()->rating, 2) }}
                                                    </div>
                                                    <ul class="list-unstyled">
                                                        @foreach ($key->chapters()->limit(4)->get() as $key)
                                                        <li>
                                                            <a href="{{ route('read', $key->id) }}">
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
                                                <div class="col-md-8">
                                                    <input type="text" name="title" class="form-control" value="{{ $request->title }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">Genres</label>
                                                <div class="col-md-8 row">
                                                    <!-- <input type="checkbox" name="genres[]" value="" hidden="" checked=""> -->
                                                    @foreach ($genres as $key)
                                                    <div class="col-md-3 col-sm-4 col-6">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="remember{{ $key->id }}" value="{{ $key->id }}" name="genres[]" @if ($request->genres && in_array($key->id, $request->genres)) checked @endif>
                                                            <label for="remember{{ $key->id }}">
                                                                {{ $key->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">Main Language</label>
                                                <div class="col-md-8 row">
                                                    <!-- <input type="checkbox" name="genres[]" value="" hidden="" checked=""> -->
                                                    <select class="form-control" name="language">
                                                        @foreach ($languages as $key)
                                                        <option value="{{ $key->id }}" @if ($key->id == $request->language) selected @endif>{{ $key->language }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="col-md-12">
                                                        <p><i class="fa fa-info-circle"></i> Main language is the language that comes from raw.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">Only Bookmarks (Log In required)</label>
                                                <div class="col-md-8">
                                                    <input type="checkbox" name="bookmarks" value="yes" @if (! Auth::check()) disabled @endif @if ($request->bookmarks) checked @endif> Yes
                                                    <p><i class="fa fa-info-circle"></i> Select <b>Yes</b> if you want search only the comics in your bookmarks.</p>
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
        </div>
    </div>
</div>
@endsection