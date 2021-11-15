@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="login">
            <h2 class="login__title">Войти</h2>
            <form action="{{ route('login') }}" method="POST" id="loginForm" class="form login__form">
                @csrf
                <label class="form__input login__input">
                    <span>Электронная почта</span>
                    <input name="email" type="email" required>
                </label>
                <label class="form__input login__input">
                    <span>Пароль</span>
                    <input name="password" type="password" required minlength="7">
                </label>
            </form>
            <input type="submit" value="Войти" form="loginForm" class="form-button login__button">
            <span class="login__span">Нет аккаунта? <a href="{{ url('register') }}" class="login__link">Зарегистрируйтесь</a></span>
        </div>
    </div>

@stop
