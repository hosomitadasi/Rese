@extends('layouts.app')

@section('content')
<div class="owner-index">
    <h2>〇〇さん</h2>
    <ul>
        <li><a href="{{ route('create') }}">店舗新規登録</a></li>
        <li><a href="{{ route('store') }}">店舗管理</a></li>
        <li><a href="{{ route('res') }}">予約管理</a></li>
    </ul>
</div>
@endsection