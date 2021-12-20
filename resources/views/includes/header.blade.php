<div class="top">
    <div class="container top__container">
        <a href="{{ url('/') }}" class="top__logo">
            <img src="{{ asset('img/top/logo.svg') }}" alt="Иконка: CREO">
        </a>
        <span class="top__info">
        База новостроек от застройщиков без посредников и переплат
    </span>
        <div class="contact top__contact">
            <div class="contact__phone">
                <img src="{{ asset('img/top/call.svg') }}" alt="#" class="call">
                <a href="tel:88004655303" class="contact__call">8 800 465-53-03</a>
            </div>
            <span class="contact__span">
            Звонок бесплатный
        </span>
        </div>
        <a href="{{ url('login') }}" class="top__account">
            <div class="top__link">Личный кабинет</div>
            <img src="{{ asset('img/top/account.svg') }}" alt="Иконка: личный кабинет" class="person">
        </a>
    </div>
</div>
