@extends('layouts.app')

@section('content')
<div class="admin-index">
    @if(session('result'))
    <p>{{ session('result') }}</p>
    @endif
    <h2></h2>
    <div class="admin-route">
        <a href="{{ route('owners.create') }}">CreateStore</a>
        <a href="{{ route('owners.store') }}">Store</a>
        <a href="{{ route('owners.res') }}">Reservation</a>
    </div>
</div>
@endsection