<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->text('name')->comment('ドメイン名');
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->integer('price')->comment('価格');
            $table->boolean('is_active')->comment('稼働フラグ');
            $table->boolean('is_transferred')->comment('移管フラグ');
            $table->boolean('is_management_only')->comment('管理のみ');
            $table->dateTime('purchased_at')->comment('購入日');
            $table->dateTime('expired_at')->comment('更新期限日');
            $table->dateTime('canceled_at')->nullable(true)->comment('解約日');
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
        Schema::table('domains', function (Blueprint $table) {
            //
            Schema::dropIfExists('domains');
        });
    }
}
