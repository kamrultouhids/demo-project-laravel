<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WitnessMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('witness', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('case_id');
            $table->date('date');
            $table->string('witness_attach',255);
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('modified_by');
            $table->timestamps();
        });

        Schema::create('witness_information_details', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('fk_witness_id')->unsigned();
            $table->string('witness_name',255);
            $table->integer('age');
            $table->string('gender',255);

            $table->string('father_name',255);
            $table->string('mother_name',255);
            $table->string('contact_no',255);
            $table->string('profession',255);
            $table->text('parmanent_address');
            $table->text('present_address');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('witness');
        Schema::drop('witness_information_details');
    }
}
