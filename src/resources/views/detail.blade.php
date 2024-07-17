@extends('layouts.app')

@section('content')
<div class="shop-detail">
    <button onclick="window.location.href='/home'">&lt; Back</button>
    <h1>{{ $shop->name }}</h1>
    <img src="{{ $shop->photo }}" alt="{{ $shop->name }}">
    <p>{{ $shop->overview }}</p>
    <div class="reservation-form">
        @if (session('result'))
        <div class="flash_message">
            {{ session('result') }}
        </div>
        @endif
        <h2>予約情報</h2>
        <form action="{{ route('reserve') }}" method="POST">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <label>日付:
                <input type="date" name="reservation_date" required>
                @error('date')
                <p>{{ $message }}</p>
                @enderror
            </label>
            <label>時間:
                <input type="time" name="reservation_time" required>
                @error('time')
                <p>{{ $message }}</p>
                @enderror
            </label>
            <label>人数:
                <input type="number" name="num_people" min="1" required>
                @error('number')
                <p>{{ $message }}</p>
                @enderror
            </label>
            <button type="submit">予約する</button>
        </form>
    </div>
</div>
@endsection