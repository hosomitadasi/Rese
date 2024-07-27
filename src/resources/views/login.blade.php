@extends('layouts.app')

@section('content')
@if (session('result'))
<div class="flash_message">
    {{ session('result') }}
</div>
@endif
<div class="login-form">
    <h2>ログイン</h2>
    <form action="{{ route('login') }}" method=" POST">
        @csrf
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
        <button type="submit">ログイン</button>
    </form>
</div>
@endsection