@extends('layouts.app')

@section('title', 'Сервера')

@section('content')
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            </ol>
            <h6 class="slim-pagetitle">@yield('title')</h6>
        </div>

        @if(auth()->user() !== null && auth()->user()->hasRole('admin'))
            <div class="row">
                <div class="col-sm-6 col-md-3 mg-b-10">
                    <a class="btn btn-teal btn-block" href="{{ route('servers.create') }}">Добавить</a>
                </div>
            </div>
        @endif

        <div class="row">
            @foreach($list as $server)
                <div class="col-lg-6 mb-4">
                    <div class="card card-profile">
                        <div class="card-body">
                            <div class="media d-flex align-items-center">
                                <div class="media-body">
                                    <h3 class="card-profile-name">
                                        <a class="text-dark" href="{{ route('servers.show', ['id' => $server->id]) }}">
                                            {{ $server->hostname }}
                                        </a>
                                    </h3>
                                    <p class="mb-1">{{ $server->address }}</p>
                                </div>
                                <div class="media-body">
                                    <div class="col-sm-12">
                                        <a class="btn btn-warning btn-block" href="{{ route('servers.edit', ['id' => $server->id]) }}">
                                            Редактировать
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
