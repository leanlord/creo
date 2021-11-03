<!doctype html>
<html lang="ru">
<head>
    @include('includes.head')
</head>

<body>
<header class="header">
    @include('includes.header')
</header>

<main class="main">
    @yield('content')
</main>

<footer class="footer">
    @include('includes.footer')
</footer>
@include('includes.scripts')
</body>
</html>
