<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Contract_buyer')->nullable();
            $table->string('Flag')->nullable();
            $table->string('Type_Con')->nullable();
            $table->date('Date_Due')->nullable();
            $table->string('Name_buyer')->nullable();
            $table->string('last_buyer')->nullable();
            $table->string('Nick_buyer')->nullable();
            $table->string('Status_buyer')->nullable();
            $table->string('Phone_buyer')->nullable();
            $table->string('Phone2_buyer')->nullable();
            $table->string('Mate_buyer')->nullable();
            $table->string('Idcard_buyer')->nullable();
            $table->string('Address_buyer')->nullable();
            $table->string('AddN_buyer')->nullable();
            $table->string('StatusAdd_buyer')->nullable();
            $table->string('Workplace_buyer')->nullable();
            $table->string('House_buyer')->nullable();
            $table->string('Driver_buyer')->nullable();
            $table->string('HouseStyle_buyer')->nullable();
            $table->string('Career_buyer')->nullable();
            $table->string('CareerDetail_buyer', "MAX")->nullable();
            $table->string('ApproveDetail_buyer', "MAX")->nullable();
            $table->string('Income_buyer')->nullable();
            $table->string('Purchase_buyer')->nullable();
            $table->string('Support_buyer')->nullable();
            $table->string('securities_buyer')->nullable();
            $table->string('deednumber_buyer')->nullable();
            $table->string('area_buyer')->nullable();
            $table->string('BeforeIncome_buyer')->nullable();
            $table->string('AfterIncome_buyer')->nullable();
            $table->string('Gradebuyer_car')->nullable();
            $table->string('Objective_car')->nullable();
            $table->string('Walkin_id')->nullable();
            $table->string('SendUse_Walkin')->nullable();
            $table->string('Memo_buyer', "MAX")->nullable();
            $table->string('Prefer_buyer', "MAX")->nullable();
            $table->string('Memo_broker', "MAX")->nullable();
            $table->string('Prefer_broker', "MAX")->nullable();
            $table->string('MemoIncome_buyer', "MAX")->nullable();
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
        Schema::dropIfExists('buyers');
    }
}
