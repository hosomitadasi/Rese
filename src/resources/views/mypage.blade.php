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
                <form>
                    @csrf
                    <button type="submit" class="change-button">変更する</button>
                </form>
            </div>
            @endforeach
        </div>
        <div class="favorites">
            <h3>お気に入り店舗</h3>
            <div class="favorite-grid">
                @foreach($favorites as $favorite)
                @if ($favorite->store)
                <div class="favorite-card">
                    <img src="{{ $favorite->store->photo }}" alt="{{ $favorite->store->name }}">
                    <p>{{ $favorite->store->name }}</p>
                    <p>#{{ $favorite->store->area->area }} #{{ $favorite->store->genre->genre }}</p>
                    <button onclick="window.location.href='/detail/{{ $favorite->store->id }}'">詳しく見る</button>
                    <span class="favorite active" onclick="removeFavorite({{ $favorite->id }})">&#x2661;</span>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function removeFavorite(id) {
        fetch('/favorite/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
</script>
@endsection