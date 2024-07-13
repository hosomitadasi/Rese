@extends('layouts.app')

@section('content')
<div class="mypage">
    <h2>こんにちは、{{ $user->name }}さん</h2>
    <div class="reservations">
        <h3>予約状況</h3>
        @foreach($reservations as $reservation)
        <div class="reservation-card">
            <div class="reservation-info">
                <p>Shop: {{ $reservation->store->name }}</p>
                <p>Date: {{ $reservation->reservation_date }}</p>
                <p>Time: {{ $reservation->reservation_time }}</p>
                <p>Number: {{ $reservation->num_people }}</p>
            </div>
            <form method="POST" action="{{ route('reserve.cancel', $reservation->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="cancel-button">×</button>
            </form>
        </div>
        @endforeach
    </div>
    <div class="favorites">
        <h3>お気に入り店舗</h3>
        @foreach($favorites as $favorite)
        <div class="favorite-card">
            <img src="{{ asset('images/' . $favorite->shop->image) }}" alt="{{ $favorite->shop->name }}">
            <p>{{ $favorite->shop->name }}</p>
            <p>#{{ $favorite->shop->location }} #{{ $favorite->shop->type }}</p>
            <button onclick="window.location.href='/detail/{{ $favorite->shop->id }}'">詳しく見る</button>
            <span class="favorite active" onclick="removeFavorite({{ $favorite->id }})">&#x2661;</span>
        </div>
        @endforeach
    </div>
</div>
@endsection