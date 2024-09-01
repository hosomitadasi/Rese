@extends('layouts.app')

@section('content')
<div class="admin-index">
    <h2>〇〇さん</h2>
    <div class="work-list">
        <div class="create-item">
            <h3>新規店舗代表者作成</h3>
            <button onclick="window.location.href='admin.create'"></button>
        </div>
        <div class="search-list">
            <h3>店舗代表者検索</h3>
            <input type="text" name="name" id="name">
            <button type="submit">検索</button>
        </div>
    </div>
    <div class="owner-list">
        <div class="owner-item">
            <h3>作成した店舗代表者の名前</h3>
            <button onclick="window.location.href='admin.edit'" class="detail-button">編集</button>
            <form>
                @csrf
                @method('DELETE')
                <button type="" class="delete-button">削除</button>
            </form>
        </div>
    </div>
</div>
@endsection