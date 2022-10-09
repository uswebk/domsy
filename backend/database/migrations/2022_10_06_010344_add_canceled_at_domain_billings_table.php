<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCanceledAtDomainBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domain_billings', function (Blueprint $table) {
            $table->dateTime('canceled_at')->nullable()->comment('キャンセル日')
            ->after('changed_at');
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
            $table->dropColumn('canceled_at');
        });
    }
}
