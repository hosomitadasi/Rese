@extends('layouts.app')

@section('content')
<div class="store-form">
    <h1>店舗情報を編集</h1>
    <form action="{{ route('stores.update', $store->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label>店舗名: <input type="text" name="name" value="{{ $store->name }}" required></label>
        <label>写真: <input type="file" name="photo"></label>
        <button type="submit">更新</button>
    </form>
</div>
@endsection