<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_items', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->comment('権限ID');
            $table->unsignedBigInteger('menu_item_id')->comment('メニュー項目');
            $table->dateTime('updated_at')->comment('更新日');
            $table->dateTime('created_at')->comment('登録日');

            $table->foreign('role_id')
            ->references('id')
            ->on('roles')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreign('menu_item_id')
            ->references('id')
            ->on('menu_items')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->primary(['role_id', 'menu_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_items');
    }
}
