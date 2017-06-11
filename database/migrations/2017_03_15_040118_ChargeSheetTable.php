<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChargeSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargesheet_information', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('modified_by');
            $table->softDeletes();
            $table->integer('case_id');
            $table->date('date');
             $table->string('chargesheet_attach', 255)->nullable();
        });


        Schema::create('chargesheet_information_details', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('chargesheet_information_id');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chargesheet_information');
        Schema::drop('chargesheet_information_details');
    }
}
