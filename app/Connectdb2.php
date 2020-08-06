<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Connectdb2 extends Model
{
    //
    protected $connection = "ibmi";

    protected $table = "SFHP.VIEW_CUSTMAIL";
}
