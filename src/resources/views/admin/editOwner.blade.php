@extends('layouts.app')

@section('content')
<div class="container">
    <h1>店舗代表者情報の編集</h1>

    <form action="{{ route('admin.updateOwner', $owner->id) }}" method="POST">
        @csrf
        <label for="name">名前</label>
        <input type="text" name="name" value="{{ $owner->name }}">

        <label for="email">メールアドレス</label>
        <input type="email" name="email" value="{{ $owner->email }}">

        <label for="password">パスワード（変更する場合のみ入力）</label>
        <input type="password" name="password">

        <button type="submit">変更する</button>
    </form>
</div>
@endsection