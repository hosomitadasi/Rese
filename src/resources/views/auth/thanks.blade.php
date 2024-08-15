@extends('layouts.app')

@section('content')
<div class="thanks-box">
    <div class="thanks-message">
        <p>会員登録ありがとうございました</p>
        <button class="thanks-button" onclick="window.location.href='/login'">ログインする</button>
    </div>
</div>
@endsection