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
	    					@foreach ($bookmarks as $key)
                            <div class="col-md-4 mb-2">
                                <form method="post" action="{{ route('comics.bookmark', $key->comic->id) }}">
                                    @csrf
                                    <button class="btn btn-danger btn-sm float-right confirm-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <h5 class="mt-0"><a href="{{ route('comics', $key->comic->id) }}">{{ $key->comic->title }}</a></h5>
                                <img src="@if ($key->comic->img_path) {{ asset('storage/'.$key->comic->img_path) }} @else {{ asset('storage/images/sancomics_cover.png') }} @endif" width="100" class="img-thumbnail float-left mr-2">
                                <ul class="list-unstyled">
                                    @foreach ($key->comic->chapters as $key)
                                    <li>
                                        <a href="{{ route('read', $key->comic->id) }}">Chapter {{ $key->chapter }}</a>
                                        <span class="float-right">{{ $key->updated_at->diffForHumans() }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
							@endforeach
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
