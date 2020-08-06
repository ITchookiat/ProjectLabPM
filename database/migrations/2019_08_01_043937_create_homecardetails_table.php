<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomecardetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homecardetails', function (Blueprint $table) {
            $table->bigIncrements('homecardetail_id');
            $table->integer('Buyerhomecar_id')->nullable();
            $table->string('brand_HC')->nullable();
            $table->string('year_HC')->nullable();
            $table->string('colour_HC')->nullable();
            $table->string('oldplate_HC')->nullable();
            $table->string('newplate_HC')->nullable();
            $table->string('mile_HC')->nullable();
            $table->string('model_HC')->nullable();
            $table->string('type_HC')->nullable();
            $table->string('price_HC')->nullable();
            $table->string('downpay_HC')->nullable();
            $table->string('insurancefee_HC')->nullable();
            $table->string('transfer_HC')->nullable();
            $table->string('topprice_HC')->nullable();
            $table->string('interest_HC')->nullable();
            $table->string('vat_HC')->nullable();
            $table->string('period_HC')->nullable();
            $table->string('paypor_HC')->nullable();
            $table->string('payment_HC')->nullable();
            $table->string('payperriod_HC')->nullable();
            $table->string('tax_HC')->nullable();
            $table->string('taxperriod_HC')->nullable();
            $table->string('totalinstalments_HC')->nullable();
            $table->string('baab_HC')->nullable();
            $table->string('guarantee_HC')->nullable();
            $table->string('firstpay_HC')->nullable();
            $table->string('insurance_HC')->nullable();
            $table->string('agent_HC')->nullable();
            $table->string('tel_HC')->nullable();
            $table->string('commit_HC')->nullable();
            $table->string('purchhis_HC')->nullable();
            $table->string('supporthis_HC')->nullable();
            $table->string('other_HC')->nullable();
            $table->string('sale_HC')->nullable();
            $table->string('approvers_HC')->nullable();
            $table->string('contrac_HC')->nullable();
            $table->string('totalinstalments1_HC')->nullable();
            $table->string('insurancekey_HC')->nullable();
            $table->string('dateapp_HC')->nullable();
            $table->string('statusapp_HC')->nullable();
            $table->string('branchUS_HC')->nullable();
            $table->string('note_HC')->nullable();

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
        Schema::dropIfExists('homecardetails');
    }
}
