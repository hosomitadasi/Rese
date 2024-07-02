<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/reset.css">
</head>
<body>
    @include('components.header')
    <div class="content">
        @yield('content')
    </div>
</body>
</html>