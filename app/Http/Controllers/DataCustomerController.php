<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data_customer;
use DB;

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
        $newfdate = '';
        $newtdate = '';
        $data = DB::table('data_customers')
              ->orderBY('created_at', 'DESC')
              ->get();
        return view('datacustomer.view', compact('data','type','newfdate','newtdate'));
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
            'Phone_buyer' => $request->get('Phonebuyer'),
            'IDCard_buyer' => $request->get('IDCardbuyer'),
            'Name_agent' => $request->get('Nameagent'),
            'Phone_agent' => $request->get('Phoneagent'),
            'Resource_news' => $request->get('News'),
            'Branch_car' => $request->get('branchcar'),
            'Note_car' => $request->get('Notecar'),
            // 'Type_leasing' => $request->get('TypeLeasing'),
            'Status_leasing' => 1,
          ]);
          $Customerdb->save();
          return redirect()->back()->with('success','บันทึกเรียบร้อยแล้ว');
    }

    public function savestatus(Request $request, $value, $id)
    {
        $data = Data_customer::find($id);
          $data->Status_leasing = $value;
        $data->update();

        if($data->Name_buyer != Null){
            $SetStr = explode(" ",$data->Name_buyer);
            $Name_buyer = $SetStr[0];
            $last_buyer = $SetStr[1];
        }else{
            $Name_buyer = '';
            $last_buyer = '';
        }
        $DateDue = date('Y-m-d');
        $SetYear = date('Y') + 543;
        if($data->Branch_car == 'ปัตตานี'){
            $SetContract = '01-'.$SetYear.'/';
        }elseif($data->Branch_car == 'ยะลา'){
            $SetContract = '03-'.$SetYear.'/';
        }elseif($data->Branch_car == 'นราธิวาส'){
            $SetContract = '04-'.$SetYear.'/';
        }elseif($data->Branch_car == 'สายบุรี'){
            $SetContract = '05-'.$SetYear.'/';
        }elseif($data->Branch_car == 'โกลก'){
            $SetContract = '06-'.$SetYear.'/';
        }elseif($data->Branch_car == 'เบตง'){
            $SetContract = '07-'.$SetYear.'/';
        }else{
            $SetContract = '00-'.$SetYear.'/';
        }

        $Buyerdb = new Buyer([
            'Contract_buyer' => $SetContract,
            'Date_Due' => $DateDue,
            'Name_buyer' => $Name_buyer,
            'last_buyer' => $last_buyer,
            'Phone_buyer' => $data->Phone_buyer,
            'Idcard_buyer' => $data->IDCard_buyer,
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
            'Commission_car' => $data->Name_agent,
            'Tellagent_car' => $data->Phone_agent,
            'StatusApp_car' => 'รออนุมัติ',
            'DocComplete_car' => $request->get('doccomplete'),
            'branch_car' => $data->Branch_car,
          ]);
          $Cardetaildb ->save();
          $Expensesdb = new Expenses([
            'Buyerexpenses_id' => $Buyerdb->id,
          ]);
          $Expensesdb ->save();
          return redirect()->back()->with('success','บันทึกเรียบร้อยแล้ว');
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
        dd($id);
    }
}
