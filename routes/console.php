<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('user:create {user} {password}', function ($user, $password) {
    \App\Models\User::create([
        'username' => $user,
        'email' => $user . '@example.com',
        'password' => md5($password),
        'access' => 'a',
        'flags' => 'a',
        'steamid' => 'STEAM_00',
        'nickname' => $user,
        'role' => \App\Models\User::ROLE_ADMIN,
    ]);
});
