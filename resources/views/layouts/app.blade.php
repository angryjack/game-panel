<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    @if(env('THEME_BLACK')) @endif

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>

@include('layouts.header')

@include('layouts.navbar')

<div class="slim-mainpanel">
    @yield('content')
</div>

@include('layouts.footer')
<script src="{{ mix('js/app.js') }}"></script>
<script src="//unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>
</html>
