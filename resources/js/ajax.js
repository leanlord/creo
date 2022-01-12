
/*
    Псевдокод для Показать квартиры:

    1) проверяя на пустоту, сформировать значение браузерной строки
    2) с помощью history API изменить строку браузера

    let uri = '/?';
    foreach(inputs as input) {
        if (input.value.isNotEmpty()) {
            uri += input.name + '=' + input.value + '&';
        }
    }

    Псевдокод для Показать еще:
    1) сделать селектор на все инпуты формы
    2) в ajax заменить функцию load() на html()
    3) в параметр передавать значение uri браузерной строки
 */


$('#hero').submit(function () {
    let $form = $(this)
    $form.find('.error').remove();
})


