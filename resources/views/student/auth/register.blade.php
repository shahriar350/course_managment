<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Register</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap5.min.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6 col-12">
            <img src="{{ asset('image/reg.student.jpg') }}" alt="" width="100%">
        </div>
        <div class="col-md-6 col-12 align-self-center">
            <div class="card">
                <div class="card-header">
                    <p class="lead">Student Registration</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('student.register') }}" method="post">
                        @csrf
                        <div class="mb-2">
                            <label class="d-none" for="name"></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Name"
                                   class="form-control @error('name') is-invalid @enderror ">
                            @error('name')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="username"></label>
                            <input type="email" id="username" name="username" value="{{ old('username') }}" placeholder="Email"
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
                            <label class="d-none" for="password"></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror ">
                            @error('password_confirmation')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2 pt-2 border-top">
                            <label class="d-none" for="gender"></label>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror ">
                                <option value="" selected disabled>Select a gender</option>
                                <option value="woman">Woman</option>
                                <option value="man">Man</option>
                            </select>

                            @error('gender')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="age"></label>
                            <input type="number" id="age" name="age" value="{{ old('age') }}" placeholder="Age"
                                   class="form-control @error('age') is-invalid @enderror ">
                            @error('age')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="school"></label>
                            <input type="text" id="school" name="school" placeholder="School"
                                   class="form-control @error('school') is-invalid @enderror ">
                            @error('school')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="department"></label>
                            <input type="text" id="department" name="department" placeholder="Department"
                                   class="form-control @error('department') is-invalid @enderror ">
                            @error('department')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="student_id"></label>
                            <input type="text" id="student_id" name="student_id" placeholder="Student ID"
                                   class="form-control @error('student_id') is-invalid @enderror ">
                            @error('student_id')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <a class="btn btn-light" href="{{ route('student.login') }}">login</a>
                            <button class="btn btn-primary" type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
