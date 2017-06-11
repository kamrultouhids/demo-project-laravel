<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvestigationMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('investigation_details', function (Blueprint $table) {
            $table->increments('id');
            $table->date('investigation_date');
            $table->integer('case_number')->unsigned();
            $table->string('investigation_details',255);
            $table->string('investigation_attach',255);
            $table->integer('investigation_by')->unsigned();
            $table->softDeletes();
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
        Schema::drop('investigation_details');
    }
}
