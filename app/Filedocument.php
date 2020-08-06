<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filedocument extends Model
{
    //filedocuments
    protected $table = 'filedocuments';
    protected $primaryKey = 'file_id';
    protected $fillable = ['folder_id','file_title','file_description','file_name','file_size','file_uploader'];
}
