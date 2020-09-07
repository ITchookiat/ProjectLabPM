<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data_customer;
use DB;
use PDF;
use Exporter;

use App\Buyer;
use App\Sponsor;
use App\Sponsor2;
use App\Cardetail;
use App\Expenses;
use App\UploadfileImage;
use App\upload_lat_long;

class DataCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        // dd($type);
        $datenow = date('Y-m-d');
        // $datenow = date('Y-m-d', strtotime('-1 days'));
        $newfdate = '';
        $newtdate = '';
        $status = '';
        $typeLab = '';
        if ($request->has('Fromdate')) {
            $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
            $tdate = \Carbon\Carbon::parse($request->get('Todate'));
            $newtdate = $tdate->addDay();
        }
        if ($request->has('Status')) {
            if($request->get('Status') == 'ลูกค้าสอบถาม'){
                $status = 1;
            }elseif($request->get('Status') == 'ลูกค้าจัดสินเชื่อ'){
                $status = 2;
            }
        }
        if ($request->has('Typelab')) {
            $typeLab = $request->get('Typelab');
        }
        if ($request->has('Fromdate') == false and $request->has('Todate') == false) {
            $data = DB::table('data_customers')
            // ->where('created_at','like', $datenow.'%')
            ->where('created_at','>', $datenow)
            ->orderBY('created_at', 'DESC')
            ->get();
        }else {
            $data = DB::table('data_customers')
            ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('created_at',[$newfdate,$newtdate]);
            })
            ->when(!empty($status), function($q) use ($status) {
                return $q->where('Status_leasing','=', $status);
            })
            ->when(!empty($typeLab), function($q) use ($typeLab) {
                return $q->where('Type_leasing','=', $typeLab);
            })
            ->orderBY('created_at', 'ASC')
            ->get();
            }
        $newtdate = $request->get('Todate');
        return view('datacustomer.view', compact('data','type','newfdate','newtdate','status','typeLab'));
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
        // dd($request);
        if ($request->get('Topcar') != Null) {
            $SetTopcar = str_replace (",","",$request->get('Topcar'));
        }else {
            $SetTopcar = 0;
        }
        $Customerdb = new Data_customer([
            'License_car' => $request->get('Licensecar'),
            'Brand_car' => $request->get('Brandcar'),
            'Model_car' => $request->get('Modelcar'),
            'Typecardetails' => $request->get('Typecardetail'),
            'Top_car' => $SetTopcar,
            'Year_car' => $request->get('Yearcar'),
            'Name_buyer' => $request->get('Namebuyer'),
            'Last_buyer' => $request->get('Lastbuyer'),
            'Phone_buyer' => $request->get('Phonebuyer'),
            'IDCard_buyer' => $request->get('IDCardbuyer'),
            'Name_agent' => $request->get('Nameagent'),
            'Last_agent' => $request->get('Lastagent'),
            'Phone_agent' => $request->get('Phoneagent'),
            'Resource_news' => $request->get('News'),
            'Branch_car' => $request->get('branchcar'),
            'Note_car' => $request->get('Notecar'),
            'Name_user' => $request->get('Nameuser'),
            'Type_leasing' => $request->get('TypeLeasing'),
            'Status_leasing' => 1,
          ]);
          $Customerdb->save();
          return redirect()->back()->with('success','บันทึกเรียบร้อยแล้ว');
    }

    public function savestatus(Request $request, $value, $id)
    {
        $data = Data_customer::find($id);
          $data->Status_leasing = $value;

        $DateDue = date('Y-m-d');
        $Year = date('Y') + 543;
        $SetYear = substr($Year,2,3);

        ////////////////////////////////////
        if($data->Type_leasing == 'P03'){
            $Flag = 'N';
        }elseif($data->Type_leasing == 'P06'){
            $Flag = 'D';
        }elseif($data->Type_leasing == 'P07'){
            $Flag = 'D';
        }

        ////////////////////////////////////
        if($data->Branch_car == 'ปัตตานี'){
            $SetContract = $data->Type_leasing.'-'.$SetYear.'50'.'/';
        }
        elseif($data->Branch_car == 'ยะลา'){
            $SetContract = $data->Type_leasing.'-'.$SetYear.'51'.'/';
        }
        elseif($data->Branch_car == 'นราธิวาส'){
            $SetContract = $data->Type_leasing.'-'.$SetYear.'52'.'/';
        }
        elseif($data->Branch_car == 'สายบุรี'){
            $SetContract = $data->Type_leasing.'-'.$SetYear.'53'.'/';
        }
        elseif($data->Branch_car == 'โกลก'){
            $SetContract = $data->Type_leasing.'-'.$SetYear.'44'.'/';
        }
        elseif($data->Branch_car == 'เบตง'){
            $SetContract = $data->Type_leasing.'-'.$SetYear.'55'.'/';
        }
        elseif($data->Branch_car == 'โคกโพธิ์'){
            $SetContract = $data->Type_leasing.'-'.$SetYear.'56'.'/';
        }
        elseif($data->Branch_car == 'ตันหยงมัส'){
            $SetContract = $data->Type_leasing.'-'.$SetYear.'57'.'/';
        }
        elseif($data->Branch_car == 'บังนังสตา'){
            $SetContract = $data->Type_leasing.'-'.$SetYear.'58'.'/';
        }
        else{
            $SetContract = $data->Type_leasing.'-'.$SetYear.'00'.'/';
        }

        $Buyerdb = new Buyer([
            'Contract_buyer' => $SetContract,
            'Flag' => $Flag,
            'Type_Con' => $data->Type_leasing,
            'Date_Due' => $DateDue,
            'Name_buyer' => $data->Name_buyer,
            'last_buyer' => $data->Last_buyer,
            'Phone_buyer' => $data->Phone_buyer,
            'Idcard_buyer' => $data->IDCard_buyer,
            'Walkin_id' => $data->Customer_id,
          ]);
          $Buyerdb->save();

          $Sponsordb = new Sponsor([
            'Buyer_id' => $Buyerdb->id,
          ]);
          $Sponsordb->save();

          $Sponsor2db = new Sponsor2([
            'Buyer_id2' => $Buyerdb->id,
          ]);

          $Sponsor2db->save();

          $Cardetaildb = new Cardetail([
            'Buyercar_id' => $Buyerdb->id,
            'Brand_car' => $data->Brand_car,
            'Year_car' => $data->Year_car,
            'Typecardetails' => $data->Typecardetails,
            'License_car' => $data->License_car,
            'Top_car' => $data->Top_car,
            'Agentcar' => $data->Name_agent,
            'Tellagent_car' => $data->Phone_agent,
            'Loanofficer_car' => $data->Name_user,
            'StatusApp_car' => 'รออนุมัติ',
            'DocComplete_car' => $request->get('doccomplete'),
            'branch_car' => $data->Branch_car,
          ]);
          $Cardetaildb ->save();

          $Expensesdb = new Expenses([
            'Buyerexpenses_id' => $Buyerdb->id,
          ]);
          $Expensesdb ->save();

          $data->update();
          return redirect()->back()->with('success','บันทึกเรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $newfdate = '';
        $newtdate = '';
        $status = '';
        $typeLab = '';
        if ($request->has('Fromdate')) {
            $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
            $tdate = \Carbon\Carbon::parse($request->get('Todate'));
            $newtdate = $tdate->addDay();
        }
        if ($request->has('Status')) {
            $status = $request->get('Status');
        }
        if ($request->has('Typelab')) {
            $typeLab = $request->get('Typelab');
        }

        if ($request->has('Fromdate') == false and $request->has('Todate') == false) {
            $data = DB::table('data_customers')
            ->where('created_at','>', $datenow)
            ->orderBY('created_at', 'ASC')
            ->get();
            dd($typeLab);
        }else{
            $data = DB::table('data_customers')
            ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('created_at',[$newfdate,$newtdate]);
            })
            ->when(!empty($status), function($q) use ($status) {
                return $q->where('Status_leasing','=', $status);
            })
            ->when(!empty($typeLab), function($q) use ($typeLab) {
                return $q->where('Type_leasing','=', $typeLab);
            })
            ->orderBY('created_at', 'ASC')
            ->get();
        }
        $newtdate = $request->get('Todate');

        if($request->Type == 1){ //PDF
            $SetTopic = "WalkinPDFReport ".$datenow;

            $view = \View::make('datacustomer.reportWalkin' ,compact('data','type','newfdate','newtdate','status','datenow','typeLab'));
            $html = $view->render();
            $pdf = new PDF();
            $pdf::SetTitle('รายงานลูกค้า Walk in');
            $pdf::AddPage('L', 'A4');
            $pdf::SetMargins(10, 5, 10);
            $pdf::SetFont('thsarabunpsk', '', 16, '', true);
            $pdf::SetAutoPageBreak(TRUE, 21);
            $pdf::WriteHTML($html,true,false,true,false,'');
            $pdf::Output($SetTopic.'.pdf');
                
        }
        elseif($request->Type == 2){ //Excel
            $data_array[] = array('ลำดับ','วันที่','สาขา','ทะเบียน','ยี่ห้อ','รุ่น','ประเภทรถ','ปี', 'ยอดจัด', 'ชื่อ-สกุล ลูกค้า','เบอร์ลูกค้า','เลขบัตรประชาชน', 'ชื่อ-สกุล นายหน้า', 'เบอร์นายหน้า', 'หมายเหตุ', 'ที่มาลูกค้า','ประเภทเงินกู้','ประเภทลูกค้า','เจ้าหน้าที่ผู้คีย์');

            foreach($data as $key => $row){
                $date = date_create(substr($row->created_at,0,10));
                $Date_Due = date_format($date, 'd-m-Y');

                if($row->Status_leasing == 1){
                    $status = 'ลูกค้าสอบถาม';
                }elseif($row->Status_leasing == 2){
                    $status = 'ลูกค้าจัดสินเชื่อ';
                }

                $data_array[] = array(
                'ลำดับ' => $key+1,
                'วันที่' => $Date_Due,
                'สาขา' => $row->Branch_car,
                'ทะเบียน' => $row->License_car,
                'ยี่ห้อ' => $row->Brand_car,
                'รุ่น' => $row->Model_car,
                'ประเภทรถ' => $row->Typecardetails,
                'ปี' => $row->Year_car,
                'ยอดจัด' => number_format($row->Top_car,2),
                'ชื่อ-สกุล ลูกค้า' => $row->Name_buyer.' '.$row->Last_buyer,
                'เบอร์ลูกค้า' => $row->Phone_buyer,
                'เลขบัตรประชาชน' => $row->IDCard_buyer,
                'ชื่อ-สกุล นายหน้า' => $row->Name_agent,
                'เบอร์นายหน้า' => $row->Phone_agent,
                'หมายเหตุ' => $row->Note_car,
                'ที่มาลูกค้า' => $row->Resource_news,
                'ประเภทเงินกู้' => $row->Type_leasing,
                'ประเภทลูกค้า' => $status,
                'เจ้าหน้าที่ผู้คีย์' => $row->Name_user,
                );
            }
            $data_array = collect($data_array);
            $excel = Exporter::make('Excel');
            $excel->load($data_array);
            return $excel->stream('CustomerWalkin.xlsx');
        }
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
        // dd($id);
        $item1 = Data_customer::find($id);
        $item1->Delete();
        return redirect()->back()->with('success','ลบข้อมูลเรียบร้อยแล้ว');
    }
}
