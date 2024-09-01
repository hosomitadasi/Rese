@extends('layouts.app')

@section('content')
<div class="create-form">
    <h2>店舗代表者新規作成</h2>
    <form action="" method="">
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
        <button type="submit">保存</button>
    </form>
</div>
@endsection