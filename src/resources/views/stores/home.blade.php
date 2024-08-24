@extends('layouts.app')

@section('content')
<div class="search-container">
    <form action="{{ route('search') }}" method="GET">
        <div class="search-field">
            <label for="area">All area</label>
            <select name="area" id="area">
                <option value=""></option>
                @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->area }}</option>
                @endforeach
            </select>
        </div>
        <div class="search-field">
            <label for="genre">All genre</label>
            <select name="genre" id="genre">
                <option value=""></option>
                @foreach($genres as $genre)
                <option value="{{ $genre->id }}">{{ $genre->genre }}</option>
                @endforeach
            </select>
            <div class="search-field">
                <label for="name"></label>
                <input type="text" name="name" id="name">
            </div>
            <div class="search-field">
                <button type="submit">検索</button>
            </div>
        </div>
    </form>
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