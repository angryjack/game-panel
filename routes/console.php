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


Artisan::command('user:create {user}', function ($user) {

    $password = \Illuminate\Support\Str::random();

    \App\Models\User::create([
        'name' => $user,
        'email' => 'admin@local',
        'auth_key' => md5($user),
        'password' => md5($password),
        'role' => \App\Models\User::ROLE_ADMIN,
        'flags' => 'a',
        'steam_id' => 'STEAM_LOCAL',
        'nickname' => 'NICKNAME',
    ]);

    echo "Login: $user \nPass: $password\n";
});
