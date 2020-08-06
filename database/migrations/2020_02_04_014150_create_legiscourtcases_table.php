<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegiscourtcasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legiscourtcases', function (Blueprint $table) {
            $table->bigIncrements('case_id');
            $table->integer('legislation_id')->nullable();
            $table->string('datepreparedoc_case')->nullable();
            $table->string('noteprepare_case')->nullable();
            $table->string('datesetsequester_case')->nullable();
            $table->string('resultsequester_case')->nullable();
            $table->string('notesequester_case')->nullable();
            $table->string('paidsequester_case')->nullable();
            $table->string('datenextsequester_case')->nullable();
            $table->string('resultsell_case')->nullable();
            $table->string('datesoldout_case')->nullable();
            $table->string('amountsequester_case')->nullable();
            $table->string('NumAmount_case')->nullable();
            $table->string('Status_case')->nullable();
            $table->string('DateStatus_case')->nullable();
            $table->string('txtStatus_case')->nullable();
            $table->string('Flag_case')->nullable();

            $table->string('DateNotice_cheat')->nullable();
            $table->string('Dateindictment_cheat')->nullable();
            $table->string('DateExamine_cheat')->nullable();
            $table->string('Datedeposition_cheat')->nullable();
            $table->string('Dateplantiff_cheat')->nullable();
            $table->string('Status_cheat')->nullable();
            $table->string('DateStatus_cheat')->nullable();
            $table->string('note_cheat')->nullable();
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
        Schema::dropIfExists('legiscourtcases');
    }
}
