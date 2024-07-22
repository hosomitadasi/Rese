@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
    <h1>管理者ダッシュボード</h1>
    <form action="{{ route('admin.createStoreOwner') }}" method="POST">
        @csrf
        <label>名前: <input type="text" name="name" required></label>
        <label>メール: <input type="email" name="email" required></label>
        <label>パスワード: <input type="password" name="password" required></label>
        <label>パスワード確認: <input type="password" name="password_confirmation" required></label>
        <button type="submit">店舗代表者を作成</button>
    </form>
</div>
@endsection