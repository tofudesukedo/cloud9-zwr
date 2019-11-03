<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mem_id');
            $table->integer('parent_id');
            $table->string('name');
            $table->string('register');
            $table->string('contract_plan');
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->integer('enable_flg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domain');
    }
}
