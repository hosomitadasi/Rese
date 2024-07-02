@extends('layouts.app')

@section('content')
    <div class="login-form">
        <h2>ログイン</h2>
        <form action="/login" method="POST">
            @csrf
            <label>メールアドレス: <input type="email" name="email"></label>
            <label>パスワード: <input type="password" name="password"></label>
            <button type="submit">ログイン</button>
        </form>
    </div>
@endsection