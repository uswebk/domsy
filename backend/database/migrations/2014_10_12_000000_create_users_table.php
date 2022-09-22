<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('email_verify_token')->nullable(true);
            $table->dateTime('email_verified_at')->nullable(true);
            $table->dateTime('last_login_at')->nullable(true);
            $table->rememberToken();
            $table->dateTime('deleted_at')->default(null)->nullable(true);
            $table->dateTime('updated_at')->nullable(false);
            $table->dateTime('created_at')->nullable(false);
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
