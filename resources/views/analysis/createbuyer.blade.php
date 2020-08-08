@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
@section('content')

@php
  date_default_timezone_set('Asia/Bangkok');
  $Y = date('Y') + 543;
  $Y2 = date('Y') + 531;
  $m = date('m');
  $d = date('d');
  $time = date('H:i');
  $date1 = $Y.'-'.$m.'-'.$d;
  $date2 = $Y2.'-'.'01'.'-'.'01';
@endphp

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>

  <style>
    #todo-list{
    width:100%;
    margin:0 auto 50px auto;
    padding:5px;
    background:white;
    position:relative;
    /*box-shadow*/
    -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
    -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
          box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
    /*border-radius*/
    -webkit-border-radius:5px;
    -moz-border-radius:5px;
          border-radius:5px;}
    #todo-list:before{
    content:"";
    position:absolute;
    z-index:-1;
    /*box-shadow*/
    -webkit-box-shadow:0 0 20px rgba(0,0,0,0.4);
    -moz-box-shadow:0 0 20px rgba(0,0,0,0.4);
          box-shadow:0 0 20px rgba(0,0,0,0.4);
    top:50%;
    bottom:0;
    left:10px;
    right:10px;
    /*border-radius*/
    -webkit-border-radius:100px / 10px;
    -moz-border-radius:100px / 10px;
          border-radius:100px / 10px;
    }
    .todo-wrap{
    display:block;
    position:relative;
    padding-left:35px;
    /*box-shadow*/
    -webkit-box-shadow:0 2px 0 -1px #ebebeb;
    -moz-box-shadow:0 2px 0 -1px #ebebeb;
          box-shadow:0 2px 0 -1px #ebebeb;
    }
    .todo-wrap:last-of-type{
    /*box-shadow*/
    -webkit-box-shadow:none;
    -moz-box-shadow:none;
          box-shadow:none;
    }
    input[type="checkbox"]{
    position:absolute;
    height:0;
    width:0;
    opacity:0;
    /* top:-600px; */
    }
    .todo{
    display:inline-block;
    font-weight:200;
    padding:10px 5px;
    height:37px;
    position:relative;
    }
    .todo:before{
    content:'';
    display:block;
    position:absolute;
    top:calc(50% + 10px);
    left:0;
    width:0%;
    height:1px;
    background:#cd4400;
    /*transition*/
    -webkit-transition:.25s ease-in-out;
    -moz-transition:.25s ease-in-out;
      -o-transition:.25s ease-in-out;
          transition:.25s ease-in-out;
    }
    .todo:after{
    content:'';
    display:block;
    position:absolute;
    z-index:0;
    height:18px;
    width:18px;
    top:9px;
    left:-25px;
    /*box-shadow*/
    -webkit-box-shadow:inset 0 0 0 2px #d8d8d8;
    -moz-box-shadow:inset 0 0 0 2px #d8d8d8;
          box-shadow:inset 0 0 0 2px #d8d8d8;
    /*transition*/
    -webkit-transition:.25s ease-in-out;
    -moz-transition:.25s ease-in-out;
      -o-transition:.25s ease-in-out;
          transition:.25s ease-in-out;
    /*border-radius*/
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
          border-radius:4px;
    }
    .todo:hover:after{
    /*box-shadow*/
    -webkit-box-shadow:inset 0 0 0 2px #949494;
    -moz-box-shadow:inset 0 0 0 2px #949494;
          box-shadow:inset 0 0 0 2px #949494;
    }
    .todo .fa-check{
    position:absolute;
    z-index:1;
    left:-31px;
    top:0;
    font-size:1px;
    line-height:36px;
    width:36px;
    height:36px;
    text-align:center;
    color:transparent;
    text-shadow:1px 1px 0 white, -1px -1px 0 white;
    }
    :checked + .todo{
    color:#717171;
    }
    :checked + .todo:before{
    width:100%;
    }
    :checked + .todo:after{
    /*box-shadow*/
    -webkit-box-shadow:inset 0 0 0 2px #0eb0b7;
    -moz-box-shadow:inset 0 0 0 2px #0eb0b7;
          box-shadow:inset 0 0 0 2px #0eb0b7;
    }
    :checked + .todo .fa-check{
    font-size:20px;
    line-height:35px;
    color:#0eb0b7;
    }
    /* Delete Items */

    .delete-item{
    display:block;
    position:absolute;
    height:36px;
    width:36px;
    line-height:36px;
    right:0;
    top:0;
    text-align:center;
    color:#d8d8d8;
    opacity:0;
    }
    .todo-wrap:hover .delete-item{
    opacity:1;
    }
    .delete-item:hover{
    color:#cd4400;
    }
  </style>

  <section class="content">
    <div class="content-header">
      @if(session()->has('success'))
        <script type="text/javascript">
          toastr.success('{{ session()->get('success') }}')
        </script>
      @endif

      <section class="content">
        <form name="form1" action="{{ route('MasterAnalysis.store') }}" method="post" id="formimage" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-inline">
                        <h4>เพิ่มรายการ (New PLoan-Micro)</h4>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="card-tools d-inline float-right">
                        <button type="submit" class="delete-modal btn btn-success">
                          <i class="fas fa-save"></i> บันทึก
                        </button>
                        <a class="delete-modal btn btn-danger" href="{{ route('Analysis',1) }}">
                          <i class="far fa-window-close"></i> ยกเลิก
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body text-sm">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-3">
                        {{-- <h1 class="m-0 text-dark">Dashboard v2</h1> --}}
                      </div>
                      <div class="col-sm-9">
                        <ol class="breadcrumb float-sm-right">
                          {{-- PLoan --}}
                          <div class="float-right form-inline">
                            <i class="fas fa-grip-vertical"></i>
                            <span class="todo-wrap">
                            <input type="checkbox" id="3" class="checkbox" name="TypeContract" value="P03-">
                              <label for="3" class="todo">
                                <i class="fa fa-check"></i>
                                <span class="text"><font color="red">PLOAN &nbsp;&nbsp;</font></span>
                              </label>
                            </span>
                          </div>

                          {{-- Micro --}}
                          <div class="float-right form-inline">
                            <i class="fas fa-grip-vertical"></i>
                            <span class="todo-wrap">
                              <input type="checkbox" id="4" class="checkbox" name="TypeContract" value="P06-">
                              <label for="4" class="todo">
                                <i class="fa fa-check"></i>
                                <span class="text"><font color="red">MICRO &nbsp;&nbsp;</font></span>
                              </label>
                            </span>
                          </div>
                          
                          {{-- ปิดสิทธ์แก้ไข / เอกสารครบ --}}
                          <div class="float-right form-inline">
                            <i class="fas fa-grip-vertical"></i>
                            <span class="todo-wrap">
                              <input type="checkbox" id="1" class="checkbox" name="doccomplete" value="{{ auth::user()->name }}"> <!-- checked="checked"  -->
                              <label for="1" class="todo">
                                <i class="fa fa-check"></i>
                                <span class="text"><font color="red">RESTRICT RIGHTS &nbsp;&nbsp;</font></span>
                              </label>
                            </span>
                          </div>
                        </ol>
                      </div>
                    </div>
                  </div>

                  <div class="card card-warning card-tabs">
                    <div class="card-header p-0 pt-1">
                      <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link MainPage" href="{{ route('Analysis',1) }}">หน้าหลัก</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" id="Sub-custom-tab1" data-toggle="pill" href="#Sub-tab1" role="tab" aria-controls="Sub-tab1" aria-selected="false">แบบฟอร์มผู้เช่าซื้อ</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Sub-custom-tab2" data-toggle="pill" href="#Sub-tab2" role="tab" aria-controls="Sub-tab2" aria-selected="false">แบบฟอร์มผู้ค้ำ</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Sub-custom-tab3" data-toggle="pill" href="#Sub-tab3" role="tab" aria-controls="Sub-tab3" aria-selected="false">แบบฟอร์มรถยนต์</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Sub-custom-tab4" data-toggle="pill" href="#Sub-tab4" role="tab" aria-controls="Sub-tab4" aria-selected="false">แบบฟอร์มค่าใช้จ่าย</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Sub-custom-tab5" data-toggle="pill" href="#Sub-tab5" role="tab" aria-controls="Sub-tab5" aria-selected="false">Checker</a>
                        </li>
                      </ul>
                    </div>
                    
                    {{-- เนื้อหา --}}
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="tab-pane fade show active" id="Sub-tab1" role="tabpanel" aria-labelledby="Sub-custom-tab1">
                          <h5 class="text-center"><b>แบบฟอร์มรายละเอียดผู้เช่าซื้อ</b></h5>
                          <p></p>
                          <div>
                            <div class="row">
                              @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right"><font color="red">เลขที่สัญญา : </font></label>
                                    <div class="col-sm-8">
                                      <input type="text" name="Contract_buyer" class="form-control" placeholder="ป้อนเลขที่สัญญา" />
                                    </div>
                                  </div>
                                </div>
                              @endif
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right"><font color="red">สาขา : </font></label>
                                  <div class="col-sm-8">
                                    <select name="BrachUser" class="form-control" required>
                                      <option value="" selected>--- เลือกสาขาตัวเอง ---</option>
                                      <option value="20">ปัตตานี (20)</option>
                                      <option value="21">ยะลา (21)</option>
                                      <option value="22">นราธิวาส (22)</option>
                                      <option value="23">สายบุรี (23)</option>
                                      <option value="24">สุไหงโกลก (24)</option>
                                      <option value="25">เบตง (25)</option>
                                      <option value="26">โคกโพธิ์ (26)</option>
                                      <option value="27">ระแงะ (27)</option>
                                      <option value="28">บันนังสตา (28)</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right"><font color="red">วันที่ทำสัญญา : </font></label>
                                  <div class="col-sm-8">
                                    <input type="date" name="DateDue" class="form-control"  value="{{ date('Y-m-d') }}">
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ชื่อ : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Namebuyer" class="form-control" placeholder="ป้อนชื่อ" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">นามสกุล : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="lastbuyer" class="form-control" placeholder="ป้อนนามสกุล" />
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ชื่อเล่น : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Nickbuyer" class="form-control" placeholder="ป้อนชื่อเล่น" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">สถานะ : </label>
                                  <div class="col-sm-8">
                                    <select name="Statusbuyer" class="form-control">
                                      <option value="" selected>--- เลือกสถานะ ---</option>
                                      <option value="โสด">โสด</option>
                                      <option value="สมรส">สมรส</option>
                                      <option value="หย่าร้าง">หย่าร้าง</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เบอร์โทรศัพท์ : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Phonebuyer" class="form-control" placeholder="ป้อนเบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask=""/>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6"> 
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เบอร์โทรอื่นๆ : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Phone2buyer" class="form-control" placeholder="ป้อนเบอร์โทรอื่นๆ" />
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เลขบัตรปชช.ผู้ซื้อ : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Idcardbuyer" class="form-control" placeholder="ป้อนเลขประชาชนผู้ซื้อ" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">คู่สมรส : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Matebuyer" class="form-control" placeholder="ป้อนคู่สมรส" />
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ที่อยู่ : </label>
                                  <div class="col-sm-8">
                                    <select name="Addressbuyer" class="form-control">
                                      <option value="" selected>--- เลือกที่อยู่ ---</option>
                                      <option value="ตามทะเบียนบ้าน">ตามทะเบียนบ้าน</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ที่อยู่ปัจจุบัน/ส่งเอกสาร : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="AddNbuyer" class="form-control" placeholder="ที่อยู่ปัจจุบัน/ส่งเอกสาร" />
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">รายละเอียดที่อยู่ : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="StatusAddbuyer" class="form-control" placeholder="ป้อนรายละเอียดที่อยู่" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">สถานที่ทำงาน : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Workplacebuyer" class="form-control" placeholder="ป้อนสถานที่ทำงาน" />
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ลักษณะบ้าน : </label>
                                  <div class="col-sm-8">
                                    <select name="Housebuyer" class="form-control">
                                      <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                      <option value="บ้านตึก 1 ชั้น">บ้านตึก 1 ชั้น</option>
                                      <option value="บ้านตึก 2 ชั้น">บ้านตึก 2 ชั้น</option>
                                      <option value="บ้านไม้ 1 ชั้น">บ้านไม้ 1 ชั้น</option>
                                      <option value="บ้านไม้ 2 ชั้น">บ้านไม้ 2 ชั้น</option>
                                      <option value="บ้านเดี่ยว">บ้านเดี่ยว</option>
                                      <option value="แฟลต">แฟลต</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ประเภทหลักทรัพย์ : </label>
                                  <div class="col-sm-8">
                                    <select name="securitiesbuyer" class="form-control">
                                      <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                      <option value="โฉนด">โฉนด</option>
                                      <option value="นส.3">นส.3</option>
                                      <option value="นส.3 ก">นส.3 ก</option>
                                      <option value="นส.4">นส.4</option>
                                      <option value="นส.4 จ">นส.4 จ</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เลขที่โฉนด : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="deednumberbuyer" class="form-control" placeholder="เลขที่โฉนด" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เนื่อที่ : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="areabuyer" class="form-control" placeholder="เนื้อที่" data-inputmask="&quot;mask&quot;:&quot;99-9-99&quot;" data-mask=""/>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ประเภทบ้าน : </label>
                                  <div class="col-sm-8">
                                    <select name="HouseStylebuyer" class="form-control">
                                      <option value="" selected>--- ประเภทบ้าน ---</option>
                                      <option value="ของตนเอง">ของตนเอง</option>
                                      <option value="อาศัยบิดา-มารดา">อาศัยบิดา-มารดา</option>
                                      <option value="อาศัยผู้อื่น">อาศัยผู้อื่น</option>
                                      <option value="บ้านพักราชการ">บ้านพักราชการ</option>
                                      <option value="บ้านเช่า">บ้านเช่า</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">อาชีพ : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Careerbuyer" class="form-control" placeholder="อาชีพ"/>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">รายได้ : </label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Incomebuyer" class="form-control" placeholder="รายได้"/>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ใบขับขี่ : </label>
                                  <div class="col-sm-8">
                                    <select name="Driverbuyer" class="form-control">
                                      <option value="" selected>--- ใบขับขี่ ---</option>
                                      <option value="มี">มี</option>
                                      <option value="ไม่มี">ไม่มี</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">หักค่าใช้จ่าย : </label>
                                  <div class="col-sm-8">
                                    <input type="text" id="Beforeincome" name="Beforeincome" class="form-control" placeholder="ก่อนหักค่าใช้จ่าย" oninput="income();" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ประวัติการซื้อ/ค้ำ : </label>
                                  <div class="col-sm-4">
                                    <select name="Purchasebuyer" class="form-control">
                                      <option value="" selected>--- ซื้อ ---</option>
                                      <option value="0 คัน">0 คัน</option>
                                      <option value="1 คัน">1 คัน</option>
                                      <option value="2 คัน">2 คัน</option>
                                      <option value="3 คัน">3 คัน</option>
                                      <option value="4 คัน">4 คัน</option>
                                      <option value="5 คัน">5 คัน</option>
                                      <option value="6 คัน">6 คัน</option>
                                      <option value="7 คัน">7 คัน</option>
                                      <option value="8 คัน">8 คัน</option>
                                      <option value="9 คัน">9 คัน</option>
                                      <option value="10 คัน">10 คัน</option>
                                      <option value="11 คัน">11 คัน</option>
                                      <option value="12 คัน">12 คัน</option>
                                      <option value="13 คัน">13 คัน</option>
                                      <option value="14 คัน">14 คัน</option>
                                      <option value="15 คัน">15 คัน</option>
                                      <option value="16 คัน">16 คัน</option>
                                      <option value="17 คัน">17 คัน</option>
                                      <option value="18 คัน">18 คัน</option>
                                      <option value="19 คัน">19 คัน</option>
                                      <option value="20 คัน">20 คัน</option>
                                    </select>
                                  </div>
                                  <div class="col-sm-4">
                                    <select name="Supportbuyer" class="form-control">
                                      <option value="" selected>--- ค้ำ ---</option>
                                      <option value="0 คัน">0 คัน</option>
                                      <option value="1 คัน">1 คัน</option>
                                      <option value="2 คัน">2 คัน</option>
                                      <option value="3 คัน">3 คัน</option>
                                      <option value="4 คัน">4 คัน</option>
                                      <option value="5 คัน">5 คัน</option>
                                      <option value="6 คัน">6 คัน</option>
                                      <option value="7 คัน">7 คัน</option>
                                      <option value="8 คัน">8 คัน</option>
                                      <option value="9 คัน">9 คัน</option>
                                      <option value="10 คัน">10 คัน</option>
                                      <option value="11 คัน">11 คัน</option>
                                      <option value="12 คัน">12 คัน</option>
                                      <option value="13 คัน">13 คัน</option>
                                      <option value="14 คัน">14 คัน</option>
                                      <option value="15 คัน">15 คัน</option>
                                      <option value="16 คัน">16 คัน</option>
                                      <option value="17 คัน">17 คัน</option>
                                      <option value="18 คัน">18 คัน</option>
                                      <option value="19 คัน">19 คัน</option>
                                      <option value="20 คัน">20 คัน</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">รายได้หลังหักค่าใช้จ่าย : </label>
                                  <div class="col-sm-8">
                                    <input type="text" id="Afterincome" name="Afterincome" class="form-control" placeholder="หลังหักค่าใช้จ่าย" oninput="income();" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">สถานะผู้เช่าซื้อ : </label>
                                  <div class="col-sm-8">
                                    <select id="Gradebuyer" name="Gradebuyer" class="form-control">
                                      <option value="" selected>--- สถานะผู้เช่าซื้อ ---</option>
                                      <option value="ลูกค้าเก่าผ่อนดี">ลูกค้าเก่าผ่อนดี</option>
                                      <option value="ลูกค้าเก่ามีงานตาม">ลูกค้าเก่ามีงานตาม</option>
                                      <option value="ลูกค้ามีงานตาม">ลูกค้ามีงานตาม</option>
                                      <option value="ลูกค้าใหม่">ลูกค้าใหม่</option>
                                      <option value="ลูกค้าใหม่(ปิดธนาคาร)">ลูกค้าใหม่(ปิดธนาคาร)</option>
                                      <option value="ปิดจัดใหม่(งานตาม)">ปิดจัดใหม่(งานตาม)</option>
                                      <option value="ปิดจัดใหม่(ผ่อนดี)">ปิดจัดใหม่(ผ่อนดี)</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">วัตถุประสงค์ของสินเชื่อ : </label>
                                  <div class="col-sm-8">
                                    <select name="objectivecar" class="form-control">
                                      <option value="" selected>--- วัตถุประสงค์ของสินเชื่อ ---</option>
                                      <option value="ลงทุนในธุรกิจ">ลงทุนในธุรกิจ</option>
                                      <option value="ขยายกิจการ">ขยายกิจการ</option>
                                      <option value="ซื้อรถยนต์">ซื้อรถยนต์</option>
                                      <option value="ใช้หนี้นอกระบบ">ใช้หนี้นอกระบบ</option>
                                      <option value="จ่ายค่าเทอม">จ่ายค่าเทอม</option>
                                      <option value="ซื้อของใช้ภายในบ้าน">ซื้อของใช้ภายในบ้าน</option>
                                      <option value="ซื้อวัว">ซื้อวัว</option>
                                      <option value="ซื้อที่ดิน">ซื้อที่ดิน</option>
                                      <option value="ซ่อมบ้าน">ซ่อมบ้าน</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <hr>
                            <div class="row">
                              <div class="col-md-12">
                                <h5 class="text-center"><b>รูปภาพประกอบ</b></h5>
                                <div class="form-group">
                                  <div class="file-loading">
                                    <input id="image-file" type="file" name="file_image[]" accept="image/*" data-min-file-count="1" multiple>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="Sub-tab2" role="tabpanel" aria-labelledby="Sub-custom-tab2">
                          <h5 class="text-center"><b>แบบฟอร์มรายละเอียดผู้ค้ำ</b></h5>
                          <div class="float-right form-inline">
                            <a class="btn btn-default" title="เพิ่มข้อมูลผู้ค้ำที่ 2" data-toggle="modal" data-target="#modal-default" data-backdrop="static" data-keyboard="false">
                              <i class="fa fa-users fa-lg"></i>
                            </a>
                          </div>
                          <br><br>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ชื่อ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="nameSP" class="form-control" placeholder="ชื่อ" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">นามสกุล : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="lnameSP" class="form-control" placeholder="นามสกุล" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ชื่อเล่น : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="niknameSP" class="form-control" placeholder="ชื่อเล่น" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">สถานะ : </label>
                                <div class="col-sm-8">
                                  <select name="statusSP" class="form-control">
                                    <option value="" selected>--- สถานะ ---</option>
                                    <option value="โสด">โสด</option>
                                    <option value="สมรส">สมรส</option>
                                    <option value="หย่าร้าง">หย่าร้าง</option>
                                    <option value="เสียชีวิต">เสียชีวิต</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เบอร์โทร : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="telSP" class="form-control" placeholder="เบอร์โทร" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask=""/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ความสัมพันธ์ : </label>
                                <div class="col-sm-8">
                                  <select name="relationSP" class="form-control">
                                    <option value="" selected>--- ความสัมพันธ์ ---</option>
                                    <option value="พี่น้อง">พี่น้อง</option>
                                    <option value="ญาติ">ญาติ</option>
                                    <option value="เพื่อน">เพื่อน</option>
                                    <option value="บิดา">บิดา</option>
                                    <option value="มารดา">มารดา</option>
                                    <option value="ตำบลเดี่ยวกัน">ตำบลเดี่ยวกัน</option>
                                    <option value="จ้างค้ำ(ไม่รู้จักกัน)">จ้างค้ำ(ไม่รู้จักกัน)</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขบัตรปชช.ผู้ค่ำ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="idcardSP" class="form-control" placeholder="เลขบัตรประชาชนผู้ค่ำ" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">คู่สมรส : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="mateSP" class="form-control" placeholder="คู่สมรส" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ที่อยู่ : </label>
                                <div class="col-sm-8">
                                  <select name="addSP" class="form-control">
                                    <option value="" selected>--- ที่อยู่ ---</option>
                                    <option value="ตามทะเบียนบ้าน">ตามทะเบียนบ้าน</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ที่อยู่ปัจจุบัน/จัดส่งเอกสาร : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="addnowSP" class="form-control" placeholder="ที่อยู่ปัจจุบัน/จัดส่งเอกสาร" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">รายละเอียดที่อยู่ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="statusaddSP" class="form-control" placeholder="รายละเอียดที่อยู่" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">สถานที่ทำงาน : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="workplaceSP" class="form-control" placeholder="สถานที่ทำงาน" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ลักษณะบ้าน : </label>
                                <div class="col-sm-8">
                                  <select name="houseSP" class="form-control">
                                    <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                    <option value="บ้านตึก 1 ชั้น">บ้านตึก 1 ชั้น</option>
                                    <option value="บ้านตึก 2 ชั้น">บ้านตึก 2 ชั้น</option>
                                    <option value="บ้านไม้ 1 ชั้น">บ้านไม้ 1 ชั้น</option>
                                    <option value="บ้านไม้ 2 ชั้น">บ้านไม้ 2 ชั้น</option>
                                    <option value="บ้านเดี่ยว">บ้านเดี่ยว</option>
                                    <option value="แฟลต">แฟลต</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประเภทหลักทรัพย์ : </label>
                                <div class="col-sm-8">
                                  <select name="securitiesSP" class="form-control">
                                    <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                    <option value="โฉนด">โฉนด</option>
                                    <option value="นส.3">นส.3</option>
                                    <option value="นส.3 ก">นส.3 ก</option>
                                    <option value="นส.4">นส.4</option>
                                    <option value="นส.4 จ">นส.4 จ</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขที่โฉนด : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="deednumberSP" class="form-control" placeholder="เลขที่โฉนด" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เนื้อที่ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="areaSP" class="form-control" placeholder="เนื้อที่" data-inputmask="&quot;mask&quot;:&quot;99-9-99&quot;" data-mask=""/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประเภทบ้าน : </label>
                                <div class="col-sm-8">
                                  <select name="housestyleSP" class="form-control">
                                    <option value="" selected>--- ประเภทบ้าน ---</option>
                                    <option value="ของตนเอง">ของตนเอง</option>
                                    <option value="อาศัยบิดา">อาศัยบิดา-มารดา</option>
                                    <option value="อาศัยผู้อื่น">อาศัยผู้อื่น</option>
                                    <option value="บ้านพักราชการ">บ้านพักราชการ</option>
                                    <option value="บ้านเช่า">บ้านเช่า</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">อาชีพ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="careerSP" class="form-control" placeholder="อาชีพ"/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">รายได้ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="incomeSP" class="form-control" placeholder="รายได้"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประวัติซื้อ/ค้ำ  : </label>
                                <div class="col-sm-4">
                                  <select name="puchaseSP" class="form-control">
                                    <option value="" selected>--- ซื้อ ---</option>
                                    <option value="0 คัน">0 คัน</option>
                                    <option value="1 คัน">1 คัน</option>
                                    <option value="2 คัน">2 คัน</option>
                                    <option value="3 คัน">3 คัน</option>
                                    <option value="4 คัน">4 คัน</option>
                                    <option value="5 คัน">5 คัน</option>
                                    <option value="6 คัน">6 คัน</option>
                                    <option value="7 คัน">7 คัน</option>
                                    <option value="8 คัน">8 คัน</option>
                                    <option value="9 คัน">9 คัน</option>
                                    <option value="10 คัน">10 คัน</option>
                                    <option value="11 คัน">11 คัน</option>
                                    <option value="12 คัน">12 คัน</option>
                                    <option value="13 คัน">13 คัน</option>
                                    <option value="14 คัน">14 คัน</option>
                                    <option value="15 คัน">15 คัน</option>
                                    <option value="16 คัน">16 คัน</option>
                                    <option value="17 คัน">17 คัน</option>
                                    <option value="18 คัน">18 คัน</option>
                                    <option value="19 คัน">19 คัน</option>
                                    <option value="20 คัน">20 คัน</option>
                                  </select>
                                </div>
                                <div class="col-sm-4">
                                  <select name="supportSP" class="form-control">
                                    <option value="" selected>--- ค้ำ ---</option>
                                    <option value="0 คัน">0 คัน</option>
                                    <option value="1 คัน">1 คัน</option>
                                    <option value="2 คัน">2 คัน</option>
                                    <option value="3 คัน">3 คัน</option>
                                    <option value="4 คัน">4 คัน</option>
                                    <option value="5 คัน">5 คัน</option>
                                    <option value="6 คัน">6 คัน</option>
                                    <option value="7 คัน">7 คัน</option>
                                    <option value="8 คัน">8 คัน</option>
                                    <option value="9 คัน">9 คัน</option>
                                    <option value="10 คัน">10 คัน</option>
                                    <option value="11 คัน">11 คัน</option>
                                    <option value="12 คัน">12 คัน</option>
                                    <option value="13 คัน">13 คัน</option>
                                    <option value="14 คัน">14 คัน</option>
                                    <option value="15 คัน">15 คัน</option>
                                    <option value="16 คัน">16 คัน</option>
                                    <option value="17 คัน">17 คัน</option>
                                    <option value="18 คัน">18 คัน</option>
                                    <option value="19 คัน">19 คัน</option>
                                    <option value="20 คัน">20 คัน</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="Sub-tab3" role="tabpanel" aria-labelledby="Sub-custom-tab3">
                          <h5 class="text-center"><b>แบบฟอร์มรายละเอียดรถยนต์</b></h5>
                          <p></p>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ยี่ห้อ : </label>
                                <div class="col-sm-8">
                                  <select name="Brandcar" class="form-control">
                                    <option value="" selected>--- ยี่ห้อ ---</option>
                                    <option value="ISUZU">ISUZU</option>
                                    <option value="MITSUBISHI">MITSUBISHI</option>
                                    <option value="TOYOTA">TOYOTA</option>
                                    <option value="MAZDA">MAZDA</option>
                                    <option value="FORD">FORD</option>
                                    <option value="NISSAN">NISSAN</option>
                                    <option value="HONDA">HONDA</option>
                                    <option value="CHEVROLET">CHEVROLET</option>
                                    <option value="MG">MG</option>
                                    <option value="SUZUKI">SUZUKI</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประเภทรถ : </label>
                                <div class="col-sm-8">
                                  <select id="Typecardetail" name="Typecardetail" class="form-control" onchange="calculate();">
                                    <option value="" selected>--- ประเภทรถ ---</option>
                                    <option value="รถกระบะ">รถกระบะ</option>
                                    <option value="รถตอนเดียว">รถตอนเดียว</option>
                                    <option value="รถเก๋ง/7ที่นั่ง">รถเก๋ง/7ที่นั่ง</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">สี : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Colourcar" class="form-control" placeholder="สี" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ปี : </label>
                                <div class="col-sm-8">
                                  <select id="Yearcar" name="Yearcar" class="form-control" onchange="calculate();">
                                    <option value="" selected>--- เลือกปี ---</option>
                                      @php
                                          $Year = date('Y');
                                      @endphp
                                      @for ($i = 0; $i < 20; $i++)
                                        <option value="{{ $Year }}">{{ $Year }}</option>
                                        @php
                                            $Year -= 1;
                                        @endphp
                                      @endfor
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ป้ายเดิม : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Licensecar" class="form-control" placeholder="ป้ายเดิม" required/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">กลุ่มปีรถยนต์ : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Groupyearcar" name="Groupyearcar" class="form-control" placeholder="กลุ่มปีรถยนต์" onchange="calculate();"/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ป้ายใหม่ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Nowlicensecar" class="form-control" placeholder="ป้ายใหม่" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขไมล์ : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Milecar" name="Milecar" class="form-control" placeholder="เลขไมล์" oninput="mile();" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">รุ่น : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Modelcar" class="form-control" placeholder="รุ่น" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ราคากลาง : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Midpricecar" name="Midpricecar" class="form-control" maxlength="9" placeholder="ราคากลาง" oninput="mile();percent();" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <hr />
                          @include('analysis.script')

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เงินต้น : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Topcar" name="Topcar" class="form-control" maxlength="9" placeholder="ป้อนเงินต้น" oninput="calculate2()" />
                                  <input type="hidden" id="Topcarfee" name="Topcarfee" class="form-control" placeholder="ป้อนยอดจัด" oninput="calculate2()" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เงินต้น+ค่าดำเนินการ : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Totalfee" name="Totalfee" class="form-control" placeholder="-" readonly/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ค่าดำเนินการ : </label>
                                <div class="col-sm-7">
                                  <input type="text" id="Processfee" name="Processfee" class="form-control" placeholder="ป้อนค่าดำเนินการ" oninput="calculate2()"/>
                                </div>
                                <label class="col-sm-1 col-form-label text-left">% </label>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ชำระต่องวด : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Paycar" name="Paycar" class="form-control" placeholder="-" readonly/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ดอกเบี้ย/ปี : </label>
                                <div class="col-sm-7">
                                  <input type="text" id="Interestcar" name="Interestcar" class="form-control" placeholder="ป้อนดอกเบี้ย" oninput="calculate2();"/>
                                </div>
                                <label class="col-sm-1 col-form-label text-left">% </label>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ยอดรวมทั้งสัญญา : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Totalpay1car" name="Totalpay1car" class="form-control" placeholder="-" readonly />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ระยะเวลาผ่อน : </label>
                                <div class="col-sm-8">
                                  <select id="Timeslackencar" name="Timeslackencar" class="form-control" oninput="calculate();calculate2();">
                                    <option value="" selected>--- ระยะเวลาผ่อน ---</option>
                                    <option value="12">12</option>
                                    <option value="18">18</option>
                                    <option value="24">24</option>
                                    <option value="30">30</option>
                                    <option value="36">36</option>
                                    <option value="42">42</option>
                                    <option value="48">48</option>
                                    <option value="54">54</option>
                                    <option value="60">60</option>
                                    <option value="66">66</option>
                                    <option value="72">72</option>
                                    {{-- <option value="78">78</option>
                                    <option value="84">84</option> --}}
                                  </select>
                                </div>
                              </div>
                            </div>
                            <!-- <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ยอดผ่อนชำระทั้งหมด : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Totalpay1car" name="Totalpay1car" class="form-control" readonly />
                                </div>
                              </div>
                            </div> -->
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประกันภัย : </label>
                                <div class="col-sm-8">
                                  <select id="Insurancecar" name="Insurancecar" class="form-control" onchange="calculate();">
                                    <option value="" selected>--- ประกันภัย ---</option>
                                    <option value="แถม ป2+ 1ปี">แถม ป2+ 1ปี</option>
                                    <option value="มี ป2+ อยู่แล้ว">มี ป2+ อยู่แล้ว</option>
                                    <option value="ไม่แถม">ไม่แถม</option>
                                    <option value="ไม่ซื้อ">ไม่ซื้อ</option>
                                    <option value="ซื้อ ป2+ 1ปี">ซื้อ ป2+ 1ปี</option>
                                    <option value="ซื้อ ป1 1ปี">ซื้อ ป1 1ปี</option>
                                    <option value="มี ป1 อยู่แล้ว">มี ป1 อยู่แล้ว</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เปอร์เซ็นจัดไฟแนนซ์ : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Percentcar" name="Percentcar" class="form-control int" placeholder="เปอร์เซ็นจัดไฟแนนซ์" readonly />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">แบบ : </label>
                                <div class="col-sm-8">
                                  <select id="statuscar" name="statuscar" class="form-control">
                                    <option value="" selected>--- เลือกแบบ ---</option>
                                    <option value="กส.ค้ำมีหลักทรัพย์">กส.ค้ำมีหลักทรัพย์</option>
                                    <option value="กส.ค้ำไม่มีหลักทรัพย์">กส.ค้ำไม่มีหลักทรัพย์</option>
                                    <option value="กส.ไม่ค้ำประกัน">กส.ไม่ค้ำประกัน</option>
                                    <option value="ซข.ค้ำมีหลักทรัพย์">ซข.ค้ำมีหลักทรัพย์</option>
                                    <option value="ซข.ค้ำไม่มีหลักทรัพย์">ซข.ค้ำไม่มีหลักทรัพย์</option>
                                    <option value="ซข.ไม่ค้ำประกัน">ซข.ไม่ค้ำประกัน</option>
                                    <option value="VIP.กรรมสิทธิ์">VIP (กรรมสิทธิ์)</option>
                                    <option value="VIP.ซื้อขาย">VIP (ซื้อขาย)</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">วันที่ชำระงวดแรก : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Dateduefirstcar" class="form-control" readonly placeholder="วันที่ชำระงวดแรก" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <hr />
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ผู้รับเงิน : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Payeecar" class="form-control" placeholder="ผู้รับเงิน" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขที่บัญชี : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Accountbrancecar" class="form-control" placeholder="เลขที่บัญชีผู้รับเงิน" maxlength="15" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">สาขา : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="branchbrancecar" class="form-control" placeholder="สาขาผู้รับเงิน" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เบอร์โทรศัพท์ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Tellbrancecar" class="form-control" placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask="" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right"><font color="red">(* กรณีเป็นพนักงาน) </font>แนะนำ/นายหน้า : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Agentcar" name="Agentcar" class="form-control" placeholder="แนะนำ/นายหน้า" oninput="commission();"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขที่บัญชี : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Accountagentcar" class="form-control" placeholder="เลขที่บัญชีนายหน้า" maxlength="15" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1" id="ShowCom" style="display:none;">
                                <label class="col-sm-3 col-form-label text-right">ค่าคอม : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Commissioncar" name="Commissioncar" class="form-control" placeholder="ค่าคอม" oninput="commission();"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">สาขา : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="branchAgentcar" class="form-control" placeholder="สาขานายหน้า" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <script>
                            $('#Agentcar').change(function(){
                              var value = document.getElementById('Agentcar').value;
                                if(value == ''){
                                  $('#ShowCom').hide();
                                }
                                else{
                                  $('#ShowCom').show();
                                }
                            });
                          </script>

                          <!-- สคริปคิดค่าคอม -->
                          <script>
                            $('#statuscar').change(function(){
                              var value = document.getElementById('statuscar').value;
                              var Year = document.getElementById('Yearcar').value;
                              var Timelack = document.getElementById('Timeslackencar').value;
                              var Settopcar = document.getElementById('Topcar').value;
                              var Topcar = Settopcar.replace(",","");
                              var SetP2Price = document.getElementById('P2Price').value;
                              var P2Price = SetP2Price.replace(",","");

                                if(value == 'กส.ค้ำมีหลักทรัพย์' || value == 'กส.ค้ำไม่มีหลักทรัพย์' || value == 'กส.ไม่ค้ำประกัน' || value == 'VIP.กรรมสิทธิ์'){
                                  var Comprice = addCommas((parseInt(Topcar) - parseInt(P2Price)) * 0.02);
                                  $('#Commissioncar').val(Comprice);
                                }
                                else{
                                  if(Year <= 2008){
                                    if(Timelack < 48){
                                      var tempValue = (5 * parseInt(Timelack)/12) * 0.01;
                                      var SetComprice = (parseInt(Topcar) - parseInt(P2Price)) * tempValue * 0.07;
                                    }
                                    else{
                                      var tempValue = (5 * 4) * 0.01;
                                      var SetComprice = (parseInt(Topcar) - parseInt(P2Price)) * tempValue * 0.07;
                                    }
                                  }
                                  else{
                                    if(Timelack < 48){
                                      var tempValue = (6 * parseInt(Timelack)/12) * 0.01;
                                      var SetComprice = (parseInt(Topcar) - parseInt(P2Price)) * tempValue * 0.07;
                                    }
                                    else{
                                      var tempValue = (6 * 4) * 0.01;
                                      var SetComprice = (parseInt(Topcar) - parseInt(P2Price)) * tempValue * 0.07;
                                    }
                                  }

                                    if(SetComprice < 1000){
                                      var ResultPrice = Math.floor(SetComprice);
                                    }else{
                                      var Comprice = Math.floor(SetComprice/100);
                                      var ResultPrice = Comprice*100;
                                    }
                                    $('#Commissioncar').val(addCommas(ResultPrice.toFixed(0))); 
                                
                                }
                            });
                          </script>                          

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประวัติการซื้อ/ค้ำ : </label>
                                <div class="col-sm-4">
                                  <select name="Purchasehistorycar" class="form-control">
                                    <option value="" selected>--- ซื้อ ---</option>
                                    <option value="0 คัน">0 คัน</option>
                                    <option value="1 คัน">1 คัน</option>
                                    <option value="2 คัน">2 คัน</option>
                                    <option value="3 คัน">3 คัน</option>
                                    <option value="4 คัน">4 คัน</option>
                                    <option value="5 คัน">5 คัน</option>
                                    <option value="6 คัน">6 คัน</option>
                                    <option value="7 คัน">7 คัน</option>
                                    <option value="8 คัน">8 คัน</option>
                                    <option value="9 คัน">9 คัน</option>
                                    <option value="10 คัน">10 คัน</option>
                                    <option value="11 คัน">11 คัน</option>
                                    <option value="12 คัน">12 คัน</option>
                                    <option value="13 คัน">13 คัน</option>
                                    <option value="14 คัน">14 คัน</option>
                                    <option value="15 คัน">15 คัน</option>
                                    <option value="16 คัน">16 คัน</option>
                                    <option value="17 คัน">17 คัน</option>
                                    <option value="18 คัน">18 คัน</option>
                                    <option value="19 คัน">19 คัน</option>
                                    <option value="20 คัน">20 คัน</option>
                                  </select>
                                </div>
                                <div class="col-sm-4">
                                  <select name="Supporthistorycar" class="form-control">
                                    <option value="" selected>--- ค้ำ ---</option>
                                    <option value="0 คัน">0 คัน</option>
                                    <option value="1 คัน">1 คัน</option>
                                    <option value="2 คัน">2 คัน</option>
                                    <option value="3 คัน">3 คัน</option>
                                    <option value="4 คัน">4 คัน</option>
                                    <option value="5 คัน">5 คัน</option>
                                    <option value="6 คัน">6 คัน</option>
                                    <option value="7 คัน">7 คัน</option>
                                    <option value="8 คัน">8 คัน</option>
                                    <option value="9 คัน">9 คัน</option>
                                    <option value="10 คัน">10 คัน</option>
                                    <option value="11 คัน">11 คัน</option>
                                    <option value="12 คัน">12 คัน</option>
                                    <option value="13 คัน">13 คัน</option>
                                    <option value="14 คัน">14 คัน</option>
                                    <option value="15 คัน">15 คัน</option>
                                    <option value="16 คัน">16 คัน</option>
                                    <option value="17 คัน">17 คัน</option>
                                    <option value="18 คัน">18 คัน</option>
                                    <option value="19 คัน">19 คัน</option>
                                    <option value="20 คัน">20 คัน</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เบอร์โทรศัพท์ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Tellagentcar" class="form-control" placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask="" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">หมายเหตุ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Notecar" class="form-control" placeholder="หมายเหตุ"/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <hr>
                          <div class="row">
                            <div class="col-md-12">
                              <h5 class="text-center"><font color="red"><b>รูปภาพหน้าบัญชี</b></font></h5>
                              <div class="form-group">
                                <div class="file-loading">
                                  <input id="Account_image" type="file" name="Account_image" accept="image/*" data-min-file-count="1" multiple>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-5">
                              <div class="float-right form-inline">
                                <!-- <label><font color="red">เจ้าหน้าที่สินเชื่อ : </font></label> -->
                                <input type="hidden" name="Loanofficercar" class="form-control" value="{{ Auth::user()->name }}" readonly />
                              </div>
                            </div>
                            <div class="col-5">
                              <div class="float-right form-inline">
                                <!-- <label><font color="red">สาขา : </font></label> -->
                                {{-- @if(Auth::user()->branch == 99)
                                    <input type="hidden" name="branchcar" class="form-control" value="Admin" readonly />
                                @elseif(Auth::user()->branch == 01)
                                    <input type="hidden" name="branchcar" class="form-control" value="ปัตตานี" readonly />
                                @elseif(Auth::user()->branch == 03)
                                    <input type="hidden" name="branchcar" class="form-control" value="ยะลา" readonly />
                                @elseif(Auth::user()->branch == 04)
                                    <input type="hidden" name="branchcar" class="form-control" value="นราธิวาส" readonly />
                                @elseif(Auth::user()->branch == 05)
                                    <input type="hidden" name="branchcar" class="form-control" value="สายบุรี" readonly />
                                @elseif(Auth::user()->branch == 06)
                                    <input type="hidden" name="branchcar" class="form-control" value="โกลก" readonly />
                                @elseif(Auth::user()->branch == 07)
                                    <input type="hidden" name="branchcar" class="form-control" value="เบตง" readonly />
                                @endif --}}
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="Sub-tab4" role="tabpanel" aria-labelledby="Sub-custom-tab4">
                          <h5 class="text-center"><b>แบบฟอร์มรายละเอียดค่าใช้จ่าย</b></h5>
                          <p></p>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">พรบ. : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="actPrice" name="actPrice" class="form-control" value="0" placeholder="พรบ." oninput="balance()"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ซื้อ ป2+/ป1 : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="P2Price" name="P2Price" class="form-control" value="0" placeholder="ซื้อ ป2+" oninput="balance();"/>
                                  <input type="hidden" id="P2PriceOri" name="P2PriceOri" class="form-control" value="0" placeholder="ซื้อ ป2+" onchange="calculate();balance();"/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ยอดปิดบัญชี : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="closeAccountPrice" name="closeAccountPrice" class="form-control" value="0" placeholder="ยอดปิดบัญชี" oninput="balance()"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ค่าดำเนินการ : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="totalkPrice" name="totalkPrice" class="form-control" placeholder="รวม คชจ." onchange="balance();" readonly/>
                                  <input type="hidden" id="temptotalkPrice" name="temptotalkPrice" class="form-control" placeholder="รวม คชจ." onchange="balance();"/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- สคริปค่าประเมิณ -->
                          <script>
                            $('#Topcar').change(function(){
                              var Settopcar = document.getElementById('Topcar').value;
                              var Topcar = Settopcar.replace(",","");
                              if(Topcar <= 50000){
                                var evaluetion = 1000;
                              }else if(Topcar > 50000 && Topcar <= 100000){
                                var evaluetion = 1500;
                              }else if(Topcar > 100000 && Topcar <= 250000){
                                var evaluetion = 2000;
                              }else{
                                var evaluetion = 2500;
                              }
                              var totalPrice = parseFloat(evaluetion) + parseFloat(1500) + parseFloat(1500);
                              var balancePrice = parseFloat(Topcar) - parseFloat(totalPrice);
                              $("#evaluetionPrice").val(addCommas(evaluetion));
                              $("#totalkPrice").val(addCommas(totalPrice));
                              $("#balancePrice").val(addCommas(balancePrice));

                            });
                          </script> 

                          <script>
                            $('#Gradebuyer').change(function(){
                              var value = document.getElementById('Gradebuyer').value;
                              if(value == 'ปิดจัดใหม่(งานตาม)' || value == 'ปิดจัดใหม่(ผ่อนดี)'){
                                $('#Commissioncar').attr('readonly', true);
                              }else{
                                $('#Commissioncar').attr('readonly', false);
                              }

                            });
                          </script>

                          <hr>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">คงเหลือ : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="balancePrice" name="balancePrice" class="form-control" placeholder="คงเหลือ" readonly/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ค่าคอมหลังหัก 1.5%  : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="commitPrice" name="commitPrice" class="form-control" placeholder="ค่าคอมหลังหัก" readonly/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">หมายเหตุ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="notePrice" class="form-control" placeholder="หมายเหตุ"/>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="Sub-tab5" role="tabpanel" aria-labelledby="Sub-custom-tab5">
                          <h5 class="text-center">ข้อมูลลงพื้นที ตรวจสอบ</h5>
                          <p></p>

                          <div class="row">
                            <div class="col-md-4">
                              <div class="col-md-12">
                                <div class="card card-danger">
                                  <div class="card-header">
                                    <h3 class="card-title">รูปภาพผู้เช่าซื้อ</h3>
                    
                                    <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    <div class="form-group">
                                      <div class="file-loading">
                                        <input id="image_checker_1" type="file" name="image_checker_1[]" accept="image/*" data-min-file-count="1" multiple>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="card card-danger">
                                  <div class="card-header">
                                    <h3 class="card-title">หมายเหตุผู้เช่าซื้อ</h3>
                    
                                    <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                                    </div>
                                  </div>
                                    <textarea class="form-control" name="BuyerNote" rows="3" placeholder="ป้อนหมายเหตุ..."></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="col-md-12">
                                <div class="card card-danger">
                                  <div class="card-header">
                                    <h3 class="card-title">รูปภาพผู้ค้ำ</h3>
                    
                                    <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    <div class="form-group">
                                      <div class="file-loading">
                                        <input id="image_checker_2" type="file" name="image_checker_2[]" accept="image/*" data-min-file-count="1" multiple>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="card card-danger">
                                  <div class="card-header">
                                    <h3 class="card-title">หมายเหตุผู้ค้ำ</h3>
                    
                                    <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                                    </div>
                                  </div>
                                    <textarea class="form-control" name="SupportNote" rows="3" placeholder="ป้อนหมายเหตุ..."></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="card card-danger">
                                <div class="card-header">
                                  <h3 class="card-title">แผนที่</h3>
                                  <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-12">
                                        <div id="myLat">
                                            <div class="form-inline float-left">
                                              <label>ตำแหน่งผู้เช่าซื้อ : </label>
                                            </div>
                                              <input type="text" id="Buyer_latlong" name="Buyer_latlong" class="form-control" placeholder="ป้อนตำแหน่งผู้เช่าซื้อ"/>
                                              <br>
                                            <div class="form-inline float-left">
                                              <label>ตำแหน่งผู้ค้ำ : </label> 
                                            </div>
                                              <input type="text" id="Support_latlong" name="Support_latlong" class="form-control" placeholder="ป้อนตำแหน่งผู้ค้ำ"/>
                                        </div>
                                      </div>
                                      <hr>
                                      <div id="map" style="width:1%;height:1vh"></div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    

                    <input type="hidden" name="patch_type" value="1">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />

                    <!-- แบบฟอร์มผู้ค้ำ 2 -->
                    <div class="modal fade" id="modal-default">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="card card-warning">
                              <div class="card-header">
                                <h4 class="card-title"><b>รายละเอียดผู้ค้ำที่ 2</b></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                                </button>
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ชื่อ : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="nameSP2" class="form-control" placeholder="ชื่อ" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">นามสกุล : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="lnameSP2" class="form-control" placeholder="นามสกุล" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ชื่อเล่น : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="niknameSP2" class="form-control" placeholder="ชื่อเล่น" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">สถานะ : </label>
                                    <div class="col-sm-8">
                                      <select name="statusSP2" class="form-control">
                                        <option value="" selected>--- สถานะ ---</option>
                                        <option value="โสด">โสด</option>
                                        <option value="สมรส">สมรส</option>
                                        <option value="หย่าร้าง">หย่าร้าง</option>
                                        <option value="เสียชีวิต">เสียชีวิต</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">เบอร์โทร : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="telSP2" class="form-control" placeholder="เบอร์โทร" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask=""/>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ความสัมพันธ์ : </label>
                                    <div class="col-sm-8">
                                      <select name="relationSP2" class="form-control">
                                        <option value="" selected>--- ความสัมพันธ์ ---</option>
                                        <option value="พี่น้อง">พี่น้อง</option>
                                        <option value="ญาติ">ญาติ</option>
                                        <option value="เพื่อน">เพื่อน</option>
                                        <option value="บิดา">บิดา</option>
                                        <option value="มารดา">มารดา</option>
                                        <option value="ตำบลเดี่ยวกัน">ตำบลเดี่ยวกัน</option>
                                        <option value="จ้างค้ำ(ไม่รู้จักกัน)">จ้างค้ำ(ไม่รู้จักกัน)</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">คู่สมรส : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="mateSP2" class="form-control" placeholder="คู่สมรส" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">เลขบัตรประชาชน : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="idcardSP2" class="form-control" placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ที่อยู่ : </label>
                                    <div class="col-sm-8">
                                      <select name="addSP2" class="form-control">
                                        <option value="" selected>--- ที่อยู่ ---</option>
                                        <option value="ตามทะเบียนบ้าน">ตามทะเบียนบ้าน</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ที่อยู่ปัจจุบัน/จัดส่งเอกสาร : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="addnowSP2" class="form-control" placeholder="ที่อยู่ปัจจุบัน/จัดส่งเอกสาร" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">รายละเอียดที่อยู่ : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="statusaddSP2" class="form-control" placeholder="รายละเอียดที่อยู่" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">สถานที่ทำงาน : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="workplaceSP2" class="form-control" placeholder="สถานที่ทำงาน" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ลักษณะบ้าน : </label>
                                    <div class="col-sm-8">
                                      <select name="houseSP2" class="form-control">
                                        <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                        <option value="บ้านตึก 1 ชั้น">บ้านตึก 1 ชั้น</option>
                                        <option value="บ้านตึก 2 ชั้น">บ้านตึก 2 ชั้น</option>
                                        <option value="บ้านไม้ 1 ชั้น">บ้านไม้ 1 ชั้น</option>
                                        <option value="บ้านไม้ 2 ชั้น">บ้านไม้ 2 ชั้น</option>
                                        <option value="บ้านเดี่ยว">บ้านเดี่ยว</option>
                                        <option value="แฟลต">แฟลต</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ประเภทหลักทรัพย์ : </label>
                                    <div class="col-sm-8">
                                      <select name="securitiesSP2" class="form-control">
                                        <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                        <option value="โฉนด">โฉนด</option>
                                        <option value="นส.3">นส.3</option>
                                        <option value="นส.3 ก">นส.3 ก</option>
                                        <option value="นส.4">นส.4</option>
                                        <option value="นส.4 จ">นส.4 จ</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">เลขที่โฉนด : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="deednumberSP2" class="form-control" placeholder="เลขที่โฉนด" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">เนื้อที่ : </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="areaSP2" class="form-control" placeholder="เนื้อที่" data-inputmask="&quot;mask&quot;:&quot;99-9-99&quot;" data-mask=""/>
                                    </div>
                                  </div>
                                </div>
                              </div> 
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ประเภทบ้าน : </label>
                                    <div class="col-sm-8">
                                      <select name="housestyleSP2" class="form-control">
                                        <option value="" selected>--- ประเภทบ้าน ---</option>
                                        <option value="ของตนเอง">ของตนเอง</option>
                                        <option value="อาศัยบิดา">อาศัยบิดา-มารดา</option>
                                        <option value="อาศัยผู้อื่น">อาศัยผู้อื่น</option>
                                        <option value="บ้านพักราชการ">บ้านพักราชการ</option>
                                        <option value="บ้านเช่า">บ้านเช่า</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">อาชีพ : </label>
                                    <div class="col-sm-8">
                                      <select name="careerSP2" class="form-control">
                                        <option value="" selected>--- อาชีพ ---</option>
                                        <option value="ตำรวจ">ตำรวจ</option>
                                        <option value="ทหาร">ทหาร</option>
                                        <option value="ครู">ครู</option>
                                        <option value="ข้าราชการอื่น">ข้าราชการอื่น</option>
                                        <option value="ลูกจ้างเทศบาล">ลูกจ้างเทศบาล</option>
                                        <option value="ลูกจ้างประจำ">ลูกจ้างประจำ</option>
                                        <option value="สมาชิก อบต.">สมาชิก อบต.</option>
                                        <option value="ลูกจ้างชั่วคราว">ลูกจ้างชั่วคราว</option>
                                        <option value="รับจ้าง">รับจ้าง</option>
                                        <option value="พนักงานบริษัทเอกชน">พนักงานบริษัทเอกชน</option>
                                        <option value="อาชีพอิสระ">อาชีพอิสระ</option>
                                        <option value="กำนัน">กำนัน</option>
                                        <option value="ผู้ใหญ่บ้าน">ผู้ใหญ่บ้าน</option>
                                        <option value="ผู้ช่วยผู้ใหญ่บ้าน">ผู้ช่วยผู้ใหญ่บ้าน</option>
                                        <option value="นักการภารโรง">นักการภารโรง</option>
                                        <option value="มอเตอร์ไซร์รับจ้าง">มอเตอร์ไซร์รับจ้าง</option>
                                        <option value="ค้าขาย">ค้าขาย</option>
                                        <option value="เจ้าของธุรกิจ">เจ้าของธุรกิจ</option>
                                        <option value="เจ้าของอู่รถ">เจ้าของอู่รถ</option>
                                        <option value="ให้เช่ารถบรรทุก">ให้เช่ารถบรรทุก</option>
                                        <option value="ช่างตัดผม">ช่างตัดผม</option>
                                        <option value="ชาวนา">ชาวนา</option>
                                        <option value="ชาวไร่">ชาวไร่</option>
                                        <option value="ชาวสวนยาง">ชาวสวนยาง</option>
                                        <option value="แม่บ้าน">แม่บ้าน</option>
                                        <option value="รับเหมาก่อสร้าง">รับเหมาก่อสร้าง</option>
                                        <option value="ประมง">ประมง</option>
                                        <option value="ทนายความ">ทนายความ</option>
                                        <option value="พระ">พระ</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">รายได้ : </label>
                                    <div class="col-sm-8">
                                      <select name="incomeSP2" class="form-control">
                                        <option value="" selected>--- รายได้ ---</option>
                                        <option value="5,000 - 10,000">5,000 - 10,000</option>
                                        <option value="10,000 - 15,000">10,000 - 15,000</option>
                                        <option value="15,000 - 20,000">15,000 - 20,000</option>
                                        <option value="มากกว่า 20,000">มากกว่า 20,000</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ประวัติซื้อ : </label>
                                    <div class="col-sm-4">
                                      <select name="puchaseSP2" class="form-control">
                                        <option value="" selected>-ซื้อ-</option>
                                        <option value="0 คัน">0 คัน</option>
                                        <option value="1 คัน">1 คัน</option>
                                        <option value="2 คัน">2 คัน</option>
                                        <option value="3 คัน">3 คัน</option>
                                        <option value="4 คัน">4 คัน</option>
                                        <option value="5 คัน">5 คัน</option>
                                        <option value="6 คัน">6 คัน</option>
                                        <option value="7 คัน">7 คัน</option>
                                        <option value="8 คัน">8 คัน</option>
                                        <option value="9 คัน">9 คัน</option>
                                        <option value="10 คัน">10 คัน</option>
                                        <option value="11 คัน">11 คัน</option>
                                        <option value="12 คัน">12 คัน</option>
                                        <option value="13 คัน">13 คัน</option>
                                        <option value="14 คัน">14 คัน</option>
                                        <option value="15 คัน">15 คัน</option>
                                        <option value="16 คัน">16 คัน</option>
                                        <option value="17 คัน">17 คัน</option>
                                        <option value="18 คัน">18 คัน</option>
                                        <option value="19 คัน">19 คัน</option>
                                        <option value="20 คัน">20 คัน</option>
                                      </select>
                                    </div>
                                    <div class="col-sm-4">
                                      <select name="supportSP2" class="form-control">
                                        <option value="" selected>-ค้ำ-</option>
                                        <option value="0 คัน">0 คัน</option>
                                        <option value="1 คัน">1 คัน</option>
                                        <option value="2 คัน">2 คัน</option>
                                        <option value="3 คัน">3 คัน</option>
                                        <option value="4 คัน">4 คัน</option>
                                        <option value="5 คัน">5 คัน</option>
                                        <option value="6 คัน">6 คัน</option>
                                        <option value="7 คัน">7 คัน</option>
                                        <option value="8 คัน">8 คัน</option>
                                        <option value="9 คัน">9 คัน</option>
                                        <option value="10 คัน">10 คัน</option>
                                        <option value="11 คัน">11 คัน</option>
                                        <option value="12 คัน">12 คัน</option>
                                        <option value="13 คัน">13 คัน</option>
                                        <option value="14 คัน">14 คัน</option>
                                        <option value="15 คัน">15 คัน</option>
                                        <option value="16 คัน">16 คัน</option>
                                        <option value="17 คัน">17 คัน</option>
                                        <option value="18 คัน">18 คัน</option>
                                        <option value="19 คัน">19 คัน</option>
                                        <option value="20 คัน">20 คัน</option>
                                    </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between float-right">
                              <button type="button" class="btn btn-success" data-dismiss="modal">บันทึก</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>

        <a id="button"></a>
      </section>
    </div>
  </section>


  <script>
    var map, infoWindow;
    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 13
      });
      infoWindow = new google.maps.InfoWindow;

      // Try HTML5 geolocation.
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };

            var getlat=position.coords.latitude;
            var getlng=position.coords.longitude;
            var CurLocation = Number(getlat) + ',' + Number(getlng);

            // document.getElementById("Buyer_latitude").value = getlat;
            // document.getElementById("Buyer_longitude").value = getlng;
            document.getElementById("Buyer_latlong").value = CurLocation;

          infoWindow.setPosition(pos);
          infoWindow.setContent('ตำแหน่งปัจจบัน');infoWindow.open(map);
          // infoWindow.setContent('สถานที่. lat: ' + position.coords.latitude + ', lng: ' + position.coords.longitude + ' ');infoWindow.open(map);
          map.setCenter(pos);
        }, function() {
          handleLocationError(true, infoWindow, map.getCenter());
        });
      }
    }
  </script>

  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHvHdio8MNE9aqZZmfvd49zHgLbixudMs&callback=initMap&language=th">
  </script>

  {{-- button-to-top --}}
  <script>
    var btn = $('#button');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });
  </script>

  {{-- image --}}
  <script type="text/javascript">
    $("#Account_image,#image-file,#image_checker_1,#image_checker_2").fileinput({
      uploadUrl:"{{ route('MasterAnalysis.store') }}",
      theme:'fa',
      uploadExtraData:function(){
        return{
          _token:"{{csrf_token()}}",
        }
      },
      allowedFileExtensions:['jpg','png','gif'],
      maxFileSize:10240
    })
  </script>

  <script>
    $(function () {
      $('[data-mask]').inputmask()
    })
  </script>

@endsection
