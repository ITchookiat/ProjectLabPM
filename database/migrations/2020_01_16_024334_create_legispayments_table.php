<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegispaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legispayments', function (Blueprint $table) {
            $table->bigIncrements('Payment_id');
            $table->integer('legis_Com_Payment_id')->nullable();
            $table->string('Date_Payment')->nullable();
            $table->string('Gold_Payment')->nullable();
            $table->string('Type_Payment')->nullable();
            $table->string('Adduser_Payment')->nullable();
            $table->string('Note_Payment')->nullable();
            $table->string('Flag_Payment')->nullable();
            $table->string('Jobnumber_Payment')->nullable();
            $table->string('Period_Payment')->nullable();
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
        Schema::dropIfExists('legispayments');
    }
}
