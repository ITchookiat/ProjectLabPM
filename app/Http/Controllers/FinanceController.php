<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recordcall;
use DB;
use PDF;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, $type)
     {

       // dump($request, $type);
       $month = date('m');
       $year = date('Y');
       $fmonth = $month;
       $fyear = $year;
       if ($request->has('Frommonth')) {
         $fmonth = $request->get('Frommonth');
       }
       if ($request->has('Fromyear')) {
         $fyear = $request->get('Fromyear');
       }
       $SetMonth = $fyear."-".$fmonth;
       $star = $SetMonth."-"."01";
       if($SetMonth == "$fyear-02"){
        $end = $SetMonth."-"."28";
       }elseif($SetMonth == "$fyear-04"){
       $end = $SetMonth."-"."30";
       }elseif($SetMonth == "$fyear-06"){
         $end = $SetMonth."-"."30";
       }elseif($SetMonth == "$fyear-09"){
         $end = $SetMonth."-"."30";
       }elseif($SetMonth == "$fyear-11"){
       $end = $SetMonth."-"."30";
       }else{
       $end = $SetMonth."-"."31";
       }

        ///// เริ่มส่วนของปัตตานี //////////
       $pt_stat = DB::connection('ibmi')
             ->table('SFHP.ARMAST')
             ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
             ->where('SFHP.ARMAST.CONTNO', 'like', '01-%')
             ->whereBetween('SFHP.ARMAST.ISSUDT',[$star,$end])
             ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
             ->get();
       $sum_pt_stat = count($pt_stat);

       for($i=0; $i<$sum_pt_stat; $i++){
         $pt[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$pt_stat[$i]->BAAB)));
       }

       $count_pt = count($pt);
       $count_pt1 = 0;
       $count_pt2 = 0;
       $count_pt3 = 0;
       $count_pt4 = 0;
       $count_pt5 = 0;
       $count_pt6 = 0;
       $count_pt7 = 0;


       for($j=0; $j<$count_pt; $j++){
           if ($pt[$j] == "กสค้ำมีหลักทรัพย์") {
             $count_pt1 = $count_pt1 + 1;
           }elseif ($pt[$j] == "กสค้ำไม่มีหลักทรัพย") {
             $count_pt2 = $count_pt2 + 1;
           }elseif ($pt[$j] == "กสไม่ค้ำประกัน") {
             $count_pt3 = $count_pt3 + 1;
           }elseif ($pt[$j] == "ซขค้ำมีหลักทรัพย์") {
             $count_pt4 = $count_pt4 + 1;
           }elseif ($pt[$j] == "ซขค้ำไม่มีหลักทรัพย") {
             $count_pt5 = $count_pt5 + 1;
           }elseif ($pt[$j] == "ซขไม่ค้ำประกัน") {
             $count_pt6 = $count_pt6 + 1;
           }elseif ($pt[$j] == "ลูกค้าVIP1") {
             $count_pt7 = $count_pt7 + 1;
           }
       }

       $sum_count_pt = $count_pt1 + $count_pt2 + $count_pt3 + $count_pt4 + $count_pt5 + $count_pt6 + $count_pt7;
       ///// สิ้นสุดส่วนของปัตตานี //////////

       ///// เริ่มส่วนของยะลา//////////
      $yl_stat = DB::connection('ibmi')
            ->table('SFHP.ARMAST')
            ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
            ->where('SFHP.ARMAST.CONTNO', 'like', '03-%')
            ->whereBetween('SFHP.ARMAST.ISSUDT',[$star,$end])
            ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
            ->get();
      $sum_yl_stat = count($yl_stat);

      for($i=0; $i<$sum_yl_stat; $i++){
        $yl[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$yl_stat[$i]->BAAB)));
      }

      $count_yl = count($yl);
      $count_yl1 = 0;
      $count_yl2 = 0;
      $count_yl3 = 0;
      $count_yl4 = 0;
      $count_yl5 = 0;
      $count_yl6 = 0;
      $count_yl7 = 0;


      for($j=0; $j<$count_yl; $j++){
          if ($yl[$j] == "กสค้ำมีหลักทรัพย์") {
            $count_yl1 = $count_yl1 + 1;
          }elseif ($yl[$j] == "กสค้ำไม่มีหลักทรัพย") {
            $count_yl2 = $count_yl2 + 1;
          }elseif ($yl[$j] == "กสไม่ค้ำประกัน") {
            $count_yl3 = $count_yl3 + 1;
          }elseif ($yl[$j] == "ซขค้ำมีหลักทรัพย์") {
            $count_yl4 = $count_yl4 + 1;
          }elseif ($yl[$j] == "ซขค้ำไม่มีหลักทรัพย") {
            $count_yl5 = $count_yl5 + 1;
          }elseif ($yl[$j] == "ซขไม่ค้ำประกัน") {
            $count_yl6 = $count_yl6 + 1;
          }elseif ($yl[$j] == "ลูกค้าVIP1") {
            $count_yl7 = $count_yl7 + 1;
          }
      }

      $sum_count_yl = $count_yl1 + $count_yl2 + $count_yl3 + $count_yl4 + $count_yl5 + $count_yl6 + $count_yl7;
      ///// สิ้นสุดส่วนของยะลา //////////

      ///// เริ่มส่วนของนรา//////////
     $nr_stat = DB::connection('ibmi')
           ->table('SFHP.ARMAST')
           ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
           ->where('SFHP.ARMAST.CONTNO', 'like', '04-%')
           ->whereBetween('SFHP.ARMAST.ISSUDT',[$star,$end])
           ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
           ->get();
     $sum_nr_stat = count($nr_stat);

     for($i=0; $i<$sum_nr_stat; $i++){
       $nr[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$nr_stat[$i]->BAAB)));
     }

     $count_nr = count($nr);
     $count_nr1 = 0;
     $count_nr2 = 0;
     $count_nr3 = 0;
     $count_nr4 = 0;
     $count_nr5 = 0;
     $count_nr6 = 0;
     $count_nr7 = 0;


     for($j=0; $j<$count_nr; $j++){
         if ($nr[$j] == "กสค้ำมีหลักทรัพย์") {
           $count_nr1 = $count_nr1 + 1;
         }elseif ($nr[$j] == "กสค้ำไม่มีหลักทรัพย") {
           $count_nr2 = $count_nr2 + 1;
         }elseif ($nr[$j] == "กสไม่ค้ำประกัน") {
           $count_nr3 = $count_nr3 + 1;
         }elseif ($nr[$j] == "ซขค้ำมีหลักทรัพย์") {
           $count_nr4 = $count_nr4 + 1;
         }elseif ($nr[$j] == "ซขค้ำไม่มีหลักทรัพย") {
           $count_nr5 = $count_nr5 + 1;
         }elseif ($nr[$j] == "ซขไม่ค้ำประกัน") {
           $count_nr6 = $count_nr6 + 1;
         }elseif ($nr[$j] == "ลูกค้าVIP1") {
           $count_nr7 = $count_nr7 + 1;
         }
     }

     $sum_count_nr = $count_nr1 + $count_nr2 + $count_nr3 + $count_nr4 + $count_nr5 + $count_nr6 + $count_nr7;
     ///// สิ้นสุดส่วนของนรา //////////

     ///// เริ่มส่วนของสายบุรี//////////
    $sb_stat = DB::connection('ibmi')
          ->table('SFHP.ARMAST')
          ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
          ->where('SFHP.ARMAST.CONTNO', 'like', '05-%')
          ->whereBetween('SFHP.ARMAST.ISSUDT',[$star,$end])
          ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
          ->get();
    $sum_sb_stat = count($sb_stat);

    for($i=0; $i<$sum_sb_stat; $i++){
      $sb[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$sb_stat[$i]->BAAB)));
    }

    $count_sb = count($sb);
    $count_sb1 = 0;
    $count_sb2 = 0;
    $count_sb3 = 0;
    $count_sb4 = 0;
    $count_sb5 = 0;
    $count_sb6 = 0;
    $count_sb7 = 0;


    for($j=0; $j<$count_sb; $j++){
        if ($sb[$j] == "กสค้ำมีหลักทรัพย์") {
          $count_sb1 = $count_sb1 + 1;
        }elseif ($sb[$j] == "กสค้ำไม่มีหลักทรัพย") {
          $count_sb2 = $count_sb2 + 1;
        }elseif ($sb[$j] == "กสไม่ค้ำประกัน") {
          $count_sb3 = $count_sb3 + 1;
        }elseif ($sb[$j] == "ซขค้ำมีหลักทรัพย์") {
          $count_sb4 = $count_sb4 + 1;
        }elseif ($sb[$j] == "ซขค้ำไม่มีหลักทรัพย") {
          $count_sb5 = $count_sb5 + 1;
        }elseif ($sb[$j] == "ซขไม่ค้ำประกัน") {
          $count_sb6 = $count_sb6 + 1;
        }elseif ($sb[$j] == "ลูกค้าVIP1") {
          $count_sb7 = $count_sb7 + 1;
        }
    }

    $sum_count_sb = $count_sb1 + $count_sb2 + $count_sb3 + $count_sb4 + $count_sb5 + $count_sb6 + $count_sb7;
    ///// สิ้นสุดส่วนของสายบุรี //////////

    ///// เริ่มส่วนของโก-ลก//////////
   $kl_stat = DB::connection('ibmi')
         ->table('SFHP.ARMAST')
         ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
         ->where('SFHP.ARMAST.CONTNO', 'like', '06-%')
         ->whereBetween('SFHP.ARMAST.ISSUDT',[$star,$end])
         ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
         ->get();
   $sum_kl_stat = count($kl_stat);

   for($i=0; $i<$sum_kl_stat; $i++){
     $kl[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$kl_stat[$i]->BAAB)));
   }

   $count_kl = count($kl);
   $count_kl1 = 0;
   $count_kl2 = 0;
   $count_kl3 = 0;
   $count_kl4 = 0;
   $count_kl5 = 0;
   $count_kl6 = 0;
   $count_kl7 = 0;


   for($j=0; $j<$count_kl; $j++){
       if ($kl[$j] == "กสค้ำมีหลักทรัพย์") {
         $count_kl1 = $count_kl1 + 1;
       }elseif ($kl[$j] == "กสค้ำไม่มีหลักทรัพย") {
         $count_kl2 = $count_kl2 + 1;
       }elseif ($kl[$j] == "กสไม่ค้ำประกัน") {
         $count_kl3 = $count_kl3 + 1;
       }elseif ($kl[$j] == "ซขค้ำมีหลักทรัพย์") {
         $count_kl4 = $count_kl4 + 1;
       }elseif ($kl[$j] == "ซขค้ำไม่มีหลักทรัพย") {
         $count_kl5 = $count_kl5 + 1;
       }elseif ($kl[$j] == "ซขไม่ค้ำประกัน") {
         $count_kl6 = $count_kl6 + 1;
       }elseif ($kl[$j] == "ลูกค้าVIP1") {
         $count_kl7 = $count_kl7 + 1;
       }
   }

   $sum_count_kl = $count_kl1 + $count_kl2 + $count_kl3 + $count_kl4 + $count_kl5 + $count_kl6 + $count_kl7;
   ///// สิ้นสุดส่วนของโก-ลก //////////

   ///// เริ่มส่วนของเบตง//////////
  $bt_stat = DB::connection('ibmi')
        ->table('SFHP.ARMAST')
        ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
        ->where('SFHP.ARMAST.CONTNO', 'like', '07-%')
        ->whereBetween('SFHP.ARMAST.ISSUDT',[$star,$end])
        ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
        ->get();
  $sum_bt_stat = count($bt_stat);

  for($i=0; $i<$sum_bt_stat; $i++){
    $bt[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$bt_stat[$i]->BAAB)));
  }

  $count_bt = count($bt);
  $count_bt1 = 0;
  $count_bt2 = 0;
  $count_bt3 = 0;
  $count_bt4 = 0;
  $count_bt5 = 0;
  $count_bt6 = 0;
  $count_bt7 = 0;


  for($j=0; $j<$count_bt; $j++){
      if ($bt[$j] == "กสค้ำมีหลักทรัพย์") {
        $count_bt1 = $count_bt1 + 1;
      }elseif ($bt[$j] == "กสค้ำไม่มีหลักทรัพย") {
        $count_bt2 = $count_bt2 + 1;
      }elseif ($bt[$j] == "กสไม่ค้ำประกัน") {
        $count_bt3 = $count_bt3 + 1;
      }elseif ($bt[$j] == "ซขค้ำมีหลักทรัพย์") {
        $count_bt4 = $count_bt4 + 1;
      }elseif ($bt[$j] == "ซขค้ำไม่มีหลักทรัพย") {
        $count_bt5 = $count_bt5 + 1;
      }elseif ($bt[$j] == "ซขไม่ค้ำประกัน") {
        $count_bt6 = $count_bt6 + 1;
      }elseif ($bt[$j] == "ลูกค้าVIP1") {
        $count_bt7 = $count_bt7 + 1;
      }
  }

  $sum_count_bt = $count_bt1 + $count_bt2 + $count_bt3 + $count_bt4 + $count_bt5 + $count_bt6 + $count_bt7;
  ///// สิ้นสุดส่วนของเบตง //////////

        if($request->type == 1) {
          // dd($type);
         return view('finance.home', compact('type','fmonth','fyear',
         'count_pt1','count_pt2','count_pt3','count_pt4','count_pt5','count_pt6','count_pt7','sum_count_pt',
         'count_yl1','count_yl2','count_yl3','count_yl4','count_yl5','count_yl6','count_yl7','sum_count_yl',
         'count_nr1','count_nr2','count_nr3','count_nr4','count_nr5','count_nr6','count_nr7','sum_count_nr',
         'count_sb1','count_sb2','count_sb3','count_sb4','count_sb5','count_sb6','count_sb7','sum_count_sb',
         'count_kl1','count_kl2','count_kl3','count_kl4','count_kl5','count_kl6','count_kl7','sum_count_kl',
         'count_bt1','count_bt2','count_bt3','count_bt4','count_bt5','count_bt6','count_bt7','sum_count_bt'));
        }
         if($request->type == 2){
           // dd($type);
           $ReportType = $request->type;

           $view = \View::make('finance.reportFinance', compact('ReportType','fmonth','fyear',
           'count_pt1','count_pt2','count_pt3','count_pt4','count_pt5','count_pt6','count_pt7','sum_count_pt',
           'count_yl1','count_yl2','count_yl3','count_yl4','count_yl5','count_yl6','count_yl7','sum_count_yl',
           'count_nr1','count_nr2','count_nr3','count_nr4','count_nr5','count_nr6','count_nr7','sum_count_nr',
           'count_sb1','count_sb2','count_sb3','count_sb4','count_sb5','count_sb6','count_sb7','sum_count_sb',
           'count_kl1','count_kl2','count_kl3','count_kl4','count_kl5','count_kl6','count_kl7','sum_count_kl',
           'count_bt1','count_bt2','count_bt3','count_bt4','count_bt5','count_bt6','count_bt7','sum_count_bt'));
           $html = $view->render();

           $pdf = new PDF();

           $pdf::SetTitle('รายงานประเภทจัดไฟแนนซ์ประจำเดือน');
           $pdf::AddPage('P', 'A4');


           // $pdf::AddPage('P', 'A4');
                   // set margins
           $pdf::SetMargins(5, 5, 6);

           $pdf::SetFont('freeserif', 24);

           $pdf::WriteHTML($html,true,false,true,false,'');
           $pdf::Output('financereport.pdf');
         }

     }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
