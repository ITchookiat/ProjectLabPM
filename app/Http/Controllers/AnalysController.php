<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use File;

use App\Buyer;
use App\Sponsor;
use App\Sponsor2;
use App\Cardetail;
use App\homecardetail;
use App\UploadfileImage;
use App\upload_lat_long;
use App\Expenses;
use Carbon\Carbon;
use Helper;

class AnalysController extends Controller
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

      if ($request->type == 1){ //สินเชื่อ
        $contno = '';
        $newfdate = '';
        $newtdate = '';
        $branch = '';
        $status = '';

        if ($request->has('Fromdate')) {
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $newtdate = $request->get('Todate');
        }
        if ($request->has('branch')) {
          $branch = $request->get('branch');
        }
        if ($request->has('status')) {
          $status = $request->get('status');
        }
        if ($request->has('Contno')) {
          $contno = $request->get('Contno');
        }

        if ($request->has('Fromdate') == false and $request->has('Todate') == false) {
          $data = DB::table('buyers')
              ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
              ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
              ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
              ->where('cardetails.Date_Appcar','=',Null)
              ->where('buyers.Contract_buyer','not like', '22%')
              ->where('buyers.Contract_buyer','not like', '33%')
              ->orderBy('buyers.Contract_buyer', 'ASC')
              ->get();
        }else {
          $data = DB::table('buyers')
            ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
              ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
              ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
              ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('buyers.Date_Due',[$newfdate,$newtdate]);
              })
              ->when(!empty($branch), function($q) use($branch){
                return $q->where('cardetails.branch_car',$branch);
              })
              ->when(!empty($status), function($q) use($status){
                return $q->where('cardetails.StatusApp_car','=',$status);
              })
              ->when(!empty($contno), function($q) use($contno){
                return $q->where('buyers.Contract_buyer','=',$contno);
              })
              ->where('buyers.Contract_buyer','not like', '22%')
              ->where('buyers.Contract_buyer','not like', '33%')
              ->orderBy('buyers.Contract_buyer', 'ASC')
              ->get();

        }

        // dd($data);
        $type = $request->type;
        $newfdate = \Carbon\Carbon::parse($newfdate)->format('Y') ."-". \Carbon\Carbon::parse($newfdate)->format('m')."-". \Carbon\Carbon::parse($newfdate)->format('d');
        $newtdate = \Carbon\Carbon::parse($newtdate)->format('Y') ."-". \Carbon\Carbon::parse($newtdate)->format('m')."-". \Carbon\Carbon::parse($newtdate)->format('d');

        $topcar = DB::table('buyers')
          ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
          ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
          ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
          ->whereBetween('buyers.Date_Due',[$newfdate,$newtdate])
          ->where('buyers.Contract_buyer','not like', '22%')
          ->where('buyers.Contract_buyer','not like', '33%')
          ->get();
        $count = count($topcar);

        if($count != 0){
            for ($i=0; $i < $count; $i++) {
            @$SumTopcar += $topcar[$i]->Top_car; //รวมยอดจัดวันปัจจุบัน
            @$SumCommissioncar += $topcar[$i]->Commission_car; //รวมค่าคอมก่อนหักวันปัจจุบัน
            @$SumCommitprice += $topcar[$i]->commit_Price; //รวมค่าคอมหลังหักวันปัจจุบัน
            }
        }else{
            $SumTopcar = 0;
            $SumCommissioncar = 0;
            $SumCommitprice = 0;
        }

        return view('analysis.view', compact('type', 'data','branch','newfdate','newtdate','status','Setdate','SumTopcar','SumCommissioncar','SumCommitprice','contno','SetStrConn','SetStr1','SetStr2'));
      }
      elseif ($request->type == 2){ //เพิ่มสินเชื่อ
        return view('analysis.createbuyer');
      }
      elseif ($request->type == 3){ //รายงาน สินเชื่อ
        $datadrop = DB::table('buyers')
        ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
        ->select('cardetails.Agent_car', DB::raw('count(*) as total'))
        ->where('cardetails.Agent_car','<>',Null)
        ->where('buyers.Contract_buyer','not like', '22%')
        ->where('buyers.Contract_buyer','not like', '33%')
        ->groupBy('cardetails.Agent_car')
        ->get();

        $datayear = DB::table('buyers')
        ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
        ->select('cardetails.Year_car', DB::raw('count(*) as total'))
        ->where('cardetails.Year_car','<>',Null)
        ->where('buyers.Contract_buyer','not like', '22%')
        ->where('buyers.Contract_buyer','not like', '33%')
        ->groupBy('cardetails.Year_car')
        ->get();

        $datastatus = DB::table('buyers')
        ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
        ->select('cardetails.status_car', DB::raw('count(*) as total'))
        ->where('cardetails.status_car','<>',Null)
        ->where('buyers.Contract_buyer','not like', '22%')
        ->where('buyers.Contract_buyer','not like', '33%')
        ->groupBy('cardetails.status_car')
        ->get();

        $databranch = DB::table('buyers')
        ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
        ->select('cardetails.branch_car', DB::raw('count(*) as total'))
        ->where('cardetails.branch_car','<>',Null)
        ->where('buyers.Contract_buyer','not like', '22%')
        ->where('buyers.Contract_buyer','not like', '33%')
        ->groupBy('cardetails.branch_car')
        ->get();

        $newfdate = '';
        $newtdate = '';
        $agen = '';
        $yearcar = '';
        $typecar = '';
        $branch = '';

        if ($request->has('Fromdate')) {
          $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
          $newtdate = $request->get('Todate');
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


        if ($request->has('Fromdate') == false and $request->has('Todate') == false and $request->has('agen') == false) {
          $data = DB::table('buyers')
            ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
            ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
            ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
            ->where('cardetails.Approvers_car','!=',Null)
            ->where('buyers.Contract_buyer','not like', '22%')
            ->where('buyers.Contract_buyer','not like', '33%')
            ->orderBy('buyers.Contract_buyer', 'ASC')
            ->get();
        }else {
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
            ->orderBy('buyers.Contract_buyer', 'ASC')
            ->get();
        }

        // dd($data);
        if ($newfdate != '' and $newtdate != '') {
          $newfdate = \Carbon\Carbon::parse($newfdate)->format('Y') ."-". \Carbon\Carbon::parse($newfdate)->format('m')."-". \Carbon\Carbon::parse($newfdate)->format('d');
          $newtdate = \Carbon\Carbon::parse($newtdate)->format('Y') ."-". \Carbon\Carbon::parse($newtdate)->format('m')."-". \Carbon\Carbon::parse($newtdate)->format('d');
        }elseif ($newfdate == '' or $newtdate == '') {
        }
        $type = $request->type;
        return view('analysis.viewReport', compact('type', 'data','newfdate','newtdate','datadrop','agen','datedue','datayear','yearcar','datastatus','typecar','databranch','branch'));
      }
      elseif ($request->type == 7){ //รายงานส่งผู้บริหาร
        $approvedate = date('Y-m-d');
        $fdate = date('Y-m-d');
        $tdate = date('Y-m-d');
        if ($request->has('Approvedate')) {
          $approvedate = $request->get('Approvedate');
          $approvedate = \Carbon\Carbon::parse($approvedate)->format('Y') ."-". \Carbon\Carbon::parse($approvedate)->format('m')."-". \Carbon\Carbon::parse($approvedate)->format('d');
        }
        if ($request->has('Fromdate')) {
          $fdate = $request->get('Fromdate');
          $fdate = \Carbon\Carbon::parse($fdate)->format('Y') ."-". \Carbon\Carbon::parse($fdate)->format('m')."-". \Carbon\Carbon::parse($fdate)->format('d');
        }
        if ($request->has('Todate')) {
          $tdate = $request->get('Todate');
          $tdate = \Carbon\Carbon::parse($tdate)->format('Y') ."-". \Carbon\Carbon::parse($tdate)->format('m')."-". \Carbon\Carbon::parse($tdate)->format('d');
        }
        $dataReport = DB::table('buyers')
                        ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                        ->join('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                        ->join('Expenses','Buyers.id','=','Expenses.Buyerexpenses_id')
                        ->when(!empty($fdate)  && !empty($tdate), function($q) use ($fdate, $tdate) {
                          return $q->whereBetween('cardetails.Date_Appcar',[$fdate,$tdate]);
                        })
                        ->where('cardetails.Approvers_car','<>','')
                        ->orderBy('buyers.Contract_buyer', 'ASC')
                        ->get();
        $type = $request->type;
        return view('analysis.viewReport', compact('type', 'dataReport','approvedate','fdate','tdate'));
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
      $BeforeIncome = str_replace (",","",$request->get('Beforeincome'));
      $AfterIncome = str_replace (",","",$request->get('Afterincome'));
      if($BeforeIncome == ''){
        $BeforeIncome = '0';
      }
      if($AfterIncome == ''){
        $AfterIncome = '0';
      }

      //สร้างเลขที่ สัญญา
      if ($request->get('TypeContract') != NULL) {
        $SetDateConn = \Carbon\Carbon::parse($request->get('DateDue'))->format('Y') +543;
        $SubStr = substr($SetDateConn,2,3);
        $StrConn = $request->get('TypeContract').$SubStr.$request->get('BrachUser')."/";
      }

      $Buyerdb = new Buyer([
        'Contract_buyer' => $StrConn,
        'Date_Due' => $request->get('DateDue'),
        'Name_buyer' => $request->get('Namebuyer'),
        'last_buyer' => $request->get('lastbuyer'),
        'Nick_buyer' => $request->get('Nickbuyer'),
        'Status_buyer' => $request->get('Statusbuyer'),
        'Phone_buyer' => $request->get('Phonebuyer'),
        'Phone2_buyer' => $request->get('Phone2buyer'),
        'Mate_buyer' => $request->get('Matebuyer'),
        'Idcard_buyer' => $request->get('Idcardbuyer'),
        'Address_buyer' => $request->get('Addressbuyer'),
        'AddN_buyer' => $request->get('AddNbuyer'),
        'StatusAdd_buyer' => $request->get('StatusAddbuyer'),
        'Workplace_buyer' => $request->get('Workplacebuyer'),
        'House_buyer' => $request->get('Housebuyer'),
        'Driver_buyer' => $request->get('Driverbuyer'),
        'HouseStyle_buyer' => $request->get('HouseStylebuyer'),
        'Career_buyer' => $request->get('Careerbuyer'),
        'Income_buyer' => $request->get('Incomebuyer'),
        'Purchase_buyer' => $request->get('Purchasebuyer'),
        'Support_buyer' => $request->get('Supportbuyer'),
        'securities_buyer' => $request->get('securitiesbuyer'),
        'deednumber_buyer' => $request->get('deednumberbuyer'),
        'area_buyer' => $request->get('areabuyer'),
        'BeforeIncome_buyer' => $BeforeIncome,
        'AfterIncome_buyer' => $AfterIncome,
        'Gradebuyer_car' => $request->get('Gradebuyer'),
        'Objective_car' => $request->get('objectivecar'),
      ]);
      $Buyerdb->save();

      $SettelSP = str_replace ("_","",$request->get('telSP'));
      $Sponsordb = new Sponsor([
        'Buyer_id' => $Buyerdb->id,
        'name_SP' => $request->get('nameSP'),
        'lname_SP' => $request->get('lnameSP'),
        'nikname_SP' => $request->get('niknameSP'),
        'status_SP' => $request->get('statusSP'),
        'tel_SP' => $SettelSP,
        'relation_SP' => $request->get('relationSP'),
        'mate_SP' => $request->get('mateSP'),
        'idcard_SP' => $request->get('idcardSP'),
        'add_SP' => $request->get('addSP'),
        'addnow_SP' => $request->get('addnowSP'),
        'statusadd_SP' => $request->get('statusaddSP'),
        'workplace_SP' => $request->get('workplaceSP'),
        'house_SP' => $request->get('houseSP'),
        'deednumber_SP' => $request->get('deednumberSP'),
        'area_SP' => $request->get('areaSP'),
        'housestyle_SP' => $request->get('housestyleSP'),
        'career_SP' => $request->get('careerSP'),
        'income_SP' => $request->get('incomeSP'),
        'puchase_SP' => $request->get('puchaseSP'),
        'support_SP' => $request->get('supportSP'),
        'securities_SP' => $request->get('securitiesSP'),
      ]);
      $Sponsordb->save();

      $SettelSP2 = str_replace ("_","",$request->get('telSP2'));
      $Sponsor2db = new Sponsor2([
        'Buyer_id2' => $Buyerdb->id,
        'name_SP2' => $request->get('nameSP2'),
        'lname_SP2' => $request->get('lnameSP2'),
        'nikname_SP2' => $request->get('niknameSP2'),
        'status_SP2' => $request->get('statusSP2'),
        'tel_SP2' => $SettelSP2,
        'relation_SP2' => $request->get('relationSP2'),
        'mate_SP2' => $request->get('mateSP2'),
        'idcard_SP2' => $request->get('idcardSP2'),
        'add_SP2' => $request->get('addSP2'),
        'addnow_SP2' => $request->get('addnowSP2'),
        'statusadd_SP2' => $request->get('statusaddSP2'),
        'workplace_SP2' => $request->get('workplaceSP2'),
        'house_SP2' => $request->get('houseSP2'),
        'deednumber_SP2' => $request->get('deednumberSP2'),
        'area_SP2' => $request->get('areaSP2'),
        'housestyle_SP2' => $request->get('housestyleSP2'),
        'career_SP2' => $request->get('careerSP2'),
        'income_SP2' => $request->get('incomeSP2'),
        'puchase_SP2' => $request->get('puchaseSP2'),
        'support_SP2' => $request->get('supportSP2'),
        'securities_SP2' => $request->get('securitiesSP2'),
      ]);
      $Sponsor2db->save();

      if ($request->get('Topcar') != Null) {
        $SetTopcar = str_replace (",","",$request->get('Topcar'));
      }else {
        $SetTopcar = 0;
      }

      if ($request->get('Commissioncar') != Null) {
        $SetCommissioncar = str_replace (",","",$request->get('Commissioncar'));
      }else {
        $SetCommissioncar = 0;
      }

      if($request->get('Agentcar') == Null){
        $SetCommissioncar = 0;
      }else{
        $SetCommissioncar = $SetCommissioncar;
      }     

      if ($request->patch_type == 1) {  //type จากหน้า create Buyers
        $SetBranch = $request->get('branchcar');

        if($request->get('Dateduefirstcar') != null){
          $dateFirst = date_create($request->get('Dateduefirstcar'));
          $SetDatefirst = date_format($dateFirst, 'd-m-Y');
        }else{
          $SetDatefirst = NULL;
        }
        $SetLicense = "";
        if ($request->get('Licensecar') != NULL) {
          $SetLicense = $request->get('Licensecar');
        }
        
        //รูปหน้าบัญชี
        $NameImage = NULL;
        if ($request->hasFile('Account_image')) {
          $AccountImage = $request->file('Account_image');
          $NameImage = $AccountImage->getClientOriginalName();

          $destination_path = public_path().'/upload-image/'.$SetLicense;
          Storage::makeDirectory($destination_path, 0777, true, true);

          $AccountImage->move($destination_path,$NameImage);
        }

        $Cardetaildb = new Cardetail([
          'Buyercar_id' => $Buyerdb->id,
          'Brand_car' => $request->get('Brandcar'),
          'Year_car' => $request->get('Yearcar'),
          'Typecardetails' => $request->get('Typecardetail'),
          'Groupyear_car' => $request->get('Groupyearcar'),
          'Colour_car' => $request->get('Colourcar'),
          'License_car' => $request->get('Licensecar'),
          'Nowlicense_car' => $request->get('Nowlicensecar'),
          'Mile_car' => $request->get('Milecar'),
          'Midprice_car' => $request->get('Midpricecar'),
          'Model_car' => $request->get('Modelcar'),
          'Top_car' => $SetTopcar,
          'Interest_car' => $request->get('Interestcar'),
          'Vat_car' => $request->get('Vatcar'),
          'Timeslacken_car' => $request->get('Timeslackencar'),
          'Pay_car' => $request->get('Paycar'),
          'Paymemt_car' => $request->get('Paymemtcar'),
          'Timepayment_car' => $request->get('Timepaymentcar'),
          'Tax_car' => $request->get('Taxcar'),
          'Taxpay_car' => $request->get('Taxpaycar'),
          'Totalpay1_car' => $request->get('Totalpay1car'),
          'Totalpay2_car' => $request->get('Totalpay2car'),
          'Dateduefirst_car' => $SetDatefirst,
          'Insurance_car' => $request->get('Insurancecar'),
          'status_car' => $request->get('statuscar'),
          'Percent_car' => $request->get('Percentcar'),
          'Payee_car' => $request->get('Payeecar'),
          'Accountbrance_car' => $request->get('Accountbrancecar'),
          'Tellbrance_car' => $request->get('Tellbrancecar'),
          'Agent_car' => $request->get('Agentcar'),
          'Accountagent_car' => $request->get('Accountagentcar'),
          'Commission_car' => $SetCommissioncar,
          'Tellagent_car' => $request->get('Tellagentcar'),
          'Purchasehistory_car' => $request->get('Purchasehistorycar'),
          'Supporthistory_car' => $request->get('Supporthistorycar'),
          'Loanofficer_car' => $request->get('Loanofficercar'),
          'Approvers_car' => $request->get('Approverscar'),
          'Date_Appcar' => Null,
          'Check_car' => Null,
          'StatusApp_car' => 'รออนุมัติ',
          'DocComplete_car' => $request->get('doccomplete'),
          'branch_car' => $SetBranch,
          'branchbrance_car' => $request->get('branchbrancecar'),
          'branchAgent_car' => $request->get('branchAgentcar'),
          'Note_car' => $request->get('Notecar'),
          'Insurance_key' => $request->get('Insurancekey'),
          'Salemethod_car' => $request->get('Salemethod'),
          'AccountImage_car' => $NameImage,
        ]);
        $Cardetaildb ->save();

        if ($request->get('tranPrice') != Null) {
          $SettranPrice = str_replace (",","",$request->get('tranPrice'));
        }else {
          $SettranPrice = 0;
        }
        if ($request->get('otherPrice') != Null) {
          $SetotherPrice = str_replace (",","",$request->get('otherPrice'));
        }else {
          $SetotherPrice = 0;
        }
        if ($request->get('totalkPrice') != Null) {
          $SettotalkPrice = str_replace (",","",$request->get('totalkPrice'));
        }else {
          $SettotalkPrice = 0;
        }
        if ($request->get('balancePrice') != Null) {
          $SetbalancePrice = str_replace (",","",$request->get('balancePrice'));
        }else {
          $SetbalancePrice = 0;
        }
        if ($request->get('commitPrice') != Null) {
          $SetcommitPrice = str_replace (",","",$request->get('commitPrice'));
        }else {
          $SetcommitPrice = 0;
        }
        if ($request->get('actPrice') != Null) {
          $SetactPrice = str_replace (",","",$request->get('actPrice'));
        }else {
          $SetactPrice = 0;
        }
        if ($request->get('closeAccountPrice') != Null) {
          $SetcloseAccountPrice = str_replace (",","",$request->get('closeAccountPrice'));
        }else {
          $SetcloseAccountPrice = 0;
        }
        if ($request->get('P2Price') != Null) {
          $SetP2Price = str_replace (",","",$request->get('P2Price'));
        }else {
          $SetP2Price = 0;
        }

        $Expensesdb = new Expenses([
          'Buyerexpenses_id' => $Buyerdb->id,
          'act_Price' => $SetactPrice,
          'closeAccount_Price' => $SetcloseAccountPrice,
          'P2_Price' => $SetP2Price,
          'vat_Price' => $request->get('vatPrice'),
          'tran_Price' => $SettranPrice,
          'other_Price' => $SetotherPrice,
          'evaluetion_Price' => $request->get('evaluetionPrice'),
          'totalk_Price' => $SettotalkPrice,
          'balance_Price' => $SetbalancePrice,
          'commit_Price' => $SetcommitPrice,
          'marketing_Price' => $request->get('marketingPrice'),
          'duty_Price' => $request->get('dutyPrice'),
          'insurance_Price' => $request->get('insurancePrice'),
          'note_Price' => $request->get('notePrice'),
        ]);
        $Expensesdb ->save();

        $type = 1;
      }

      $image_new_name = "";

      // รูปประกอบ
      if ($request->hasFile('file_image')) {
        $image_array = $request->file('file_image');
        $array_len = count($image_array);

        for ($i=0; $i < $array_len; $i++) {
          $image_size = $image_array[$i]->getClientSize();
          $image_lastname = $image_array[$i]->getClientOriginalExtension();
          $image_new_name = str_random(10).time(). '.' .$image_array[$i]->getClientOriginalExtension();

          $destination_path = public_path().'/upload-image/'.$SetLicense;
          Storage::makeDirectory($destination_path, 0777, true, true);
          
          $image_array[$i]->move($destination_path,$image_new_name);

          $SetType = 1; //ประเภทรูปภาพ รูปประกอบ
          $Uploaddb = new UploadfileImage([
            'Buyerfileimage_id' => $Buyerdb->id,
            'Type_fileimage' => $SetType,
            'Name_fileimage' => $image_new_name,
            'Size_fileimage' => $image_size,
          ]);
          $Uploaddb ->save();
        }
      }

      //รูป Checker ผู้เช่าซื้อ
      if ($request->hasFile('image_checker_1')) {
        $image_array = $request->file('image_checker_1');
        $array_len = count($image_array);

        for ($i=0; $i < $array_len; $i++) {
          $image_size = $image_array[$i]->getClientSize();
          $image_lastname = $image_array[$i]->getClientOriginalExtension();
          $image_new_name = str_random(10).time(). '.' .$image_array[$i]->getClientOriginalExtension();

          $destination_path = public_path().'/upload-image/'.$SetLicense;
          Storage::makeDirectory($destination_path, 0777, true, true);

          $image_array[$i]->move($destination_path,$image_new_name);

          $SetType = 2; //ประเภทรูปภาพ checker ผู้เช่าซื้อ
          $Uploaddb = new UploadfileImage([
            'Buyerfileimage_id' => $Buyerdb->id,
            'Type_fileimage' => $SetType,
            'Name_fileimage' => $image_new_name,
            'Size_fileimage' => $image_size,
          ]);
          $Uploaddb ->save();
        }
      }

      //รูป Checker ผู้ค่ำ
      if ($request->hasFile('image_checker_2')) {
        $image_array = $request->file('image_checker_2');
        $array_len = count($image_array);

        for ($i=0; $i < $array_len; $i++) {
          $image_size = $image_array[$i]->getClientSize();
          $image_lastname = $image_array[$i]->getClientOriginalExtension();
          $image_new_name = str_random(10).time(). '.' .$image_array[$i]->getClientOriginalExtension();

          $destination_path = public_path().'/upload-image/'.$SetLicense;
          Storage::makeDirectory($destination_path, 0777, true, true);

          $image_array[$i]->move($destination_path,$image_new_name);

          $SetType = 3; //ประเภทรูปภาพ checker ผู้ค่ำ
          $Uploaddb = new UploadfileImage([
            'Buyerfileimage_id' => $Buyerdb->id,
            'Type_fileimage' => $SetType,
            'Name_fileimage' => $image_new_name,
            'Size_fileimage' => $image_size,
          ]);
          $Uploaddb ->save();
        }
      }

      // เก็บค่า lat-long 
      $locationDB = new upload_lat_long([
        'Use_id' => $Buyerdb->id,
        'Buyer_latlong' => $request->get('Buyer_latlong'),
        'Support_latlong' => $request->get('Support_latlong'),
        'Buyer_note' => $request->get('BuyerNote'),
        'Support_note' => $request->get('SupportNote'),
      ]);
      $locationDB ->save();

      return redirect()->Route('Analysis',$type)->with('success','บันทึกข้อมูลเรียบร้อย');
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
    public function edit($type,$id,$fdate,$tdate,$branch,$status,Request $request)
    {
      if ($type == 1) {
        $data = DB::table('buyers')
          ->leftJoin('sponsors','buyers.id','=','sponsors.Buyer_id')
          ->leftJoin('sponsor2s','buyers.id','=','sponsor2s.Buyer_id2')
          ->leftJoin('cardetails','Buyers.id','=','cardetails.Buyercar_id')
          ->leftJoin('expenses','Buyers.id','=','expenses.Buyerexpenses_id')
          ->leftJoin('upload_lat_longs','Buyers.id','=','upload_lat_longs.Use_id')
          ->select('buyers.*','sponsors.*','sponsor2s.*','cardetails.*','expenses.*','upload_lat_longs.*','buyers.created_at AS createdBuyers_at')
          ->where('buyers.id',$id)->first();
                  
        $GetDocComplete = $data->DocComplete_car;

        $Gettype = $type;

      }
      elseif ($type == 4) {
        $data = DB::table('buyers')
                  ->leftJoin('sponsors','buyers.id','=','sponsors.Buyer_id')
                  ->leftJoin('sponsor2s','buyers.id','=','sponsor2s.Buyer_id2')
                  ->leftJoin('homecardetails','buyers.id','=','homecardetails.Buyerhomecar_id')
                  ->select('buyers.*','sponsors.*','sponsor2s.*','homecardetails.*','buyers.created_at AS createdBuyers_at')
                  ->where('buyers.id',$id)->first();

        $Gettype = $type;
      }
      elseif ($type == 8) {
        $data = DB::table('buyers')
                  ->leftJoin('sponsors','buyers.id','=','sponsors.Buyer_id')
                  ->leftJoin('sponsor2s','buyers.id','=','sponsor2s.Buyer_id2')
                  ->leftJoin('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                  ->leftJoin('expenses','Buyers.id','=','expenses.Buyerexpenses_id')
                  ->leftJoin('upload_lat_longs','Buyers.id','=','upload_lat_longs.Use_id')
                  ->select('buyers.*','sponsors.*','sponsor2s.*','cardetails.*','expenses.*','upload_lat_longs.*','buyers.created_at AS createdBuyers_at')
                  ->where('buyers.id',$id)->first();

                  $GetDocComplete = $data->DocComplete_car;
                  $Gettype = $type;
                  $data = $data;
      }
      elseif ($type == 12) {
        $data = DB::table('buyers')
                  ->leftJoin('sponsors','buyers.id','=','sponsors.Buyer_id')
                  ->leftJoin('sponsor2s','buyers.id','=','sponsor2s.Buyer_id2')
                  ->leftJoin('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                  ->leftJoin('expenses','Buyers.id','=','expenses.Buyerexpenses_id')
                  ->leftJoin('upload_lat_longs','Buyers.id','=','upload_lat_longs.Use_id')
                  ->select('buyers.*','sponsors.*','sponsor2s.*','cardetails.*','expenses.*','upload_lat_longs.*','buyers.created_at AS createdBuyers_at')
                  ->where('buyers.id',$id)->first();

                  $GetDocComplete = $data->DocComplete_car;
                  $Gettype = $type;

                  $data = $data;
      }

      $dataImage = DB::table('uploadfile_images')->where('Buyerfileimage_id',$data->id)->get();
      // dd($dataImage);
      
      $countImage = count($dataImage);
      $newDateDue = $data->Date_Due;
      $Statusby = [
        'โสด' => 'โสด',
        'สมรส' => 'สมรส',
        'หย่าร้าง' => 'หย่าร้าง',
      ];
      $Addby = [
        'ตามทะเบียนบ้าน' => 'ตามทะเบียนบ้าน',
      ];
      $Houseby = [
        'บ้านตึก 1 ชั้น' => 'บ้านตึก 1 ชั้น',
        'บ้านตึก 2 ชั้น' => 'บ้านตึก 2 ชั้น',
        'บ้านไม้ 1 ชั้น' => 'บ้านไม้ 1 ชั้น',
        'บ้านไม้ 2 ชั้น' => 'บ้านไม้ 2 ชั้น',
        'บ้านเดี่ยว' => 'บ้านเดี่ยว',
        'แฟลต' => 'แฟลต',
      ];
      $Driverby = [
        'มี' => 'มี',
        'ไม่มี' => 'ไม่มี',
      ];
      $HouseStyleby = [
        'ของตนเอง' => 'ของตนเอง',
        'อาศัยบิดา-มารดา' => 'อาศัยบิดา-มารดา',
        'อาศัยผู้อื่น' => 'อาศัยผู้อื่น',
        'บ้านพักราชการ' => 'บ้านพักราชการ',
        'บ้านเช่า' => 'บ้านเช่า',
      ];
      $Careerby = [
        'ตำรวจ' => 'ตำรวจ',
        'ทหาร' => 'ทหาร',
        'ครู' => 'ครู',
        'ข้าราชการอื่นๆ' => 'ข้าราชการอื่นๆ',
        'ลูกจ้างเทศบาล' => 'ลูกจ้างเทศบาล',
        'ลูกจ้างประจำ' => 'ลูกจ้างประจำ',
        'สมาชิก อบต.' => 'สมาชิก อบต.',
        'ลูกจ้างชั่วคราว' => 'ลูกจ้างชั่วคราว',
        'รับจ้าง' => 'รับจ้าง',
        'พนักงานบริษัทเอกชน' => 'พนักงานบริษัทเอกชน',
        'อาชีพอิสระ' => 'อาชีพอิสระ',
        'กำนัน' => 'กำนัน',
        'ผู้ใหญ่บ้าน' => 'ผู้ใหญ่บ้าน',
        'ผู้ช่วยผู้ใหญ่บ้าน' => 'ผู้ช่วยผู้ใหญ่บ้าน',
        'นักการภารโรง' => 'นักการภารโรง',
        'มอเตอร์ไซร์รับจ้าง' => 'มอเตอร์ไซร์รับจ้าง',
        'ค้าขาย' => 'ค้าขาย',
        'เจ้าของธุรกิจ' => 'เจ้าของธุรกิจ',
        'เจ้าของอู่รถ' => 'เจ้าของอู่รถ',
        'ให้เช่ารถบรรทุก' => 'ให้เช่ารถบรรทุก',
        'ช่างตัดผม' => 'ช่างตัดผม',
        'ชาวนา' => 'ชาวนา',
        'ชาวไร่' => 'ชาวไร่',
        'ชาวสวนยาง' => 'ชาวสวนยาง',
        'แม่บ้าน' => 'แม่บ้าน',
        'รับเหมาก่อสร้าง' => 'รับเหมาก่อสร้าง',
        'ประมง' => 'ประมง',
        'ทนายความ' => 'ทนายความ',
        'พระ' => 'พระ',
      ];
      $Incomeby = [
        '5,000 - 10,000' => '5,000 - 10,000',
        '10,000 - 15,000' => '10,000 - 15,000',
        '15,000 - 20,000' => '15,000 - 20,000',
        'มากกว่า 20,000' => 'มากกว่า 20,000',
      ];
      $HisCarby = [
        '0 คัน' => '0 คัน',
        '1 คัน' => '1 คัน',
        '2 คัน' => '2 คัน',
        '3 คัน' => '3 คัน',
        '4 คัน' => '4 คัน',
        '5 คัน' => '5 คัน',
        '6 คัน' => '6 คัน',
        '7 คัน' => '7 คัน',
        '8 คัน' => '8 คัน',
        '9 คัน' => '9 คัน',
        '10 คัน' => '10 คัน',
        '11 คัน' => '11 คัน',
        '12 คัน' => '12 คัน',
        '13 คัน' => '13 คัน',
        '14 คัน' => '14 คัน',
        '15 คัน' => '15 คัน',
        '16 คัน' => '16 คัน',
        '17 คัน' => '17 คัน',
        '18 คัน' => '18 คัน',
        '19 คัน' => '19 คัน',
        '20 คัน' => '20 คัน',
      ];
      $relationSPp = [
        'พี่น้อง' => 'พี่น้อง',
        'ญาติ' => 'ญาติ',
        'เพื่อน' => 'เพื่อน',
        'บิดา' => 'บิดา',
        'มารดา' => 'มารดา',
        'ตำบลเดี่ยวกัน' => 'ตำบลเดี่ยวกัน',
        'จ้างค้ำ(ไม่รู้จักกัน)' => 'จ้างค้ำ(ไม่รู้จักกัน)',
      ];
      $objectivecar = [
        'ลงทุนในธุรกิจ' => 'ลงทุนในธุรกิจ',
        'ขยายกิจการ' => 'ขยายกิจการ',
        'ซื้อรถยนต์' => 'ซื้อรถยนต์',
        'ใช้หนี้นอกระบบ' => 'ใช้หนี้นอกระบบ',
        'จ่ายค่าเทอม' => 'จ่ายค่าเทอม',
        'ซื้อของใช้ภายในบ้าน' => 'ซื้อของใช้ภายในบ้าน',
        'ซื้อวัว' => 'ซื้อวัว',
        'ซื้อที่ดิน' => 'ซื้อที่ดิน',
        'ซ่อมบ้าน' => 'ซ่อมบ้าน',
        'ลดค่าธรรมเนียม' => 'ลดค่าธรรมเนียม',
        'ลดดอกเบี้ย สูงสุด 100 %' => 'ลดดอกเบี้ย สูงสุด 100 %',
        'พักชำระเงินต้น 3 เดือน' => 'พักชำระเงินต้น 3 เดือน',
        'พักชำระหนี้ 3 เดือน' => 'พักชำระหนี้ 3 เดือน',
        'ขยายระยะเวลาชำระหนี้' => 'ขยายระยะเวลาชำระหนี้',
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
      $Interestcarr = [
        '0.55' => '0.55',
        '0.65' => '0.65',
        '0.80' => '0.80',
        '0.90' => '0.90',
        '1.05' => '1.05',
        '1.20' => '1.20',
        '1.40' => '1.40',
        '1.55' => '1.55',
        '1.70' => '1.70',
      ];
      $Timeslackencarr = [
        '12' => '12',
        '18' => '18',
        '24' => '24',
        '30' => '30',
        '36' => '36',
        '42' => '42',
        '48' => '48',
        '54' => '54',
        '60' => '60',
        '66' => '66',
        '72' => '72',
        '78' => '78',
        '84' => '84',
      ];
      $Insurancecarr = [
        'แถม ป2+ 1ปี' => 'แถม ป2+ 1ปี',
        'มี ป2+ อยู่แล้ว' => 'มี ป2+ อยู่แล้ว',
        'ไม่แถม' => 'ไม่แถม',
        'ไม่ซื้อ' => 'ไม่ซื้อ',
        'ซื้อ ป2+ 1ปี' => 'ซื้อ ป2+ 1ปี',
        'ซื้อ ป1 1ปี' => 'ซื้อ ป1 1ปี',
        'มี ป1 อยู่แล้ว' => 'มี ป1 อยู่แล้ว',
      ];
      $statuscarr = [
        'กส.ค้ำมีหลักทรัพย์' => 'กส.ค้ำมีหลักทรัพย์',
        'กส.ค้ำไม่มีหลักทรัพย์' => 'กส.ค้ำไม่มีหลักทรัพย์',
        'กส.ไม่ค้ำประกัน' => 'กส.ไม่ค้ำประกัน',
        'ซข.ค้ำมีหลักทรัพย์' => 'ซข.ค้ำมีหลักทรัพย์',
        'ซข.ค้ำไม่มีหลักทรัพย์' => 'ซข.ค้ำไม่มีหลักทรัพย์',
        'ซข.ไม่ค้ำประกัน' => 'ซข.ไม่ค้ำประกัน',
        'VIP.กรรมสิทธิ์' => 'VIP.กรรมสิทธิ์',
        'VIP.ซื้อขาย' => 'VIP.ซื้อขาย',
      ];
      $evaluetionPricee = [
        '1,000' => '1,000',
        '1,500' => '1,500',
        '2,000' => '2,000',
        '2,500' => '2,500',
      ];
      $securitiesSPp = [
        'โฉนด' => 'โฉนด',
        'นส.3' => 'นส.3',
        'นส.3 ก' => 'นส.3 ก',
        'นส.4' => 'นส.4',
        'นส.4 จ' => 'นส.4 จ',
      ];
      $Getinsurance = [
        '0' => 'ลูกค้าโอนเอง',
        '7700' => '7700',
        '20000' => '20000',
      ];
      $Gettransfer = [
        '0' => 'ลูกค้าโอนเอง',
        '3950' => '3950',
        '4950' => '4950',
        '6950' => '6950',
      ];
      $Getinterest = [
        '0.40' => '0.40',
        '0.42' => '0.42',
        '0.45' => '0.45',
        '0.55' => '0.55',
        '0.65' => '0.65',
        '0.70' => '0.70',
        '0.75' => '0.75',
        '0.85' => '0.85',
        '1.00' => '1.00',
        '1.20' => '1.20',
      ];
      $GetSale = [
        'มารูวัน หะยีเจะแม' => 'มารูวัน หะยีเจะแม',
        'แวยูคิมสี อาแว' => 'แวยูคิมสี อาแว',
        'อลิสา หิดาวรรณ' => 'อลิสา หิดาวรรณ',
        'ธัญญ์วรา สีลาภเกื้อ' => 'ธัญญ์วรา สีลาภเกื้อ',
        'ชูชาติ สังขวัตร' => 'ชูชาติ สังขวัตร',
      ];
      $GetypeHC = [
        'รถเทิร์น' => 'รถเทิร์น',
        'รถยึด' => 'รถยึด',
        'รถฝากขาย' => 'รถฝากขาย',
        'รถโมบายบริษัท' => 'รถโมบายบริษัท',
      ];
      $GetbaabHC = [
        'ซข.ค้ำมีหลักทรัพย์' => 'ซข.ค้ำมีหลักทรัพย์',
        'ซข.ค้ำไม่มีหลักทรัพย์' => 'ซข.ค้ำไม่มีหลักทรัพย์',
        'ซข.ไม่ค้ำประกัน' => 'ซข.ไม่ค้ำประกัน',
      ];
      $GetguaranteeHC = [
        'โฉนด' => 'โฉนด',
        'ข้าราชการ' => 'ข้าราชการ',
        'เจ้าบ้าน' => 'เจ้าบ้าน',
        'บุคคลธรรมดา' => 'บุคคลธรรมดา',
        'ไม่ค้ำ' => 'ไม่ค้ำ',
      ];
      $relationSP = [
        'พี่น้อง' => 'พี่น้อง',
        'ญาติ' => 'ญาติ',
        'เพื่อน' => 'เพื่อน',
        'บิดา' => 'บิดา',
        'มารดา' => 'มารดา',
        'บุตร' => 'บุตร',
        'ตำบลเดี่ยวกัน' => 'ตำบลเดี่ยวกัน',
        'จ้างค้ำ(ไม่รู้จักกัน)' => 'จ้างค้ำ(ไม่รู้จักกัน)',
      ];
      $GradeBuyer = [
        'ลูกค้าเก่าผ่อนดี' => 'ลูกค้าเก่าผ่อนดี',
        'ลูกค้ามีงานตาม' => 'ลูกค้ามีงานตาม',
        'ลูกค้าใหม่' => 'ลูกค้าใหม่',
        'ลูกค้าใหม่(ปิดธนาคาร)' => 'ลูกค้าใหม่(ปิดธนาคาร)',
        'ปิดจัดใหม่(งานตาม)' => 'ปิดจัดใหม่(งานตาม)',
        'ปิดจัดใหม่(ผ่อนดี)' => 'ปิดจัดใหม่(ผ่อนดี)',
      ];
      $Typecardetail = [
        'รถกระบะ' => 'รถกระบะ',
        'รถตอนเดียว' => 'รถตอนเดียว',
        'รถเก๋ง/7ที่นั่ง' => 'รถเก๋ง/7ที่นั่ง',
      ];

      if ($type == 1) {
        return view('Analysis.edit',
            compact('data','id','dataImage','Statusby','Addby','Houseby','Driverby','HouseStyleby','Careerby','Incomeby',
            'HisCarby','StatusSPp','relationSPp','addSPp','housestyleSPp','Brandcarr','Interestcarr','Timeslackencarr',
            'Insurancecarr','statuscarr','newDateDue','evaluetionPricee','securitiesSPp','GetDocComplete','Getinsurance',
            'Gettransfer','Getinterest','fdate','tdate','branch','status','type','Gettype','countImage','GradeBuyer','Typecardetail','objectivecar'));
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
      // dd($request);
      date_default_timezone_set('Asia/Bangkok');
      $Currdate = date('2020-06-02');   //วันที่เช็ตค่า รูป
      $Getcardetail = Cardetail::where('Buyercar_id',$id)->first();
      $Gethomecardetail = homecardetail::where('Buyerhomecar_id',$id)->first();

      $newDateDue = $request->DateDue;  //วันเริ่มทำสัญญา
      $SetPhonebuyer = str_replace ( "_","",$request->get('Phonebuyer'));

      if ($request->get('Topcar') != Null) {
        $SetTopcar = str_replace (",","",$request->get('Topcar'));
      }else {
        $SetTopcar = 0;
      }

      if ($request->get('Commissioncar') != Null) {
        $SetCommissioncar = str_replace (",","",$request->get('Commissioncar'));
      }else {
        $SetCommissioncar = 0;
      }

      // ดึงค่า ป้ายทะเบียน
      $SetLicense = "";
      if ($request->get('Licensecar') != NULL) {
        $SetLicense = $request->get('Licensecar');
      }

      // กำหนด วันอนุมัติสัญญา
      $StatusApp = "รออนุมัติ";
      $newDateDue = $request->get('DateDue');
      if ($SetTopcar > 250000) {
        if ($request->get('MANAGER') != Null) {
            $newDateDue = date('Y-m-d');
            $StatusApp = "อนุมัติ";
        }else {
          $newDateDue = $request->get('DateDue');
          $StatusApp = "รออนุมัติ";
        }
      }else {
        if ($request->get('AUDIT') != Null) {
            $newDateDue = date('Y-m-d');
            $StatusApp = "อนุมัติ";
        }elseif ($request->get('MASTER') != Null) {
            $newDateDue = $request->get('DateDue');
            $StatusApp = "รออนุมัติ";
        }elseif ($request->get('approversHC') != Null) {
          if ($Gethomecardetail->dateapp_HC == Null) {
            $newDateDue = date('Y-m-d');
          }
        }
      }

      if ($request->get('doccomplete') != Null) {
        $SetDocComplete = $request->get('doccomplete');
      }else {
        $SetDocComplete = NULL;
      }

        $user = Buyer::find($id);
          $user->Contract_buyer = $request->get('Contract_buyer');
          $user->Date_Due = $newDateDue;
          $user->Name_buyer = $request->get('Namebuyer');
          $user->last_buyer = $request->get('lastbuyer');
          $user->Nick_buyer = $request->get('Nickbuyer');
          $user->Status_buyer = $request->get('Statusbuyer');
          $user->Phone_buyer = $SetPhonebuyer;
          $user->Phone2_buyer = $request->get('Phone2buyer');
          $user->Mate_buyer = $request->get('Matebuyer');
          $user->Idcard_buyer = $request->get('Idcardbuyer');
          $user->Address_buyer = $request->get('Addressbuyer');
          $user->AddN_buyer = $request->get('AddNbuyer');
          $user->StatusAdd_buyer = $request->get('StatusAddbuyer');
          $user->Workplace_buyer = $request->get('Workplacebuyer');
          $user->House_buyer = $request->get('Housebuyer');
          $user->Driver_buyer = $request->get('Driverbuyer');
          $user->HouseStyle_buyer = $request->get('HouseStylebuyer');
          $user->Career_buyer = $request->get('Careerbuyer');
          $user->Income_buyer = $request->get('Incomebuyer');
          $user->Purchase_buyer = $request->get('Purchasebuyer');
          $user->Support_buyer = $request->get('Supportbuyer');
          $user->securities_buyer = $request->get('securitiesbuyer');
          $user->deednumber_buyer = $request->get('deednumberbuyer');
          $user->area_buyer = $request->get('areabuyer');
          $user->BeforeIncome_buyer = str_replace(",","",$request->get('Beforeincome'));
          $user->AfterIncome_buyer = str_replace(",","",$request->get('Afterincome'));
          $user->Gradebuyer_car = $request->get('Gradebuyer');
          $user->Objective_car = $request->get('objectivecar');
        $user->update();

        $SettelSP = str_replace ("_","",$request->get('telSP'));
        $sponsor = Sponsor::where('Buyer_id',$id)->first();
          $sponsor->name_SP = $request->get('nameSP');
          $sponsor->lname_SP = $request->get('lnameSP');
          $sponsor->nikname_SP = $request->get('niknameSP');
          $sponsor->status_SP = $request->get('statusSP');
          $sponsor->tel_SP = $SettelSP;
          $sponsor->relation_SP = $request->get('relationSP');
          $sponsor->mate_SP = $request->get('mateSP');
          $sponsor->idcard_SP = $request->get('idcardSP');
          $sponsor->add_SP = $request->get('addSP');
          $sponsor->addnow_SP = $request->get('addnowSP');
          $sponsor->statusadd_SP = $request->get('statusaddSP');
          $sponsor->workplace_SP = $request->get('workplaceSP');
          $sponsor->house_SP = $request->get('houseSP');
          $sponsor->deednumber_SP = $request->get('deednumberSP');
          $sponsor->area_SP = $request->get('areaSP');
          $sponsor->housestyle_SP = $request->get('housestyleSP');
          $sponsor->career_SP = $request->get('careerSP');
          $sponsor->income_SP = $request->get('incomeSP');
          $sponsor->puchase_SP = $request->get('puchaseSP');
          $sponsor->support_SP = $request->get('supportSP');
          $sponsor->securities_SP = $request->get('securitiesSP');
        $sponsor->update();

        $SettelSP2 = str_replace ("_","",$request->get('telSP2'));
        $sponsor2 = Sponsor2::where('Buyer_id2',$id)->first();

        if ($sponsor2 != Null) {
            $sponsor2->name_SP2 = $request->get('nameSP2');
            $sponsor2->lname_SP2 = $request->get('lnameSP2');
            $sponsor2->nikname_SP2 = $request->get('niknameSP2');
            $sponsor2->status_SP2 = $request->get('statusSP2');
            $sponsor2->tel_SP2 = $SettelSP2;
            $sponsor2->relation_SP2 = $request->get('relationSP2');
            $sponsor2->mate_SP2 = $request->get('mateSP2');
            $sponsor2->idcard_SP2 = $request->get('idcardSP2');
            $sponsor2->add_SP2 = $request->get('addSP2');
            $sponsor2->addnow_SP2 = $request->get('addnowSP2');
            $sponsor2->statusadd_SP2 = $request->get('statusaddSP2');
            $sponsor2->workplace_SP2 = $request->get('workplaceSP2');
            $sponsor2->house_SP2 = $request->get('houseSP2');
            $sponsor2->deednumber_SP2 = $request->get('deednumberSP2');
            $sponsor2->area_SP2 = $request->get('areaSP2');
            $sponsor2->housestyle_SP2 = $request->get('housestyleSP2');
            $sponsor2->career_SP2 = $request->get('careerSP2');
            $sponsor2->income_SP2 = $request->get('incomeSP2');
            $sponsor2->puchase_SP2 = $request->get('puchaseSP2');
            $sponsor2->support_SP2 = $request->get('supportSP2');
            $sponsor2->securities_SP2 = $request->get('securitiesSP2');
          $sponsor2->update();
        }else {
          $SettelSP2 = str_replace ("_","",$request->get('telSP2'));
          $Sponsor2db = new Sponsor2([
            'Buyer_id2' => $id,
            'name_SP2' => $request->get('nameSP2'),
            'lname_SP2' => $request->get('lnameSP2'),
            'nikname_SP2' => $request->get('niknameSP2'),
            'status_SP2' => $request->get('statusSP2'),
            'tel_SP2' => $SettelSP2,
            'relation_SP2' => $request->get('relationSP2'),
            'mate_SP2' => $request->get('mateSP2'),
            'idcard_SP2' => $request->get('idcardSP2'),
            'add_SP2' => $request->get('addSP2'),
            'addnow_SP2' => $request->get('addnowSP2'),
            'statusadd_SP2' => $request->get('statusaddSP2'),
            'workplace_SP2' => $request->get('workplaceSP2'),
            'house_SP2' => $request->get('houseSP2'),
            'deednumber_SP2' => $request->get('deednumberSP2'),
            'area_SP2' => $request->get('areaSP2'),
            'housestyle_SP2' => $request->get('housestyleSP2'),
            'career_SP2' => $request->get('careerSP2'),
            'income_SP2' => $request->get('incomeSP2'),
            'puchase_SP2' => $request->get('puchaseSP2'),
            'support_SP2' => $request->get('supportSP2'),
            'securities_SP2' => $request->get('securitiesSP2'),
          ]);
          $Sponsor2db->save();
        }

        if ($type == 4) {   //สินเชื่อ รถบ้าน

        }
        else {
          $cardetail = Cardetail::where('Buyercar_id',$id)->first();
            $cardetail->Brand_car = $request->get('Brandcar');
            $cardetail->Year_car = $request->get('Yearcar');
            $cardetail->Typecardetails = $request->get('Typecardetail');
            $cardetail->Groupyear_car = $request->get('Groupyearcar');
            $cardetail->Colour_car = $request->get('Colourcar');
            $cardetail->License_car = $request->get('Licensecar');
            $cardetail->Nowlicense_car = $request->get('Nowlicensecar');
            $cardetail->Mile_car = $request->get('Milecar');
            $cardetail->Midprice_car = $request->get('Midpricecar');
            $cardetail->Model_car = $request->get('Modelcar');
            $cardetail->Top_car = $SetTopcar;
            $cardetail->Interest_car = $request->get('Interestcar');
            $cardetail->Vat_car = $request->get('Vatcar');
            $cardetail->Timeslacken_car = $request->get('Timeslackencar');
            $cardetail->Pay_car = $request->get('Paycar');
            $cardetail->Paymemt_car = $request->get('Paymemtcar');
            $cardetail->Timepayment_car = $request->get('Timepaymentcar');
            $cardetail->Tax_car = $request->get('Taxcar');
            $cardetail->Taxpay_car = $request->get('Taxpaycar');
            $cardetail->Totalpay1_car = $request->get('Totalpay1car');
            $cardetail->Totalpay2_car = $request->get('Totalpay2car');
            $cardetail->Insurance_key = $request->get('Insurancekey');
            $cardetail->Salemethod_car = $request->get('Salemethod');

            // รูปภาพหน้าบัญชี
            if ($request->hasFile('Account_image')) {
              $AccountImage = $request->file('Account_image');
              $NameImage = $AccountImage->getClientOriginalName();

              if(substr($user->created_at,0,10) < $Currdate){
                $destination_path = public_path('/upload-image');
                $AccountImage->move($destination_path,$NameImage);
              }
              else {
                $destination_path = public_path().'/upload-image/'.$SetLicense;
                Storage::makeDirectory($destination_path, 0777, true, true);

                $AccountImage->move($destination_path,$NameImage);
              }

              $cardetail->AccountImage_car = $NameImage;
            }

            // สถานะ อนุมัติสัญญา
            if ($StatusApp == "อนุมัติ") {
              $Date = date('d-m-Y', strtotime('+1 month'));
              $SetDate = \Carbon\Carbon::parse($Date)->format('Y')+543 ."-". \Carbon\Carbon::parse($Date)->format('m')."-". \Carbon\Carbon::parse($Date)->format('d');
              $datedueBF = date_create($SetDate);
              $DateDue = date_format($datedueBF, 'd-m-Y');

              if ($cardetail->branch_car == "ปัตตานี") {
                  $connect = Buyer::where('Contract_buyer', 'like', '01%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }elseif ($cardetail->branch_car == "ยะลา") {
                  $connect = Buyer::where('Contract_buyer', 'like', '03%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }elseif ($cardetail->branch_car == "นราธิวาส") {
                  $connect = Buyer::where('Contract_buyer', 'like', '04%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }elseif ($cardetail->branch_car == "สายบุรี") {
                  $connect = Buyer::where('Contract_buyer', 'like', '05%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }elseif ($cardetail->branch_car == "โกลก") {
                  $connect = Buyer::where('Contract_buyer', 'like', '06%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }elseif ($cardetail->branch_car == "เบตง") {
                  $connect = Buyer::where('Contract_buyer', 'like', '07%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }elseif ($cardetail->branch_car == "รถบ้าน") {
                  $connect = Buyer::where('Contract_buyer', 'like', '10%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }elseif ($cardetail->branch_car == "รถยืดขายผ่อน") {
                  $connect = Buyer::where('Contract_buyer', 'like', '11%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }elseif ($cardetail->branch_car == "ปรับโครงสร้าง") {
                  $connect = Buyer::where('Contract_buyer', 'like', '22%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }elseif ($cardetail->branch_car == "มาตรการช่วยเหลือ") {
                  $connect = Buyer::where('Contract_buyer', 'like', '33%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
              }

              $contract = $connect[0]->Contract_buyer;
              $SetStr = explode("/",$contract);
              $StrNum = $SetStr[1] + 1;

              $num = "1000";
              $SubStr = substr($num.$StrNum, -4);
              $StrConn = $SetStr[0]."/".$SubStr;

              $GetIdConn = Buyer::where('id',$id)->first();
                $GetIdConn->Contract_buyer = $StrConn;
              $GetIdConn->update();
            }
            else { //รออนุมัติ
                $DateDue = NULL;      //วันดิวงวดแรก
                $newDateDue = NULL;   //วันอนุมัติ
                $StatusApp = "รออนุมัติ";

                $branchType = NULL;
                if ($cardetail->branch_car == "ปัตตานี") {
                  $connect = Buyer::where('Contract_buyer', 'like', '01%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }elseif ($cardetail->branch_car == "ยะลา") {
                  $connect = Buyer::where('Contract_buyer', 'like', '03%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }elseif ($cardetail->branch_car == "นราธิวาส") {
                  $connect = Buyer::where('Contract_buyer', 'like', '04%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }elseif ($cardetail->branch_car == "สายบุรี") {
                  $connect = Buyer::where('Contract_buyer', 'like', '05%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }elseif ($cardetail->branch_car == "โกลก") {
                  $connect = Buyer::where('Contract_buyer', 'like', '06%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }elseif ($cardetail->branch_car == "เบตง") {
                  $connect = Buyer::where('Contract_buyer', 'like', '07%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }elseif ($cardetail->branch_car == "รถบ้าน") {
                  $connect = Buyer::where('Contract_buyer', 'like', '10%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }elseif ($cardetail->branch_car == "รถยืดขายผ่อน") {
                  $connect = Buyer::where('Contract_buyer', 'like', '11%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }elseif ($cardetail->branch_car == "ปรับโครงสร้าง") {
                  $connect = Buyer::where('Contract_buyer', 'like', '22%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }elseif ($cardetail->branch_car == "มาตรการช่วยเหลือ") {
                  $connect = Buyer::where('Contract_buyer', 'like', '33%' )
                      ->orderBy('Contract_buyer', 'desc')->limit(1)
                      ->get();
                }
              
                $contract = $connect[0]->Contract_buyer;
                $SetStr = explode("/",$contract);
                $StrNum = $SetStr[0];

                $GetIdConn = Buyer::where('id',$id)->first();
                  $GetIdConn->Contract_buyer = $StrNum;
                $GetIdConn->update();
            }

            $cardetail->Dateduefirst_car = $DateDue;     //วันที่ ดิวงวดแรก
            $cardetail->Date_Appcar = $newDateDue;       //วันที่ อนุมัติ
            $cardetail->StatusApp_car = $StatusApp;      //สถานะ อนุมัติ

            $cardetail->Insurance_car = $request->get('Insurancecar');
            $cardetail->status_car = $request->get('statuscar');
            $cardetail->Percent_car = $request->get('Percentcar');
            $cardetail->Payee_car = $request->get('Payeecar');
            $cardetail->Accountbrance_car = $request->get('Accountbrancecar');
            $cardetail->Tellbrance_car = $request->get('Tellbrancecar');
            $cardetail->Agent_car = $request->get('Agentcar');
            $cardetail->Accountagent_car = $request->get('Accountagentcar');
            $cardetail->Commission_car = $SetCommissioncar;
            $cardetail->Tellagent_car = $request->get('Tellagentcar');
            $cardetail->Purchasehistory_car = $request->get('Purchasehistorycar');
            $cardetail->Supporthistory_car = $request->get('Supporthistorycar');
            $cardetail->DocComplete_car = $SetDocComplete;             //เอกสารครบ
            $cardetail->Check_car = $request->get('MASTER');          //หัวหน้า
            $cardetail->Approvers_car = $request->get('AUDIT');        //audit
            $cardetail->ManagerApp_car = $request->get('MANAGER');     //ผู้จัดการ
            $cardetail->branchbrance_car = $request->get('branchbrancecar');
            $cardetail->branchAgent_car = $request->get('branchAgentcar');
            $cardetail->Note_car = $request->get('Notecar');
            if($type == 8 or $type == 12){    //ปรับโครงสร้าง && มาตกราช่วยเหลือ
              $cardetail->Dateduefirst_car = $request->get('Dateduefirstcar');
            }
          $cardetail->update();

          if ($request->get('tranPrice') != Null) {
            $SettranPrice = str_replace (",","",$request->get('tranPrice'));
          }else {
            $SettranPrice = 0;
          }
          if ($request->get('otherPrice') != Null) {
            $SetotherPrice = str_replace (",","",$request->get('otherPrice'));
          }else {
            $SetotherPrice = 0;
          }
          if ($request->get('totalkPrice') != Null) {
            $SettotalkPrice = str_replace (",","",$request->get('totalkPrice'));
          }else {
            $SettotalkPrice = 0;
          }
          if ($request->get('balancePrice') != Null) {
            $SetbalancePrice = str_replace (",","",$request->get('balancePrice'));
          }else {
            $SetbalancePrice = 0;
          }
          if ($request->get('commitPrice') != Null) {
            $SetcommitPrice = str_replace (",","",$request->get('commitPrice'));
          }else {
            $SetcommitPrice = 0;
          }
          if ($request->get('actPrice') != Null) {
            $SetactPrice = str_replace (",","",$request->get('actPrice'));
          }else {
            $SetactPrice = 0;
          }
          if ($request->get('closeAccountPrice') != Null) {
            $SetcloseAccountPrice = str_replace (",","",$request->get('closeAccountPrice'));
          }else {
            $SetcloseAccountPrice = 0;
          }
          if ($request->get('P2Price') != Null) {
            $SetP2Price = str_replace (",","",$request->get('P2Price'));
          }else {
            $SetP2Price = 0;
          }

          $expenses = Expenses::where('Buyerexpenses_id',$id)->first();
            $expenses->act_Price = $SetactPrice;
            $expenses->closeAccount_Price = $SetcloseAccountPrice;
            $expenses->P2_Price = $SetP2Price;
            $expenses->vat_Price = $request->get('vatPrice');
            $expenses->tran_Price = $SettranPrice;
            $expenses->other_Price = $SetotherPrice;
            $expenses->evaluetion_Price = $request->get('evaluetionPrice');
            $expenses->totalk_Price = $SettotalkPrice;
            $expenses->balance_Price = $SetbalancePrice;
            $expenses->commit_Price = $SetcommitPrice;
            $expenses->marketing_Price = $request->get('marketingPrice');
            $expenses->duty_Price = $request->get('dutyPrice');
            $expenses->insurance_Price = $request->get('insurancePrice');
            $expenses->note_Price = $request->get('notePrice');
          $expenses->update();
        }

      // รูปภาพประกอบ
      if ($request->hasFile('file_image')) {
        $image_array = $request->file('file_image');
        $array_len = count($image_array);

        for ($i=0; $i < $array_len; $i++) {
          $image_size = $image_array[$i]->getClientSize();
          $image_lastname = $image_array[$i]->getClientOriginalExtension();
          $image_new_name = str_random(10).time(). '.' .$image_array[$i]->getClientOriginalExtension();

          if(substr($user->created_at,0,10) < $Currdate){
            $destination_path = public_path('/upload-image');
            $image_array[$i]->move($destination_path,$image_new_name);
          }
          else{
            $path = public_path().'/upload-image/'.$SetLicense;
            Storage::makeDirectory($path, 0777, true, true);
            $image_array[$i]->move($path,$image_new_name);
          }

          $Uploaddb = new UploadfileImage([
            'Buyerfileimage_id' => $id,
            'Type_fileimage' => 1,
            'Name_fileimage' => $image_new_name,
            'Size_fileimage' => $image_size,
          ]);
          $Uploaddb ->save();
        }
      }
      // รูปภาพ Checker ผู้เช่าซื้อ
      if ($request->hasFile('image_checker_1')) {
        $image_array = $request->file('image_checker_1');
        $array_len = count($image_array);

        for ($i=0; $i < $array_len; $i++) {
          $image_size = $image_array[$i]->getClientSize();
          $image_lastname = $image_array[$i]->getClientOriginalExtension();
          $image_new_name = str_random(10).time(). '.' .$image_array[$i]->getClientOriginalExtension();

          if(substr($user->created_at,0,10) < $Currdate){
            $destination_path = public_path('/upload-image');
            $image_array[$i]->move($destination_path,$image_new_name);
          }
          else{
            $path = public_path().'/upload-image/'.$SetLicense;
            Storage::makeDirectory($path, 0777, true, true);
            $image_array[$i]->move($path,$image_new_name);
          }

          $Uploaddb = new UploadfileImage([
            'Buyerfileimage_id' => $id,
            'Type_fileimage' => 2,
            'Name_fileimage' => $image_new_name,
            'Size_fileimage' => $image_size,
          ]);
          $Uploaddb ->save();
        }
      }
      // รูปภาพ Checker ผู้ค่ำ
      if ($request->hasFile('image_checker_2')) {
        $image_array = $request->file('image_checker_2');
        $array_len = count($image_array);

        for ($i=0; $i < $array_len; $i++) {
          $image_size = $image_array[$i]->getClientSize();
          $image_lastname = $image_array[$i]->getClientOriginalExtension();
          $image_new_name = str_random(10).time(). '.' .$image_array[$i]->getClientOriginalExtension();

          if(substr($user->created_at,0,10) < $Currdate){
            $destination_path = public_path('/upload-image');
            $image_array[$i]->move($destination_path,$image_new_name);
          }
          else{
            $path = public_path().'/upload-image/'.$SetLicense;
            Storage::makeDirectory($path, 0777, true, true);
            $image_array[$i]->move($path,$image_new_name);
          }

          $Uploaddb = new UploadfileImage([
            'Buyerfileimage_id' => $id,
            'Type_fileimage' => 3,
            'Name_fileimage' => $image_new_name,
            'Size_fileimage' => $image_size,
          ]);
          $Uploaddb ->save();
        }
      }
      // ตำแหน่งที่ตั้ง ผู้เช่าซื้อ ผู้ค้ำ
      if($request->get('Buyer_latlong') != NULL){
        $StrBuyerLatlong = $request->get('Buyer_latlong');
      }else{
        $StrBuyerLatlong = NULL;
      }

      if($request->get('Support_latlong') != NULL){
        $StrSupporterlatLong = $request->get('Support_latlong');
      }else{
        $StrSupporterlatLong = NULL;
      }
      
      $Location = upload_lat_long::where('Use_id',$id)->first();
      if($Location != null){
        $Location->Buyer_latlong = $StrBuyerLatlong;
        $Location->Support_latlong = $StrSupporterlatLong;
        $Location->Buyer_note = $request->get('BuyerNote');
        $Location->Support_note = $request->get('SupportNote');
        $Location->update();
      }else{
        $locationDB = new upload_lat_long([
          'Use_id' => $user->id,
          'Buyer_latlong' => $request->get('Buyer_latlong'),
          'Support_latlong' => $request->get('Support_latlong'),
          'Buyer_note' => $request->get('BuyerNote'),
          'Support_note' => $request->get('SupportNote'),
        ]);
        $locationDB ->save();
      }

      $fdate = $request->fdate;
      $tdate = $request->tdate;
      $branch = $request->branch;
      $status = $request->status;

      if ($branch == "Null") {
        $branch = Null;
      }
      if ($status == "Null") {
        $status = Null;
      }

      if ($type == 1) {
        return redirect()->Route('Analysis',$type)->with(['fdate' => $fdate,'tdate' => $tdate,'branch' => $branch,'status' => $status,'success' => 'อัพเดตข้อมูลเรียบร้อย']);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, $type)
    {
      $item1 = Buyer::find($id);
      $item2 = Sponsor::where('Buyer_id',$id);
      $item3 = Cardetail::where('Buyercar_id',$id);
      $item4 = Expenses::where('Buyerexpenses_id',$id);
      $item6 = homecardetail::where('Buyerhomecar_id',$id);
      $item7 = Sponsor2::where('Buyer_id2',$id);
      $item8 = upload_lat_long::where('Use_id',$id);

      $item5 = UploadfileImage::where('Buyerfileimage_id','=',$id)->get();
      $countData = count($item5);

      $Currdate = date('2020-06-02');
      $created_at = '';

      if($type == 1 or $type == 8 or $type == 12){
        if($countData != 0){
          $dataold = Buyer::where('id','=',$id)->first();
          $datacarold = Cardetail::where('Buyercar_id',$id)->first();
          $created_at = substr($dataold->created_at,0,10);
          $path = $datacarold->License_car;
        }
      }elseif($type == 4){
        if($countData != 0){
          $dataold = Buyer::where('id','=',$id)->first();
          $datacarold = homecardetail::where('Buyerhomecar_id',$id)->first();
          $created_at = substr($dataold->created_at,0,10);
          $path = $datacarold->oldplate_HC;
        }
      }

      if($created_at < $Currdate){
        foreach ($item5 as $key => $value) {
          $itemID = $value->Buyerfileimage_id;
          $itemPath = $value->Name_fileimage;
          Storage::delete($itemPath);
        }
        if($type == 1){
          $ImageAccount = Cardetail::where('Buyercar_id','=',$id)->get();
          if ($ImageAccount != NULL) {
            Storage::delete($ImageAccount[0]->AccountImage_car);
          }
        }elseif($type == 4){
          $ImageAccount = homecardetail::where('Buyerhomecar_id','=',$id)->get();
          if ($ImageAccount != NULL) {
            Storage::delete($ImageAccount[0]->AccountImage_car);
          }
        }
      }
      else{
        foreach ($item5 as $key => $value) {
          $itemID = $value->Buyerfileimage_id;
          $itemPath = public_path().'/upload-image/'.$path;
          File::deleteDirectory($itemPath);
        }
        if($type == 1){
          $ImageAccount = Cardetail::where('Buyercar_id','=',$id)->get();
          if ($ImageAccount != NULL) {
            File::delete($ImageAccount[0]->AccountImage_car);
          }
        }elseif($type == 4){
          $ImageAccount = homecardetail::where('Buyerhomecar_id','=',$id)->get();
          if ($ImageAccount != NULL) {
            File::delete($ImageAccount[0]->AccountImage_car);
          }
        }
      }

      if ($countData != 0) {
        $deleteItem = UploadfileImage::where('Buyerfileimage_id',$itemID);
        $deleteItem->Delete();
      }  

      $item1->Delete();
      $item2->Delete();
      $item3->Delete();
      $item4->Delete();
      $item6->Delete();
      $item7->Delete();
      $item8->Delete();

      return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }

    public function deleteImageAll($id,$path,Request $request)
    {
      $Currdate = date('2020-06-02');
      $created_at = '';
      if ($request->type == 2) {
        $item = DB::table('uploadfile_images')
              ->where('Buyerfileimage_id','=',$id)
              ->where('Type_fileimage','=', '2')
              ->get();

        if ($item != NULL) {
          foreach ($item as $key => $value) {
            $itemPath = public_path().'/upload-image/'.$path.'/'.$value->Name_fileimage;
            File::delete($itemPath);

            $deleteItem = UploadfileImage::where('fileimage_id',$value->fileimage_id);
            $deleteItem->Delete();
          }

        }
      }
      elseif ($request->type == 3) {
        $item = DB::table('uploadfile_images')
              ->where('Buyerfileimage_id','=',$id)
              ->where('Type_fileimage','=', '3')
              ->get();

        if ($item != NULL) {
          foreach ($item as $key => $value) {
            $itemPath = public_path().'/upload-image/'.$path.'/'.$value->Name_fileimage;
            File::delete($itemPath);

            $deleteItem = UploadfileImage::where('fileimage_id',$value->fileimage_id);
            $deleteItem->Delete();
          }

        }
      }
      else {
        $item = UploadfileImage::where('Buyerfileimage_id','=',$id)->get();
        $countData = count($item);
        if($countData != 0){
          $dataold = Buyer::where('id','=',$id)->first();
          $created_at = substr($dataold->created_at,0,10);
        }
  
        if($created_at < $Currdate){
          foreach ($item as $key => $value) {
            $itemID = $value->Buyerfileimage_id;
            $itemPath = $value->Name_fileimage;
            Storage::delete($itemPath);
          }
        }
        else{
          foreach ($item as $key => $value) {
            $itemID = $value->Buyerfileimage_id;
            $itemPath = public_path().'/upload-image/'.$path.'/'.$value->Name_fileimage;
            File::delete($itemPath);
          }
        }
        $deleteItem = UploadfileImage::where('Buyerfileimage_id',$itemID);
        $deleteItem->Delete();
      }

      return redirect()->back()->with('success','ลบรูปทั้งหมดเรียบร้อย');
      // return redirect()->Route('deleteImageEach',[$type,$mainid,$fdate,$tdate,$branch,$status])->with(['success' => 'ลบรูปสำเร็จเรียบร้อย']);
    }

    public function deleteImageEach($type,$id,$fdate,$tdate,$branch,$status,$path,Request $request)
    {
      $id = $id;
      $type = $type;
      $fdate = $fdate;
      $tdate = $tdate;
      $branch = $branch;
      $status = $status;
      $path = $path;
      $created_at = '';

      $data = UploadfileImage::where('Buyerfileimage_id','=',$id)->where('Type_fileimage','=','1')->get();
      $countData = count($data);
      if($countData != 0){
        $dataold = Buyer::where('id','=',$id)->first();
        $created_at = substr($dataold->created_at,0,10);
      }

      return view('analysis.viewimage', compact('data','countData','id','type','fdate','tdate','branch','status','path','created_at'));
    }

    public function destroyImage($type,$id,$fdate,$tdate,$branch,$status,$path,Request $request)
    {
      $type = $type;
      $id = $id;
      $fdate = $fdate;
      $tdate = $tdate;
      $branch = $branch;
      $status = $status;
      $path = $path;
      $mainid = $request->mainid;
      $created_at = '';
      $Currdate = date('2020-06-02');

      $item1 = UploadfileImage::where('fileimage_id',$id);
      $data = UploadfileImage::where('fileimage_id','=',$id)->get();
      $countData = count($data);
      if($countData != 0){
        $dataold = Buyer::where('id','=',$mainid)->first();
        $created_at = substr($dataold->created_at,0,10);
      }
      if($created_at < $Currdate){
        foreach ($data as $key => $value) {
          $itemPath = $value->Name_fileimage;
          Storage::delete($itemPath);
        }
      }
      else{
        foreach ($data as $key => $value) {
          $itemPath = public_path().'/upload-image/'.$path.'/'.$value->Name_fileimage;
          File::delete($itemPath);
        }
      }
      $item1->Delete();
      return redirect()->Route('deleteImageEach',[$type,$mainid,$fdate,$tdate,$branch,$status,$path])->with(['success' => 'ลบรูปสำเร็จ']);
    }

}
