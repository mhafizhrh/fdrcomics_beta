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
                    <a href="{{ route('admin.comics') }}" class="btn btn-default mb-1"><i class="fa fa-pencil-alt"></i> Comics</a>
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
                            <h3 class="card-title"><i class="fa fa-plus-square"></i> New Comic</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.comics.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-4">Title</label>
                                    <div class="col-md-8">
                                        <input type="text" name="title" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Author</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="author_id" required="">
                                            @foreach ($authors as $key)
                                            <option value="{{ $key->id }}" @if($key->id == old('author_id')) selected @endif>{{ $key->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Language</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="language_id" required="">
                                            @foreach ($languages as $key)
                                            <option value="{{ $key->id }}" @if($key->id == old('language_id')) selected @endif>{{ $key->language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Genre</label>
                                    <div class="col-md-8 row">
                                        @foreach ($genres as $key)
                                        <div class="col-md-3"><input type="checkbox" name="genre_id[]" value="{{ $key->id }}"> {{ $key->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Synopsis</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="synopsis" rows="7">{{ old('synopsis') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Status</label>
                                    <div class="col-md-8">
                                        <input type="text" name="status" class="form-control" value="{{ old('status') }}" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4"></label>
                                    <div class="col-md-8">
                                        <button class="btn btn-default float-right">Add Comic</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
