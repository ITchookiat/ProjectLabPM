<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->bigIncrements('Sponsor_id');
            $table->integer('Buyer_id')->nullable();
            $table->string('name_SP')->nullable();
            $table->string('lname_SP')->nullable();
            $table->string('nikname_SP')->nullable();
            $table->string('status_SP')->nullable();
            $table->string('tel_SP')->nullable();
            $table->string('relation_SP')->nullable();
            $table->string('mate_SP')->nullable();
            $table->string('idcard_SP')->nullable();
            $table->string('add_SP')->nullable();
            $table->string('addnow_SP')->nullable();
            $table->string('statusadd_SP')->nullable();
            $table->string('workplace_SP')->nullable();
            $table->string('house_SP')->nullable();
            $table->string('deednumber_SP')->nullable();
            $table->string('area_SP')->nullable();
            $table->string('housestyle_SP')->nullable();
            $table->string('career_SP')->nullable();
            $table->string('income_SP')->nullable();
            $table->string('puchase_SP')->nullable();
            $table->string('support_SP')->nullable();
            $table->string('securities_SP')->nullable();
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
        Schema::dropIfExists('sponsors');
    }
}
