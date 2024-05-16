@extends('layout')
@section('title', 'Dashboard')
@section('content')
    <div class="flex flex-col justify-center items-center">
        <h1 class="m-4 text-3xl">Welcome {{ session('coachName') }}!</h1>
    </div>
@endsection
