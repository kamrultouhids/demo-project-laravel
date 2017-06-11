<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CaseAndDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('modified_by');
            $table->softDeletes();
            $table->string('reference_no',50);
            $table->string('previous_case_no',50);
            $table->string('litigant_name',150);
            $table->integer('litigant_designation');
            $table->integer('litigant_battalion');
            $table->string('fir_attach', 255);
            $table->integer('status');
            $table->longText('evidence');
        });


        Schema::create('case_convict_info', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('case_id');
            $table->string('convict_name',150);
            $table->integer('convict_age');
            $table->string('convict_gender',10);
            $table->string('convict_father_name', 150)->nullable();
            $table->string('convict_mother_name', 150)->nullable();
            $table->string('convict_contact_number', 20);
            $table->text('convict_permanent_address')->nullable();
            $table->text('convict_present_address');
            $table->enum('convict_pastcase', ['0', '1'])->default('0');
            $table->text('convict_details')->nullable();
        });

        Schema::create('case_victim_info', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('case_id');
            $table->string('victim_name',150);
            $table->integer('victim_age');
            $table->string('victim_gender',10);
            $table->string('victim_father_name', 150)->nullable();
            $table->string('victim_mother_name', 150)->nullable();
            $table->string('victim_contact_number', 20);
            $table->text('victim_permanent_address')->nullable();
            $table->text('victim_present_address');
        });


        Schema::create('case_law_section', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('case_id');
            $table->integer('law_type');
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
        Schema::drop('case');
        Schema::drop('case_convict_info');
        Schema::drop('case_victim_info');
        Schema::drop('case_crime_info');
        Schema::drop('case_law_section');
    }
}
