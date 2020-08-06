<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Connectdb2;
use App\DataIBM;
use DB;

use App\Buyer;
use App\Sponsor;
use App\Cardetail;
use App\homecardetail;
use App\Expenses;
use App\Holdcar;
use App\data_car;
use App\checkDocument;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($name)
    {
        // $conn = Connectdb2::where('CUSCOD','=','AHI-00000001')->get();
        // echo $conn[0]->NAME1;
        // echo iconv('Tis-620','utf-8',$conn[0]->NAME1).'<br>';
        // $data = DB::select("SELECT * FROM [IBM].[DATASF].[SFHP].[INVTRAN] WHERE [RECVNO] = 'AOC-03040001'");
        // dd($data);

        // $conn = DataIBM::where('RECVNO','=','AOC-03040001')->get();
        // dd($conn);

        // date_default_timezone_set('Asia/Bangkok');
        // $Y = date('Y');
        // $m = date('m');
        // $d = date('d');
        // $date = $Y.'-'.$m.'-'.$d;
        // $newdate = date('Y-m-d', strtotime('+3 days'));


        // $datafinance = DB::table('buyers')
        //           ->join('cardetails','buyers.id','=','cardetails.Buyercar_id')
        //           ->where('cardetails.Approvers_car','<>',Null)
        //           ->count();

        // $datahomecar = DB::table('buyers')
        //           ->join('homecardetails','buyers.id','=','homecardetails.Buyerhomecar_id')
        //           ->where('homecardetails.dateapp_HC','<>',Null)
        //           ->count();

        // $datamassage = DB::connection('ibmi')
        //           ->table('SFHP.ARMAST')
        //           ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
        //           ->whereBetween('SFHP.ARPAY.DDATE',[$newdate,$newdate])
        //           ->whereBetween('SFHP.ARMAST.HLDNO',[1.5,3.69])
        //           ->where('SFHP.ARMAST.BILLCOLL','=',99)
        //           ->count();

        // $datafollow = DB::connection('ibmi')
        //           ->table('SFHP.ARMAST')
        //           ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
        //           ->where('SFHP.ARMAST.BILLCOLL','=',99)
        //           ->whereBetween('SFHP.ARMAST.HLDNO',[2.5,4.69])
        //           ->whereBetween('SFHP.ARPAY.DDATE',[$date,$date])
        //           ->count();

        // $datanotice = DB::connection('ibmi')
        //           ->table('SFHP.ARMAST')
        //           ->join('SFHP.ARPAY','SFHP.ARMAST.CONTNO','=','SFHP.ARPAY.CONTNO')
        //           ->whereBetween('SFHP.ARPAY.DDATE',[$date,$date])
        //           ->whereBetween('SFHP.ARMAST.HLDNO',[4.7,5.69])
        //           ->count();

        // $datastock = DB::table('holdcars')->count();

        // $legisCourt = DB::table('legislations')
        //             ->where('legislations.Flag_status','=',1)
        //             ->count();

        // $legisCourt2 = DB::table('legislations')
        //             ->where('legislations.Flag_status','=',2)
        //             ->count();

        // $LegisAsset = DB::table('legisassets')->count();

        // $LegisCompro = DB::table('Legiscompromises')->count();
        
        return view($name, compact('datafinance','datahomecar','datafollow','datamassage','datanotice','datastock',
                                   'legisCourt','legisCourt2','LegisAsset','LegisCompro'));
    }

    public function get_json(Request $request)
    {
        $data = '{
            "1":{
                "2015-2019":[12,18,24,30,36,42,48,54,60,66,72,78,84],
                "2012-2014":[12,18,24,30,36,42,48,54,60,66,72],
                "2010-2011":[12,18,24,30,36,42,48,54,60,66,72],
                "2009":[12,18,24,30,36,42,48,54,60,66,72],
                "2008":[12,18,24,30,36,42,48,54,60,66,72],
                "2007":[12,18,24,30,36,42,48,54,60],
                "2006":[12,18,24,30,36,42,48,54,60],
                "2005-2003":[12,18,24,30,36,42,48]
            },
            "2":{
                "2015-2019":[12,18,24,30,36,42,48,54,60,66,72,78,84],
                "2012-2014":[12,18,24,30,36,42,48,54,60,66,72],
                "2010-2011":[12,18,24,30,36,42,48,54,60,66,72],
                "2009":[12,18,24,30,36,42,48,54,60,66,72],
                "2008":[12,18,24,30,36,42,48,54,60,66,72],
                "2007":[12,18,24,30,36,42,48,54,60],
                "2006":[12,18,24,30,36,42,48,54,60],
                "2005-2003":[12,18,24,30,36,42,48]
            },
            "3":{
                "2015-2020":[12,18,24,30,36,42,48,54,60],
                "2013-2014":[12,18,24,30,36,42,48,54,60],
                "2010-2012":[12,18,24,30,36,42,48,54,60],
                "2008-2009":[12,18,24,30,36,42,48],
                "2006-2007":[12,18,24,30,36,42,48],
                "2004-2005":[12,18,24,30,36]
            }
        }';

        $json_data = json_decode($data);
        // dd($json_data);
        $type = $request->type;
        $year = $request->year;
        $showtext = $request->showtext;

        switch ($request->action) {
            case 'type':
                echo "<option value='0'>- เลือกปี -</option>";
                foreach ($json_data->$type as $year => $value) {
                    echo "<option value='$year' >$year</option>" ;
                }
                break;
            case 'year':
                foreach ($json_data->$type->$year as $value) {
                    echo "<option value='$value' >$value</option>" ;
                }
                break;
            case 'showtext':
                foreach ($json_data->$type->$year as $value) {
                    echo "<option value='$value' >$value</option>" ;
                }
                break;

            default:
                # code...
                break;
        }
    }

}
