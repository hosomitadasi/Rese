@extends('layouts.app')

@section('content')
<div class="store-form">
    <h1>店舗情報を作成</h1>
    <form action="{{ route('stores.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>店舗名: <input type="text" name="name" required></label>
        <label>写真: <input type="file" name="photo" required></label>
        <button type="submit">作成</button>
    </form>
</div>
@endsection