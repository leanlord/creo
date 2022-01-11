@forelse($data['flats'] as $flat)
    <div class="flats__flat">
        <div class="flats__status">
            <img class="check" src="{{ asset('img/flats/checkmark.svg') }}" alt="Иконка: сдан">
            {{ $flat->is_rented ? "Сдан" : "Не сдан" }}
        </div>
        <img src="{{ asset('img/flats/flat.jpg') }}" alt="Картинка квартиры" class="flats__image">
        <div class="flats__info">
            <div class="flats__name">{{ $flat->company }}</div>
            <div class="flats__address">
                <img class="map" src="{{ asset('img/flats/map.svg') }}" alt="Иконка: адрес">
                <address class="flats__city">{{ $flat->city }}
                </address>
            </div>
            <div class="flats__price">
                <img src="{{ asset('img/flats/price.svg') }}" alt="Иконка: цена" class="price">
                <strong class="flats__cost">от {{ $flat->price }} руб</strong>
            </div>
            <div class="flats__type">
                <img src="{{ asset('img/flats/flat.svg') }}" alt="Иконка: типы квартир"
                     class="flatIcon">
                <span class="flats__desc">{{ $flat->area }}</span>
            </div>
            <div class="flats__type">
                <img src="{{ asset('img/flats/carbon_area.svg') }}" alt="Иконка: площадь"
                     class="flatIcon">
                <span class="flats__desc">{{ $flat->square }} м2</span>
            </div>
            <a href="#" class="btn flats__details">Подробнее</a>
        </div>
    </div>
@empty
    <p> По вашему запросу ничего не найдено. </p>
@endforelse
