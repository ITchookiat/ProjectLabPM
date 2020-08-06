<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegislandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legislands', function (Blueprint $table) {
            $table->bigIncrements('Legisland_id');
            $table->string('Date_legis')->nullable();
            $table->string('ContractNo_legis')->nullable();
            $table->string('Name_legis')->nullable();
            $table->string('Idcard_legis')->nullable();
            $table->string('DateDue_legis')->nullable();
            $table->string('Pay_legis')->nullable();
            $table->string('DateSue_legis')->nullable();
            $table->string('Realty_legis')->nullable();
            $table->string('Period_legis')->nullable();       //ค่างวด
            $table->string('Countperiod_legis')->nullable();  //จำนวนงวดทั้งหมด
            $table->string('Beforeperiod_legis')->nullable(); //ผ่อนมาแล้ว กี่งวด
            $table->string('Beforemoney_legis')->nullable();   //เป็นจำนวนเงิน กี่งวด
            $table->string('Sumperiod_legis')->nullable();    //เหลือเป็นจำนวนเงิน เท่าไร
            $table->string('Remainperiod_legis')->nullable(); //จำนวนงวดที่ค้าง
            $table->string('Staleperiod_legis')->nullable();  //จำนวนงวดค้าง
            $table->string('Realperiod_legis')->nullable();   //จำนวนงวดที่ค้างจริง
            $table->string('StatusContract_legis')->nullable(); //สถานะ
            $table->string('Datenotice_legis')->nullable(); //วันส่งโนติส
            $table->string('Dategetnotice_legis')->nullable(); //วันได้รับโนติส
            $table->string('Datepetition_legis')->nullable(); //วันยื่นคำร้อง
            $table->string('Dateinvestigate_legis')->nullable(); //วันสืบ
            $table->string('Dateadjudicate_legis')->nullable(); //วันพิพากษา
            $table->string('Dateeviction_legis')->nullable(); //วันทำเรื่องขับไล่
            $table->string('Datepost_legis')->nullable(); //วันติดประกาศ
            $table->string('Datecheckasset_legis')->nullable(); //วันตรวจทรัพย์
            $table->string('Resultcheck_legis')->nullable(); //ผลตรวจทรัพย์
            $table->string('Datearrest_legis')->nullable(); //วันนำหมายจับ
            $table->string('Datestaffarrest_legis')->nullable(); //วัน พนง. นำจับ
            $table->string('Noteland_legis')->nullable(); //หมายเหตุ
            $table->string('Statusland_legis')->nullable(); //สถานะจบงาน
            $table->string('Datestatusland_legis')->nullable(); //วันที่จบงาน
            $table->string('Flag')->nullable();
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
        Schema::dropIfExists('legislands');
    }
}
