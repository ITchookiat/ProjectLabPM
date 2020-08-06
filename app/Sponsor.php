<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
  protected $table = 'sponsors';
  protected $primaryKey = 'Buyer_id';
  protected $fillable = ['Buyer_id','name_SP','lname_SP','nikname_SP','status_SP','tel_SP','relation_SP','mate_SP',
                        'idcard_SP','add_SP','addnow_SP','statusadd_SP','workplace_SP','house_SP','deednumber_SP',
                        'area_SP','housestyle_SP','career_SP','income_SP','puchase_SP','support_SP','securities_SP'];

  public function BuyerSponsor()
  {
    return $this->belongsTo(Buyer::class,'Buyer_id');
  }
}
