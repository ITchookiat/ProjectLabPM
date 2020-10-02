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
use App\Data_customer;
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
        $typeCon = '';

        if ($request->has('Fromdate')) {
          $newfdate = $request->get('Fromdate');
        }elseif (session()->has('newfdate')) {
          $newfdate = session('newfdate');
        }

        if ($request->has('Todate')) {
          $newtdate = $request->get('Todate');
        }elseif (session()->has('newtdate')) {
          $newtdate = session('newtdate');
        }

        if ($request->has('branch')) {
          $branch = $request->get('branch');
        }elseif (session()->has('branch')) {
          $branch = session('branch');
        }

        if ($request->has('status')) {
          $status = $request->get('status');
        }elseif (session()->has('status')) {
          $status = session('status');
        }

        if ($request->has('Contno')) {
          $contno = $request->get('Contno');
        }elseif (session()->has('Contno')) {
          $contno = session('Contno');
        }

        if ($branch == 'Null') {
          $branch = NULL;
        }
        if ($status == 'Null') {
          $status = NULL;
        }

        // dd($newfdate,$branch);

        if ($newfdate == '' and $newtdate == '') {
          $data = DB::table('buyers')
              ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
              ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
              ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
              ->where('cardetails.Date_Appcar','=',Null)
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
              ->orderBy('buyers.Contract_buyer', 'ASC')
              ->get();
        }

        $type = $request->type;
        $newfdate = \Carbon\Carbon::parse($newfdate)->format('Y') ."-". \Carbon\Carbon::parse($newfdate)->format('m')."-". \Carbon\Carbon::parse($newfdate)->format('d');
        $newtdate = \Carbon\Carbon::parse($newtdate)->format('Y') ."-". \Carbon\Carbon::parse($newtdate)->format('m')."-". \Carbon\Carbon::parse($newtdate)->format('d');

        $CountP03 = 0;
        $CountP06 = 0;
        $CountP07 = 0;
        if ($data != NULL) {
          foreach ($data as $key => $value) {
            if ($value->Type_Con == 'P03') {
                $CountP03 += 1;
            }elseif ($value->Type_Con == 'P06') {
                $CountP06 += 1;
            }elseif ($value->Type_Con == 'P07') {
                $CountP07 += 1;
            }
          }
        }

        $topcar = DB::table('buyers')
          ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
          ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
          ->join('expenses','buyers.id','=','expenses.Buyerexpenses_id')
          ->whereBetween('buyers.Date_Due',[$newfdate,$newtdate])
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

        return view('analysis.view', compact('type', 'data','branch','newfdate','newtdate','status','Setdate','SumTopcar','SumCommissioncar',
                                             'SumCommitprice','contno','SetStrConn','SetStr1','SetStr2','CountP03','CountP06','CountP07'));
      }
      elseif ($request->type == 2){ //เพิ่มสินเชื่อ
        return view('analysis.createbuyer');
      }
      elseif ($request->type == 3){ //รายงาน สินเชื่อ
        $datadrop = DB::table('buyers')
        ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
        ->select('cardetails.Agent_car', DB::raw('count(*) as total'))
        ->where('cardetails.Agent_car','<>',Null)
        ->groupBy('cardetails.Agent_car')
        ->get();

        $datayear = DB::table('buyers')
        ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
        ->select('cardetails.Year_car', DB::raw('count(*) as total'))
        ->where('cardetails.Year_car','<>',Null)
        ->groupBy('cardetails.Year_car')
        ->get();

        $datastatus = DB::table('buyers')
        ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
        ->select('cardetails.status_car', DB::raw('count(*) as total'))
        ->where('cardetails.status_car','<>',Null)
        ->groupBy('cardetails.status_car')
        ->get();

        $databranch = DB::table('buyers')
        ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
        ->select('cardetails.branch_car', DB::raw('count(*) as total'))
        ->where('cardetails.branch_car','<>',Null)
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
      if ($request->get('Contract_buyer') != NULL) {
        $StrConn = $request->get('Contract_buyer');

        if ($request->get('TypeContract') == "P03") {
          $SetFlag = "Y"; //สถานะเริ่มต้นของ PLoan
        }elseif ($request->get('TypeContract') == "P06") {
          $SetFlag = "E"; //สถานะเริ่มต้นของ Micro
        }elseif ($request->get('TypeContract') == "P07") {
          $SetFlag = "S"; //สถานะเริ่มต้นของ P07
        }
      }

      $Buyerdb = new Buyer([
        'Contract_buyer' => $StrConn,
        'Flag' => $SetFlag,
        'Type_Con' => $request->get('TypeContract'),
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

      if ($request->get('incomeSP') != Null) {
        $SetincomeSP = str_replace (",","",$request->get('incomeSP'));
      }else {
        $SetincomeSP = 0;
      }
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
        'income_SP' => $SetincomeSP,
        'puchase_SP' => $request->get('puchaseSP'),
        'support_SP' => $request->get('supportSP'),
        'securities_SP' => $request->get('securitiesSP'),
      ]);
      $Sponsordb->save();

      if ($request->get('incomeSP2') != Null) {
        $SetincomeSP2 = str_replace (",","",$request->get('incomeSP2'));
      }else {
        $SetincomeSP2 = 0;
      }
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
        'income_SP2' => $SetincomeSP2,
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

        if ($request->get('BrachUser') == "50") {
          $SetBranch = "ปัตตานี";
        }elseif ($request->get('BrachUser') == "51") {
          $SetBranch = "ยะลา";
        }elseif ($request->get('BrachUser') == "52") {
          $SetBranch = "นราธิวาส";
        }elseif ($request->get('BrachUser') == "53") {
          $SetBranch = "สายบุรี";
        }elseif ($request->get('BrachUser') == "54") {
          $SetBranch = "สุไหงโกลก";
        }elseif ($request->get('BrachUser') == "55") {
          $SetBranch = "เบตง";
        }elseif ($request->get('BrachUser') == "56") {
          $SetBranch = "โคกโพธิ์";
        }elseif ($request->get('BrachUser') == "57") {
          $SetBranch = "ตันหยงมัส";
        }elseif ($request->get('BrachUser') == "58") {
          $SetBranch = "บันนังสตา";
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
          'AccountImage_car' => $NameImage,
        ]);
        $Cardetaildb ->save();

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
          'totalk_Price' => $SettotalkPrice,
          'balance_Price' => $SetbalancePrice,
          'commit_Price' => $SetcommitPrice,
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
        $SubStr = substr($data->Contract_buyer,0,3);
      }

      $dataImage = DB::table('uploadfile_images')->where('Buyerfileimage_id',$data->id)->get();
      $countImage = count($dataImage);
      $newDateDue = $data->Date_Due;

      if ($type == 1) {
        return view('Analysis.edit',
            compact('data','id','dataImage','newDateDue','GetDocComplete','fdate','tdate','branch','status','type','countImage','SubStr'));
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
      $Getcardetail = Cardetail::where('Buyercar_id',$id)->first();

      //สร้างเลขที่สัญญา
      if ($request->get('BrachUser') == "50" or $request->get('BrachUser') == "ปัตตานี") {
        $NumBranch = "50";
      }elseif ($request->get('BrachUser') == "51" or $request->get('BrachUser') == "ยะลา") {
        $NumBranch = "51";
      }elseif ($request->get('BrachUser') == "52" or $request->get('BrachUser') == "นราธิวาส") {
        $NumBranch = "52";
      }elseif ($request->get('BrachUser') == "53" or $request->get('BrachUser') == "สายบุรี") {
        $NumBranch = "53";
      }elseif ($request->get('BrachUser') == "54" or $request->get('BrachUser') == "สุไหงโกลก") {
        $NumBranch = "54";
      }elseif ($request->get('BrachUser') == "55" or $request->get('BrachUser') == "เบตง") {
        $NumBranch = "55";
      }elseif ($request->get('BrachUser') == "56" or $request->get('BrachUser') == "โคกโพธิ์") {
        $NumBranch = "56";
      }elseif ($request->get('BrachUser') == "57" or $request->get('BrachUser') == "ตันหยงมัส") {
        $NumBranch = "57";
      }elseif ($request->get('BrachUser') == "58" or $request->get('BrachUser') == "บันนังสตา") {
        $NumBranch = "58";
      }

      $GetYear = substr(date('Y')+543, 2,4);  //ดึงปี พ.ศ.
      $NewContract = $request->get('TypeContract').'-'.$GetYear.$NumBranch."/";

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
      $SetLicense = "";
      if ($request->get('Licensecar') != NULL) {
        $SetLicense = $request->get('Licensecar');
      }


      // กำหนด วันอนุมัติสัญญา
      $StatusApp = "รออนุมัติ";
      $newDateDue = $request->get('DateDue');
      if ($SetTopcar > 250000) {
        if ($request->get('MANAGER') != Null) {
          if ($Getcardetail->Date_Appcar == Null) {
            $newDateDue = date('Y-m-d');
          }
          $StatusApp = "อนุมัติ";
          if ($request->get('TypeContract') == "P03") {
            $SetFlag = "Y";
          }elseif ($request->get('TypeContract') == "P06") {
            $SetFlag = "E";
          }elseif ($request->get('TypeContract') == "P07") {
            $SetFlag = "S";
          }
        }else {
          $newDateDue = $request->get('DateDue');
          $StatusApp = "รออนุมัติ";
          if ($request->get('TypeContract') == "P03") {
            $SetFlag = NULL;
          }elseif ($request->get('TypeContract') == "P06") {
            $SetFlag = NULL;
          }elseif ($request->get('TypeContract') == "P07") {
            $SetFlag = NULL;
          }
        }
      }else {
        if ($request->get('AUDIT') != Null) {
          if ($Getcardetail->Date_Appcar == Null) {
            $newDateDue = date('Y-m-d');
          }
          $StatusApp = "อนุมัติ";
          if ($request->get('TypeContract') == "P03") {
            $SetFlag = "Y";
          }elseif ($request->get('TypeContract') == "P06") {
            $SetFlag = "E";
          }elseif ($request->get('TypeContract') == "P07") {
            $SetFlag = "S";
          }
        }elseif ($request->get('MASTER') != Null) {
          $newDateDue = $request->get('DateDue');
          $StatusApp = "รออนุมัติ";
          if ($request->get('TypeContract') == "P03") {
            $SetFlag = NULL;
          }elseif ($request->get('TypeContract') == "P06") {
            $SetFlag = NULL;
          }elseif ($request->get('TypeContract') == "P07") {
            $SetFlag = NULL;
          }
        }
      }

      if ($request->get('doccomplete') != Null) {
        $SetDocComplete = $request->get('doccomplete');
      }else {
        $SetDocComplete = NULL;
      }

      $user = Buyer::find($id);
        if ($Getcardetail->Date_Appcar == NULL) { //เช็คอนุมัติ
          $user->Contract_buyer = $NewContract;
          $user->Type_Con = $request->get('TypeContract');
          $user->Date_Due = $newDateDue;
        }
        $user->Name_buyer = $request->get('Namebuyer');
        $user->last_buyer = $request->get('lastbuyer');
        $user->Nick_buyer = $request->get('Nickbuyer');
        $user->Status_buyer = $request->get('Statusbuyer');
        $user->Phone_buyer = $request->get('Phonebuyer');
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
        $user->CareerDetail_buyer = $request->get('CareerDetail');
        $user->ApproveDetail_buyer = $request->get('ApproveDetail');
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

      if ($type == 1) {   //PLoan-Micro
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

          // รูปภาพหน้าบัญชี
          if ($request->hasFile('Account_image')) {
            $AccountImage = $request->file('Account_image');
            $NameImage = $AccountImage->getClientOriginalName();

            $destination_path = public_path().'/upload-image/'.$SetLicense;
            Storage::makeDirectory($destination_path, 0777, true, true);
            $AccountImage->move($destination_path,$NameImage);
            $cardetail->AccountImage_car = $NameImage;
          }

          if ($request->get('BrachUser') == "50" or $request->get('BrachUser') == "ปัตตานี") {
            $SetBranch = "ปัตตานี";
          }elseif ($request->get('BrachUser') == "51" or $request->get('BrachUser') == "ยะลา") {
            $SetBranch = "ยะลา";
          }elseif ($request->get('BrachUser') == "52" or $request->get('BrachUser') == "นราธิวาส") {
            $SetBranch = "นราธิวาส";
          }elseif ($request->get('BrachUser') == "53" or $request->get('BrachUser') == "สายบุรี") {
            $SetBranch = "สายบุรี";
          }elseif ($request->get('BrachUser') == "54" or $request->get('BrachUser') == "สุไหงโกลก") {
            $SetBranch = "สุไหงโกลก";
          }elseif ($request->get('BrachUser') == "55" or $request->get('BrachUser') == "เบตง") {
            $SetBranch = "เบตง";
          }elseif ($request->get('BrachUser') == "56" or $request->get('BrachUser') == "โคกโพธิ์") {
            $SetBranch = "โคกโพธิ์";
          }elseif ($request->get('BrachUser') == "57" or $request->get('BrachUser') == "ตันหยงมัส") {
            $SetBranch = "ตันหยงมัส";
          }elseif ($request->get('BrachUser') == "58" or $request->get('BrachUser') == "บันนังสตา") {
            $SetBranch = "บันนังสตา";
          }

          // สถานะ อนุมัติสัญญา
          if ($StatusApp == "อนุมัติ") {
            if ($cardetail->StatusApp_car == "รออนุมัติ") {
              $Date = date('d-m-Y', strtotime('+1 month'));
              $SetDate = \Carbon\Carbon::parse($Date)->format('Y')+543 ."-". \Carbon\Carbon::parse($Date)->format('m')."-". \Carbon\Carbon::parse($Date)->format('d');
              $datedueBF = date_create($SetDate);
              $DateDue = date_format($datedueBF, 'd-m-Y');

              if ($request->get('TypeContract') == "P03") {       //PLoan
                $connect = DB::table('Buyers')
                    ->leftJoin('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                    ->where('buyers.Flag', '=' ,'Y')
                    ->where('cardetails.Branch_car' ,$cardetail->branch_car)
                    ->orderBy('Contract_buyer', 'desc')->limit(1)
                    ->first();
              }elseif ($request->get('TypeContract') == "P06") {  //Micro
                $connect = DB::table('Buyers')
                    ->leftJoin('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                    ->where('buyers.Flag', '=' ,'E')
                    ->where('cardetails.Branch_car' ,$cardetail->branch_car)
                    ->orderBy('Contract_buyer', 'desc')->limit(1)
                    ->first();
              }elseif ($request->get('TypeContract') == "P07") {  //P07
                $connect = DB::table('Buyers')
                    ->leftJoin('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                    ->where('buyers.Flag', '=' ,'S')
                    ->where('cardetails.Branch_car' ,$cardetail->branch_car)
                    ->orderBy('Contract_buyer', 'desc')->limit(1)
                    ->first();
              }
              
              $cont = $connect->Contract_buyer;
              $SetStr = explode("/",$cont);
              $StrNum = $SetStr[1] + 1;
              
              $num = "1000";
              $SubStr = substr($num.$StrNum, -4);
              $StrConn = $SetStr[0]."/".$SubStr;
              
              $GetIdConn = Buyer::where('id',$id)->first();
                $GetIdConn->Contract_buyer = $StrConn;
                $GetIdConn->Flag = $SetFlag;
              $GetIdConn->update();
            }
          }
          else { //รออนุมัติ
            if ($Getcardetail->Date_Appcar == NULL) { //เช็คอนุมัติ
              $DateDue = NULL;      //วันดิวงวดแรก
              $newDateDue = NULL;   //วันอนุมัติ
              $StatusApp = "รออนุมัติ";
            } 
          }

          if ($Getcardetail->Date_Appcar == NULL) { //เช็คอนุมัติ
            $cardetail->Dateduefirst_car = $DateDue;     //วันที่ ดิวงวดแรก
            $cardetail->Date_Appcar = $newDateDue;       //วันที่ อนุมัติ
            $cardetail->StatusApp_car = $StatusApp;      //สถานะ อนุมัติ
          }

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
          if ($Getcardetail->Date_Appcar == NULL) { //เช็คอนุมัติ
            $cardetail->branch_car = $SetBranch;                       //สาขา   
          }
          $cardetail->DocComplete_car = $SetDocComplete;             //เอกสารครบ
          $cardetail->Check_car = $request->get('MASTER');           //หัวหน้า
          $cardetail->Approvers_car = $request->get('AUDIT');        //audit
          $cardetail->ManagerApp_car = $request->get('MANAGER');     //ผู้จัดการ
          $cardetail->branchbrance_car = $request->get('branchbrancecar');
          $cardetail->branchAgent_car = $request->get('branchAgentcar');
          $cardetail->Note_car = $request->get('Notecar');
        $cardetail->update();

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
          $expenses->totalk_Price = $SettotalkPrice;
          $expenses->balance_Price = $SetbalancePrice;
          $expenses->commit_Price = $SetcommitPrice;
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

          $path = public_path().'/upload-image/'.$SetLicense;
          Storage::makeDirectory($path, 0777, true, true);
          $image_array[$i]->move($path,$image_new_name);

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

          $path = public_path().'/upload-image/'.$SetLicense;
          Storage::makeDirectory($path, 0777, true, true);
          $image_array[$i]->move($path,$image_new_name);

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

          $path = public_path().'/upload-image/'.$SetLicense;
          Storage::makeDirectory($path, 0777, true, true);
          $image_array[$i]->move($path,$image_new_name);

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
        return redirect()->Route('Analysis',$type)->with(['newfdate' => $fdate,'newtdate' => $tdate,'branch' => $branch,'status' => $status,'success' => 'อัพเดตข้อมูลเรียบร้อย']);
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
      $item7 = Sponsor2::where('Buyer_id2',$id);
      $item8 = upload_lat_long::where('Use_id',$id);

      $item5 = UploadfileImage::where('Buyerfileimage_id','=',$id)->get();
      $countData = count($item5);
      $created_at = '';

      if($type == 1){
        if($countData != 0){
          $dataold = Buyer::where('id','=',$id)->first();
          $datacarold = Cardetail::where('Buyercar_id',$id)->first();
          $created_at = substr($dataold->created_at,0,10);
          $path = $datacarold->License_car;
        }
      }

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
      }
      if ($countData != 0) {
        $deleteItem = UploadfileImage::where('Buyerfileimage_id',$itemID);
        $deleteItem->Delete();
      }  

      $item9 = Data_customer::where('Customer_id',$item1->Walkin_id)->first();
        if ($item9 != NULL) {
          $item9->Status_leasing = 1;
          $item9->update();
        }

      $item1->Delete();
      $item2->Delete();
      $item3->Delete();
      $item4->Delete();
      $item7->Delete();
      $item8->Delete();

      return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }

    public function deleteImageAll($id,$path,Request $request)
    {
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

        foreach ($item as $key => $value) {
          $itemID = $value->Buyerfileimage_id;
          $itemPath = public_path().'/upload-image/'.$path.'/'.$value->Name_fileimage;
          File::delete($itemPath);
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

      $item1 = UploadfileImage::where('fileimage_id',$id);
      $data = UploadfileImage::where('fileimage_id','=',$id)->get();
      $countData = count($data);
      if($countData != 0){
        $dataold = Buyer::where('id','=',$mainid)->first();
        $created_at = substr($dataold->created_at,0,10);
      }

      foreach ($data as $key => $value) {
        $itemPath = public_path().'/upload-image/'.$path.'/'.$value->Name_fileimage;
        File::delete($itemPath);
      }
      
      $item1->Delete();
      return redirect()->Route('deleteImageEach',[$type,$mainid,$fdate,$tdate,$branch,$status,$path])->with(['success' => 'ลบรูปสำเร็จ']);
    }

}
