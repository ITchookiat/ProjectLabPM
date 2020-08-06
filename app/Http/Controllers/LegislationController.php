<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Storage;
use Carbon\Carbon;
use Exporter;
use Excel;
use Helper;

use App\Legislation;
use App\Legiscourt;
use App\Legiscourtcase;
use App\LegisImage;
use App\Legiscompromise;
use App\legispayment;
use App\legisasset;
use App\Legisexhibit;
use App\Legisland;

class LegislationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // ข้อมูลฟ้องจาก ตารางปกติ
      $data = DB::connection('ibmi')
            ->table('SFHP.ARMAST')
            ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
            ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
            ->whereBetween('SFHP.ARMAST.HLDNO',[6.7,99.99])
            ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
            ->get();
      $count = count($data);

      for($i=0; $i<$count; $i++){
        $str[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$data[$i]->CONTSTAT)));
        if ($str[$i] == "ฟ") {
          $result[] = $data[$i];
        }
      }

      $Countresult1 = count($result);

      if($request->type == 1) {        //รายชื่อส่งฟ้อง
        $dataAro = DB::connection('ibmi')
                ->table('SFHP.ARMAST')
                ->join('SFHP.AROTHGAR','SFHP.ARMAST.CONTNO','=','SFHP.AROTHGAR.CONTNO')
                ->whereBetween('SFHP.ARMAST.HLDNO',[6.7,99.99])
                ->orderBy('SFHP.ARMAST.CONTNO', 'ASC')
                ->get();

        $count2 = count($dataAro);
        for($j=0; $j<$count2; $j++){
          $str2[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$dataAro[$j]->CONTSTAT)));
          if ($str2[$j] == "ฟ") {
            $result2[] = $dataAro[$j];
          }
        }

        $dataSMT = DB::connection('ibmi')
                ->table('ASFHP.ARMAST')
                ->join('ASFHP.INVTRAN','ASFHP.ARMAST.CONTNO','=','ASFHP.INVTRAN.CONTNO')
                ->join('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
                ->orderBy('ASFHP.ARMAST.CONTNO', 'ASC')
                ->get();

        $count3 = count($dataSMT);
        for($j=0; $j<$count3; $j++){
          $str3[] = (iconv('TIS-620', 'utf-8', str_replace(" ","",$dataSMT[$j]->CONTSTAT)));
          if ($str3[$j] == "ป") {
            $result3[] = $dataSMT[$j];
          }
        }
        $arrayMerge = array_merge($result, $result3);

        $dataDB = DB::table('legislations')
                  ->orderBy('Contract_legis', 'ASC')
                  ->get();
        $type = $request->type;
        return view('legislation.view', compact('type','data','result','dataDB','result2','arrayMerge'));

      }
      elseif ($request->type == 2) {   //งานฟ้อง
        $newfdate = '';
        $newtdate = '';
        $StateCourt = '';
        $StateLegis = '';

        if ($request->has('Fromdate')){
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')){
          $newtdate = $request->get('Todate');
        }
        if ($request->get('StateCourt')){
          $StateCourt = $request->get('StateCourt');
        }
        if ($request->get('StateLegis')){
          $StateLegis = $request->get('StateLegis');
        }

        $data = DB::table('legislations')
                  ->leftJoin('Legiscourtcases','legislations.id','=','Legiscourtcases.legislation_id')
                  ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                  ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                    return $q->whereBetween('legislations.Datesend_Flag',[$newfdate,$newtdate]);
                  })
                  ->where('legislations.Flag_status','=', '2')
                  ->orderBy('legislations.id', 'DESC')
                  ->get();

        $dataPay = DB::table('legislations')
               ->join('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
               ->join('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
               ->where('legispayments.Flag_Payment', '=', 'Y')
               ->get();

               // dd($dataPay);

        if ($StateCourt == "ชั้นศาล") {
          $data = DB::table('legislations')
                ->leftJoin('Legiscourtcases','legislations.id','=','Legiscourtcases.legislation_id')
                ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legislations.Datesend_Flag',[$newfdate,$newtdate]);
                })
                ->where('legiscourts.fillingdate_court','!=', Null)
                ->orderBy('legislations.id', 'DESC')
                ->get();
        }
        elseif ($StateCourt == "ชั้นบังคับคดี") {
          $data = DB::table('legislations')
                ->leftJoin('Legiscourtcases','legislations.id','=','Legiscourtcases.legislation_id')
                ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legislations.Datesend_Flag',[$newfdate,$newtdate]);
                })
                ->where('Legiscourtcases.datepreparedoc_case','!=', Null)
                ->orderBy('legislations.id', 'DESC')
                ->get();
        }
        elseif ($StateLegis != Null) {
          $data = DB::table('legislations')
                ->leftJoin('Legiscourtcases','legislations.id','=','Legiscourtcases.legislation_id')
                ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legislations.Datesend_Flag',[$newfdate,$newtdate]);
                })
                ->when(!empty($StateLegis), function($q) use($StateLegis){
                  return $q->where('legislations.Status_legis',$StateLegis);
                })
                ->orderBy('legislations.id', 'DESC')
                ->get();
        }

        // dd($data);
        $type = $request->type;
        return view('legislation.view', compact('type', 'data','result','dataPay','newfdate','newtdate','StateCourt','StateLegis'));
      }
      elseif ($request->type == 6) {   //ลูกหนี้เตรียมฟ้อง
        $data = DB::table('legislations')
                  ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->where('legislations.Flag_status','!=', '3')
                  ->orderBy('legislations.id', 'DESC')
                  ->get();

        $type = $request->type;
        return view('legislation.view', compact('type', 'data','result'));
      }
      elseif ($request->type == 7) {   //งานประนอมหนี้
        $lastday = date('Y-m-d', strtotime("-90 days"));
        $newfdate = '';
        $newtdate = '';
        $status = '';

        if ($request->has('Fromdate')) {
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $newtdate = $request->get('Todate');
        }
        if ($request->has('status')) {
          $status = $request->get('status');
        }

        $data = DB::table('legislations')
                ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->where('legislations.Flag_status','!=', '1')
                ->where('Legiscompromises.Date_Promise','!=', null)
                ->orderBy('legislations.Contract_legis', 'ASC')
                ->get();

        // $dataPay = DB::table('legislations')
        //         ->join('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
        //         ->join('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
        //         ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
        //           return $q->whereBetween('legispayments.Date_Payment',[$newfdate,$newtdate]);
        //         })
        //         ->where('legispayments.Flag_Payment', '=', 'Y')
        //         ->get();

        $dataPay = DB::table('legislations')
                ->join('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                ->join('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->select('legislations.*','legispayments.*','Legiscompromises.*','legispayments.created_at AS CPayments_at')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legispayments.Date_Payment',[$newfdate,$newtdate]);
                })
                ->where('legispayments.Flag_Payment', '=', 'Y')
                ->get();

        if($status == "ชำระปกติ"){
          $data = DB::table('legislations')
                ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftjoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                ->select('legislations.*','legiscourts.*','legispayments.*','Legiscompromises.*','legispayments.created_at AS CPayments_at')
                ->where('legislations.Flag_status','!=', '1')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legispayments.Date_Payment',[$newfdate,$newtdate]);
                })
                ->when(!empty($status), function($q) use($lastday){
                    return $q->where('legispayments.Date_Payment','>=',$lastday);
                  })
                ->where('legispayments.Flag_Payment', '=', 'Y')
                ->where('legislations.Status_legis','=', Null)
                ->orderBy('legislations.Contract_legis', 'ASC')
                ->get();

        }
        elseif($status == "ขาดชำระ"){
          $data = DB::table('legislations')
                ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftjoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                ->select('legislations.*','legiscourts.*','legispayments.*','Legiscompromises.*','legispayments.created_at AS CPayments_at')
                ->where('legislations.Flag_status','!=', '1')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legispayments.Date_Payment',[$newfdate,$newtdate]);
                })
                ->when(!empty($status), function($q) use($lastday){
                    return $q->where('legispayments.Date_Payment','<',$lastday);
                  })
                ->where('legispayments.Flag_Payment', '=', 'Y')
                ->get();
        }
        elseif($status == "ปิดบัญชี"){
          $data = DB::table('legislations')
                ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->where('legislations.Flag_status','!=', '1')
                ->where('legislations.Status_legis','=', 'ปิดบัญชีประนอมหนี้')
                ->orderBy('legislations.Contract_legis', 'ASC')
                ->get();
        }

        $type = $request->type;
        return view('legislation.view', compact('type', 'data','result','newfdate','newtdate','status','dataPay'));
      }
      elseif ($request->type == 8) {   //สืบทรัพย์
        $newfdate = '';
        $newtdate = '';
        $Newstatus = '';
        $Newstat2 = '';
        $SetSelect = '';

        if ($request->has('Fromdate')){
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $newtdate = $request->get('Todate');
        }
        if ($request->get('status') == "หมดอายุความ"){
          $Newstat2 = $request->get('status');
        }elseif ($request->get('status') == "จบงานสืบทรัพย์"){
          $Newstat2 = $request->get('status');
        }else {
          $Newstatus = $request->get('status');
        }

        if ($request->has('Fromdate') == false and $request->has('Todate') == false) {
          $data = DB::table('legislations')
                    ->join('legisassets','legislations.id','=','legisassets.legisAsset_id')
                    ->orderBy('legisassets.legisAsset_id', 'ASC')
                    ->get();
        }else {
          $data = DB::table('legislations')
                    ->join('legisassets','legislations.id','=','legisassets.legisAsset_id')
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                      return $q->whereBetween('legisassets.Date_asset',[$newfdate,$newtdate]);
                    })
                    ->when(!empty($Newstatus), function($q) use($Newstatus){
                      return $q->where('legisassets.propertied_asset',$Newstatus);
                    })
                    ->when(!empty($Newstat2), function($q) use($Newstat2){
                      return $q->where('legisassets.sendsequester_asset',$Newstat2);
                    })
                    ->orderBy('legisassets.legisAsset_id', 'ASC')
                    ->get();
        }
        // dd($data);
        if ($Newstatus != Null) {
          $SetSelect = $Newstatus;
        }elseif ($Newstat2 != Null) {
          $SetSelect = $Newstat2;
        }

        $type = $request->type;
        return view('legislation.view', compact('type', 'data','result','newfdate','newtdate','SetSelect'));
      }
      elseif ($request->type == 10) {   //ของกลาง
        $fdate = '';
        $tdate = '';
        $terminateexhibit = '';
        $typeexhibit = '';
        if ($request->has('Fromdate')){
          $fdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
        }
        if ($request->has('TerminateExhibit')){
          $terminateexhibit = $request->get('TerminateExhibit');
        }
        if ($request->has('Typeexhibit')) {
          $typeexhibit = $request->get('Typeexhibit');
        }
        $data = DB::table('legisexhibits')
                  ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                    return $q->whereBetween('Dateaccept_legis',[$fdate,$tdate]);
                  })
                  ->when(!empty($terminateexhibit), function($q) use($terminateexhibit){
                    return $q->where('Terminate_legis',$terminateexhibit);
                  })
                  ->when(!empty($typeexhibit), function($q) use($typeexhibit){
                    return $q->where('Typeexhibit_legis',$typeexhibit);
                  })
                  ->get();
        $type = $request->type;
        return view('legislation.view', compact('type','data','fdate','tdate','terminateexhibit','typeexhibit'));
      }
      elseif ($request->type == 11) {   //หน้าเพิ่มข้อมูลใหม่ของกลาง
        $type = $request->type;
        return view('legislation.createexhibit',compact('type'));
      }
      elseif ($request->type == 12) {   //ขายฝาก
        $dataLand = DB::table('legislands')
                  ->orderBy('ContractNo_legis', 'ASC')
                  ->get();
        $type = $request->type;
        return view('legislation.view', compact('type','dataLand'));
      }
      elseif ($request->type == 9 or $request->type == 15 or $request->type == 16) {   //รายงานประนอมหนี้
        $type = $request->type;
        return view('legislation.viewReport',compact('type'));
      }
      elseif ($request->type == 17 or $request->type == 18) {   //รายงานลูกหนี้ฟ้อง
        $type = $request->type;
        return view('legislation.viewReport',compact('type'));
      }
      elseif ($request->type == 19) {   //รายงานลูกหนี้สืบทรัพย์
        $type = $request->type;
        return view('legislation.viewReport',compact('type'));
      }
      elseif ($request->type == 20) {   //รายงานตรวจสอบยอดชำระ
        $dataDB = DB::table('users')
                  ->whereBetween('users.branch',[31,42])
                  ->get();
        $type = $request->type;
        return view('legislation.viewReport',compact('type','dataDB'));
      }
      elseif ($request->type == 100) {   //Dashboard
        $dataprepare = DB::table('legislations')
                  ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->where('legislations.Flag_status','=', '1')
                  ->orderBy('legislations.id', 'DESC')
                  ->count();
        $dataprepareDone = DB::table('legislations')
                  ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->where('legislations.Flag_status','=', '2')
                  ->orderBy('legislations.id', 'DESC')
                  ->count();

        $datalegis = DB::table('legislations')
                  ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->where('legislations.Flag_status','=', '2')
                  ->whereNull('legiscourts.fillingdate_court')
                  ->orderBy('legislations.id', 'DESC')
                  ->count();
        $datalegisDone = DB::table('legislations')
                  ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->where('legislations.Flag_status','=', '2')
                  ->whereNotNull('legiscourts.fillingdate_court')
                  ->orderBy('legislations.id', 'DESC')
                  ->count();

        $lastday = date('Y-m-d', strtotime("-90 days"));
        $dataPaymentAll = DB::table('Legiscompromises')->count();
        $dataPayment = DB::table('legislations')
                  ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->leftjoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                  ->where('legislations.Flag_status','!=', '1')
                  ->where('legispayments.Date_Payment','>=',$lastday)
                  ->where('legispayments.Flag_Payment', '=', 'Y')
                  ->where('legislations.Status_legis','=', Null)
                  ->orderBy('legislations.Contract_legis', 'ASC')
                  ->count();
        $dataPaymentDone = DB::table('legislations')
                  ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->leftjoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                  ->where('legislations.Flag_status','!=', '1')
                  ->where('legispayments.Date_Payment','<',$lastday)
                  ->where('legispayments.Flag_Payment', '=', 'Y')
                  ->where('legislations.Status_legis','=', Null)
                  ->orderBy('legislations.Contract_legis', 'ASC')
                  ->count();
        $type = $request->type;
        return view('legislation.view',compact('type','dataprepare','dataprepareDone','datalegis','datalegisDone','dataPaymentAll','dataPayment','dataPaymentDone'));
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
    public function store(Request $request, $id, $type)
    {
      $SetGoldPay = str_replace (",","",$request->get('GoldPayment'));

      if ($type == 2) { //ฟ้อง (กรณีปิดบัญชี)
        $SetContract = $request->ContractNo;
        $SetPriceAcc = str_replace(",","", $request->PriceAccount);
        $SetTopCloseAcc = str_replace(",","", $request->TopCloseAccount);
        $SetTDiscountAcc = str_replace(",","", $request->DiscountAccount);

        $user = Legislation::find($id);
          $user->DateStatus_legis = $request->DateCloseAccount;
          $user->PriceStatus_legis = $SetPriceAcc;
          $user->txtStatus_legis = $SetTopCloseAcc;
          $user->Discount_legis = $SetTDiscountAcc;
        $user->update();

        $data = DB::connection('ibmi')
              ->table('SFHP.ARMAST')
              ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
              ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
              ->where('SFHP.ARMAST.CONTNO','=', $request->ContractNo)
              ->first();

        $dataDB = DB::table('legislations')
              ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
              ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
              ->where('legislations.id','=', $id)
              ->first();

        $type = 3; //เปลี่ยนเป็นเบอร์ 3 เพื่อสงไปยังหน้าพิมพ์ใบเสร็จ เพราะมี เบอร์ 1,2 อยู่แล้ว
        $view = \View::make('legislation.reportCompro' ,compact('data','user','type','dataDB'));
        $html = $view->render();

        $pdf = new PDF();
        $pdf::SetTitle('ใบเสร็จปิดบัญชี');
        $pdf::AddPage('L', 'A5');
        $pdf::SetMargins(16, 5, 5, 5);
        $pdf::SetFont('freeserif', '', 11, '', true);
        $pdf::SetAutoPageBreak(TRUE, 5);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');
      }
      if ($type == 5) { //เพิ่มข้อมูลชำระ
        $Payment = legispayment ::find($id);
          if ($Payment != Null) {
            DB::table('legispayments')
              ->where('legis_Com_Payment_id', $id)
              ->update([
                  'Flag_Payment' => 'N'
              ]);
          }

        $GetNumPeriod = DB::table('legispayments')
                ->where('legis_Com_Payment_id', $id)
                ->orderBy('Period_Payment', 'desc')->limit(1)
                ->first();

        $connect = DB::table('legispayments')
                ->orderBy('Jobnumber_Payment', 'desc')->limit(1)
                ->get();
        $connectCon = count($connect);

        if ($connectCon != 0) {
          $GetJob = $connect[0]->Jobnumber_Payment;
          $SetStr = explode("-",$GetJob);
          $SetJobNumber = $SetStr[1] + 1;

          // ดึงปีและเดือนปัจจุบัน
          $SetNumDate = substr($SetStr[1],0,2);
          $Day = date('Y');
          $SubDay = substr($Day,2);
          $month = date('m');

          $num = "1000";
          $SubStr = substr($num.$SetJobNumber, -4);
          if ($SetNumDate == $SubDay) {
            $StrConn = $SetStr[0]."-".$SubDay."".$month."".$SubStr;
          }else {
            $StrConn = $SetStr[0]."-".$SubDay."".$month."0001";
          }

          // จำนวนงวด
          if ($GetNumPeriod != Null) {
            $Period = $GetNumPeriod->Period_Payment;
            $SetPeriod = $Period + 1;
          }else {
            $SetPeriod = 1;
          }

        }else {
          $Day = date('Y');
          $SubDay = substr($Day,2);
          $month = date('m');

          $StrConn = "ABL"."-".$SubDay."".$month."0001";
          $SetPeriod = 1;
        }

        $LegisPay = new legispayment([
          'legis_Com_Payment_id' => $id,
          'Date_Payment' => $request->get('DatePayment'),
          'Gold_Payment' =>  $SetGoldPay,
          'Type_Payment' =>  $request->get('TypePayment'),
          'Adduser_Payment' =>  $request->get('AdduserPayment'),
          'Note_Payment' =>  $request->get('NotePayment'),
          'Flag_Payment' =>  $request->get('FlagPayment'),
          'Jobnumber_Payment' => $StrConn,
          'Period_Payment' => $SetPeriod,
        ]);
        $LegisPay->save();

        $dataSum = DB::table('legispayments')
                ->join('Legiscompromises','legispayments.legis_Com_Payment_id','=','Legiscompromises.legisPromise_id')
                ->where('legis_Com_Payment_id','=', $id)
                ->get();
        $countdataSum = count($dataSum);
        if($countdataSum != 0){
          foreach ($dataSum as $key => $value) {
              @$sum += $value->Gold_Payment;
          }
        }else{
          $sum = 0;
        }

        $Legiscom = Legiscompromise ::find($id);
          $Legiscom->KeyPay_id = $id;
          $Legiscom->Sum_Promise = $dataSum[0]->Total_Promise - $sum;
        $Legiscom->update();

        $type = 4;

        // return redirect()->back()->with(['id' => $id,'type' => $type,'success' => 'บันทึกข้อมูลเรียบร้อย']);
        return redirect()->Route('legislation.edit',[$id,$type])->with(['success'=>'รับเรื่องเรียบร้อย']);
      }
      if ($type == 11){ //เพิ่มข้อของกลาง
        $Dateresult = NULL;
        if($request->get('DategetResult1') != Null){
          $Dateresult = $request->get('DategetResult1');
        }
        if($request->get('DategetResult2') != Null){
          $Dateresult = $request->get('DategetResult2');
        }
        $LegisExhibit = new Legisexhibit([
          'Contract_legis' => $request->get('ContractNo'),
          'Dateaccept_legis' => $request->get('DateExhibit'),
          'Name_legis' =>  $request->get('NameContract'),
          'Policestation_legis' =>  $request->get('PoliceStation'),
          'Suspect_legis' =>  $request->get('NameSuspect'),
          'Plaint_legis' =>  $request->get('PlaintExhibit'),
          'Inquiryofficial_legis' =>  $request->get('InquiryOfficial'),
          'Inquiryofficialtel_legis' =>  $request->get('InquiryOfficialtel'),
          'Terminate_legis' =>  $request->get('TerminateExhibit'),
          'DateLawyersend_legis' =>  $request->get('DateLawyersend'),
          'Typeexhibit_legis' =>  $request->get('TypeExhibit'),
          'Currentstatus_legis' =>  $request->get('Currentstatus'),
          'Nextstatus_legis' =>  $request->get('Nextstatus'),
          'Noteexhibit_legis' =>  $request->get('NoteExhibit'),
          'Dategiveword_legis' =>  $request->get('DateGiveword'),
          'Typegiveword_legis' =>  $request->get('TypeGiveword'),
          'Datepreparedoc_legis' =>  $request->get('DatePreparedoc'),
          'Dateinvestigate_legis' =>  $request->get('DateInvestigate'),
          'Datecheckexhibit_legis' =>  $request->get('DateCheckexhibit'),
          'Datesendword_legis' =>  $request->get('DateSendword'),
          'Resultexhibit1_legis' =>  $request->get('ResultExhibit1'),
          'Processexhibit1_legis' =>  $request->get('ProcessExhibit1'),
          'Datesenddetail_legis' =>  $request->get('DateSenddetail'),
          'Resultexhibit2_legis' =>  $request->get('ResultExhibit2'),
          'Processexhibit1_legis' =>  $request->get('ProcessExhibit2'),
          'Dategetresult_legis' =>  $Dateresult,
        ]);
        // dd($LegisExhibit);
        $LegisExhibit->save();
        $type = 10;
        return redirect()->Route('legislation',$type)->with('success','บันทึกข้อมูลเรียบร้อย');
      }
    }

    public function Savestore(Request $request, $SetStr1, $SetStr2, $SetRealty, $type)
    {
      date_default_timezone_set('Asia/Bangkok');
      $Y = date('Y');
      $m = date('m');
      $d = date('d');
      $date = $Y.'-'.$m.'-'.$d;
      
      
      if ($type == 1) {       //ลูกหนี้ปกติ
        $SetStrConn = $SetStr1."/".$SetStr2;
        $data = DB::connection('ibmi')
        ->table('SFHP.ARMAST')
        ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
        ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
        ->where('SFHP.ARMAST.CONTNO','=', $SetStrConn)
        ->first();

        $dataGT = DB::connection('ibmi')
                  ->table('SFHP.VIEW_ARMGAR')
                  ->where('SFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
                  ->first();

        if ($dataGT == Null) {
          $SetGTName = Null;
          $SetGTIDNO = Null;
          $SetGTAddress = Null;
        }else {
          $SetGTName = (iconv('Tis-620','utf-8',$dataGT->NAME));
          $SetGTIDNO = (str_replace(" ","",$dataGT->IDNO));
          $SetGTAddress = (iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->ADDRES))." ต.".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->TUMB))." อ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->AUMPDES))." จ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->PROVDES))."  ".iconv('TIS-620', 'utf-8', str_replace(" ","",$dataGT->ZIP)));
        }

        $LegisDB = new Legislation([
          'Date_legis' => $date,
          'KeyCourts_id' => Null,
          'KeyCompro_id' => Null,
          'Contract_legis' => $data->CONTNO,
          'Name_legis' => (iconv('TIS-620', 'utf-8', str_replace(" ","",$data->SNAM)." ".str_replace(" ","",$data->NAME1)."  ".str_replace(" ","",$data->NAME2))),
          'Idcard_legis' => (str_replace(" ","",$data->IDNO)),
          'Address_legis' => (iconv('TIS-620', 'utf-8', str_replace(" ","",$data->ADDRES))." ต.".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->TUMB))." อ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->AUMPDES))." จ.".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->PROVDES))."  ".iconv('TIS-620', 'utf-8', str_replace(" ","",$data->ZIP))),
          'BrandCar_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->TYPE))),
          'register_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->REGNO))),
          'YearCar_legis' => $data->MANUYR,
          'Category_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->BAAB))),
          'DateDue_legis' => $data->FDATE,
          'Pay_legis' => $data->NCARCST,
          'DateVAT_legis' => $data->DTSTOPV,
          'NameGT_legis' => $SetGTName,
          'IdcardGT_legis' => $SetGTIDNO,
          'AddressGT_legis' => $SetGTAddress,
          'Realty_legis' => $SetRealty,

          'Mile_legis' => $data->MILERT,
          'Period_legis' => $data->TOT_UPAY,
          'Countperiod_legis' => $data->T_NOPAY,
          'Beforeperiod_legis' => $data->EXP_FRM,
          'Beforemoey_legis' => $data->SMPAY,
          'Remainperiod_legis' => $data->EXP_TO,
          'Staleperiod_legis' => $data->EXP_PRD, //ค้าง
          'Realperiod_legis' => $data->HLDNO, //ค้างงวดจริง
          'Sumperiod_legis' => $data->BALANC - $data->SMPAY,
          'Flag' => 'Y',
          'Phone_legis' => (iconv('Tis-620','utf-8',$data->TELP)),
          'Flag_status' => '1',
          'UserSend1_legis' => auth()->user()->name,
        ]);
        $LegisDB->save();
        $tab = 1;
        return redirect()->Route('legislation', $type)->with(['tab'=>$tab,'success'=>'รับเรื่องเรียบร้อย']);
      }
      elseif ($type == 2) {   //ลูกหนี้ประนอม
        $SetStrConn = $SetStr1."/".$SetStr2;
        $data = DB::connection('ibmi')
                  ->table('ASFHP.ARMAST')
                  ->join('ASFHP.INVTRAN','ASFHP.ARMAST.CONTNO','=','ASFHP.INVTRAN.CONTNO')
                  ->join('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->where('ASFHP.ARMAST.CONTNO','=', $SetStrConn)
                  ->first();

                  // dd($data);

        $dataGT = DB::connection('ibmi')
                  ->table('ASFHP.VIEW_ARMGAR')
                  ->where('ASFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
                  ->first();

        if ($dataGT == Null) {
          $SetGTName = Null;
          $SetGTIDNO = Null;
        }else {
          $SetGTName = (iconv('Tis-620','utf-8',$dataGT->NAME));
          $SetGTIDNO = (str_replace(" ","",$dataGT->IDNO));
        }

        $LegisDB = new Legislation([
          'Date_legis' => $date,
          'KeyCourts_id' => Null,
          'KeyCompro_id' => Null,
          'Contract_legis' => $data->CONTNO,
          'Name_legis' => (iconv('TIS-620', 'utf-8', str_replace(" ","",$data->SNAM)." ".str_replace(" ","",$data->NAME1)."  ".str_replace(" ","",$data->NAME2))),
          'Idcard_legis' => (str_replace(" ","",$data->IDNO)),
          'BrandCar_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->TYPE))),
          'register_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->REGNO))),
          'YearCar_legis' => $data->MANUYR,
          'Category_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->BAAB))),
          'DateDue_legis' => $data->FDATE,
          'Pay_legis' => $data->NCARCST,
          'DateVAT_legis' => $data->DTSTOPV,
          'NameGT_legis' => $SetGTName,
          'IdcardGT_legis' => $SetGTIDNO,
          'Realty_legis' => $SetRealty,

          'Mile_legis' => $data->MILERT,
          'Period_legis' => $data->TOT_UPAY,
          'Countperiod_legis' => $data->T_NOPAY,
          'Beforeperiod_legis' => $data->EXP_FRM,
          'Beforemoey_legis' => $data->SMPAY,
          'Remainperiod_legis' => $data->EXP_TO,
          'Staleperiod_legis' => $data->EXP_PRD, //ค้าง
          'Realperiod_legis' => $data->HLDNO, //ค้างงวดจริง
          'Sumperiod_legis' => $data->BALANC - $data->SMPAY,
          'Flag' => 'C',
          'Phone_legis' => (iconv('Tis-620','utf-8',$data->TELP)),
          'Flag_status' => '3',
          'UserSend1_legis' => auth()->user()->name,

        ]);
        $LegisDB->save();

        $LegisPromise = new Legiscompromise([
          'Date_Promise' => $date,
          'legisPromise_id' => $LegisDB->id,
          'KeyPay_id' => Null,
          'Flag_Promise' => Null,
          'Total_Promise' => Null,
          'Type_Promise' =>  Null,
          'DateNsale_Promise' =>  Null,
          'Dateset_Promise' =>  Null,
          'Payall_Promise' =>  Null,
          'Sum_Promise' =>  Null,
          'Discount_Promise' =>  Null,
          'Due_Promise' =>  Null,
          'DuePay_Promise' =>  Null,
          'Datelast_Promise' =>  Null,
          'SumAll_Promise' =>  Null,
          'Note_Promise' =>  Null,
        ]);
        $LegisPromise->save();

        $Legislation = Legislation::find($LegisDB->id);
          $Legislation->KeyCompro_id = $LegisPromise->legisPromise_id;
        $Legislation->update();

        $type = 1;
        return redirect()->Route('legislation', $type)->with('success','รับเรื่องเรียบร้อย');
      }
      elseif ($type == 3) {  //ลูกหนี้ขายฝาก
        $SetStrConn = $SetStr1."/".$SetStr2;
        $data = DB::connection('ibmi')
                  ->table('LSFHP.ARMAST')
                  ->join('LSFHP.INVTRAN','LSFHP.ARMAST.CONTNO','=','LSFHP.INVTRAN.CONTNO')
                  ->join('LSFHP.VIEW_CUSTMAIL','LSFHP.ARMAST.CUSCOD','=','LSFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->where('LSFHP.ARMAST.CONTNO','=', $SetStrConn)
                  ->first();
        $dataGT = DB::connection('ibmi')
                  ->table('LSFHP.VIEW_ARMGAR')
                  ->where('LSFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
                  ->first();

        if ($dataGT == Null) {
          $SetGTName = Null;
          $SetGTIDNO = Null;
        }else {
          $SetGTName = (iconv('Tis-620','utf-8',$dataGT->NAME));
          $SetGTIDNO = (str_replace(" ","",$dataGT->IDNO));
        }

        $LegisLand = new Legisland([
          'Date_legis' => $date,
          'ContractNo_legis' => $data->CONTNO,
          'Name_legis' => (iconv('TIS-620', 'utf-8', str_replace(" ","",$data->SNAM).str_replace(" ","",$data->NAME1)."  ".str_replace(" ","",$data->NAME2))),
          'Idcard_legis' => (str_replace(" ","",$data->IDNO)),
          'BrandCar_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->TYPE))),
          'register_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->REGNO))),
          'YearCar_legis' => $data->MANUYR,
          'Category_legis' => (iconv('Tis-620','utf-8',str_replace(" ","",$data->BAAB))),
          'DateDue_legis' => $data->SDATE,
          'Pay_legis' => $data->NCARCST,
          'DateVAT_legis' => $data->DTSTOPV,
          'NameGT_legis' => $SetGTName,
          'IdcardGT_legis' => $SetGTIDNO,
          'Realty_legis' => $SetRealty,
          'Period_legis' => $data->TOT_UPAY,
          'Countperiod_legis' => $data->T_NOPAY,
          'Beforeperiod_legis' => $data->EXP_FRM,
          'Beforemoney_legis' => $data->SMPAY,
          'Sumperiod_legis' => $data->BALANC - $data->SMPAY,
          'Remainperiod_legis' => $data->EXP_TO,
          'Staleperiod_legis' => $data->EXP_PRD, //ค้าง
          'Realperiod_legis' => $data->HLDNO, //ค้างงวดจริง
          'StatusContract_legis' => (iconv('Tis-620','utf-8',$data->CONTSTAT)),
          'Flag' => 'Y',
        ]);
        $LegisLand->save();
        $tab = 2;
        $type = 1;
        return redirect()->Route('legislation', $type)->with(['tab' => $tab , 'success' => '่ส่งดำเนินเรื่องเรียบร้อย']);
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
    public function edit($id, $type)
    {

      if ($type == 2) {     //ข้อมูลผู้เช่าซื้อ
        $data = DB::table('legislations')
              ->where('legislations.id',$id)->first();

        $StrCon = explode("/",$data->Contract_legis);
        $SetStr1 = $StrCon[0];
        $SetStr2 = $StrCon[1];
        $SetStrConn = $SetStr1."/".$SetStr2;

        if ($data->Flag == "C") {
          $data1 = DB::connection('ibmi')
                ->table('ASFHP.ARMAST')
                ->join('ASFHP.INVTRAN','ASFHP.ARMAST.CONTNO','=','ASFHP.INVTRAN.CONTNO')
                ->join('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
                ->where('ASFHP.ARMAST.CONTNO','=', $SetStrConn)
                ->first();

          $dataGT = DB::connection('ibmi')
                ->table('SFHP.VIEW_ARMGAR')
                ->where('SFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
                ->first();

        }else {
          $data1 = DB::connection('ibmi')
                ->table('SFHP.ARMAST')
                ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                ->where('SFHP.ARMAST.CONTNO','=', $SetStrConn)
                ->first();

          $dataGT = DB::connection('ibmi')
                ->table('SFHP.VIEW_ARMGAR')
                ->where('SFHP.VIEW_ARMGAR.CONTNO','=', $SetStrConn)
                ->first();
        }

        return view('legislation.edit',compact('data','data1','dataGT','id','type'));
      }
      elseif ($type == 3){  //ชั้นศาล
        $data = DB::table('legislations')
                  ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                  ->where('legiscourts.legislation_id',$id)->first();

        return view('legislation.court',compact('data','id','type'));
      }
      elseif ($type == 4) { //ประนอมหนี้-รายละเอียด
        $data = DB::table('legislations')
                  ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->leftJoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                  ->where('legislations.id', $id)
                  ->orderBy('legispayments.Payment_id', 'DESC')
                  ->first();

        $dataPay = DB::table('legispayments')
                  ->where('legispayments.legis_Com_Payment_id', $id)
                  ->get();

        $dataPranom = DB::table('Legiscompromises')
                  ->where('legisPromise_id', $id)
                  ->count();

        // dd($dataPranom);

        $SumCount = 0;  //ค่าผ่อนชำระทั้งหมด
        $SumPay = 0;    //ค่าชำระ
        $SumPayDue = 0; //ค่าเงินก้อนแรก

        foreach ($dataPay as $key => $value) {
          $GetPay = str_replace (",","",$value->Gold_Payment);
          if ($value->Type_Payment == "เงินก้อนแรก") {
            $SumPayDue = $SumPayDue + $GetPay;
          }
          $SumCount = $SumCount + $GetPay;
        }

        if ($data->Total_Promise != Null) {
          $Getdata = str_replace (",","",$data->Total_Promise);
          $SumPay = $Getdata - $SumCount;
          $SumAllPAy = $Getdata - $SumPayDue;

          if ($data->Discount_Promise != Null) {
            $GetDiscount = str_replace (",","",$data->Discount_Promise);
            $SumPay = $SumPay - $GetDiscount;
          }
        }else {
          $SumAllPAy = 0;
          $Getdata = 0;
        }

        return view('legislation.compromise',compact('data','id','type','dataPay','SumPay','SumAllPAy','Getdata','SumCount','dataPranom'));
      }
      elseif ($type == 5) { //เพิ่มข้อมูลชำระ
        $data = DB::table('legislations')
              ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
              ->leftJoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
              ->where('legispayments.legis_Com_Payment_id', $id)
              ->orderBy('legispayments.Period_Payment', 'desc')->limit(1)
              ->first();

          // dd($data);

        return view('legislation.payment',compact('data','id','type'));
      }
      elseif ($type == 6) { //เพิ่มข้อมูลงาน วิเคราะห์
        $data = DB::table('legislations')
        ->where('legislations.id',$id)->first();
        $StrCon = explode("/",$data->Contract_legis);
        $SetStr1 = $StrCon[0];
        $SetStr2 = $StrCon[1];
        $SetStrConn = $SetStr1."/".$SetStr2;

        $data1 = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->where('SFHP.ARMAST.CONTNO','=', $SetStrConn)
                  ->first();

        // dd($data1);
        return view('legislation.editAnalyze',compact('data','data1','id','type'));
      }
      elseif ($type == 7) { //ชั้นบังคับคดี
        $data = DB::table('legislations')
                  ->leftJoin('legiscourtcases','legislations.id','=','legiscourtcases.legislation_id')
                  ->where('legiscourtcases.legislation_id',$id)->first();

        return view('legislation.courtcase',compact('data','id','type'));
      }
      elseif ($type == 8) { //สืบทรัพย์
        $data = DB::table('legislations')
                  ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                  ->where('legislations.id', $id)
                  ->first();
        // dd($data);
        return view('legislation.asset',compact('data','id','type'));
      }
      elseif ($type == 10){ //ของกลาง
        $data = DB::table('legisexhibits')
                  ->where('Legisexhibit_id', $id)
                  ->first();
        $data1 = DB::connection('ibmi')
              ->table('SFHP.ARMAST')
              ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
              ->where('SFHP.ARMAST.CONTNO','=', $data->Contract_legis)
              ->first();

        return view('legislation.editmore',compact('data','data1','id','type'));
      }
      elseif ($type == 11){ //รูปและแผนที
        // $data = DB::table('legiscourts')
        //       ->where('legiscourts.legislation_id',$id)->first();

        $data = DB::table('legislations')
                  ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->where('legiscourts.legislation_id',$id)->first();

        $dataImages = DB::table('legisimages')
                    ->where('legisimages.legisImage_id',$id)->get();

        $SumImage = count($dataImages);
        if($SumImage > 0){
          $column = 100/$SumImage - 0.8;
        }else{
          $column = 0;
        }

        $lat = $data->latitude_court;
        $long = $data->longitude_court;

        // dd($data);

        // foreach ($datalatlong as $key => $value) {
        //   $lat = $value->latitude_court;
        //   $long = $value->longitude_court;
        // }


        return view('legislation.info',compact('data','id','type','dataImages','SumImage','column','lat','long'));
      }
      elseif ($type == 12){ //ขายฝาก
        $data = DB::table('legislands')
                  ->where('Legisland_id', $id)
                  ->first();
        $StrCon = explode("/",$data->ContractNo_legis);
        $SetStr1 = $StrCon[0];
        $SetStr2 = $StrCon[1];
        $SetStrConn = $SetStr1."/".$SetStr2;
        $data1 = DB::connection('ibmi')
                  ->table('LSFHP.ARMAST')
                  ->join('LSFHP.INVTRAN','LSFHP.ARMAST.CONTNO','=','LSFHP.INVTRAN.CONTNO')
                  ->join('LSFHP.VIEW_CUSTMAIL','LSFHP.ARMAST.CUSCOD','=','LSFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->where('LSFHP.ARMAST.CONTNO','=', $SetStrConn)
                  ->first();
        return view('legislation.editmore',compact('data','data1','id','type'));
      }
      elseif ($type == 13) { //โกงเจ้าหนี้
        $data = DB::table('legislations')
              ->leftJoin('legiscourtcases','legislations.id','=','legiscourtcases.legislation_id')
              ->where('legiscourtcases.legislation_id',$id)->first();

        // if ($data->Flag_case != Null) {
        //   $SetDateCourt = $data->datepreparedoc_case;
        //   $DateNew = date ("Y-m-d", strtotime("+60 days", strtotime($SetDateCourt)));
        // }else {
        //   $DateNew = Null;
        // }

        return view('legislation.cheat',compact('data','id','type'));
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
      $Y = date('Y');
      $m = date('m');
      $d = date('d');
      $date = $Y.'-'.$m.'-'.$d;

      // dd($request, $type);

      if ($type == 2) {     //ข้อมูลผู้เช่าซื้อ
        $user = Legislation::find($id);
          // เพิ่มสถานะจบงาน
          if ($request->get('Statuslegis') != Null) {
            $user->Status_legis = $request->get('Statuslegis');
            $user->UserStatus_legis = auth()->user()->name;
            $user->DateUpState_legis = date('Y-m-d');
            $user->DateCarState_legis = $request->get('DateStatuslegis');

            $user->DateStatus_legis = $request->get('DateCloseAccount');
            $user->PriceStatus_legis = $request->get('PriceAccount');
            $user->txtStatus_legis = $request->get('TopCloseAccount');
            $user->Discount_legis = $request->get('DiscountAccount');
          }
          elseif ($request->get('Statuslegis') == Null) {
            $user->Status_legis = NULL;
            $user->UserStatus_legis = NULL;
            $user->DateStatus_legis = NULL;
            $user->PriceStatus_legis = NULL;
            $user->txtStatus_legis = NULL;
            $user->Discount_legis = NULL;
            $user->DateUpState_legis = NULL;
            $user->DateCarState_legis = NULL;
          }

          //หน้าทีมทนาย
          $user->Pay_legis = str_replace(",","",$request->get('Paylegis'));
          $user->Period_legis = str_replace(",","",$request->get('Periodlegis'));
          $user->Countperiod_legis = $request->get('Countperiodlegis');
          $user->Beforeperiod_legis = $request->get('Beforeperiodlegis');
          $user->Remainperiod_legis = $request->get('Remainperiodlegis');
          $user->Beforemoey_legis = str_replace(",","",$request->get('Beforemoeylegis'));
          $user->Staleperiod_legis = str_replace(",","",$request->get('Staleperiodlegis'));
          $user->Realperiod_legis = str_replace(",","",$request->get('Realperiod_legis'));
          $user->Sumperiod_legis = str_replace(",","",$request->get('Sumperiodlegis'));
          $user->DateVAT_legis = $request->get('DateVATlegis');
          $user->Certificate_list = $request->get('Certificatelist');
          $user->Authorize_list = $request->get('Authorizelist');
          $user->Authorizecase_list = $request->get('Authorizecaselist');
          $user->Purchase_list = $request->get('Purchaselist');
          $user->Promise_list = $request->get('Promiselist');
          $user->Titledeed_list = $request->get('Titledeedlist');
          $user->Note = $request->get('Legisnote');

          //หน้าทีมวิเคราะห์
          $user->Terminatebuyer_list = $request->get('Terminatebuyerlist');
          $user->Terminatesupport_list = $request->get('Terminatesupportlist');
          $user->Acceptbuyerandsup_list = $request->get('Acceptbuyerandsuplist');
          $user->Twodue_list = $request->get('Twoduelist');
          $user->AcceptTwodue_list = $request->get('AcceptTwoduelist');
          $user->Confirm_list = $request->get('Confirmlist');
          $user->Accept_list = $request->get('Acceptlist');

          $user->Address_legis = $request->get('Adreeslegis');
          $user->AddressGT_legis = $request->get('AdreesGTlegis');
          $user->Phone_legis = $request->get('Phonelegis');
        $user->update();

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
      }
      elseif ($type == 3) { //ชั้นศาล
        $user = Legislation::find($id); //update status
          if ($request->get('Statuslegis') != Null) {
            $user->Status_legis = $request->get('Statuslegis');
            $user->UserStatus_legis = auth()->user()->name;
            $user->DateUpState_legis = date('Y-m-d');
            $SettxtStatus = $request->get('DateStatuslegis');
            $SetDateUp = date('Y-m-d');

            $user->DateStatus_legis = $request->get('DateCloseAccount');
            $user->PriceStatus_legis = $request->get('PriceAccount');
            $user->txtStatus_legis = $request->get('TopCloseAccount');
            $user->Discount_legis = $request->get('DiscountAccount');
          }
          elseif ($request->get('Statuslegis') == Null) {
            $user->Status_legis = NULL;
            $user->UserStatus_legis = NULL;
            $user->DateUpState_legis = NULL;
            $SettxtStatus = NULL;

            $SetDateUp = NULL;
            $SettxtStatus = NULL;
          }
        $user->update();

        $Setcapitalcourt = str_replace (",","",$request->get('capitalcourt'));
        $Setindictmentcourt = str_replace (",","",$request->get('indictmentcourt'));
        $Setpricelawyercourt = str_replace (",","",$request->get('pricelawyercourt'));

        $Legiscourt = Legiscourt::where('legislation_id',$id)->first();
          $Legiscourt->fillingdate_court = $request->get('fillingdatecourt');
          $Legiscourt->law_court = $request->get('lawcourt');
          $Legiscourt->bnumber_court = $request->get('bnumbercourt');
          $Legiscourt->rnumber_court = $request->get('rnumbercourt');
          $Legiscourt->capital_court = $Setcapitalcourt;
          $Legiscourt->indictment_court = $Setindictmentcourt;
          $Legiscourt->pricelawyer_court = $Setpricelawyercourt;
          $Legiscourt->examiday_court = $request->get('examidaycourt');
          $Legiscourt->fuzzy_court = $request->get('fuzzycourt');
          $Legiscourt->examinote_court = $request->get('examinotecourt');
          $Legiscourt->orderday_court = $request->get('orderdaycourt');
          $Legiscourt->ordersend_court = $request->get('ordersendcourt');
          $Legiscourt->checkday_court = $request->get('checkdaycourt');
          $Legiscourt->checksend_court = $request->get('checksendcourt');
          $Legiscourt->buyer_court = $request->get('buyercourt');
          $Legiscourt->support_court = $request->get('supportcourt');
          $Legiscourt->note_court = $request->get('notecourt');
          $Legiscourt->social_flag = $request->get('socialflag');
          $Legiscourt->setoffice_court = $request->get('setofficecourt');
          $Legiscourt->sendoffice_court = $request->get('sendofficecourt');
          $Legiscourt->checkresults_court = $request->get('checkresultscourt');
          $Legiscourt->sendcheckresults_court = $request->get('sendcheckresultscourt');
          $Legiscourt->received_court = $request->get('radio-receivedflag');
          $Legiscourt->telresults_court = $request->get('telresultscourt');
          $Legiscourt->dayresults_court = $request->get('dayresultscourt');

          $Legiscourt->Status_court = $request->get('Statuslegis');
          $Legiscourt->DateStatus_court = $SetDateUp;
          $Legiscourt->txtStatus_court = $SettxtStatus;

          if ($Legiscourt->DateComplete_court == NULL) {
            if ($request->get('fillingdatecourt') != NULL) {
              $Legiscourt->DateComplete_court = date('Y-m-d');
              $Legiscourt->User_court = auth()->user()->name;
            }
          }
        $Legiscourt->update();

        // update key ลูก
        $Legislation = Legislation::find($id);
          $Legislation->KeyCourts_id = $Legiscourt->court_id;
        $Legislation->update();

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
      }
      elseif ($type == 4) { //ประนอมหนี้-รายละเอียด
        $data = DB::table('Legiscompromises')
                  ->where('Legiscompromises.legisPromise_id', $id)->first();

        $SetTotalPromise = str_replace (",","",$request->get('TotalPromise'));
        $SetSumPromise = str_replace (",","",$request->get('SumPromise'));
        $SetDuePay = str_replace (",","",$request->get('DuePayPromise'));
        $SetDiscount = str_replace (",","",$request->get('DiscountPromise'));
        $SetPayallPromise = str_replace (",","",$request->get('PayallPromise'));

        if ($data == Null) {
            $LegisPromise = new Legiscompromise([
              'Date_Promise' => $date,
              'legisPromise_id' => $id,
              'KeyPay_id' => Null,
              'Flag_Promise' => $request->get('FlagPromise'),
              'Total_Promise' => $SetTotalPromise,
              'Type_Promise' =>  $request->get('TypePromise'),
              'DateNsale_Promise' =>  $request->get('DateNsalePromise'),
              'Dateset_Promise' =>  $request->get('DatesetPromise'),
              'Payall_Promise' =>  $SetPayallPromise,
              'Sum_Promise' =>  $SetSumPromise,
              'Discount_Promise' =>  $SetDiscount,
              'Due_Promise' =>  $request->get('DuePromise'),
              'DuePay_Promise' =>  $SetDuePay,
              'Datelast_Promise' =>  $request->get('DatelastPromise'),
              'SumAll_Promise' =>  $request->get('SumAllPromise'),
              'Note_Promise' =>  $request->get('NotePromise'),
              'User_Promise' =>  auth()->user()->name,
            ]);
            $LegisPromise->save();
        }else {
          $LegisPromise = Legiscompromise::where('legisPromise_id',$id)->first();
            $LegisPromise->Flag_Promise = $request->get('FlagPromise');
            $LegisPromise->Total_Promise = $SetTotalPromise;
            $LegisPromise->Type_Promise = $request->get('TypePromise');
            $LegisPromise->DateNsale_Promise = $request->get('DateNsalePromise');
            $LegisPromise->Dateset_Promise = $request->get('DatesetPromise');
            $LegisPromise->Payall_Promise = $request->get('PayallPromise');
            $LegisPromise->Sum_Promise = $SetSumPromise;
            $LegisPromise->Discount_Promise = $SetDiscount;
            $LegisPromise->Due_Promise = $request->get('DuePromise');
            $LegisPromise->DuePay_Promise = $SetDuePay;
            $LegisPromise->Datelast_Promise = $request->get('DatelastPromise');
            $LegisPromise->SumAll_Promise = $request->get('SumAllPromise');
            $LegisPromise->Note_Promise = $request->get('NotePromise');

            if ($request->get('StatusCompro') != NULL) {
              $LegisPromise->Status_Promise = $request->get('StatusCompro');
              $LegisPromise->DateStatus_Promise = date('Y-m-d');
            }else {
              $LegisPromise->Status_Promise = NULL;
              $LegisPromise->DateStatus_Promise = NULL;
            }
          $LegisPromise->update();
        }

        $data = DB::table('legislations')
                  ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->where('Legiscompromises.legisPromise_id', $id)
                  ->orderBy('legislations.Contract_legis', 'ASC')
                  ->first();

        // update key ลูก
        $Legislation = Legislation::find($id);
          $Legislation->KeyCompro_id = $data->Promise_id;
        $Legislation->update();

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อย');
      }
      elseif ($type == 6) { //เตรียมเอกสารฝ่ายวิเคราะห์
        $user = Legislation::find($id);
          $user->Pay_legis = str_replace(",","",$request->get('Paylegis'));
          $user->Period_legis = str_replace(",","",$request->get('Periodlegis'));
          $user->Countperiod_legis = $request->get('Countperiodlegis');
          $user->Beforeperiod_legis = $request->get('Beforeperiodlegis');
          $user->Remainperiod_legis = $request->get('Remainperiodlegis');
          $user->Beforemoey_legis = str_replace(",","",$request->get('Beforemoeylegis'));
          $user->Staleperiod_legis = str_replace(",","",$request->get('Staleperiodlegis'));
          $user->Realperiod_legis = str_replace(",","",$request->get('Realperiod_legis'));
          $user->Sumperiod_legis = str_replace(",","",$request->get('Sumperiodlegis'));
          $user->DateVAT_legis = $request->get('DateVATlegis');
          $user->Terminatebuyer_list = $request->get('Terminatebuyerlist');
          $user->Terminatesupport_list = $request->get('Terminatesupportlist');
          $user->Acceptbuyerandsup_list = $request->get('Acceptbuyerandsuplist');
          $user->Twodue_list = $request->get('Twoduelist');
          $user->AcceptTwodue_list = $request->get('AcceptTwoduelist');
          $user->Confirm_list = $request->get('Confirmlist');
          $user->Accept_list = $request->get('Acceptlist');
          $user->Noteby_legis = $request->get('NotebyAnalysis');
          $user->Phone_legis = $request->get('Phonelegis');
        $user->update();

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
      }
      elseif ($type == 7) { //ชั้นบังคับคดี

        // $file = $request->file('Upfile');

        // dump($file->getClientOriginalName());
        // dump($file->getClientOriginalExtension());
        // dd($file->getSize());

        if($request->get('Paidseguester') != ''){
          $Paidseguester = str_replace(",","",$request->get('Paidseguester'));
        }else{
          $Paidseguester = 0;
        }

        if($request->get('Amountsequester') != ''){
          $Amountsequester = str_replace(",","",$request->get('Amountsequester'));
        }else{
          $Amountsequester = 0;
        }

        if ($request->get('StatusCase') == "ถอนบังคับคดีปิดบัญชี") {
          if ($request->get('txtStatusCase1') != Null) {
            $SettxtStatus = $request->get('txtStatusCase1');
            $SetDateStatus = $request->get('DateStatusCase1');
          }
        }elseif ($request->get('StatusCase') == "ถอนบังคับคดียึดรถ") {
          if ($request->get('txtStatusCase2') != Null) {
            $SettxtStatus = $request->get('txtStatusCase2');
            $SetDateStatus = $request->get('DateStatusCase2');
          }
        }elseif ($request->get('StatusCase') == "ถอนบังคับคดียอดเหลือน้อย") {
          if ( $request->get('txtStatusCase3') != Null) {
            $SettxtStatus = $request->get('txtStatusCase3');
            $SetDateStatus = $request->get('DateStatusCase3');
          }
        }elseif ($request->get('StatusCase') == "ถอนบังคับคดีขายเต็มจำนวน") {
          $SettxtStatus = NULL;
          $SetDateStatus = $request->get('Datesoldout');
        }elseif ($request->get('StatusCase') == "ประนอมหลังยึดทรัพย์") {
          $SettxtStatus = NULL;
          $SetDateStatus = date('Y-m-d');
        }else {
          $SettxtStatus = NULL;
          $SetDateStatus = NULL;
        }

        $Legiscourtcase = Legiscourtcase::where('legislation_id',$id)->first();
          $Legiscourtcase->datepreparedoc_case = $request->get('datepreparedoc');
          $Legiscourtcase->noteprepare_case = $request->get('noteprepare');
          $Legiscourtcase->datesetsequester_case = $request->get('DatesetSequester');
          $Legiscourtcase->resultsequester_case = $request->get('ResultSequester');
          $Legiscourtcase->notesequester_case = $request->get('Notesequester');
          $Legiscourtcase->paidsequester_case = $Paidseguester;
          $Legiscourtcase->datenextsequester_case = $request->get('DatenextSequester');
          $Legiscourtcase->resultsell_case = $request->get('ResultSell');
          $Legiscourtcase->datesoldout_case = $request->get('Datesoldout');
          $Legiscourtcase->amountsequester_case = $Amountsequester;
          $Legiscourtcase->NumAmount_case = $request->get('CountSeliing');
          $Legiscourtcase->Status_case = $request->get('StatusCase');
          $Legiscourtcase->DateStatus_case = $SetDateStatus;
          $Legiscourtcase->txtStatus_case = $SettxtStatus;
          $Legiscourtcase->Flag_case = $request->get('Flagcase');
        $Legiscourtcase->update();

        $courtcase = Legiscourtcase::find($id); //update DateNotice_cheat
          if ($request->get('Flagcase') == Null) {
            $courtcase->DateNotice_cheat = Null;
          }else {
            $SetDateCourt = $request->get('datepreparedoc');
            $courtcase->DateNotice_cheat = date ("Y-m-d", strtotime("+60 days", strtotime($SetDateCourt)));
          }
        $courtcase->update();

        $user = Legislation::find($id); //update status
          if ($request->get('StatusCase') != Null) {
            $user->Status_legis = $request->get('StatusCase');
            $user->UserStatus_legis = auth()->user()->name;
            $user->DateUpState_legis = $SetDateStatus;

            $user->DateStatus_legis = $request->get('DateCloseAccount');
            $user->PriceStatus_legis = $request->get('PriceAccount');
            $user->txtStatus_legis = $request->get('TopCloseAccount');
            $user->Discount_legis = $request->get('DiscountAccount');
          }
          elseif ($request->get('StatusCase') == Null) {
            $user->Status_legis = NULL;
            $user->UserStatus_legis = NULL;
            $user->DateUpState_legis = NULL;
          }
        $user->update();

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
      }
      elseif ($type == 8) { //สืบทรัพย์
        $data = DB::table('legisassets')
                  ->where('legisassets.legisAsset_id', $id)->first();

        $SetPriceasset = str_replace (",","",$request->get('Priceasset'));

        if ($data == Null) {
            $LegisAsset = new legisasset([
              'legisAsset_id' => $id,
              'Date_asset' => $request->get('Dateasset'),
              'Status_asset' => $request->get('statusasset'),
              'Price_asset' => $SetPriceasset,
              'propertied_asset' => $request->get('radio_propertied'),
              'sequester_asset' =>  $request->get('sequesterasset'),
              'sendsequester_asset' => $request->get('sendsequesterasset'),
              'Dateresult_asset' => Null,
              'NewpursueDate_asset' => $request->get('NewpursueDateasset'),
              'Notepursue_asset' =>  $request->get('Notepursueasset'),
              'User_asset' =>  auth()->user()->name,
            ]);
            $LegisAsset->save();
        }else {
          if ($request->get('sendsequesterasset') == "สืบทรัพย์เจอ" or $request->get('sendsequesterasset') == "หมดอายุความคดี" or $request->get('sendsequesterasset') == "จบงานสืบทรัพย์") {
            $Dateresult = date('Y-m-d');
          }else {
            $Dateresult = Null;
            if ($request->get('radio_propertied') == "Y") {
              $Dateresult = date('Y-m-d');
            }else {
              $Dateresult = Null;
            }
          }

          $LegisAsset = legisasset::where('legisAsset_id',$id)->first();
            $LegisAsset->Date_asset = $request->get('Dateasset');
            $LegisAsset->Status_asset = $request->get('statusasset');
            $LegisAsset->Price_asset = $SetPriceasset;
            $LegisAsset->propertied_asset = $request->get('radio_propertied');
            $LegisAsset->sequester_asset = $request->get('sequesterasset');
            $LegisAsset->sendsequester_asset = $request->get('sendsequesterasset');
            $LegisAsset->Dateresult_asset = $Dateresult;
            $LegisAsset->NewpursueDate_asset = $request->get('NewpursueDateasset');
            $LegisAsset->Notepursue_asset =  $request->get('Notepursueasset');
          $LegisAsset->update();
        }

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อย');
      }
      elseif ($type == 10){ //ของกลาง
          $Dateresult = NULL;
          if($request->get('TypeExhibit') == 'ของกลาง'){
            $Dateresult = $request->get('DategetResult1');
          }
          if($request->get('TypeExhibit') == 'ยึดตามมาตราการ(ปปส.)'){
            $Dateresult = $request->get('DategetResult2');
          }
          $LegisExhibit = Legisexhibit::where('Legisexhibit_id',$id)->first();
            $LegisExhibit->Contract_legis = $request->get('ContractNo');
            $LegisExhibit->Dateaccept_legis = $request->get('DateExhibit');
            $LegisExhibit->Name_legis =  $request->get('NameContract');
            $LegisExhibit->Policestation_legis =  $request->get('PoliceStation');
            $LegisExhibit->Suspect_legis =  $request->get('NameSuspect');
            $LegisExhibit->Plaint_legis =  $request->get('PlaintExhibit');
            $LegisExhibit->Inquiryofficial_legis =  $request->get('InquiryOfficial');
            $LegisExhibit->Inquiryofficialtel_legis =  $request->get('InquiryOfficialtel');
            $LegisExhibit->Terminate_legis =  $request->get('TerminateExhibit');
            $LegisExhibit->DateLawyersend_legis =  $request->get('DateLawyersend');
            $LegisExhibit->Typeexhibit_legis =  $request->get('TypeExhibit');
            $LegisExhibit->Currentstatus_legis =  $request->get('Currentstatus');
            $LegisExhibit->Nextstatus_legis =  $request->get('Nextstatus');
            $LegisExhibit->Noteexhibit_legis =  $request->get('NoteExhibit');
            $LegisExhibit->Dategiveword_legis =  $request->get('DateGiveword');
            $LegisExhibit->Typegiveword_legis =  $request->get('TypeGiveword');
            $LegisExhibit->Datepreparedoc_legis =  $request->get('DatePreparedoc');
            $LegisExhibit->Dateinvestigate_legis =  $request->get('DateInvestigate');
            $LegisExhibit->Datecheckexhibit_legis =  $request->get('DateCheckexhibit');
            $LegisExhibit->Datesendword_legis =  $request->get('DateSendword');
            $LegisExhibit->Resultexhibit1_legis =  $request->get('ResultExhibit1');
            $LegisExhibit->Processexhibit1_legis =  $request->get('ProcessExhibit1');
            $LegisExhibit->Datesenddetail_legis =  $request->get('DateSenddetail');
            $LegisExhibit->Resultexhibit2_legis =  $request->get('ResultExhibit2');
            $LegisExhibit->Processexhibit2_legis =  $request->get('ProcessExhibit2');
            $LegisExhibit->Dategetresult_legis =  $Dateresult;
          $LegisExhibit->update();
          return redirect()->back()->with('success','อัพเดทข้อมูลเรียบร้อย');
      }
      elseif ($type == 11) { //รูปและแผนที่
        $Legiscourt = Legiscourt::where('legislation_id',$id)->first();
          $Legiscourt->latitude_court = $request->get('latitude');
          $Legiscourt->longitude_court = $request->get('longitude');
        $Legiscourt->update();

        if ($request->hasFile('file_image')) {
          $image_array = $request->file('file_image');
          $array_len = count($image_array);
          // dd($array_len);
          for ($i=0; $i < $array_len; $i++) {
            $image_size = $image_array[$i]->getClientSize();
            $image_lastname = $image_array[$i]->getClientOriginalExtension();
            $image_new_name = str_random(10).time(). '.' .$image_array[$i]->getClientOriginalExtension();

            $destination_path = public_path('/upload-image');
            $image_array[$i]->move($destination_path,$image_new_name);

            $Uploaddb = new LegisImage([
              'legisImage_id' => $id,
              'name_image' => $image_new_name,
              'size_image' => $image_size,
            ]);
            // dd($Uploaddb);
            $Uploaddb ->save();
          }
        }
        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
      }
      elseif ($type == 13) { //โกงเจ้าหนี้
        $Legiscourtcase = Legiscourtcase::where('legislation_id',$id)->first();
          $Legiscourtcase->DateNotice_cheat = $request->get('DateNoticeCheat');
          $Legiscourtcase->Dateindictment_cheat = $request->get('DateindictmentCheat');
          $Legiscourtcase->DateExamine_cheat = $request->get('DateExamineCheat');
          $Legiscourtcase->Datedeposition_cheat = $request->get('DatedepositionCheat');
          $Legiscourtcase->Dateplantiff_cheat = $request->get('DateplantiffCheat');
          $Legiscourtcase->Status_cheat = $request->get('StatusCheat');
          $Legiscourtcase->DateStatus_Cheat = $request->get('DateStatusCheat');
          $Legiscourtcase->note_cheat = $request->get('noteCheat');
        $Legiscourtcase->update();

        $user = Legislation::find($id); //update status
          if ($request->get('StatusCheat') != Null) {
            $user->Status_legis = $request->get('StatusCheat');
            $user->UserStatus_legis = auth()->user()->name;
            $user->DateUpState_legis = $request->get('DateStatusCheat');

            $user->DateStatus_legis = $request->get('DateCloseAccount');
            $user->PriceStatus_legis = $request->get('PriceAccount');
            $user->txtStatus_legis = $request->get('TopCloseAccount');
            $user->Discount_legis = $request->get('DiscountAccount');
          }
          elseif ($request->get('StatusCheat') == Null) {
            $user->Status_legis = NULL;
            $user->UserStatus_legis = NULL;
            $user->DateUpState_legis = NULL;
          }
        $user->update();

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
      }
      elseif ($type == 12) {  //ขายฝาก
        $LegisLand = Legisland::where('Legisland_id',$id)->first();
          $LegisLand->Beforemoney_legis = str_replace(",","",$request->get('Beforemoneylegis'));
          $LegisLand->Sumperiod_legis = str_replace(",","",$request->get('Sumperiodlegis'));
          $LegisLand->Realperiod_legis =  $request->get('Realperiodlegis');
          $LegisLand->Datenotice_legis =  $request->get('DateNotice');
          $LegisLand->Dategetnotice_legis =  $request->get('DateGetNotice');
          $LegisLand->Datepetition_legis =  $request->get('DatePetition');
          $LegisLand->Dateinvestigate_legis =  $request->get('DateInvestigate');
          $LegisLand->Dateadjudicate_legis =  $request->get('DateAdjudicate');
          $LegisLand->Dateeviction_legis =  $request->get('DateEviction');
          $LegisLand->Datepost_legis =  $request->get('DatePost');
          $LegisLand->Datecheckasset_legis =  $request->get('DateCheckAsset');
          $LegisLand->Resultcheck_legis =  $request->get('ResultCheck');
          $LegisLand->Datearrest_legis =  $request->get('DateArrest');
          $LegisLand->Datestaffarrest_legis =  $request->get('DateStaffArrest');
          $LegisLand->Noteland_legis =  $request->get('NoteLand');
          $LegisLand->Statusland_legis =  $request->get('Statuslandlegis');
          $LegisLand->Datestatusland_legis =  $request->get('DateStatuslandlegis');
        $LegisLand->update();

        return redirect()->back()->with('success','อัพเดทข้อมูลเรียบร้อย');
      }
      elseif ($type == 100) { //Json ประนอมหนี้
        $input = $request->all();
        $data = DB::table('Legiscompromises')
                  ->where('Legiscompromises.legisPromise_id',$input["Getid"])->get();
        $dataCount = count($data);

        if ($dataCount == 0) {
            $LegisPromise = new Legiscompromise([
              'legisPromise_id' => $input["Getid"],
              'Total_Promise' => Null,
              'Type_Promise' =>  Null,
              'Payall_Promise' =>  Null,
              'Sum_Promise' =>  Null,
              'Due_Promise' =>  Null,
              'DuePay_Promise' =>  Null,
              'Datelast_Promise' =>  Null,
              'SumAll_Promise' =>  Null,
              'Note_Promise' =>  Null,
            ]);
            $LegisPromise->save();

        }else {
          $Legiscourt = Legiscompromise::where('legisPromise_id',$input["Getid"])->first();
            $Legiscourt->Total_Promise = $request->get('TotalPromise');
            $Legiscourt->Type_Promise = $request->get('TypePromise');
            $Legiscourt->Payall_Promise = $request->get('PayallPromise');
            $Legiscourt->Pay1_Promise = $request->get('Pay1Promise');
            $Legiscourt->Pay2_Promise = $request->get('Pay2Promise');
            $Legiscourt->Pay3_Promise = $request->get('Pay3Promise');
            $Legiscourt->Sum_Promise = $request->get('SumPromise');
            $Legiscourt->Due_Promise = $request->get('DuePromise');
            $Legiscourt->DuePay_Promise = $request->get('DuePayPromise');
            $Legiscourt->Datelast_Promise = $request->get('DatelastPromise');
            $Legiscourt->SumAll_Promise = $request->get('SumAllPromise');
          $Legiscourt->update();
        }

        $data = DB::table('Legiscompromises')
                  ->where('Legiscompromises.legisPromise_id',$input["Getid"])->get();

        $Typecom = [
          'ประนอมที่ศาล' => 'ประนอมที่ศาล',
          'ประนอมที่บริษัท' => 'ประนอมที่บริษัท',
          'หลังยึดทรัพย์' => 'หลังยึดทรัพย์',
        ];

        return response()->json(['success'=> $data]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function updateLegislation(Request $request, $id, $type)
     {
       if ($type == 6) {     //ข้อมูลผู้เช่าซื้อจากฝ่ายวิเคราะห์
         $user = Legislation::find($id);
               $user->Flag_status = $request->get('Flag');
               $user->UserSend2_legis = auth()->user()->name;
               $user->Datesend_Flag = date('Y-m-d');
         $user->update();

         $Legiscourt = new Legiscourt([
           'legislation_id' => $id,
           'fillingdate_court' => Null,
           'law_court' =>  Null,
           'bnumber_court' =>  Null,
           'rnumber_court' =>  Null,
           'capital_court' =>  0,
           'indictment_court' =>  0,
           'pricelawyer_court' =>  0,
           'examiday_court' =>  Null,
           'fuzzy_court' =>  Null,
           'examinote_court' =>  Null,
           'orderday_court' =>  Null,
           'ordersend_court' =>  Null,
           'checkday_court' =>  Null,
           'checksend_court' =>  Null,
           'buyer_court' =>  Null,
           'support_court' =>  Null,
           'note_court' =>  Null,
           'social_flag' =>  Null,
           'setoffice_court' =>  Null,
           'sendoffice_court' =>  Null,
           'checkresults_court' =>  Null,
           'sendcheckresults_court' =>  Null,
           'received_court' =>  Null,
           'telresults_court' =>  Null,
           'dayresults_court' =>  Null,
           'User_court' => NULL,
           'latitude_court' =>  Null,
           'longitude_court' =>  Null,
         ]);
         $Legiscourt->save();

         $Legiscourtcase = new Legiscourtcase([
           'legislation_id' => $id,
           'datepreparedoc_case' => Null,
           'noteprepare_case' =>  Null,
           'datesetsequester_case' =>  Null,
           'resultsequester_case' =>  Null,
           'notesequester_case' =>  Null,
           'paidsequester_case' =>  Null,
           'datenextsequester_case' =>  Null,
           'resultsell_case' =>  Null,
           'datesoldout_case' =>  Null,
           'amountsequester_case' =>  Null,
           'NumAmount_case' =>  Null,
           'Status_case' =>  Null,
           'DateStatus_case' =>  Null,
           'txtStatus_case' =>  Null,
           'Flag_case' =>  Null,

           'DateNotice_cheat' => Null,
           'Dateindictment_cheat' => Null,
           'DateExamine_cheat' => Null,
           'Datedeposition_cheat' => Null,
           'Dateplantiff_cheat' => Null,
           'Status_cheat' => Null,
           'note_cheat' => Null,
         ]);
         $Legiscourtcase->save();

         return redirect()->Route('legislation',$type)->with('success','ส่งเรียบร้อย');
       }
     }

    public function destroy($id ,$type)
    {
      if ($type == 1) { //ลบทั้งหมด
        $item = Legislation::find($id);
        $item2 = Legiscourt::where('legislation_id',$id);
        $item3 = Legiscompromise::where('legisPromise_id',$id);
        $item4 = legispayment::where('legis_Com_Payment_id',$id);
        $item5 = legisasset::where('legisAsset_id',$id);
        $item6 = Legiscourtcase::where('legislation_id',$id);

        $item->Delete();
        $item2->Delete();
        $item3->Delete();
        $item4->Delete();
        $item5->Delete();
        $item6->Delete();
      }
      elseif ($type == 2) { //ลบตาราง Payment
        $item1 = legispayment::where('Payment_id',$id)->first();

        // dd($item1);
        $dataFind = DB::table('legiscompromises')
                      ->where('legisPromise_id','=', $item1->legis_Com_Payment_id)->first();

                      // dd($item1->legis_Com_Payment_id);
        $total = $dataFind->Sum_Promise + $item1->Gold_Payment;
        $Legiscom = Legiscompromise ::find($item1->legis_Com_Payment_id);
          $Legiscom->Sum_Promise = $total;
        $Legiscom->update();

        $item = legispayment::where('Payment_id',$id);
        $item->Delete();

        $LegisPay = legispayment::where('legis_Com_Payment_id',$item1->legis_Com_Payment_id)->latest()->first();
        if ($LegisPay != Null) {
          DB::table('legispayments')
            ->where('Payment_id', $LegisPay->Payment_id)
            ->update([
                'Flag_Payment' => 'Y'
            ]);
        }

      }
      elseif ($type == 3) { //ลบตาราง ของกลาง Exhibit
        $item = Legisexhibit::where('Legisexhibit_id',$id);
        $item->Delete();
      }
      elseif ($type == 4) { //ลบตาราง ขายฝาก Legisland
        $item = Legisland::where('legisland_id',$id);
        $item->Delete();
      }
      return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }

    public function deleteImageAll($id)
    {
      $item = LegisImage::where('legisImage_id','=',$id)->get();

      foreach ($item as $key => $value) {
        $itemID = $value->legisImage_id;
        $itemPath = $value->name_image;

        Storage::delete($itemPath);
      }

        $deleteItem = LegisImage::where('legisImage_id',$itemID);
        $deleteItem->Delete();

      return redirect()->back()->with('success','ลบรูปทั้งหมดเรียบร้อยแล้ว');
    }

    public function ReportReceipt(Request $request, $id, $type)
    {
      date_default_timezone_set('Asia/Bangkok');
      $Y = date('Y') + 543;
      $Y2 = date('Y');
      $m = date('m');
      $d = date('d');
      $time = date('H:i');
      $date = $Y2.'-'.$m.'-'.$d;
      $date2 = $Y.'-'.$m.'-'.$d;

      if ($type == 1) {     //เมนูค้นหาหน้า View
        $NumberBill = $request->NumberBill;
        $Fromdate = $request->Fdate;
        $Todate = $request->Tdate;

        $data = DB::connection('ibmi')
              ->table('SFHP.ARMAST')
              ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
              ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
              ->where('SFHP.ARMAST.CONTNO','=', $request->Contract)
              ->first();

        if ($data == Null) {
          $data = DB::connection('ibmi')
                ->table('ASFHP.ARMAST')
                ->join('ASFHP.INVTRAN','ASFHP.ARMAST.CONTNO','=','ASFHP.INVTRAN.CONTNO')
                ->join('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
                ->where('ASFHP.ARMAST.CONTNO','=', $request->Contract)
                ->first();
        }
        // dd($data);
        $dataDB = DB::table('legislations')
              ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
              ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
              ->leftJoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
              ->where('legislations.Contract_legis','=', $request->Contract)
              ->when(!empty($NumberBill), function($q) use($NumberBill){
                return $q->where('legispayments.Jobnumber_Payment',$NumberBill);
              })
              ->when(!empty($Fromdate)  && !empty($Todate), function($q) use ($Fromdate, $Todate) {
                return $q->whereBetween('legispayments.Date_Payment',[$Fromdate,$Todate]);
              })
              ->orderBy('legislations.id', 'ASC')
              ->first();

        $pdf = new PDF();
        $pdf::SetTitle('ใบเสร็จรับชำระค่างวด');
        $pdf::AddPage('L', 'A5');
        $pdf::SetMargins(16, 5, 5, 5);
        $pdf::SetFont('freeserif', '', 11, '', true);
        $pdf::SetAutoPageBreak(TRUE, 5);

        $view = \View::make('legislation.reportCompro' ,compact('data','dataPay','dataDB','type','dataCount','status','newfdate','newtdate'));
        $html = $view->render();
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');

      }
      elseif ($type == 2) { //ใบเสร็จรับชำระค่างวด
        
        $dataDB = DB::table('legislations')
                ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftJoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                ->where('legispayments.Payment_id','=', $id)
                ->orderBy('legispayments.Payment_id', 'ASC')
                ->first();

        // dd($dataDB);

        if ($dataDB->Flag == "C") {
          $data = DB::connection('ibmi')
                ->table('ASFHP.ARMAST')
                ->join('ASFHP.INVTRAN','ASFHP.ARMAST.CONTNO','=','ASFHP.INVTRAN.CONTNO')
                ->join('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
                ->where('ASFHP.ARMAST.CONTNO','=', $dataDB->Contract_legis)
                ->first();
        }else {
          $data = DB::connection('ibmi')
                ->table('SFHP.ARMAST')
                ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                ->where('SFHP.ARMAST.CONTNO','=', $dataDB->Contract_legis)
                ->first();
        }

        $pdf = new PDF();
        $pdf::SetTitle('ใบเสร็จรับชำระค่างวด');
        $pdf::AddPage('L', 'A5');
        $pdf::SetMargins(16, 5, 5, 5);
        $pdf::SetFont('freeserif', '', 11, '', true);
        $pdf::SetAutoPageBreak(TRUE, 5);

        $view = \View::make('legislation.reportCompro' ,compact('data','dataPay','dataDB','type','dataCount','status','newfdate','newtdate'));
        $html = $view->render();
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');
      }
      elseif ($type == 16) { //รายงานลูกหนี้ประนอม
        $lastday = date('Y-m-d', strtotime("-90 days"));
        $newfdate = '';
        $newtdate = '';
        $status = '';

        if ($request->has('Fromdate')) {
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $newtdate = $request->get('Todate');
        }
        if ($request->has('status')) {
          $status = $request->get('status');
        }

        $data = DB::table('legislations')
                  ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                  ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                  ->where('legislations.Flag_status','!=', '1')
                  ->where('Legiscompromises.Date_Promise','!=', null)
                  ->orderBy('legislations.Contract_legis', 'ASC')
                  ->get();

        $dataPay = DB::table('legislations')
                ->join('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                ->join('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legispayments.Date_Payment',[$newfdate,$newtdate]);
                })
                ->where('legispayments.Flag_Payment', '=', 'Y')
                ->get();

        if($status == "ชำระปกติ"){
          $data = DB::table('legislations')
                ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftjoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                ->where('legislations.Flag_status','!=', '1')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legispayments.Date_Payment',[$newfdate,$newtdate]);
                })
                ->when(!empty($status), function($q) use($lastday){
                    return $q->where('legispayments.Date_Payment','>=',$lastday);
                  })
                ->where('legispayments.Flag_Payment', '=', 'Y')
                ->where('legislations.Status_legis','=', Null)
                ->orderBy('legislations.Contract_legis', 'ASC')
                ->get();
        }
        elseif($status == "ขาดชำระ"){
          $data = DB::table('legislations')
                ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftjoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                ->where('legislations.Flag_status','!=', '1')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legispayments.Date_Payment',[$newfdate,$newtdate]);
                })
                ->when(!empty($status), function($q) use($lastday){
                    return $q->where('legispayments.Date_Payment','<',$lastday);
                 })
                ->where('legispayments.Flag_Payment', '=', 'Y')
                ->get();
        }
        elseif($status == "ปิดบัญชี"){
          $data = DB::table('legislations')
                ->leftjoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftjoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->where('legislations.Flag_status','!=', '1')
                // ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                //   return $q->whereBetween('Legiscompromises.Date_Promise',[$newfdate,$newtdate]);
                // })
                ->where('legislations.Status_legis','=', 'ปิดบัญชีประนอมหนี้')
                ->orderBy('legislations.Contract_legis', 'ASC')
                ->get();
        }

        $dataSmart = DB::connection('ibmi')
        ->table('ASFHP.ARMAST')
        ->join('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
        ->orderBy('ASFHP.ARMAST.CONTNO', 'ASC')
        ->get();
        $countDatasmart = count($dataSmart);
        $countData = count($data);

        for ($i=0; $i < $countData; $i++) {
          $Contract_No[] = str_replace(" ", "",$data[$i]->Contract_legis);
            for ($j=0; $j < $countDatasmart; $j++) {
              if($data[$i]->Contract_legis == $dataSmart[$j]->CONTNO){
                $SmartInfo[] = $dataSmart[$j];
              }
            }
        }

        // dump($dataSmart);
        // dd($SmartInfo,$Contract_No);

        $pdf = new PDF();
        $pdf::SetTitle('รายงานลูกหนี้ประนอมหนี้');
        $pdf::AddPage('L', 'A4');
        $pdf::SetFont('thsarabunpsk', '', 12, '', true);
        $pdf::SetAutoPageBreak(TRUE, 20);

        $view = \View::make('legislation.reportCompro' ,compact('data','dataPay','dataDB','type','dataCount','status','newfdate','newtdate','SmartInfo','countDatasmart'));
        $html = $view->render();
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');
      }
      elseif ($type == 10){ //รายงานลูกหนี้ของกลาง
        $fdate = '';
        $tdate = '';
        $terminateexhibit = '';
        $typeexhibit = '';
        if ($request->has('Fromdate')){
          $fdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
        }
        if ($request->has('TerminateExhibit')){
          $terminateexhibit = $request->get('TerminateExhibit');
        }
        if ($request->has('Typeexhibit')) {
          $typeexhibit = $request->get('Typeexhibit');
        }
        $data = DB::table('legisexhibits')
                  ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                    return $q->whereBetween('Dateaccept_legis',[$fdate,$tdate]);
                  })
                  ->when(!empty($terminateexhibit), function($q) use($terminateexhibit){
                    return $q->where('Terminate_legis',$terminateexhibit);
                  })
                  ->when(!empty($typeexhibit), function($q) use($typeexhibit){
                    return $q->where('Typeexhibit_legis',$typeexhibit);
                  })
                  ->get();
        $pdf = new PDF();
        $pdf::SetTitle('รายงานลูกหนี้ของกลาง');
        $pdf::AddPage('L', 'A4');
        $pdf::SetMargins(5, 5, 5, 5);
        $pdf::SetFont('thsarabunpsk', '', 14, '', true);
        $pdf::SetAutoPageBreak(TRUE, 5);

        $view = \View::make('legislation.reportCompro' ,compact('data','type','dataCount','status','newfdate','newtdate'));
        $html = $view->render();
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');
      }
      elseif ($type == 15) { //รายงานบันทึกชำะค่างวด
        $dataDB = DB::table('legislations')
                ->join('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->join('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
                ->where('legislations.Contract_legis', '=', $request->Contract)
                ->get();

                $dataCount = count($dataDB);

        if ($dataCount != 0) {
          if ($dataDB[0]->Flag != "C") {
            $data = DB::connection('ibmi')
                  ->table('ASFHP.ARMAST')
                  ->join('ASFHP.INVTRAN','ASFHP.ARMAST.CONTNO','=','ASFHP.INVTRAN.CONTNO')
                  ->join('ASFHP.VIEW_CUSTMAIL','ASFHP.ARMAST.CUSCOD','=','ASFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->where('ASFHP.ARMAST.CONTNO','=', $dataDB[0]->Contract_legis)
                  ->first();
          }else {
            $data = DB::connection('ibmi')
                  ->table('SFHP.ARMAST')
                  ->join('SFHP.INVTRAN','SFHP.ARMAST.CONTNO','=','SFHP.INVTRAN.CONTNO')
                  ->join('SFHP.VIEW_CUSTMAIL','SFHP.ARMAST.CUSCOD','=','SFHP.VIEW_CUSTMAIL.CUSCOD')
                  ->where('SFHP.ARMAST.CONTNO','=', $dataDB[0]->Contract_legis)
                  ->first();
          }
        }else {
          dd('ไม่มีเลขที่สัญญานี้ไม่ระบบประนอมหนี้');
        }
        $pdf = new PDF();
        $pdf::SetTitle('รายงานบันทึกชำะค่างวด');
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(5, 5, 5, 5);
        $pdf::SetFont('freeserif', '', 8, '', true);

        $view = \View::make('legislation.reportCompro' ,compact('data','dataDB','type','dataCount','status','newfdate','newtdate'));
        $html = $view->render();
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');
      }
      elseif ($type == 17) { //รายงานลูกหนี้
        $newfdate = '';
        $newtdate = '';
        $status = '';

        if ($request->has('Fromdate')) {
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $newtdate = $request->get('Todate');
        }
        if ($request->has('status')) {
          $status = $request->get('status');
        }

        if($status == "ลูกหนี้ฟ้อง"){
          $data = DB::table('legislations')
                ->leftJoin('Legiscourtcases','legislations.id','=','Legiscourtcases.legislation_id')
                ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legiscourts.fillingdate_court',[$newfdate,$newtdate]);
                })
                ->where('legislations.KeyCourts_id','!=', NULL)
                ->where('legislations.Status_legis','=', NULL)
                ->where('legislations.Flag_status','=', '2')
                ->orderBy('legislations.id', 'DESC')
                ->get();

        }elseif ($status == "ลูกหนี้ยังไม่ฟ้อง") {
          $data = DB::table('legislations')
                ->leftJoin('Legiscourtcases','legislations.id','=','Legiscourtcases.legislation_id')
                ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legiscourts.fillingdate_court',[$newfdate,$newtdate]);
                })
                ->where('legislations.KeyCourts_id','=', NULL)
                ->where('legislations.Status_legis','=', NULL)
                ->where('legislations.Flag_status','=', '2')
                ->orderBy('legislations.id', 'DESC')
                ->get();

        }elseif ($status == "ลูกหนี้ปิดจบงาน"){
          $data = DB::table('legislations')
                ->leftJoin('Legiscourtcases','legislations.id','=','Legiscourtcases.legislation_id')
                ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legiscourts.fillingdate_court',[$newfdate,$newtdate]);
                })
                ->where('legislations.Status_legis','!=', NULL)
                ->where('legislations.Flag_status','=', '2')
                ->orderBy('legislations.id', 'DESC')
                ->get();

        }else {
          $data = DB::table('legislations')
                ->leftJoin('Legiscourtcases','legislations.id','=','Legiscourtcases.legislation_id')
                ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
                ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
                ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
                ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                  return $q->whereBetween('legiscourts.fillingdate_court',[$newfdate,$newtdate]);
                })
                ->where('legislations.Flag_status','=', '2')
                ->orderBy('legislations.id', 'DESC')
                ->get();

                $status = 'ลูกหนี้รวม';
              }

        if ($newfdate != NULL) {
          $Fdate = date('d-m-Y', strtotime($newfdate));
          $Tdate = date('d-m-Y', strtotime($newtdate));
        }else {
          $Fdate = "";
          $Tdate = "";
        }

        // dd($data);

        Excel::create('รายงานลูกหนี้', function ($excel) use($data,$status,$date,$Fdate,$Tdate) {
          $excel->sheet($status, function ($sheet) use($data,$status,$date,$Fdate,$Tdate) {
              $sheet->prependRow(1, array("บริษัท ชูเกียรติลิสซิ่ง จำกัด"));
              $sheet->prependRow(2, array("จากวันที่  ".$Fdate,"ถึงวันที่  ".$Tdate));
              $sheet->cells('A3:M3', function($cells) {
                $cells->setBackground('#FFCC00');
              });
              $row = 3;
              $sheet->row($row, array('เลขที่สัญญา','ชื่อ-นามสกุล','ยอดคงเหลือ','ยอดตั้งฟ้อง','เบอร์โทร','วันถืองาน','วันที่ฟ้อง','ระยะเวลา','สถานะลูกหนี้','สถานะทรัพย์','สถานะประนอมหนี้','วันที่ปิดงาน','ยอดชำระ','หมายเหตุ'));
              $Summperiod = 0;    //รวมยอดคงเหลือ
              $SumAmount = 0;
              $SumTextStatus = 0; //ยอดปิดบัญชี

              foreach ($data as $value) {
                $SumCourt = ($value->capital_court + $value->indictment_court + $value->pricelawyer_court);
                $Summperiod += $value->Sumperiod_legis;
                $SumAmount += $SumCourt;
                $SumTextStatus += $value->txtStatus_legis + ($value->Total_Promise - $value->Sum_Promise);

                if ($value->txtStatus_legis != NULL) {
                  $TextStatus = $value->txtStatus_legis;
                }else {
                  $TextStatus = $value->Total_Promise - $value->Sum_Promise;
                }

                //สถานะลูกหนี้
                if ($value->Status_legis != NULL) {
                  $SetText = $value->Status_legis;
                }
                else {
                  $SetText = 'รอฟ้อง';
                  $Newdate = date_create($date);

                  // วันที่สืบพยาน
                  if ($value->examiday_court != Null) {
                    $Tab1 = date_create($value->examiday_court);
                    $DateEx = date_diff($Newdate,$Tab1);
                    // วันที่ส่งจริง/ส่งคำบังคับ
                    if($value->fuzzy_court != Null){
                      $Tab1 = date_create($value->fuzzy_court);
                      $DateEx = date_diff($Newdate,$Tab1);
                    }
                    // วันที่ตรวจผลหมายจริง
                    if ($value->ordersend_court != Null) {
                      $Tab2 = date_create($value->ordersend_court);
                      $DateEx2 = date_diff($Newdate,$Tab2);
                    }elseif ($value->ordersend_court == Null) {
                      $Tab2 = date_create($value->orderday_court);
                      $DateEx2 = date_diff($Newdate,$Tab2);
                    }
                    // วันที่ตรวจผลหมาย
                    if ($value->checkday_court != Null) {
                      $Tab3 = date_create($value->checkday_court);
                      $DateEx3 = date_diff($Newdate,$Tab3);
                    }
                    // วันที่ตั้งเจ้าพนักงาน
                    if ($value->sendoffice_court != Null) {
                      $Tab4 = date_create($value->sendoffice_court);
                      $DateEx4 = date_diff($Newdate,$Tab4);
                    }elseif ($value->sendoffice_court == Null) {
                      $Tab4 = date_create($value->setoffice_court);
                      $DateEx4 = date_diff($Newdate,$Tab4);
                    }
                    // วันที่ตรวจผลหมายตั้ง
                    if ($value->sendcheckresults_court != Null) {
                      $Tab5 = date_create($value->sendcheckresults_court);
                      $DateEx5 = date_diff($Newdate,$Tab5);
                    }elseif ($value->sendcheckresults_court == Null) {
                      $Tab5 = date_create($value->checkresults_court);
                      $DateEx5 = date_diff($Newdate,$Tab5);
                    }
                    // เตรียมเอกสาร/ชั้นบังคับคดี
                    if ($value->datepreparedoc_case != Null) {
                      $Tab6 = date_create($value->datepreparedoc_case);
                      $DateEx6 = date_diff($Newdate,$Tab6);
                    }else {
                      $Tab6 = date_create("0000-00-00");
                      $DateEx6 = date_diff($Newdate,$Tab6);
                    }
                    // ยึดทรัพย์/ชั้นบังคับคดี
                    if ($value->datesetsequester_case != Null) {
                      $Tab7 = date_create($value->datesetsequester_case);
                      $DateEx7 = date_diff($Newdate,$Tab7);
                    }else {
                      $Tab7 = date_create("0000-00-00");
                      $DateEx7 = date_diff($Newdate,$Tab7);
                    }
                    // วันที่แจ้งความ/โกงเจ้าหนี้
                    if ($value->DateNotice_cheat != Null) {
                      $Tab8 = date_create($value->DateNotice_cheat);
                      $DateEx8 = date_diff($Newdate,$Tab8);
                    }else {
                      $Tab8 = date_create("0000-00-00");
                      $DateEx8 = date_diff($Newdate,$Tab8);
                    }

                    if($Newdate <= $Tab1){
                      if($DateEx->days <= 7){
                        $SetText = 'สืบพยาน';
                      }else {
                        $SetText = 'รอสืบพยาน';
                      }
                    }
                    elseif($Newdate <= $Tab2){
                      if($DateEx2->days <= 7){
                        $SetText = 'ส่งคำบังคับ';
                      }else {
                        $SetText = 'รอส่งคำบังคับ';
                      }
                    }
                    elseif($Newdate <= $Tab3){
                      if($DateEx3->days <= 7){
                        $SetText = 'ตรวจผลหมาย';
                      }else {
                        $SetText = 'รอตรวจผลหมาย';
                      }
                    }
                    elseif($Newdate <= $Tab4){
                      if($value->checksend_court != Null){
                        if($DateEx4->days <= 7){
                          $SetText = 'ตั้งเจ้าพนักงาน';
                        }else {
                          $SetText = 'รอตั้งเจ้าพนักงาน';
                        }
                      }else {
                        $SetText = 'รอผลตรวจหมายจริง';
                      }
                    }
                    elseif($Newdate <= $Tab5){
                      if($DateEx5->days <= 7){
                        $SetText = 'ตรวจผลหมายตั้ง';
                      }else {
                        $SetText = 'รอตรวจผลหมายตั้ง';
                      }
                    }
                    else{
                      if($Newdate <= $Tab6){    // เตรียมเอกสาร/ชั้นบังคับคดี
                        if($DateEx6->days <= 7){
                          $SetText = 'คัดโฉนด';
                        }else {
                          $SetText = 'รอคัดโฉนด';
                        }
                      }
                      elseif($Newdate <= $Tab7){  // ยึดทรัพย์/ชั้นบังคับคดี
                        if($DateEx7->days <= 7){
                          $SetText = 'ตั้งเรื่องยึดทรัพย์';
                        }else {
                          $SetText = 'รอตั้งเรื่องยึดทรัพย์';
                        }
                      }
                      elseif($value->resultsequester_case != Null){ // ประกาศขาย/ชั้นบังคับคดี
                        if($value->resultsequester_case == "ขายไม่ได้"){
                          $SetText = 'บังคับคดี/ขายไม่ได้';
                        }else {
                          if($value->resultsell_case == "เต็มจำนวน"){
                            $SetText = 'ขายได้/เต็มจำนวน';
                          }
                          elseif($value->resultsell_case == "ไม่เต็มจำนวน"){
                            $SetText = 'ขายได้/ไม่เต็มจำนวน';
                          }
                          else {
                            $SetText = 'รอผลจากการขาย';
                          }
                        }
                      }
                      elseif($Newdate <= $Tab8){  // โกงเจ้าหนี้
                        if($DateEx8->days <= 7){
                          $SetText = 'โกงเจ้าหนี้';
                        }else {
                          $SetText = 'โกงเจ้าหนี้';
                        }
                      }
                      else {
                        $SetText = 'รอขั้นตอนต่อไป';
                      }
                    }
                  }
                  else {
                    if($value->fillingdate_court == Null){
                      $SetText = "รอฟ้อง";
                    }
                    elseif($value->fillingdate_court != Null){
                      $SetText = "ฟ้อง";
                    }
                  }
                }
                //สถานะสืบทรัพย์
                if ($value->propertied_asset == "Y") {
                  $SetTextAsset = "มีทรัพย์";
                }elseif ($value->propertied_asset == "N") {
                  $SetTextAsset = "ไม่มีทรัพย์";
                }else {
                  $SetTextAsset = "ไม่มีข้อมูล";
                }
                //สถานะประนอมหนี้
                if ($value->Status_Promise != NULL) {
                  $SetTextCompro = $value->Status_Promise;
                }else {
                  if ($value->Date_Promise != NULL) {
                    $SetTextCompro = "ประนอมหนี้";
                  }else {
                    $SetTextCompro = "ไม่มีข้อมูล";
                  }
                }

                if ($value->DateUpState_legis != NULL) {
                  $SetDatelegis = Helper::formatDateThai($value->DateUpState_legis);

                  // $SetDatelegis = date('d-m-Y', strtotime($value->DateUpState_legis));
                }else {
                  $SetDatelegis = "";
                }

                //เพิ่ม 2 ฟิวด์
                if($value->fillingdate_court != Null){
                  $SetDatefillingdate = Helper::formatDateThai($value->fillingdate_court);
                }
                else{
                  $SetDatefillingdate = '';
                }
                $date = date('Y-m-d');
                //ระยะเวลางานข
                if($value->Status_legis != Null){
                  $Cldate = date_create($value->DateComplete_court);
                  $nowCldate = date_create($value->DateUpState_legis);
                  $ClDateDiff = date_diff($Cldate,$nowCldate);
                  $duration = $ClDateDiff->format("%a วัน");
                }
                else{
                  $Cldate = date_create($value->fillingdate_court);
                  $nowCldate = date_create($date);
                  $ClDateDiff = date_diff($Cldate,$nowCldate);
                  $duration = $ClDateDiff->format("%a วัน");
                }
                ///วันถืองาน
                if($value->DateComplete_court != Null){
                  $Cldate = date_create($value->Datesend_Flag);
                  $nowCldate = date_create($value->DateComplete_court);
                  $ClDateDiff = date_diff($Cldate,$nowCldate);
                  $date_carry = $ClDateDiff->format("%a วัน");
                }
                elseif($value->DateUpState_legis != Null){
                  $Cldate = date_create($value->Datesend_Flag);
                  $nowCldate = date_create($value->DateUpState_legis);
                  $ClDateDiff = date_diff($Cldate,$nowCldate);
                  $date_carry = $ClDateDiff->format("%a วัน");
                }
                elseif($value->DateComplete_court == Null){
                  $Cldate = date_create($value->Datesend_Flag);
                  $nowCldate = date_create($date);
                  $ClDateDiff = date_diff($Cldate,$nowCldate);
                  $date_carry = $ClDateDiff->format("%a วัน");
                }

                $sheet->row(++$row, array(
                  $value->Contract_legis,
                  $value->Name_legis,
                  number_format($value->Sumperiod_legis, 2),
                  number_format($SumCourt, 2),
                  $value->Phone_legis,
                  $date_carry,
                  $SetDatefillingdate,
                  $duration,
                  $SetText,
                  $SetTextAsset,
                  $SetTextCompro,
                  $SetDatelegis,
                  number_format($TextStatus, 2),
                  $value->Note
                ));

              }
              $sheet->appendRow(function($rows) {
                $rows->setBackground('#FFCC00');
              });
              $sheet->appendRow(array('รวมทั้งหมด','',number_format($Summperiod,2).'  บาท',number_format($SumAmount,2).'  บาท','','','','','','','','',number_format($SumTextStatus,2).'  บาท'));
          });
        })->export('xlsx');

      }
      elseif ($type == 18) {  //รายงานลูกหนี้สืบพยาน
        $newfdate = '';
        $newtdate = '';

        if ($request->has('Fromdate')) {
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $newtdate = $request->get('Todate');
        }

        $data = DB::table('legislations')
              ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
              ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('legiscourts.examiday_court',[$newfdate,$newtdate]);
              })
              ->orderBy('legiscourts.examiday_court', 'ASC')
              ->get();

        $pdf = new PDF();
        $pdf::SetTitle('รายงานลูกหนี้สิบพยาน');
        $pdf::AddPage('P', 'A4');
        $pdf::SetMargins(5, 5, 5, 5);
        $pdf::SetFont('freeserif', '', 8, '', true);

        $view = \View::make('legislation.reportLegis' ,compact('data','type','newfdate','newtdate'));
        $html = $view->render();
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');
      }
      elseif ($type == 19) {  //รายงานลูกหนี้สืบทรัพย์
        $newfdate = '';
        $newtdate = '';
        $status = '';

        if ($request->has('Fromdate')) {
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $newtdate = $request->get('Todate');
        }
        if ($request->has('status')) {
          $status = $request->get('status');
        }

        $data = DB::table('legislations')
              ->leftJoin('Legiscourtcases','legislations.id','=','Legiscourtcases.legislation_id')
              ->leftJoin('legiscourts','legislations.id','=','legiscourts.legislation_id')
              ->leftJoin('Legiscompromises','legislations.id','=','Legiscompromises.legisPromise_id')
              ->leftJoin('legisassets','legislations.id','=','legisassets.legisAsset_id')
              ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('legiscourts.examiday_court',[$newfdate,$newtdate]);
              })
              ->when(!empty($status), function($q) use($status){
                return $q->where('legisassets.propertied_asset',$status);
              })
              ->orderBy('legislations.id', 'DESC')
              ->get();

        foreach ($data as $value) {
          //สถานะลูกหนี้
          if ($value->Status_legis != NULL) {
            $SetText = $value->Status_legis;
          }
          else {
            $SetText = 'รอฟ้อง';
            $Newdate = date_create($date);

            // วันที่สืบพยาน
            if ($value->examiday_court != Null) {
              $Tab1 = date_create($value->examiday_court);
              $DateEx = date_diff($Newdate,$Tab1);
              // วันที่ส่งจริง/ส่งคำบังคับ
              if($value->fuzzy_court != Null){
                $Tab1 = date_create($value->fuzzy_court);
                $DateEx = date_diff($Newdate,$Tab1);
              }
              // วันที่ตรวจผลหมายจริง
              if ($value->ordersend_court != Null) {
                $Tab2 = date_create($value->ordersend_court);
                $DateEx2 = date_diff($Newdate,$Tab2);
              }elseif ($value->ordersend_court == Null) {
                $Tab2 = date_create($value->orderday_court);
                $DateEx2 = date_diff($Newdate,$Tab2);
              }
              // วันที่ตรวจผลหมาย
              if ($value->checkday_court != Null) {
                $Tab3 = date_create($value->checkday_court);
                $DateEx3 = date_diff($Newdate,$Tab3);
              }
              // วันที่ตั้งเจ้าพนักงาน
              if ($value->sendoffice_court != Null) {
                $Tab4 = date_create($value->sendoffice_court);
                $DateEx4 = date_diff($Newdate,$Tab4);
              }elseif ($value->sendoffice_court == Null) {
                $Tab4 = date_create($value->setoffice_court);
                $DateEx4 = date_diff($Newdate,$Tab4);
              }
              // วันที่ตรวจผลหมายตั้ง
              if ($value->sendcheckresults_court != Null) {
                $Tab5 = date_create($value->sendcheckresults_court);
                $DateEx5 = date_diff($Newdate,$Tab5);
              }elseif ($value->sendcheckresults_court == Null) {
                $Tab5 = date_create($value->checkresults_court);
                $DateEx5 = date_diff($Newdate,$Tab5);
              }
              // เตรียมเอกสาร/ชั้นบังคับคดี
              if ($value->datepreparedoc_case != Null) {
                $Tab6 = date_create($value->datepreparedoc_case);
                $DateEx6 = date_diff($Newdate,$Tab6);
              }else {
                $Tab6 = date_create("0000-00-00");
                $DateEx6 = date_diff($Newdate,$Tab6);
              }
              // ยึดทรัพย์/ชั้นบังคับคดี
              if ($value->datesetsequester_case != Null) {
                $Tab7 = date_create($value->datesetsequester_case);
                $DateEx7 = date_diff($Newdate,$Tab7);
              }else {
                $Tab7 = date_create("0000-00-00");
                $DateEx7 = date_diff($Newdate,$Tab7);
              }
              // วันที่แจ้งความ/โกงเจ้าหนี้
              if ($value->DateNotice_cheat != Null) {
                $Tab8 = date_create($value->DateNotice_cheat);
                $DateEx8 = date_diff($Newdate,$Tab8);
              }else {
                $Tab8 = date_create("0000-00-00");
                $DateEx8 = date_diff($Newdate,$Tab8);
              }

              if($Newdate <= $Tab1){
                if($DateEx->days <= 7){
                  $SetText = 'สืบพยาน';
                }else {
                  $SetText = 'รอสืบพยาน';
                }
              }
              elseif($Newdate <= $Tab2){
                if($DateEx2->days <= 7){
                  $SetText = 'ส่งคำบังคับ';
                }else {
                  $SetText = 'รอส่งคำบังคับ';
                }
              }
              elseif($Newdate <= $Tab3){
                if($DateEx3->days <= 7){
                  $SetText = 'ตรวจผลหมาย';
                }else {
                  $SetText = 'รอตรวจผลหมาย';
                }
              }
              elseif($Newdate <= $Tab4){
                if($value->checksend_court != Null){
                  if($DateEx4->days <= 7){
                    $SetText = 'ตั้งเจ้าพนักงาน';
                  }else {
                    $SetText = 'รอตั้งเจ้าพนักงาน';
                  }
                }else {
                  $SetText = 'รอผลตรวจหมายจริง';
                }
              }
              elseif($Newdate <= $Tab5){
                if($DateEx5->days <= 7){
                  $SetText = 'ตรวจผลหมายตั้ง';
                }else {
                  $SetText = 'รอตรวจผลหมายตั้ง';
                }
              }
              else{
                if($Newdate <= $Tab6){    // เตรียมเอกสาร/ชั้นบังคับคดี
                  if($DateEx6->days <= 7){
                    $SetText = 'คัดโฉนด';
                  }else {
                    $SetText = 'รอคัดโฉนด';
                  }
                }
                elseif($Newdate <= $Tab7){  // ยึดทรัพย์/ชั้นบังคับคดี
                  if($DateEx7->days <= 7){
                    $SetText = 'ตั้งเรื่องยึดทรัพย์';
                  }else {
                    $SetText = 'รอตั้งเรื่องยึดทรัพย์';
                  }
                }
                elseif($value->resultsequester_case != Null){ // ประกาศขาย/ชั้นบังคับคดี
                  if($value->resultsequester_case == "ขายไม่ได้"){
                    $SetText = 'บังคับคดี/ขายไม่ได้';
                  }else {
                    if($value->resultsell_case == "เต็มจำนวน"){
                      $SetText = 'ขายได้/เต็มจำนวน';
                    }
                    elseif($value->resultsell_case == "ไม่เต็มจำนวน"){
                      $SetText = 'ขายได้/ไม่เต็มจำนวน';
                    }
                    else {
                      $SetText = 'รอผลจากการขาย';
                    }
                  }
                }
                elseif($Newdate <= $Tab8){  // โกงเจ้าหนี้
                  if($DateEx8->days <= 7){
                    $SetText = 'โกงเจ้าหนี้';
                  }else {
                    $SetText = 'โกงเจ้าหนี้';
                  }
                }
                else {
                  $SetText = 'รอขั้นตอนต่อไป';
                }
              }
            }
            else {
              if($value->fillingdate_court == Null){
                $SetText = "รอฟ้อง";
              }
              elseif($value->fillingdate_court != Null){
                $SetText = "ฟ้อง";
              }
            }
          }

          $SetaArry[] = ['id_status' => $value->id, 'txt_status' => $SetText];
        }
              // dd($SetaArry);

        $pdf = new PDF();
        $pdf::SetTitle('รายงานลูกหนี้สิบทรัพย์');
        $pdf::AddPage('L', 'A4');
        $pdf::SetMargins(5, 5, 5, 5);
        // $pdf::SetFont('freeserif', '', 8, '', true);
        $pdf::SetFont('thsarabunpsk', '', 10, '', true);

        $view = \View::make('legislation.reportAsset' ,compact('data','type','newfdate','newtdate','status','SetaArry'));
        $html = $view->render();
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');
      }
      elseif ($type == 20) { //รายงานตรวจสอบยอดชำระ
        $newfdate = '';
        $newtdate = '';
        $CashReceiver = '';

        if ($request->has('Fromdate')) {
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
          $newtdate = Carbon::parse($tdate)->addDays(+1);
        }
        if ($request->has('CashReceiver')) {
          $CashReceiver = $request->get('CashReceiver');
        }
        // dd($newfdate,$newtdate,$CashReceiver);

        $data = DB::table('legislations')
              ->leftJoin('legispayments','legislations.id','=','legispayments.legis_Com_Payment_id')
              ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('legispayments.created_at',[$newfdate,$newtdate]);
              })
              ->when(!empty($CashReceiver), function($q) use($CashReceiver){
                  return $q->where('legispayments.Adduser_Payment','=',$CashReceiver);
                })
              ->orderBy('legispayments.created_at','ASC')
              ->get();

        $newtdate = Carbon::parse($tdate);

        $pdf = new PDF();
        $pdf::SetTitle('รายงานตรวจสอบยอดชำระ');
        $pdf::AddPage('L', 'A4');
        $pdf::SetFont('thsarabunpsk', '', 16, '', true);
        $pdf::SetMargins(10, 5, 5, 5);
        $pdf::SetAutoPageBreak(TRUE, 18);

        $view = \View::make('legislation.reportCompro' ,compact('data','type','dataCount','CashReceiver','newfdate','newtdate'));
        $html = $view->render();
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('report.pdf');

      }
    }
}
