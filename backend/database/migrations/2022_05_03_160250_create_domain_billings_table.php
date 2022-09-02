<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain_billings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dealing_id');
            $table->decimal('total', 10, 0)->default(0)->comment('請求額合計');
            $table->dateTime('billing_date')->comment('請求日');
            $table->boolean('is_fixed')->comment('確定済');
            $table->dateTime('changed_at')->nullable()->comment('変更日');
            $table->dateTime('updated_at')->comment('更新日');
            $table->dateTime('created_at')->comment('登録日');

            $table->foreign('dealing_id')
            ->references('id')
            ->on('domain_dealings')
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
        Schema::dropIfExists('domain_billings');
    }
}
