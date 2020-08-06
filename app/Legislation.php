<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legislation extends Model
{
  protected $table = 'legislations';
  protected $fillable = ['KeyCourts_id','Date_legis','KeyCompro_id','Contract_legis','Name_legis','Idcard_legis','Address_legis','BrandCar_legis','register_legis','YearCar_legis',
                        'Category_legis','DateDue_legis','Pay_legis','DateSue_legis','DateVAT_legis',
                        'NameGT_legis','IdcardGT_legis','AddressGT_legis','Realty_legis','Mile_legis','Period_legis','Countperiod_legis',
                        'Beforeperiod_legis','Beforemoey_legis','Remainperiod_legis','Staleperiod_legis','Realperiod_legis','Sumperiod_legis','Note','Flag','Phone_legis',
                        'Status_legis','UserStatus_legis','DateStatus_legis','PriceStatus_legis','txtStatus_legis','Discount_legis','DateUpState_legis','DateCarState_legis',
                        'Flag_status','Datesend_Flag','Noteby_legis','UserSend1_legis','UserSend2_legis','Certificate_list','Authorize_list','Authorizecase_list','Purchase_list','Promise_list','Titledeed_list',
                        'Terminatebuyer_list','Terminatesupport_list','Acceptbuyerandsup_list','Twodue_list','AcceptTwodue_list',
                        'Confirm_list','Accept_list'];

  public function legiscourt()
  {
    return $this->hasMany(Legiscourt::class);
  }

  public function legisImage()
  {
    return $this->hasMany(LegisImage::class);
  }
  public function Legiscompromise()
  {
    return $this->hasMany(Legiscompromise::class);
  }
  public function Legisasset()
  {
    return $this->hasMany(legisasset::class);
  }
}
