<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legiscourt extends Model
{
  protected $table = 'legiscourts';
  protected $primaryKey = 'legislation_id';
  protected $fillable = ['legislation_id','fillingdate_court','law_court','bnumber_court','rnumber_court','capital_court','indictment_court','pricelawyer_court','examiday_court',
                        'fuzzy_court','examinote_court','orderday_court','ordersend_court','checkday_court','checksend_court','buyer_court','support_court','note_court',
                        'social_flag','setoffice_court','sendoffice_court','checkresults_court','sendcheckresults_court','received_court','telresults_court','dayresults_court',
                        'propertied_court','sequester_court','sendsequester_court','NewpursueDate_court','Notepursue_court','Status_court','DateStatus_court','txtStatus_court',
                        'DateComplete_court','User_court',
                        'latitude_court','longitude_court'];

  public function legislationCourt()
  {
    return $this->belongsTo(Legislation::class,'legislation_id');
  }
}
