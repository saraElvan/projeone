<!doctype html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
</head>
<body>
    @include('partials.nav')

    <main>
        @yield('content')
    </main>
</body>
</html>