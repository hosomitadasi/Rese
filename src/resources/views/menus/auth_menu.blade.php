@extends('layouts.app')

@section('content')
<div class="menu-container">
    <form action="{{ route('home') }}" method="GET">
        @csrf
        <button type="submit"><p>Home</p></button>
    </form>

    <form action="{{ route('register') }}" method="GET">
        @csrf
        <button type="submit"><p>Registration</p></button>
    </form>

    <form action="{{ route('login') }}" method="GET">
        @csrf
        <button type="submit"><p>Login</p></button>
    </form>

</div>
@endsection