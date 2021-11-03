@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="hero">
            <h1 class="hero__title">Выбрать квартиру</h1>
            <p class="hero__desc">Найди своё среди 500 тыс. вариантов недвижимости</p>
            <form action="#" class="form hero__form">
                <label class="form__city">Выберите город *
                    <select name="city" id="city" required>
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
                    <select name="city" id="city">
                        <option value="Любой">Любой район</option>
                        <option value="Краснодар">Центральный</option>
                        <option value="Волгоград">Табачная фабрика</option>
                        <option value="Москва">Губернский</option>
                    </select>
                    <div class="splitter"></div>
                </label>
                <label class="form__square">Площадь, м2

                </label>
            </form>
        </div>
    </div>
@stop
