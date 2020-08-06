<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recordcall extends Model
{
  protected $table = 'recordcalls';
  protected $fillable = ['CONTNO','name','fdate','tel','exp_amt','exp_frm','exp_to','exp_prd','HLDNO','L_HLDNO','pay_status','group','date_record'];
}
