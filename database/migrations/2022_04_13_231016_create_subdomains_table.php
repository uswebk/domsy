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
            $table->string('prefix')->nullable()->comment('サブドメイン');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('value')->comment('レコード値')->nullable();
            $table->integer('ttl')->nullable();
            $table->integer('priority')->comment('メール優先順位')->nullable();
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
        Schema::dropIfExists('domain_dns_records');
    }
}
