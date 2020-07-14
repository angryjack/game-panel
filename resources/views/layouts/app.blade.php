<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="/css/libs/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/libs/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="/css/libs/select2/css/select2.min.css" rel="stylesheet">
    <link href="/css/libs/jquery.steps/css/jquery.steps.css" rel="stylesheet">
    <link href="/css/libs/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="stylesheet" href="/css/slim.min.css">
    @if(env('THEME_BLACK'))
        <link rel="stylesheet" href="/css/slim.one.css">
    @endif

    <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>
@include('layouts.header')

@include('layouts.navbar')

<div class="slim-mainpanel">
    @yield('content')
</div>

@include('layouts.footer')

<script src="{{ asset('js/app.js') }}"></script>

<script src="/js/libs/jquery.js"></script>
<script src="/js/libs/popper.js"></script>
<script src="/js/libs/bootstrap.min.js"></script>
<script src="/js/libs/select2.min.js"></script>
<script src="/js/libs/jquery-ui.js"></script>
<script src="/js/libs/moment.js"></script>
<script src="/js/libs/bootstrap-tagsinput.js"></script>
<script src="/js/libs/jquery.steps.js"></script>
<script src="/js/libs/parsley.js"></script>
<script src="/js/libs/ru.js"></script>

<script src="/js/components/BuyPrivilege.js"></script>
<script src="/js/components/Signin.js"></script>
<script src="/js/components/User.js"></script>
<script src="/js/components/Donation.js"></script>
<script src="/js/components/Profile.js"></script>
<script src="/js/components/Users.js"></script>
<script src="/js/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?162"></script>


</body>
</html>
