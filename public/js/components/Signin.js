let $email = $('input[name="email"]');
let $password = $('input[name="password"]');
let $btn = $('.btn-signin');
let $errorContainer = $('.error-container');

$email.on('keyup', removeErrors);
$password.on('keyup', removeErrors);


$('.do-login').on('click', function () {
    let email = $email.val();
    let password = $password.val();

    if (email.length < 2 || password.length < 5) {
        addErrors('Пожалуйста, введите логин и пароль.');
        return;
    }
    let data = {
        email: email,
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
    $email.addClass('parsley-error');
    $password.addClass('parsley-error');
    $email.select();
}

function removeErrors() {
    $errorContainer.html('');
    $btn.removeClass('disabled');
    $email.removeClass('parsley-error');
    $password.removeClass('parsley-error');
}
