@extends('student.master')

@section('head')
    <title>Home-page</title>
@endsection
@section('body')
    <div class="position-fixed top-0 left-0 d-flex justify-content-center vh-100 vw-100">
        <div class="align-self-center  col-lg-4 col-md-6 col-sm-8 col-12">
            <div class="card shadow-sm w-100 text-center text-black-50">
                <div class="card-header ">
                    <p class="h1 text-muted">Student Details</p>
                </div>
                <div class="card-body">
                    <b-icon class="h1 font-weight-bold" icon="person-circle"></b-icon>
                    <p class="h3 font-weight-bold">{{ ucfirst(auth()->user()->name) }}</p>
                    <p class="h5">ID: {{ ucfirst(auth()->user()->student_id ) }}</p>
                    <p class="h5">Email: {{ ucfirst(auth()->user()->username ) }}</p>
                    <p class="h5">{{ ucfirst(auth()->user()->school ) }}</p>
                    <p class="h5">{{ ucfirst(auth()->user()->department ) }}</p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-light border">View schedule</a>
                    <a href="{{ route('student.course') }}" class="btn btn-light border">Take Course</a>
                </div>
            </div>

        </div>
    </div>
@endsection
