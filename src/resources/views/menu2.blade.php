@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Menu</h1>
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('register') }}">Registration</a></li>
        <li><a href="{{ route('login') }}">Login</a></li>
    </ul>
</div>
@endsection