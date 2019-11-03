<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppInfra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_infra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('app_id');
            $table->integer('srv_id');
            $table->integer('domain_id');
            $table->integer('name');
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
        Schema::dropIfExists('app_infra');
    }
}
