<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoldcarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holdcars', function (Blueprint $table) {
            $table->bigIncrements('Hold_id');
            $table->string('Contno_hold')->nullable();
            $table->string('Name_hold')->nullable();
            $table->string('Brandcar_hold')->nullable();
            $table->string('Number_Regist')->nullable();
            $table->string('Year_Product')->nullable();
            $table->string('Date_hold')->nullable();
            $table->string('Dateupdate_hold')->nullable();
            $table->string('Team_hold')->nullable();
            $table->string('Price_hold')->nullable();
            $table->string('Statuscar')->nullable();
            $table->string('Status_soldcar')->nullable();
            $table->string('Note_hold')->nullable();
            $table->string('Date_came')->nullable();
            $table->string('Amount_hold')->nullable();
            $table->string('Pay_hold')->nullable();
            $table->string('Datecheck_Capital')->nullable();
            $table->string('Datesend_Stockhome')->nullable();
            $table->string('Datesend_Letter')->nullable();
            $table->string('Barcode_No')->nullable();
            $table->string('Capital_Account')->nullable();
            $table->string('Capital_Topprice')->nullable();
            $table->string('Note2_hold')->nullable();
            $table->string('Letter_hold')->nullable();
            $table->string('Date_send')->nullable();
            $table->string('Barcode2')->nullable();
            $table->string('Accept_hold')->nullable();
            $table->string('Date_accept_hold')->nullable();
            $table->string('Soldout_hold')->nullable();
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
        Schema::dropIfExists('holdcars');
    }
}
