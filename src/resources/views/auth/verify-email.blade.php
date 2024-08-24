@extends('layouts.app')

@section('content')
<div class="thanks-box">
    <div class="thanks-message">
        <p>会員登録ありがとうございました。</p>
        <p>メールの確認が完了しましたら、「ログインする」ボタンを押してログインしてください。</p>
        <button class="thanks-button" onclick="window.location.href='/thanks'">ログインする</button>
    </div>
</div>

@endsection