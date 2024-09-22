@extends('layouts.app')

@section('content')
<div class="menu-container">
    <form action="{{ route('owners.index') }}" method="GET">
        <button type="submit">Home</button>
    </form>

    <form action="{{ route('owners.create') }}" method="GET">
        <button type="submit">CreateStore</button>
    </form>

    <form action="{{ route('owners.store') }}" method="GET">
        <button type="submit">StoreList</button>
    </form>

    <form action="{{ route('owners.res') }}" method="GET">
        <button type="submit">Reservation</button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</div>
@endsection