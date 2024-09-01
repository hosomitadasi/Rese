@extends('layouts.app')

@section('content')
<div class="create-form">
    <h2>店舗新規作成</h2>
    <form action="" method="">
        @csrf
        <label>店舗名:
            <input type="text" name="name">
            @error('name')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <label>地域:
            <input type="" name="">
            @error('area')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <label>ジャンル:
            <input type="" name="">
            @error('genre')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <label>写真:
            <input type="text" name="name">
            @error('photo')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <label>概要:
            <input type="text" name="overview">
            @error('overview')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <button type="submit">保存する</button>
    </form>
</div>
@endsection