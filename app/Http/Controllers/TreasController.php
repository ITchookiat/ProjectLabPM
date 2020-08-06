<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use Carbon\Carbon;

use App\Buyer;
use App\Sponsor;
use App\Cardetail;
use App\Expenses;

class TreasController extends Controller
{
    public function index(Request $request)
    {
        $date = date('Y-m-d');

        if ($request->type == 1) {
            $newfdate = '';
            $newtdate = '';

            if ($request->has('Fromdate')){
                $newfdate = $request->get('Fromdate');
            }
            if ($request->has('Todate')){
                $newtdate = $request->get('Todate');
            }

            if ($request->has('Fromdate') == false and $request->has('Todate') == false) {
                $data = DB::table('buyers')
                        ->join('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                        ->join('Expenses','Buyers.id','=','Expenses.Buyerexpenses_id')
                        ->where('cardetails.Date_Appcar', $date)
                        ->where('buyers.Contract_buyer','not like', '22%')
                        ->where('buyers.Contract_buyer','not like', '33%')
                        ->where('cardetails.Approvers_car','<>','')
                        ->orderBy('buyers.Contract_buyer', 'ASC')
                        ->get();

            }
            else {
                $data = DB::table('buyers')
                        ->join('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                        ->join('Expenses','Buyers.id','=','Expenses.Buyerexpenses_id')
                        ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                            return $q->whereBetween('cardetails.Date_Appcar',[$newfdate,$newtdate]);
                        })
                        ->where('buyers.Contract_buyer','not like', '22%')
                        ->where('buyers.Contract_buyer','not like', '33%')
                        ->where('cardetails.Approvers_car','<>','')
                        ->orderBy('buyers.Contract_buyer', 'ASC')
                        ->get();
            }
            return view('treasury.view', compact('data','newfdate','newtdate'));
        }
        elseif ($request->type == 2) {
            $type = $request->type;
            
            return view('treasury.viewReport',compact('type'));
        }
        elseif ($request->type == 3) {
            $type = $request->type;
            
            return view('treasury.viewReport',compact('type'));
        }
    }

    public function SearchData(Request $request, $type, $id)
    {
        if ($type == 1 or $type == 2) {
            $data = DB::table('buyers')
                    ->join('sponsors','buyers.id','=','sponsors.Buyer_id')
                    ->join('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                    ->join('Expenses','Buyers.id','=','Expenses.Buyerexpenses_id')
                    ->select('buyers.*','sponsors.*','cardetails.*','Expenses.*','buyers.created_at AS createdBuyers_at')
                    ->where('buyers.id', $id)
                    ->first();

                    // dd($data);

            if ($data->Payee_car != NULL) {
                $SetAccount = str_replace ("-","",$data->Accountbrance_car);
                $SetTell = str_replace ("-","",$data->Tellbrance_car);
            }else {
                $SetAccount = "";
                $SetTell = "";
            }

            if ($data->Payee_car != NULL) {
                $SetAccountGT = str_replace ("-","",$data->Accountagent_car);
                $SetTellGT = str_replace ("-","",$data->Tellagent_car);
            }else {
                $SetAccountGT = "";
                $SetTellGT = "";
            }

            $GetType = $type;
            return view('treasury.viewDetail', compact('data','GetType','SetAccount','SetTell','SetAccountGT','SetTellGT'));
        }
        elseif ($type == 3) {
            $data = DB::table('buyers')
                ->leftJoin('cardetails','buyers.id','=','cardetails.Buyercar_id')
                ->where('cardetails.Date_Appcar','>=',date('Y-m-d'))
                ->where('cardetails.UserCheckAc_car','=',Null)
                ->get();

                $countData = Count($data);

            if ($countData == 0) {
            $countData = NULL;
            }else {
            $countData = '<span class="badge badge-danger navbar-badge">'.$countData.'</span>';
            }
            
            echo $countData;
        }
    }

    public function updateAnalysis(Request $request, $type, $id)
    {
        if ($type == 1) {
            if ($request->has('checkAccount') != NULL) {
                $user = Cardetail::find($id);
                    $user->UserCheckAc_car = $request->get('checkAccount');
                    $user->DateCheckAc_car = date('Y-m-d');
                $user->update();
            }
        
            return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
        }
    }

    public function ReportDueDate(Request $request, $type)
    {
        date_default_timezone_set('Asia/Bangkok');
        $Y = date('Y');
        $Y2 = date('Y') +543;
        $m = date('m');
        $d = date('d');
        $date2 = $d.'-'.$m.'-'.$Y2;

        $newfdate = '';
        $newtdate = '';

        if ($request->has('Fromdate')) {
            $newfdate = $request->get('Fromdate');
        }
        if ($request->has('Todate')) {
            $newtdate = $request->get('Todate');
        }

        if ($type == 2) {
            $dataReport = DB::table('buyers')
                    ->join('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                    ->join('Expenses','Buyers.id','=','Expenses.Buyerexpenses_id')
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                        return $q->whereBetween('cardetails.Date_Appcar',[$newfdate,$newtdate]);
                    })
                    ->where('buyers.Contract_buyer','not like', '22%')
                    ->where('buyers.Contract_buyer','not like', '33%')
                    ->where('cardetails.Approvers_car','<>','')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get();

            $view = \View::make('analysis.ReportDueDate' ,compact('dataReport','date2'));
            $html = $view->render();
            $pdf = new PDF();
            $pdf::SetTitle('รายงานนำเสนอ');
            $pdf::AddPage('L', 'A4');
            $pdf::SetMargins(5, 5, 5, 0);
            $pdf::SetFont('freeserif', '', 8, '', true);
            $pdf::SetAutoPageBreak(TRUE, 25);

            $pdf::WriteHTML($html,true,false,true,false,'');
            $pdf::Output('report.pdf');
        }
        elseif ($type == 3) {
            $dataReport = DB::table('buyers')
            ->join('cardetails','Buyers.id','=','cardetails.Buyercar_id')
            ->join('Expenses','Buyers.id','=','Expenses.Buyerexpenses_id')
            ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                return $q->whereBetween('cardetails.DateCheckAc_car',[$newfdate,$newtdate]);
            })
            ->where('cardetails.UserCheckAc_car','<>',NULL)
            ->orderBy('buyers.Contract_buyer', 'ASC')
            ->get();

            dd('ยังไม่เปิดให้ใช้งาน');

            $view = \View::make('treasury.reportTreas' ,compact('dataReport','type','newfdate','newtdate'));
            $html = $view->render();
            $pdf = new PDF();
            $pdf::SetTitle('รายงานแผนกการเงิน');
            $pdf::AddPage('L', 'A4');
            $pdf::SetMargins(5, 5, 5, 0);
            $pdf::SetFont('freeserif', '', 8, '', true);
            $pdf::SetAutoPageBreak(TRUE, 25);

            $pdf::WriteHTML($html,true,false,true,false,'');
            $pdf::Output('report.pdf');
        }
    }
}
