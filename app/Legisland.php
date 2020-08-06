<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legisland extends Model
{
  protected $table = 'legislands';
  protected $primaryKey = 'Legisland_id';
  protected $fillable = ['Date_legis','ContractNo_legis','Name_legis','Idcard_legis','DateDue_legis','Pay_legis','DateSue_legis','Realty_legis','Period_legis','Countperiod_legis',
                        'Beforeperiod_legis','Beforemoney_legis','Sumperiod_legis','Staleperiod_legis','Realperiod_legis','Remainperiod_legis','StatusContract_legis','Datenotice_legis','Flag',
                        'Dategetnotice_legis','Datepetition_legis','Dateinvestigate_legis','Dateadjudicate_legis','Dateeviction_legis','Datepost_legis','Datecheckasset_legis','Resultcheck_legis',
                        'Datearrest_legis','Datestaffarrest_legis','Noteland_legis','Statusland_legis','Datestatusland_legis'];
}
