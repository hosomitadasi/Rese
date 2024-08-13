@extends('layouts.app')

@section('content')
<div class="shop-detail">
    <button onclick="location.href='/'">&lt; Back</button>
    <div class="shop-content">
        <div class="shop-info">
            <h1>{{ $shop->name }}</h1>
            <img src="{{ $shop->photo }}" alt="{{ $shop->name }}">
            <p>{{ $shop->overview }}</p>

            <!-- レビュー入力フォーム -->
            <div class="review-form">
                <h2>このお店の評価を行う</h2>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <label for="rating">評価:</label>
                    <select name="rating" id="rating" required>
                        <option value="5">★★★★★</option>
                        <option value="4">★★★★☆</option>
                        <option value="3">★★★☆☆</option>
                        <option value="2">★★☆☆☆</option>
                        <option value="1">★☆☆☆☆</option>
                    </select>
                    <label for="comment">コメント:</label>
                    <textarea name="comment" id="comment" rows="4" required></textarea>
                    <button type="submit">評価を投稿する</button>
                </form>
            </div>
        </div>
        <!-- 予約登録フォーム -->
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

</div>
@endsection