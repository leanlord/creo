@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="register">
            <h2 class="register__title">Регистрация</h2>
            <a href="#" class="profile__image">
                <img src="{{ asset('img/account/profile.svg') }}" alt="Изменить аватар" class="profile__pic">
            </a>
            <form action="{{ route('register') }}" method="POST" id="registerForm" class="form register__form">
                <div class="form__first">
                    <label class="form__name">
                        <span>Имя</span>
                        <input name="first__name" id="name" type="text" placeholder="Владимир">
                    </label>
                    <label class="form__name">
                        <span>Фамилия</span>
                        <input name="last__name" id="name" type="text" placeholder="Дадыка">
                    </label>
                </div>
                <label class="form__input">
                    <span>Электронная почта*</span>
                    <input name="email" type="email" required>
                </label>
                <label class="form__input">
                    <span>Номер телефона</span>
                    <input name="number" type="tel">
                </label>
                <label class="form__input">
                    <span>Пароль (минимум 7 символов)*</span>
                    <input name="password" type="password" required minlength="7">
                </label>
            </form>
            <span class="register__span">* - поля, обязательные для заполнения</span>
            <input type="submit" value="Создать аккаунт" form="registerForm" class="form-button register__button">
        </div>
    </div>
@stop
