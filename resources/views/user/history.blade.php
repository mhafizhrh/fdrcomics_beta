@extends('layout')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1 class="m-0">History</h1>
                </div>
                <div class="col-sm-8">
		            <ol class="breadcrumb float-sm-right">
		                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
		                <li class="breadcrumb-item">History</li>
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
    					<h3 class="card-title">History</h3>
    				</div>
    				<div class="card-body">
    					<div class="row">
	    					@foreach ($history as $key)
							<div class="col-lg-2 col-md-2 col-sm-6 col-6">
								<div class="card text-center mb-2">
									<img src="{{ asset('storage/'.$key->chapter->comic->img_path) }}" class="card-img-top" style="max-height: 200px; object-fit: cover;">
									<div class="card-body px-2 py-2">
										<a href="{{ route('comics', $key->chapter->comic->id) }}" class="text-row-1">{{ $key->chapter->comic->title }}</a>
										<hr class="bg-white">
										<a href="{{ route('read', $key->chapter->id) }}">Chapter {{ $key->chapter->chapter }}</a>
									</div>
								</div>
							</div>
							@endforeach
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@endsection
