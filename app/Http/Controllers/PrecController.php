<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Exporter;
use Excel;
use Carbon\Carbon;
use App\Holdcar;
use Helper;

class PrecController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Bangkok');
        $Y = date('Y');
        $m = date('m');
        $d = date('d');
        $date = $Y.'-'.$m.'-'.$d;

        if ($request->type == 1) {  //ปล่อยงานตาม (เรียกย้อนหลัง 1 วัน)
          $newdate = date('Y-m-d');
          $yesterdate = date('Y-m-d',strtotime('-1 days'));
          $fdate = $newdate;
          $tdate = $newdate;
          $newfdate = $yesterdate;
          $newtdate = $yesterdate;
          if ($request->has('Fromdate')) {
            $fdate = $request->get('Fromdate');

            $new = Carbon::parse($fdate)->addDays(-1);
            $newfdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
          }
          if ($request->has('Todate')) {
            $tdate = $request->get('Todate');

            $new = Carbon::parse($tdate)->addDays(-1);
            $newtdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
          }
          // if ($request->has('Fromstart')) {
          //   $fstart = $request->get('Fromstart');
          // }
          // if ($request->has('Toend')) {
          //   $tend = $request->get('Toend');
          // }

          $data = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->where('SFHP.ARMAST.BILLCOLL','=',99)
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$newfdate,$newtdate]);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[3.00,4.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $dataNotice = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[4.7,5.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $dataPrec  = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[3.7,4.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $dataLegis  = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[5.7,6.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $type = $request->type;
          return view('precipitate.view', compact('data','dataNotice','dataPrec','dataLegis','fstart','tend','fdate','tdate','newfdate','newtdate','type'));
        }
        elseif ($request->type == 2) {
          $fdate = $date;
          $tdate = $date;
          $follower = '';
          if ($request->has('Fromdate')) {
            $fdate = $request->get('Fromdate');
          }
          if ($request->has('Todate')) {
            $tdate = $request->get('Todate');
          }
          if ($request->has('follower')) {
            $follower = $request->get('follower');
          }

          $data = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->whereBetween('SFHP.ARMAST.HLDNO',[2.5,4.69])
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                    })
                    ->when(!empty($follower), function($q) use($follower){
                      return $q->where('SFHP.ARMAST.BILLCOLL',$follower);
                    })
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $type = $request->type;
          return view('precipitate.view', compact('data','fdate','tdate','follower','type'));
        }
        elseif ($request->type == 3) {  //แจ้งเตือนติดตาม
          $newdate = date('Y-m-d', strtotime('-1 days'));
          $fdate = $newdate;
          $tdate = $newdate;
          $newDay = substr($newdate, 8, 9);
          $fstart = '1.5';
          $tend = '2.99';
          $followcode = '';

          if ($request->has('Fromdate')) {
            $fdate = $request->get('Fromdate');
            $newDay = substr($fdate, 8, 9);
          }
          if ($request->has('Todate')) {
            $tdate = $request->get('Todate');
          }
          if ($request->has('Fromstart')) {
            $fstart = $request->get('Fromstart');
          }
          if ($request->has('Toend')) {
            $tend = $request->get('Toend');
          }
          if ($request->has('Followcode')) {
            $followcode = $request->get('Followcode');
          }

          $data1 = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->when(!empty($fstart)  && !empty($tend), function($q) use ($fstart, $tend) {
                      return $q->whereBetween('SFHP.ARMAST.HLDNO',[$fstart,$tend]);
                    })
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                    })
                    ->when(!empty($followcode), function($q) use ($followcode) {
                      return $q->where('SFHP.ARMAST.BILLCOLL','=', $followcode);
                    })
                    // ->where('SFHP.ARMAST.BILLCOLL','=',99)
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();
          $count = count($data1);
                    for($i=0; $i<$count; $i++){
                      $str[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$data1[$i]->CONTSTAT)));
                      if ($str[$i] == "ท") {
                        $data[] = $data1[$i];
                      }
                    }

          $data2 = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->when(!empty($fstart)  && !empty($tend), function($q) use ($fstart, $tend) {
                      return $q->whereBetween('SFHP.ARMAST.HLDNO',[$fstart,$tend]);
                    })
                    ->when(!empty($followcode), function($q) use ($followcode) {
                      return $q->where('SFHP.ARMAST.BILLCOLL','=', $followcode);
                    })
                    // ->whereBetween('SFHP.ARMAST.HLDNO',[1.5,2.99])
                    // ->where('SFHP.ARMAST.BILLCOLL','=',99)
                    ->when(!empty($newDay), function($q) use ($newDay) {
                      return $q->whereDay('SFHP.ARMAST.FDATE',$newDay);
                    })
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $count = count($data2);
          $data = $data1;

          if($count != 0){
              for ($i=0; $i < $count; $i++) {
                if($data2[$i]->EXP_FRM == $data2[$i]->EXP_TO){
                  $data3[] = $data2[$i];
                  $data = $data1->concat($data3);
                }
              }
          }else{
            $data = $data1;
          }


          $type = $request->type;
          return view('precipitate.view', compact('data','fdate','tdate','fstart','tend','type','followcode'));
        }
        elseif ($request->type == 4) {  //ปล่อยงานโนติส
          $fdate = $date;
          $tdate = $date;
          if ($request->has('Fromdate')) {
            $fdate = $request->get('Fromdate');
          }
          if ($request->has('Todate')) {
            $tdate = $request->get('Todate');
          }

          $data = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[4.7,5.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();
          // dd($data);

          $type = $request->type;
          return view('precipitate.view', compact('data','fdate','tdate','type'));
        }
        elseif ($request->type == 5) {  //หน้า stock เร่งรัด
          $fdate = '';
          $tdate = '';
          $Statuscar = '';
          if ($request->has('Fromdate')) {
            $fdate = $request->get('Fromdate');
          }
          if ($request->has('Todate')) {
            $tdate = $request->get('Todate');
          }
          if ($request->has('Statuscar')) {
            $Statuscar = $request->get('Statuscar');
          }
          if($Statuscar == 7){
            $data = DB::table('holdcars')
            ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
              return $q->whereBetween('holdcars.Date_hold',[$fdate,$tdate]);
            })
            ->whereIn('holdcars.Statuscar', [1, 3])
            ->orderBy('holdcars.Date_hold', 'ASC')
            ->get();
          }
          else{
            $data = DB::table('holdcars')
            ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
              return $q->whereBetween('holdcars.Date_hold',[$fdate,$tdate]);
            })
            ->when(!empty($Statuscar), function($q) use ($Statuscar) {
              return $q->where('holdcars.Statuscar',$Statuscar);
            })
            ->orderBy('holdcars.Date_hold', 'ASC')
            ->get();
          }

          $type = $request->type;
          return view('precipitate.viewstock', compact('data','type','fdate','tdate','Statuscar'));
        }
        elseif ($request->type == 6) {  //หน้า เพิ่มรถ
          $type = $request->type;
          return view('precipitate.createstock', compact('type'));
        }
        elseif ($request->type == 7) {  //รายงาน งานประจำวัน
          $fdate = $date;
          $tdate = $date;
          if ($request->has('Fromdate')) {
            $fdate = $request->get('Fromdate');

            $new = Carbon::parse($fdate)->addDays(-1);
            $newfdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
          }
          else {
            $new = Carbon::parse($date)->addDays(-1);
            $newfdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
          }

          if ($request->has('Todate')) {
            $tdate = $request->get('Todate');

            $new = Carbon::parse($tdate)->addDays(-1);
            $newtdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
          }
          else {
            $new = Carbon::parse($date)->addDays(-1);
            $newtdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
          }

          $dataFollow = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->where('SFHP.ARMAST.BILLCOLL','=',99)
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$newfdate,$newtdate]);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[3.00,4.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $dataNotice  = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[4.7,5.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $dataPrec  = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[3.7,4.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $dataLegis  = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[5.7,6.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

            $type = $request->type;
            return view('precipitate.viewReport', compact('dataFollow','dataNotice','dataPrec','dataLegis','fdate','tdate','newfdate','newtdate','fstart','tend','type'));
        }
        elseif ($request->type == 8) {  //รายงาน รับชำระค่าติดตาม
          $fdate = $date;
          $tdate = $date;
          if ($request->has('Fromdate')) {
            $fdate = $request->get('Fromdate');
          }
          if ($request->has('Todate')) {
            $tdate = $request->get('Todate');
          }

          $data = DB::connection('ibmi')
                    ->table('SFHP.HDPAYMENT')
                    ->leftJoin('SFHP.TRPAYMENT','SFHP.HDPAYMENT.TEMPBILL','=','SFHP.TRPAYMENT.TEMPBILL')
                    ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                      return $q->whereBetween('SFHP.HDPAYMENT.TEMPDATE',[$fdate,$tdate]);
                    })
                    ->where('SFHP.TRPAYMENT.PAYCODE','!=','006')
                    ->orderBy('SFHP.HDPAYMENT.CONTNO', 'ASC')
                    ->get();

            $type = $request->type;
            $Office = $request->DataOffice;
            return view('precipitate.viewReport', compact('data','fdate','tdate','type','Office'));
        }
        elseif ($request->type == 9) {
          $newdate = $date;

          if ($request->has('SelectDate')) {
            $newdate = $request->get('SelectDate');
          }

          $dataSup = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.VIEW_ARMGAR.CONTNO')
                    ->select('SFHP.ARMAST.*','SFHP.VIEW_ARMGAR.NAME')
                    ->when(!empty($newdate), function($q) use ($newdate) {
                     return $q->where('SFHP.ARPAY.DDATE',$newdate);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[2,2.99])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          $dataUseSup = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->join('SFHP.VIEW_ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.VIEW_ARMGAR.CONTNO')
                    ->select('SFHP.ARMAST.*','SFHP.VIEW_CUSTMAIL.SNAM','SFHP.VIEW_CUSTMAIL.NAME1','SFHP.VIEW_CUSTMAIL.NAME2')
                    ->when(!empty($newdate), function($q) use ($newdate) {
                      return $q->where('SFHP.ARPAY.DDATE',$newdate);
                    })
                    ->whereBetween('SFHP.ARMAST.HLDNO',[3,4.69])
                    ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                    ->get();

          // dd($data1);

            $type = $request->type;
            return view('precipitate.viewReport', compact('dataSup','dataUseSup','newdate','type'));
        }
        elseif ($request->type == 10) { //รายงาน หนังสือยืนยัน
          $contno = '';
          $fdate = '';
          $tdate = '';
          $fstart = '6';
          $tend = '8.99';

          if ($request->has('Contno')) {
            $contno = $request->get('Contno');
          }
          if ($request->has('Fromdate')) {
            $fdate = $request->get('Fromdate');
          }
          if ($request->has('Todate')) {
            $tdate = $request->get('Todate');
          }
          if ($request->has('Fromstart')) {
            $fstart = $request->get('Fromstart');
          }
          if ($request->has('Toend')) {
            $tend = $request->get('Toend');
          }

          if($contno == ''){
            $data = DB::connection('ibmi')
            ->table('SFHP.ARMAST')
            ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
            // ->whereBetween('SFHP.ARMAST.HLDNO',[3, 4.9])
            ->when(!empty($fstart)  && !empty($tend), function($q) use ($fstart, $tend) {
              return $q->whereBetween('SFHP.ARMAST.HLDNO',[$fstart,$tend]);
            })
            ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
              return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
            })
            ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
            ->get();
            // $count = count($dataCan);
            // for($i=0; $i<$count; $i++){
            //   $str[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$dataCan[$i]->CONTSTAT)));
            //   if ($str[$i] == "ฟ" OR $str[$i] == "P") {
            //     $data[] = $dataCan[$i];
            //   }
            // }
          }else{
            $data = DB::connection('ibmi')
            ->table('SFHP.ARMAST')
            ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
            ->when(!empty($contno), function($q) use($contno){
              return $q->where('SFHP.ARMAST.CONTNO','=',$contno);
            })
            ->get();
          }
          // dd($data);
          $type = $request->type;
          return view('precipitate.viewReport', compact('data','fdate','tdate','fstart','tend','type','contno'));
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
      // dd($request->type);

        if($request->type == 6) {
          if($request->get('Pricehold') == ''){
            $SetPricehold = 0;
          }else{
            $SetPricehold = str_replace (",","",$request->get('Pricehold'));
          }

          if($request->get('Amounthold') == ''){
            $SetAmounthold = 0;
          }else{
            $SetAmounthold = str_replace (",","",$request->get('Amounthold'));
          }

          if($request->get('Payhold') == ''){
            $SetPayhold = 0;
          }else{
            $SetPayhold = str_replace (",","",$request->get('Payhold'));
          }

          if($request->get('CapitalAccount') == ''){
            $SetCapitalAccount = 0;
          }else{
            $SetCapitalAccount = str_replace (",","",$request->get('CapitalAccount'));
          }

          if($request->get('CapitalTopprice') == ''){
            $SetCapitalTopprice = 0;
          }else{
            $SetCapitalTopprice = str_replace (",","",$request->get('CapitalTopprice'));
          }

          $Holdcardb = new Holdcar([
            'Contno_hold' => $request->get('Contno'),
            'Name_hold' => $request->get('NameCustomer'),
            'Brandcar_hold' => $request->get('Brandcar'),
            'Number_Regist' => $request->get('Number_Regist'),
            'Year_Product' => $request->get('Yearcar'),
            'Date_hold' => $request->get('Datehold'),
            'Dateupdate_hold' => date('Y-m-d'),
            'Team_hold' => $request->get('Teamhold'),
            'Price_hold' => $SetPricehold,
            'Statuscar' => $request->get('Statuscar'),
            'Note_hold' => $request->get('Note'),
            'Date_came' => $request->get('Datecame'),
            'Amount_hold' => $SetAmounthold,
            'Pay_hold' => $SetPayhold,
            'Datecheck_Capital' => $request->get('DatecheckCapital'),
            'Datesend_Stockhome' => $request->get('DatesendStockhome'),
            'Datesend_Letter' => $request->get('DatesendLetter'),
            'Barcode_No' => $request->get('BarcodeNo'),
            'Capital_Account' => $SetCapitalAccount,
            'Capital_Topprice' => $SetCapitalTopprice,
            'Note2_hold' => $request->get('Note2'),
            'Letter_hold' => $request->get('Letter'),
            'Date_send' => $request->get('Datesend'),
            'Barcode2' => $request->get('Barcode2'),
            'Accept_hold' => $request->get('Accept'),
            'Soldout_hold' => $request->get('Soldout'),
          ]);
          $Holdcardb->save();
          $type = 5;
          return redirect()->Route('Precipitate', $type)->with('success','บันทึกข้อมูลเรียบร้อย');
        }
        elseif($request->type == 10){
          $AcceptDate = $request->AcceptDate;
          $PayAmount = str_replace(",","",$request->PayAmount);
          $BalanceAmount = str_replace(",","",$request->BalanceAmount);
          $Contno = $request->contno;
          // dd($AcceptDate,$PayAmount,$BalanceAmount,$Contno);

          $data = DB::connection('ibmi')
                    ->table('SFHP.ARMAST')
                    ->leftJoin('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                    ->leftJoin('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                    ->leftJoin('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                    ->leftJoin('SFHP.VIEW_ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.VIEW_ARMGAR.CONTNO')
                    ->leftJoin('SFHP.ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.ARMGAR.CONTNO')
                    ->leftJoin('SFHP.TBROKER','SFHP.ARMAST.RECOMCOD','=','SFHP.TBROKER.MEMBERID')
                    ->leftJoin('SFHP.CUSTMAST','SFHP.ARMAST.CUSCOD','=','SFHP.CUSTMAST.CUSCOD')
                    ->select('SFHP.ARMAST.*','SFHP.VIEW_CUSTMAIL.*','SFHP.INVTRAN.*','SFHP.VIEW_ARMGAR.NAME','SFHP.VIEW_ARMGAR.NICKNM AS NICKARMGAR',
                             'SFHP.ARMGAR.RELATN','SFHP.VIEW_ARMGAR.ADDRES as ADDARMGAR','SFHP.VIEW_ARMGAR.TUMB as TUMBARMGAR','SFHP.VIEW_ARMGAR.AUMPDES AS AUMARMGAR',
                             'SFHP.VIEW_ARMGAR.PROVDES AS PROARMGAR','SFHP.VIEW_ARMGAR.OFFIC AS OFFICARMGAR','SFHP.VIEW_ARMGAR.TELP AS TELPARMGAR',
                             'SFHP.CUSTMAST.OCCUP','SFHP.CUSTMAST.MEMO1 AS CUSMEMO','SFHP.CUSTMAST.OFFIC AS CUSOFFIC',
                             'SFHP.TBROKER.FNAME','SFHP.TBROKER.LNAME','SFHP.TBROKER.MEMBERID','SFHP.TBROKER.ADDRESS','SFHP.TBROKER.TELP AS TELPTBROKER')
                    ->where('SFHP.ARMAST.CONTNO','=',$Contno)
                    ->first();

            $data2 = DB::connection('ibmi')
                      ->table('SFHP.ARPAY')
                      ->where('SFHP.ARPAY.CONTNO','=',$Contno)
                      ->get();
            $count2 = count($data2);
            for ($i=0; $i < $count2; $i++) {
              if($data2[$i]->DAMT != $data2[$i]->PAYMENT){
                $SetDate[] = $data2[$i]->DDATE;
                $Datehold = $SetDate[0];
              }
            }
            // dd($Datehold);
            $data3 = DB::connection('ibmi')
                      ->table('SFHP.AROTHR')
                      ->where('SFHP.AROTHR.CONTNO','=',$Contno)
                      ->where('SFHP.AROTHR.PAYFOR','=',600)
                      ->orderBy('SFHP.AROTHR.ARDATE', 'DESC')
                      ->first();
            $DatecancleContract = $data3->ARDATE;

            $word = str_replace(" ", "",$data->STRNO);
            $word2 = str_replace(" ", "",$data->ENGNO);
            $test = strlen($word);
            $test2 = strlen($word2);

            for ($i=0; $i < $test; $i++) {
              $string[] = substr($word, $i, 1);
              if($string[$i] == 'A'){
                $Newword[] = 'เอ';
              }elseif($string[$i] == 'B'){
                $Newword[] = 'บี';
              }elseif($string[$i] == 'C'){
                $Newword[] = 'ซี';
              }elseif($string[$i] == 'D'){
                $Newword[] = 'ดี';
              }elseif($string[$i] == 'E'){
                $Newword[] = 'อี';
              }elseif($string[$i] == 'F'){
                $Newword[] = 'เอฟ';
              }elseif($string[$i] == 'G'){
                $Newword[] = 'จี';
              }elseif($string[$i] == 'H'){
                $Newword[] = 'เฮช';
              }elseif($string[$i] == 'I'){
                $Newword[] = 'ไอ';
              }elseif($string[$i] == 'J'){
                $Newword[] = 'เจ';
              }elseif($string[$i] == 'K'){
                $Newword[] = 'เค';
              }elseif($string[$i] == 'L'){
                $Newword[] = 'แอล';
              }elseif($string[$i] == 'M'){
                $Newword[] = 'เอ็ม';
              }elseif($string[$i] == 'N'){
                $Newword[] = 'เอ็น';
              }elseif($string[$i] == 'O'){
                $Newword[] = 'โอ';
              }elseif($string[$i] == 'P'){
                $Newword[] = 'พี';
              }elseif($string[$i] == 'Q'){
                $Newword[] = 'คิว';
              }elseif($string[$i] == 'R'){
                $Newword[] = 'อาร์';
              }elseif($string[$i] == 'S'){
                $Newword[] = 'เอส';
              }elseif($string[$i] == 'T'){
                $Newword[] = 'ที';
              }elseif($string[$i] == 'U'){
                $Newword[] = 'ยู';
              }elseif($string[$i] == 'V'){
                $Newword[] = 'วี';
              }elseif($string[$i] == 'W'){
                $Newword[] = 'ดับเบิลยู';
              }elseif($string[$i] == 'X'){
                $Newword[] = 'เอ็กซ์';
              }elseif($string[$i] == 'Y'){
                $Newword[] = 'วาย';
              }elseif($string[$i] == 'Z'){
                $Newword[] = 'แซก์';
              }

              elseif($string[$i] == '1'){
                $Newword[] = '1';
              }elseif($string[$i] == '2'){
                $Newword[] = '2';
              }elseif($string[$i] == '3'){
                $Newword[] = '3';
              }elseif($string[$i] == '4'){
                $Newword[] = '4';
              }elseif($string[$i] == '5'){
                $Newword[] = '5';
              }elseif($string[$i] == '6'){
                $Newword[] = '6';
              }elseif($string[$i] == '7'){
                $Newword[] = '7';
              }elseif($string[$i] == '8'){
                $Newword[] = '8';
              }elseif($string[$i] == '9'){
                $Newword[] = '9';
              }elseif($string[$i] == '0'){
                $Newword[] = '0';
              }
            }

            for ($j=0; $j < $test2; $j++) {
              $string2[] = substr($word2, $j, 1);
              if($string2[$j] == 'A'){
                $Newword2[] = 'เอ';
              }elseif($string2[$j] == 'B'){
                $Newword2[] = 'บี';
              }elseif($string2[$j] == 'C'){
                $Newword2[] = 'ซี';
              }elseif($string2[$j] == 'D'){
                $Newword2[] = 'ดี';
              }elseif($string2[$j] == 'E'){
                $Newword2[] = 'อี';
              }elseif($string2[$j] == 'F'){
                $Newword2[] = 'เอฟ';
              }elseif($string2[$j] == 'G'){
                $Newword2[] = 'จี';
              }elseif($string2[$j] == 'H'){
                $Newword2[] = 'เฮช';
              }elseif($string2[$j] == 'I'){
                $Newword2[] = 'ไอ';
              }elseif($string2[$j] == 'J'){
                $Newword2[] = 'เจ';
              }elseif($string2[$j] == 'K'){
                $Newword2[] = 'เค';
              }elseif($string2[$j] == 'L'){
                $Newword2[] = 'แอล';
              }elseif($string2[$j] == 'M'){
                $Newword2[] = 'เอ็ม';
              }elseif($string2[$j] == 'N'){
                $Newword2[] = 'เอ็น';
              }elseif($string2[$j] == 'O'){
                $Newword2[] = 'โอ';
              }elseif($string2[$j] == 'P'){
                $Newword2[] = 'พี';
              }elseif($string2[$j] == 'Q'){
                $Newword2[] = 'คิว';
              }elseif($string2[$j] == 'R'){
                $Newword2[] = 'อาร์';
              }elseif($string2[$j] == 'S'){
                $Newword2[] = 'เอส';
              }elseif($string2[$j] == 'T'){
                $Newword2[] = 'ที';
              }elseif($string2[$j] == 'U'){
                $Newword2[] = 'ยู';
              }elseif($string2[$j] == 'V'){
                $Newword2[] = 'วี';
              }elseif($string2[$j] == 'W'){
                $Newword2[] = 'ดับเบิลยู';
              }elseif($string2[$j] == 'X'){
                $Newword2[] = 'เอ็กซ์';
              }elseif($string2[$j] == 'Y'){
                $Newword2[] = 'วาย';
              }elseif($string2[$j] == 'Z'){
                $Newword2[] = 'แซก์';
              }

              elseif($string2[$j] == '1'){
                $Newword2[] = '1';
              }elseif($string2[$j] == '2'){
                $Newword2[] = '2';
              }elseif($string2[$j] == '3'){
                $Newword2[] = '3';
              }elseif($string2[$j] == '4'){
                $Newword2[] = '4';
              }elseif($string2[$j] == '5'){
                $Newword2[] = '5';
              }elseif($string2[$j] == '6'){
                $Newword2[] = '6';
              }elseif($string2[$j] == '7'){
                $Newword2[] = '7';
              }elseif($string2[$j] == '8'){
                $Newword2[] = '8';
              }elseif($string2[$j] == '9'){
                $Newword2[] = '9';
              }elseif($string2[$j] == '0'){
                $Newword2[] = '0';
              }
            }

            $New_STRNO = implode($Newword);
            $New_ENGNO = implode($Newword2);

          $type = $request->type;

          $view = \View::make('precipitate.ReportInvoice' ,compact('data','AcceptDate','PayAmount','BalanceAmount','Contno','type','Datehold','DatecancleContract','New_STRNO','New_ENGNO'));
          $html = $view->render();
          $pdf = new PDF();
          $pdf::SetTitle('หนังสือบอกเลิกสัญญา');
          $pdf::AddPage('P', 'A4');
          $pdf::SetMargins(20, 5, 15);
          $pdf::SetFont('thsarabunpsk', '', 16, '', true);
          // $pdf::SetFont('angsananew', '', 16, '', true);
          // $pdf::SetFont('mazdatypeth', '', 12, '', true);
          $pdf::SetAutoPageBreak(TRUE, 25);
          $pdf::WriteHTML($html,true,false,true,false,'');
          $pdf::Output('CancelContractPaper.pdf');
        }

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
    public function edit($id,Request $request)
    {
        if($request->type == 5) {
          // dd($id);
          $data = DB::table('holdcars')
                    ->where('holdcars.hold_id',$id)
                    ->first();

          $type = $request->type;

          $Statuscar = [
            '1' => 'ยึดจากลูกค้าครั้งแรก',
            '2' => 'ลูกค้ามารับรถคืน',
            '3' => 'ยึดจากลูกค้าครั้งที่ 2',
            '4' => 'รับรถจากของกลาง',
            '5' => 'ส่งรถบ้าน',
            '6' => 'ลูกค้าส่งรถคืน',
          ];

          $Brandcarr = [
            'ISUZU' => 'ISUZU',
            'MITSUBISHI' => 'MITSUBISHI',
            'TOYOTA' => 'TOYOTA',
            'MAZDA' => 'MAZDA',
            'FORD' => 'FORD',
            'NISSAN' => 'NISSAN',
            'HONDA' => 'HONDA',
            'CHEVROLET' => 'CHEVROLET',
            'MG' => 'MG',
            'SUZUKI' => 'SUZUKI',
          ];

          $Teamhold = [
            '008' => '008 - เจ๊ะฟารีด๊ะห์ เจ๊ะกาเดร์',
            '102' => '102 - นายอับดุลเล๊าะ กาซอ',
            '104' => '104 - นายอนุวัฒน์ อับดุลราน',
            '105' => '105 - นายธีรวัฒน์ เจ๊ะกา',
            '112' => '112 - นายราชัน เจ๊ะกา',
            '113' => '113 - นายฟิฏตรี วิชา',
            '114' => '114 - นายอานันท์ กาซอ',
          ];

          $Accept = [
            'ได้รับ' => 'ได้รับ',
            'รอส่ง' => 'รอส่ง',
            'ส่งใหม่' => 'ส่งใหม่',
          ];

          return view('Precipitate.editstock', compact('data','type','id','Statuscar','Brandcarr','Teamhold','Accept'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $type)
    {
        date_default_timezone_set('Asia/Bangkok');
        $date = date('Y-m-d', strtotime('+45 days'));

        if($type == 5) {
          $SetPricehold = str_replace (",","",$request->get('Pricehold'));
          $SetAmounthold = str_replace (",","",$request->get('Amounthold'));
          $SetPayhold = str_replace (",","",$request->get('Payhold'));
          $SetCapitalAccount = str_replace (",","",$request->get('CapitalAccount'));
          $SetCapitalTopprice = str_replace (",","",$request->get('CapitalTopprice'));

          $hold = Holdcar::where('Hold_id',$id)->first();
            $hold->Contno_hold = $request->get('Contno');
            $hold->Name_hold = $request->get('NameCustomer');
            $hold->Brandcar_hold = $request->get('Brandcar');
            $hold->Number_Regist = $request->get('Number_Regist');
            $hold->Year_Product = $request->get('Yearcar');
            $hold->Date_hold = $request->get('Datehold');
            if($request->get('Datehold') != Null && $request->get('Datehold') != $hold->Dateupdate_hold){
              $hold->Dateupdate_hold = date('Y-m-d');
            }
            $hold->Team_hold = $request->get('Teamhold');
            $hold->Price_hold = $SetPricehold;
            $hold->Statuscar = $request->get('Statuscar');
            $hold->Note_hold = $request->get('Note');
            // dd($hold->Note_hold);
            $hold->Date_came = $request->get('Datecame');
            $hold->Amount_hold = $SetAmounthold;
            $hold->Pay_hold = $SetPayhold;
            $hold->Datecheck_Capital = $request->get('DatecheckCapital');
            $hold->Datesend_Stockhome = $request->get('DatesendStockhome');
            $hold->Datesend_Letter = $request->get('DatesendLetter');
            $hold->Barcode_No = $request->get('BarcodeNo');
            $hold->Capital_Account = $SetCapitalAccount;
            $hold->Capital_Topprice = $SetCapitalTopprice;
            $hold->Note2_hold = $request->get('Note2');
            $hold->Letter_hold = $request->get('Letter');
            $hold->Date_send = $request->get('Datesend');
            $hold->Barcode2 = $request->get('Barcode2');
            $hold->Accept_hold = $request->get('Accept');
            if($request->get('Accept') == 'ได้รับ'){
            $hold->Date_accept_hold = $date;
            }else{
            $hold->Date_accept_hold = NULL;
            }
            $hold->Soldout_hold = $request->get('Soldout');
          $hold->update();
          return redirect()->Route('Precipitate', $type)->with('success','อัพเดทข้อมูลเรียบร้อย');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type)
    {
      if($type == 5) {
        $item1 = Holdcar::find($id);
        $item1->Delete();
        return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
      }
    }

    public function ReportPrecDue(Request $request, $SetStr1, $SetStr2)
    {
      date_default_timezone_set('Asia/Bangkok');
      $Y = date('Y');
      $m = date('m');
      $d = date('d');
      $date = $Y.'-'.$m.'-'.$d;

      $fdate = '';
      $tdate = '';
      if ($request->has('Fromdate')) {
        $fdate = $request->get('Fromdate');

        $new = Carbon::parse($fdate)->addDays(-1);
        $newfdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
      }
      if ($request->has('Todate')) {
        $tdate = $request->get('Todate');

        $new = Carbon::parse($tdate)->addDays(-1);
        $newtdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
      }
      // if ($request->has('Fromstart')) {
      //   $fstart = $request->get('Fromstart');
      // }
      // if ($request->has('Toend')) {
      //   $tend = $request->get('Toend');
      // }

      if ($request->type == 1) {  //รายงาน ใบติดตาม
        $data = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->where('SFHP.ARMAST.BILLCOLL','=',99)
                  ->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate])
                  // ->whereBetween('SFHP.ARMAST.HLDNO',[$fstart,$tend])
                  ->whereBetween('SFHP.ARMAST.HLDNO',[3.00,4.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $CountData = count($data)-1;
        $type = $request->type;

        $view = \View::make('precipitate.ReportPrecDue' ,compact('data','date','fdate','tdate','type','CountData'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานข้อมูลติดตาม');
        $pdf::AddPage('L', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);
        $pdf::SetFont('freeserif', '', 10, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportPrecDue.pdf');
      }
      elseif ($request->type == 2) {  //รายงาน ใบแจ้งหนี้
        $SetStrConn = $SetStr1."/".$SetStr2;
        $data = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->leftJoin('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->leftJoin('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->leftJoin('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->leftJoin('SFHP.VIEW_ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.VIEW_ARMGAR.CONTNO')
                  ->leftJoin('SFHP.ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.ARMGAR.CONTNO')
                  ->leftJoin('SFHP.TBROKER','SFHP.ARMAST.RECOMCOD','=','SFHP.TBROKER.MEMBERID')
                  ->leftJoin('SFHP.CUSTMAST','SFHP.ARMAST.CUSCOD','=','SFHP.CUSTMAST.CUSCOD')
                  ->select('SFHP.ARMAST.*','SFHP.VIEW_CUSTMAIL.*','SFHP.INVTRAN.*','SFHP.VIEW_ARMGAR.NAME','SFHP.VIEW_ARMGAR.NICKNM AS NICKARMGAR',
                           'SFHP.ARMGAR.RELATN','SFHP.VIEW_ARMGAR.ADDRES as ADDARMGAR','SFHP.VIEW_ARMGAR.TUMB as TUMBARMGAR','SFHP.VIEW_ARMGAR.AUMPDES AS AUMARMGAR',
                           'SFHP.VIEW_ARMGAR.PROVDES AS PROARMGAR','SFHP.VIEW_ARMGAR.OFFIC AS OFFICARMGAR','SFHP.VIEW_ARMGAR.TELP AS TELPARMGAR',
                           'SFHP.CUSTMAST.OCCUP','SFHP.CUSTMAST.MEMO1 AS CUSMEMO','SFHP.CUSTMAST.OFFIC AS CUSOFFIC',
                           'SFHP.TBROKER.FNAME','SFHP.TBROKER.LNAME','SFHP.TBROKER.MEMBERID','SFHP.TBROKER.ADDRESS','SFHP.TBROKER.TELP AS TELPTBROKER')
                  ->where('SFHP.ARMAST.CONTNO','=',$SetStrConn)
                  ->whereBetween('SFHP.ARPAY.DDATE',[$newfdate,$newtdate])
                  ->whereBetween('SFHP.ARMAST.HLDNO',[3.00,4.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $dataArpay = DB::connection('ibmi')
                  ->table('SFHP.ARPAY')
                  ->where('SFHP.ARPAY.CONTNO','=',$SetStrConn)
                  ->sum('SFHP.ARPAY.INTAMT');

        $dataInpay = DB::connection('ibmi')
                  ->table('SFHP.CHQTRAN')
                  ->where('SFHP.CHQTRAN.CONTNO','=',$SetStrConn)
                  ->sum('SFHP.CHQTRAN.PAYINT');

        $SumPay = $dataArpay - $dataInpay;
        $type = $request->type;

        $view = \View::make('precipitate.ReportInvoice' ,compact('data','date','fdate','tdate','type','SumPay'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานข้อมูลติดตาม');
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);
        $pdf::SetFont('freeserif', '', 10, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportInvoice.pdf');
      }
      elseif ($request->type == 4) {  //รายงาน ใบแจ้งหนี้โนติส
        $SetStrConn = $SetStr1."/".$SetStr2;
        $data = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->leftJoin('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->leftJoin('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->leftJoin('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->leftJoin('SFHP.VIEW_ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.VIEW_ARMGAR.CONTNO')
                  ->leftJoin('SFHP.ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.ARMGAR.CONTNO')
                  ->leftJoin('SFHP.TBROKER','SFHP.ARMAST.RECOMCOD','=','SFHP.TBROKER.MEMBERID')
                  ->leftJoin('SFHP.CUSTMAST','SFHP.ARMAST.CUSCOD','=','SFHP.CUSTMAST.CUSCOD')
                  ->select('SFHP.ARMAST.*','SFHP.VIEW_CUSTMAIL.*','SFHP.INVTRAN.*','SFHP.VIEW_ARMGAR.NAME','SFHP.VIEW_ARMGAR.NICKNM AS NICKARMGAR',
                           'SFHP.ARMGAR.RELATN','SFHP.VIEW_ARMGAR.ADDRES as ADDARMGAR','SFHP.VIEW_ARMGAR.TUMB as TUMBARMGAR','SFHP.VIEW_ARMGAR.AUMPDES AS AUMARMGAR',
                           'SFHP.VIEW_ARMGAR.PROVDES AS PROARMGAR','SFHP.VIEW_ARMGAR.OFFIC AS OFFICARMGAR','SFHP.VIEW_ARMGAR.TELP AS TELPARMGAR',
                           'SFHP.CUSTMAST.OCCUP','SFHP.CUSTMAST.MEMO1 AS CUSMEMO','SFHP.CUSTMAST.OFFIC AS CUSOFFIC',
                           'SFHP.TBROKER.FNAME','SFHP.TBROKER.LNAME','SFHP.TBROKER.MEMBERID','SFHP.TBROKER.ADDRESS','SFHP.TBROKER.TELP AS TELPTBROKER')
                  ->where('SFHP.ARMAST.CONTNO','=',$SetStrConn)
                  ->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate])
                  ->whereBetween('SFHP.ARMAST.HLDNO',[4.7,5.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $dataArpay = DB::connection('ibmi')
                  ->table('SFHP.ARPAY')
                  ->where('SFHP.ARPAY.CONTNO','=',$SetStrConn)
                  ->sum('SFHP.ARPAY.INTAMT');

        $dataInpay = DB::connection('ibmi')
                  ->table('SFHP.CHQTRAN')
                  ->where('SFHP.CHQTRAN.CONTNO','=',$SetStrConn)
                  ->sum('SFHP.CHQTRAN.PAYINT');

        $SumPay = $dataArpay - $dataInpay;
        $type = $request->type;

        $view = \View::make('precipitate.ReportInvoice' ,compact('data','date','fdate','tdate','type','SumPay'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานข้อมูลโนติส');
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);
        $pdf::SetFont('freeserif', '', 10, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportInvoice.pdf');
      }
      elseif ($request->type == 5) {  //รายงาน สต็อกรถเร่งรัด
        $fdate = '';
        $tdate = '';
        $Statuscar = '';
        if ($request->has('Fromdate')) {
          $fdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
        }
        if ($request->has('Statuscar')) {
          $Statuscar = $request->get('Statuscar');
        }
        // dd($fdate,$tdate,$Statuscar);
        if($Statuscar == 7){
          $data = DB::table('holdcars')
          ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
            return $q->whereBetween('holdcars.Date_hold',[$fdate,$tdate]);
          })
          ->whereIn('holdcars.Statuscar', [1, 3])
          ->orderBy('holdcars.Date_hold', 'ASC')
          ->get();
        }
        else{
          $data = DB::table('holdcars')
          ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
            return $q->whereBetween('holdcars.Date_hold',[$fdate,$tdate]);
          })
          ->when(!empty($Statuscar), function($q) use ($Statuscar) {
            return $q->where('holdcars.Statuscar',$Statuscar);
          })
          ->orderBy('holdcars.Date_hold', 'ASC')
          ->get();
        }

        $type = $request->type;

        $view = \View::make('precipitate.ReportPrecDue' ,compact('data','date','fdate','tdate','type'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานสต็อกรถเร่งรัด');
        $pdf::AddPage('L', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);
        $pdf::SetFont('freeserif', '', 10, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportHoldcar.pdf');
      }
      elseif ($request->type == 7) {  //รายงาน ใบติดตามโนติส
        $data = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate])
                  ->whereBetween('SFHP.ARMAST.HLDNO',[4.7,5.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $type = $request->type;

        $view = \View::make('precipitate.ReportPrecDue' ,compact('data','date','fdate','tdate','type'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานข้อมูลโนติส');
        $pdf::AddPage('L', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);
        $pdf::SetFont('freeserif', '', 10, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportPrecDue.pdf');
      }
      elseif ($request->type == 8) {  //รายงาน รับชำระค่าติดตาม
        $data = DB::connection('ibmi')
                  ->table('SFHP.HDPAYMENT')
                  ->leftJoin('SFHP.TRPAYMENT','SFHP.HDPAYMENT.TEMPBILL','=','SFHP.TRPAYMENT.TEMPBILL')
                  ->whereBetween('SFHP.HDPAYMENT.TEMPDATE',[$fdate,$tdate])
                  ->where('SFHP.TRPAYMENT.PAYCODE','!=','006')
                  ->orderBy('SFHP.HDPAYMENT.CONTNO', 'ASC')
                  ->get();

        // dd($data);
        $summary102 = 0;
        $summary104 = 0;
        $summary105 = 0;
        $summary113 = 0;
        $summary112 = 0;
        $summary114 = 0;
        $summaryCKL = 0;

        foreach ($data as $key => $value) {
          if ($value->BILLCOLL == 102) {
            $summary102 += $value->TOTAMT;
            if ($value->CANDATE != "") {
              $summary102 -= $value->TOTAMT;
            }
          }
          elseif ($value->BILLCOLL == 104) {
            $summary104 += $value->TOTAMT;
            if ($value->CANDATE != "") {
              $summary104 -= $value->TOTAMT;
            }
          }
          elseif ($value->BILLCOLL == 105) {
            $summary105 += $value->TOTAMT;
            if ($value->CANDATE != "") {
              $summary105 -= $value->TOTAMT;
            }
          }
          elseif ($value->BILLCOLL == 113) {
            $summary113 += $value->TOTAMT;
            if ($value->CANDATE != "") {
              $summary113 -= $value->TOTAMT;
            }
          }
          elseif ($value->BILLCOLL == 112) {
            $summary112 += $value->TOTAMT;
            if ($value->CANDATE != "") {
              $summary112 -= $value->TOTAMT;
            }
          }
          elseif ($value->BILLCOLL == 114) {
            $summary114 += $value->TOTAMT;
            if ($value->CANDATE != "") {
              $summary114 -= $value->TOTAMT;
            }
          }
          elseif ($value->BILLCOLL == "CKL   "){
            $summaryCKL += $value->TOTAMT;
            if ($value->CANDATE != "") {
              $summaryCKL -= $value->TOTAMT;
            }
          }
        }

        // dump($summary102,$summary104,$summary105,$summary113,$summary112,$summary114,$summaryCKL);
        // dd($request);
        $DataOffice = $request->DataOffice;
        $type = $request->type;

        $view = \View::make('precipitate.ReportPrecDue' ,compact('data','fdate','tdate','type','DataOffice','summary102','summary104','summary105','summary113','summary112','summary114','summaryCKL'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงาน รับชำระค่าติดตาม');
        $pdf::AddPage('L', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);;
        $pdf::SetFont('freeserif', '', 12, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportAddPayment.pdf');
      }
      elseif ($request->type == 9) {  //รายงาน ใบติดตามเร่งรัด
        $data = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate])
                  ->whereBetween('SFHP.ARMAST.HLDNO',[3.7,4.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $type = $request->type;

        $view = \View::make('precipitate.ReportPrecDue' ,compact('data','date','fdate','tdate','type'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานข้อมูลเร่งรัด');
        $pdf::AddPage('L', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);
        $pdf::SetFont('freeserif', '', 10, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportPrecDue.pdf');
      }
      elseif ($request->type == 10) {  //รายงาน ใบติดตามเตรียมฟ้อง
        $data = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate])
                  ->whereBetween('SFHP.ARMAST.HLDNO',[5.7,6.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $type = $request->type;

        $view = \View::make('precipitate.ReportPrecDue' ,compact('data','date','fdate','tdate','type'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานข้อมูลเตรียมฟ้อง');
        $pdf::AddPage('L', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);
        $pdf::SetFont('freeserif', '', 10, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportPrecDue.pdf');
      }
      elseif ($request->type == 11) {  //รายงาน ใบแจ้งหนี้เร่งรัด
        $SetStrConn = $SetStr1."/".$SetStr2;
        $data = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->leftJoin('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->leftJoin('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->leftJoin('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->leftJoin('SFHP.VIEW_ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.VIEW_ARMGAR.CONTNO')
                  ->leftJoin('SFHP.ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.ARMGAR.CONTNO')
                  ->leftJoin('SFHP.TBROKER','SFHP.ARMAST.RECOMCOD','=','SFHP.TBROKER.MEMBERID')
                  ->leftJoin('SFHP.CUSTMAST','SFHP.ARMAST.CUSCOD','=','SFHP.CUSTMAST.CUSCOD')
                  ->select('SFHP.ARMAST.*','SFHP.VIEW_CUSTMAIL.*','SFHP.INVTRAN.*','SFHP.VIEW_ARMGAR.NAME','SFHP.VIEW_ARMGAR.NICKNM AS NICKARMGAR',
                           'SFHP.ARMGAR.RELATN','SFHP.VIEW_ARMGAR.ADDRES as ADDARMGAR','SFHP.VIEW_ARMGAR.TUMB as TUMBARMGAR','SFHP.VIEW_ARMGAR.AUMPDES AS AUMARMGAR',
                           'SFHP.VIEW_ARMGAR.PROVDES AS PROARMGAR','SFHP.VIEW_ARMGAR.OFFIC AS OFFICARMGAR','SFHP.VIEW_ARMGAR.TELP AS TELPARMGAR',
                           'SFHP.CUSTMAST.OCCUP','SFHP.CUSTMAST.MEMO1 AS CUSMEMO','SFHP.CUSTMAST.OFFIC AS CUSOFFIC',
                           'SFHP.TBROKER.FNAME','SFHP.TBROKER.LNAME','SFHP.TBROKER.MEMBERID','SFHP.TBROKER.ADDRESS','SFHP.TBROKER.TELP AS TELPTBROKER')
                  ->where('SFHP.ARMAST.CONTNO','=',$SetStrConn)
                  ->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate])
                  ->whereBetween('SFHP.ARMAST.HLDNO',[3.7,4.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $dataArpay = DB::connection('ibmi')
                  ->table('SFHP.ARPAY')
                  ->where('SFHP.ARPAY.CONTNO','=',$SetStrConn)
                  ->sum('SFHP.ARPAY.INTAMT');

        $dataInpay = DB::connection('ibmi')
                  ->table('SFHP.CHQTRAN')
                  ->where('SFHP.CHQTRAN.CONTNO','=',$SetStrConn)
                  ->sum('SFHP.CHQTRAN.PAYINT');

        $SumPay = $dataArpay - $dataInpay;
        $type = $request->type;

        $view = \View::make('precipitate.ReportInvoice' ,compact('data','date','fdate','tdate','type','SumPay'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานข้อมูลเร่งรัด');
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);
        $pdf::SetFont('freeserif', '', 10, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportInvoice.pdf');
      }
      elseif ($request->type == 12) {  //รายงาน ใบแจ้งหนี้เตรียมฟ้อง
        $SetStrConn = $SetStr1."/".$SetStr2;
        $data = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->leftJoin('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->leftJoin('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->leftJoin('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->leftJoin('SFHP.VIEW_ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.VIEW_ARMGAR.CONTNO')
                  ->leftJoin('SFHP.ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.ARMGAR.CONTNO')
                  ->leftJoin('SFHP.TBROKER','SFHP.ARMAST.RECOMCOD','=','SFHP.TBROKER.MEMBERID')
                  ->leftJoin('SFHP.CUSTMAST','SFHP.ARMAST.CUSCOD','=','SFHP.CUSTMAST.CUSCOD')
                  ->select('SFHP.ARMAST.*','SFHP.VIEW_CUSTMAIL.*','SFHP.INVTRAN.*','SFHP.VIEW_ARMGAR.NAME','SFHP.VIEW_ARMGAR.NICKNM AS NICKARMGAR',
                           'SFHP.ARMGAR.RELATN','SFHP.VIEW_ARMGAR.ADDRES as ADDARMGAR','SFHP.VIEW_ARMGAR.TUMB as TUMBARMGAR','SFHP.VIEW_ARMGAR.AUMPDES AS AUMARMGAR',
                           'SFHP.VIEW_ARMGAR.PROVDES AS PROARMGAR','SFHP.VIEW_ARMGAR.OFFIC AS OFFICARMGAR','SFHP.VIEW_ARMGAR.TELP AS TELPARMGAR',
                           'SFHP.CUSTMAST.OCCUP','SFHP.CUSTMAST.MEMO1 AS CUSMEMO','SFHP.CUSTMAST.OFFIC AS CUSOFFIC',
                           'SFHP.TBROKER.FNAME','SFHP.TBROKER.LNAME','SFHP.TBROKER.MEMBERID','SFHP.TBROKER.ADDRESS','SFHP.TBROKER.TELP AS TELPTBROKER')
                  ->where('SFHP.ARMAST.CONTNO','=',$SetStrConn)
                  ->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate])
                  ->whereBetween('SFHP.ARMAST.HLDNO',[5.7,6.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $dataArpay = DB::connection('ibmi')
                  ->table('SFHP.ARPAY')
                  ->where('SFHP.ARPAY.CONTNO','=',$SetStrConn)
                  ->sum('SFHP.ARPAY.INTAMT');

        $dataInpay = DB::connection('ibmi')
                  ->table('SFHP.CHQTRAN')
                  ->where('SFHP.CHQTRAN.CONTNO','=',$SetStrConn)
                  ->sum('SFHP.CHQTRAN.PAYINT');

        $SumPay = $dataArpay - $dataInpay;
        $type = $request->type;

        $view = \View::make('precipitate.ReportInvoice' ,compact('data','date','fdate','tdate','type','SumPay'));
        $html = $view->render();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานข้อมูลเตรียมฟ้อง');
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(5, 5, 5, 0);
        $pdf::SetFont('freeserif', '', 10, '', true);
        $pdf::SetAutoPageBreak(TRUE, 25);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('ReportInvoice.pdf');
      }
    }

    public function excel(Request $request)
    {
      if($request->type == 1){  //รายงาน งานประจำวัน
        $newdate = date('Y-m-d');
        $fdate = $newdate;
        $tdate = $newdate;

        if ($request->has('Fromdate')) {
          $fdate = $request->get('Fromdate');

          $new = Carbon::parse($fdate)->addDays(-1);
          $newfdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');

          $new = Carbon::parse($tdate)->addDays(-1);
          $newtdate = \Carbon\Carbon::parse($new)->format('Y') ."-". \Carbon\Carbon::parse($new)->format('m')."-". \Carbon\Carbon::parse($new)->format('d');
        }

        $dataFollow = DB::connection('ibmi') //ปล่อยงานตาม ต้องดึงย้อยหลัง 1 วัน
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->where('SFHP.ARMAST.BILLCOLL','=',99)
                  ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                    return $q->whereBetween('SFHP.ARPAY.DDATE',[$newfdate,$newtdate]);
                  })
                  ->whereBetween('SFHP.ARMAST.HLDNO',[3.00,4.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $dataNotice  = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                    return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                  })
                  ->whereBetween('SFHP.ARMAST.HLDNO',[4.7,5.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $dataPrec  = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                    return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                  })
                  ->whereBetween('SFHP.ARMAST.HLDNO',[3.7,4.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $dataLegis  = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                    return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                  })
                  ->whereBetween('SFHP.ARMAST.HLDNO',[5.7,6.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $Datethai = Helper::formatDateThai($newdate);
        $FDatethai = Helper::formatDateThai($fdate);
        $TDatethai = Helper::formatDateThai($tdate);
        $FnewDatethai = Helper::formatDateThai($newfdate);
        $TnewDatethai = Helper::formatDateThai($newtdate);

         // dd(iconv('Tis-620','utf-8',str_replace(" ","",$ConnData[1]->BAAB)));

         $type = $request->type;

         Excel::create('ปล่อยงานประจำวัน', function ($excel) use($dataFollow,$dataNotice,$dataPrec,$dataLegis,$Datethai,$FDatethai,$TDatethai,$FnewDatethai,$TnewDatethai) {
             $excel->sheet('ปล่อยงานตาม', function ($sheet) use($dataFollow,$Datethai,$FnewDatethai,$TnewDatethai) {
                 $sheet->prependRow(1, array("ดิวงานวันที่ ".$FnewDatethai." ถึงวันที่ ".$TnewDatethai." ปล่อยงานตาม ".$Datethai));
                 $sheet->cells('A2:M2', function($cells) {
                   $cells->setBackground('#FFCC00');
                 });
                 $row = 2;
                 $sheet->row($row, array('ลำดับ','เลขที่สัญญา','ชื่อลูกค้า','วันชำระล่าสุด','ผ่อนงวดละ','งวดค้างชำระ','ค้างงวดจริง','ลูกหนี้คงเหลือ','เลขทะเบียน','ยี่ห้อ','ปีรถ','แบบ','หมายเหตุ'));
                 $no = 1;
                 foreach ($dataFollow as $value) {
                     $NewBaab = iconv('Tis-620','utf-8',str_replace(" ","",$value->BAAB));
                     if ($NewBaab != "") {
                       if ($NewBaab == "กสค้ำมีหลักทรัพย์") {
                          $NewBaab = "กส.ค้ำมีหลักทรัพย์";
                       }elseif ($NewBaab == "กสค้ำไม่มีหลักทรัพย") {
                          $NewBaab = "กส.ค้ำไม่มีหลักทรัพย";
                       }elseif ($NewBaab == "กสไม่ค้ำประกัน") {
                          $NewBaab = "กส.ไม่ค้ำประกัน";
                       }elseif ($NewBaab == "ซขค้ำมีหลักทรัพย์") {
                          $NewBaab = "ซข.ค้ำมีหลักทรัพย์";
                       }elseif ($NewBaab == "ซขค้ำไม่มีหลักทรัพย") {
                          $NewBaab = "ซข.ค้ำไม่มีหลักทรัพย";
                       }elseif ($NewBaab == "ซขไม่ค้ำประกัน") {
                          $NewBaab = "ซข.ไม่ค้ำประกัน";
                       }elseif ($NewBaab == "ลูกค้าVIP1") {
                          $NewBaab = "ลูกค้า VIP1";
                       }else {
                         if ($value->CLOSAR != "") {
                           if ($value->CLOSAR == 1) {
                             $NewBaab = "ซื้อขาย";
                           }elseif ($value->CLOSAR == 2) {
                             $NewBaab = "กรรมสิทธิ์";
                           }elseif ($value->CLOSAR == 3) {
                             $NewBaab = "รถบริษัท";
                           }
                         }
                       }

                     $sheet->row(++$row, array($no++, $value->CONTNO,
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->SNAM.$value->NAME1)."   ".str_replace(" ","",$value->NAME2)),
                     Helper::formatDateThai($value->LPAYD),
                     number_format($value->DAMT,2),
                     number_format($value->EXP_AMT, 2),
                     number_format($value->HLDNO,2),
                     number_format($value->BALANC - $value->SMPAY, 2),
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->REGNO)),
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->TYPE)),
                     $value->MANUYR,
                     $NewBaab,
                     " "));
                   }
                 }
             });

             $excel->sheet('ปล่อยงานโนติส', function ($sheet) use($dataNotice,$Datethai,$FDatethai,$TDatethai) {
                 $sheet->prependRow(1, array("ดิวงานวันที่ ".$FDatethai." ถึงวันที่  ".$TDatethai." ปล่อยงานโนติส ".$Datethai));
                 $sheet->cells('A2:M2', function($cells) {
                   $cells->setBackground('#FFCC00');
                 });
                 $row = 2;
                 $sheet->row($row, array('ลำดับ','เลขที่สัญญา','ชื่อลูกค้า','วันชำระล่าสุด','ผ่อนงวดละ','งวดค้างชำระ','ค้างงวดจริง','ลูกหนี้คงเหลือ','เลขทะเบียน','ยี่ห้อ','ปีรถ','แบบ','หมายเหตุ'));
                 $no = 1;
                 foreach ($dataNotice as $value) {
                     $NewBaab = iconv('Tis-620','utf-8',str_replace(" ","",$value->BAAB));
                     if ($NewBaab != "") {
                       if ($NewBaab == "กสค้ำมีหลักทรัพย์") {
                          $NewBaab = "กส.ค้ำมีหลักทรัพย์";
                       }elseif ($NewBaab == "กสค้ำไม่มีหลักทรัพย") {
                          $NewBaab = "กส.ค้ำไม่มีหลักทรัพย";
                       }elseif ($NewBaab == "กสไม่ค้ำประกัน") {
                          $NewBaab = "กส.ไม่ค้ำประกัน";
                       }elseif ($NewBaab == "ซขค้ำมีหลักทรัพย์") {
                          $NewBaab = "ซข.ค้ำมีหลักทรัพย์";
                       }elseif ($NewBaab == "ซขค้ำไม่มีหลักทรัพย") {
                          $NewBaab = "ซข.ค้ำไม่มีหลักทรัพย";
                       }elseif ($NewBaab == "ซขไม่ค้ำประกัน") {
                          $NewBaab = "ซข.ไม่ค้ำประกัน";
                       }elseif ($NewBaab == "ลูกค้าVIP1") {
                          $NewBaab = "ลูกค้า VIP1";
                       }else {
                         if ($value->CLOSAR != "") {
                           if ($value->CLOSAR == 1) {
                             $NewBaab = "ซื้อขาย";
                           }elseif ($value->CLOSAR == 2) {
                             $NewBaab = "กรรมสิทธิ์";
                           }elseif ($value->CLOSAR == 3) {
                             $NewBaab = "รถบริษัท";
                           }
                         }
                       }

                     $sheet->row(++$row, array($no++, $value->CONTNO,
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->SNAM.$value->NAME1)."   ".str_replace(" ","",$value->NAME2)),
                     Helper::formatDateThai($value->LPAYD),
                     number_format($value->DAMT,2),
                     number_format($value->EXP_AMT, 2),
                     number_format($value->HLDNO,2),
                     number_format($value->BALANC - $value->SMPAY, 2),
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->REGNO)),
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->TYPE)),
                     $value->MANUYR,
                     $NewBaab,
                     " "));
                   }
                 }
             });

             $excel->sheet('ปล่อยงานเร่งรัด', function ($sheet) use($dataPrec,$Datethai,$FDatethai,$TDatethai) {
                 $sheet->prependRow(1, array("ดิวงานวันที่ ".$FDatethai." ถึงวันที่  ".$TDatethai." ปล่อยงานเร่งรัด ".$Datethai));
                 $sheet->cells('A2:M2', function($cells) {
                   $cells->setBackground('#FFCC00');
                 });
                 $row = 2;
                 $sheet->row($row, array('ลำดับ','เลขที่สัญญา','ชื่อลูกค้า','วันชำระล่าสุด','ผ่อนงวดละ','งวดค้างชำระ','ค้างงวดจริง','ลูกหนี้คงเหลือ','เลขทะเบียน','ยี่ห้อ','ปีรถ','แบบ','หมายเหตุ'));
                 $no = 1;
                 foreach ($dataPrec as $value) {
                     $NewBaab = iconv('Tis-620','utf-8',str_replace(" ","",$value->BAAB));
                     if ($NewBaab != "") {
                       if ($NewBaab == "กสค้ำมีหลักทรัพย์") {
                          $NewBaab = "กส.ค้ำมีหลักทรัพย์";
                       }elseif ($NewBaab == "กสค้ำไม่มีหลักทรัพย") {
                          $NewBaab = "กส.ค้ำไม่มีหลักทรัพย";
                       }elseif ($NewBaab == "กสไม่ค้ำประกัน") {
                          $NewBaab = "กส.ไม่ค้ำประกัน";
                       }elseif ($NewBaab == "ซขค้ำมีหลักทรัพย์") {
                          $NewBaab = "ซข.ค้ำมีหลักทรัพย์";
                       }elseif ($NewBaab == "ซขค้ำไม่มีหลักทรัพย") {
                          $NewBaab = "ซข.ค้ำไม่มีหลักทรัพย";
                       }elseif ($NewBaab == "ซขไม่ค้ำประกัน") {
                          $NewBaab = "ซข.ไม่ค้ำประกัน";
                       }elseif ($NewBaab == "ลูกค้าVIP1") {
                          $NewBaab = "ลูกค้า VIP1";
                       }else {
                         if ($value->CLOSAR != "") {
                           if ($value->CLOSAR == 1) {
                             $NewBaab = "ซื้อขาย";
                           }elseif ($value->CLOSAR == 2) {
                             $NewBaab = "กรรมสิทธิ์";
                           }elseif ($value->CLOSAR == 3) {
                             $NewBaab = "รถบริษัท";
                           }
                         }
                       }

                     $sheet->row(++$row, array($no++, $value->CONTNO,
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->SNAM.$value->NAME1)."   ".str_replace(" ","",$value->NAME2)),
                     Helper::formatDateThai($value->LPAYD),
                     number_format($value->DAMT,2),
                     number_format($value->EXP_AMT, 2),
                     number_format($value->HLDNO,2),
                     number_format($value->BALANC - $value->SMPAY, 2),
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->REGNO)),
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->TYPE)),
                     $value->MANUYR,
                     $NewBaab,
                     " "));
                   }
                 }
             });

             $excel->sheet('ปล่อยงานเตรียมฟ้อง', function ($sheet) use($dataLegis,$Datethai,$FDatethai,$TDatethai) {
                 $sheet->prependRow(1, array("ดิวงานวันที่ ".$FDatethai." ถึงวันที่  ".$TDatethai." ปล่อยงานเตรียมฟ้อง ".$Datethai));
                 $sheet->cells('A2:M2', function($cells) {
                   $cells->setBackground('#FFCC00');
                 });
                 $row = 2;
                 $sheet->row($row, array('ลำดับ','เลขที่สัญญา','ชื่อลูกค้า','วันชำระล่าสุด','ผ่อนงวดละ','งวดค้างชำระ','ค้างงวดจริง','ลูกหนี้คงเหลือ','เลขทะเบียน','ยี่ห้อ','ปีรถ','แบบ','หมายเหตุ'));
                 $no = 1;
                 foreach ($dataLegis as $value) {
                     $NewBaab = iconv('Tis-620','utf-8',str_replace(" ","",$value->BAAB));
                     if ($NewBaab != "") {
                       if ($NewBaab == "กสค้ำมีหลักทรัพย์") {
                          $NewBaab = "กส.ค้ำมีหลักทรัพย์";
                       }elseif ($NewBaab == "กสค้ำไม่มีหลักทรัพย") {
                          $NewBaab = "กส.ค้ำไม่มีหลักทรัพย";
                       }elseif ($NewBaab == "กสไม่ค้ำประกัน") {
                          $NewBaab = "กส.ไม่ค้ำประกัน";
                       }elseif ($NewBaab == "ซขค้ำมีหลักทรัพย์") {
                          $NewBaab = "ซข.ค้ำมีหลักทรัพย์";
                       }elseif ($NewBaab == "ซขค้ำไม่มีหลักทรัพย") {
                          $NewBaab = "ซข.ค้ำไม่มีหลักทรัพย";
                       }elseif ($NewBaab == "ซขไม่ค้ำประกัน") {
                          $NewBaab = "ซข.ไม่ค้ำประกัน";
                       }elseif ($NewBaab == "ลูกค้าVIP1") {
                          $NewBaab = "ลูกค้า VIP1";
                       }else {
                         if ($value->CLOSAR != "") {
                           if ($value->CLOSAR == 1) {
                             $NewBaab = "ซื้อขาย";
                           }elseif ($value->CLOSAR == 2) {
                             $NewBaab = "กรรมสิทธิ์";
                           }elseif ($value->CLOSAR == 3) {
                             $NewBaab = "รถบริษัท";
                           }
                         }
                       }

                     $sheet->row(++$row, array($no++, $value->CONTNO,
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->SNAM.$value->NAME1)."   ".str_replace(" ","",$value->NAME2)),
                     Helper::formatDateThai($value->LPAYD),
                     number_format($value->DAMT,2),
                     number_format($value->EXP_AMT, 2),
                     number_format($value->HLDNO,2),
                     number_format($value->BALANC - $value->SMPAY, 2),
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->REGNO)),
                     iconv('Tis-620','utf-8',str_replace(" ","",$value->TYPE)),
                     $value->MANUYR,
                     $NewBaab,
                     " "));
                   }
                 }
             });

         })->export('xlsx');

      }
      elseif($request->type == 2){
      }
      elseif($request->type == 3){ //excel งานแจ้งเตือนติดตาม
        $newdate = date('Y-m-d', strtotime('-1 days'));
        $fdate = $newdate;
        $tdate = $newdate;
        $newDay = substr($newdate, 8, 9);
        $fstart = '1.5';
        $tend = '2.99';
        $followcode = '';

        if ($request->has('Fromdate')) {
          $fdate = $request->get('Fromdate');
          $newDay = substr($fdate, 8, 9);
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
        }
        if ($request->has('Fromstart')) {
          $fstart = $request->get('Fromstart');
        }
        if ($request->has('Toend')) {
          $tend = $request->get('Toend');
        }
        if ($request->has('Followcode')) {
          $followcode = $request->get('Followcode');
        }

        $data1 = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->when(!empty($fstart)  && !empty($tend), function($q) use ($fstart, $tend) {
                    return $q->whereBetween('SFHP.ARMAST.HLDNO',[$fstart,$tend]);
                  })
                  ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                    return $q->whereBetween('SFHP.ARPAY.DDATE',[$fdate,$tdate]);
                  })
                  ->when(!empty($followcode), function($q) use ($followcode) {
                    return $q->where('SFHP.ARMAST.BILLCOLL','=', $followcode);
                  })
                  // ->whereBetween('SFHP.ARMAST.HLDNO',[1.5,2.99])
                  // ->where('SFHP.ARMAST.BILLCOLL','=',99)
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();
        $count = count($data1);
                  for($i=0; $i<$count; $i++){
                    $str[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$data1[$i]->CONTSTAT)));
                    if ($str[$i] == "ท") {
                      $data[] = $data1[$i];
                    }
                  }


        $data2 = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->when(!empty($fstart)  && !empty($tend), function($q) use ($fstart, $tend) {
                    return $q->whereBetween('SFHP.ARMAST.HLDNO',[$fstart,$tend]);
                  })
                  ->when(!empty($followcode), function($q) use ($followcode) {
                    return $q->where('SFHP.ARMAST.BILLCOLL','=', $followcode);
                  })
                  // ->whereBetween('SFHP.ARMAST.HLDNO',[1.5,2.99])
                  // ->where('SFHP.ARMAST.BILLCOLL','=',99)
                  ->when(!empty($newDay), function($q) use ($newDay) {
                    return $q->whereDay('SFHP.ARMAST.FDATE',$newDay);
                  })
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $count = count($data2);
        $data = $data1;

        if($count != 0){
            for ($i=0; $i < $count; $i++) {
              if($data2[$i]->EXP_FRM == $data2[$i]->EXP_TO){
                $data3[] = $data2[$i];
                $data = $data1->concat($data3);
              }
            }
        }else{
          $data = $data1;
        }

        // dd($data);

          $type = $request->type;

          $data_array[] = array('สาขา', 'เลขที่สัญญา', 'รหัสลูกค้า', 'ชื่อลูกค้า', 'ที่อยู่', 'วันที่ขาย', 'วันดิวงวดแรก', 'ราคาขาย',
                          'เงินดาวน์', 'วันชำระล่าสุด', 'สถานะสัญญา', 'ผ่อนงวดละ', 'งวดค้างชำระ', 'รวมชำระแล้ว', 'ค้างจากงวด', 'ค้างถึงงวด',
                          'ชำระล่าสุด', 'ชำระดาวน์', 'พนักงานเก็บเงิน', 'รุ่นรถ', 'สีรถ', 'เลขทะเบียน', 'เลขถัง', 'ค้างดาวน์', 'ค้างเบี้ยปรับ',
                          'ค้างลูกหนี้อื่น', 'ลูกหนี้คงเหลือ', 'ค้างงวด', 'ค้างงวดจริง', 'ผู้ตรวจสอบ', 'เบอร์โทร');
                          foreach($data as $key => $row){
                            $date1 = date_create($row->ISSUDT);
                            $ISSUDT = date_format($date1, 'd-m-Y');

                            $date2 = date_create($row->FDATE);
                            $FDATE = date_format($date2, 'd-m-Y');

                            $date3 = date_create($row->LPAYD);
                            $LPAYD = date_format($date3, 'd-m-Y');

                            $data_array[] = array(
                             'สาขา' => $row->LOCAT,
                             'เลขที่สัญญา' => $row->CONTNO,
                             'รหัสลูกค้า' => $row->CUSCOD,
                             'ชื่อลูกค้า' => iconv('Tis-620','utf-8', str_replace(" ","",$row->SNAM).str_replace(" ","",$row->NAME1).'   '.str_replace(" ","",$row->NAME2)),
                             'ที่อยู่' => iconv('Tis-620','utf-8',str_replace(" ","",$row->ADDRES).' '.str_replace(" ","",$row->TUMB).' '.str_replace(" ","",$row->AUMPDES).' '.str_replace(" ","",$row->PROVDES).' '.str_replace(" ","",$row->AUMPCOD)),
                             'วันที่ขาย' => $ISSUDT,
                             'วันดิวงวดแรก' => $FDATE,
                             'ราคาขาย' => number_format($row->TOTPRC, 2),
                             'เงินดาวน์' => number_format($row->PAYDWN, 2),
                             'วันชำระล่าสุด' => $LPAYD,
                             'สถานะสัญญา' => iconv('Tis-620','utf-8',$row->CONTSTAT),
                             'ผ่อนงวดละ' => number_format($row->T_LUPAY, 2),
                             'งวดค้างชำระ' => number_format($row->EXP_AMT, 2),
                             'รวมชำระแล้ว' => number_format($row->SMPAY, 2),
                             'ค้างจากงวด' => $row->EXP_FRM,
                             'ค้างถึงงวด' => $row->EXP_TO,
                             'ชำระล่าสุด' => number_format($row->LPAYA, 2),
                             'ชำระดาวน์' => number_format($row->PAYDWN, 2),
                             'พนักงานเก็บเงิน' => iconv('TIS-620', 'utf-8', $row->BILLCOLL),
                             'รุ่นรถ' => iconv('TIS-620', 'utf-8', $row->MODEL),
                             'สีรถ' => iconv('TIS-620', 'utf-8', $row->COLOR),
                             'เลขทะเบียน' => iconv('TIS-620', 'utf-8', $row->REGNO),
                             'เลขถัง' => $row->STRNO,
                             'ค้างดาวน์' => '',
                             'ค้างเบี้ยปรับ' => '',
                             'ค้างลูกหนี้อื่น' => '',
                             'ลูกหนี้คงเหลือ' => number_format($row->BALANC - $row->SMPAY, 2),
                             'ค้างงวด' => number_format($row->EXP_PRD, 0),
                             'ค้างงวดจริง' => number_format($row->HLDNO, 2),
                             'ผู้ตรวจสอบ' => $row->CHECKER,
                             'เบอร์โทร' => iconv('Tis-620','utf-8',str_replace("-","", str_replace("/",",",$row->TELP))),
                            );
                          }
                        $data_array = collect($data_array);
                        $excel = Exporter::make('Excel');
                        $excel->load($data_array);

                        return $excel->stream($newDay.'.xlsx');
      }
      elseif($request->type == 4){
      }
      elseif($request->type == 5){ //excel สต๊อกรถเร่งรัด
        $fdate = '';
        $tdate = '';
        $Statuscar = '';
        if ($request->has('Fromdate')) {
          $fdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
        }
        if ($request->has('Statuscar')) {
          $Statuscar = $request->get('Statuscar');
        }
        // dd($fdate,$tdate,$Statuscar);
        if($Statuscar == 7){
          $data = DB::table('holdcars')
          ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
            return $q->whereBetween('holdcars.Date_hold',[$fdate,$tdate]);
          })
          ->whereIn('holdcars.Statuscar', [1, 3])
          ->orderBy('holdcars.Date_hold', 'ASC')
          ->get();
        }
        else{
          $data = DB::table('holdcars')
          ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
            return $q->whereBetween('holdcars.Date_hold',[$fdate,$tdate]);
          })
          ->when(!empty($Statuscar), function($q) use ($Statuscar) {
            return $q->where('holdcars.Statuscar',$Statuscar);
          })
          ->orderBy('holdcars.Date_hold', 'ASC')
          ->get();
        }

        $type = $request->type;

        // dd($data);
        // $data_array[] = array('jhasgdjkgzl;hlkgndklgldk');
        $data_array[] = array('ลำดับ', 'เลขที่สัญญา', 'ชื่อ - สกุล', 'ยี่ห้อ', 'ทะเบียน', 'ปีรถ', 'วันที่ยึด', 'ทีมยึด',
                        'ค่ายึด', 'รายละเอียด', 'วันที่มารับรถคืน', 'ค่างวดยึดค้าง', 'ชำระค่างวดยึด', 'วันที่เช็คต้นทุน', 'วันที่ส่งรถบ้าน', 'วันที่ส่งจดหมาย',
                        'เลขบาร์โค้ด', 'ต้นทุนบัญชี', 'ต้นทุนยอดจัด', 'หมายเหตุ', 'จดหมาย', 'วันส่งจดหมาย', 'บาร์โค้ดผู้ค้ำ', 'รับ', 'ขายได้', 'สถานะ');
                        foreach($data as $key => $row){
                          $date1 = date_create($row->Date_hold);
                          $Date_hold = date_format($date1, 'd-m-Y');

                          $date2 = date_create($row->Date_came);
                          $Date_came = date_format($date2, 'd-m-Y');

                          $date3 = date_create($row->Datecheck_Capital);
                          $Datecheck_Capital = date_format($date3, 'd-m-Y');

                          $date4 = date_create($row->Datesend_Stockhome);
                          $Datesend_Stockhome = date_format($date4, 'd-m-Y');

                          $date5 = date_create($row->Datesend_Letter);
                          $Datesend_Letter = date_format($date5, 'd-m-Y');

                          $date6 = date_create($row->Date_send);
                          $Date_send = date_format($date6, 'd-m-Y');

                          if($row->Statuscar == 1){
                          $Statuscar = 'ยึดจากลูกค้าครั้งแรก';
                          }elseif($row->Statuscar == 2){
                            $Statuscar = 'ลูกค้ามารับรถคืน';
                          }elseif($row->Statuscar == 3){
                            $Statuscar = 'ยึดจากลูกค้าครั้งที่ 2';
                          }elseif($row->Statuscar == 4){
                            $Statuscar = 'รับรถจากของกลาง';
                          }elseif($row->Statuscar == 5){
                            $Statuscar = 'ส่งรถบ้าน';
                          }


                          $data_array[] = array(
                           'ลำดับ' => $key+1,
                           'เลขที่สัญญา' => $row->Contno_hold,
                           'ชื่อ - สกุล' => $row->Name_hold,
                           'ยี่ห้อ' => $row->Brandcar_hold,
                           'ทะเบียน' => $row->Number_Regist,
                           'ปีรถ' => $row->Year_Product,
                           'วันที่ยึด' => $Date_hold,
                           'ทีมยึด' => $row->Team_hold,
                           'ค่ายึด' => $row->Price_hold,
                           'รายละเอียด' => $row->Note_hold,
                           'วันที่มารับรถคืน' => $Date_came,
                           'ค่างวดยึดค้าง' => $row->Amount_hold,
                           'ชำระค่างวดยึด' => $row->Pay_hold,
                           'วันที่เช็คต้นทุน' => $Datecheck_Capital,
                           'วันที่ส่งรถบ้าน' => $Datesend_Stockhome,
                           'วันที่ส่งจดหมาย' => $Datesend_Letter,
                           'เลขบาร์โค้ด' => $row->Barcode_No,
                           'ต้นทุนบัญชี' => $row->Capital_Account,
                           'ต้นทุนยอดจัด' => $row->Capital_Topprice,
                           'หมายเหตุ' => $row->Note2_hold,
                           'จดหมาย' => $row->Letter_hold,
                           'วันส่งจดหมาย' => $Date_send,
                           'บาร์โค้ดผู้ค้ำ' => $row->Barcode2,
                           'รับ' => $row->Accept_hold,
                           'ขายได้' => $row->Soldout_hold,
                           'สถานะ' => $Statuscar,
                          );
                        }
                      $data_array = collect($data_array);
                      $excel = Exporter::make('Excel');
                      $excel->load($data_array);

                      return $excel->stream('StockHoldcar.xlsx');

      }
      elseif($request->type == 9) {
        $date = date('Y-m-d');
        $newdate = $date;

        if ($request->has('SelectDate')) {
          $newdate = $request->get('SelectDate');
        }

        $dataSup = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.VIEW_ARMGAR.CONTNO')
                  ->when(!empty($newdate), function($q) use ($newdate) {
                    return $q->where('SFHP.ARPAY.DDATE',$newdate);
                  })
                  ->whereBetween('SFHP.ARMAST.HLDNO',[2,2.99])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $dataUseSup = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->join('SFHP.VIEW_ARMGAR','SFHP.ARMAST.CONTNO','=','SFHP.VIEW_ARMGAR.CONTNO')
                  ->select('SFHP.ARMAST.*','SFHP.VIEW_CUSTMAIL.*','SFHP.VIEW_ARMGAR.NAME AS NAMEARMGAR','SFHP.VIEW_ARMGAR.ZIP AS ZIPARMGAR')
                  ->when(!empty($newdate), function($q) use ($newdate) {
                    return $q->where('SFHP.ARPAY.DDATE',$newdate);
                  })
                  ->whereBetween('SFHP.ARMAST.HLDNO',[3,4.69])
                  ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                  ->get();

        $Datethai = Helper::formatDateThai($date);
        $NewDatethai = Helper::formatDateThai($newdate);

        // dd($dataUseSup);

         $type = $request->type;

         Excel::create('.ใบรับฝากรวม', function ($excel) use($dataSup,$dataUseSup,$Datethai,$NewDatethai) {
             $excel->sheet('ใบรับฝากผู้ค้ำ 2-2.99', function ($sheet) use($dataSup,$Datethai,$NewDatethai) {
                 $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
                 $sheet->cells('A3:H3', function($cells) {
                   $cells->setBackground('#FFCC00');
                 });
                 $row = 3;
                 $sheet->row($row, array('ชื่อ-นามสกุล','รหัส ปณ.','','','ลงท้าย','เลขที่สัญญา',''));
                 $no = 1;
                 foreach ($dataSup as $value) {
                   if ($value->HLDNO >= 2.00 && $value->HLDNO <= 2.99) {
                     $sheet->row(++$row, array(
                     iconv('Tis-620','utf-8',$value->NAME),
                     $value->ZIP,
                     " ",
                     " ",
                     "TH",
                     $value->CONTNO,
                     " "));
                   }
                 }
             });

             $excel->sheet('ใบรับฝากผู้ซื้อและผู้ค้ำ 3-4.69', function ($sheet) use($dataUseSup,$Datethai,$NewDatethai) {
                 $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
                 $sheet->cells('A3:H3', function($cells) {
                   $cells->setBackground('#FFCC00');
                 });
                 $row = 3;
                 $sheet->row($row, array('ชื่อ-นามสกุล','รหัส ปณ.','','','ลงท้าย','เลขที่สัญญา',''));
                 $no = 1;
                 foreach ($dataUseSup as $val) {
                   if ($val->HLDNO >= 3.00 && $val->HLDNO <= 4.69) {
                     $sheet->row(++$row, array(
                     iconv('Tis-620','utf-8',str_replace(" ","",$val->SNAM.$val->NAME1)."   ".str_replace(" ","",$val->NAME2)),
                     $val->ZIP,
                     " ",
                     " ",
                     "TH",
                     $val->CONTNO,
                     " "));
                     if ($val->NAMEARMGAR != "") {
                       $sheet->row(++$row, array(
                       iconv('Tis-620','utf-8',$val->NAMEARMGAR),
                       $val->ZIPARMGAR,
                       " ",
                       " ",
                       "TH",
                       $val->CONTNO,
                       " "));
                     }
                   }
                 }
             });

         })->export('xlsx');
      }
    }

}
