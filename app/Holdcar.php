<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holdcar extends Model
{
    //
    protected $table = 'holdcars';
    protected $primaryKey = 'Hold_id';
    protected $fillable = ['Contno_hold','Name_hold','Brandcar_hold','Number_Regist','Year_Product','Date_hold','Dateupdate_hold','Team_hold','Price_hold',
                          'Statuscar','Status_soldcar','Note_hold','Date_came','Amount_hold','Pay_hold','Datecheck_Capital','Datesend_Stockhome',
                          'Datesend_Letter','Barcode_No','Capital_Account','Capital_Topprice','Note2_hold','Letter_hold',
                          'Date_send','Barcode2','Accept_hold','Date_Accept_hold','Soldout_hold'];
}
