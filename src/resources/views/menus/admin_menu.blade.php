@extends('layouts.app')

@section('content')
<div class="menu-container">
    <form action="{{ route('admins.index') }}" method="GET">
        <button type="submit">Home</button>
    </form>

    <form action="{{ route('admins.create') }}" method="GET">
        <button type="submit">CreateOwner</button>
    </form>

    <form action="{{ route('admins.shopkeeper') }}" method="GET">
        <button type="submit">ShopKeeper</button>
    </form>

    <form action="{{ route('admins.mail') }}" method="GET">
        <button type="submit">Mail</button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</div>
@endsection