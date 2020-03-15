@extends('layouts.main')

@section('title', 'Weather forecast for ' . ucfirst($city))

@section('content')
    @if($errorMessage)<p class="alert alert-danger">{{ $errorMessage }}</p>@endif
    {{ ucfirst($city) }} <p class="badge">{{ $temperature }} ℃</p>
@endsection