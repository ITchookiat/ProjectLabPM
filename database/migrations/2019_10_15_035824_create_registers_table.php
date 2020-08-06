<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('Date_regis')->nullable();
            $table->string('Regno_regis')->nullable();
            $table->string('TypeofReg_regis')->nullable();
            $table->string('Comp_regis')->nullable();
            $table->string('CustName_regis')->nullable();
            $table->string('CustSurN_regis')->nullable();
            $table->string('NewReg_regis')->nullable();
            $table->string('Desc_regis')->nullable();
            $table->string('CustAmt_regis')->nullable();
            $table->string('RecptAmt_regis')->nullable();
            $table->string('TechAmt_regis')->nullable();
            $table->string('CopyAmt_regis')->nullable();
            $table->string('TransInAmt_regis')->nullable();
            $table->string('TransAmt_regis')->nullable();
            $table->string('NewCarAmt_regis')->nullable();
            $table->string('TaxAmt_regis')->nullable();
            $table->string('RegAmt_regis')->nullable();
            $table->string('DocAmt_regis')->nullable();
            $table->string('FixAmt_regis')->nullable();
            $table->string('CancelAmt_regis')->nullable();
            $table->string('OtherAmt_regis')->nullable();
            $table->string('EMSAmt_regis')->nullable();
            $table->string('BlAmt_regis')->nullable();
            $table->date('CopyDate_regis')->nullable();
            $table->date('CashoutDate_regis')->nullable();
            $table->string('DocChk_regis')->nullable();
            $table->string('KeyChk_regis')->nullable();
            $table->string('RecChk_regis')->nullable();
            $table->date('DocrecDate_regis')->nullable();
            $table->string('Note_regis')->nullable();
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
        Schema::dropIfExists('registers');
    }
}
