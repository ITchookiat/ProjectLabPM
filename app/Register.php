<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
  protected $table = 'registers';
  protected $fillable = ['Date_regis','Regno_regis','TypeofReg_regis','Comp_regis','CustName_regis','CustSurN_regis',
                        'NewReg_regis','Desc_regis','CustAmt_regis','RecptAmt_regis','TechAmt_regis','CopyAmt_regis',
                        'TransInAmt_regis','TransAmt_regis','NewCarAmt_regis','TaxAmt_regis','RegAmt_regis','DocAmt_regis',
                        'FixAmt_regis','CancelAmt_regis','OtherAmt_regis','EMSAmt_regis','BlAmt_regis','CopyDate_regis',
                        'CashoutDate_regis','DocChk_regis','KeyChk_regis','RecChk_regis','DocrecDate_regis','Note_regis'];
}
