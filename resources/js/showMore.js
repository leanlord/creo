let noMore = false;
let page = 1;
let url = document.URL;

$('.flats__button').click(function (event) {
    event.preventDefault();
    page++;

    if (url.includes("?")) {
        url += "&page=";
    } else {
        url += "?page=";
    }
    url += page;

    $.get(url, function (data) {
        if (!data.includes('<div class="flats__flat">')) {
            console.log("nomore");
            if (!noMore) {
                $("#flats-wrapper").append(data);
                noMore = true;
            }
        } else {
            $("#flats-wrapper").append(data);
        }
    });
});

