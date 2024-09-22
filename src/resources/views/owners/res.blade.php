@extends('layouts.app')

@section('content')
<form action="{{ route('owners.res') }}" method="GET">
    <input type="text" name="search" placeholder="店舗名、日付で検索" value="{{ request('search') }}">
    <button type="submit">検索</button>
</form>

<table>
    <thead>
        <tr>
            <th>店舗名</th>
            <th>日付</th>
            <th>時間</th>
            <th>人数</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $reservation)
        <tr>
            <td>{{ $reservation->store->name }}</td>
            <td>{{ $reservation->reservation_date }}</td>
            <td>{{ $reservation->reservation_time }}</td>
            <td>{{ $reservation->num_people }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $reservations->links() }}
@endsection