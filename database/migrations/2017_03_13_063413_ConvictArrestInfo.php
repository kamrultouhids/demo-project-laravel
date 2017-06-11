<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvictArrestInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convict_arrest_information', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('modified_by');
            $table->softDeletes();
            $table->integer('case_id');
            $table->date('date');
            $table->string('attach', 255);
        });


        Schema::create('convict_arrest_information_details', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('convict_arrest_information_id');
            $table->string('name',150);
            $table->string('place',150);
            $table->text('legal_goods_seized');
            $table->text('illegal_goods_seized');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('convict_arrest_information');
        Schema::drop('convict_arrest_information_details');
    }
}
