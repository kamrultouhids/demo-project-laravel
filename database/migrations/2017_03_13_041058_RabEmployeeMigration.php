<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RabEmployeeMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rab_employee', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_no')->unique();
            $table->string('employee_name',255);
            $table->string('gender');
            $table->string('contact_no',255);
            $table->string('employee_image',255);
            $table->integer('fk_battalion_id')->unsigned();
            $table->integer('fk_designation_id')->unsigned();
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::drop('rab_employee');
    }
}
