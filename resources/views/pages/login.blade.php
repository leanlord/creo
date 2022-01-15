@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="login">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @endif
            <h2 class="login__title">Войти</h2>
            <form action="{{ route('login') }}" method="POST" id="loginForm" class="login__form auth__form">
                @csrf
                <label class="auth__input">
                    <span>Электронная почта</span>
                    <input name="email" type="email" required>
                </label>
                <label class="auth__input">
                    <span>Пароль</span>
                    <input name="password" type="password" required minlength="7">
                </label>
            </form>
            <label class="login__button">
                <input type="submit" value="Войти" form="loginForm" class="form-button login__send">
            </label>
            <span class="login__span">Нет аккаунта? <a href="{{ url('register') }}" class="login__link">Зарегистрируйтесь</a></span>
        </div>
    </div>

@stop
