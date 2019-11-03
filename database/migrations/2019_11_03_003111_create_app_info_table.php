<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('app_id');
            $table->integer('app_info_key_id');
            $table->integer('parent_id');
            $table->integer('value_mem_id');
            $table->integer('value_opt_id');
            $table->integer('value_int');
            $table->text('value_str');
            $table->integer('value_boolean');
            $table->date('value_date');
            $table->text('note');
            $table->integer('delete_flg');
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
        Schema::dropIfExists('app_info');
    }
}
