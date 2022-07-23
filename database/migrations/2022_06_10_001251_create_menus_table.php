<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->string('name')->comment('メニュー名');
            $table->string('description')->comment('メニュー詳細説明');
            $table->string('url_path')->comment('リンク');
            $table->string('icon')->comment('アイコン');
            $table->boolean('is_nav')->comment('ナビゲーション有無');
            $table->unsignedInteger('sort')->comment('並び順');
            $table->dateTime('updated_at')->comment('更新日');
            $table->dateTime('created_at')->comment('登録日');

            $table->foreign('type_id')
            ->references('id')
            ->on('menu_types')
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
        Schema::dropIfExists('menus');
    }
}
