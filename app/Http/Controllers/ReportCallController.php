<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use App\Recordcall;
use Carbon\Carbon;

class ReportCallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, $type)
     {
         //
         date_default_timezone_set('Asia/Bangkok');
         $today = date('Y-m-d');
         $date = date('Y-m-d', strtotime('-1 days'));

         $data_today = DB::table('recordcalls')
         ->select('CONTNO')
         ->where('date_record', '=', $date)
         ->orderBy('CONTNO', 'ASC')
         ->get();

         $sum_data_today = count($data_today);

         $data_0210 = DB::table('recordcalls')
                     ->where('CONTNO', 'not like', '01-%')
                     ->where('CONTNO', 'not like', '03-%')
                     ->where('CONTNO', 'not like', '04-%')
                     ->where('CONTNO', 'not like', '05-%')
                     ->where('CONTNO', 'not like', '06-%')
                     ->where('CONTNO', 'not like', '07-%')
                     ->where('date_record', '=', $date)
                     ->get();

         $flag1 = true;              $count1 = [];
         $flag2 = false;             $count2 = [];
         $flag3 = false;             $count3 = [];
         $flag4 = false;             $count4 = [];
         $flag5 = false;             $count5 = [];
         $flag6 = false;             $count6 = [];
         $flag7 = false;             $count7 = [];
         $flag8 = false;             $count8 = [];
         $flag9 = false;             $count9 = [];
         $flag10 = false;            $count10 = [];
         $flag11 = false;            $count11 = [];
         $flag12 = false;            $count12 = [];
         $flag13 = false;            $count13 = [];
         $flag14 = false;            $count14 = [];
         $flag15 = false;            $count15 = [];
         $flag16 = false;            $count16 = [];

         foreach ($data_0210 as $key => $value) {
         if($flag1 == true){
         $count1[] = $data_0210[$key];
         $flag1 = false;
         $flag2 = true;

         } elseif($flag2 == true){
         $count2[] = $data_0210[$key];
         $flag2 = false;
         $flag3 = true;

         } elseif($flag3 == true){
         $count3[] = $data_0210[$key];
         $flag3 = false;
         $flag4 = true;

         }elseif($flag4 == true){
         $count4[] = $data_0210[$key];
         $flag4 = false;
         $flag5 = true;

         }elseif($flag5 == true){
         $count5[] = $data_0210[$key];
         $flag5 = false;
         $flag6 = true;

         }elseif($flag6 == true){
         $count6[] = $data_0210[$key];
         $flag6 = false;
         $flag7 = true;

         }elseif($flag7 == true){
         $count7[] = $data_0210[$key];
         $flag7 = false;
         $flag8 = true;

         }elseif($flag8 == true){
         $count8[] = $data_0210[$key];
         $flag8 = false;
         $flag9 = true;

         }elseif($flag9 == true){
         $count9[] = $data_0210[$key];
         $flag9 = false;
         $flag10 = true;

         }elseif($flag10 == true){
         $count10[] = $data_0210[$key];
         $flag10 = false;
         $flag11 = true;

         }elseif($flag11 == true){
         $count11[] = $data_0210[$key];
         $flag11 = false;
         $flag12 = true;

         }elseif($flag12 == true){
         $count12[] = $data_0210[$key];
         $flag12 = false;
         $flag13 = true;

         }elseif($flag13 == true){
         $count13[] = $data_0210[$key];
         $flag13 = false;
         $flag14 = true;

         }elseif($flag14 == true){
         $count14[] = $data_0210[$key];
         $flag14 = false;
         $flag15 = true;

         }elseif($flag15 == true){
         $count15[] = $data_0210[$key];
         $flag15 = false;
         $flag16 = true;

         }elseif($flag16 == true){
         $count16[] = $data_0210[$key];
         $flag16 = false;
         $flag1 = true;

         }
         }

         $pattani = collect([$count1,$count10])->collapse();
         $yala = collect([$count2,$count5])->collapse();
         $nara = collect([$count11,$count16,$count8])->collapse();
         $saiburi  = collect([$count4,$count13,$count7])->collapse();
         $kolok = collect([$count3,$count9,$count15])->collapse();
         $betong = collect([$count12,$count14,$count6])->collapse();

         if ($request->type == 1){
           $data_all = DB::table('recordcalls')
           ->where('date_record', '=', $date)
           ->orderBy('CONTNO', 'ASC')
           ->get();
           $sum_data_all = count($data_all);
         }

         if ($request->type == 2){
           $data_pt = DB::table('recordcalls')
           ->where('CONTNO', 'like', '01-%')
           ->where('date_record', '=', $date)
           ->orderBy('CONTNO', 'ASC')
           ->get();
           $sum_data_pt = count($data_pt);
         }

         if ($request->type == 3){
           $data_yl = DB::table('recordcalls')
           ->where('CONTNO', 'like', '03-%')
           ->where('date_record', '=', $date)
           ->orderBy('CONTNO', 'ASC')
           ->get();
           $sum_data_yl = count($data_yl);
         }

         if ($request->type == 4){
           $data_nr = DB::table('recordcalls')
           ->where('CONTNO', 'like', '04-%')
           ->where('date_record', '=', $date)
           ->orderBy('CONTNO', 'ASC')
           ->get();
           $sum_data_nr = count($data_nr);
         }

         if ($request->type == 5){
           $data_sb = DB::table('recordcalls')
           ->where('CONTNO', 'like', '05-%')
           ->where('date_record', '=', $date)
           ->orderBy('CONTNO', 'ASC')
           ->get();
           $sum_data_sb = count($data_sb);
         }

         if ($request->type == 6){
           $data_kl = DB::table('recordcalls')
           ->where('CONTNO', 'like', '06-%')
           ->where('date_record', '=', $date)
           ->orderBy('CONTNO', 'ASC')
           ->get();
           $sum_data_kl = count($data_kl);
         }

         if ($request->type == 7){
           $data_bt = DB::table('recordcalls')
           ->where('CONTNO', 'like', '07-%')
           ->where('date_record', '=', $date)
           ->orderBy('CONTNO', 'ASC')
           ->get();
           $sum_data_bt = count($data_bt);
         }

         $ReportType = $request->type;

         $view = \View::make('call.reportAll', compact('ReportType', 'data_all','data_pt', 'data_yl', 'data_nr','data_sb', 'data_kl', 'data_bt',
          'pattani', 'yala', 'nara', 'saiburi', 'kolok', 'betong'));
         $html = $view->render();

         $pdf = new PDF();
        if ($request->type == 1) {
           $pdf::SetTitle('รายงานงานโทรทุกสาขา');
           $pdf::AddPage('P', 'A4');
         }elseif ($request->type == 2) {
           $pdf::SetTitle('รายงานงานโทรสาขาปัตตานี');
           $pdf::AddPage('P', 'A4');
         }elseif ($request->type == 3) {
           $pdf::SetTitle('รายงานงานโทรสาขายะลา');
           $pdf::AddPage('P', 'A4');
         }elseif ($request->type == 4) {
           $pdf::SetTitle('รายงานงานโทรสาขานราธิวาส');
           $pdf::AddPage('P', 'A4');
         }elseif ($request->type == 5) {
           $pdf::SetTitle('รายงานงานโทรสาขาสายบุรี');
           $pdf::AddPage('P', 'A4');
         }elseif ($request->type == 6) {
           $pdf::SetTitle('รายงานงานโทรสาขาสุไงโก-ลก');
           $pdf::AddPage('P', 'A4');
         }elseif ($request->type == 7) {
           $pdf::SetTitle('รายงานงานโทรสาขาเบตง');
           $pdf::AddPage('P', 'A4');
         }

         $pdf::SetMargins(5, 5, 6);

         $pdf::SetFont('freeserif', 8);
         $pdf::SetAutoPageBreak(TRUE, 18.5);

         $pdf::WriteHTML($html,true,false,true,false,'');
         $pdf::lastPage();
         $pdf::Output('reportcall.pdf');

     }

    public function store(Request $request)
    {

      if($request->get('date') == ''){
      $date = date('Y-m-d', strtotime('-1 days'));
      }else{
      $date = $request->get('date');
      }

      $SetContno = $request->get('contno');
      $SetName = $request->get('name');
      $SetFdate = $request->get('fdate');
      $SetTel = $request->get('tel');
      $SetExpamt = $request->get('exp_amt');
      $SetExpfrm = $request->get('exp_frm');
      $SetExpto = $request->get('exp_to');
      $SetPrd = $request->get('exp_prd');
      $SetHldno = $request->get('hldno');
      $array_len = count($SetContno);

      for($i=0; $i<$array_len; $i++){

          $Contno = $SetContno[$i];
          $Name = $SetName[$i];
          $Fdate = $SetFdate[$i];
          $Tel = $SetTel[$i];
          $AMT = $SetExpamt[$i];
          $FRM = $SetExpfrm[$i];
          $To = $SetExpto[$i];
          $PRD = $SetPrd[$i];
          $Hldno = $SetHldno[$i];
          $recordcalldb = new Recordcall([
            'CONTNO' => $Contno,
            'name' => $Name,
            'fdate' => $Fdate,
            'tel' => $Tel,
            'exp_amt' => $AMT,
            'exp_frm' => $FRM,
            'exp_to' => $To,
            'exp_prd' => $PRD,
            'HLDNO' => $Hldno,
            'date_record' => $date,
          ]);
          $recordcalldb->save();
      }
      $type = 1;
      return redirect()->Route('call', $type)->with('success','บันทึกข้อมูลเรียบร้อย');

      }
      public function update(Request $request, $type)
      {

        $SetContno = $request->get('contno');
        $SetLhldo = $request->get('l_hldno');
        $SetPaid = $request->get('paid');
        $array_len = count($SetContno);

        for($i=0; $i<$array_len; $i++){

            $Contno = $SetContno[$i];
            $l_hldno = $SetLhldo[$i];
            $Paid = $SetPaid[$i];

            $update = DB::table('recordcalls')
                    ->whereIn('CONTNO', [$Contno])
                    ->update(['l_hldno' => $l_hldno]);

            $update1 = DB::table('recordcalls')
                    ->whereIn('CONTNO', [$Contno])
                    ->update(['pay_status' => $Paid]);

          }

        return redirect()->Route('call', $type)->with('success','อัพเดทข้อมูลเรียบร้อย');

        }

        public function updategroup(Request $request, $type)
       {
         $SetGroup = $request->get('group');
         $SetContno1 = $request->get('contno1');
         $SetContno2 = $request->get('contno2');
         if($SetContno1 == ''){
           $SetContno1 = [];
         }
         $SetContno = array_merge($SetContno1,$SetContno2);

         $array_len = count($SetContno);

         for($i=0; $i<$array_len; $i++){

             $Contno = $SetContno[$i];

             $updateG = DB::table('recordcalls')
                     ->whereIn('CONTNO', [$Contno])
                     ->update(['group' => $SetGroup]);
           }
         $type = 1;
         return redirect()->Route('call', $type)->with('success','อัพเดทข้อมูลเรียบร้อย');

         }

        public function monthReport(Request $request, $type, $fdate, $tdate){

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

        $ReportType = $request->type;

        $view = \View::make('call.reportAll', compact('ReportType', 'fdate','tdate',
        'sum_all_month_0','sum_pt_month_0','sum_yl_month_0','sum_nr_month_0','sum_sb_month_0','sum_kl_month_0','sum_bt_month_0',
        'sum_all_month_l1','sum_pt_month_l1','sum_yl_month_l1','sum_nr_month_l1','sum_sb_month_l1','sum_kl_month_l1','sum_bt_month_l1',
        'sum_all_month_1','sum_pt_month_1','sum_yl_month_1','sum_nr_month_1','sum_sb_month_1','sum_kl_month_1','sum_bt_month_1'));
        $html = $view->render();

        $pdf = new PDF();
        $pdf::SetTitle('รายงานการโทรไฟแนนซ์ลูกค้าค้างประจำเดือน ');
        $pdf::AddPage('P', 'A4');

        $pdf::SetMargins(5, 5, 6);

        $pdf::SetFont('freeserif', 28);
        // $pdf::SetAutoPageBreak(TRUE, 18.5);

        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::lastPage();
        $pdf::Output('monthreport.pdf');
      }
}
