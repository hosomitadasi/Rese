@extends('layouts.app')

@section('content')
<div class="admin-index">
    @if(session('result'))
    <p>{{ session('result') }}</p>
    @endif

    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif

    <h2>{{ $user->name }}さん</h2>
    <div class="admin-route">
        <a href="{{ route('admin.create') }}">CreateOwner</a>
        <a href="{{ route('admin.shopkeeper') }}">ShopKeeper</a>
        <a href="{{ route('admin.mail') }}">CreateMail</a>
    </div>
</div>
@endsection