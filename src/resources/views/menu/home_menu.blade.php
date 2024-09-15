@extends('layouts.app')

@section('content')
<div class="menu-container">
    <form action="{{ route('home') }}" method="GET">
        <button type="submit">Home</button>
    </form>

    <form action="{{ route('mypage') }}" method="GET">
        <button type="submit">Mypage</button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</div>
@endsection