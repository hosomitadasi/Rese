@extends('layouts.app')

@section('content')
<div class="edit-form">
    <button onclick="location.href='admin.shopkeeper'">&lt; Back</button>
    <h2>店舗代表者新規作成</h2>
    <div class="before-code">
        <div>
            <p>以前の店舗の名前</p>
            <p>以前の店舗のメールアドレス</p>
            <p>以前の店舗のパスワード</p>
        </div>
    </div>
    <form>
        <label>名前
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
        <label>パスワード
            <input type="password" name="password">
            @error('password')
            <p>{{ $message }}</p>
            @enderror
        </label>
        <button type="submit">変更する</button>
    </form>
</div>
@endsection