<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailCategoriesTable extends Migration
{
    protected $table_schema = 'mail_categories';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_schema, function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('メールカテゴリ名');
            $table->string('annotation')->comment('メールカテゴリ注釈');
            $table->boolean('is_specify_number_days')->comment('日数指定可能');
            $table->integer('default_days')->comment('メール通知標準値');
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
        Schema::dropIfExists($this->table_schema);
    }
}
