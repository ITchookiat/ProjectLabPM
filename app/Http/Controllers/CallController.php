<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recordcall;
use DB;
use PDF;

class CallController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index(Request $request)
   {
     date_default_timezone_set('Asia/Bangkok');
     $today = date('Y-m-d');
     $date = date('Y-m-d', strtotime('-1 days'));
     $fdate = $date;
     $tdate = $date;
     if ($request->has('Fromdate')) {
       $fdate = $request->get('Fromdate');
     }
     if ($request->has('Todate')) {
       $tdate = $request->get('Todate');
     }

       // $check = Recordcall::where('date_record', '=', $date)->count();

       // $data_today = DB::table('recordcalls')
       // ->select('CONTNO')
       // ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //        return $q->whereBetween('date_record',[$fdate,$tdate]);
       //        })
       // ->orderBy('CONTNO', 'ASC')
       // ->get();
       // $sum_data_today = count($data_today);

       // $all = DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->select('SFHP.ARMAST.CONTNO')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $allsum = count($all);

       // $allbranch = DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $sumall = count($allbranch);

       // $ptbranch= DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->where('SFHP.ARMAST.CONTNO', 'like', '01-%')
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $sumpt = count($ptbranch);

       // $ylbranch= DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->where('SFHP.ARMAST.CONTNO', 'like', '03-%')
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $sumyl = count($ylbranch);

       // $nrbranch= DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->where('SFHP.ARMAST.CONTNO', 'like', '04-%')
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $sumnr = count($nrbranch);

       // $sbbranch= DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->where('SFHP.ARMAST.CONTNO', 'like', '05-%')
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $sumsb = count($sbbranch);

       // $klbranch= DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->where('SFHP.ARMAST.CONTNO', 'like', '06-%')
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $sumkl = count($klbranch);

       // $btbranch= DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->where('SFHP.ARMAST.CONTNO', 'like', '07-%')
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $sumbt = count($btbranch);

       // $branch02= DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->where('SFHP.ARMAST.CONTNO', 'like', '02-%')
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $sum02 = count($branch02);

       // $branch10= DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->where('SFHP.ARMAST.CONTNO', 'like', '10-%')
       //       ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
       //       ->get();
       // $sum10 = count($branch10);

       // $branch0210= DB::connection('ibmi')
       //       ->table('SFHP.ARMAST')
       //       ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
       //       ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
       //       ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
       //       ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
       //              })
       //       ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
       //       ->where('SFHP.ARMAST.CONTNO', 'not like', '01-%')
       //       ->where('SFHP.ARMAST.CONTNO', 'not like', '03-%')
       //       ->where('SFHP.ARMAST.CONTNO', 'not like', '04-%')
       //       ->where('SFHP.ARMAST.CONTNO', 'not like', '05-%')
       //       ->where('SFHP.ARMAST.CONTNO', 'not like', '06-%')
       //       ->where('SFHP.ARMAST.CONTNO', 'not like', '07-%')
       //       ->get();

       // $data_0210 = DB::table('recordcalls')
       //             ->where('CONTNO', 'not like', '01-%')
       //             ->where('CONTNO', 'not like', '03-%')
       //             ->where('CONTNO', 'not like', '04-%')
       //             ->where('CONTNO', 'not like', '05-%')
       //             ->where('CONTNO', 'not like', '06-%')
       //             ->where('CONTNO', 'not like', '07-%')
       //             ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //                    return $q->whereBetween('date_record',[$fdate,$tdate]);
       //                    })
       //             ->get();

       // $flag1 = true;              $count1 = [];
       // $flag2 = false;             $count2 = [];
       // $flag3 = false;             $count3 = [];
       // $flag4 = false;             $count4 = [];
       // $flag5 = false;             $count5 = [];
       // $flag6 = false;             $count6 = [];
       // $flag7 = false;             $count7 = [];
       // $flag8 = false;             $count8 = [];
       // $flag9 = false;             $count9 = [];
       // $flag10 = false;            $count10 = [];
       // $flag11 = false;            $count11 = [];
       // $flag12 = false;            $count12 = [];
       // $flag13 = false;            $count13 = [];
       // $flag14 = false;            $count14 = [];
       // $flag15 = false;            $count15 = [];
       // $flag16 = false;            $count16 = [];

       // foreach ($data_0210 as $key => $value) {
       // if($flag1 == true){
       // $count1[] = $data_0210[$key];
       // $flag1 = false;
       // $flag2 = true;
       // } elseif($flag2 == true){
       // $count2[] = $data_0210[$key];
       // $flag2 = false;
       // $flag3 = true;
       // } elseif($flag3 == true){
       // $count3[] = $data_0210[$key];
       // $flag3 = false;
       // $flag4 = true;
       // }elseif($flag4 == true){
       // $count4[] = $data_0210[$key];
       // $flag4 = false;
       // $flag5 = true;
       // }elseif($flag5 == true){
       // $count5[] = $data_0210[$key];
       // $flag5 = false;
       // $flag6 = true;
       // }elseif($flag6 == true){
       // $count6[] = $data_0210[$key];
       // $flag6 = false;
       // $flag7 = true;
       // }elseif($flag7 == true){
       // $count7[] = $data_0210[$key];
       // $flag7 = false;
       // $flag8 = true;
       // }elseif($flag8 == true){
       // $count8[] = $data_0210[$key];
       // $flag8 = false;
       // $flag9 = true;
       // }elseif($flag9 == true){
       // $count9[] = $data_0210[$key];
       // $flag9 = false;
       // $flag10 = true;
       // }elseif($flag10 == true){
       // $count10[] = $data_0210[$key];
       // $flag10 = false;
       // $flag11 = true;
       // }elseif($flag11 == true){
       // $count11[] = $data_0210[$key];
       // $flag11 = false;
       // $flag12 = true;
       // }elseif($flag12 == true){
       // $count12[] = $data_0210[$key];
       // $flag12 = false;
       // $flag13 = true;
       // }elseif($flag13 == true){
       // $count13[] = $data_0210[$key];
       // $flag13 = false;
       // $flag14 = true;
       // }elseif($flag14 == true){
       // $count14[] = $data_0210[$key];
       // $flag14 = false;
       // $flag15 = true;
       // }elseif($flag15 == true){
       // $count15[] = $data_0210[$key];
       // $flag15 = false;
       // $flag16 = true;
       // }elseif($flag16 == true){
       // $count16[] = $data_0210[$key];
       // $flag16 = false;
       // $flag1 = true;
       // }
       // }

       // $pattani = collect([$count1,$count10])->collapse();
       // $yala = collect([$count2,$count5])->collapse();
       // $nara = collect([$count11,$count16,$count8])->collapse();
       // $saiburi  = collect([$count4,$count13,$count7])->collapse();
       // $kolok = collect([$count3,$count9,$count15])->collapse();
       // $betong = collect([$count12,$count14,$count6])->collapse();

       //   $data_all = DB::table('recordcalls')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();
       //   $sum_data_all = count($data_all);

       //   $data_pt_ori = DB::table('recordcalls')
       //   ->where('CONTNO', 'like', '01-%')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();

       //   $data_pt = DB::table('recordcalls')
       //   ->where('group', 'like', '01')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();
       //   $sum_data_pt = count($data_pt);

       //   $data_yl_ori = DB::table('recordcalls')
       //   ->where('CONTNO', 'like', '03-%')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();

       //   $data_yl = DB::table('recordcalls')
       //   ->where('group', 'like', '03')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();
       //   $sum_data_yl = count($data_yl);

       //   $data_nr_ori = DB::table('recordcalls')
       //   ->where('CONTNO', 'like', '04-%')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();

       //   $data_nr = DB::table('recordcalls')
       //   ->where('group', 'like', '04')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();
       //   $sum_data_nr = count($data_nr);

       //   $data_sb_ori = DB::table('recordcalls')
       //   ->where('CONTNO', 'like', '05-%')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();

       //   $data_sb = DB::table('recordcalls')
       //   ->where('group', 'like', '05')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();
       //   $sum_data_sb = count($data_sb);

       //   $data_kl_ori = DB::table('recordcalls')
       //   ->where('CONTNO', 'like', '06-%')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();

       //   $data_kl = DB::table('recordcalls')
       //   ->where('group', 'like', '06')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();
       //   $sum_data_kl = count($data_kl);

       //   $data_bt_ori = DB::table('recordcalls')
       //   ->where('CONTNO', 'like', '07-%')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();

       //   $data_bt = DB::table('recordcalls')
       //   ->where('group', 'like', '07')
       //   ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //          return $q->whereBetween('date_record',[$fdate,$tdate]);
       //          })
       //   ->orderBy('CONTNO', 'ASC')
       //   ->get();
       //   $sum_data_bt = count($data_bt);

       //         if ($request->type == 1)
       //         {
       //           $group01 = DB::table('recordcalls')
       //           ->where('group', 'like', '01')
       //           ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //                  return $q->whereBetween('date_record',[$fdate,$tdate]);
       //                  })
       //           ->count();

       //           $group03 = DB::table('recordcalls')
       //           ->where('group', 'like', '03')
       //           ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //                  return $q->whereBetween('date_record',[$fdate,$tdate]);
       //                  })
       //           ->count();

       //           $group04 = DB::table('recordcalls')
       //           ->where('group', 'like', '04')
       //           ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //                  return $q->whereBetween('date_record',[$fdate,$tdate]);
       //                  })
       //           ->count();

       //           $group05 = DB::table('recordcalls')
       //           ->where('group', 'like', '05')
       //           ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //                  return $q->whereBetween('date_record',[$fdate,$tdate]);
       //                  })
       //           ->count();

       //           $group06 = DB::table('recordcalls')
       //           ->where('group', 'like', '06')
       //           ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //                  return $q->whereBetween('date_record',[$fdate,$tdate]);
       //                  })
       //           ->count();

       //           $group07 = DB::table('recordcalls')
       //           ->where('group', 'like', '07')
       //           ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
       //                  return $q->whereBetween('date_record',[$fdate,$tdate]);
       //                  })
       //           ->count();

       //           return view('call.home', compact('type','allbranch','ptbranch','ylbranch','nrbranch','sbbranch','klbranch','btbranch',
       //           'sumall','sumpt','sumyl','sumnr','sumsb','sumkl','sumbt','sum02','sum10','branch0210',
       //           'pattani','yala','nara','saiburi','kolok','betong','check',
       //           'data_pt_ori','data_yl_ori','data_nr_ori','data_sb_ori','data_kl_ori','data_bt_ori',
       //           'data_all','data_today','data_pt','data_yl','data_nr','data_sb','data_kl','data_bt','data_02','data_10',
       //           'sum_data_all','sum_data_today','sum_data_pt','sum_data_yl','sum_data_nr','sum_data_sb','sum_data_kl','sum_data_bt','sum_data_02','sum_data_10',
       //           'differ','sum_for_all1','sum_for_all2',
       //           'fdate','tdate','group01','group03','group04','group05','group06','group07'));
       //         }
               if ($request->type == 3)
               {
                       $fdate = $date;
                       $tdate = $date;
                       if ($request->has('Fromdate')) {
                         $fdate = $request->get('Fromdate');
                       }
                       if ($request->has('Todate')) {
                         $tdate = $request->get('Todate');
                       }

                     $data_today = DB::table('recordcalls')
                     ->select('CONTNO')
                     ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                            return $q->whereBetween('date_record',[$fdate,$tdate]);
                            })
                     ->orderBy('CONTNO', 'ASC')
                     ->get();
                     $sum_data_today = count($data_today);

                     $all = DB::connection('ibmi')
                           ->table('SFHP.ARMAST')
                           ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                           ->select('SFHP.ARMAST.CONTNO')
                           ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                                  return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                                  })
                           ->whereBetween('SFHP.ARMAST.HLDNO',[1,1.49])
                           ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                           ->get();
                     $allsum = count($all);

                     $numall = 0;
                     $sum_for_all1 = [];
                     $sum_for_all2 = [];

                     for ($j=0; $j < $sum_data_today; $j++) {

                       for ($i=0; $i < $allsum; $i++) {

                         if ($data_today[$j] == $all[$i]) {
                               $sum_for_all1[] = $all[$i];
                               $numall = 0;
                           break;
                         }
                         if($data_today[$j] <> $all[$i]) {
                             $numall = $i;

                           if ($numall == ($allsum - 1)) {
                             $sum_for_all2[] = $data_today[$j];
                             $numall = 0;
                           }

                           continue;
                         }
                       }
                     }

                $num1 = count($sum_for_all1);
                $num2 = count($sum_for_all2);

                // dump($sum_data_today, $allsum, $num1, $num2);


                for($c=0; $c<$num2; $c++){

                  $datas = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->select('SFHP.ARMAST.HLDNO', 'SFHP.ARMAST.CONTNO')
                  ->where('SFHP.ARMAST.CONTNO','=', $sum_for_all2[$c]->CONTNO)
                  // ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();
                  $count_datas = count($datas);

                }

                $ch_update = DB::table('recordcalls')
                ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                       return $q->whereBetween('date_record',[$fdate,$tdate]);
                       })
                ->whereNotNull('l_hldno')
                ->orderBy('CONTNO', 'ASC')
                ->get();
                $count_ch_update = count($ch_update);

                // dump($num2, $count_ch_update);

                $numupdate = 0;
                $sum_update_all1 = [];
                $sum_update_all2 = [];

                for ($a=0; $a < $allsum; $a++) {

                  for ($b=0; $b < $num1; $b++) {

                    if ($all[$a] == $sum_for_all1[$b]) {
                          $sum_update_all1[] = $sum_for_all1[$b];
                          $numupdate = 0;
                      break;
                    }
                    if($all[$a] <> $sum_for_all1[$b]) {
                        $numupdate = $b;

                      if ($numupdate == ($num1 - 1)) {
                        $sum_update_all2[] = $all[$a];
                        $numupdate = 0;
                      }

                      continue;
                    }
                  }
                }

                $count_update_all2 = count($sum_update_all2);

                $data_all_pay = DB::table('recordcalls')
                ->where('pay_status', '!=', null)
                ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                       return $q->whereBetween('date_record',[$fdate,$tdate]);
                       })
                ->orderBy('CONTNO', 'ASC')
                ->count();

                $data_pt_pay = DB::table('recordcalls')
                ->where('group', 'like', '01')
                ->where('pay_status', '!=', null)
                ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                       return $q->whereBetween('date_record',[$fdate,$tdate]);
                       })
                ->orderBy('CONTNO', 'ASC')
                ->count();

                $data_yl_pay = DB::table('recordcalls')
                ->where('group', 'like', '03')
                ->where('pay_status', '!=', null)
                ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                       return $q->whereBetween('date_record',[$fdate,$tdate]);
                       })
                ->orderBy('CONTNO', 'ASC')
                ->count();

                $data_nr_pay = DB::table('recordcalls')
                ->where('group', 'like', '04')
                ->where('pay_status', '!=', null)
                ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                       return $q->whereBetween('date_record',[$fdate,$tdate]);
                       })
                ->orderBy('CONTNO', 'ASC')
                ->count();

                $data_sb_pay = DB::table('recordcalls')
                ->where('group', 'like', '05')
                ->where('pay_status', '!=', null)
                ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                       return $q->whereBetween('date_record',[$fdate,$tdate]);
                       })
                ->orderBy('CONTNO', 'ASC')
                ->count();

                $data_kl_pay = DB::table('recordcalls')
                ->where('group', 'like', '06')
                ->where('pay_status', '!=', null)
                ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                       return $q->whereBetween('date_record',[$fdate,$tdate]);
                       })
                ->orderBy('CONTNO', 'ASC')
                ->count();

                $data_bt_pay = DB::table('recordcalls')
                ->where('group', 'like', '07')
                ->where('pay_status', '!=', null)
                ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                       return $q->whereBetween('date_record',[$fdate,$tdate]);
                       })
                ->orderBy('CONTNO', 'ASC')
                ->count();

                // dd($data_pt_pay);

                 return view('call.checkCall', compact('type','allbranch','ptbranch','ylbranch','nrbranch','sbbranch','klbranch','btbranch',
                 'sumall','sumpt','sumyl','sumnr','sumsb','sumkl','sumbt','sum02','sum10','branch0210',
                 'data_all_pay','data_pt_pay','data_yl_pay','data_nr_pay','data_sb_pay','data_kl_pay','data_bt_pay',
                 'pattani','yala','nara','saiburi','kolok','betong','check',
                 'data_all','data_today','data_pt','data_yl','data_nr','data_sb','data_kl','data_bt','data_02','data_10',
                 'sum_data_all','sum_data_today','sum_data_pt','sum_data_yl','sum_data_nr','sum_data_sb','sum_data_kl','sum_data_bt','sum_data_02','sum_data_10',
                 'differ','sum_for_all1','sum_for_all2','datas','num2','count_ch_update','sum_update_all2','count_update_all2',
                 'fdate','tdate'));
                 }

     elseif ($request->type == 2){

       $fdate = $date;
       $tdate = $date;
       if ($request->has('Fromdate')) {
         $fdate = $request->get('Fromdate');
       }
       if ($request->has('Todate')) {
         $tdate = $request->get('Todate');
       }

       $all_month_0 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('l_hldno', '=', '0.00')
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_all_month_0 = count($all_month_0);

       $pt_month_0 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '01')
       ->where('l_hldno', '=', '0.00')
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_pt_month_0 = count($pt_month_0);

       $yl_month_0 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '03')
       ->where('l_hldno', '=', '0.00')
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_yl_month_0 = count($yl_month_0);

       $nr_month_0 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '04')
       ->where('l_hldno', '=', '0.00')
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_nr_month_0 = count($nr_month_0);

       $sb_month_0 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '05')
       ->where('l_hldno', '=', '0.00')
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_sb_month_0 = count($sb_month_0);

       $kl_month_0 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '06')
       ->where('l_hldno', '=', '0.00')
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_kl_month_0 = count($kl_month_0);

       $bt_month_0 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '07')
       ->where('l_hldno', '=', '0.00')
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_bt_month_0 = count($bt_month_0);

       $all_month_l1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->whereBetween('l_hldno',[0.01,0.99])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_all_month_l1 = count($all_month_l1);

       $pt_month_l1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '01')
       ->whereBetween('l_hldno',[0.01,0.99])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_pt_month_l1 = count($pt_month_l1);

       $yl_month_l1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '03')
       ->whereBetween('l_hldno',[0.01,0.99])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_yl_month_l1 = count($yl_month_l1);

       $nr_month_l1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '04')
       ->whereBetween('l_hldno',[0.01,0.99])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_nr_month_l1 = count($nr_month_l1);

       $sb_month_l1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '05')
       ->whereBetween('l_hldno',[0.01,0.99])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_sb_month_l1 = count($sb_month_l1);

       $kl_month_l1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '06')
       ->whereBetween('l_hldno',[0.01,0.99])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_kl_month_l1 = count($kl_month_l1);

       $bt_month_l1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '07')
       ->whereBetween('l_hldno',[0.01,0.99])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_bt_month_l1 = count($bt_month_l1);

       $all_month_1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->whereBetween('hldno',[1.00,1.49])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_all_month_1 = count($all_month_1);

       $pt_month_1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '01')
       ->whereBetween('hldno',[1.00,1.49])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_pt_month_1 = count($pt_month_1);

       $yl_month_1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '03')
       ->whereBetween('hldno',[1.00,1.49])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_yl_month_1 = count($yl_month_1);

       $nr_month_1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '04')
       ->whereBetween('hldno',[1.00,1.49])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_nr_month_1 = count($nr_month_1);

       $sb_month_1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '05')
       ->whereBetween('hldno',[1.00,1.49])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_sb_month_1 = count($sb_month_1);

       $kl_month_1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '06')
       ->whereBetween('hldno',[1.00,1.49])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_kl_month_1 = count($kl_month_1);

       $bt_month_1 = DB::table('recordcalls')
       ->whereBetween('date_record',[$fdate,$tdate])
       ->where('group', '=', '07')
       ->whereBetween('hldno',[1.00,1.49])
       ->orderBy('CONTNO', 'ASC')
       ->get();
       $sum_bt_month_1 = count($bt_month_1);

       return view('call.month', compact('type','fdate','tdate',
       'sum_all_month_0','sum_pt_month_0','sum_yl_month_0','sum_nr_month_0','sum_sb_month_0','sum_kl_month_0','sum_bt_month_0',
       'sum_all_month_l1','sum_pt_month_l1','sum_yl_month_l1','sum_nr_month_l1','sum_sb_month_l1','sum_kl_month_l1','sum_bt_month_l1',
       'sum_all_month_1','sum_pt_month_1','sum_yl_month_1','sum_nr_month_1','sum_sb_month_1','sum_kl_month_1','sum_bt_month_1'));
     }
     elseif ($request->type == 99){
       return view('call.homeCheck');
     }

   }

  public function viewdetail(Request $request)
  {
      if ($request->type == 1){
              $contno = $request->contractNo;
              $idcard = $request->idCard;
              $data = DB::connection('ibmi')
                     ->table('SFHP.ARMAST')
                     ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                     ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                     ->where('SFHP.ARMAST.CONTNO','=', $contno)
                     ->first();
              if($data != Null && $idcard == str_replace(" ","",$data->IDNO)){
                $message = 'ข้อมูลถูกต้อง';
              }else{
                $message = 'เลขที่สัญญาหรือเลขบัตรประชาชนไม่ถูกต้อง';
              }
              return view('call.pageResult', compact('data','message'));
      }
    $SetStrConn = $SetStr1."/".$SetStr2;

    $info = DB::connection('ibmi')
    ->table('SFHP.ARMAST')
    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
    ->where('SFHP.ARMAST.CONTNO','=', $SetStrConn)
    ->first();

    $info2 = DB::connection('ibmi')
    ->table('SFHP.ARPAY')
    ->where('SFHP.ARPAY.CONTNO','=', $SetStrConn)
    ->get();

    $info3 = DB::connection('ibmi')
    ->table('SFHP.VIEW_ARMGAR')
    ->where('SFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
    ->first();

    return view('call.viewdetail', compact('info', 'info2', 'info3'));
  }
}
