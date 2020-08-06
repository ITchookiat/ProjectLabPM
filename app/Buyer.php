<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
  protected $table = 'buyers';
  protected $fillable = ['Contract_buyer','Date_Due','Name_buyer','last_buyer','Nick_buyer','Status_buyer','Phone_buyer','Phone2_buyer',
                        'Mate_buyer','Idcard_buyer','Address_buyer','AddN_buyer','StatusAdd_buyer','Workplace_buyer','House_buyer',
                        'Driver_buyer','HouseStyle_buyer','Career_buyer','Income_buyer','Purchase_buyer','Support_buyer',
                        'securities_buyer','deednumber_buyer','area_buyer','BeforeIncome_buyer','AfterIncome_buyer','Gradebuyer_car','Objective_car'];

  public function Sponsor()
  {
    return $this->hasMany(Sponsor::class);
  }
  public function Sponsor2()
  {
    return $this->hasMany(Sponsor2::class);
  }
  public function Cardetail()
  {
    return $this->hasMany(Cardetail::class);
  }
  public function UploadfileImage()
  {
    return $this->hasMany(UploadfileImage::class);
  }
  public function Expenses()
  {
    return $this->hasMany(Expenses::class);
  }
  public function homecardetails()
  {
    return $this->hasMany(Homecardetail::class);
  }
  public function Uploadlat_long()
  {
    return $this->hasMany(upload_lat_long::class);
  }
}
