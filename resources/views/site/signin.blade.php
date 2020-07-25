<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} - Войти</title>
    <link href="/lib/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/slim.min.css">
    @if(env('THEME_BLACK'))
        <link rel="stylesheet" href="/css/slim.one.css">
    @endif
</head>
<body>
<div class="d-md-flex flex-row-reverse">
    <div class="signin-right">
        <div class="signin-box">
            <h2 class="signin-title-primary">С Возвращением!</h2>
            <h3 class="signin-title-secondary">Войдите чтобы продолжить.</h3>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text"
                           name="login"
                           class="form-control"
                           placeholder="Введите логин"
                           value="{{ old('login') }}"
                           required>
                    @error('login')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mg-b-50">
                    <input type="password" name="password" class="form-control" placeholder="Введите пароль"
                           minlength="5"
                           required>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-signin">
                    Войти
                </button>
            </form>
        </div>

    </div>
    <div class="signin-left">
        <div class="signin-box">
            <h2 class="slim-logo"><a href="{{ route('home') }}">{{ env('APP_NAME') }}<span>.</span></a></h2>

            <p class="tx-12">© Copyright @php echo date('Y') @endphp. Все права защищены.</p>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="/js/libs/jquery.js"></script>
<script src="/js/components/Signin.js"></script>

</body>
</html>
