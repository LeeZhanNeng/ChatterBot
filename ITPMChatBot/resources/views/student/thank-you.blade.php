@extends('empty-layout')

@section('content')

    <div class="container">
        <div class="text-center">
            <h2>Thanks for submit your Exam, {{ Auth::user()->name }}</h2>
            <p>We will review your Exam, and update your as soon as posible by Mail</p>
            <a href="{{ route('returnPage') }}" class="btn btn-info">Go Back</a>
        </div>
    </div>

@endsection