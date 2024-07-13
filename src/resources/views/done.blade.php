@extends('layouts.app')

@section('content')
    <div class="done-message">
        <p>ご予約ありがとうございました</p>
        <button onclick="window.location.href='/detail/{{ $shop ??  }}'">戻る</button>
    </div>
@endsection