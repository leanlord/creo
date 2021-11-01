<!doctype html>
<html lang="ru">
<head>
    @include('includes.head')
</head>

<body>
<header class="header">
    <div class="container">
        @include('includes.header')
    </div>
</header>

<main class="main">
    @yield('content')
</main>

<footer class="footer">
    @include('includes.footer')
</footer>
</body>
</html>
