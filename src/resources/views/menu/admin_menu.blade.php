@extends('layouts.app')

@section('content')
<div class="menu-container">
    <ul>
        <li><a href="{{ route('admin.index') }}">Home</a></li>
        <li><a href="{{ route('admin.create') }}">CreateOwner</a></li>
        <li><a href="{{ route('admin.shopkeeper')}}">ShopKeeper</a></li>
        <li><a href="{{ route('admin.mail')}}">Mail</a></li>
        <li><a href="{{ route('logoutAdmin') }}">Logout</a></li>
    </ul>
</div>
@endsection