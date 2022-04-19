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
            $table->unsignedBigInteger('registrar_id');
            $table->unsignedBigInteger('client_id');
            $table->decimal('subtotal', 10, 0);
            $table->decimal('discount', 10, 0);
            $table->dateTime('billing_date');
            $table->tinyInteger('interval');
            $table->enum('interval_category', ['Day','Week', 'Month', 'Year']);
            $table->boolean('is_auto_update');
            $table->dateTime('updated_at')->comment('更新日');
            $table->dateTime('created_at')->comment('登録日');

            $table->foreign('domain_id')
            ->references('id')
            ->on('domains')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreign('registrar_id')
            ->references('id')
            ->on('registrars')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreign('client_id')
            ->references('id')
            ->on('clients')
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
        Schema::dropIfExists('domain_dealings');
    }
}
