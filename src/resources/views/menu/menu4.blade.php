@extends('layouts.app')

@section('content')
<div class="menu-container">
    <ul>
        <li><a href="{{ route('store') }}">Home</a></li>
        <li><a href="{{ route('logout') }}">Logout</a></li>
        <li><a href="{{ route('store') }}">Store</a></li>
        <li><a href="{{ route('add') }}">予約管理</a></li>
    </ul>
</div>
@endsection