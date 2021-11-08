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
                <form action="#" id="profileForm" class="profile__form">
                    <div class="profile__first">
                        <label class="profile__name">
                            <span>Имя</span>
                            <input id="name" type="text" required placeholder="Владимир">
                        </label>
                        <label class="profile__name">
                            <span>Фамилия</span>
                            <input id="name" type="text" required placeholder="Дадыка">
                        </label>
                    </div>
                    <label class="profile__input">
                        <span>Электронная почта</span>
                        <input type="email" required>
                    </label>
                    <label class="profile__input">
                        <span>Номер телефона</span>
                        <input type="tel" required>
                    </label>
                    <label class="profile__input">
                        <span>Пароль (минимум 7 символов)</span>
                        <input type="password" required minlength="7">
                    </label>
                </form>
                <input type="submit" value="Сохранить" form="profileForm" class="profile__button">
            </div>
        </div>
    </div>
@stop
