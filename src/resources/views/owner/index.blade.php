@extends('layouts.app')

@section('content')
<div class="admin-index">
    <h2>〇〇さん</h2>
    <div class="admin-route">
        <a href="{{ route('owner.create') }}">CreateStore</a>
        <a href="{{ route('owner.store') }}">Store</a>
        <a href="{{ route('owner.res') }}">Reservation</a>
    </div>
</div>
@endsection