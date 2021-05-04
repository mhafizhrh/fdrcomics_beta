@extends('layout')
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1 class="m-0">Settings</h1>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                            src="@if($user->img_path) {{ asset('storage/'. $user->img_path) }} @else {{ asset('storage/images/sancomics_cover.png') }}@endif" style="width:100px; height:100px; object-fit:cover;"
                            alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{ $user->name }}</h3>
                        <p class="text-muted text-center">{{ Str::ucfirst($user->role) }}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Bookmarks</b> <span class="float-right">{{ $user->bookmarks->count() }} Comic(s)</span>
                            </li>
                            <li class="list-group-item">
                                <b>Comic Rated</b> <span class="float-right">{{ $user->ratings->count() }} Comic(s)</span>
                            </li>
                            <li class="list-group-item">
                                <b>Comments</b> <span class="float-right">{{ $user->comments->count() }} Comment(s)</span>
                            </li>
                        </ul>
                        <a href="{{ route('logout') }}" class="btn btn-primary btn-block"><b>Logout</b></a>
                    </div>
                </div>
                <!-- <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Education</strong>
                        <p class="text-muted">
                            B.S. in Computer Science from the University of Tennessee at Knoxville
                        </p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                        <p class="text-muted">Malibu, California</p>
                        <hr>
                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                        <p class="text-muted">
                            <span class="tag tag-danger">UI Design</span>
                            <span class="tag tag-success">Coding</span>
                            <span class="tag tag-info">Javascript</span>
                            <span class="tag tag-warning">PHP</span>
                            <span class="tag tag-primary">Node.js</span>
                        </p>
                        <hr>
                        <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                    </div>
                </div> -->
            </div>
            <div class="col-md-9">
                @if ($errors->any())
                    <div class="alert alert-danger mb-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success mb-2">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mb-2">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active tablink activity" data-href="activity" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link tablink profile" data-href="profile" href="#profile" data-toggle="tab">Profile</a></li>
                            <li class="nav-item"><a class="nav-link tablink password" data-href="password" href="#password" data-toggle="tab">Password</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="activity">
                                @foreach ($user->comments()->paginate(10) as $key)

                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="@if($user->img_path) {{ asset('storage/'. $user->img_path) }} @else {{ asset('storage/images/sancomics_cover.png') }}@endif" alt="user image">
                                        <span class="username">
                                            <a href="#">{{ $key->user->name }}</a>
                                            <form class="float-right" method="post" action="{{ route('comment.delete', $key->id) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-link btn-sm py-0 my-0 confirm-delete"><i class="fas fa-times"></i></button>
                                            </form>
                                        </span>
                                        <span class="description">{{ $key->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p>
                                        {!! $key->comment !!}
                                    </p>
                                    <p>
                                        <a href="{{ route('read', $key->chapter_id) . '#comment-card' }}" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Go to comment</a>
                                    </p>
                                </div>

                                @endforeach

                                {{ $user->comments()->paginate(10)->links() }}
                            </div>
                            <div class="tab-pane" id="profile">
                                <form class="form-horizontal" method="post" action="{{ route('user.settings.profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-group row">
                                        <label for="exampleInputFile" class="col-md-4 col-sm-4 col-form-label d-flex align-items-center">Profile Picture</label>
                                        <div class="col-md-8 d-flex align-items-center">
                                            <img class="profile-user-img img-fluid img-circle mr-3" src="@if($user->img_path) {{ asset('storage/'. $user->img_path) }} @else {{ asset('storage/images/sancomics_cover.png') }}@endif" style="min-width:100px; height:100px; object-fit:cover;" alt="User profile picture">
                                            <div class="custom-file">
                                                <input type="file" name="img_path" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose File</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-md-4 col-sm-4 col-form-label">Name</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $user->name }}" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-md-4 col-sm-4 col-form-label">Email</label>
                                        <div class="col-md-8 col-sm-8">
                                            <span>{{ $user->email }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-md-4 col-sm-4 col-form-label">Username</label>
                                        <div class="col-md-8 col-sm-8">
                                            <span>{{ $user->username }}</span>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-md-4 offset-sm-4 col-sm-8 col-md-8">
                                            <button type="submit" class="btn btn-default">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="password">
                                <form class="form-horizontal" method="post" action="{{ route('user.settings.password.update') }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-group row">
                                        <label class="col-md-4 col-sm-4 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="password" class="form-control" name="current_password" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-sm-4 col-form-label">New Password</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="password" class="form-control" name="new_password" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-sm-4 col-form-label">New Password Confirmation</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="password" class="form-control" name="new_password_confirmation" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-md-4 offset-sm-4 col-sm-8 col-md-8">
                                            <button type="submit" class="btn btn-default">Save Password</button>
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
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // const navpills = document.getElementByTag("a[href='#Activity']");

        $(".tablink").on('click', function(e){

            window.localStorage.setItem('tab-pane-active', e.target.dataset.href);
            console.log(e);
        })

        if (window.localStorage.getItem("tab-pane-active")) {
            $(".tablink").removeClass('active');
            $(".tab-pane").removeClass('active');
            $("."+window.localStorage.getItem("tab-pane-active")).addClass('active');
            $("#"+window.localStorage.getItem("tab-pane-active")).addClass('active');
        }

        console.log(window.localStorage.getItem("tab-pane-active"));

        if (window.localStorage.getItem("tab-pane-active") == '') {

            $("#customSwitch3").attr('checked', true);
            $("body").addClass("dark-mode");
            $(".custom-control-label").html("Dark Mode");
            $(".main-header").addClass('navbar-dark');
            $(".main-header").removeClass('navbar-light');
        } else {

            $(".custom-control-label").html("Light Mode");
        }
    </script>
@endsection