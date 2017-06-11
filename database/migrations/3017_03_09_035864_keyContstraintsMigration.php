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
  

        Schema::table('investigation_attended_person', function ($table) {
            $table->foreign('fk_investigation_id', 'investigation_details_attended_person')->references('id')->on('investigation_details');
        });
     Schema::table('investigation_attended_person', function ($table) {
            $table->foreign('attended_person', 'investigation_details_rab_employee')->references('id')->on('rab_employee');
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
