<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Coart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coart_information', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('modified_by');
            $table->softDeletes();
            $table->integer('case_id');
            $table->date('date');
            $table->string('coart_name',255);
            $table->string('judge_name');
            $table->text('judgment');
            $table->string('coart_attach',255);
        });


        Schema::create('coart_information_details', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('coart_info_id');
            $table->string('name',150);
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coart_information');
        Schema::drop('coart_information_details');
    }
}
