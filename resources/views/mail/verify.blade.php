<h1>Hello, {{ $data['user']->email }} ! </h1>
<a href="{{ url('/account/verify?token=' . $data['token']) }}">Нажмите</a>
