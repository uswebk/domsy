<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_setting_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('基本設定カテゴリ名');
            $table->string('annotation')->comment('基本設定カテゴリ注釈');
            $table->integer('sort')->comment('並び順');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_setting_categories');
    }
}
