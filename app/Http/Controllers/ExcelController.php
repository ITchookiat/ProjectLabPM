<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Exporter;

class ExcelController extends Controller
{

    public function excel(Request $request)
    {
      date_default_timezone_set('Asia/Bangkok');
      $today = date('Y-m-d');

      if($request->type == 1){
        $data = DB::table('recordcalls')
                  ->whereBetween('date_record',[$today,$today])
                  ->get()
                  ->toArray();

        $data_array[] = array('งานโทรค้าง 1 งวด รวมทุกสาขา');
        $data_array[] = array('ลำดับ', 'เลขที่สัญญา', 'ชื่อลูกค้า', 'วันดิว งวดแรก', 'เบอร์โทร', 'ค้างชำระ', 'หมายเหตุ');

        foreach($data as $key => $call){

          $date = date_create($call->fdate);
          $fdate = date_format($date, 'd-m-Y');

          $data_array[] = array(
          'ลำดับ' => $key+1,
          'เลขที่สัญญา' => $call->contno,
          'ชื่อลูกค้า' => $call->name,
          'วันดิว งวดแรก' => $fdate,
          'เบอร์โทร' => $call->tel,
          'ค้างชำระ' => $call->exp_amt,
          'หมายเหตุ' => ''
          );
          }
          $data_array = collect($data_array);
          // dd($data_array);
          $excel = Exporter::make('Excel');
          $excel->load($data_array);
          return $excel->stream('calldaily.xlsx');
      }
      elseif($request->type == 2){
        dd('ส่วนปัตตานี');
      }
      elseif($request->type == 3){  //รายงานสินเชื่อ
        date_default_timezone_set('Asia/Bangkok');
        $Y = date('Y');
        $Y2 = date('Y') +543;
        $m = date('m');
        $d = date('d');
        $date = $Y.'-'.$m.'-'.$d;
        $date2 = $d.'-'.$m.'-'.$Y2;

        $newfdate = '';
        $newtdate = '';
        $agen = '';
        $yearcar = '';
        $typecar = '';
        $branch = '';

        if ($request->has('Fromdate')) {
          $fdate = $request->get('Fromdate');
          $newfdate = \Carbon\Carbon::parse($fdate)->format('Y') ."-". \Carbon\Carbon::parse($fdate)->format('m')."-". \Carbon\Carbon::parse($fdate)->format('d');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
          $newtdate = \Carbon\Carbon::parse($tdate)->format('Y') ."-". \Carbon\Carbon::parse($tdate)->format('m')."-". \Carbon\Carbon::parse($tdate)->format('d');
        }
        if ($request->has('agen')) {
          $agen = $request->get('agen');
        }
        if ($request->has('yearcar')) {
          $yearcar = $request->get('yearcar');
        }
        if ($request->has('typecar')) {
          $typecar = $request->get('typecar');
        }
        if ($request->has('branch')) {
          $branch = $request->get('branch');
        }

        if ($request->get('Fromdate') == Null and $request->get('Todate') == Null) {
          $data = DB::table('buyers')
                    ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                    ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
                    ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->where('cardetails.Approvers_car','!=',Null)
                    ->where('buyers.Contract_buyer','not like', '22%')
                    ->where('buyers.Contract_buyer','not like', '33%')
                    ->orderBy('buyers.Date_Due', 'ASC')
                    ->get()
                    ->toArray();
        }else{
          $data = DB::table('buyers')
                    ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                    ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
                    ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->where('cardetails.Approvers_car','!=',Null)
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                      return $q->whereBetween('buyers.Date_Due',[$newfdate,$newtdate]);
                    })
                    ->when(!empty($agen), function($q) use($agen){
                      return $q->where('cardetails.Agent_car',$agen);
                    })
                    ->when(!empty($yearcar), function($q) use($yearcar){
                      return $q->where('cardetails.Year_car',$yearcar);
                    })
                    ->when(!empty($typecar), function($q) use($typecar){
                      return $q->where('cardetails.status_car',$typecar);
                    })
                    ->when(!empty($branch), function($q) use($branch){
                      return $q->where('cardetails.branch_car',$branch);
                    })
                    ->where('buyers.Contract_buyer','not like', '22%')
                    ->where('buyers.Contract_buyer','not like', '33%')
                    ->orderBy('buyers.Date_Due', 'ASC')
                    ->get()
                    ->toArray();
        }

