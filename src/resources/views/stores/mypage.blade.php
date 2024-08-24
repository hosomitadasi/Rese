@extends('layouts.app')

@section('content')
<div class="mypage">
    <h2>こんにちは、{{ $user->name }}さん</h2>
    <div class="content-wrapper">
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
                @if (Carbon\Carbon::parse($reservation->reservation_date)->greaterThanOrEqualTo(now()->addDay()))

                <form method="POST" action="{{ route('reserve.change', $reservation->id) }}">
                    @csrf
                    <input type="date" name="reservation_date" value="{{ $reservation->reservation_date }}" required>
                    <input type="time" name="reservation_time" value="{{ $reservation->reservation_time }}" required>
                    <input type="number" name="num_people" value="{{ $reservation->num_people }}" required>
                    <button type="submit" class="change-button">変更する</button>
                </form>
                @endif

                <form method="GET" action="{{ route('generate.qr', $reservation->id) }}" target="_blank">
                    <button type="submit" class="qr-button">QRコードを作成</button>
                </form>
                <img src="{{ route('generate.qr', ['reservationID' => $reservation->id, 'rand' => uniqid()]) }}" alt="QR Code" />

                <form method="GET" action="{{ route('payment', $reservation->id) }}">
                    <button class="payment-button">決済画面へ</button>
                </form>
            </div>
            @endforeach
        </div>
        <div class="favorites">
            <h3>お気に入り店舗</h3>
            <div class="favorite-list">
                @foreach($favorites as $favorite)
                @if ($favorite->store)
                <div class="favorite-item">
                    <img src="{{ $favorite->store->photo }}" alt="{{ $favorite->store->name }}">
                    <p>{{ $favorite->store->name }}</p>
                    <p>#{{ $favorite->store->area->area }} #{{ $favorite->store->genre->genre }}</p>
                    <button onclick="window.location.href='/detail/{{ $favorite->store->id }}'">詳しく見る</button>

                    <form method="POST" action="{{ route('favorite.toggle', $favorite->store->id) }}">
                        @csrf
                        <button type="submit" class="favorite-button">
                            <span class="favorite active">&hearts;</span>
                        </button>
                    </form>
                </div>
                @endif
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection