<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 1) {
            if ($request->has('Fromdate')){
                $newfdate = $request->get('Fromdate');
            }
            if ($request->has('Todate')){
                $newtdate = $request->get('Todate');
            }
            if ($request->has('Fromdate') == false and $request->has('Todate') == false) {
                $dataApp = DB::table('buyers')
                    ->leftJoin('cardetails','buyers.id','=','cardetails.Buyercar_id')
                    ->leftJoin('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->where('cardetails.Date_Appcar',date('Y-m-d'))
                    ->where('cardetails.Approvers_car','<>', NULL)
                    ->where('buyers.Contract_buyer','not like', '22%')
                    ->where('buyers.Contract_buyer','not like', '33%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get();

                $dataTrans = DB::table('buyers')
                    ->leftJoin('cardetails','buyers.id','=','cardetails.Buyercar_id')
                    ->leftJoin('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->where('cardetails.DateCheckAc_car',date('Y-m-d'))
                    ->where('cardetails.UserCheckAc_car','<>', Null)
                    ->where('buyers.Contract_buyer','not like', '22%')
                    ->where('buyers.Contract_buyer','not like', '33%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get();
            }else {
                $dataApp = DB::table('buyers')
                    ->leftJoin('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                    ->leftJoin('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                        return $q->whereBetween('cardetails.Date_Appcar',[$newfdate,$newtdate]);
                    })
                    ->where('cardetails.Approvers_car','<>', NULL)
                    ->where('buyers.Contract_buyer','not like', '22%')
                    ->where('buyers.Contract_buyer','not like', '33%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get();

                $dataTrans = DB::table('buyers')
                    ->leftJoin('cardetails','Buyers.id','=','cardetails.Buyercar_id')
                    ->leftJoin('expenses','buyers.id','=','expenses.Buyerexpenses_id')
                    ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
                        return $q->whereBetween('cardetails.DateCheckAc_car',[$newfdate,$newtdate]);
                    })
                    ->where('cardetails.UserCheckAc_car','<>', NULL)
                    ->where('buyers.Contract_buyer','not like', '22%')
                    ->where('buyers.Contract_buyer','not like', '33%')
                    ->orderBy('buyers.Contract_buyer', 'ASC')
                    ->get();
            }

            $SumApp = 0;
            if ($dataApp != NULL) {
                foreach ($dataApp as $key => $value) {
                    $SumApp += $value->Top_car;
                }
            }
            $SumTrans = 0;
            if ($dataTrans != NULL) {
                foreach ($dataTrans as $key => $value) {
                    $SumTrans += $value->Top_car;
                }
            }
            
            return view('accounting.view', compact('dataApp','dataTrans','SumApp','SumTrans'));
        }
        elseif ($request->type == 2) {
            $type = $request->type;
            return view('accounting.viewReport',compact('type'));
        }elseif ($request->type == 3) {
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
    
            if ($newfdate != '' and $newtdate != '') {
              $newfdate = \Carbon\Carbon::parse($newfdate)->format('Y') ."-". \Carbon\Carbon::parse($newfdate)->format('m')."-". \Carbon\Carbon::parse($newfdate)->format('d');
              $newtdate = \Carbon\Carbon::parse($newtdate)->format('Y') ."-". \Carbon\Carbon::parse($newtdate)->format('m')."-". \Carbon\Carbon::parse($newtdate)->format('d');
            }elseif ($newfdate == '' or $newtdate == '') {
            }
            $type = $request->type;
            return view('analysis.viewReport', compact('type', 'data','newfdate','newtdate','datadrop','agen','datedue','datayear','yearcar','datastatus','typecar','databranch','branch'));
        }
    }
}
