<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'file_id';
    protected $fillable = ['file_title','file_description','file_name','file_size','file_uploader'];
}
