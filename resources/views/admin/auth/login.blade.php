<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Register</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap5.min.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6 col-12">
            <img src="{{ asset('image/reg.student.jpg') }}" alt="" width="100%">
        </div>
        <div class="col-md-6 col-12 align-self-center">
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif
            <div class="card">
                <div class="card-header">
                    <p class="lead">Admin login</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.login') }}" method="post">
                        @csrf
                        <div class="mb-2">
                            <label class="d-none" for="username"></label>
                            <input type="text" id="username" name="username" placeholder="Username"
                                   class="form-control @error('username') is-invalid @enderror ">
                            @error('username')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="password"></label>
                            <input type="password" id="password" name="password" placeholder="Password"
                                   class="form-control @error('password') is-invalid @enderror ">
                            @error('password')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
