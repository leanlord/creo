<h1>Hello, {{ $user->email }} ! </h1>
<a href="{{ url('/account/verify?token=' . $verifyToken) }}">Подтвердить</a>
