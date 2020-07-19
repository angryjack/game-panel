<?php

use App\Models\User;

/** @var $router \Illuminate\Routing\Router */


//Route::group(['middleware' => ['auth', 'role:admin']], function () {});
//Route::prefix('/user')->group(function () {});


//Сайт
$router->get('/', 'SiteController@index')->name('home');

//Вход-выход
$router->get('login', 'LoginController@loginPage')->name('login');
$router->post('login', 'LoginController@login')->name('login');
$router->get('logout', 'LoginController@logout')->name('logout');

// профиль
$router->group(['prefix' => 'profile'], function () use ($router) {
    $router->get('/', 'ProfileController@profile')
        ->middleware('auth')
        ->name('profile');
    $router->get('/auth', 'SiteController@auth');
    $router->post('/update', 'ProfileController@updateProfile')
        ->middleware('auth')
        ->name('profile.update');
});

// оплата
$router->group(['prefix' => 'payment'], function () use ($router) {
    $router->get('/handle', 'PaymentController@handle');
    $router->get('/result', 'PaymentController@result');
    $router->post('/redirect', 'PaymentController@redirect');
});

// пользователи
$router->group(['prefix' => 'users', 'middleware' => ['auth', 'role:' . User::ROLE_ADMIN]], function () use ($router) {
    $router->get('/', 'UserController@index')->name('users');
    $router->get('/create', 'UserController@create')->name('users.create');
    $router->get('/edit/{id}', 'UserController@edit')->name('users.edit');
    $router->get('/delete/{id}', 'UserController@delete')->name('users.delete');
    $router->get('/{id}', 'UserController@show')->name('users.show');
    $router->post('/store', 'UserController@store')->name('users.store');
    $router->post('/update', 'UserController@update')->name('users.update');
});

// привилегии
$router->group(['prefix' => 'privileges', 'middleware' => ['auth', 'role:' . User::ROLE_ADMIN]], function () use ($router) {
    $router->get('/', 'PrivilegeController@index')->name('privileges');
    $router->get('/create', 'PrivilegeController@create')->name('privileges.create');
    $router->get('/edit/{id}', 'PrivilegeController@edit')->name('privileges.edit');
    $router->get('/delete/{id}', 'PrivilegeController@delete')->name('privileges.delete');
    $router->post('/store', 'PrivilegeController@store')->name('privileges.store');
});
$router->group(['prefix' => 'privileges'], function () use ($router) {
    $router->get('/buy', 'PrivilegeController@buy')->name('privilege.buy');
    $router->get('/{id}', 'PrivilegeController@show')->name('privileges.show');
    $router->post('/server/{id}', 'PrivilegeController@server');
    $router->post('/{id}/terms', 'PrivilegeController@privilege');
});

// сервера
$router->group(['prefix' => 'servers', 'middleware' => ['auth', 'role:' . User::ROLE_ADMIN]], function () use ($router) {
    $router->get('create', 'ServerController@create')->name('servers.create');
    $router->get('edit/{id}', 'ServerController@edit')->name('servers.edit');
    $router->get('delete/{id}', 'ServerController@delete')->name('servers.delete');
    $router->post('store', 'ServerController@store')->name('servers.store');
});
$router->group(['prefix' => 'servers'], function () use ($router) {
    $router->get('/', 'ServerController@index')->name('servers');
    $router->get('list', 'ServerController@list');
    $router->get('info/{id}', 'ServerController@info');
    $router->get('{id}', 'ServerController@show')->name('servers.show');
});

// пожертвования
$router->get('donations', 'DonationController@index')->name('donations');
