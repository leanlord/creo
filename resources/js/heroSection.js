const params = new URLSearchParams(window.location.search)

for (const param of params) {
    console.log(param);
    let element = $('#' + param[0]);
    if (param[1] != '' && param[1] != 'Любой') {
        element.val(param[1])
    }
}
