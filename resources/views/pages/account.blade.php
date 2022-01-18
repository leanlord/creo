@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="account">
            <div class="profile account__profile">
                <h2 class="profile__title">Редактировать профиль</h2>
                <a href="#" class="profile__image">
                    <img id="profile-img"
                         src="{{ asset('img/account/profile.svg') }}"
                         alt="Изменить аватар"
                         class="profile__pic">
                </a>
                @include('includes.demo-input')
                @include('includes.errors')
                <form action="" id="profileForm" class="profile__form auth__form"
                      method="POST">
                    @csrf
                    <div class="auth__first">
                        <label class="auth__name">
                            <span>Имя</span>
                            <input name="first_name" id="name" type="text"
                                   value="{{ auth()->user()->first_name }}">
                        </label>
                        <label class="auth__name">
                            <span>Фамилия</span>
                            <input name="last_name" id="name" type="text"
                                   value="{{ auth()->user()->last_name }}">
                        </label>
                    </div>
                    <label class="auth__input">
                        <span>Электронная почта</span>
                        <input name="email" type="email"
                               value="{{ auth()->user()->email }}">
                    </label>
                    <label class="auth__input">
                        <span>Номер телефона</span>
                        <input name="number" type="tel"
                               value="{{ auth()->user()->number }}">
                    </label>
                    <label class="auth__input">
                        <span>Пароль (минимум 7 символов)</span>
                        <input name="password" type="password" minlength="7">
                    </label>
                    <label class="auth__input">
                        <span>Подтвердите пароль</span>
                        <input name="password_confirmation" type="password" minlength="7">
                    </label>
                </form>
                <input type="submit" value="Сохранить" form="profileForm" class="form-button profile__button">
                <div class="account__exit--profile">
                    <a href="{{ route('logout') }}" class="form-button account__leave">Выйти из аккаунта</a>
                </div>
            </div>
            <div class="account__exit">
                <a href="{{ route('logout') }}" class="form-button account__leave">Выйти из аккаунта</a>
            </div>
        </div>
    </div>
@stop
