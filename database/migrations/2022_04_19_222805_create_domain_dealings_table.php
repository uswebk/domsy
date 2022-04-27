<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainDealingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain_dealings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domain_id');
            $table->unsignedBigInteger('client_id');
            $table->decimal('subtotal', 10, 0)->default(0);
            $table->decimal('discount', 10, 0)->default(0);
            $table->dateTime('billing_date')->comment('請求日');
            $table->tinyInteger('interval');
            $table->enum('interval_category', ['Day','Week', 'Month', 'Year'])->comment('請求間隔');
            $table->boolean('is_auto_update')->comment('請求情報自動更新可否');
            $table->dateTime('updated_at')->comment('更新日');
            $table->dateTime('created_at')->comment('登録日');

            $table->foreign('domain_id')
            ->references('id')
            ->on('domains')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreign('client_id')
            ->references('id')
            ->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domain_dealings');
    }
}
