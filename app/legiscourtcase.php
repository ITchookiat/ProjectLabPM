<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legiscourtcase extends Model
{
  protected $table = 'legiscourtcases';
  protected $primaryKey = 'legislation_id';
  protected $fillable = ['legislation_id','datepreparedoc_case','noteprepare_case','datesetsequester_case','resultsequester_case',
                         'notesequester_case','paidsequester_case','datenextsequester_case','resultsell_case',
                         'datesoldout_case','amountsequester_case','NumAmount_case','Status_case','DateStatus_case','txtStatus_case','Flag_case',
                         'DateNotice_cheat','Dateindictment_cheat','DateExamine_cheat','Datedeposition_cheat','Dateplantiff_cheat',
                         'Status_cheat','DateStatus_cheat','note_cheat'];

  public function legislationCourtcase()
  {
    return $this->belongsTo(Legislation::class,'legislation_id');
  }
}
