<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(auth()->user()->type == "Admin"){
        $users = User::all();
        return view('maindata.view', compact('users'));
      }else {
        dd('You not admin');
        return view('home');
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
      User::create([
        'name' => $request->get('name'),
        'username' => $request->get('username'),
        'email' => $request->get('email'),
        'password' => bcrypt($request->get('password')),
        'password_token' => $request->get('password'),
        'branch' => $request->get('branch'),
        'type' => $request->get('section_type'),
        'position' => $request->get('position'),
      ]);

      return redirect()->Route('MasterMaindata.index')->with('success','อัพเดตข้อมูลเรียบร้อย');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      if ($id == 1) {
        if(auth()->user()->type == "Admin"){    // เช็คสิทธิ์ ในตาราง user
          return view('maindata.register');
        }else{
          abort(404);
        }
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
      $user = User::find($id);
      return view('maindata.edit',compact('user','id'));
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
      $user = User::find($id);
        $user->username = $request->get('main_username');
        $user->name = $request->get('main_name');
        $user->email = $request->get('main_email');
        $user->branch = $request->get('branch');
        $user->type = $request->get('section_type');
        $user->position = $request->get('position');
      $user->update();

      return redirect()->Route('MasterMaindata.index')->with('success','อัพเดตข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $item = User::find($id);
      $item->Delete();

      return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }
}
