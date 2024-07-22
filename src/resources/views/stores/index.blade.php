@extends('layouts.app')

@section('content')
<div class="store-list">
    <h1>店舗情報</h1>
    @foreach($stores as $store)
    <div class="store-item">
        <h2>{{ $store->name }}</h2>
        <img src="{{ asset('images/' . $store->photo) }}" alt="{{ $store->name }}">
        <a href="{{ route('stores.edit', $store->id) }}">編集</a>
        <a href="{{ route('stores.reservations', $store->id) }}">予約情報</a>
    </div>
    @endforeach
</div>
@endsection