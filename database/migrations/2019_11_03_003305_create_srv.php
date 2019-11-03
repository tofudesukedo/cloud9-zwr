<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srv', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mem_id');
            $table->string('name');
            $table->string('vendor');
            $table->string('contract_plan');
            $table->date('contact_start_date');
            $table->date('contact_end_date');
            $table->string('os');
            $table->string('overview');
            $table->text('middleware');
            $table->integer('enable_flg');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('srv');
    }
}
