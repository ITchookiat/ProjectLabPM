<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegisassetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legisassets', function (Blueprint $table) {
            $table->bigIncrements('asset_id');
            $table->integer('legisAsset_id')->nullable();
            $table->string('Date_asset')->nullable();
            $table->string('Status_asset')->nullable();
            $table->string('Price_asset')->nullable();
            $table->string('propertied_asset')->nullable();
            $table->string('sequester_asset')->nullable();
            $table->string('sendsequester_asset')->nullable();
            $table->string('Dateresult_asset')->nullable();
            $table->string('NewpursueDate_asset')->nullable();
            $table->string('Notepursue_asset')->nullable();
            $table->string('User_asset')->nullable();
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
        Schema::dropIfExists('legisassets');
    }
}
