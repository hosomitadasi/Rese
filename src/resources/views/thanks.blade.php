@extends('layouts.app')

@section('content')
    <div class="thanks-message">
        <p>会員登録ありがとうございました</p>
        <button onclick="window.location.href='/login'">ログインする</button>
    </div>
@endsection