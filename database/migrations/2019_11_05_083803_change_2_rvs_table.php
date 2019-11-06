<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Change2RvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('srvs', function (Blueprint $table) {
            $table->date('contract_start_date');
            $table->date('contract_end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('srvs', function (Blueprint $table) {
            $table->dropColumn('contact_start_date');
            $table->dropColumn('contact_end_date');
        });
    }
}
