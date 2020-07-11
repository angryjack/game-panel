@extends('layouts.app')

@section('title', env('APP_NAME') . ' - Войти')

@section('content')
    <div class="d-md-flex flex-row-reverse">
        <div class="signin-right">
            <div class="signin-box">
                <h2 class="signin-title-primary">С Возвращением!</h2>
                <h3 class="signin-title-secondary">Войдите чтобы продолжить.</h3>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Введите почту"
                               required>
                    </div><!-- form-group -->
                    <div class="form-group mg-b-50">
                        <input type="password" name="password" class="form-control" placeholder="Введите пароль"
                               minlength="5"
                               required>
                        <ul class="parsley-errors-list filled">
                            <li class="parsley-required tx-14 error-container"></li>
                        </ul>
                    </div><!-- form-group -->

                    <button class="do-login btn btn-primary btn-block btn-signin">Войти</button>
                </form>
                {{--<p class="mg-b-0">Нет аккаунта? <a href="{{ route('signup') }}">Пройдите регистрацию</a></p>--}}
            </div>

        </div>
        <div class="signin-left">
            <div class="signin-box">
                <h2 class="slim-logo"><a href="{{ route('home') }}">{{ env('APP_NAME') }}<span>.</span></a></h2>

                @include('custom.signin')

                <p><a href="{{ route('home') }}" class="btn btn-outline-secondary pd-x-25">Подробнее</a></p>

                <p class="tx-12">© Copyright @php echo date('Y') @endphp. Все права защищены.</p>
            </div>
        </div>
    </div>
@endsection
