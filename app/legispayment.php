<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legispayment extends Model
{
  protected $table = 'legispayments';
  protected $primaryKey = 'legis_Com_Payment_id';
  protected $fillable = ['legis_Com_Payment_id','Date_Payment','Gold_Payment','Type_Payment','Adduser_Payment','Note_Payment','Flag_Payment','Jobnumber_Payment','Period_Payment'];

  public function legislationPayment()
  {
    return $this->belongsTo(Legiscompromise::class,'legis_Com_Payment_id');
  }
}
