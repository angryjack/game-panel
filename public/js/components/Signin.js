let $login = $('input[name="login"]');
let $password = $('input[name="password"]');
let $btn = $('.btn-signin');
let $errorContainer = $('.error-container');

$login.on('keyup', removeErrors);
$password.on('keyup', removeErrors);


$('.do-login').on('click', function () {
    let login = $login.val();
    let password = $password.val();

    if (login.length < 2 || password.length < 5) {
        addErrors('Пожалуйста, введите логин и пароль.');
        return;
    }
    let data = {
        login: login,
        password: password
    };

    axios.post($('form').attr('action'), data)
        .then((r) => {
            window.location.href = '/profile';
        })
        .catch((e) => {
            addErrors('Логин или пароль указан неверно.');
        });
});

function addErrors(message) {
    $errorContainer.html(message);
    $btn.addClass('disabled');
    $login.addClass('parsley-error');
    $password.addClass('parsley-error');
    $login.select();
}

function removeErrors() {
    $errorContainer.html('');
    $btn.removeClass('disabled');
    $login.removeClass('parsley-error');
    $password.removeClass('parsley-error');
}
