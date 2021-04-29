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
                    <a href="{{ route('admin.comics.edit', $chapter->comic->id) }}" class="btn btn-default mb-1"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-1">
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
                            <form method="post" action="{{ route('admin.comics.chapters.delete', $chapter->id) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger float-right confirm-delete">Delete Chapter</button>
                            </form>
                            <h3 class="card-title">{{ $chapter->comic->title }} - Chapter {{ $chapter->chapter }}</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.comics.chapters.update', $chapter->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label class="col-md-4">Cover</label>
                                    <div class="col-md-8">
                                        <img src="@if (!$chapter->comic->img_path) {{ asset('storage/images/sancomics_cover.png') }} @else {{ asset('storage/'.$chapter->comic->img_path) }} @endif" class="img-fluid w-25 mb-2">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Title</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $chapter->comic->title }}" readonly="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Language</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="language_id" required="">
                                            @foreach ($languages as $key)
                                            <option value="{{ $key->id }}" @if($key->id == $chapter->comic->language_id) selected @endif>{{ $key->language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Chapter</label>
                                    <div class="col-md-8">
                                        <input type="text" name="chapter" class="form-control" required="" value="{{ $chapter->chapter }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Title</label>
                                    <div class="col-md-8">
                                        <input type="text" name="title" class="form-control" value="{{ $chapter->title }}">
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
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.comics.chapters.contents.store', $chapter->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="alert alert-info mb-2">
                                    <i class="fa fa-info-circle"></i> Information
                                    <ul>
                                        <li>Drag to reorder file.</li>
                                        <li>Click/Tap List to view image</li>
                                    </ul>
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
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <button class="btn btn-default float-right">Upload</button>
                                    </div>
                                </div>
                            </form>
                            <hr class="bg-light">
                            <form method="post" action="{{ route('admin.comics.chapters.contents.update', $chapter->id) }}">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <div class="list-group" id="fileSortable">
                                        @foreach ($chapter->chapterContent as $key)
                                        <div class="list-group-item" style="cursor: move;">
                                            <i class="fas fa-arrows-alt"></i>
                                            {{ explode('/', $key->img_path)[count(explode('/', $key->img_path)) - 1] }}
                                            <a href="{{ route('admin.comics.chapters.contents.delete', $key->id) }}" class="btn btn-danger float-right btn-sm confirm-delete-anchor"><i class="fas fa-trash"></i></a>
                                            <button type="button" class="btn btn-default btn-sm float-right mr-2" data-toggle="modal" data-target="#img-modal-{{ $loop->iteration }}"><i class="fas fa-eye"></i></button>
                                            <input type="text" name="id[]" value="{{ $key->id }}" readonly="" hidden="">
                                        </div>
                                        <div class="modal fade modal-img" id="img-modal-{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark text-white">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"><i class="fa fa-times text-white"></i></span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body p-0">
                                                        <img src="{{ asset('storage/'. $key->img_path) }}" class="img-responsive w-100 m-0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-default float-right">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="{{ asset('storage') }}/AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
<script type="text/javascript">

    Sortable.create(fileSortable, {
        swap: true,
        swapClass: "bg-light",
        animation: 150
    })

    $(".sortable").sortable({
        items: '> :not(.modal-img)'
    });
    $(".sortable").disableSelection();
</script>
@endsection
