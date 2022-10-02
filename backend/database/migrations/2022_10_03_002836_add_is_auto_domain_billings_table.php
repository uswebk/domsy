<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAutoDomainBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domain_billings', function (Blueprint $table) {
            $table->boolean('is_auto', 255)->comment('自動追加')
            ->default(0)
            ->after('is_fixed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domain_billings', function (Blueprint $table) {
            $table->dropColumn('is_auto');
        });
    }
}
