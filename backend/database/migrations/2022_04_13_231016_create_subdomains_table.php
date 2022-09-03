<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubdomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdomains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domain_id');
            $table->string('prefix')->default('')->comment('サブドメイン');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('value')->default('')->comment('レコード値');
            $table->integer('ttl')->default(0)->comment('TTL');
            $table->integer('priority')->default(0)->comment('メール優先順位');
            $table->dateTime('updated_at')->comment('更新日');
            $table->dateTime('created_at')->comment('登録日');

            $table->foreign('domain_id')
            ->references('id')
            ->on('domains')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreign('type_id')
            ->references('id')
            ->on('dns_record_types')
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
        Schema::dropIfExists('subdomains');
    }
}
