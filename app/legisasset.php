<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legisasset extends Model
{
  protected $table = 'legisassets';
  protected $primaryKey = 'legisAsset_id';
  protected $fillable = ['legisAsset_id','Date_asset','Status_asset','Price_asset','propertied_asset','sequester_asset',
                         'sendsequester_asset','Dateresult_asset','NewpursueDate_asset','Notepursue_asset','User_asset'];

  public function legislationAsset()
  {
    return $this->belongsTo(Legislation::class,'legisAsset_id');
  }
}
