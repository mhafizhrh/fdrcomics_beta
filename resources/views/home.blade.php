@extends('layout')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Home</h1>
                </div>
            </div>
        </div>
    </div>
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
                    <div class="card">
                        <div class="card-body">
                            <ol>
                                @foreach ($visitors as $key)
                                <li>{{ $key->chapter->comic->distinct('2')->first()->title }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
