<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Data_insure;

class InsureController extends Controller
{
    public function index(Request $request, $type)
    {
        // dump($type);
        $newfdate = '';
        $newtdate = '';
        $data = DB::table('data_insures')
              ->orderBY('created_at', 'DESC')
              ->get();
        return view('insurance.view', compact('data','type','newfdate','newtdate'));
    }

    public function store(Request $request, $type)
    {
        // dd($request,$type);
        $Data_insureDB = new Data_insure([
            'Number_register' => $request->get('Registercar'),
            'Brand_car' => $request->get('Brandcar'),
            'Year_car' => $request->get('Yearcar'),
            'Version_car' => $request->get('Versioncar'),
            'Engno_car' => $request->get('Engnocar'),
            'Type_car' => $request->get('Typecar'),
            'Register_expire' => $request->get('RegisterExpire'),
            'Insure_expire' => $request->get('InsureExpire'),
            'Act_expire' => $request->get('ActExpire'),
            'Check_car' => $request->get('Checkcar'),
            'Note_car' => $request->get('Notecar'),
            'Name_user' => $request->get('NameUser'),
            'Date_useradd' => date('Y-m-d'),
          ]);
          $Data_insureDB->save();
        return redirect()->Route('Insure',$type)->with('success','บันทึกข้อมูลเรียบร้อย');
    }

    public function destroy(Request $request,$id)
    {
        dd($id);
        return redirect()->Route('Insure',$type)->with('success','ลบข้อมูลเรียบร้อย');
    }

}
