@extends('layouts.app')

@section('title', env('APP_NAME') . ' - Контакты')

@section('content')
    <div class="container">
        <div class="slim-pageheader">
            <h6 class="slim-pagetitle mr-auto">Контакты</h6>
        </div>
        <div class="row row-sm">
            <div class="col-md-6 col-lg-4 mg-t-10 mg-md-t-0 order-lg-4">
                <div class="card card-info">
                    <div class="card-body pd-40">
                        <div class="d-flex justify-content-center mg-b-30">
                            <img src="/images/admin.jpg" class="wd-100" alt="">
                        </div>
                        <h5 class="tx-inverse mg-b-20">Главный Админ</h5>
                        <p>Привет! Меня зовут <b>Алексей</b>. Связаться со мной можно по контактам:</p>
                        <p><b>Почта:</b> <a href="mailto:gmcsforce@yandex.ru">gmcsforce@yandex.ru</a></p>
                        <p><b>Вконтакте:</b> <a href="//vk.com/javekson">vk.com/javekson</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mg-t-10 mg-lg-t-0 order-lg-2">
                <div class="card card-quick-post">
                    <div class="d-flex justify-content-center">
                        <img src="/images/logo.jpg" alt="" style="max-width: 100%">
                    </div>
                    <div class="content mt-4">
                        <p>📌 Название: GAME FORCE | PUBLIC 18+ <br>
                            ✔ IP-адрес: 37.230.210.128:27015 <br>
                            🍧 Девушкам VIP бесплатно <br>
                            💰 VIP-привилегии: от 100 рублей <br>
                            🔥 Современная защита, хорошая стрельба <br>
                            🍓 Веселая и дружная администрация <br>
                            👌 Уютная и комфортная атмосфера на сервере <br>
                             ☢ Night VIP с 23:00 по 11:00 МСК <br>
                        </p>
                        <p>Наша группа Вконтакте: <a href="//vk.com/gmforce" target="_blank" class="d-block">vk.com/gmforce</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

