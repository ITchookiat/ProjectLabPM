<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('expenses_id');
            $table->integer('Buyerexpenses_id')->nullable();
            $table->string('act_Price')->nullable();
            $table->string('closeAccount_Price')->nullable();
            $table->string('P2_Price')->nullable();
            $table->string('vat_Price')->nullable();
            $table->string('tran_Price')->nullable();
            $table->string('other_Price')->nullable();
            $table->string('evaluetion_Price')->nullable();
            $table->string('totalk_Price')->nullable();
            $table->string('balance_Price')->nullable();
            $table->string('commit_Price')->nullable();
            $table->string('marketing_Price')->nullable();
            $table->string('duty_Price')->nullable();
            $table->string('insurance_Price')->nullable();
            $table->string('note_Price')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
