<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data_insure extends Model
{
    protected $table = 'data_insures';
    protected $primaryKey = 'Insure_id';
    protected $fillable = ['Number_register','Brand_car','Year_car','Version_car','Engno_car','Type_car',
    'Register_expire','Insure_expire','Act_expire','Check_car','Note_car','Name_user','Date_useradd'];
}
