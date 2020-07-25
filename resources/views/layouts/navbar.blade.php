@php

    $menu = [
        [
            'href' => '',
            'title' => 'Главная',
            'icon' => 'home'
        ],
        [
            'href' => 'users',
            'title' => 'Пользователи',
            'icon' => 'people',
            'role' => \App\Models\User::ROLE_ADMIN
        ],
        /*[
            'href' => 'donations',
            'title' => 'Пожертвования',
            'icon' => 'heart'
        ],*/
        [
            'href' => 'servers',
            'title' => 'Сервера',
            'icon' => 'game-controller-b',
            'role' => \App\Models\User::ROLE_ADMIN,
        ],
        [
            'href' => 'privileges',
            'title' => 'Привилегии',
            'icon' => 'gear',
            'role' => \App\Models\User::ROLE_ADMIN,
        ],
        [
            'href' => 'contacts',
            'title' => 'Контакты',
            'icon' => 'contact',
        ],
    ];

@endphp

<div class="slim-navbar">
    <div class="container">
        <ul class="nav">
            @foreach($menu as $item)
                @isset($item['role'])
                    @if(auth()->user() === null || !auth()->user()->hasRole($item['role']))
                        @continue
                    @endif
                @endif
                <li class="nav-item @if(request()->is($item['href']) ||
                request()->is($item['href'] . '/*') ) active @endif @isset($item['sub']) with-sub @endif">
                    <a class="nav-link" href="/{{ $item['href'] }}">
                        <i class="icon ion-ios-{{ $item['icon'] }}-outline"></i>
                        <span>{{ $item['title'] }}</span>
                    </a>
                    @isset($item['sub'])
                        <div class="sub-item">
                            <ul>
                                @foreach($item['sub'] as $link => $submenu)
                                    <li><a href="/{{ $link }}">{{ $submenu }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
