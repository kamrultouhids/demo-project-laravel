<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KeyContstraintsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('districts', function ($table) {
            $table->foreign('fk_division_id', 'fk_division_district_id')->references('id')->on('divisions');
        });
        Schema::table('rab_employee', function ($table) {
            $table->foreign('fk_battalion_id', 'fk_battalion_battalion_id')->references('id')->on('battalion');
        });
        Schema::table('rab_employee', function ($table) {
            $table->foreign('fk_designation_id', 'fk_designation_employee_id')->references('id')->on('designation');
        });
        Schema::table('witness_information_details', function ($table) {
            $table->foreign('fk_witness_id', 'fk_witness_id')->references('id')->on('witness');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
