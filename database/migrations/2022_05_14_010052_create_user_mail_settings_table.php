<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMailSettingsTable extends Migration
{
    protected $table_schema = 'user_mail_settings';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_schema, function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->unsignedBigInteger('mail_category_id')->comment('メールカテゴリID');
            $table->unsignedInteger('notice_number_days')->default(0)->comment('事前通知日数');
            $table->boolean('is_received')->comment('受信可否');
            $table->dateTime('updated_at')->comment('更新日');
            $table->dateTime('created_at')->comment('登録日');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreign('mail_category_id')
            ->references('id')
            ->on('mail_categories')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->unique(['user_id', 'mail_category_id']);
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
