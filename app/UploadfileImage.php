<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadfileImage extends Model
{
  protected $table = 'uploadfile_images';
  protected $primaryKey = 'Buyerfileimage_id';
  protected $fillable = ['Buyerfileimage_id','Type_fileimage','Name_fileimage','Size_fileimage'];

  public function Buyeruploadfileimages()
  {
    return $this->belongsTo(Buyer::class,'Buyerfileimage_id');
  }
}
