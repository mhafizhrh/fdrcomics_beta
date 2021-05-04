@extends('admin.layout')
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Comics</h1>
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
                <a href="{{ route('admin.comics.new') }}" class="btn btn-default mb-1"><i class="fa fa-plus-square"></i> New Comic</a>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Comics</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="table-responsive">
                            <table class="table table-striped" id="datatables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Language</th>
                                        <th>Total Chapter</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comics as $key)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $key->title }}</td>
                                        <td>{{ $key->authors->name }}</td>
                                        <td>{{ $key->languages->language }}</td>
                                        <td>{{ $key->totalChapter() }}</td>
                                        <td>
                                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i></button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('admin.comics.chapters.new', $key->id) }}" class="dropdown-item">New Chapter</a>
                                                <a href="{{ route('admin.comics.edit', $key->id) }}" class="dropdown-item">Edit</a>
                                                <a href="#" class="dropdown-item">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection