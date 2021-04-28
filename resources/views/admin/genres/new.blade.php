@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Genres</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('admin.genres') }}" class="btn btn-default mb-1"><i class="fa fa-tags"></i> Genres</a>
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
                            <h3 class="card-title"><i class="fa fa-plus-square"></i> New Genre</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.genres.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-4">Genre</label>
                                    <div class="col-md-8">
                                        <input type="text" name="name" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4"></label>
                                    <div class="col-md-8">
                                        <button class="btn btn-default float-right">Add Genre</button>
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
