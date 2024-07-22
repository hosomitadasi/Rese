@extends('layouts.app')

@section('content')
<div class="store-owner-dashboard">
    <h1>店舗代表者ダッシュボード</h1>
    <a href="{{ route('stores.create') }}">店舗情報を作成</a>
    <a href="{{ route('stores.index') }}">店舗情報を管理</a>
</div>
@endsection