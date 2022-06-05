<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->string('name')->comment('レジストラ名');
            $table->string('link')->default('')->comment('レジストラURL');
            $table->text('note')->comment('備考');
            $table->dateTime('updated_at')->comment('更新日');
            $table->dateTime('created_at')->comment('登録日');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrars');
    }
}
