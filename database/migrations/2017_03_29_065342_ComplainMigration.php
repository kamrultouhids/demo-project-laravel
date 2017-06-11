<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComplainMigration extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('complain_info', function (Blueprint $table) {
      $table->increments('id')->unsigned();
      $table->timestamps();
      $table->integer('created_by');
      $table->integer('modified_by');
      $table->softDeletes();
      $table->string('reference_no',50)->nullable();
      $table->integer('battalion');
      $table->date('date');
      $table->string('complainant_name',150);
      $table->integer('complainant_age');
      $table->string('complainant_gender',10);
      $table->string('complainant_father_name', 150)->nullable();
      $table->string('complainant_mother_name', 150)->nullable();
      $table->string('complainant_contact_number', 20);
      $table->text('complainant_permanent_address')->nullable();
      $table->text('complainant_present_address');
      $table->text('complainant_details')->nullable();

    });



    Schema::create('complainant_defendant_info', function (Blueprint $table) {
      $table->increments('id')->unsigned();
      $table->integer('complainant_info_id');
      $table->string('defendant_name',150);
      $table->integer('defendant_age');
      $table->string('defendant_gender',10);
      $table->string('defendant_father_name', 150)->nullable();
      $table->string('defendant_mother_name', 150)->nullable();
      $table->string('defendant_contact_number', 20);
      $table->text('defendant_permanent_address')->nullable();
      $table->text('defendant_present_address');
    });



  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {

    Schema::drop('complain_info');
    Schema::drop('complainant_info');
    Schema::drop('complainant_defendant_info');
  }
}
