<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filefolder extends Model
{
    protected $table = 'filefolders';
    protected $primaryKey = 'folder_id';
    protected $fillable = ['folder_name','folder_creator'];
}
