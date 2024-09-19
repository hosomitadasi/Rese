@extends('layouts.app')

@section('content')
<div class="shop-content">
    <button onclick="location.href='/admin/index'">&lt; Back</button>
    <h1>店舗代表者一覧</h1>
    <form method="GET" action="{{ route('admin.shopkeeper') }}">
        <input type="text" name="search" placeholder="名前かメールアドレスで検索" value="{{ request('search') }}">
        <button type="submit">検索</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>編集</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            @foreach($owners as $owner)
            <tr>
                <td>{{ $owner->name }}</td>
                <td>{{ $owner->email }}</td>
                <td><a href="{{ route('admin.editOwner', $owner->id) }}">編集</a></td>
                <td>
                    <form action="{{ route('admin.deleteOwner', $owner->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $owners->links() }}
</div>
@endsection