        $data_array[] = array('ลำดับ', 'วันที่โอน', 'สถานะ', 'ยี่ห้อ', 'รุ่น', 'ทะเบียนเดิม', 'ทะเบียนใหม่', 'เลขสัญญา', 'ปี', 'ยอดจัด', 'พรบ.','ยอดปิดบัญชี','ซื้อประกัน', '%ยอดจัด', 'งวดผ่อน(เดือน)', 'ค่าใช้จ่ายขนส่ง', 'อื่นๆ', 'ค่าประเมิน',
                        'ค่าการตลาด', 'อากร','รวม คชจ', 'คงเหลือ', 'ค่าคอมก่อนหัก3%', 'ค่ค่าคอมหลังหัก3%', 'เอกสารผู้ค้ำ', 'ผู้รับเงิน', 'เลขที่บัญชี', 'เบอร์โทรผู้รับเงิน', 'ผู้รับค่าคอม', 'เลขที่บัญชี', 'เบอร์โทรผู้แนะนำ', 'ใบขับขี่', 'แถมประกัน'.'สถานะผู้เช่าซื้อ');

          foreach($data as $key => $row){
            $date = date_create($row->Date_Due);
            $Date_Due = date_format($date, 'd-m-Y');

            $data_array[] = array(
             'ลำดับ' => $key+1,
             'วันที่โอน' => $Date_Due,
             'สถานะ' => $row->status_car,
             'ยี่ห้อ' => $row->Brand_car,
             'รุ่น' => $row->Model_car,
             'ทะเบียนเดิม' => $row->License_car,
             'ทะเบียนใหม่' => $row->Nowlicense_car,
             'เลขสัญญา' => $row->Contract_buyer,
             'ปี' => $row->Year_car,
             'ยอดจัด' => $row->Top_car,
             'พรบ.' => $row->act_Price,
             'ยอดปิดบัญชี' => $row->closeAccount_Price,
             'ซื้อประกัน' => $row->P2_Price,
             'ดอกเบี้ย' => $row->Percent_car,
             'งวดผ่อน(เดือน)' => $row->Timeslacken_car,
             'ค่าใช้จ่ายขนส่ง' => $row->tran_Price,
             'อื่นๆ' => $row->other_Price,
             'ค่าประเมิน' => $row->evaluetion_Price,
             'ค่าการตลาด' => $row->marketing_Price,
             'อากร' => $row->duty_Price,
             'รวม คชจ.' => $row->totalk_Price,
             'คงเหลือ' => $row->balance_Price,
             'ค่าคอมก่อนหัก3%' => $row->Commission_car,
             'ค่าคอมหลังหัก3%' => $row->commit_Price,
             'เอกสารผู้ค้ำ' => $row->deednumber_SP,
             'ผู้รับเงิน' => $row->Payee_car,
             'เลขที่บัญช(ผู้รับเงิน)' => $row->Accountbrance_car,
             'เบอร์โทร(ผู้รับเงิน)' => $row->Tellbrance_car,
             'ผู้รับค่าคอม' => $row->Agent_car,
             'เลขที่บัญชี(รับคอม)' => $row->Accountagent_car,
             'เบอร์โทรผู้แนะนำ' => $row->Tellagent_car,
             'ใบขับขี่' => $row->Driver_buyer,
             'แถมประกัน' => $row->Insurance_car,
             'สถานะผู้เช่าซื้อ' => $row->Gradebuyer_car,
            );
          }
        $data_array = collect($data_array);
        $excel = Exporter::make('Excel');
        $excel->load($data_array);
        return $excel->stream('reportapprove.xlsx');
      }
      elseif($request->type == 4){
        dd('ส่วนนราธิวาส');
      }
      elseif($request->type == 5){
        dd('ส่วนสายบุรี');
      }
      elseif($request->type == 6){
        date_default_timezone_set('Asia/Bangkok');
        $Y = date('Y');
        $Y2 = date('Y') +543;
        $m = date('m');
        $d = date('d');
        $date = $Y.'-'.$m.'-'.$d;
        $date2 = $d.'-'.$m.'-'.$Y2;

        $newfdate = '';
        $newtdate = '';
        $agen = '';
        $yearcar = '';

        // dd($request->has('Fromdate'));

        if ($request->has('Fromdate')) {
          $fdate = $request->get('Fromdate');
          $newfdate = \Carbon\Carbon::parse($fdate)->format('Y') ."-". \Carbon\Carbon::parse($fdate)->format('m')."-". \Carbon\Carbon::parse($fdate)->format('d');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
          $newtdate = \Carbon\Carbon::parse($tdate)->format('Y') ."-". \Carbon\Carbon::parse($tdate)->format('m')."-". \Carbon\Carbon::parse($tdate)->format('d');
        }
        if ($request->has('agen')) {
          $agen = $request->get('agen');
        }
        if ($request->has('yearcar')) {
          $yearcar = $request->get('yearcar');
        }

        if ($request->get('Fromdate') == Null and $request->get('Todate') == Null) {
          $data = DB::table('buyers')
                    ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                    ->join('homecardetails','buyers.id','=','homecardetails.Buyerhomecar_id')
                    ->where('homecardetails.approvers_HC','!=',Null)
                    ->where('buyers.Contract_buyer','not like', '22%')
                    ->where('buyers.Contract_buyer','not like', '33%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get()
                    ->toArray();
        }else {
          $data = DB::table('buyers')
                    ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                    ->join('homecardetails','buyers.id','=','homecardetails.Buyerhomecar_id')
                    ->where('homecardetails.approvers_HC','!=',Null)
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                      return $q->whereBetween('buyers.Date_Due',[$newfdate,$newtdate]);
                    })
                    ->when(!empty($agen), function($q) use($agen){
                      return $q->where('homecardetails.agent_HC',$agen);
                    })
                    ->when(!empty($yearcar), function($q) use($yearcar){
                      return $q->where('homecardetails.year_HC',$yearcar);
                    })
                    ->where('buyers.Contract_buyer','not like', '22%')
                    ->where('buyers.Contract_buyer','not like', '33%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get()
                    ->toArray();
        }
        // dd($data);

        $data_array[] = array('ลำดับ', 'วันที่โอน', 'สถานะ', 'ยี่ห้อ', 'รุ่น', 'ทะเบียนเดิม', 'ทะเบียนใหม่', 'เลขสัญญา', 'ปี', 'ยอดจัด', 'ระยะเวลาผ่อน',
                              'ค่าคอม','นายหน้า', 'เบอร์โทรนายหน้า', 'ประกันภัย','ราคารถ','เงินดาวน์','ค่าโอน','ค่าประกัน');

        foreach($data as $key => $row){
          $date = date_create($row->Date_Due);
          $Date_Due = date_format($date, 'd-m-Y');

          $data_array[] = array(
           'ลำดับ' => $key+1,
           'วันที่โอน' => $Date_Due,
           'สถานะ' => $row->baab_HC,
           'ยี่ห้อ' => $row->brand_HC,
           'รุ่น' => $row->model_HC,
           'ทะเบียนเดิม' => $row->oldplate_HC,
           'ทะเบียนใหม่' => $row->newplate_HC,
           'เลขสัญญา' => $row->Contract_buyer,
           'ปี' => $row->year_HC,
           'ยอดจัด' => $row->topprice_HC,
           'ระยะเวลาผ่อน' => $row->period_HC,
           'ค่าคอม' => $row->commit_HC,
           'นายหน้า' => $row->agent_HC,
           'เบอร์โทรนายหน้า' => $row->tel_HC,
           'ประกันภัย' => $row->insurance_HC,
           'ราคารถ' => $row->price_HC,
           'เงินดาวน์' => $row->downpay_HC,
           'ค่าโอน' => $row->transfer_HC,
           'ค่าประกัน' => $row->insurancefee_HC,

          );
        }
        $data_array = collect($data_array);
        $excel = Exporter::make('Excel');
        $excel->load($data_array);
        return $excel->stream('reportappHomecar.xlsx');
      }
      elseif($request->type == 7){
        dd('ส่วนเบตง');
      }
      elseif($request->type == 11){  //รายงานปรับโครงสร้างหนี้
        date_default_timezone_set('Asia/Bangkok');
        $Y = date('Y');
        $Y2 = date('Y') +543;
        $m = date('m');
        $d = date('d');
        $date = $Y.'-'.$m.'-'.$d;
        $date2 = $d.'-'.$m.'-'.$Y2;

        $newfdate = '';
        $newtdate = '';
        $agen = '';
        $yearcar = '';
        $typecar = '';
        $branch = '';

        if ($request->has('Fromdate')) {
          $fdate = $request->get('Fromdate');
          $newfdate = \Carbon\Carbon::parse($fdate)->format('Y') ."-". \Carbon\Carbon::parse($fdate)->format('m')."-". \Carbon\Carbon::parse($fdate)->format('d');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
          $newtdate = \Carbon\Carbon::parse($tdate)->format('Y') ."-". \Carbon\Carbon::parse($tdate)->format('m')."-". \Carbon\Carbon::parse($tdate)->format('d');
        }
        // if ($request->has('agen')) {
        //   $agen = $request->get('agen');
        // }
        // if ($request->has('yearcar')) {
        //   $yearcar = $request->get('yearcar');
        // }
        // if ($request->has('typecar')) {
        //   $typecar = $request->get('typecar');
        // }
        // if ($request->has('branch')) {
        //   $branch = $request->get('branch');
        // }

        if ($request->get('Fromdate') == Null and $request->get('Todate') == Null) {
          $data = DB::table('buyers')
                    ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                    ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
                    ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->where('cardetails.Approvers_car','!=',Null)
                    ->where('buyers.Contract_buyer','like', '22%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get()
                    ->toArray();
        }else{
          $data = DB::table('buyers')
                    ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                    ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
                    ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->where('cardetails.Approvers_car','!=',Null)
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                      return $q->whereBetween('buyers.Date_Due',[$newfdate,$newtdate]);
                    })
                    // ->when(!empty($agen), function($q) use($agen){
                    //   return $q->where('cardetails.Agent_car',$agen);
                    // })
                    // ->when(!empty($yearcar), function($q) use($yearcar){
                    //   return $q->where('cardetails.Year_car',$yearcar);
                    // })
                    // ->when(!empty($typecar), function($q) use($typecar){
                    //   return $q->where('cardetails.status_car',$typecar);
                    // })
                    // ->when(!empty($branch), function($q) use($branch){
                    //   return $q->where('cardetails.branch_car',$branch);
                    // })
                    ->where('buyers.Contract_buyer','like', '22%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get()
                    ->toArray();
        }

        $data_array[] = array('ลำดับ', 'วันที่โอน', 'สถานะ', 'ยี่ห้อ', 'รุ่น', 'ทะเบียนเดิม', 'ทะเบียนใหม่', 'เลขสัญญา', 'ปี', 'ยอดจัด', 'พรบ.','ยอดปิดบัญชี','ซื้อประกัน', '%ยอดจัด', 'งวดผ่อน(เดือน)', 'ค่าใช้จ่ายขนส่ง', 'อื่นๆ', 'ค่าประเมิน',
                        'ค่าการตลาด', 'อากร','รวม คชจ', 'คงเหลือ', 'ค่าคอมก่อนหัก3%', 'ค่ค่าคอมหลังหัก3%', 'เอกสารผู้ค้ำ', 'ผู้รับเงิน', 'เลขที่บัญชี', 'เบอร์โทรผู้รับเงิน', 'ผู้รับค่าคอม', 'เลขที่บัญชี', 'เบอร์โทรผู้แนะนำ', 'ใบขับขี่', 'แถมประกัน','สถานะผู้เช่าซื้อ','คชจ. ปรับโครงสร้าง');

          foreach($data as $key => $row){
            $date = date_create($row->Date_Due);
            $Date_Due = date_format($date, 'd-m-Y');

            $data_array[] = array(
             'ลำดับ' => $key+1,
             'วันที่โอน' => $Date_Due,
             'สถานะ' => $row->status_car,
             'ยี่ห้อ' => $row->Brand_car,
             'รุ่น' => $row->Model_car,
             'ทะเบียนเดิม' => $row->License_car,
             'ทะเบียนใหม่' => $row->Nowlicense_car,
             'เลขสัญญา' => $row->Contract_buyer,
             'ปี' => $row->Year_car,
             'ยอดจัด' => $row->Top_car,
             'พรบ.' => $row->act_Price,
             'ยอดปิดบัญชี' => $row->closeAccount_Price,
             'ซื้อประกัน' => $row->P2_Price,
             'ดอกเบี้ย' => $row->Percent_car,
             'งวดผ่อน(เดือน)' => $row->Timeslacken_car,
             'ค่าใช้จ่ายขนส่ง' => $row->tran_Price,
             'อื่นๆ' => $row->other_Price,
             'ค่าประเมิน' => $row->evaluetion_Price,
             'ค่าการตลาด' => $row->marketing_Price,
             'อากร' => $row->duty_Price,
             'รวม คชจ.' => $row->totalk_Price,
             'คงเหลือ' => $row->balance_Price,
             'ค่าคอมก่อนหัก3%' => $row->Commission_car,
             'ค่าคอมหลังหัก3%' => $row->commit_Price,
             'เอกสารผู้ค้ำ' => $row->deednumber_SP,
             'ผู้รับเงิน' => $row->Payee_car,
             'เลขที่บัญช(ผู้รับเงิน)' => $row->Accountbrance_car,
             'เบอร์โทร(ผู้รับเงิน)' => $row->Tellbrance_car,
             'ผู้รับค่าคอม' => $row->Agent_car,
             'เลขที่บัญชี(รับคอม)' => $row->Accountagent_car,
             'เบอร์โทรผู้แนะนำ' => $row->Tellagent_car,
             'ใบขับขี่' => $row->Driver_buyer,
             'แถมประกัน' => $row->Insurance_car,
             'สถานะผู้เช่าซื้อ' => $row->Gradebuyer_car,
             'คชจ. ปรับโครงสร้าง' => 2500,
            );
          }
        $data_array = collect($data_array);
        $excel = Exporter::make('Excel');
        $excel->load($data_array);
        return $excel->stream('reportapprove.xlsx');
      }
      elseif($request->type == 14){  //รายงานมาตรการช่วยเหลือ
        date_default_timezone_set('Asia/Bangkok');
        $Y = date('Y');
        $Y2 = date('Y') +543;
        $m = date('m');
        $d = date('d');
        $date = $Y.'-'.$m.'-'.$d;
        $date2 = $d.'-'.$m.'-'.$Y2;

        $newfdate = '';
        $newtdate = '';
        $agen = '';
        $yearcar = '';
        $typecar = '';
        $branch = '';

        if ($request->has('Fromdate')) {
          $fdate = $request->get('Fromdate');
          $newfdate = \Carbon\Carbon::parse($fdate)->format('Y') ."-". \Carbon\Carbon::parse($fdate)->format('m')."-". \Carbon\Carbon::parse($fdate)->format('d');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
          $newtdate = \Carbon\Carbon::parse($tdate)->format('Y') ."-". \Carbon\Carbon::parse($tdate)->format('m')."-". \Carbon\Carbon::parse($tdate)->format('d');
        }
        // if ($request->has('agen')) {
        //   $agen = $request->get('agen');
        // }
        // if ($request->has('yearcar')) {
        //   $yearcar = $request->get('yearcar');
        // }
        // if ($request->has('typecar')) {
        //   $typecar = $request->get('typecar');
        // }
        // if ($request->has('branch')) {
        //   $branch = $request->get('branch');
        // }

        if ($request->get('Fromdate') == Null and $request->get('Todate') == Null) {
          $data = DB::table('buyers')
                    ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                    ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
                    ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->where('cardetails.Approvers_car','!=',Null)
                    ->where('buyers.Contract_buyer','like', '33%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get()
                    ->toArray();
        }
        else{
          $data = DB::table('buyers')
                    ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                    ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
                    ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->where('cardetails.Approvers_car','!=',Null)
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                      return $q->whereBetween('buyers.Date_Due',[$newfdate,$newtdate]);
                    })
                    // ->when(!empty($agen), function($q) use($agen){
                    //   return $q->where('cardetails.Agent_car',$agen);
                    // })
                    // ->when(!empty($yearcar), function($q) use($yearcar){
                    //   return $q->where('cardetails.Year_car',$yearcar);
                    // })
                    // ->when(!empty($typecar), function($q) use($typecar){
                    //   return $q->where('cardetails.status_car',$typecar);
                    // })
                    // ->when(!empty($branch), function($q) use($branch){
                    //   return $q->where('cardetails.branch_car',$branch);
                    // })
                    ->where('buyers.Contract_buyer','like', '33%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get()
                    ->toArray();
        }

        $data_array[] = array('ลำดับ','สาขา','วันที่อนุมัติ','เลขสัญญาเดิม','มาตรการช่วยเหลือ','เลขสัญญา','แบบ','ยี่ห้อ','ทะเบียน','ปี','ยอดจัด','ค่างวด','ระยะเวลาผ่อน','ยอดรวม','วันที่ชำระงวดแรก','ที่อยู่','เบอร์ติดต่อ');

          foreach($data as $key => $row){
            $date = date_create($row->Date_Due);
            $Date_Due = date_format($date, 'd-m-Y');
            $date2 = date_create($row->Dateduefirst_car);
            $Date_DueFirstcar = date_format($date2, 'd-m-Y');

            if($row->Loanofficer_car == 'นายต่วนมุหยีดีน ลอจิ' or $row->Loanofficer_car == 'นางวิธุกร ณ พิชัย' or $row->Loanofficer_car == 'นางวุฐิกุล ศุกลรัตน์'){
              $Branch = 'ปัตตานี';
            }
            elseif($row->Loanofficer_car == 'นายเดะมะ มะ' or $row->Loanofficer_car == 'นายมะยูโซะ อามะ' or $row->Loanofficer_car == 'นายฤทธิพร ดือราแม'){
              $Branch = 'ยะลา';
            }
            elseif($row->Loanofficer_car == 'น.ส.ฮายาตี นิบง' or $row->Loanofficer_car == 'นายซุลกิฟลี แมเราะ' or $row->Loanofficer_car == 'นายมัซวัน มะสาแม'){
              $Branch = 'นราธิวาส';
            }
            elseif($row->Loanofficer_car == 'นายฟิกรีย์ บาราเต๊ะ' or $row->Loanofficer_car == 'น.ส สาลีละห์ เจะโซะ'){
              $Branch = 'สายบุรี';
            }
            elseif($row->Loanofficer_car == 'นายฟาอีส อูมา' or $row->Loanofficer_car == 'สุภาพร สุขแดง'){
              $Branch = 'โกลก';
            }
            elseif($row->Loanofficer_car == 'น.ส.เพ็ญทิพย์ หนูบุญล้อม' or $row->Loanofficer_car == 'น.ส สาลีละห์ เจะโซะ'){
              $Branch = 'เบตง';
            }

            $data_array[] = array(
             'ลำดับ' => $key+1,
             'สาขา' => $Branch,
             'วันที่อนุมัติ' => $Date_Due,
             'เลขสัญญาเดิม' => $row->Note_car,
             'มาตรการช่วยเหลือ' => $row->Objective_car,
             'เลขสัญญา' => $row->Contract_buyer,
             'แบบ' => $row->status_car,
             'ยี่ห้อ' => $row->Brand_car,
             'ทะเบียน' => $row->License_car,
             'ปี' => $row->Year_car,
             'ยอดจัด' => number_format($row->Top_car,2),
             'ค่างวด' => $row->Pay_car,
             'ระยะเวลาผ่อน' => $row->Timeslacken_car,
             'ยอดรวม' => $row->Totalpay1_car,
             'วันที่ชำระงวดแรก' => $Date_DueFirstcar,
             'ที่อยู่' => $row->StatusAdd_buyer,
             'เบอร์ติดต่อ' => $row->Phone_buyer,
            );
          }
        $data_array = collect($data_array);
        $excel = Exporter::make('Excel');
        $excel->load($data_array);
        return $excel->stream('reportCovidapprove.xlsx');
      }
    }
}
