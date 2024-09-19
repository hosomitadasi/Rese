@extends('layouts.app')

@section('content')
<div class="create-form">
    <button onclick="location.href='owner.index'">&lt; Back</button>
    <h2>店舗新規作成</h2>
    <form action="{{ route('owner.createStore') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">店舗名</label>
        <input type="text" name="name" required>

        <label for="area_id">エリア</label>
        <select name="area_id" required>
            @foreach($areas as $area)
            <option value="{{ $area->id }}">{{ $area->name }}</option>
            @endforeach
        </select>

        <label for="genre_id">ジャンル</label>
        <select name="genre_id" required>
            @foreach($genres as $genre)
            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>

        <label for="overview">概要</label>
        <textarea name="overview" required></textarea>

        <label for="photo">店舗の写真</label>
        <input type="file" name="photo" required>

        <button type="submit">保存する</button>
    </form>
</div>
@endsection