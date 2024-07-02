@extends('layouts.app')

@section('content')
    <div class="register-form">
        <h2>会員登録</h2>
        <form action="/register" method="POST">
            @csrf
            <label>名前: <input type="text" name="name"></label>
            <label>メールアドレス: <input type="email" name="email"></label>
            <label>パスワード: <input type="password" name="password"></label>
            <button type="submit">登録</button>
        </form>
    </div>
@endsection