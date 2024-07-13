@extends('layouts.app')

@section('content')
<div class="menu-container">
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('register') }}">Registration</a></li>
        <li><a href="{{ route('login') }}">Login</a></li>
    </ul>
</div>
@endsection