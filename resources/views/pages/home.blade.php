@extends('layouts.default')

@section('content')

    <div class="hero">
        <div class="container">
            <h1 class="hero__title">Выбрать квартиру</h1>
            <p class="hero__desc">Найди своё среди 500 тыс. вариантов недвижимости</p>
            <form method="GET" id="hero" action="#" class="form hero__form">
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
            <label class="btn submit__button">
                <input form="" value="Отправить" type="submit">
            </label>
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
                    @include('includes.flats')
                </div>
                <a href="#" class="flats__button">
                    <img src="{{ asset('img/flats/more.svg') }}" alt="Иконка: показать больше" class="flats__more">
                    <span class="flats__more">Показать ещё</span>
                </a>
            </div>
        </div>
    </div>
    <div class="submit">
        <div class="container submit__wrapper">
            <h2 class="submit__title">Снимайте тапочки, а не квартиру!</h2>
            <p class="submit__text">
                БЕСПЛАТНО откроем ипотеку с пониженной процентной ставкой! <span class="submit__span">Для покупки в ипотеку доступно более 78 000 квартир!</span>
            </p>
            <form method="POST" class="submit__form">
                @csrf
                <div class="submit__top">
                    <label class="submit__placeholder">
                        <input name="name" class="submit__input" type="text" required placeholder="Ваше Имя">
                    </label>
                    <label class="submit__placeholder">
                        <input name="number" class="submit__input" type="tel" required placeholder="Телефон">
                    </label>
                    <label class="btn submit__button">
                        <input value="Отправить" type="submit">
                    </label>
                </div>
                <div class="submit__bottom">
                    <label class="submit__checkbox">
                        Отправляя заявку на обратный звонок я даю своё согласие с
                        <a href="#" class="submit__link">политикой обработки персональных данных</a>
                        <input type="checkbox" required>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </form>
            <p class="submit__aside">
                Ваши соседи уже делают ремонт! Хватит думать, пора покупать!
            </p>
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
                <li class="districts__item">Восточно-Кругликовский</li>
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
