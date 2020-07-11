<div class="slim-header">
    <div class="container">
        <div class="slim-header-left">
            <h2 class="slim-logo">
                <a href="/">{{ env('APP_NAME') }}<span>.</span></a>
            </h2>
        </div><!-- slim-header-left -->
        <div class="slim-header-right">
            <div class="dropdown dropdown-c">
                <a id="header-dropdown-toggle" class="logged-user">
                    <img src="https://via.placeholder.com/500x500" alt="">
                    <span>
                        @auth
                            {{ auth()->user()->nickname }}
                        @else
                            Гость
                        @endif
                    </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <div id="header-dropdown" class="dropdown-menu dropdown-menu-right">
                    <nav class="nav">
                        @auth
                            <a href="{{ route('profile') }}" class="nav-link"><i class="icon ion-person"></i>Профиль</a>
                            <a href="{{ route('logout') }}" class="nav-link"><i class="icon ion-forward"></i>Выйти</a>
                        @else
                            <a href="{{ route('login') }}" class="nav-link"><i class="icon ion-log-in"></i>Войти</a>
                        @endif
                    </nav>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
        </div><!-- header-right -->
    </div><!-- container -->
</div>
