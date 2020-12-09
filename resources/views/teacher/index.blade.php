@extends('teacher.master')

@section('head')
    <title>Home-page</title>
@endsection
@section('body')
    <div class="position-fixed top-0 left-0 d-flex justify-content-center vh-100 vw-100">
        <div class="align-self-center  col-lg-4 col-md-6 col-sm-8 col-12">
            <div class="card shadow-sm w-100 text-center text-black-50">
                <div class="card-header ">
                    <p class="h1 text-muted">Teacher Details</p>
                </div>
                <div class="card-body">
                    <b-icon class="h1 font-weight-bold" icon="person-circle"></b-icon>
                    <p class="h3 font-weight-bold">{{ ucfirst(auth()->user()->name) }}</p>
                    <p class="h5">Email: {{ ucfirst(auth()->user()->username ) }}</p>
                    <p class="h5">{{ $total_class }} classes in week</p>

                </div>
                <div class="card-footer">
{{--                    <a href="#" class="btn btn-light border">View schedule</a>--}}
                    <a href="{{ route('teacher.schedule') }}" class="btn btn-light border">View Schedule</a>
                </div>
            </div>

        </div>
    </div>
@endsection
