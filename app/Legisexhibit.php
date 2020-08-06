<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legisexhibit extends Model
{
  protected $table = 'Legisexhibits';
  protected $primaryKey = 'Legisexhibit_id';
  protected $fillable = ['Contract_legis','Dateaccept_legis','Name_legis','Policestation_legis','Suspect_legis','Plaint_legis',
                        'Inquiryofficial_legis','Inquiryofficialtel_legis','Terminate_legis','DateLawyersend_legis','Typeexhibit_legis','Currentstatus_legis','Nextstatus_legis',
                        'Noteexhibit_legis','Dategiveword_legis','Typegiveword_legis','Datecheckexhibit_legis','Datepreparedoc_legis','Datesendword_legis',
                        'Dateinvestigate_legis','Resultexhibit1_legis','Processexhibit1_legis','Datesenddetail_legis','Resultexhibit2_legis','Processexhibit2_legis','Dategetresult_legis'];
}
