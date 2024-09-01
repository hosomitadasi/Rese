@extends('layouts.app')

@section('content')
<div class="shop-list">
    @foreach($stores as $store)
    <div class="shop-item">
        <img src="{{ $store->photo }}" alt="{{ $store->name }}">
        <h3>{{ $store->name }}</h3>
        <p>#<span>{{ $store->area->area }}</span></p>
        <p>#<span>{{ $store->genre->genre }}</span></p>
        <button onclick="window.location.href='/detail/{{ $store->id }}'" class="detail-button">詳しく見る</button>

        <form method="POST" action="{{ route('favorite.toggle', $store->id) }}">
            @csrf
            <button type="submit" class="favorite-button">
                <span class="favorite {{ $store->is_Favorite ? 'active' : '' }}">&hearts;</span>
            </button>
        </form>
    </div>
    @endforeach
</div>
@endsection