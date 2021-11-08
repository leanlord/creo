@extends('layouts.default')

@section('content')
    <div class="hero">
        <div class="container">
            <h1 class="hero__title">Выбрать квартиру</h1>
            <p class="hero__desc">Найди своё среди 500 тыс. вариантов недвижимости</p>
            <form action="#" class="form hero__form">
                <label class="form__city">Выберите город *
                    <select id="city">
                        <option value="Любой">Любой</option>
                        <option value="Краснодар">Краснодар</option>
                        <option value="Волгоград">Волгоград</option>
                        <option value="Москва">Москва</option>
                    </select>
                    <div class="splitter"></div>
                </label>
                <label class="form__name">Название ЖК, ПК, шоссе...
                    <input type="text">
                    <div class="splitter"></div>
                </label>
                <label class="form__city">Район
                    <select id="city">
                        <option value="Любой">Любой район</option>
                        <option value="Краснодар">Центральный</option>
                        <option value="Волгоград">Табачная фабрика</option>
                        <option value="Москва">Губернский</option>
                    </select>
                    <div class="splitter"></div>
                </label>
                <label class="form__square">Площадь, м2

                </label>
                <label class="form__price">Стоимость, ₽

                </label>
            </form>
        </div>
    </div>
    <div class="flats">
        <div class="container flats__container">
            <div class="menu flats__menu">
                <div class="menu__heading">
                    <img src="{{ asset('img/flats/star.svg') }}" alt="Иконка: топ новостройки" class="menu__image">
                    <span class="menu__title">Топ 12 новостроек</span>
                </div>
                <div class="menu__links">
                    <ul class="menu__list">
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Кубанская Марка"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Фестивальный"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Свобода"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Девелопмент-Плаза"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Образцова, 6"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Россинский парк"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Фруктовый квартал Абрикосово"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Дыхание"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">МКР "Кубанский"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Седьмой континент"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Восточно-Кругликовский"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Элегант"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Центральный"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Лиговский"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Восточно-Кругликовский" (ООО "Теплостройсервис")</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Жилой квартал" по ул. 40 лет Победы</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК "Lime" (ЖК Лайм)</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">КП "Фестивальный"</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">ЖК Ракурс</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flats__main">
                <h2 class="flats__title">Все новостройки Краснодара</h2>
                <div class="flats__wrapper">
                    @for ($i = 0; $i < 9; $i++)
                        @include('includes.flat')
                    @endfor
                </div>
                <a href="#" class="flats__button">
                    <img src="{{ asset('img/flats/more.svg') }}" alt="Иконка: показать больше" class="flats__more">
                    <span class="flats__more">Показать ещё</span>
                </a>
            </div>
        </div>
@stop
