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
            <button onclick="window.location.href='/detail/{{ $store->id }}'">詳しく見る</button>
            <span class="favorite {{ $store->isFavorite ? 'active' : '' }}" onclick="toggleFavorite({{ $store->id }})">&#x2661;</span>
        </div>
        @endforeach
    </div>

    <script>
        function toggleFavorite(storeId) {
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'POST');

            fetch(`/favorite/${storeId}`, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            }).then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Network response was not ok.');
                }
            }).then(data => {
                location.reload();
            }).catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        }
    </script>
    @endsection