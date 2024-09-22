@extends('layouts.app')

@section('content')
<button onclick="location.href='index'">&lt; Back</button>
<form action="{{ route('owners.store') }}" method="GET">
    <input type="text" name="search" placeholder="店舗名、エリア、ジャンルで検索" value="{{ request('search') }}">
    <button type="submit">検索</button>
</form>

<table>
    <thead>
        <tr>
            <th>店舗名</th>
            <th>エリア</th>
            <th>ジャンル</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stores as $store)
        <tr>
            <td>{{ $store->name }}</td>
            <td>{{ $store->area->name }}</td>
            <td>{{ $store->genre->name }}</td>
            <td>
                <a href="{{ route('owners.editStore', $store->id) }}">編集</a>

                <form action="{{ route('owners.deleteStore', $store->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if ($stores->hasPages())
<div class="pagination">
    {{ $stores->links('pagination::bootstrap-4') }}
</div>
@endif
@endsection