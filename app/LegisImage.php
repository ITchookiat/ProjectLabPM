<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegisImage extends Model
{
  protected $table = 'legisimages';
  protected $primaryKey = 'legisImage_id';
  protected $fillable = ['legisImage_id','name_image','size_image'];

  public function legislationImage()
  {
    return $this->belongsTo(Legislation::class,'legisImage_id');
  }
}
