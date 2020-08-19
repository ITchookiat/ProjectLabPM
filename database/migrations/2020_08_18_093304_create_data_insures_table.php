<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataInsuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_insures', function (Blueprint $table) {
            $table->bigIncrements('insure_id');
            $table->string('Number_register')->nullable();
            $table->string('Brand_car')->nullable();
            $table->string('Year_car')->nullable();
            $table->string('Version_car')->nullable();
            $table->string('Engno_car')->nullable();
            $table->string('Type_car')->nullable();
            $table->string('Register_expire')->nullable();
            $table->string('Insure_expire')->nullable();
            $table->string('Act_expire')->nullable();
            $table->string('Check_car')->nullable();
            $table->string('Note_car')->nullable();
            $table->string('Name_user')->nullable();
            $table->string('Date_useradd')->nullable();
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
        Schema::dropIfExists('data_insures');
    }
}
