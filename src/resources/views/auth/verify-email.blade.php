@component('mail::message')
# メールアドレスの確認

以下のボタンをクリックして、メールアドレスの確認を完了してください。

@component('mail::button', ['url' => $url])
メールアドレスを確認する
@endcomponent

ありがとうございます！

{{ config('app.name') }}
@endcomponent