<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordcallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recordcalls', function (Blueprint $table) {
          $table->bigIncrements('record_id');
          $table->string('contno')->nullable();
          $table->string('name')->nullable();
          $table->string('fdate')->nullable();
          $table->string('tel')->nullable();
          $table->string('exp_amt')->nullable();
          $table->string('exp_frm')->nullable();
          $table->string('exp_to')->nullable();
          $table->string('exp_prd')->nullable();
          $table->string('hldno')->nullable();
          $table->string('l_hldno')->nullable();
          $table->string('pay_status')->nullable();
          $table->string('group')->nullable();
          $table->date('date_record')->nullable();
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
        Schema::dropIfExists('recordcalls');
    }
}
