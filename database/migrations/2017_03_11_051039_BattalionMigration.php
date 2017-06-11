<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BattalionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battalion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_division_id');
            $table->integer('fk_district_id');
            $table->integer('fk_police_station_id');
            $table->string('battalion_name',255)->unique();
            $table->string('battalion_address',255);
            $table->string('contact_person_name',255);
            $table->string('designation',255);
            $table->string('contact_no',255);
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
        Schema::drop('battalion');
    }
}
