@extends('layouts.app')

@section('content')
@if (session('result'))
<div class="flash_message">
    {{ session('result') }}
</div>
@endif
<div class="register-form">
    <h2>会員登録</h2>
    <form action="/register" method="POST">
        @csrf
        <label>名前:
            <input type="text" name="name">
            @error('name')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <label>メールアドレス:
            <input type="email" name="email">
            @error('email')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <label>パスワード:
            <input type="password" name="password">
            @error('password')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <button type="submit">登録</button>
    </form>
</div>
@endsection