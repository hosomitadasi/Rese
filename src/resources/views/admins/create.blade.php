@extends('layouts.app')

@section('content')
<div class="create-form">
    <button onclick="location.href='/admins/index'">&lt; Back</button>
    <h2>店舗代表者新規作成</h2>
    <form action="{{ route('admins.createOwner') }}" method="POST">
        @csrf
        <label>名前
            <input type="text" name="name">
            @error('name')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <label>メールアドレス
            <input type="email" name="email">
            @error('email')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <label>パスワード
            <input type="password" name="password">
            @error('password')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <button type="submit">登録する</button>
    </form>
</div>
@endsection