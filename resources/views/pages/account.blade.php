@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="account">
            <div class="account__menu">
                <ul class="account__list">
                    <li class="account__item">
                        <a href="#" class="account__link">
                            <img src="{{ asset('img/account/edit.svg') }}" alt="Иконка: редактировать"
                                 class="account__icon">
                            <span>Редактировать профиль</span>
                            <img src="{{ asset('img/account/arrow.svg') }}" alt="Активный элемент">
                        </a>
                        <div class="splitter account__splitter"></div>
                    </li>
                    <li class="account__item">
                        <a href="#" class="account__link">
                            <img src="{{ asset('img/account/person.svg') }}" alt="Иконка: личные данные"
                                 class="account__icon">
                            <span>Личные данные</span>
                        </a>
                        <div class="splitter account__splitter"></div>
                    </li>
                </ul>
            </div>
            <div class="splitter splitter-large"></div>
            <div class="profile account__profile">
                <h2 class="profile__title">Редактировать профиль</h2>
                <a href="#" class="profile__image">
                    <img src="{{ asset('img/account/profile.svg') }}" alt="Изменить аватар" class="profile__pic">
                </a>
                <form action="" id="profileForm" class="form profile__form"
                      method="POST">
                    @csrf
                    <div class="form__first">
                        <label class="form__name">
                            <span>Имя</span>
                            <input name="first_name" id="name" type="text"
                                   value="{{ auth()->user()->first_name }}">
                        </label>
                        <label class="form__name">
                            <span>Фамилия</span>
                            <input name="last_name" id="name" type="text"
                                   value="{{ auth()->user()->last_name }}">
                        </label>
                    </div>
                    <label class="form__input">
                        <span>Электронная почта</span>
                        <input name="email" type="email"
                               value="{{ auth()->user()->email }}">
                    </label>
                    <label class="form__input">
                        <span>Номер телефона</span>
                        <input name="number" type="tel"
                               value="{{ auth()->user()->number }}">
                    </label>
                    <label class="form__input">
                        <span>Пароль (минимум 7 символов)</span>
                        <input name="password" type="password" minlength="7">
                    </label>
                </form>
                <input type="submit" value="Сохранить" form="profileForm" class="form-button profile__button">
            </div>
            <div class="account__exit">
                <a href="{{ route('logout') }}" class="form-button account__leave">Выйти из аккаунта</a>
            </div>
        </div>
    </div>
@stop
