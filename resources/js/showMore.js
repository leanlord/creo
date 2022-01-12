const showMoreButton = $('.flats__button');
showMoreButton.click((event) => {
    event.preventDefault()
    $('#show-more').load('?min_price=9000000');
    $('.flats__main').append($('#flats-button'));
    console.log('success');
})
