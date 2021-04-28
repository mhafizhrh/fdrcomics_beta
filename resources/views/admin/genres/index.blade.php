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
                    <a href="{{ route('admin.genres.new') }}" class="btn btn-default mb-1"><i class="fa fa-plus-square"></i> New Genre</a>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Genres</h3>
                        </div>
                        <div class="card-body">
                            @foreach ($genres as $key)

                            <a href="#" class="btn btn-default mb-1">{{ $key->name }} <span class="badge badge-light">{{ $key->totalComics() }}</span></a>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
