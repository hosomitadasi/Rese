@extends('layouts.app')

@section('content')
    <div class="mypage">
        <h2>こんにちは、{{ $user->name }}さん</h2>
        <div class="reservations">
            <h3>予約一覧</h3>
            <ul>
                @foreach($reservations as $reservation)
                    <li>
                        {{ $reservation->shop->name }} - {{ $reservation->date }} {{ $reservation->time }} - {{ $reservation->number }}名
                        <button onclick="cancelReservation({{ $reservation->id }})">キャンセル</button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="favorites">
            <h3>お気に入り一覧</h3>
            <ul>
                @foreach($favorites as $favorite)
                    <li>
                        {{ $favorite->shop->name }}
                        <button onclick="window.location.href='/detail/{{ $favorite->shop->id }}'">詳しく見る</button>
                        <span class="favorite active" onclick="removeFavorite({{ $favorite->id }})">&#x2661;</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection