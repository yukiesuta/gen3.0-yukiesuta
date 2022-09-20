<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>POSSE | @yield('title', 'Quizy')</title>
    <link rel="icon" href="{{ asset('/favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('head')
</head>

<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
</body>
@yield('script')

</html>
