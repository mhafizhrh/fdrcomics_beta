@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Comics</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('admin.comics') }}" class="btn btn-default mb-1"><i class="fa fa-arrow-left"></i> Back</a>
                    <a href="{{ route('admin.comics.new') }}" class="btn btn-default mb-1"><i class="fa fa-plus-square"></i> New Comic</a>
                    <a href="{{ route('admin.comics.chapters.new', $comic->id) }}" class="btn btn-default mb-1"><i class="fa fa-plus-square"></i> New Chapter</a>
                </div>
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-info mb-1">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success mb-1">{{ session('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Comic Detail</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.comics.update', $comic->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label class="col-md-4">Cover</label>
                                    <div class="col-md-8">
                                        <img src="@if (!$comic->img_path) {{ asset('storage/images/sancomics_cover.png') }} @else {{ asset('storage/'.$comic->img_path) }} @endif" class="img-fluid w-25 mb-2">
                                        <div class="custom-file">
                                            <input type="file" name="img_path" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Title</label>
                                    <div class="col-md-8">
                                        <input type="text" name="title" class="form-control" value="{{ $comic->title }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Author</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="author_id" required="">
                                            @foreach ($authors as $key)
                                            <option value="{{ $key->id }}" @if($key->id == $comic->author_id) selected @endif>{{ $key->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Language</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="language_id" required="">
                                            @foreach ($languages as $key)
                                            <option value="{{ $key->id }}" @if($key->id == $comic->language_id) selected @endif>{{ $key->language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Genre</label>
                                    <div class="col-md-8 row">
                                        @foreach ($genres as $key)
                                        <div class="col-md-3"><input type="checkbox" name="genre_id[]" value="{{ $key->id }}"
                                            @foreach($comic->comicGenre as $comicGenre)
                                            @if($key->id == $comicGenre->genre_id)
                                                checked=""
                                            @endif
                                            @endforeach
                                        > {{ $key->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Synopsis</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="synopsis" id="summernote">{{ $comic->synopsis }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Status</label>
                                    <div class="col-md-8">
                                        <input type="text" name="status" class="form-control" value="{{ $comic->status }}" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4"></label>
                                    <div class="col-md-8">
                                        <button class="btn btn-default float-right">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chapters</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($comic->chapters as $key)
                                <li class="list-group-item">
                                    <a href="{{ route('read', $key->id) }}" class="btn btn-default btn-sm float-right ml-1"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.comics.chapters.edit', $key->id) }}" class="btn btn-default btn-sm float-right ml-1"><i class="fas fa-edit"></i></a>
                                    Chapter {{ $key->chapter }}
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
@endsection
