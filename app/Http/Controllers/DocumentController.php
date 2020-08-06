<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filedocument;
use App\Filefolder;
use DB;
use File;
use Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = DB::table('filefolders')
            //   ->orderBY('created_at', 'DESC')
              ->get();
        return view('document.home', compact('data','newfdate','newtdate'));
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
    public function store(Request $request, $type)
    {
        // dd($request);
        if($type == 1){
            $data = new Filefolder;
            $data->folder_name = $request->foldername;
            $data->folder_creator = $request->creator;
            $data->save();
        }
        elseif($type == 2){
            $data = new Filedocument;
            if($request->file('file')){
                $file = $request->file('file');
                $filesize = $file->getClientSize();
                $filename = $request->title.date('dmY'). '.' .$file->getClientOriginalExtension();
                // $filename = time().'.'.$file->getClientOriginalExtension();
                // $destination_path = public_path('/file-documents');
                // $request->file->move($destination_path.'/'.$filename);
                $destination_path = public_path().'/file-documents/'.$request->folder;
                Storage::makeDirectory($destination_path, 0777, true, true);
                $request->file->move($destination_path, $filename);
                $data->file_name = $filename;
                $data->file_size = $filesize;
            }
            $data->folder_id = $request->folder_id;
            $data->file_title = $request->title;
            $data->file_description = $request->description;
            $data->file_uploader = $request->uploader;
            $data->save();
        }

        return redirect()->back()->with('success','ข้อมูลเรียบร้อย');
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
    public function edit($id,Request $request, $type)
    {
        // dd($id);
        if($type == 1){
            $folder = Filefolder::find($id);
            $data = DB::table('filefolders')
                ->join('filedocuments','filefolders.folder_id','=','filedocuments.folder_id')
                ->where('filedocuments.folder_id','=',$id)
                ->orderBY('filedocuments.created_at', 'DESC')
                ->get();
            $title = $folder->folder_name;
            return view('document.view',compact('data','title','id'));
        }
        elseif($type == 2){
            $folder_name = $request->foldername;
            $data = Filedocument::find($id);
            return view('document.preview',compact('data','folder_name'));
        }
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
    public function destroy(Request $request,$id,$type)
    {
        if($type == 1){
            $item1 = Filefolder::find($id);
            $item1->Delete();
            $itemPath = public_path().'/file-documents/'.$request->foldername;
            File::deleteDirectory($itemPath);
        }
        elseif($type == 2){
            $item1 = Filedocument::find($id);
            $itemPath = public_path().'/file-documents/'.$request->foldername.'/'.$item1->file_name;
            File::delete($itemPath);
            $item1->Delete();
        }
        return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }
    public function download($file)
    {   
        // dd($file);
        $destination_path = public_path('/file-documents');
        return response()->download($destination_path. '/' .$file);
    }
}
