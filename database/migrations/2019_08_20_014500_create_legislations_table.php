<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegislationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legislations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Date_legis')->nullable();
            $table->integer('KeyCourts_id')->nullable();    //  Key ของตาราง ชั้นศาล
            $table->integer('KeyCompro_id')->nullable();    //  Key ของตาราง ประนอมหนี้
            $table->string('Contract_legis')->nullable();
            $table->string('Name_legis')->nullable();
            $table->string('Idcard_legis')->nullable();
            $table->string('Address_legis')->nullable();
            $table->string('BrandCar_legis')->nullable();
            $table->string('register_legis')->nullable();
            $table->string('YearCar_legis')->nullable();
            $table->string('Category_legis')->nullable();
            $table->string('DateDue_legis')->nullable();
            $table->string('Pay_legis')->nullable();
            $table->string('DateSue_legis')->nullable();
            $table->string('DateVAT_legis')->nullable();
            $table->string('NameGT_legis')->nullable();
            $table->string('IdcardGT_legis')->nullable();
            $table->string('AddressGT_legis')->nullable();
            $table->string('Realty_legis')->nullable();
            $table->string('Mile_legis')->nullable();         //เลขไมล์
            $table->string('Period_legis')->nullable();       //ค่างวด
            $table->string('Countperiod_legis')->nullable();  //จำนวนงวดทั้งหมด
            $table->string('Beforeperiod_legis')->nullable(); //ผ่อนมาแล้ว กี่งวด
            $table->string('Beforemoey_legis')->nullable();   //เป็นจำนวนเงิน กี่งวด
            $table->string('Remainperiod_legis')->nullable(); //จำนวนงวดที่ค้าง
            $table->string('Staleperiod_legis')->nullable();  //จำนวนงวดค้าง
            $table->string('Realperiod_legis')->nullable();   //จำนวนงวดที่ค้างจริง
            $table->string('Sumperiod_legis')->nullable();    //เหลือเป็นจำนวนเงิน เท่าไร
            $table->string('Note')->nullable();
            $table->string('Flag')->nullable();
            $table->string('Phone_legis')->nullable();

            $table->string('Status_legis')->nullable();       //สถานะ
            $table->string('UserStatus_legis')->nullable();   //ชื่อคนเลือกสถานะ
            $table->string('DateStatus_legis')->nullable();   //วันที่สถานะ
            $table->string('PriceStatus_legis')->nullable();  //ยอดตั้งต้น
            $table->string('txtStatus_legis')->nullable();    //ยอดชำระ
            $table->string('Discount_legis')->nullable();     //ส่วนลด
            $table->string('DateUpState_legis')->nullable();  //วันที่เลือกสถานะ
            $table->string('DateCarState_legis')->nullable();  //วันที่ยึดรถ

            $table->string('Flag_status')->nullable();
            $table->string('Datesend_Flag')->nullable(); //วันที่ส่งงานให้ทีมทนาย
            $table->string('Noteby_legis')->nullable(); //หมายเหตุจากทีมวิวิเคราะห์
            $table->string('UserSend1_legis')->nullable(); //ชื่อ user ส่งฟ้อง
            $table->string('UserSend2_legis')->nullable(); //ชื่อ user เตรียมฟ้อง

            $table->string('Certificate_list')->nullable();
            $table->string('Authorize_list')->nullable();
            $table->string('Authorizecase_list')->nullable();
            $table->string('Purchase_list')->nullable();
            $table->string('Promise_list')->nullable();
            $table->string('Titledeed_list')->nullable();
            $table->string('Terminatebuyer_list')->nullable();
            $table->string('Terminatesupport_list')->nullable();
            $table->string('Acceptbuyerandsup_list')->nullable();
            $table->string('Twodue_list')->nullable();
            $table->string('AcceptTwodue_list')->nullable();
            $table->string('Confirm_list')->nullable();
            $table->string('Accept_list')->nullable();
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
        Schema::dropIfExists('legislations');
    }
}
