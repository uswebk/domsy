<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('会社名');
            $table->string('email')->comment('メールアドレス');
            $table->char('zip', 7)->comment('請求先郵便番号');
            $table->string('address')->comment('請求先住所');
            $table->string('phone_number', 20)->comment('電話番号');
            $table->dateTime('updated_at')->comment('更新日');
            $table->dateTime('created_at')->comment('登録日');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
