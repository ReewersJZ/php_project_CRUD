var message = document.querySelector('#message');

function showMessage(type, msg) {
    message.className = type;
    message.innerHTML = msg;
}

function SwapMovie(option, action) {
    var data = {};
    data['id_aktora'] = document.getElementById('aktor_movies').getAttribute('data-id_aktora');
    data['id_filmu'] = option.value;
    data['action'] = action;

    AJAX({
        type: 'GET',
        url: 'ajax/filmy_aktora.php',
        data: data,
        success: function(response, xhr) {
            var res = JSON.parse(response);

            if (Array.isArray(res)) {
                showMessage('error', res.join('<br>'));
            } else if ('error' in res) {
                showMessage('error', res.error);
            } else if ('success' in res) {
                document.getElementById('aktor_movies').innerHTML = res.success;
            }
        }
    });
}