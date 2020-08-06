<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    public static function formatDateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        // $strMonthCut = Array("","01","02","03","04","05","06","07","08","09","10","11","12");
        $strMonthThai=$strMonthCut[$strMonth];

        return $strDay." ".$strMonthThai." ".$strYear;
    }
}
