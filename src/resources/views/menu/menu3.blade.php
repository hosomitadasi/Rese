@extends('layouts.app')

@section('content')
<div class="menu-container">
    <ul>
        <li><a href="{{ route('admin') }}">Home</a></li>
        <li><a href="{{ route('logoutAdmin') }}">Logout</a></li>
        <li><a href="{{ route('edit') }}"></a>Edit</li>
    </ul>
</div>
@endsection