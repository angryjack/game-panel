let $profileName = $('input[name="nickname"]');
let $profilePassword = $('input[name="password"]');

$profileName.on('keyup', function () {
    $profileName.removeClass('is-invalid');
    $profileName.siblings('.errors').html('');
});
$profilePassword.on('keyup', function () {
    $profilePassword.removeClass('is-invalid');
    $profilePassword.siblings('.errors').html('');
});

$('.extend-privilege').on('click', function () {
    var $form = $('.server-' + $(this).attr('data-server'));
    var rate = $form.find('select').val();

    axios.post('/payment/go/privilege', {rate: rate})
        .then((r) => {
            window.location.href = response.url;
        });
});

$('.do-update').on('click', function () {

    let data = {
        nickname: $profileName.val(),
        password: $profilePassword.val()
    };

    axios.post('/profile/update', data)
        .then((r) => {
            window.location.reload();
        }).catch((e) => {
            console.log(e, e.response);
            return;
        if (e.response.responseJSON.nickname) {
            $profileName.addClass('is-invalid');
            $profileName.siblings('.errors').html(response.responseJSON.nickname)
        }

        if (response.responseJSON.password) {
            $profilePassword.addClass('is-invalid');
            $profilePassword.siblings('.errors').html(response.responseJSON.password)
        }
    });
});
