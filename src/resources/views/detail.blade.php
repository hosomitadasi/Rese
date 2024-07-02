@extends('layouts.app')

@section('content')
    <div class="shop-detail">
        <button onclick="window.location.href='/home'">&lt; Back</button>
        <h1>{{ $shop->name }}</h1>
        <img src="{{ $shop->photo }}" alt="{{ $shop->name }}">
        <p>{{ $shop->overview }}</p>
        <div class="reservation-form">
            <h2>予約情報</h2>
            <form action="/reserve" method="POST">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <label>日付: <input type="date" name="date"></label>
                <label>時間: <input type="time" name="time"></label>
                <label>人数: <input type="number" name="number" min="1"></label>
                <button type="submit">予約する</button>
            </form>
        </div>
    </div>
@endsection