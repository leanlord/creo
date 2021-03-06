@extends('layouts.default')

@section('content')

    <div class="hero">
        <div class="container">
            <h1 class="hero__title">Выбрать квартиру</h1>
            <p class="hero__desc">Найди своё среди 500 тыс. вариантов недвижимости</p>
            <form id="hero" method="get" action="/" class="form hero__form">
                <div class="hero__city form__item">
                    <label for="city" class="form__span">Выберите город *</label>
                    <select name="city" class="form__input" id="city">
                        <option value="Любой">Любой</option>
                        @foreach($data['attributes']['cities'] as $city)
                            <option value="{{ $city->name }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <div class="splitter"></div>
                </div>
                <div class="hero__name form__item">
                    <label for="company" class="form__span">Название ЖК</label>
                    <input id="company" name="company" class="form__input" type="text">
                    <div class="splitter"></div>
                </div>
                <div class="hero__district form__item">
                    <label class="form__span">Район</label>
                    <select name="area" class="form__input" id="area">
                        <option value="Любой">Любой</option>
                        @foreach($data['attributes']['areas'] as $area)
                            <option value="{{ $area->name }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                    <div class="splitter"></div>
                </div>
                <div class="hero__square form__item">
                    <label class="form__span">Площадь, м2</label>
                    <div class="form__wrapper">
                        <input id="min_square" name="min_square" type="text" class="form__input form__textbox hero__square-placeholder"
                               placeholder="{{ $data['attributes']['minSquare'] ?? '' }}">
                        <span class="form__dash">—</span>
                        <input id="max_square" name="max_square" type="text" class="form__input form__textbox hero__square-placeholder"
                               placeholder="{{ $data['attributes']['maxSquare'] ?? '' }}">
                    </div>
                </div>
                <div class="hero__price form__item">
                    <label class="form__span">Стоимость, ₽</label>
                    <div class="form__wrapper">
                        <input id="min_price" name="min_price" type="text" class="form__input form__textbox hero__price-placeholder"
                               placeholder="{{
                                isset($data['attributes']['minPrice']) ?
                                number_format($data['attributes']['minPrice'], 0, " ", " ")
                                 : '' }}">
                        <span class="form__dash">—</span>
                        <input id="max_price" name="max_price" type="text" class="form__input form__textbox hero__price-placeholder"
                               placeholder="{{
                                isset($data['attributes']['maxPrice']) ?
                                number_format($data['attributes']['maxPrice'], 0, " ", " ")
                                 : '' }} ">
                    </div>
                </div>
                <div class="hero__price form__item">
                    <label for="is_rented" class="form__span">Статус</label>
                    <select name="is_rented" class="form__input" id="is_rented">
                        <option value="Любой">Любой</option>
                        <option value="Сдан">Сдан</option>
                        <option value="Не сдан">Не сдан</option>
                    </select>
                    <div class="splitter"></div>
                </div>
            </form>
            <label class="btn hero__button">
                <input class="hero__submit input-submit" form="hero" value="Показать квартиры" type="submit">
            </label>
        </div>
    </div>
    <div class="flats">
        <div class="container flats__container" id="flats-container">
            <div class="menu flats__menu">
                <div class="menu__heading">
                    <img src="{{ asset('img/flats/star.svg') }}" alt="Иконка: топ новостройки" class="menu__image">
                    <span class="menu__title">Топ {{ count($data['attributes']['companies']) }} новостроек</span>
                </div>
                <div class="menu__links">
                    <ul class="menu__list">
                        @foreach($data['attributes']['companies'] as $company)
                            <li class="menu__item">
                                <a href="#" class="menu__link">{{ $company->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="flats__main">
                <h2 class="flats__title">Все новостройки Краснодара</h2>
                <div class="flats__wrapper" id="flats-wrapper">
                    @include('includes.flats')
                </div>
                <a href="#" class="flats__button">
                    <img src="{{ asset('img/flats/more.svg') }}" alt="Иконка: показать больше" class="flats__more">
                    <span class="flats__more">Показать ещё</span>
                </a>
                <div id="show-more" class="flats__wrapper"></div>
            </div>
        </div>
    </div>
    <div class="submit">
        <div class="container">
            <div class="submit__wrapper">
                <h2 class="submit__title">Снимайте тапочки, а не квартиру!</h2>
                <p class="submit__text">
                    БЕСПЛАТНО откроем ипотеку с пониженной процентной ставкой! <span class="submit__span">Для покупки в ипотеку доступно более 78 000 квартир!</span>
                </p>
                <form method="POST" class="submit__form">
                    @csrf
                    <div class="submit__top">
                        <label class="submit__placeholder">
                            <input id="form-name" name="name" class="submit__input" type="text" required placeholder="Ваше Имя">
                        </label>
                        <label class="submit__placeholder">
                            <input id="form-number" name="number" class="submit__input" type="tel" required placeholder="Телефон">
                        </label>
                        <label class="btn submit__button" id="form-submit">
                            <input class="submit__send input-submit" value="Отправить" type="submit">
                        </label>
                    </div>
                    <div class="submit__bottom">
                        <label class="submit__checkbox">
                            Отправляя заявку на обратный звонок я даю своё согласие с
                            <a href="#" class="submit__link">политикой обработки персональных данных</a>
                            <input id="form-checkbox" type="checkbox" required>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </form>
                <p class="submit__aside">
                    Ваши соседи уже делают ремонт! Хватит думать, пора покупать!
                </p>
            </div>
        </div>
    </div>
    <div class="districts">
        <div class="container">
            <h2 class="districts__title">Популярные районы Краснодара</h2>
            <ul class="districts__list">
                <li class="districts__item">Центральный</li>
                <li class="districts__item">Фестивальный</li>
                <li class="districts__item">Юбилейный</li>
                <li class="districts__item">Пашковский</li>
                <li class="districts__item">Славянский</li>
                <li class="districts__item">Черемушки</li>
                <li class="districts__item">Комсомольский</li>
                <li class="districts__item">Энка</li>
                <li class="districts__item">Гидрострой</li>
                <li class="districts__item">Репино</li>
                <li class="districts__item">40 лет Победы</li>
                <li class="districts__item">Авиагородок</li>
                <li class="districts__item">Музыкальный</li>
                <li class="districts__item">Сельхозинститут</li>
                <li class="districts__item">ТЭЦ</li>
                <li class="districts__item">Западный обход</li>
                <li class="districts__item">Московская</li>
                <li class="districts__item">Молодежный</li>
                <li class="districts__item">Зип</li>
                <li class="districts__item">ККБ</li>
                <li class="districts__item">Витаминкомбинат</li>
                <li class="districts__item">Школьный</li>
                <li class="districts__item">Микрохирургия глаза</li>
            </ul>
            <h2 class="districts__title">Новостройки в Краснодаре</h2>
            <p class="districts__paragraph">Доступное жилье – воплощение мечты большинства людей, которые сегодня ютятся
                в малогабаритных неудобных квартирах. Сейчас реализовать ее несложно, так как практически во всех
                новостройках в ЖК Краснодара есть квартиры по демократичной стоимости.
            </p>
            <p class="districts__paragraph">Они пользуются спросом не только у жителей города, но и среди россиян из
                других регионов. Это объясняется удачным расположением Краснодара, его стремительно развивающейся
                инфраструктурой и большим потенциалом для бизнеса. Кроме того, недвижимость в ЖК Краснодара отличается
                качеством и относительно невысокими ценами. Ее покупка позволяет выгодно вложить деньги и впоследствии
                получать прибыль, сдавая квартиру в аренду.
            </p>
            <p class="districts__paragraph">Среди молодежи особенно высоким спросом пользуются квартиры-студии, купить
                которые в новостройках Краснодара можно в любых вариантах. Они привлекательны тем, что имеют свободную
                планировку и позволяют владельцам, как угодно распоряжаться пространством, реализуя свой творческий
                потенциал. К тому же, это жилье эконом-класса, и приобрести его можно в рассрочку или по ипотеке. Такой
                вариант является оптимальным для молодых людей, желающим иметь отдельную квартиру, но не имеющих
                солидного материального базиса.</p>
            <h3 class="districts__subtitle">Новостройки в Краснодаре без посредников.</h3>
            <p class="districts__paragraph">Сейчас многие компании-застройщики предлагают приобрести жилье, заключив
                договор с ними еще на стадии возведения зданий. Это очень удобный и выгодный способ покупки квартир,
                предполагающий поэтапные выплаты равноценных сумм. Цены на такие новостройки Краснодара или на ЖК в
                Геледжике не включают в себя надбавки за услуги посредников и практически аналогичны себестоимости
                жилья.
            </p>
            <p class="districts__paragraph">Иногда люди опасаются вкладывать деньги в объекты, которые еще не сданы в
                эксплуатацию. Это опасение основывается на реальных случаях остановки строительства, после которой
                инвесторы прикладывали огромные усилия к тому, чтобы вернуть вложенные в него средства. Таких ситуаций
                можно избежать, если выбирать лучшие ЖК Краснодара, которые возводят компании с безупречной репутацией.
                Таких фирм, доказавших свою надежность на протяжении многих лет, в городе много. Они предлагают свои
                услуги через сайты, на которых выставлена масса вариантов жилья различной площади и планировки.
            </p>
            <p class="districts__paragraph">Приобретение жилья на первичном рынке в Краснодаре имеет много преимуществ.
                Проекты современных новостроек подразумевают применение инновационных технологий, способствующих
                максимальному энергосбережению. Это дает возможность снизить затраты на отопление, газо- и
                водообеспечение, электроснабжение зданий и существенно уменьшить оплату за эти услуги.
            </p>
            <h3 class="districts__subtitle">Особенности расположения и строительства всех новостроек.</h3>
            <p class="districts__paragraph">Сейчас жилые дома возводятся только в экологически безопасных зеленых зонах
                с парками, водоемами, удобной инфраструктурой. При создании этих проектов учитывается много факторов,
                среди которых приоритетными являются элементы комфорта для жильцов. Они включают в себя расположение
                неподалеку от готовых новостроек Краснодара школ, детских садов, торговых, развлекательных и спортивных
                центров, остановок общественного транспорта, автостоянок, поликлиник.
            </p>
            <p class="districts__paragraph">Здания строятся из кирпича, монолита, панельных блоков, имеют разную
                этажность и различное количество квартир. Среди есть элитные варианты в два-три этажа и многоэтажные
                дома с современными бесшумными лифтами. В городе можно приобрести недорогую квартиру под ключ с
                внутренней отделкой или выбрать более дешевое жилье без косметического ремонта и сделать его на свой
                вкус. Найти подходящий вариант квартиры несложно. Для этого достаточно посмотреть каталог новостроек
                Краснодара в интернет-ресурсе по продаже недвижимости.</p>
        </div>
    </div>
@stop
