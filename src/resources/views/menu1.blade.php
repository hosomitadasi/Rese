@extends('layouts.app')

@section('content')
<div class="menu-container">
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('mypage') }}">Mypage</a></li>
        <li><a href="{{ route('logout') }}">Logout</a></li>
    </ul>
</div>
@endsection