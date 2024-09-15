@extends('layouts.app')

@section('content')
<div class="menu-container">
    <form action="{{ route('owner.index') }}" method="GET">
        <button type="submit">Home</button>
    </form>

    <form action="{{ route('owner.create') }}" method="GET">
        <button type="submit">CreateStore</button>
    </form>

    <form action="{{ route('owner.store') }}" method="GET">
        <button type="submit">StoreList</button>
    </form>

    <form action="{{ route('owner.res') }}" method="GET">
        <button type="submit"></button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</div>
@endsection