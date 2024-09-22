@extends('layouts.app')

@section('content')
<div class="mail-form">
    <button onclick="location.href='/admins/index'">&lt; Back</button>

    <form action="{{ route('admins.send_mail') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">メール内容 </label>
            <textarea id="content" name="content" rows="5" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">送信</button>
    </form>
</div>
@endsection