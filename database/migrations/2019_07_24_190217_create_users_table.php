<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('auth_key')->unique();
            $table->string('password');
            $table->string('role', 32)->default(User::ROLE_USER);

            $table->string('flags', 5)->nullable();
            $table->string('steam_id', 32)->unique();
            $table->string('nickname', 32)->unique();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
