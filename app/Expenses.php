<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
  protected $table = 'expenses';
  protected $primaryKey = 'Buyerexpenses_id';
  protected $fillable = ['Buyerexpenses_id','act_Price','closeAccount_Price','P2_Price','vat_Price','tran_Price','other_Price','evaluetion_Price','totalk_Price','balance_Price',
                        'commit_Price','marketing_Price','duty_Price','insurance_Price','note_Price'];

  public function BuyerExpenses()
  {
    return $this->belongsTo(Buyer::class,'Buyerexpenses_id');
  }
}
