@extends('layouts.app')

@section('content')
<div class="store-form">
    <h1>店舗情報を作成</h1>
    <form action="{{ route('stores.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">店舗名:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="area_id">エリアID:</label>
            <input type="number" id="area_id" name="area_id" required>
        </div>
        <div>
            <label for="genre_id">ジャンルID:</label>
            <input type="number" id="genre_id" name="genre_id" required>
        </div>
        <div>
            <label for="overview">概要:</label>
            <textarea id="overview" name="overview" required></textarea>
        </div>
        <div>
            <label for="photo">写真:</label>
            <input type="file" id="photo" name="photo" required>
        </div>
        <div>
            <button type="submit">保存</button>
        </div>
    </form>
</div>
@endsection