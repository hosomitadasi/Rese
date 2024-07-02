@extends('layouts.app')

@section('content')
    <div class="shop-list">
        @foreach($stores as $store)
            <div class="shop-item">
                <img src="{{ $store->photo }}" alt="{{ $store->name }}">
                <h3>{{ $store->name }}</h3>
                <button onclick="window.location.href='/detail/{{ $store->id }}'">詳しく見る</button>
                <span class="favorite {{ $store->isFavorite ? 'active' : '' }}" onclick="toggleFavorite({{ $store->id }})">&#x2661;</span>
            </div>
        @endforeach
    </div>
@endsection