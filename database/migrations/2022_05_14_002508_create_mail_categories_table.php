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
