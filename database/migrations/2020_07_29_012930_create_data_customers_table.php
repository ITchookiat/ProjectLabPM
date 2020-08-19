<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_customers', function (Blueprint $table) {
            $table->bigIncrements('Customer_id');
            $table->string('License_car')->nullable();
            $table->string('Brand_car')->nullable();
            $table->string('Model_car')->nullable();
            $table->string('Typecardetails')->nullable();
            $table->string('Top_car')->nullable();
            $table->string('Year_car')->nullable();
            $table->string('Name_buyer')->nullable();
            $table->string('Last_buyer')->nullable();
            $table->string('Phone_buyer')->nullable();
            $table->string('IDCard_buyer')->nullable();
            $table->string('Name_agent')->nullable();
            $table->string('Phone_agent')->nullable();
            $table->string('Resource_news')->nullable();
            $table->string('Note_car')->nullable();
            $table->string('Name_user')->nullable();
            $table->string('Branch_car')->nullable();
            $table->string('Type_leasing')->nullable();
            $table->string('Status_leasing')->nullable();
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
        Schema::dropIfExists('data_customers');
    }
}
