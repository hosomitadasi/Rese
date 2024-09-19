@extends('layouts.app')

@section('content')
<button onclick="location.href='owner.index'">&lt; Back</button>
<form action="{{ route('owner.store') }}" method="GET">
    <input type="text" name="search" placeholder="店舗名、エリア、ジャンルで検索" value="{{ request('search') }}">
    <button type="submit">検索</button>
</form>

<table>
    <thead>
        <tr>
            <th>店舗名</th>
            <th>エリア</th>
            <th>ジャンル</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stores as $store)
        <tr>
            <td>{{ $store->name }}</td>
            <td>{{ $store->area->name }}</td>
            <td>{{ $store->genre->name }}</td>
        </tr>
        @endforeach
    </tbody>
    <tr>
        <td>{{ $store->name }}</td>
        <td>{{ $store->area->name }}</td>
        <td>{{ $store->genre->name }}</td>
        <td>
            <a href="{{ route('owner.editStore', $store->id) }}">編集</a>
            <form action="{{ route('owner.deleteStore', $store->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button>
            </form>
        </td>
    </tr>
</table>

{{ $stores->links() }} <!-- ページネーション -->
@endsection