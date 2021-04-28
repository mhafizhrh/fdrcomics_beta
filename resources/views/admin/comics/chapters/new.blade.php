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
                    <a href="{{ route('admin.comics.new') }}" class="btn btn-default mb-1"><i class="fa fa-plus-square"></i> New Comic</a>
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
                            <h3 class="card-title">New Chapter</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.comics.chapters.store', $comic->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="form-group row">
                                    <label class="col-md-4">Cover</label>
                                    <div class="col-md-8">
                                        <img src="@if (!$comic->img_path) {{ asset('storage/images/sancomics_cover.png') }} @else {{ asset('storage/'.$comic->img_path) }} @endif" class="img-fluid w-25 mb-2">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Title</label>
                                    <div class="col-md-8">
                                        <input type="text" name="title" class="form-control" value="{{ $comic->title }}" readonly="">
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
                                    <label class="col-md-4">Chapter</label>
                                    <div class="col-md-8">
                                        <input type="number" name="chapter" class="form-control" step="0.01" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Title</label>
                                    <div class="col-md-8">
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Upload Files</label>
                                    <div class="col-md-8">
                                        <div class="custom-file">
                                            <input type="file" name="img_path[]" class="custom-file-input" id="exampleInputFile" multiple="">
                                            <label class="custom-file-label">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4"></label>
                                    <div class="col-md-8">
                                        <button class="btn btn-default float-right">Add Chapter</button>
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
                                    <span class="float-right">{{ $key->updated_at->diffForHumans() }}</span>
                                    <a href="#">Chapter {{ $key->chapter }}</a>
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
