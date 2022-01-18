import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';

const inputElement = document.querySelector('input[id="avatar"]');
const pond = FilePond.create(inputElement);
FilePond.setOptions({
    server: {
        url: '/account/upload-avatar',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        process: {
            onload: (response) => {
                console.log(response.substr(1, response.length - 2));
                let img = $('#profile-img');
                img.attr(
                    'src', 'http://www.creo.test/avatars/' +
                    response.substr(1, response.length - 2)
                );
            }
        }
    }
});


