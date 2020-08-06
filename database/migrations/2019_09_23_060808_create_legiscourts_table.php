<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegiscourtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legiscourts', function (Blueprint $table) {
            $table->bigIncrements('court_id');
            $table->integer('legislation_id')->nullable();
            $table->string('fillingdate_court')->nullable();
            $table->string('law_court')->nullable();
            $table->string('bnumber_court')->nullable();
            $table->string('rnumber_court')->nullable();
            $table->string('capital_court')->nullable();
            $table->string('indictment_court')->nullable();
            $table->string('pricelawyer_court')->nullable();
            $table->string('examiday_court')->nullable();
            $table->string('fuzzy_court')->nullable();
            $table->string('examinote_court')->nullable();
            $table->string('orderday_court')->nullable();
            $table->string('ordersend_court')->nullable();
            $table->string('checkday_court')->nullable();
            $table->string('checksend_court')->nullable();
            $table->string('buyer_court')->nullable();
            $table->string('support_court')->nullable();
            $table->string('note_court')->nullable();
            $table->string('social_flag')->nullable();
            $table->string('setoffice_court')->nullable();
            $table->string('sendoffice_court')->nullable();
            $table->string('checkresults_court')->nullable();
            $table->string('sendcheckresults_court')->nullable();
            $table->string('received_court')->nullable();
            $table->string('telresults_court')->nullable();
            $table->string('dayresults_court')->nullable();
            $table->string('Status_court')->nullable();
            $table->string('DateStatus_court')->nullable();
            $table->string('txtStatus_court')->nullable();
            $table->string('DateComplete_court')->nullable(); //วันที่กดอัพเดต
            $table->string('User_court')->nullable(); //ชื่อ user ลงระบบ

            $table->string('latitude_court')->nullable();   //ค่า ละติจุต แผนที
            $table->string('longitude_court')->nullable();  //ค่า ลองติจุต แผนที
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
        Schema::dropIfExists('legiscourts');
    }
}
