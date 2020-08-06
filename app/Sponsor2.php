<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor2 extends Model
{
  protected $table = 'sponsor2s';
  protected $primaryKey = 'Buyer_id2';
  protected $fillable = ['Buyer_id2','name_SP2','lname_SP2','nikname_SP2','status_SP2','tel_SP2','relation_SP2','mate_SP2',
                        'idcard_SP2','add_SP2','addnow_SP2','statusadd_SP2','workplace_SP2','house_SP2','deednumber_SP2',
                        'area_SP2','housestyle_SP2','career_SP2','income_SP2','puchase_SP2','support_SP2','securities_SP2'];

  public function BuyerSponsor2()
  {
    return $this->belongsTo(Buyer::class,'Buyer_id2');
  }
}
