@extends('layouts.app')

@section('content')
<div class="admin-index">
    <h2>{{ $user->name }}さん</h2>
    <div class="admin-route">
        <a href="{{ route('admin.create') }}">CreateOwner</a>
        <a href="{{ route('admin.shopkeeper') }}">ShopKeeper</a>
        <a href="{{ route('admin.mail') }}">CreateMail</a>
    </div>
</div>
@endsection