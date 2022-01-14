import swal from 'sweetalert';

const swalSucces = {
    title: "Форма успешно отправлена!",
    text: "Ожидайте звонка.",
    icon: "success",
}

const swalError = {
    title: "Упс...",
    text: "Что-то пошло не так.",
    icon: "error",
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function userFilledFields(data) {
    return data.name !== undefined &&
        data.number !== undefined &&
        document.getElementById('form-checkbox').checked;
}

$('#form-submit').click(function (event) {

    let data = {
        name: document.getElementById('form-name').value,
        number: document.getElementById('form-number').value,
    };

    if (userFilledFields(data)) {
        event.preventDefault();

        $.post('/', data)
            .done(function() {
                swal(swalSucces);
            })
            .fail(function () {
                swal(swalError);
            });
    }
});
