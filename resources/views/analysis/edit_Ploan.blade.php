@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
@section('content')

@php
  date_default_timezone_set('Asia/Bangkok');
  $Y = date('Y') + 543;
  $Y2 = date('Y') + 531;
  $m = date('m');
  $d = date('d');
  $Currdate = date('2020-06-02');
  $time = date('H:i');
  $date = $Y.'-'.$m.'-'.$d;
  $date2 = $Y2.'-'.'01'.'-'.'01';
@endphp

  <link type="text/css" rel="stylesheet" href="{{ asset('css/magiczoomplus.css') }}"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

  <script type="text/javascript" src="{{ asset('js/magiczoomplus.js') }}"></script>
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
        <form name="form1" method="post" action="{{ action('AnalysController@update',[$id,$type]) }}" enctype="multipart/form-data">
          @csrf
          @method('put')

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-4">
                      <div class="form-inline">
                        @if($data->StatusApp_car != 'อนุมัติ')
                          <h5><i class="fas fa-biking pr-1"></i>แก้ไขสัญญา (Edit P04 Loan Agreement)</h5>
                        @else
                          <h5><i class="fas fa-biking pr-1"></i>รายละเอียดสัญญา (Details PLoan-Micro P04)</h5>
                        @endif
                      </div>
                    </div>
                    <div class="col-8">
                      <div class="card-tools d-inline float-right">
                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                          @if(auth::user()->type == "Admin")
                            <button type="submit" class="delete-modal btn btn-success btn-sm">
                              <i class="fas fa-save"></i> Update
                            </button>
                            <a class="delete-modal btn btn-danger btn-sm" href="{{ route('MasterAnalysis.index') }}?type={{3}}&Fromdate={{$fdate}}&Todate={{$tdate}}&status={{$status}}">
                              <i class="far fa-window-close"></i> Close
                            </a>
                          @elseif(auth::user()->type == "แผนก วิเคราะห์")
                            @if($data->StatusApp_car != 'อนุมัติ')
                              <button type="submit" class="delete-modal btn btn-success btn-sm">
                                <i class="fas fa-save"></i> Update
                              </button>
                              <a class="delete-modal btn btn-danger btn-sm" href="{{ route('MasterAnalysis.index') }}?type={{3}}&Fromdate={{$fdate}}&Todate={{$tdate}}&status={{$status}}">
                                <i class="far fa-window-close"></i> Close
                              </a>
                            @else
                              <a class="delete-modal btn btn-danger btn-sm" href="{{ route('MasterAnalysis.index') }}?type={{3}}&Fromdate={{$fdate}}&Todate={{$tdate}}&status={{$status}}">
                                <i class="fas fa-undo"></i> ย้อนกลับ
                              </a>
                            @endif
                          @endif
                        @else
                          @if($data->StatusApp_car != 'อนุมัติ')
                            <button type="submit" class="delete-modal btn btn-success btn-sm">
                              <i class="fas fa-save"></i> Update
                            </button>
                            <a class="delete-modal btn btn-danger btn-sm" href="{{ route('MasterAnalysis.index') }}?type={{3}}&Fromdate={{$fdate}}&Todate={{$tdate}}&status={{$status}}">
                              <i class="far fa-window-close"></i> Close
                            </a>
                          @else
                            <a class="delete-modal btn btn-danger btn-sm" href="{{ route('MasterAnalysis.index') }}?type={{3}}&Fromdate={{$fdate}}&Todate={{$tdate}}&status={{$status}}">
                              <i class="fas fa-undo"></i> Back
                            </a>
                          @endif
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body text-sm">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-3"></div>
                      <div class="col-sm-9">
                        <ol class="breadcrumb float-sm-right">
                          {{-- ผู้จัดการ --}}
                          <div class="float-right form-inline">
                            <i class="fas fa-grip-vertical"></i>
                            <span class="todo-wrap">
                              @if(auth::user()->type == "Admin" or auth::user()->position == "MANAGER")
                                @if ($data->ManagerApp_car != NULL)
                                  <input type="checkbox" class="checkbox" name="MANAGER" id="1" value="{{ $data->ManagerApp_car }}" {{ ($data->ManagerApp_car !== NULL) ? 'checked' : '' }}>
                                @else
                                  <input type="checkbox" class="checkbox" name="MANAGER" id="1" value="{{ auth::user()->name }}">
                                @endif
                              @else
                                <input type="checkbox" class="checkbox" id="1" {{ ($data->ManagerApp_car !== NULL) ? 'checked' : '' }} disabled>
                              @endif
                              <label for="1" class="todo">
                                <i class="fa fa-check"></i>
                                <font color="red">MANAGER &nbsp;&nbsp;</font>
                              </label>
                            </span> 
                            @if(auth::user()->type != "Admin" and auth::user()->position != "MANAGER")
                              @if($data->ManagerApp_car != NULL)
                                <input type="hidden" name="MANAGER" value="{{ $data->ManagerApp_car }}">
                              @endif
                            @endif  
                          </div>

                          {{-- audit --}}
                          <div class="float-right form-inline">
                            <i class="fas fa-grip-vertical"></i>
                            <span class="todo-wrap">
                              @if(auth::user()->type == "Admin" or auth::user()->position == "AUDIT" or auth::user()->position == "MANAGER")
                                @if ($data->Approvers_car != NULL)
                                  <input type="checkbox" id="2" name="AUDIT" value="{{ $data->Approvers_car }}" {{ ($data->Approvers_car !== NULL) ? 'checked' : '' }}/>
                                @else
                                  <input type="checkbox" id="2" name="AUDIT" value="{{ auth::user()->name }}"/>
                                @endif
                              @else
                                <input type="checkbox" class="checkbox" id="2" {{ ($data->Approvers_car !== NULL) ? 'checked' : '' }} disabled>
                              @endif
                                <label for="2" class="todo">
                                <i class="fa fa-check"></i>
                                <font color="red">AUDIT &nbsp;&nbsp;</font>
                              </label>
                            </span>
                            @if(auth::user()->type != "Admin" and auth::user()->position != "AUDIT")
                              @if($data->Approvers_car != NULL)
                                <input type="hidden" name="AUDIT" value="{{ $data->Approvers_car }}">
                              @endif
                            @endif
                          </div>

                          {{-- หัวหน้าสาขา --}}
                          <div class="float-right form-inline">
                            <i class="fas fa-grip-vertical"></i>
                            <span class="todo-wrap">
                              @if(auth::user()->type == "Admin" or auth::user()->position == "MASTER" or auth::user()->position == "AUDIT")
                                @if($data->Check_car != NULL)
                                  <input type="checkbox" class="checkbox" name="MASTER" id="3" value="{{ $data->Check_car }}" {{ ($data->Check_car !== NULL) ? 'checked' : '' }}>
                                @else
                                  <input type="checkbox" class="checkbox" name="MASTER" id="3" value="{{ auth::user()->name }}">
                                @endif
                              @else
                                <input type="checkbox" class="checkbox" id="3" {{ ($data->Check_car !== NULL) ? 'checked' : '' }} disabled>
                              @endif
                              <label for="3" class="todo">
                                <i class="fa fa-check"></i>
                                <font color="red">MASTER &nbsp;&nbsp;</font>
                              </label>
                            </span>
                            @if(auth::user()->type != "Admin" and auth::user()->position != "MASTER" and auth::user()->position != "AUDIT")
                              @if($data->Check_car != NULL)
                                <input type="hidden" name="MASTER" value="{{ $data->Check_car }}">
                              @endif
                            @endif
                          </div>

                          {{-- ปิดสิทธ์แก้ไข / เอกสารครบ --}}
                          <div class="float-right form-inline">
                            <i class="fas fa-grip-vertical"></i>
                            <span class="todo-wrap">
                              @if(auth::user()->type == "Admin" or auth::user()->position == "MASTER" or auth::user()->position == "AUDIT")
                                @if($data->DocComplete_car != NULL)
                                  <input type="checkbox" class="checkbox" name="doccomplete" id="4" value="{{ $data->DocComplete_car }}" {{ ($data->DocComplete_car !== NULL) ? 'checked' : '' }}>
                                @else
                                  <input type="checkbox" class="checkbox" name="doccomplete" id="4" value="{{ auth::user()->name }}">
                                @endif
                              @else
                                @if(auth::user()->position != "STAFF")
                                  <input type="checkbox" class="checkbox" id="4" {{ ($data->DocComplete_car !== NULL) ? 'checked' : '' }} disabled>
                                @endif
                              @endif

                              @if(auth::user()->position == "STAFF")
                                @if($data->DocComplete_car != NULL)
                                  <input type="checkbox" class="checkbox" name="doccomplete" id="4" value="{{ $data->DocComplete_car }}" {{ ($data->DocComplete_car !== NULL) ? 'checked' : '' }} disabled>
                                @else
                                  <input type="checkbox" class="checkbox" name="doccomplete" id="4" value="{{ auth::user()->name }}">
                                @endif
                              @endif

                              <label for="4" class="todo">
                                <i class="fa fa-check"></i>
                                <font color="red">RESTRICT RIGHTS</font>
                              </label>
                            </span>
                            @if(auth::user()->type != "Admin" and auth::user()->position != "MASTER" and auth::user()->position != "STAFF" and auth::user()->position != "AUDIT")
                              <input type="hidden" name="doccomplete" value="{{ $data->DocComplete_car }}">
                            @endif

                            @if(auth::user()->position == "STAFF")
                              @if($data->DocComplete_car != NULL)
                                <input type="hidden" name="doccomplete" value="{{ $data->DocComplete_car }}">
                              @endif
                            @endif
                          </div>  
                        </ol>
                      </div>
                    </div>
                  </div>

                  <div class="card card-warning card-tabs">
                    <div class="card-header p-0 pt-1">
                      <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link MainPage" href="{{ route('MasterAnalysis.index') }}?type={{1}}">หน้าหลัก</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" id="Sub-custom-tab1" data-toggle="pill" href="#Sub-tab1" role="tab" aria-controls="Sub-tab1" aria-selected="false">แบบฟอร์มผู้กู้</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Sub-custom-tab2" data-toggle="pill" href="#Sub-tab2" role="tab" aria-controls="Sub-tab2" aria-selected="false">แบบฟอร์มผู้ค้ำ</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Sub-custom-tab3" data-toggle="pill" href="#Sub-tab3" role="tab" aria-controls="Sub-tab3" aria-selected="false">แบบฟอร์มรถจักรยานยนต์</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Sub-custom-tab5" data-toggle="pill" href="#Sub-tab5" role="tab" aria-controls="Sub-tab5" aria-selected="false">Checker</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Sub-custom-tab6" data-toggle="pill" href="#Sub-tab6" role="tab" aria-controls="Sub-tab6" aria-selected="false">ที่มารายได้</a>
                        </li>
                      </ul>
                    </div>

                    {{-- เนื้อหา --}}
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="tab-pane fade show active" id="Sub-tab1" role="tabpanel" aria-labelledby="Sub-custom-tab1">
                          <h5 class="text-center"><b>แบบฟอร์มรายละเอียดผู้เช่าซื้อ</b></h5>
                          <p></p>
                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right"><font color="red">เลขที่สัญญา : </font></label>
                                  <div class="col-sm-8">
                                    <input type="text" name="Contract_buyer" class="form-control form-control-sm" value="{{ $data->Contract_buyer }}"/>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right"><font color="red">ประเภทสัญญา : </font></label>
                                  <div class="col-sm-8">
                                    <select name="TypeContract" class="form-control form-control-sm" required>
                                      <option value="" selected>--- เลือกสัญญา ---</option>
                                      <option value="P03" {{ ($SubStr === 'P03') ? 'selected' : '' }}>สัญญาเงินกู้รถยนต์ (PLoan)</option>
                                      <option value="P04" {{ ($SubStr === 'P04') ? 'selected' : '' }}>สัญญาเงินกู้รถจักรยานยนต์ (P04)</option>
                                      <option value="P06" {{ ($SubStr === 'P06') ? 'selected' : '' }}>สัญญาเงินกู้ส่วนบุคคล (Micro)</option>
                                      <option value="P07" {{ ($SubStr === 'P07') ? 'selected' : '' }}>สัญญาเงินกู้พนักงาน (P07)</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right"><font color="red">สาขา : </font></label>
                                  <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="BrachUser" class="form-control form-control-sm" required>
                                      <option value="" selected>--- เลือกสาขาตัวเอง ---</option>
                                      <option value="50" {{ ($data->branch_car === 'ปัตตานี') ? 'selected' : '' }}>ปัตตานี (50)</option>
                                      <option value="51" {{ ($data->branch_car === 'ยะลา') ? 'selected' : '' }}>ยะลา (51)</option>
                                      <option value="52" {{ ($data->branch_car === 'นราธิวาส') ? 'selected' : '' }}>นราธิวาส (52)</option>
                                      <option value="53" {{ ($data->branch_car === 'สายบุรี') ? 'selected' : '' }}>สายบุรี (53)</option>
                                      <option value="54" {{ ($data->branch_car === 'โกลก') ? 'selected' : '' }}>โกลก (54)</option>
                                      <option value="55" {{ ($data->branch_car === 'เบตง') ? 'selected' : '' }}>เบตง (55)</option>
                                      <option value="56" {{ ($data->branch_car === 'โคกโพธิ์') ? 'selected' : '' }}>โคกโพธิ์ (56)</option>
                                      <option value="57" {{ ($data->branch_car === 'ตันหยงมัส') ? 'selected' : '' }}>ตันหยงมัส (57)</option>
                                      <option value="58" {{ ($data->branch_car === 'รือเสาะ') ? 'selected' : '' }}>รือเสาะ (58)</option>
                                      <option value="59" {{ ($data->branch_car === 'บังนังสตา') ? 'selected' : '' }}>บังนังสตา (59)</option>
                                      <option value="60" {{ ($data->branch_car === 'ยะหา') ? 'selected' : '' }}>ยะหา (60)</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="BrachUser" class="form-control form-control-sm" value="{{ $data->branch_car }}" readonly/>
                                    @else
                                      <select name="BrachUser" class="form-control form-control-sm" required>
                                        <option value="" selected>--- เลือกสาขาตัวเอง ---</option>
                                        <option value="50" {{ ($data->branch_car === 'ปัตตานี') ? 'selected' : '' }}>ปัตตานี (50)</option>
                                        <option value="51" {{ ($data->branch_car === 'ยะลา') ? 'selected' : '' }}>ยะลา (51)</option>
                                        <option value="52" {{ ($data->branch_car === 'นราธิวาส') ? 'selected' : '' }}>นราธิวาส (52)</option>
                                        <option value="53" {{ ($data->branch_car === 'สายบุรี') ? 'selected' : '' }}>สายบุรี (53)</option>
                                        <option value="54" {{ ($data->branch_car === 'โกลก') ? 'selected' : '' }}>โกลก (54)</option>
                                        <option value="55" {{ ($data->branch_car === 'เบตง') ? 'selected' : '' }}>เบตง (55)</option>
                                        <option value="56" {{ ($data->branch_car === 'โคกโพธิ์') ? 'selected' : '' }}>โคกโพธิ์ (56)</option>
                                        <option value="57" {{ ($data->branch_car === 'ตันหยงมัส') ? 'selected' : '' }}>ตันหยงมัส (57)</option>
                                        <option value="58" {{ ($data->branch_car === 'รือเสาะ') ? 'selected' : '' }}>รือเสาะ (58)</option>
                                        <option value="59" {{ ($data->branch_car === 'บังนังสตา') ? 'selected' : '' }}>บังนังสตา (59)</option>
                                        <option value="60" {{ ($data->branch_car === 'ยะหา') ? 'selected' : '' }}>ยะหา (60)</option>
                                      </select>
                                    @endif
                                  @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right"><font color="red">วันที่ทำสัญญา : </font></label>
                                  <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="date" name="DateDue" class="form-control form-control-sm" value="{{ $newDateDue }}">
                                  @else
                                    <input type="date" name="DateDue" class="form-control form-control-sm" value="{{ $newDateDue }}" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}>
                                  @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">ชื่อ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Namebuyer" value="{{ $data->Name_buyer }}" class="form-control form-control-sm" placeholder="ป้อนชื่อ" />
                                    @else
                                      <input type="text" name="Namebuyer" value="{{ $data->Name_buyer }}" class="form-control form-control-sm" placeholder="ป้อนชื่อ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">นามสกุล : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="lastbuyer" value="{{ $data->last_buyer }}" class="form-control form-control-sm" placeholder="ป้อนนามสกุล" />
                                    @else
                                      <input type="text" name="lastbuyer" value="{{ $data->last_buyer }}" class="form-control form-control-sm" placeholder="ป้อนนามสกุล" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">ชื่อเล่น : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Nickbuyer" value="{{ $data->Nick_buyer }}" class="form-control form-control-sm" placeholder="ป้อนชื่อเล่น" />
                                    @else
                                      <input type="text" name="Nickbuyer" value="{{ $data->Nick_buyer }}" class="form-control form-control-sm" placeholder="ป้อนชื่อเล่น" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">สถานะ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Statusbuyer" class="form-control form-control-sm">
                                        <option value="" selected>--- เลือกสถานะ ---</option>
                                        <option value="โสด" {{ ($data->Status_buyer === 'โสด') ? 'selected' : '' }}>โสด</option>
                                        <option value="สมรส" {{ ($data->Status_buyer === 'สมรส') ? 'selected' : '' }}>สมรส</option>
                                        <option value="หย่าร้าง" {{ ($data->Status_buyer === 'หย่าร้าง') ? 'selected' : '' }}>หย่าร้าง</option>
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Statusbuyer" value="{{ $data->Status_buyer }}" class="form-control form-control-sm" readonly/>
                                      @else
                                        <select name="Statusbuyer" class="form-control form-control-sm">
                                          <option value="" selected>--- เลือกสถานะ ---</option>
                                          <option value="โสด" {{ ($data->Status_buyer === 'โสด') ? 'selected' : '' }}>โสด</option>
                                          <option value="สมรส" {{ ($data->Status_buyer === 'สมรส') ? 'selected' : '' }}>สมรส</option>
                                          <option value="หย่าร้าง" {{ ($data->Status_buyer === 'หย่าร้าง') ? 'selected' : '' }}>หย่าร้าง</option>
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">เบอร์โทรศัพท์ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Phonebuyer" value="{{ $data->Phone_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนเบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask=""/>
                                    @else
                                      <input type="text" name="Phonebuyer" value="{{ $data->Phone_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนเบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6"> 
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">เบอร์โทรอื่นๆ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Phone2buyer" value="{{ $data->Phone2_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนเบอร์โทรอื่นๆ" />
                                    @else
                                      <input type="text" name="Phone2buyer" value="{{ $data->Phone2_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนเบอร์โทรอื่นๆ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">เลขบัตรปชช.ผู้กู้ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Idcardbuyer" value="{{ $data->Idcard_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนเลขประชาชนผู้ซื้อ" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                                    @else
                                      <input type="text" name="Idcardbuyer" value="{{ $data->Idcard_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนเลขประชาชนผู้ซื้อ" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">คู่สมรส : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Matebuyer" value="{{ $data->Mate_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนคู่สมรส" />
                                    @else
                                      <input type="text" name="Matebuyer" value="{{ $data->Mate_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนคู่สมรส" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">ที่อยู่ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Addressbuyer" class="form-control form-control-sm" >
                                        <option value="" selected>--- เลือกที่อยู่ ---</option>
                                        <option value="ตามทะเบียนบ้าน" {{ ($data->Address_buyer === 'ตามทะเบียนบ้าน') ? 'selected' : '' }}>ตามทะเบียนบ้าน</option>
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Addressbuyer" value="{{ $data->Address_buyer }}" class="form-control form-control-sm"  placeholder="เลือกที่อยู่" readonly/>
                                      @else
                                        <select name="Addressbuyer" class="form-control form-control-sm" >
                                          <option value="" selected>--- เลือกที่อยู่ ---</option>
                                          <option value="ตามทะเบียนบ้าน" {{ ($data->Address_buyer === 'ตามทะเบียนบ้าน') ? 'selected' : '' }}>ตามทะเบียนบ้าน</option>
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">ที่อยู่ปัจจุบัน/ส่งเอกสาร : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="AddNbuyer" value="{{ $data->AddN_buyer }}" class="form-control form-control-sm"  placeholder="ที่อยู่ปัจจุบัน/ส่งเอกสาร" />
                                    @else
                                      <input type="text" name="AddNbuyer" value="{{ $data->AddN_buyer }}" class="form-control form-control-sm"  placeholder="ที่อยู่ปัจจุบัน/ส่งเอกสาร" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">รายละเอียดที่อยู่ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="StatusAddbuyer" value="{{ $data->StatusAdd_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนรายละเอียดที่อยู่" />
                                    @else
                                      <input type="text" name="StatusAddbuyer" value="{{ $data->StatusAdd_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนรายละเอียดที่อยู่" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">สถานที่ทำงาน : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Workplacebuyer" value="{{ $data->Workplace_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนสถานที่ทำงาน" />
                                    @else
                                      <input type="text" name="Workplacebuyer" value="{{ $data->Workplace_buyer }}" class="form-control form-control-sm"  placeholder="ป้อนสถานที่ทำงาน" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">ลักษณะบ้าน : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Housebuyer" class="form-control form-control-sm" >
                                        <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                        <option value="บ้านตึก 1 ชั้น" {{ ($data->House_buyer === 'บ้านตึก 1 ชั้น') ? 'selected' : '' }}>บ้านตึก 1 ชั้น</option>
                                        <option value="บ้านตึก 2 ชั้น" {{ ($data->House_buyer === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                        <option value="บ้านไม้ 1 ชั้น" {{ ($data->House_buyer === 'บ้านไม้ 1 ชั้น') ? 'selected' : '' }}>บ้านไม้ 1 ชั้น</option>
                                        <option value="บ้านตึก 2 ชั้น" {{ ($data->House_buyer === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                        <option value="บ้านเดี่ยว" {{ ($data->House_buyer === 'บ้านเดี่ยว') ? 'selected' : '' }}>บ้านเดี่ยว</option>
                                        <option value="แฟลต" {{ ($data->House_buyer === 'แฟลต') ? 'selected' : '' }}>แฟลต</option>
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Housebuyer" value="{{ $data->House_buyer }}" class="form-control form-control-sm"  placeholder="เลือกลักษณะบ้าน" readonly/>
                                      @else
                                        <select name="Housebuyer" class="form-control form-control-sm" >
                                          <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                          <option value="บ้านตึก 1 ชั้น" {{ ($data->House_buyer === 'บ้านตึก 1 ชั้น') ? 'selected' : '' }}>บ้านตึก 1 ชั้น</option>
                                          <option value="บ้านตึก 2 ชั้น" {{ ($data->House_buyer === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                          <option value="บ้านไม้ 1 ชั้น" {{ ($data->House_buyer === 'บ้านไม้ 1 ชั้น') ? 'selected' : '' }}>บ้านไม้ 1 ชั้น</option>
                                          <option value="บ้านตึก 2 ชั้น" {{ ($data->House_buyer === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                          <option value="บ้านเดี่ยว" {{ ($data->House_buyer === 'บ้านเดี่ยว') ? 'selected' : '' }}>บ้านเดี่ยว</option>
                                          <option value="แฟลต" {{ ($data->House_buyer === 'แฟลต') ? 'selected' : '' }}>แฟลต</option>
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">ประเภทบ้าน : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="HouseStylebuyer" class="form-control form-control-sm" >
                                        <option value="" selected>--- ประเภทบ้าน ---</option>
                                        <option value="ของตนเอง" {{ ($data->HouseStyle_buyer === 'ของตนเอง') ? 'selected' : '' }}>ของตนเอง</option>
                                        <option value="อาศัยบิดา-มารดา" {{ ($data->HouseStyle_buyer === 'อาศัยบิดา-มารดา') ? 'selected' : '' }}>อาศัยบิดา-มารดา</option>
                                        <option value="อาศัยผู้อื่น" {{ ($data->HouseStyle_buyer === 'อาศัยผู้อื่น') ? 'selected' : '' }}>อาศัยผู้อื่น</option>
                                        <option value="บ้านพักราชการ" {{ ($data->HouseStyle_buyer === 'บ้านพักราชการ') ? 'selected' : '' }}>บ้านพักราชการ</option>
                                        <option value="บ้านเช่า" {{ ($data->HouseStyle_buyer === 'บ้านเช่า') ? 'selected' : '' }}>บ้านเช่า</option>
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="HouseStylebuyer" value="{{ $data->HouseStyle_buyer }}" class="form-control form-control-sm"  placeholder="เลือกประเภทบ้าน" readonly/>
                                      @else
                                        <select name="HouseStylebuyer" class="form-control form-control-sm" >
                                          <option value="" selected>--- ประเภทบ้าน ---</option>
                                          <option value="ของตนเอง" {{ ($data->HouseStyle_buyer === 'ของตนเอง') ? 'selected' : '' }}>ของตนเอง</option>
                                          <option value="อาศัยบิดา-มารดา" {{ ($data->HouseStyle_buyer === 'อาศัยบิดา-มารดา') ? 'selected' : '' }}>อาศัยบิดา-มารดา</option>
                                          <option value="อาศัยผู้อื่น" {{ ($data->HouseStyle_buyer === 'อาศัยผู้อื่น') ? 'selected' : '' }}>อาศัยผู้อื่น</option>
                                          <option value="บ้านพักราชการ" {{ ($data->HouseStyle_buyer === 'บ้านพักราชการ') ? 'selected' : '' }}>บ้านพักราชการ</option>
                                          <option value="บ้านเช่า" {{ ($data->HouseStyle_buyer === 'บ้านเช่า') ? 'selected' : '' }}>บ้านเช่า</option>
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">ใบขับขี่ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Driverbuyer" class="form-control form-control-sm" >
                                        <option value="" selected>--- เลือกใบขับขี่ ---</option>
                                        <option value="มี" {{ ($data->Driver_buyer === 'มี') ? 'selected' : '' }}>มี</option>
                                        <option value="ไม่มี" {{ ($data->Driver_buyer === 'ไม่มี') ? 'selected' : '' }}>ไม่มี</option>
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Driverbuyer" value="{{ $data->Driver_buyer }}" class="form-control form-control-sm"  placeholder="เลือกใบขับขี่" readonly/>
                                      @else
                                        <select name="Driverbuyer" class="form-control form-control-sm" >
                                          <option value="" selected>--- เลือกใบขับขี่ ---</option>
                                          <option value="มี" {{ ($data->Driver_buyer === 'มี') ? 'selected' : '' }}>มี</option>
                                          <option value="ไม่มี" {{ ($data->Driver_buyer === 'ไม่มี') ? 'selected' : '' }}>ไม่มี</option>
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">สถานะผู้กู้ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Gradebuyer" class="form-control form-control-sm" >
                                        <option value="" selected>--- สถานะผู้กู้ ---</option>
                                        <option value="ลูกค้าเก่าผ่อนดี" {{ ($data->Gradebuyer_car === 'ลูกค้าเก่าผ่อนดี') ? 'selected' : '' }}>ลูกค้าเก่าผ่อนดี</option>
                                        <option value="ลูกค้ามีงานตาม" {{ ($data->Gradebuyer_car === 'ลูกค้ามีงานตาม') ? 'selected' : '' }}>ลูกค้ามีงานตาม</option>
                                        <option value="ลูกค้าใหม่" {{ ($data->Gradebuyer_car === 'ลูกค้าใหม่') ? 'selected' : '' }}>ลูกค้าใหม่</option>
                                        <option value="ลูกค้าใหม่(ปิดธนาคาร)" {{ ($data->Gradebuyer_car === 'ลูกค้าใหม่(ปิดธนาคาร)') ? 'selected' : '' }}>ลูกค้าใหม่(ปิดธนาคาร)</option>
                                        <option value="ปิดจัดใหม่(งานตาม)" {{ ($data->Gradebuyer_car === 'ปิดจัดใหม่(งานตาม)') ? 'selected' : '' }}>ปิดจัดใหม่(งานตาม)</option>
                                        <option value="ปิดจัดใหม่(ผ่อนดี)" {{ ($data->Gradebuyer_car === 'ปิดจัดใหม่(ผ่อนดี)') ? 'selected' : '' }}>ปิดจัดใหม่(ผ่อนดี)</option>
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Gradebuyer" value="{{ $data->Gradebuyer_car }}" class="form-control form-control-sm"  placeholder="เลือกสถานะผู้กู้" readonly/>
                                      @else
                                        <select name="Gradebuyer" class="form-control form-control-sm" >
                                          <option value="" selected>--- สถานะผู้กู้ ---</option>
                                          <option value="ลูกค้าเก่าผ่อนดี" {{ ($data->Gradebuyer_car === 'ลูกค้าเก่าผ่อนดี') ? 'selected' : '' }}>ลูกค้าเก่าผ่อนดี</option>
                                          <option value="ลูกค้ามีงานตาม" {{ ($data->Gradebuyer_car === 'ลูกค้ามีงานตาม') ? 'selected' : '' }}>ลูกค้ามีงานตาม</option>
                                          <option value="ลูกค้าใหม่" {{ ($data->Gradebuyer_car === 'ลูกค้าใหม่') ? 'selected' : '' }}>ลูกค้าใหม่</option>
                                          <option value="ลูกค้าใหม่(ปิดธนาคาร)" {{ ($data->Gradebuyer_car === 'ลูกค้าใหม่(ปิดธนาคาร)') ? 'selected' : '' }}>ลูกค้าใหม่(ปิดธนาคาร)</option>
                                          <option value="ปิดจัดใหม่(งานตาม)" {{ ($data->Gradebuyer_car === 'ปิดจัดใหม่(งานตาม)') ? 'selected' : '' }}>ปิดจัดใหม่(งานตาม)</option>
                                          <option value="ปิดจัดใหม่(ผ่อนดี)" {{ ($data->Gradebuyer_car === 'ปิดจัดใหม่(ผ่อนดี)') ? 'selected' : '' }}>ปิดจัดใหม่(ผ่อนดี)</option>
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                               <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">ประวัติการซื้อ/ค้ำ : </label>
                                  <div class="col-sm-4">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Purchasebuyer" class="form-control form-control-sm">
                                        <option value="" selected>--- ซื้อ ---</option>
                                        <option value="0 คัน" {{ ($data->Purchase_buyer === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                        <option value="1 คัน" {{ ($data->Purchase_buyer === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                        <option value="2 คัน" {{ ($data->Purchase_buyer === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                        <option value="3 คัน" {{ ($data->Purchase_buyer === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                        <option value="4 คัน" {{ ($data->Purchase_buyer === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                        <option value="5 คัน" {{ ($data->Purchase_buyer === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                        <option value="6 คัน" {{ ($data->Purchase_buyer === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                        <option value="7 คัน" {{ ($data->Purchase_buyer === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                        <option value="8 คัน" {{ ($data->Purchase_buyer === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                        <option value="9 คัน" {{ ($data->Purchase_buyer === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                        <option value="10 คัน" {{ ($data->Purchase_buyer === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                        <option value="11 คัน" {{ ($data->Purchase_buyer === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                        <option value="12 คัน" {{ ($data->Purchase_buyer === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                        <option value="13 คัน" {{ ($data->Purchase_buyer === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                        <option value="14 คัน" {{ ($data->Purchase_buyer === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                        <option value="15 คัน" {{ ($data->Purchase_buyer === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                        <option value="16 คัน" {{ ($data->Purchase_buyer === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                        <option value="17 คัน" {{ ($data->Purchase_buyer === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                        <option value="18 คัน" {{ ($data->Purchase_buyer === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                        <option value="19 คัน" {{ ($data->Purchase_buyer === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                        <option value="20 คัน" {{ ($data->Purchase_buyer === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Purchasebuyer" value="{{ $data->Purchase_buyer }}" class="form-control form-control-sm" placeholder="ซื้อ" readonly/>
                                      @else
                                        <select name="Purchasebuyer" class="form-control form-control-sm">
                                          <option value="" selected>--- ซื้อ ---</option>
                                          <option value="0 คัน" {{ ($data->Purchase_buyer === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                          <option value="1 คัน" {{ ($data->Purchase_buyer === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                          <option value="2 คัน" {{ ($data->Purchase_buyer === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                          <option value="3 คัน" {{ ($data->Purchase_buyer === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                          <option value="4 คัน" {{ ($data->Purchase_buyer === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                          <option value="5 คัน" {{ ($data->Purchase_buyer === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                          <option value="6 คัน" {{ ($data->Purchase_buyer === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                          <option value="7 คัน" {{ ($data->Purchase_buyer === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                          <option value="8 คัน" {{ ($data->Purchase_buyer === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                          <option value="9 คัน" {{ ($data->Purchase_buyer === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                          <option value="10 คัน" {{ ($data->Purchase_buyer === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                          <option value="11 คัน" {{ ($data->Purchase_buyer === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                          <option value="12 คัน" {{ ($data->Purchase_buyer === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                          <option value="13 คัน" {{ ($data->Purchase_buyer === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                          <option value="14 คัน" {{ ($data->Purchase_buyer === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                          <option value="15 คัน" {{ ($data->Purchase_buyer === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                          <option value="16 คัน" {{ ($data->Purchase_buyer === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                          <option value="17 คัน" {{ ($data->Purchase_buyer === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                          <option value="18 คัน" {{ ($data->Purchase_buyer === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                          <option value="19 คัน" {{ ($data->Purchase_buyer === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                          <option value="20 คัน" {{ ($data->Purchase_buyer === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                  <div class="col-sm-4">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Supportbuyer" class="form-control form-control-sm">
                                        <option value="" selected>--- ค่ำ ---</option>
                                        <option value="0 คัน" {{ ($data->Support_buyer === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                        <option value="1 คัน" {{ ($data->Support_buyer === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                        <option value="2 คัน" {{ ($data->Support_buyer === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                        <option value="3 คัน" {{ ($data->Support_buyer === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                        <option value="4 คัน" {{ ($data->Support_buyer === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                        <option value="5 คัน" {{ ($data->Support_buyer === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                        <option value="6 คัน" {{ ($data->Support_buyer === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                        <option value="7 คัน" {{ ($data->Support_buyer === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                        <option value="8 คัน" {{ ($data->Support_buyer === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                        <option value="9 คัน" {{ ($data->Support_buyer === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                        <option value="10 คัน" {{ ($data->Support_buyer === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                        <option value="11 คัน" {{ ($data->Support_buyer === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                        <option value="12 คัน" {{ ($data->Support_buyer === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                        <option value="13 คัน" {{ ($data->Support_buyer === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                        <option value="14 คัน" {{ ($data->Support_buyer === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                        <option value="15 คัน" {{ ($data->Support_buyer === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                        <option value="16 คัน" {{ ($data->Support_buyer === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                        <option value="17 คัน" {{ ($data->Support_buyer === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                        <option value="18 คัน" {{ ($data->Support_buyer === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                        <option value="19 คัน" {{ ($data->Support_buyer === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                        <option value="20 คัน" {{ ($data->Support_buyer === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Supportbuyer" value="{{ $data->Support_buyer }}" class="form-control form-control-sm" placeholder="ค้ำ" readonly/>
                                      @else
                                        <select name="Supportbuyer" class="form-control form-control-sm">
                                          <option value="" selected>--- ค่ำ ---</option>
                                          <option value="0 คัน" {{ ($data->Support_buyer === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                          <option value="1 คัน" {{ ($data->Support_buyer === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                          <option value="2 คัน" {{ ($data->Support_buyer === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                          <option value="3 คัน" {{ ($data->Support_buyer === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                          <option value="4 คัน" {{ ($data->Support_buyer === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                          <option value="5 คัน" {{ ($data->Support_buyer === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                          <option value="6 คัน" {{ ($data->Support_buyer === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                          <option value="7 คัน" {{ ($data->Support_buyer === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                          <option value="8 คัน" {{ ($data->Support_buyer === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                          <option value="9 คัน" {{ ($data->Support_buyer === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                          <option value="10 คัน" {{ ($data->Support_buyer === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                          <option value="11 คัน" {{ ($data->Support_buyer === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                          <option value="12 คัน" {{ ($data->Support_buyer === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                          <option value="13 คัน" {{ ($data->Support_buyer === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                          <option value="14 คัน" {{ ($data->Support_buyer === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                          <option value="15 คัน" {{ ($data->Support_buyer === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                          <option value="16 คัน" {{ ($data->Support_buyer === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                          <option value="17 คัน" {{ ($data->Support_buyer === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                          <option value="18 คัน" {{ ($data->Support_buyer === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                          <option value="19 คัน" {{ ($data->Support_buyer === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                          <option value="20 คัน" {{ ($data->Support_buyer === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">สาขาที่รับลูกค้า : </label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" value="{{$data->SendUse_Walkin}}" readonly/>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right">ที่มาของลูกค้า : </label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" value="{{$data->Resource_news}}" readonly/>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <hr>
                            <input type="hidden" name="fdate" value="{{ $fdate }}" />
                            <input type="hidden" name="tdate" value="{{ $tdate }}" />
                            <input type="hidden" name="branch" value="{{ $branch }}" />
                            <input type="hidden" name="status" value="{{ $status }}" />

                            <div class="row">
                              <div class="col-md-4">
                                <h5 class="text-center"><b>รูปภาพประกอบ</b></h5>
                                @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                  <div class="file-loading">
                                    <input id="image-file" type="file" name="file_image[]" accept="image/*" data-min-file-count="1" multiple>
                                  </div>
                                @else
                                  @if($data->Approvers_car == Null)
                                    <div class="file-loading">
                                      <input id="image-file" type="file" name="file_image[]" accept="image/*" data-min-file-count="1" multiple>
                                    </div>
                                  @endif
                                @endif
                                <!-- <div class="form-group">
                                  @if($countImage != 0)
                                    @php
                                      $path = $data->License_car;
                                    @endphp
                                    <p></p>
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <a href="{{ action('AnalysController@deleteImageAll',[$data->id,$path]) }}" class="btn btn-danger pull-left DeleteImage" title="ลบรูปภาพทั้งหมด"> ลบรูปภาพทั้งหมด..</a>
                                      <a href="{{ action('AnalysController@deleteImageEach',[$type,$data->id,$fdate,$tdate,$branch,$status,$path]) }}" class="btn btn-danger pull-right" title="การจัดการรูป">
                                        <span class="glyphicon glyphicon-picture"></span> ลบรูปภาพ..
                                      </a>
                                    @else
                                      @if($data->Approvers_car == Null)
                                        @if($GetDocComplete == Null)
                                        <a href="{{ action('AnalysController@deleteImageEach',[$type,$data->id,$fdate,$tdate,$branch,$status,$path]) }}" class="btn btn-danger pull-right" title="การจัดการรูป">
                                          <span class="glyphicon glyphicon-picture"></span> ลบรูปภาพ..
                                        </a>
                                        @endif
                                      @endif
                                    @endif
                                  @endif
                                </div> -->
                              </div>
                              <div class="col-md-8">
                                <div class="row">
                                  <div class="col-md-6">
                                    <h5 class="text-center"><b>รายละเอียดอาชีพ</b></h5>
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <textarea class="form-control" name="CareerDetail" rows="5" placeholder="ป้อนรายละเอียด">{{$data->CareerDetail_buyer}}</textarea>
                                    @else
                                        @if($GetDocComplete != Null)
                                          <textarea class="form-control" name="CareerDetail" rows="5" placeholder="ป้อนรายละเอียด" readonly>{{$data->CareerDetail_buyer}}</textarea>
                                        @else
                                          <textarea class="form-control" name="CareerDetail" rows="5" placeholder="ป้อนรายละเอียด">{{$data->CareerDetail_buyer}}</textarea>
                                        @endif
                                    @endif
                                    <h5 class="text-center"><b>วัตถุประสงค์สินเชื่อ</b></h5>
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <textarea class="form-control" name="objectivecar" rows="5" placeholder="ป้อนวัตถุประสงค์สินเชื่อ">{{$data->Objective_car}}</textarea>
                                    @else
                                        @if($GetDocComplete != Null)
                                          <textarea class="form-control" name="objectivecar" rows="5" placeholder="ป้อนวัตถุประสงค์สินเชื่อ" readonly>{{$data->Objective_car}}</textarea>
                                        @else
                                          <textarea class="form-control" name="objectivecar" rows="5" placeholder="ป้อนวัตถุประสงค์สินเชื่อ">{{$data->Objective_car}}</textarea>
                                        @endif
                                    @endif
                                  </div>
                                  <div class="col-md-6">
                                    <h5 class="text-center"><b>เหตุผลในการขออนุมัติ</b></h5>
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <textarea class="form-control" name="ApproveDetail" rows="5" placeholder="ป้อนเหตุผล">{{$data->ApproveDetail_buyer}}</textarea>
                                    @else
                                        @if($GetDocComplete != Null)
                                          <textarea class="form-control" name="ApproveDetail" rows="5" placeholder="ป้อนเหตุผล" readonly>{{$data->ApproveDetail_buyer}}</textarea>
                                        @else
                                          <textarea class="form-control" name="ApproveDetail" rows="5" placeholder="ป้อนเหตุผล">{{$data->ApproveDetail_buyer}}</textarea>
                                        @endif
                                    @endif
                                    <h5 class="text-center text-red"><b>หมายเหตุ / กรณีพิเศษ</b></h5>
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <textarea class="form-control" name="Notecar" rows="5" placeholder="ป้อนหมายเหตุ">{{$data->Note_car}}</textarea>
                                    @else
                                        @if($GetDocComplete != Null)
                                          <textarea class="form-control" name="Notecar" rows="5" placeholder="ป้อนหมายเหตุ" readonly>{{$data->Note_car}}</textarea>
                                        @else
                                          <textarea class="form-control" name="Notecar" rows="5" placeholder="ป้อนหมายเหตุ">{{$data->Note_car}}</textarea>
                                        @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>
                          <hr>
                          @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                            <div class="row">
                              <div class="col-md-4"></div>
                              <div class="col-md-4">
                                <h5 class="text-center"><b>ผลการตรวจสอบลูกค้า</b></h5>
                                  @if(auth::user()->type == "Admin")
                                    <textarea class="form-control mb-3" name="Memo" rows="3" placeholder="ป้อนเหตุผล">{{$data->Memo_buyer}}</textarea>
                                  @else
                                    @if($data->ManagerApp_car != Null)
                                      <textarea class="form-control mb-3" name="Memo" rows="3" placeholder="ป้อนเหตุผล" readonly>{{$data->Memo_buyer}}</textarea>
                                    @else 
                                      <textarea class="form-control mb-3" name="Memo" rows="3" placeholder="ป้อนเหตุผล">{{$data->Memo_buyer}}</textarea>
                                    @endif 
                                  @endif
                                  <div class="card">
                                    <h5 class="text-center"><b>ความพึงพอใจลูกค้า</b></h5>
                                    <div class="form-group clearfix">
                                      &nbsp;
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary1" name="Buyerprefer" value="ปรับปรุง" {{ ($data->Prefer_buyer == 'ปรับปรุง') ? 'checked' : '' }}>
                                        <label for="radioPrimary1" style="font-size: 10px;">
                                        ปรับปรุง
                                        </label>
                                      </div>
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary2" name="Buyerprefer" value="พอใช้" {{ ($data->Prefer_buyer == 'พอใช้') ? 'checked' : '' }}>
                                        <label for="radioPrimary2" style="font-size: 10px;">
                                        พอใช้
                                        </label>
                                      </div>
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary3" name="Buyerprefer" value="ปานกลาง" {{ ($data->Prefer_buyer == 'ปานกลาง') ? 'checked' : '' }}>
                                        <label for="radioPrimary3" style="font-size: 10px;">
                                        ปานกลาง
                                        </label>
                                      </div>
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary4" name="Buyerprefer" value="ดี" {{ ($data->Prefer_buyer == 'ดี') ? 'checked' : '' }}>
                                        <label for="radioPrimary4" style="font-size: 10px;">
                                        ดี
                                        </label>
                                      </div>
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary5" name="Buyerprefer" value="ดีมาก" {{ ($data->Prefer_buyer == 'ดีมาก') ? 'checked' : '' }}>
                                        <label for="radioPrimary5" style="font-size: 10px;">
                                        ดีมาก
                                        </label>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                <h5 class="text-center"><b>ผลการตรวจสอบนายหน้า</b></h5>
                                  @if(auth::user()->type == "Admin")
                                    <textarea class="form-control mb-3" name="Memobroker" rows="3" placeholder="ป้อนเหตุผล">{{$data->Memo_broker}}</textarea>
                                  @else
                                    @if($data->ManagerApp_car != Null)
                                      <textarea class="form-control mb-3" name="Memobroker" rows="3" placeholder="ป้อนเหตุผล" readonly>{{$data->Memo_broker}}</textarea>
                                    @else
                                      <textarea class="form-control mb-3" name="Memobroker" rows="3" placeholder="ป้อนเหตุผล">{{$data->Memo_broker}}</textarea>
                                    @endif 
                                  @endif
                                  <div class="card">
                                    <h5 class="text-center"><b>ความพึงพอใจนายหน้า</b></h5>
                                    <div class="form-group clearfix">
                                      &nbsp;
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary11" name="Brokerprefer" value="ปรับปรุง" {{ ($data->Prefer_broker == 'ปรับปรุง') ? 'checked' : '' }}>
                                        <label for="radioPrimary11" style="font-size: 10px;">
                                        ปรับปรุง
                                        </label>
                                      </div>
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary22" name="Brokerprefer" value="พอใช้" {{ ($data->Prefer_broker == 'พอใช้') ? 'checked' : '' }}>
                                        <label for="radioPrimary22" style="font-size: 10px;">
                                        พอใช้
                                        </label>
                                      </div>
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary33" name="Brokerprefer" value="ปานกลาง" {{ ($data->Prefer_broker == 'ปานกลาง') ? 'checked' : '' }}>
                                        <label for="radioPrimary33" style="font-size: 10px;">
                                        ปานกลาง
                                        </label>
                                      </div>
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary44" name="Brokerprefer" value="ดี" {{ ($data->Prefer_broker == 'ดี') ? 'checked' : '' }}>
                                        <label for="radioPrimary44" style="font-size: 10px;">
                                        ดี
                                        </label>
                                      </div>
                                      <div class="icheck-primary d-inline pr-3">
                                        <input type="radio" id="radioPrimary55" name="Brokerprefer" value="ดีมาก" {{ ($data->Prefer_broker == 'ดีมาก') ? 'checked' : '' }}>
                                        <label for="radioPrimary55" style="font-size: 10px;">
                                        ดีมาก
                                        </label>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          @else
                            <input type="hidden" name="Memo" value="{{$data->Memo_buyer}}" />
                            <input type="hidden" name="Buyerprefer" value="{{$data->Prefer_buyer}}" />
                            <input type="hidden" name="Memobroker" value="{{$data->Memo_broker}}" />
                            <input type="hidden" name="Brokerprefer" value="{{$data->Prefer_broker}}" />
                          @endif
                            
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                    @if($countImage != 0)
                                      @php
                                        $path = $data->License_car;
                                      @endphp
                                      <p></p>
                                      @if(auth::user()->type == "Admin" or auth::user()->position == "MANAGER" or auth::user()->position == "AUDIT" or auth::user()->position == "MASTER" or auth::user()->position == "STAFF")
                                        <a href="{{ action('AnalysController@deleteImageAll',[$data->id,$path]) }}" class="btn btn-danger pull-left DeleteImage" title="ลบรูปภาพทั้งหมด"> ลบรูปภาพทั้งหมด..</a>
                                        <a href="{{ action('AnalysController@deleteImageEach',[$type,$data->id,$fdate,$tdate,$branch,$status,$path]) }}" class="btn btn-danger pull-right" title="การจัดการรูป">
                                          <span class="glyphicon glyphicon-picture"></span> ลบรูปภาพ..
                                        </a>
                                      @else
                                        @if($data->Approvers_car == Null)
                                          @if($GetDocComplete == Null)
                                          <a href="{{ action('AnalysController@deleteImageEach',[$type,$data->id,$fdate,$tdate,$branch,$status,$path]) }}" class="btn btn-danger pull-right" title="การจัดการรูป">
                                            <span class="glyphicon glyphicon-picture"></span> ลบรูปภาพ..
                                          </a>
                                          @endif
                                        @endif
                                      @endif
                                    @endif
                                  </div>
                                </div>
                            </div>
                            <br/>

                            <div class="row">
                              <div class="col-12">
                                <div class="card card-primary">
                                  <div class="card-header">
                                    <div class="card-title">
                                      รูปภาพทั้งหมด
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    @if($data->License_car != NULL)
                                      @php
                                        $Setlisence = $data->License_car;
                                      @endphp
                                    @endif
                                    <div class="form-inline">
                                      @if(substr($data->createdBuyers_at,0,10) < $Currdate)
                                        @foreach($dataImage as $images)
                                          @if($images->Type_fileimage == "1")
                                            <div class="col-sm-3">
                                              <a href="{{ asset('upload-image/'.$images->Name_fileimage) }}" class="MagicZoom" data-gallery="gallery" data-options="hint:true; zoomMode:magnifier; variableZoom: true">
                                                <img src="{{ asset('upload-image/'.$images->Name_fileimage) }}" style="width: 300px; height: 280px;">
                                              </a>
                                            </div>
                                          @endif
                                        @endforeach
                                      @else
                                        @foreach($dataImage as $images)
                                          @if($images->Type_fileimage == "1")
                                            <div class="col-sm-3">
                                              <a href="{{ asset('upload-image/'.$Setlisence .'/'.$images->Name_fileimage) }}" class="MagicZoom" data-gallery="gallery" data-options="hint:true; zoomMode:magnifier; variableZoom: true">
                                                <img src="{{ asset('upload-image/'.$Setlisence .'/'.$images->Name_fileimage) }}" style="width: 300px; height: 280px;">
                                              </a>
                                            </div>
                                          @endif
                                        @endforeach
                                      @endif
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
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ชื่อ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="nameSP" value="{{$data->name_SP}}" class="form-control form-control-sm" placeholder="ชื่อ" />
                                  @else
                                    <input type="text" name="nameSP" value="{{$data->name_SP}}" class="form-control form-control-sm" placeholder="ชื่อ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">นามสกุล : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="lnameSP" value="{{$data->lname_SP}}" class="form-control form-control-sm" placeholder="นามสกุล" />
                                  @else
                                    <input type="text" name="lnameSP" value="{{$data->lname_SP}}" class="form-control form-control-sm" placeholder="นามสกุล" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ชื่อเล่น : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="niknameSP" value="{{$data->nikname_SP}}" class="form-control form-control-sm" placeholder="ชื่อเล่น" />
                                  @else
                                    <input type="text" name="niknameSP" value="{{$data->nikname_SP}}" class="form-control form-control-sm" placeholder="ชื่อเล่น" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">สถานะ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="statusSP" class="form-control form-control-sm">
                                      <option value="" selected>--- สถานะ ---</option>
                                      <option value="โสด" {{ ($data->status_SP === 'โสด') ? 'selected' : '' }}>โสด</option>
                                      <option value="สมรส" {{ ($data->status_SP === 'สมรส') ? 'selected' : '' }}>สมรส</option>
                                      <option value="หย่าร้าง" {{ ($data->status_SP === 'หย่าร้าง') ? 'selected' : '' }}>หย่าร้าง</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="statusSP" value="{{$data->status_SP}}" class="form-control form-control-sm" placeholder="เลือกสถานะ" readonly/>
                                    @else
                                      <select name="statusSP" class="form-control form-control-sm">
                                        <option value="" selected>--- สถานะ ---</option>
                                        <option value="โสด" {{ ($data->status_SP === 'โสด') ? 'selected' : '' }}>โสด</option>
                                        <option value="สมรส" {{ ($data->status_SP === 'สมรส') ? 'selected' : '' }}>สมรส</option>
                                        <option value="หย่าร้าง" {{ ($data->status_SP === 'หย่าร้าง') ? 'selected' : '' }}>หย่าร้าง</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">เบอร์โทร : </label>
                                <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="telSP" value="{{$data->tel_SP}}" class="form-control form-control-sm" placeholder="เบอร์โทร" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="telSP" value="{{$data->tel_SP}}" class="form-control form-control-sm" placeholder="เบอร์โทร" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ความสัมพันธ์ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="relationSP" class="form-control form-control-sm">
                                      <option value="" selected>--- ความสัมพันธ์ ---</option>
                                      <option value="พี่น้อง" {{ ($data->relation_SP === 'พี่น้อง') ? 'selected' : '' }}>พี่น้อง</option>
                                      <option value="ญาติ" {{ ($data->relation_SP === 'ญาติ') ? 'selected' : '' }}>ญาติ</option>
                                      <option value="เพื่อน" {{ ($data->relation_SP === 'เพื่อน') ? 'selected' : '' }}>เพื่อน</option>
                                      <option value="บิดา" {{ ($data->relation_SP === 'บิดา') ? 'selected' : '' }}>บิดา</option>
                                      <option value="มารดา" {{ ($data->relation_SP === 'มารดา') ? 'selected' : '' }}>มารดา</option>
                                      <option value="ลูก" {{ ($data->relation_SP === 'ลูก') ? 'selected' : '' }}>ลูก</option>
                                      <option value="ตำบลเดี่ยวกัน" {{ ($data->relation_SP === 'ตำบลเดี่ยวกัน') ? 'selected' : '' }}>ตำบลเดี่ยวกัน</option>
                                      <option value="จ้างค้ำ(ไม่รู้จักกัน)" {{ ($data->relation_SP === 'จ้างค้ำ(ไม่รู้จักกัน)') ? 'selected' : '' }}>จ้างค้ำ(ไม่รู้จักกัน)</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="relationSP" value="{{$data->relation_SP}}" class="form-control form-control-sm" placeholder="เลือกความสัมพันธ์" readonly/>
                                    @else
                                      <select name="relationSP" class="form-control form-control-sm">
                                        <option value="" selected>--- ความสัมพันธ์ ---</option>
                                        <option value="พี่น้อง" {{ ($data->relation_SP === 'พี่น้อง') ? 'selected' : '' }}>พี่น้อง</option>
                                        <option value="ญาติ" {{ ($data->relation_SP === 'ญาติ') ? 'selected' : '' }}>ญาติ</option>
                                        <option value="เพื่อน" {{ ($data->relation_SP === 'เพื่อน') ? 'selected' : '' }}>เพื่อน</option>
                                        <option value="บิดา" {{ ($data->relation_SP === 'บิดา') ? 'selected' : '' }}>บิดา</option>
                                        <option value="มารดา" {{ ($data->relation_SP === 'มารดา') ? 'selected' : '' }}>มารดา</option>
                                        <option value="ตำบลเดี่ยวกัน" {{ ($data->relation_SP === 'ตำบลเดี่ยวกัน') ? 'selected' : '' }}>ตำบลเดี่ยวกัน</option>
                                        <option value="จ้างค้ำ(ไม่รู้จักกัน)" {{ ($data->relation_SP === 'จ้างค้ำ(ไม่รู้จักกัน)') ? 'selected' : '' }}>จ้างค้ำ(ไม่รู้จักกัน)</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">เลขบัตรปชช.ผู้ค่ำ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="idcardSP" value="{{$data->idcard_SP}}" class="form-control form-control-sm" placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="idcardSP" value="{{$data->idcard_SP}}" class="form-control form-control-sm" placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">คู่สมรส : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="mateSP" value="{{$data->mate_SP}}" class="form-control form-control-sm" placeholder="คู่สมรส" />
                                  @else
                                    <input type="text" name="mateSP" value="{{$data->mate_SP}}" class="form-control form-control-sm" placeholder="คู่สมรส" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ที่อยู่ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="addSP" class="form-control form-control-sm">
                                      <option value="" selected>--- ที่อยู่ ---</option>
                                      <option value="ตามทะเบียนบ้าน" {{ ($data->add_SP === 'ตามทะเบียนบ้าน') ? 'selected' : '' }}>ตามทะเบียนบ้าน</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="addSP" value="{{$data->add_SP}}" class="form-control form-control-sm" placeholder="เลือกที่อยู่" readonly/>
                                    @else
                                      <select name="addSP" class="form-control form-control-sm">
                                        <option value="" selected>--- ที่อยู่ ---</option>
                                        <option value="ตามทะเบียนบ้าน" {{ ($data->add_SP === 'ตามทะเบียนบ้าน') ? 'selected' : '' }}>ตามทะเบียนบ้าน</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ที่อยู่ปัจจุบัน/จัดส่งเอกสาร : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="addnowSP" value="{{$data->addnow_SP}}" class="form-control form-control-sm" placeholder="ที่อยู่ปัจจุบัน/จัดส่งเอกสาร" />
                                  @else
                                    <input type="text" name="addnowSP" value="{{$data->addnow_SP}}" class="form-control form-control-sm" placeholder="ที่อยู่ปัจจุบัน/จัดส่งเอกสาร" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">รายละเอียดที่อยู่ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="statusaddSP" value="{{$data->statusadd_SP}}" class="form-control form-control-sm" placeholder="รายละเอียดที่อยู่" />
                                  @else
                                    <input type="text" name="statusaddSP" value="{{$data->statusadd_SP}}" class="form-control form-control-sm" placeholder="รายละเอียดที่อยู่" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">สถานที่ทำงาน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="workplaceSP" value="{{$data->workplace_SP}}" class="form-control form-control-sm" placeholder="สถานที่ทำงาน" />
                                  @else
                                    <input type="text" name="workplaceSP" value="{{$data->workplace_SP}}" class="form-control form-control-sm" placeholder="สถานที่ทำงาน" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ลักษณะบ้าน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="houseSP" class="form-control form-control-sm">
                                      <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                      <option value="บ้านตึก 1 ชั้น" {{ ($data->house_SP === 'บ้านตึก 1 ชั้น') ? 'selected' : '' }}>บ้านตึก 1 ชั้น</option>
                                      <option value="บ้านตึก 2 ชั้น" {{ ($data->house_SP === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                      <option value="บ้านไม้ 1 ชั้น" {{ ($data->house_SP === 'บ้านไม้ 1 ชั้น') ? 'selected' : '' }}>บ้านไม้ 1 ชั้น</option>
                                      <option value="บ้านตึก 2 ชั้น" {{ ($data->house_SP === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                      <option value="บ้านเดี่ยว" {{ ($data->house_SP === 'บ้านเดี่ยว') ? 'selected' : '' }}>บ้านเดี่ยว</option>
                                      <option value="แฟลต" {{ ($data->house_SP === 'แฟลต') ? 'selected' : '' }}>แฟลต</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="houseSP" value="{{$data->house_SP}}" class="form-control form-control-sm" placeholder="เลือกลักษณะบ้าน" readonly/>
                                    @else
                                      <select name="houseSP" class="form-control form-control-sm">
                                        <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                        <option value="บ้านตึก 1 ชั้น" {{ ($data->house_SP === 'บ้านตึก 1 ชั้น') ? 'selected' : '' }}>บ้านตึก 1 ชั้น</option>
                                        <option value="บ้านตึก 2 ชั้น" {{ ($data->house_SP === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                        <option value="บ้านไม้ 1 ชั้น" {{ ($data->house_SP === 'บ้านไม้ 1 ชั้น') ? 'selected' : '' }}>บ้านไม้ 1 ชั้น</option>
                                        <option value="บ้านตึก 2 ชั้น" {{ ($data->house_SP === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                        <option value="บ้านเดี่ยว" {{ ($data->house_SP === 'บ้านเดี่ยว') ? 'selected' : '' }}>บ้านเดี่ยว</option>
                                        <option value="แฟลต" {{ ($data->house_SP === 'แฟลต') ? 'selected' : '' }}>แฟลต</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ประเภทบ้าน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="housestyleSP" class="form-control form-control-sm">
                                      <option value="" selected>--- ประเภทบ้าน ---</option>
                                      <option value="ของตนเอง" {{ ($data->housestyle_SP === 'ของตนเอง') ? 'selected' : '' }}>ของตนเอง</option>
                                      <option value="อาศัยบิดา-มารดา" {{ ($data->housestyle_SP === 'อาศัยบิดา-มารดา') ? 'selected' : '' }}>อาศัยบิดา-มารดา</option>
                                      <option value="อาศัยผู้อื่น" {{ ($data->housestyle_SP === 'อาศัยผู้อื่น') ? 'selected' : '' }}>อาศัยผู้อื่น</option>
                                      <option value="บ้านพักราชการ" {{ ($data->housestyle_SP === 'บ้านพักราชการ') ? 'selected' : '' }}>บ้านพักราชการ</option>
                                      <option value="บ้านเช่า" {{ ($data->housestyle_SP === 'บ้านเช่า') ? 'selected' : '' }}>บ้านเช่า</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="housestyleSP" value="{{$data->housestyle_SP}}" class="form-control form-control-sm" placeholder="ประเภทบ้าน" readonly/>
                                    @else
                                      <select name="housestyleSP" class="form-control form-control-sm">
                                        <option value="" selected>--- ประเภทบ้าน ---</option>
                                        <option value="ของตนเอง" {{ ($data->housestyle_SP === 'ของตนเอง') ? 'selected' : '' }}>ของตนเอง</option>
                                        <option value="อาศัยบิดา-มารดา" {{ ($data->housestyle_SP === 'อาศัยบิดา-มารดา') ? 'selected' : '' }}>อาศัยบิดา-มารดา</option>
                                        <option value="อาศัยผู้อื่น" {{ ($data->housestyle_SP === 'อาศัยผู้อื่น') ? 'selected' : '' }}>อาศัยผู้อื่น</option>
                                        <option value="บ้านพักราชการ" {{ ($data->housestyle_SP === 'บ้านพักราชการ') ? 'selected' : '' }}>บ้านพักราชการ</option>
                                        <option value="บ้านเช่า" {{ ($data->housestyle_SP === 'บ้านเช่า') ? 'selected' : '' }}>บ้านเช่า</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">อาชีพ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="careerSP" value="{{$data->career_SP}}" class="form-control form-control-sm" placeholder="อาชีพ"/>
                                  @else
                                    <input type="text" name="careerSP" value="{{$data->career_SP}}" class="form-control form-control-sm" placeholder="อาชีพ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">รายได้ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="incomeSP" name="incomeSP" value="{{ $data->income_SP }}" class="form-control form-control-sm" placeholder="รายได้" />
                                  @else
                                    <input type="text" id="incomeSP" name="incomeSP" value="{{ $data->income_SP }}" class="form-control form-control-sm" placeholder="รายได้"  {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ประวัติซื้อ/ค้ำ  : </label>
                                <div class="col-sm-4">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="puchaseSP" class="form-control form-control-sm">
                                      <option value="" selected>--- ซื้อ ---</option>
                                      <option value="0 คัน" {{ ($data->puchase_SP === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                      <option value="1 คัน" {{ ($data->puchase_SP === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                      <option value="2 คัน" {{ ($data->puchase_SP === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                      <option value="3 คัน" {{ ($data->puchase_SP === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                      <option value="4 คัน" {{ ($data->puchase_SP === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                      <option value="5 คัน" {{ ($data->puchase_SP === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                      <option value="6 คัน" {{ ($data->puchase_SP === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                      <option value="7 คัน" {{ ($data->puchase_SP === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                      <option value="8 คัน" {{ ($data->puchase_SP === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                      <option value="9 คัน" {{ ($data->puchase_SP === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                      <option value="10 คัน" {{ ($data->puchase_SP === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                      <option value="11 คัน" {{ ($data->puchase_SP === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                      <option value="12 คัน" {{ ($data->puchase_SP === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                      <option value="13 คัน" {{ ($data->puchase_SP === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                      <option value="14 คัน" {{ ($data->puchase_SP === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                      <option value="15 คัน" {{ ($data->puchase_SP === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                      <option value="16 คัน" {{ ($data->puchase_SP === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                      <option value="17 คัน" {{ ($data->puchase_SP === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                      <option value="18 คัน" {{ ($data->puchase_SP === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                      <option value="19 คัน" {{ ($data->puchase_SP === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                      <option value="20 คัน" {{ ($data->puchase_SP === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="puchaseSP" value="{{$data->puchase_SP}}" class="form-control form-control-sm" placeholder="ซื้อ" readonly/>
                                    @else
                                      <select name="puchaseSP" class="form-control form-control-sm">
                                        <option value="" selected>--- ซื้อ ---</option>
                                        <option value="0 คัน" {{ ($data->puchase_SP === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                        <option value="1 คัน" {{ ($data->puchase_SP === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                        <option value="2 คัน" {{ ($data->puchase_SP === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                        <option value="3 คัน" {{ ($data->puchase_SP === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                        <option value="4 คัน" {{ ($data->puchase_SP === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                        <option value="5 คัน" {{ ($data->puchase_SP === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                        <option value="6 คัน" {{ ($data->puchase_SP === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                        <option value="7 คัน" {{ ($data->puchase_SP === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                        <option value="8 คัน" {{ ($data->puchase_SP === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                        <option value="9 คัน" {{ ($data->puchase_SP === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                        <option value="10 คัน" {{ ($data->puchase_SP === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                        <option value="11 คัน" {{ ($data->puchase_SP === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                        <option value="12 คัน" {{ ($data->puchase_SP === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                        <option value="13 คัน" {{ ($data->puchase_SP === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                        <option value="14 คัน" {{ ($data->puchase_SP === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                        <option value="15 คัน" {{ ($data->puchase_SP === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                        <option value="16 คัน" {{ ($data->puchase_SP === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                        <option value="17 คัน" {{ ($data->puchase_SP === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                        <option value="18 คัน" {{ ($data->puchase_SP === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                        <option value="19 คัน" {{ ($data->puchase_SP === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                        <option value="20 คัน" {{ ($data->puchase_SP === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                                <div class="col-sm-4">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="supportSP" class="form-control form-control-sm">
                                      <option value="" selected>--- ค้ำ ---</option>
                                      <option value="0 คัน" {{ ($data->support_SP === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                      <option value="1 คัน" {{ ($data->support_SP === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                      <option value="2 คัน" {{ ($data->support_SP === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                      <option value="3 คัน" {{ ($data->support_SP === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                      <option value="4 คัน" {{ ($data->support_SP === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                      <option value="5 คัน" {{ ($data->support_SP === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                      <option value="6 คัน" {{ ($data->support_SP === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                      <option value="7 คัน" {{ ($data->support_SP === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                      <option value="8 คัน" {{ ($data->support_SP === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                      <option value="9 คัน" {{ ($data->support_SP === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                      <option value="10 คัน" {{ ($data->support_SP === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                      <option value="11 คัน" {{ ($data->support_SP === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                      <option value="12 คัน" {{ ($data->support_SP === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                      <option value="13 คัน" {{ ($data->support_SP === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                      <option value="14 คัน" {{ ($data->support_SP === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                      <option value="15 คัน" {{ ($data->support_SP === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                      <option value="16 คัน" {{ ($data->support_SP === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                      <option value="17 คัน" {{ ($data->support_SP === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                      <option value="18 คัน" {{ ($data->support_SP === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                      <option value="19 คัน" {{ ($data->support_SP === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                      <option value="20 คัน" {{ ($data->support_SP === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="supportSP" value="{{$data->support_SP}}" class="form-control form-control-sm" placeholder="ค้ำ" readonly/>
                                    @else
                                      <select name="supportSP" class="form-control form-control-sm">
                                        <option value="" selected>--- ค้ำ ---</option>
                                        <option value="0 คัน" {{ ($data->support_SP === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                        <option value="1 คัน" {{ ($data->support_SP === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                        <option value="2 คัน" {{ ($data->support_SP === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                        <option value="3 คัน" {{ ($data->support_SP === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                        <option value="4 คัน" {{ ($data->support_SP === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                        <option value="5 คัน" {{ ($data->support_SP === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                        <option value="6 คัน" {{ ($data->support_SP === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                        <option value="7 คัน" {{ ($data->support_SP === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                        <option value="8 คัน" {{ ($data->support_SP === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                        <option value="9 คัน" {{ ($data->support_SP === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                        <option value="10 คัน" {{ ($data->support_SP === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                        <option value="11 คัน" {{ ($data->support_SP === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                        <option value="12 คัน" {{ ($data->support_SP === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                        <option value="13 คัน" {{ ($data->support_SP === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                        <option value="14 คัน" {{ ($data->support_SP === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                        <option value="15 คัน" {{ ($data->support_SP === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                        <option value="16 คัน" {{ ($data->support_SP === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                        <option value="17 คัน" {{ ($data->support_SP === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                        <option value="18 คัน" {{ ($data->support_SP === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                        <option value="19 คัน" {{ ($data->support_SP === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                        <option value="20 คัน" {{ ($data->support_SP === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                            </div>
                          </div>

                        </div>
                        <div class="tab-pane fade" id="Sub-tab3" role="tabpanel" aria-labelledby="Sub-custom-tab3">
                          <h5 class="text-center"><b>แบบฟอร์มรายละเอียดรถจักรยานยนต์</b></h5>
                          <p></p>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ยี่ห้อ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="Brandcar" class="form-control form-control-sm" >
                                      <option value="" selected>--- ยี่ห้อ ---</option>
                                      <option value="HONDA" {{ ($data->Brand_car === 'HONDA') ? 'selected' : '' }}>HONDA</option>
                                      <option value="YAMAHA" {{ ($data->Brand_car === 'YAMAHA') ? 'selected' : '' }}>YAMAHA</option>
                                      <option value="KAWASAKI" {{ ($data->Brand_car === 'KAWASAKI') ? 'selected' : '' }}>KAWASAKI</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="Brandcar" value="{{$data->Brand_car}}" class="form-control form-control-sm"  placeholder="ยี่ห้อ" readonly/>
                                    @else
                                      <select name="Brandcar" class="form-control form-control-sm" >
                                        <option value="" selected>--- ยี่ห้อ ---</option>
                                        <option value="HONDA" {{ ($data->Brand_car === 'HONDA') ? 'selected' : '' }}>HONDA</option>
                                        <option value="YAMAHA" {{ ($data->Brand_car === 'YAMAHA') ? 'selected' : '' }}>YAMAHA</option>
                                        <option value="KAWASAKI" {{ ($data->Brand_car === 'KAWASAKI') ? 'selected' : '' }}>KAWASAKI</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ประเภทรถ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="Typecardetail" name="Typecardetail" class="form-control form-control-sm"  onchange="calculate();">
                                      <option value="" selected>--- ประเภทรถ ---</option>
                                      <option value="เกียร์ธรรมดา" {{ ($data->Typecardetails === 'เกียร์ธรรมดา') ? 'selected' : '' }}>เกียร์ธรรมดา</option>
                                      <option value="รถออโตเมติก" {{ ($data->Typecardetails === 'รถออโตเมติก') ? 'selected' : '' }}>รถออโตเมติก</option>
                                      <option value="BigBike" {{ ($data->Typecardetails === 'BigBike') ? 'selected' : '' }}>BigBike</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="Typecardetail" name="Typecardetail" value="{{$data->Typecardetails}}" class="form-control form-control-sm"  placeholder="ปี" readonly/>
                                    @else
                                      <select id="Typecardetail" name="Typecardetail" class="form-control form-control-sm"  onchange="calculate();">
                                        <option value="" selected>--- ประเภทรถ ---</option>
                                        <option value="เกียร์ธรรมดา" {{ ($data->Typecardetails === 'เกียร์ธรรมดา') ? 'selected' : '' }}>เกียร์ธรรมดา</option>
                                        <option value="รถออโตเมติก" {{ ($data->Typecardetails === 'รถออโตเมติก') ? 'selected' : '' }}>รถออโตเมติก</option>
                                        <option value="BigBike" {{ ($data->Typecardetails === 'BigBike') ? 'selected' : '' }}>BigBike</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">สี : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Colourcar" value="{{ $data->Colour_car }}" class="form-control form-control-sm"  placeholder="สี" />
                                  @else
                                    <input type="text" name="Colourcar" value="{{ $data->Colour_car }}" class="form-control form-control-sm"  placeholder="สี" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ปี : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="Yearcar" name="Yearcar" class="form-control form-control-sm"  onchange="calculate();">
                                      <option value="{{$data->Year_car}}" selected>{{$data->Year_car}}</option>
                                      <option value="">--------------------</option>
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
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="Yearcar" value="{{$data->Year_car}}" class="form-control form-control-sm"  placeholder="ปี" readonly/>
                                    @else
                                      <select id="Yearcar" name="Yearcar" class="form-control form-control-sm"  onchange="calculate();">
                                        <option value="{{$data->Year_car}}" selected>{{$data->Year_car}}</option>
                                        <option value="">--------------------</option>
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
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ป้ายทะเบียน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin")
                                    <input type="text" name="Licensecar"  value="{{ $data->License_car}}" class="form-control form-control-sm"  placeholder="ป้ายเดิม"/>
                                  @else
                                    @if($countImage == 0)
                                      <input type="text" name="Licensecar"  value="{{ $data->License_car}}" class="form-control form-control-sm"/>
                                    @else
                                      <input type="text" name="Licensecar"  value="{{ $data->License_car}}" class="form-control form-control-sm"  readonly/>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">รุ่น : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Modelcar" value="{{$data->Model_car}}" class="form-control form-control-sm"  placeholder="รุ่น" />
                                  @else
                                    <input type="text" name="Modelcar" value="{{$data->Model_car}}" class="form-control form-control-sm"  placeholder="รุ่น" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">เลขตัวถัง : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="IDTankcar" value="{{$data->IDTank_car}}" class="form-control form-control-sm"  placeholder="เลขตัวถัง" />
                                  @else
                                    <input type="text" name="IDTankcar" value="{{$data->IDTank_car}}" class="form-control form-control-sm"  placeholder="เลขตัวถัง" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">เลขเครื่อง : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="IDMachinecar" value="{{$data->IDMachine_car}}" class="form-control form-control-sm"  placeholder="เลขเครื่อง"/>
                                  @else
                                    <input type="text" name="IDMachinecar" value="{{$data->IDMachine_car}}" class="form-control form-control-sm"  placeholder="เลขเครื่อง" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">เลขไมล์ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Milecar" name="Milecar" value="{{$data->Mile_car}}" class="form-control form-control-sm"  placeholder="เลขไมล์" onchange="mile();" />
                                  @else
                                    <input type="text" id="Milecar" name="Milecar" value="{{$data->Mile_car}}" class="form-control form-control-sm"  placeholder="เลขไมล์" onchange="mile();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ราคากลาง : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Midpricecar" name="Midpricecar" value="{{$data->Midprice_car}}" class="form-control form-control-sm"  placeholder="ราคากลาง" oninput="mile();percent();"/>
                                  @else
                                    <input type="text" id="Midpricecar" name="Midpricecar" value="{{$data->Midprice_car}}" class="form-control form-control-sm"  placeholder="ราคากลาง" oninput="mile();percent();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          {{-- กลุ่มปีรถยนต์ --}}
                          <input type="hidden" id="Groupyearcar" name="Groupyearcar" class="form-control form-control-sm"  value="{{ $data->Groupyear_car}}" readonly onchange="newformula();" disabled/>
                          
                          <hr />
                          @include('analysis.script')

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right"><font color="red">เงินต้น :</font></label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Topcar" name="Topcar" value="{{number_format($data->Top_car)}}" class="form-control form-control-sm"  placeholder="ป้อนเงินต้น" oninput="calculate2();balance2();" />
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="Topcar" name="Topcar" value="{{number_format($data->Top_car)}}" class="form-control form-control-sm"  placeholder="ป้อนเงินต้น" oninput="calculate2();balance2();" readonly/>
                                    @else
                                      <input type="text" id="Topcar" name="Topcar" value="{{number_format($data->Top_car)}}" class="form-control form-control-sm"  placeholder="ป้อนเงินต้น" oninput="calculate2();balance2();"/>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <div class="col-sm-8">
                                  <input type="hidden" id="Totalfee" name="Paymemtcar" class="form-control form-control-sm" value="{{$data->Paymemt_car}}" placeholder="-" readonly/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ค่าดำเนินการ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Processfee" name="Vatcar" class="form-control form-control-sm" value="{{($data->Vat_car != null)?$data->Vat_car:0}}" placeholder="ป้อนค่าดำเนินการ" oninput="calculate2();balance2();"/>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="Processfee" name="Vatcar" class="form-control form-control-sm" value="{{($data->Vat_car != null)?$data->Vat_car:0}}" placeholder="ป้อนค่าดำเนินการ" oninput="calculate2();balance2();" readonly/>
                                    @else
                                      <input type="text" id="Processfee" name="Vatcar" class="form-control form-control-sm" value="{{($data->Vat_car != null)?$data->Vat_car:0}}" placeholder="ป้อนค่าดำเนินการ" oninput="calculate2();balance2();"/>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ชำระต่องวด : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Paycar" name="Paycar"  value="{{$data->Pay_car}}" class="form-control form-control-sm" placeholder="-"/>
                                </div>
                                <!-- <div class="col-sm-2">
                                  <input type="text" id="Paycar_ori" name="Paycar_ori" class="form-control form-control-sm" placeholder="-"/>
                                </div>
                                <div class="col-sm-2">
                                  <input type="text" id="Paycar_new" name="Paycar_new" class="form-control form-control-sm" placeholder="-"/>
                                </div> -->
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ดอกเบี้ย/เดือน : </label>
                                <div class="col-sm-7">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Interestcar" name="Interestcar" value="{{$data->Interest_car}}" class="form-control form-control-sm" placeholder="ป้อนดอกเบี้ย" oninput="calculate2();balance2();"/>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="Interestcar" name="Interestcar" value="{{$data->Interest_car}}" class="form-control form-control-sm" placeholder="ป้อนดอกเบี้ย" oninput="calculate2();balance2();" readonly/>
                                    @else
                                      <input type="text" id="Interestcar" name="Interestcar" value="{{$data->Interest_car}}" class="form-control form-control-sm" placeholder="ป้อนดอกเบี้ย" oninput="calculate2();balance2();"/>
                                    @endif
                                  @endif
                                </div>
                                <label class="col-sm-1 col-form-label text-left">% </label>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">กำไรจากดอกเบี้ย : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Profit" name="Taxcar"  value="{{$data->Tax_car}}" class="form-control form-control-sm" placeholder="-" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ระยะเวลาผ่อน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="Timeslackencar" name="Timeslackencar" class="form-control form-control-sm"  oninput="calculate();calculate2();balance2();">
                                      <option value="" selected>--- ระยะเวลาผ่อน ---</option>
                                      <option value="6" {{ ($data->Timeslacken_car === '6') ? 'selected' : '' }}>6</option>
                                      <option value="12" {{ ($data->Timeslacken_car === '12') ? 'selected' : '' }}>12</option>
                                      <option value="18" {{ ($data->Timeslacken_car === '18') ? 'selected' : '' }}>18</option>
                                      <option value="24" {{ ($data->Timeslacken_car === '24') ? 'selected' : '' }}>24</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="Timeslackencar" name="Timeslackencar" value="{{$data->Timeslacken_car}}" class="form-control form-control-sm"  placeholder="ระยะเวลาผ่อน" readonly />
                                    @else
                                      <select id="Timeslackencar" name="Timeslackencar" class="form-control form-control-sm"  oninput="calculate();calculate2();balance2();">
                                        <option value="" selected>--- ระยะเวลาผ่อน ---</option>
                                        <option value="6" {{ ($data->Timeslacken_car === '6') ? 'selected' : '' }}>6</option>
                                        <option value="12" {{ ($data->Timeslacken_car === '12') ? 'selected' : '' }}>12</option>
                                        <option value="18" {{ ($data->Timeslacken_car === '18') ? 'selected' : '' }}>18</option>
                                        <option value="24" {{ ($data->Timeslacken_car === '24') ? 'selected' : '' }}>24</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ยอดรวมทั้งสัญญา : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Totalpay1car" name="Totalpay1car"  value="{{$data->Totalpay1_car}}" class="form-control form-control-sm" placeholder="-" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">แบบ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="statuscar" name="statuscar" class="form-control form-control-sm" >
                                      <option value="" selected>--- เลือกแบบ ---</option>
                                      <option value="กส.ค้ำไม่มีหลักทรัพย์" {{ ($data->status_car === 'กส.ค้ำไม่มีหลักทรัพย์') ? 'selected' : '' }}>กส.ค้ำไม่มีหลักทรัพย์</option>
                                      <option value="กส.ไม่ค้ำประกัน" {{ ($data->status_car === 'กส.ไม่ค้ำประกัน') ? 'selected' : '' }}>กส.ไม่ค้ำประกัน</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="statuscar" name="statuscar" value="{{$data->status_car}}" class="form-control form-control-sm"  placeholder="สถานะ" readonly />
                                    @else
                                      <select id="statuscar" name="statuscar" class="form-control form-control-sm" >
                                        <option value="" selected>--- เลือกแบบ ---</option>
                                        <option value="กส.ค้ำไม่มีหลักทรัพย์" {{ ($data->status_car === 'กส.ค้ำไม่มีหลักทรัพย์') ? 'selected' : '' }}>กส.ค้ำไม่มีหลักทรัพย์</option>
                                        <option value="กส.ไม่ค้ำประกัน" {{ ($data->status_car === 'กส.ไม่ค้ำประกัน') ? 'selected' : '' }}>กส.ไม่ค้ำประกัน</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">วันที่ชำระงวดแรก : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Dateduefirstcar" value="{{$data->Dateduefirst_car}}" class="form-control form-control-sm"  readonly placeholder="วันที่ชำระงวดแรก" />
                                </div>
                              </div>
                            </div>
                          </div>

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
                                  var Comprice = (parseInt(Topcar) - parseInt(P2Price)) * 0.02;
                                  $('#Commissioncar').val(addCommas(Comprice.toFixed(2)));
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
                                    $('#Commissioncar').val(addCommas(ResultPrice.toFixed(2)));
                                }
                            });
                          </script>

                          <hr />
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ผู้รับเงิน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Payeecar" value="{{$data->Payee_car}}" class="form-control form-control-sm"  placeholder="ผู้รับเงิน" />
                                  @else
                                    <input type="text" name="Payeecar" value="{{$data->Payee_car}}" class="form-control form-control-sm"  placeholder="ผู้รับเงิน" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">เลขที่บัญชี : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Accountbrancecar" value="{{$data->Accountbrance_car}}" class="form-control form-control-sm"  placeholder="เลขที่บัญชี" maxlength="15"/>
                                  @else
                                    <input type="text" name="Accountbrancecar" value="{{$data->Accountbrance_car}}" class="form-control form-control-sm"  placeholder="เลขที่บัญชี" maxlength="15" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ปชช.ผู้รับเงิน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="IDcardPayeecar" value="{{$data->IDcardPayee_car}}" class="form-control form-control-sm" placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="IDcardPayeecar" value="{{$data->IDcardPayee_car}}" class="form-control form-control-sm" placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">สาขา : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="branchbrancecar" value="{{$data->branchbrance_car}}" class="form-control form-control-sm"  placeholder="สาขาผู้รับเงิน" />
                                  @else
                                    <input type="text" name="branchbrancecar" value="{{$data->branchbrance_car}}" class="form-control form-control-sm"  placeholder="สาขาผู้รับเงิน" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">เบอร์โทรศัพท์ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Tellbrancecar" value="{{$data->Tellbrance_car}}" class="form-control form-control-sm"  placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="Tellbrancecar" value="{{$data->Tellbrance_car}}" class="form-control form-control-sm"  placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <hr>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">แนะนำ/นายหน้า : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Agentcar" name="Agentcar" value="{{$data->Agent_car}}" class="form-control form-control-sm"  placeholder="แนะนำ/นายหน้า" oninput="commission_P04();"/>
                                  @else
                                    <input type="text" id="Agentcar" name="Agentcar" value="{{$data->Agent_car}}" class="form-control form-control-sm"  placeholder="แนะนำ/นายหน้า" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }} oninput="commission_P04();"/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">เลขที่บัญชี : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Accountagentcar" value="{{$data->Accountagent_car}}" class="form-control form-control-sm"  placeholder="เลขที่บัญชี" maxlength="15"/>
                                  @else
                                    <input type="text" name="Accountagentcar" value="{{$data->Accountagent_car}}" class="form-control form-control-sm"  placeholder="เลขที่บัญชี" maxlength="15" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                  <label class="col-sm-3 col-form-label text-right text-xs">ปชช.ผู้แนะนำ/นายหน้า : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" id="IDAgentcar" name="IDAgentcar" value="{{$data->IDcardAgent_car}}" class="form-control form-control-sm"  placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                                    @else
                                      <input type="text" id="IDAgentcar" name="IDAgentcar" value="{{$data->IDcardAgent_car}}" class="form-control form-control-sm"  placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">สาขา : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="branchAgentcar" value="{{$data->branchAgent_car}}" class="form-control form-control-sm"  placeholder="สาขานายหน้า"/>
                                  @else
                                    <input type="text" name="branchAgentcar" value="{{$data->branchAgent_car}}" class="form-control form-control-sm"  placeholder="สาขานายหน้า" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              @if($data->Agent_car != NULL)
                                <div class="form-group row mb-0" id="ShowCom">
                              @else
                                <div class="form-group row mb-0" id="ShowCom" style="display:none;">
                              @endif
                                  <label class="col-sm-3 col-form-label text-right">ค่าคอม : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" id="Commissioncar" name="Commissioncar" value="{{number_format($data->Commission_car, 2)}}" class="form-control form-control-sm" placeholder="ค่าคอม" readonly/>
                                    @else
                                      <input type="text" id="Commissioncar" name="Commissioncar" value="{{number_format($data->Commission_car, 2)}}" class="form-control form-control-sm"  placeholder="ค่าคอม" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">เบอร์โทรศัพท์ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Tellagentcar" value="{{$data->Tellagent_car}}" class="form-control form-control-sm"  placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="Tellagentcar" value="{{$data->Tellagent_car}}" class="form-control form-control-sm"  placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
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

                          <div class="row">
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-0">
                                <label class="col-sm-3 col-form-label text-right">ประวัติการซื้อ/ค้ำ : </label>
                                <div class="col-sm-4">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="Purchasehistorycar" class="form-control form-control-sm">
                                      <option value="" selected>--- ซื้อ ---</option>
                                      <option value="0 คัน" {{ ($data->Purchasehistory_car === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                      <option value="1 คัน" {{ ($data->Purchasehistory_car === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                      <option value="2 คัน" {{ ($data->Purchasehistory_car === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                      <option value="3 คัน" {{ ($data->Purchasehistory_car === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                      <option value="4 คัน" {{ ($data->Purchasehistory_car === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                      <option value="5 คัน" {{ ($data->Purchasehistory_car === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                      <option value="6 คัน" {{ ($data->Purchasehistory_car === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                      <option value="7 คัน" {{ ($data->Purchasehistory_car === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                      <option value="8 คัน" {{ ($data->Purchasehistory_car === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                      <option value="9 คัน" {{ ($data->Purchasehistory_car === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                      <option value="10 คัน" {{ ($data->Purchasehistory_car === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                      <option value="11 คัน" {{ ($data->Purchasehistory_car === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                      <option value="12 คัน" {{ ($data->Purchasehistory_car === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                      <option value="13 คัน" {{ ($data->Purchasehistory_car === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                      <option value="14 คัน" {{ ($data->Purchasehistory_car === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                      <option value="15 คัน" {{ ($data->Purchasehistory_car === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                      <option value="16 คัน" {{ ($data->Purchasehistory_car === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                      <option value="17 คัน" {{ ($data->Purchasehistory_car === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                      <option value="18 คัน" {{ ($data->Purchasehistory_car === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                      <option value="19 คัน" {{ ($data->Purchasehistory_car === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                      <option value="20 คัน" {{ ($data->Purchasehistory_car === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="Purchasehistorycar" value="{{$data->Purchasehistory_car}}" class="form-control form-control-sm" placeholder="ซื้อ" readonly/>
                                    @else
                                      <select name="Purchasehistorycar" class="form-control form-control-sm">
                                        <option value="" selected>--- ซื้อ ---</option>
                                        <option value="0 คัน" {{ ($data->Purchasehistory_car === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                        <option value="1 คัน" {{ ($data->Purchasehistory_car === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                        <option value="2 คัน" {{ ($data->Purchasehistory_car === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                        <option value="3 คัน" {{ ($data->Purchasehistory_car === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                        <option value="4 คัน" {{ ($data->Purchasehistory_car === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                        <option value="5 คัน" {{ ($data->Purchasehistory_car === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                        <option value="6 คัน" {{ ($data->Purchasehistory_car === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                        <option value="7 คัน" {{ ($data->Purchasehistory_car === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                        <option value="8 คัน" {{ ($data->Purchasehistory_car === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                        <option value="9 คัน" {{ ($data->Purchasehistory_car === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                        <option value="10 คัน" {{ ($data->Purchasehistory_car === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                        <option value="11 คัน" {{ ($data->Purchasehistory_car === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                        <option value="12 คัน" {{ ($data->Purchasehistory_car === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                        <option value="13 คัน" {{ ($data->Purchasehistory_car === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                        <option value="14 คัน" {{ ($data->Purchasehistory_car === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                        <option value="15 คัน" {{ ($data->Purchasehistory_car === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                        <option value="16 คัน" {{ ($data->Purchasehistory_car === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                        <option value="17 คัน" {{ ($data->Purchasehistory_car === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                        <option value="18 คัน" {{ ($data->Purchasehistory_car === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                        <option value="19 คัน" {{ ($data->Purchasehistory_car === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                        <option value="20 คัน" {{ ($data->Purchasehistory_car === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                                <div class="col-sm-4">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="Supporthistorycar" class="form-control form-control-sm">
                                      <option value="" selected>--- ค้ำ ---</option>
                                      <option value="0 คัน" {{ ($data->Supporthistory_car === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                      <option value="1 คัน" {{ ($data->Supporthistory_car === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                      <option value="2 คัน" {{ ($data->Supporthistory_car === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                      <option value="3 คัน" {{ ($data->Supporthistory_car === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                      <option value="4 คัน" {{ ($data->Supporthistory_car === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                      <option value="5 คัน" {{ ($data->Supporthistory_car === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                      <option value="6 คัน" {{ ($data->Supporthistory_car === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                      <option value="7 คัน" {{ ($data->Supporthistory_car === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                      <option value="8 คัน" {{ ($data->Supporthistory_car === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                      <option value="9 คัน" {{ ($data->Supporthistory_car === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                      <option value="10 คัน" {{ ($data->Supporthistory_car === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                      <option value="11 คัน" {{ ($data->Supporthistory_car === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                      <option value="12 คัน" {{ ($data->Supporthistory_car === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                      <option value="13 คัน" {{ ($data->Supporthistory_car === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                      <option value="14 คัน" {{ ($data->Supporthistory_car === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                      <option value="15 คัน" {{ ($data->Supporthistory_car === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                      <option value="16 คัน" {{ ($data->Supporthistory_car === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                      <option value="17 คัน" {{ ($data->Supporthistory_car === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                      <option value="18 คัน" {{ ($data->Supporthistory_car === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                      <option value="19 คัน" {{ ($data->Supporthistory_car === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                      <option value="20 คัน" {{ ($data->Supporthistory_car === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="Supporthistorycar" value="{{$data->Purchasehistory_car}}" class="form-control form-control-sm" placeholder="ค้ำ" readonly/>
                                    @else
                                      <select name="Supporthistorycar" class="form-control form-control-sm">
                                        <option value="" selected>--- ค้ำ ---</option>
                                        <option value="0 คัน" {{ ($data->Supporthistory_car === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                        <option value="1 คัน" {{ ($data->Supporthistory_car === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                        <option value="2 คัน" {{ ($data->Supporthistory_car === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                        <option value="3 คัน" {{ ($data->Supporthistory_car === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                        <option value="4 คัน" {{ ($data->Supporthistory_car === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                        <option value="5 คัน" {{ ($data->Supporthistory_car === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                        <option value="6 คัน" {{ ($data->Supporthistory_car === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                        <option value="7 คัน" {{ ($data->Supporthistory_car === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                        <option value="8 คัน" {{ ($data->Supporthistory_car === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                        <option value="9 คัน" {{ ($data->Supporthistory_car === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                        <option value="10 คัน" {{ ($data->Supporthistory_car === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                        <option value="11 คัน" {{ ($data->Supporthistory_car === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                        <option value="12 คัน" {{ ($data->Supporthistory_car === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                        <option value="13 คัน" {{ ($data->Supporthistory_car === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                        <option value="14 คัน" {{ ($data->Supporthistory_car === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                        <option value="15 คัน" {{ ($data->Supporthistory_car === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                        <option value="16 คัน" {{ ($data->Supporthistory_car === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                        <option value="17 คัน" {{ ($data->Supporthistory_car === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                        <option value="18 คัน" {{ ($data->Supporthistory_car === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                        <option value="19 คัน" {{ ($data->Supporthistory_car === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                        <option value="20 คัน" {{ ($data->Supporthistory_car === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <hr>
                          <div class="row">
                            <div class="col-md-6">
                              <h5 class="text-center"><font color="red"><b>เพิ่มรูปหน้าบัญชี</b></font></h5>
                              @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                <div class="file-loading">
                                  <input id="Account_image" type="file" name="Account_image" accept="image/*" data-min-file-count="1" multiple>
                                </div>
                              @else
                                @if($data->Approvers_car == Null)
                                  <div class="file-loading">
                                    <input id="Account_image" type="file" name="Account_image" accept="image/*" data-min-file-count="1" multiple>
                                  </div>
                                @endif
                              @endif
                            </div>

                            <div class="col-6">
                              <br><p></p>
                              <div class="card card-primary">
                                <div class="card-header">
                                  <div class="card-title">
                                    รูปภาพหน้าบัญชี
                                  </div>
                                </div>
                                <div class="card-body">

                                  @if($data->License_car != NULL)
                                    @php
                                      $Setlisence = $data->License_car;
                                    @endphp
                                  @endif

                                  <div class="row">
                                    @if(substr($data->createdBuyers_at,0,10) < $Currdate)
                                      @if ($data->AccountImage_car != NULL)
                                        <div class="col-sm-2">
                                          <a href="{{ asset('upload-image/'.$data->AccountImage_car) }}" class="MagicZoom" data-gallery="gallery" data-options="hint:true; zoomMode:magnifier; variableZoom: true" style="width: 300px; height: auto;">
                                            <img src="{{ asset('upload-image/'.$data->AccountImage_car) }}">
                                          </a>
                                        </div>
                                      @endif
                                    @else
                                      @if ($data->AccountImage_car != NULL)
                                        <div class="col-sm-2">
                                          <a href="{{ asset('upload-image/'.$Setlisence.'/'.$data->AccountImage_car) }}" class="MagicZoom" data-gallery="gallery" data-options="hint:true; zoomMode:magnifier; variableZoom: true" style="width: 300px; height: auto;">
                                            <img src="{{ asset('upload-image/'.$Setlisence.'/'.$data->AccountImage_car) }}">
                                          </a>
                                        </div>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" id="balancePrice" name="balancePrice" value="{{number_format($data->Top_car,2)}}" class="form-control form-control-sm" placeholder="คงเหลือ" readonly/>
                        </div>
                        <div class="tab-pane fade" id="Sub-tab5" role="tabpanel" aria-labelledby="Sub-custom-tab5">
                          <h5 class="text-center"><b>ข้อมูลลงพื้นที ตรวจสอบ</b></h5>
                          <p></p>

                          <div class="row">
                            <div class="col-md-4">
                              <div class="card card-danger">
                                <div class="card-header">
                                  <h3 class="card-title">รูปภาพผู้เช่าซื้อ</h3>
                                  <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize" title="ขยาย">
                                      <i class="fas fa-expand"></i>
                                    </button>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <div class="form-group">
                                    <div class="file-loading">
                                      <input id="image_checker_1" type="file" name="image_checker_1[]" accept="image/*" data-min-file-count="1" multiple>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-12">
                                  <div class="card card-primary">
                                    <div class="card-header">
                                      <div class="card-title">
                                        รูปภาพผู้เช่าซื้อ
                                      </div>
                                      @if($data->License_car != NULL)
                                        @php
                                          $Setlisence = $data->License_car;
                                        @endphp
                                      @endif
                                      <div class="card-tools">
                                        <a href="{{ action('AnalysController@deleteImageAll',[$id,$Setlisence]) }}?type=2" class="pull-left DeleteImage">
                                          <i class="far fa-trash-alt"></i>
                                        </a>
                                      </div>
                                    </div>
                                    
                                    <div class="card-body">
                                      <div class="row">
                                        @foreach($dataImage as $key => $images)
                                          @if($images->Type_fileimage == "2")
                                            <div class="col-sm-2">
                                              <a href="{{ asset('upload-image/'.$Setlisence.'/'.$images->Name_fileimage) }}" data-toggle="lightbox" data-title="ภาพผู้เช่าซื้อ">
                                                <img src="{{ asset('upload-image/'.$Setlisence.'/'.$images->Name_fileimage) }}" class="img-fluid mb-2" alt="white sample">
                                              </a>
                                            </div>
                                          @endif
                                        @endforeach
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
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <textarea class="form-control" name="BuyerNote" rows="3" placeholder="ป้อนหมายเหตุ...">{{$data->Buyer_note}}</textarea>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <textarea class="form-control" name="BuyerNote" rows="3" placeholder="ป้อนหมายเหตุ..." readonly>{{$data->Buyer_note}}</textarea>
                                      @else
                                        <textarea class="form-control" name="BuyerNote" rows="3" placeholder="ป้อนหมายเหตุ...">{{$data->Buyer_note}}</textarea>
                                      @endif
                                    @endif
                                  </div>

                                </div> 
                                 
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="card card-danger">
                                <div class="card-header">
                                  <h3 class="card-title">รูปภาพผู้ค้ำ</h3>
                  
                                  <div class="card-tools">
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

                                <div class="col-12">
                                  <div class="card card-primary">
                                    <div class="card-header">
                                      <div class="card-title">
                                        รูปภาพผู้ค้ำ
                                      </div>
                                      @if($data->License_car != NULL)
                                        @php
                                          $Setlisence = $data->License_car;
                                        @endphp
                                      @endif
                                      <div class="card-tools">
                                        <a href="{{ action('AnalysController@deleteImageAll',[$id,$Setlisence]) }}?type=3" class="pull-left DeleteImage">
                                          <i class="far fa-trash-alt"></i>
                                        </a>
                                      </div>
                                    </div>
                                    
                                    <div class="card-body">
                                      <div class="row">
                                        @foreach($dataImage as $key => $images)
                                          @if($images->Type_fileimage == "3")
                                            <div class="col-sm-2">
                                              <a href="{{ asset('upload-image/'.$Setlisence.'/'.$images->Name_fileimage) }}" data-toggle="lightbox" data-title="ภาพผู้ค้ำ">
                                                <img src="{{ asset('upload-image/'.$Setlisence.'/'.$images->Name_fileimage) }}" class="img-fluid mb-2" alt="white sample">
                                              </a>
                                            </div>
                                          @endif
                                        @endforeach
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
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <textarea class="form-control" name="SupportNote" rows="3" placeholder="ป้อนหมายเหตุ...">{{$data->Support_note}}</textarea>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <textarea class="form-control" name="SupportNote" rows="3" placeholder="ป้อนหมายเหตุ..." readonly>{{$data->Support_note}}</textarea>
                                      @else
                                        <textarea class="form-control" name="SupportNote" rows="3" placeholder="ป้อนหมายเหตุ...">{{$data->Support_note}}</textarea>
                                      @endif
                                    @endif
                                  </div>

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
                                      <div id="myLat" style="">
                                          <div class="form-inline float-left">
                                            <label>ตำแหน่งที่ตั้งผู้เช่าซื้อ (A) : </label>
                                          </div>
                                            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                              <input type="text" id="Buyer_latlong" name="Buyer_latlong" class="form-control" value="{{ $data->Buyer_latlong }}"/>
                                            @else
                                              @if($GetDocComplete != Null)
                                                <input type="text" id="Buyer_latlong" name="Buyer_latlong" class="form-control" value="{{ $data->Buyer_latlong }}" readonly/>
                                              @else
                                                <input type="text" id="Buyer_latlong" name="Buyer_latlong" class="form-control" value="{{ $data->Buyer_latlong }}"/>
                                              @endif
                                            @endif
                                            <br>
                                          <div class="form-inline float-left">
                                            <label>ตำแหน่งที่ตั้งผู้ค้ำ (B): </label>
                                          </div>
                                            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                               <input type="text" id="Support_latlong" name="Support_latlong" class="form-control" value="{{ $data->Support_latlong }}"/>
                                            @else
                                              @if($GetDocComplete != Null)
                                                 <input type="text" id="Support_latlong" name="Support_latlong" class="form-control" value="{{ $data->Support_latlong }}" readonly/>
                                              @else
                                                 <input type="text" id="Support_latlong" name="Support_latlong" class="form-control" value="{{ $data->Support_latlong }}"/>
                                              @endif
                                            @endif
                                      </div>
                                    </div>
                                  </div>
                                    <hr>
                                    <div id="map" style="width:100%;height:50vh"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="Sub-tab6" role="tabpanel" aria-labelledby="Sub-custom-tab6">
                           <h5 class="text-center"><b>ที่มาของรายได้</b></h5>
                           <p></p>
                           <div class="row">
                            <div class="col-md-6">
                              <div class="card card-info">
                                <div class="card-header">
                                  <h3 class="card-title">รายได้ผู้เช่าซื้อ</h3>
                  
                                  <div class="card-tools">
                                    <!-- <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button> -->
                                  </div>
                                </div>
                                <div class="card-body">
                                  <div class="form-group">
                                    <div class="form-group row mb-0">
                                      <label class="col-sm-4 col-form-label text-right">อาชีพ : </label>
                                      <div class="col-sm-8">
                                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                          <input type="text" name="Careerbuyer" value="{{ $data->Career_buyer }}" class="form-control form-control-sm"  placeholder="เลือกอาชีพ"/>
                                        @else
                                          <input type="text" name="Careerbuyer" value="{{ $data->Career_buyer }}" class="form-control form-control-sm"  placeholder="เลือกอาชีพ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                        @endif
                                      </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                      <label class="col-sm-4 col-form-label text-right">รายได้ : </label>
                                      <div class="col-sm-8">
                                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                          <input type="text" id="Incomebuyer" name="Incomebuyer" value="{{ $data->Income_buyer }}" class="form-control form-control-sm"  placeholder="เลือกรายได้" />
                                        @else
                                          <input type="text" id="Incomebuyer" name="Incomebuyer" value="{{ $data->Income_buyer }}" class="form-control form-control-sm"  placeholder="เลือกรายได้"  {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                        @endif
                                      </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                      <label class="col-sm-4 col-form-label text-right">หักค่าใช้จ่าย : </label>
                                      <div class="col-sm-8">
                                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                          <input type="text" id="Beforeincome" name="Beforeincome" value="{{ number_format($data->BeforeIncome_buyer,0) }}" class="form-control form-control-sm"  placeholder="ก่อนหักค่าใช้จ่าย" onchange="income();" />
                                        @else
                                          <input type="text" id="Beforeincome" name="Beforeincome" value="{{ number_format($data->BeforeIncome_buyer,0) }}" class="form-control form-control-sm"  placeholder="ก่อนหักค่าใช้จ่าย" onchange="income();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }} />
                                        @endif
                                      </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                      <label class="col-sm-4 col-form-label text-right">รายได้หลังหักค่าใช้จ่าย : </label>
                                      <div class="col-sm-8">
                                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                          <input type="text" id="Afterincome" name="Afterincome" value="{{ number_format($data->AfterIncome_buyer,0) }}" class="form-control form-control-sm"  placeholder="ก่อนหักค่าใช้จ่าย" onchange="income();" />
                                        @else
                                          <input type="text" id="Afterincome" name="Afterincome" value="{{ number_format($data->AfterIncome_buyer,0) }}" class="form-control form-control-sm"  placeholder="ก่อนหักค่าใช้จ่าย" onchange="income();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }} />
                                        @endif
                                      </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                      <label class="col-sm-4 col-form-label text-right">หมายเหตุ : </label>
                                      <div class="col-sm-8">
                                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                          <textarea class="form-control form-control-sm" name="BuyerIncomeNote" rows="3" placeholder="ป้อนหมายเหตุ...">{{$data->MemoIncome_buyer}}</textarea>
                                        @else
                                          @if($GetDocComplete != Null)
                                            <textarea class="form-control form-control-sm" name="BuyerIncomeNote" rows="3" placeholder="ป้อนหมายเหตุ..." readonly>{{$data->MemoIncome_buyer}}</textarea>
                                          @else
                                            <textarea class="form-control form-control-sm" name="BuyerIncomeNote" rows="3" placeholder="ป้อนหมายเหตุ...">{{$data->MemoIncome_buyer}}</textarea>
                                          @endif
                                        @endif
                                      </div>
                                    </div>
                                    <div class="file-loading">
                                      <input id="image_income_1" type="file" name="image_income_1[]" accept="image/*" data-min-file-count="1" multiple>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-12">
                                  <div class="card card-primary">
                                    <div class="card-header">
                                      <div class="card-title">
                                        รูปภาพรายได้ผู้เช่าซื้อ
                                      </div>
                                      @if($data->License_car != NULL)
                                        @php
                                          $Setlisence = $data->License_car;
                                        @endphp
                                      @endif
                                      <div class="card-tools">
                                        <a href="{{ action('AnalysController@deleteImageAll',[$id,$Setlisence]) }}?type=4" class="pull-left DeleteImage">
                                          <i class="far fa-trash-alt"></i>
                                        </a>
                                      </div>
                                    </div>
                                    
                                    <div class="card-body">
                                      <div class="row">
                                        @foreach($dataImage as $key => $images)
                                          @if($images->Type_fileimage == "4")
                                            <div class="col-sm-2">
                                              <a href="{{ asset('upload-image/'.$Setlisence.'/'.$images->Name_fileimage) }}" data-toggle="lightbox" data-title="ภาพผู้เช่าซื้อ">
                                                <img src="{{ asset('upload-image/'.$Setlisence.'/'.$images->Name_fileimage) }}" class="img-fluid mb-2" alt="white sample">
                                              </a>
                                            </div>
                                          @endif
                                        @endforeach
                                      </div>
                                    </div>
                                  </div>

                                </div> 
                                 
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="card card-info">
                                <div class="card-header">
                                  <h3 class="card-title">รายได้ผู้ค้ำ</h3>
                  
                                  <div class="card-tools">
                                    <!-- <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button> -->
                                  </div>
                                </div>
                                <div class="card-body">
                                  <div class="form-group">
                                    <div class="form-group row mb-0">
                                      <label class="col-sm-4 col-form-label text-right">อาชีพ : </label>
                                      <div class="col-sm-8">
                                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                          <input type="text" name="careerSP" value="{{$data->career_SP}}" class="form-control form-control-sm" placeholder="อาชีพ"/>
                                        @else
                                          <input type="text" name="careerSP" value="{{$data->career_SP}}" class="form-control form-control-sm" placeholder="อาชีพ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                        @endif
                                      </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                      <label class="col-sm-4 col-form-label text-right">รายได้ : </label>
                                      <div class="col-sm-8">
                                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                          <input type="text" id="incomeSP" name="incomeSP" value="{{ $data->income_SP }}" class="form-control form-control-sm" placeholder="รายได้" />
                                        @else
                                          <input type="text" id="incomeSP" name="incomeSP" value="{{ $data->income_SP }}" class="form-control form-control-sm" placeholder="รายได้"  {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                        @endif
                                      </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                      <label class="col-sm-4 col-form-label text-right">หมายเหตุ : </label>
                                      <div class="col-sm-8">
                                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                          <textarea class="form-control form-control-sm" name="SupportIncomeNote" rows="3" placeholder="ป้อนหมายเหตุ...">{{$data->MemoIncome_SP}}</textarea>
                                        @else
                                          @if($GetDocComplete != Null)
                                            <textarea class="form-control form-control-sm" name="SupportIncomeNote" rows="3" placeholder="ป้อนหมายเหตุ..." readonly>{{$data->MemoIncome_SP}}</textarea>
                                          @else
                                            <textarea class="form-control form-control-sm" name="SupportIncomeNote" rows="3" placeholder="ป้อนหมายเหตุ...">{{$data->MemoIncome_SP}}</textarea>
                                          @endif
                                        @endif
                                      </div>
                                    </div>
                                    <br><br><br>
                                    <div class="file-loading">
                                      <input id="image_income_2" type="file" name="image_income_2[]" accept="image/*" data-min-file-count="1" multiple>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-12">
                                  <div class="card card-primary">
                                    <div class="card-header">
                                      <div class="card-title">
                                        รูปภาพรายได้ผู้ค้ำ
                                      </div>
                                      @if($data->License_car != NULL)
                                        @php
                                          $Setlisence = $data->License_car;
                                        @endphp
                                      @endif
                                      <div class="card-tools">
                                        <a href="{{ action('AnalysController@deleteImageAll',[$id,$Setlisence]) }}?type=5" class="pull-left DeleteImage">
                                          <i class="far fa-trash-alt"></i>
                                        </a>
                                      </div>
                                    </div>
                                    
                                    <div class="card-body">
                                      <div class="row">
                                        @foreach($dataImage as $key => $images)
                                          @if($images->Type_fileimage == "5")
                                            <div class="col-sm-2">
                                              <a href="{{ asset('upload-image/'.$Setlisence.'/'.$images->Name_fileimage) }}" data-toggle="lightbox" data-title="ภาพผู้ค้ำ">
                                                <img src="{{ asset('upload-image/'.$Setlisence.'/'.$images->Name_fileimage) }}" class="img-fluid mb-2" alt="white sample">
                                              </a>
                                            </div>
                                          @endif
                                        @endforeach
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
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">ชื่อ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="nameSP2" value="{{$data->name_SP2}}" class="form-control" placeholder="ชื่อ" />
                                      @else
                                          <input type="text" name="nameSP2" value="{{$data->name_SP2}}" class="form-control" placeholder="ชื่อ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">นามสกุล : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="lnameSP2" value="{{$data->lname_SP2}}" class="form-control" placeholder="นามสกุล" />
                                      @else
                                        <input type="text" name="lnameSP2" value="{{$data->lname_SP2}}" class="form-control" placeholder="นามสกุล" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">ชื่อเล่น : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="niknameSP2" value="{{$data->nikname_SP2}}" class="form-control" placeholder="ชื่อเล่น" />
                                      @else
                                        <input type="text" name="niknameSP2" value="{{$data->nikname_SP2}}" class="form-control" placeholder="ชื่อเล่น" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">สถานะ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="statusSP2" class="form-control">
                                          <option value="" selected>--- สถานะ ---</option>
                                          <option value="โสด" {{ ($data->status_SP2 === 'โสด') ? 'selected' : '' }}>โสด</option>
                                          <option value="สมรส" {{ ($data->status_SP2 === 'สมรส') ? 'selected' : '' }}>สมรส</option>
                                          <option value="หย่าร้าง" {{ ($data->status_SP2 === 'หย่าร้าง') ? 'selected' : '' }}>หย่าร้าง</option>
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="statusSP2" value="{{$data->status_SP2}}" class="form-control" placeholder="เลือกสถานะ" readonly/>
                                        @else
                                          <select name="statusSP2" class="form-control">
                                            <option value="" selected>--- สถานะ ---</option>
                                            <option value="โสด" {{ ($data->status_SP2 === 'โสด') ? 'selected' : '' }}>โสด</option>
                                            <option value="สมรส" {{ ($data->status_SP2 === 'สมรส') ? 'selected' : '' }}>สมรส</option>
                                            <option value="หย่าร้าง" {{ ($data->status_SP2 === 'หย่าร้าง') ? 'selected' : '' }}>หย่าร้าง</option>
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">เบอร์โทร : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="telSP2" value="{{$data->tel_SP2}}" class="form-control" placeholder="เบอร์โทร" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask=""/>
                                      @else
                                        <input type="text" name="telSP2" value="{{$data->tel_SP2}}" class="form-control" placeholder="เบอร์โทร" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">ความสัมพันธ์ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="relationSP2" class="form-control">
                                          <option value="" selected>--- ความสัมพันธ์ ---</option>
                                          <option value="พี่น้อง" {{ ($data->relation_SP2 === 'พี่น้อง') ? 'selected' : '' }}>พี่น้อง</option>
                                          <option value="ญาติ" {{ ($data->relation_SP2 === 'ญาติ') ? 'selected' : '' }}>ญาติ</option>
                                          <option value="เพื่อน" {{ ($data->relation_SP2 === 'เพื่อน') ? 'selected' : '' }}>เพื่อน</option>
                                          <option value="บิดา" {{ ($data->relation_SP2 === 'บิดา') ? 'selected' : '' }}>บิดา</option>
                                          <option value="มารดา" {{ ($data->relation_SP2 === 'มารดา') ? 'selected' : '' }}>มารดา</option>
                                          <option value="ตำบลเดี่ยวกัน" {{ ($data->relation_SP2 === 'ตำบลเดี่ยวกัน') ? 'selected' : '' }}>ตำบลเดี่ยวกัน</option>
                                          <option value="จ้างค้ำ(ไม่รู้จักกัน)" {{ ($data->relation_SP2 === 'จ้างค้ำ(ไม่รู้จักกัน)') ? 'selected' : '' }}>จ้างค้ำ(ไม่รู้จักกัน)</option>
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="relationSP2" value="{{$data->relation_SP2}}" class="form-control" placeholder="เลือกความสัมพันธ์" readonly/>
                                        @else
                                          <select name="relationSP2" class="form-control">
                                            <option value="" selected>--- ความสัมพันธ์ ---</option>
                                            <option value="พี่น้อง" {{ ($data->relation_SP2 === 'พี่น้อง') ? 'selected' : '' }}>พี่น้อง</option>
                                            <option value="ญาติ" {{ ($data->relation_SP2 === 'ญาติ') ? 'selected' : '' }}>ญาติ</option>
                                            <option value="เพื่อน" {{ ($data->relation_SP2 === 'เพื่อน') ? 'selected' : '' }}>เพื่อน</option>
                                            <option value="บิดา" {{ ($data->relation_SP2 === 'บิดา') ? 'selected' : '' }}>บิดา</option>
                                            <option value="มารดา" {{ ($data->relation_SP2 === 'มารดา') ? 'selected' : '' }}>มารดา</option>
                                            <option value="ตำบลเดี่ยวกัน" {{ ($data->relation_SP2 === 'ตำบลเดี่ยวกัน') ? 'selected' : '' }}>ตำบลเดี่ยวกัน</option>
                                            <option value="จ้างค้ำ(ไม่รู้จักกัน)" {{ ($data->relation_SP2 === 'จ้างค้ำ(ไม่รู้จักกัน)') ? 'selected' : '' }}>จ้างค้ำ(ไม่รู้จักกัน)</option>
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">เลขบัตรปชช.ผู้ค่ำ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="idcardSP2" value="{{$data->idcard_SP2}}" class="form-control" placeholder="เลขบัตรประชาชนผู้ค่ำ" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                                      @else
                                        <input type="text" name="idcardSP2" value="{{$data->idcard_SP2}}" class="form-control" placeholder="เลขบัตรประชาชนผู้ค่ำ" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div> 
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">คู่สมรส : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="mateSP2" value="{{$data->mate_SP2}}" class="form-control" placeholder="คู่สมรส" />
                                      @else
                                        <input type="text" name="mateSP2" value="{{$data->mate_SP2}}" class="form-control" placeholder="คู่สมรส" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">ที่อยู่ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="addSP2" class="form-control">
                                          <option value="" selected>--- ที่อยู่ ---</option>
                                          <option value="ตามทะเบียนบ้าน" {{ ($data->add_SP2 === 'ตามทะเบียนบ้าน') ? 'selected' : '' }}>ตามทะเบียนบ้าน</option>
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="addSP2" value="{{$data->add_SP2}}" class="form-control" placeholder="เลือกที่อยู่" readonly/>
                                        @else
                                          <select name="addSP2" class="form-control">
                                            <option value="" selected>--- ที่อยู่ ---</option>
                                            <option value="ตามทะเบียนบ้าน" {{ ($data->add_SP2 === 'ตามทะเบียนบ้าน') ? 'selected' : '' }}>ตามทะเบียนบ้าน</option>
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">ที่อยู่ปัจจุบัน/จัดส่งเอกสาร : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="addnowSP2" value="{{$data->addnow_SP2}}" class="form-control" placeholder="ที่อยู่ปัจจุบัน/จัดส่งเอกสาร" />
                                      @else
                                        <input type="text" name="addnowSP2" value="{{$data->addnow_SP2}}" class="form-control" placeholder="ที่อยู่ปัจจุบัน/จัดส่งเอกสาร" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">รายละเอียดที่อยู่ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="statusaddSP2" value="{{$data->statusadd_SP2}}" class="form-control" placeholder="รายละเอียดที่อยู่" />
                                      @else
                                        <input type="text" name="statusaddSP2" value="{{$data->statusadd_SP2}}" class="form-control" placeholder="รายละเอียดที่อยู่" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">สถานที่ทำงาน : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="workplaceSP2" value="{{$data->workplace_SP2}}" class="form-control" placeholder="สถานที่ทำงาน" />
                                      @else
                                        <input type="text" name="workplaceSP2" value="{{$data->workplace_SP2}}" class="form-control" placeholder="สถานที่ทำงาน" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">ลักษณะบ้าน : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="houseSP2" class="form-control">
                                          <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                          <option value="บ้านตึก 1 ชั้น" {{ ($data->house_SP2 === 'บ้านตึก 1 ชั้น') ? 'selected' : '' }}>บ้านตึก 1 ชั้น</option>
                                          <option value="บ้านตึก 2 ชั้น" {{ ($data->house_SP2 === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                          <option value="บ้านไม้ 1 ชั้น" {{ ($data->house_SP2 === 'บ้านไม้ 1 ชั้น') ? 'selected' : '' }}>บ้านไม้ 1 ชั้น</option>
                                          <option value="บ้านตึก 2 ชั้น" {{ ($data->house_SP2 === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                          <option value="บ้านเดี่ยว" {{ ($data->house_SP2 === 'บ้านเดี่ยว') ? 'selected' : '' }}>บ้านเดี่ยว</option>
                                          <option value="แฟลต" {{ ($data->house_SP2 === 'แฟลต') ? 'selected' : '' }}>แฟลต</option>
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="houseSP2" value="{{$data->house_SP2}}" class="form-control" placeholder="เลือกลักษณะบ้าน" readonly/>
                                        @else
                                          <select name="houseSP2" class="form-control">
                                            <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                            <option value="บ้านตึก 1 ชั้น" {{ ($data->house_SP2 === 'บ้านตึก 1 ชั้น') ? 'selected' : '' }}>บ้านตึก 1 ชั้น</option>
                                            <option value="บ้านตึก 2 ชั้น" {{ ($data->house_SP2 === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                            <option value="บ้านไม้ 1 ชั้น" {{ ($data->house_SP2 === 'บ้านไม้ 1 ชั้น') ? 'selected' : '' }}>บ้านไม้ 1 ชั้น</option>
                                            <option value="บ้านตึก 2 ชั้น" {{ ($data->house_SP2 === 'บ้านตึก 2 ชั้น') ? 'selected' : '' }}>บ้านตึก 2 ชั้น</option>
                                            <option value="บ้านเดี่ยว" {{ ($data->house_SP2 === 'บ้านเดี่ยว') ? 'selected' : '' }}>บ้านเดี่ยว</option>
                                            <option value="แฟลต" {{ ($data->house_SP2 === 'แฟลต') ? 'selected' : '' }}>แฟลต</option>
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">ประเภทหลักทรัพย์ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="securitiesSP2" class="form-control">
                                          <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                          <option value="โฉนด" {{ ($data->securities_SP2 === 'โฉนด') ? 'selected' : '' }}>โฉนด</option>
                                          <option value="นส.3" {{ ($data->securities_SP2 === 'นส.3') ? 'selected' : '' }}>นส.3</option>
                                          <option value="นส.3 ก" {{ ($data->securities_SP2 === 'นส.3 ก') ? 'selected' : '' }}>นส.3 ก</option>
                                          <option value="นส.4" {{ ($data->securities_SP2 === 'นส.4') ? 'selected' : '' }}>นส.4</option>
                                          <option value="นส.4 จ" {{ ($data->securities_SP2 === 'นส.4 จ') ? 'selected' : '' }}>นส.4 จ</option>
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                        <input type="text" name="securitiesSP2" value="{{$data->securities_SP2}}" class="form-control" placeholder="ประเภทหลักทรัพย์" readonly/>
                                        @else
                                          <select name="securitiesSP2" class="form-control">
                                            <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                            <option value="โฉนด" {{ ($data->securities_SP2 === 'โฉนด') ? 'selected' : '' }}>โฉนด</option>
                                            <option value="นส.3" {{ ($data->securities_SP2 === 'นส.3') ? 'selected' : '' }}>นส.3</option>
                                            <option value="นส.3 ก" {{ ($data->securities_SP2 === 'นส.3 ก') ? 'selected' : '' }}>นส.3 ก</option>
                                            <option value="นส.4" {{ ($data->securities_SP2 === 'นส.4') ? 'selected' : '' }}>นส.4</option>
                                            <option value="นส.4 จ" {{ ($data->securities_SP2 === 'นส.4 จ') ? 'selected' : '' }}>นส.4 จ</option>
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">เลขที่โฉนด : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="deednumberSP2" value="{{$data->deednumber_SP2}}" class="form-control" placeholder="เลขที่โฉนด" />
                                      @else
                                        <input type="text" name="deednumberSP2" value="{{$data->deednumber_SP2}}" class="form-control" placeholder="เลขที่โฉนด" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">เนื้อที่ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="areaSP2" value="{{$data->area_SP2}}" class="form-control" placeholder="เนื้อที่" data-inputmask="&quot;mask&quot;:&quot;99-9-99&quot;" data-mask=""/>
                                      @else
                                        <input type="text" name="areaSP2" value="{{$data->area_SP2}}" class="form-control" placeholder="เนื้อที่" data-inputmask="&quot;mask&quot;:&quot;99-9-99&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">ประเภทบ้าน : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="housestyleSP2" class="form-control">
                                          <option value="" selected>--- ประเภทบ้าน ---</option>
                                          <option value="ของตนเอง" {{ ($data->housestyle_SP2 === 'ของตนเอง') ? 'selected' : '' }}>ของตนเอง</option>
                                          <option value="อาศัยบิดา-มารดา" {{ ($data->housestyle_SP2 === 'อาศัยบิดา-มารดา') ? 'selected' : '' }}>อาศัยบิดา-มารดา</option>
                                          <option value="อาศัยผู้อื่น" {{ ($data->housestyle_SP2 === 'อาศัยผู้อื่น') ? 'selected' : '' }}>อาศัยผู้อื่น</option>
                                          <option value="บ้านพักราชการ" {{ ($data->housestyle_SP2 === 'บ้านพักราชการ') ? 'selected' : '' }}>บ้านพักราชการ</option>
                                          <option value="บ้านเช่า" {{ ($data->housestyle_SP2 === 'บ้านเช่า') ? 'selected' : '' }}>บ้านเช่า</option>
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="housestyleSP2" value="{{$data->housestyle_SP2}}" class="form-control" placeholder="ประเภทบ้าน" readonly/>
                                        @else
                                          <select name="housestyleSP2" class="form-control">
                                            <option value="" selected>--- ประเภทบ้าน ---</option>
                                            <option value="ของตนเอง" {{ ($data->housestyle_SP2 === 'ของตนเอง') ? 'selected' : '' }}>ของตนเอง</option>
                                            <option value="อาศัยบิดา-มารดา" {{ ($data->housestyle_SP2 === 'อาศัยบิดา-มารดา') ? 'selected' : '' }}>อาศัยบิดา-มารดา</option>
                                            <option value="อาศัยผู้อื่น" {{ ($data->housestyle_SP2 === 'อาศัยผู้อื่น') ? 'selected' : '' }}>อาศัยผู้อื่น</option>
                                            <option value="บ้านพักราชการ" {{ ($data->housestyle_SP2 === 'บ้านพักราชการ') ? 'selected' : '' }}>บ้านพักราชการ</option>
                                            <option value="บ้านเช่า" {{ ($data->housestyle_SP2 === 'บ้านเช่า') ? 'selected' : '' }}>บ้านเช่า</option>
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">อาชีพ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="careerSP2" value="{{$data->career_SP2}}" class="form-control" placeholder="อาชีพ"/>
                                      @else
                                        <input type="text" name="careerSP2" value="{{$data->career_SP2}}" class="form-control" placeholder="อาชีพ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">รายได้ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" id="incomeSP2" name="incomeSP2" value="{{ number_format($data->income_SP2,0) }}" class="form-control" placeholder="รายได้" oninput="income();"/>
                                      @else
                                        <input type="text" id="incomeSP2" name="incomeSP2" value="{{ number_format($data->income_SP2,0) }}" class="form-control" placeholder="รายได้" oninput="income();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">ประวัติซื้อ : </label>
                                    <div class="col-sm-4">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="puchaseSP2" class="form-control">
                                          <option value="" selected>--- ซื้อ ---</option>
                                          <option value="0 คัน" {{ ($data->puchase_SP2 === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                          <option value="1 คัน" {{ ($data->puchase_SP2 === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                          <option value="2 คัน" {{ ($data->puchase_SP2 === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                          <option value="3 คัน" {{ ($data->puchase_SP2 === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                          <option value="4 คัน" {{ ($data->puchase_SP2 === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                          <option value="5 คัน" {{ ($data->puchase_SP2 === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                          <option value="6 คัน" {{ ($data->puchase_SP2 === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                          <option value="7 คัน" {{ ($data->puchase_SP2 === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                          <option value="8 คัน" {{ ($data->puchase_SP2 === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                          <option value="9 คัน" {{ ($data->puchase_SP2 === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                          <option value="10 คัน" {{ ($data->puchase_SP2 === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                          <option value="11 คัน" {{ ($data->puchase_SP2 === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                          <option value="12 คัน" {{ ($data->puchase_SP2 === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                          <option value="13 คัน" {{ ($data->puchase_SP2 === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                          <option value="14 คัน" {{ ($data->puchase_SP2 === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                          <option value="15 คัน" {{ ($data->puchase_SP2 === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                          <option value="16 คัน" {{ ($data->puchase_SP2 === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                          <option value="17 คัน" {{ ($data->puchase_SP2 === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                          <option value="18 คัน" {{ ($data->puchase_SP2 === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                          <option value="19 คัน" {{ ($data->puchase_SP2 === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                          <option value="20 คัน" {{ ($data->puchase_SP2 === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="puchaseSP2" value="{{$data->puchase_SP2}}" class="form-control" placeholder="ซื้อ" readonly/>
                                        @else
                                        <select name="puchaseSP2" class="form-control">
                                          <option value="" selected>--- ซื้อ ---</option>
                                          <option value="0 คัน" {{ ($data->puchase_SP2 === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                          <option value="1 คัน" {{ ($data->puchase_SP2 === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                          <option value="2 คัน" {{ ($data->puchase_SP2 === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                          <option value="3 คัน" {{ ($data->puchase_SP2 === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                          <option value="4 คัน" {{ ($data->puchase_SP2 === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                          <option value="5 คัน" {{ ($data->puchase_SP2 === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                          <option value="6 คัน" {{ ($data->puchase_SP2 === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                          <option value="7 คัน" {{ ($data->puchase_SP2 === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                          <option value="8 คัน" {{ ($data->puchase_SP2 === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                          <option value="9 คัน" {{ ($data->puchase_SP2 === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                          <option value="10 คัน" {{ ($data->puchase_SP2 === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                          <option value="11 คัน" {{ ($data->puchase_SP2 === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                          <option value="12 คัน" {{ ($data->puchase_SP2 === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                          <option value="13 คัน" {{ ($data->puchase_SP2 === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                          <option value="14 คัน" {{ ($data->puchase_SP2 === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                          <option value="15 คัน" {{ ($data->puchase_SP2 === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                          <option value="16 คัน" {{ ($data->puchase_SP2 === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                          <option value="17 คัน" {{ ($data->puchase_SP2 === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                          <option value="18 คัน" {{ ($data->puchase_SP2 === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                          <option value="19 คัน" {{ ($data->puchase_SP2 === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                          <option value="20 คัน" {{ ($data->puchase_SP2 === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                        </select>
                                        @endif
                                      @endif
                                    </div>
                                    <div class="col-sm-4">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="supportSP2" class="form-control">
                                          <option value="" selected>--- ค้ำ ---</option>
                                          <option value="0 คัน" {{ ($data->support_SP2 === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                          <option value="1 คัน" {{ ($data->support_SP2 === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                          <option value="2 คัน" {{ ($data->support_SP2 === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                          <option value="3 คัน" {{ ($data->support_SP2 === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                          <option value="4 คัน" {{ ($data->support_SP2 === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                          <option value="5 คัน" {{ ($data->support_SP2 === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                          <option value="6 คัน" {{ ($data->support_SP2 === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                          <option value="7 คัน" {{ ($data->support_SP2 === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                          <option value="8 คัน" {{ ($data->support_SP2 === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                          <option value="9 คัน" {{ ($data->support_SP2 === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                          <option value="10 คัน" {{ ($data->support_SP2 === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                          <option value="11 คัน" {{ ($data->support_SP2 === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                          <option value="12 คัน" {{ ($data->support_SP2 === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                          <option value="13 คัน" {{ ($data->support_SP2 === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                          <option value="14 คัน" {{ ($data->support_SP2 === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                          <option value="15 คัน" {{ ($data->support_SP2 === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                          <option value="16 คัน" {{ ($data->support_SP2 === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                          <option value="17 คัน" {{ ($data->support_SP2 === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                          <option value="18 คัน" {{ ($data->support_SP2 === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                          <option value="19 คัน" {{ ($data->support_SP2 === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                          <option value="20 คัน" {{ ($data->support_SP2 === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="supportSP2" value="{{$data->support_SP2}}" class="form-control" placeholder="ค้ำ" readonly/>
                                        @else
                                          <select name="supportSP2" class="form-control">
                                            <option value="" selected>--- ค้ำ ---</option>
                                            <option value="0 คัน" {{ ($data->support_SP2 === '0 คัน') ? 'selected' : '' }}>0 คัน</option>
                                            <option value="1 คัน" {{ ($data->support_SP2 === '1 คัน') ? 'selected' : '' }}>1 คัน</option>
                                            <option value="2 คัน" {{ ($data->support_SP2 === '2 คัน') ? 'selected' : '' }}>2 คัน</option>
                                            <option value="3 คัน" {{ ($data->support_SP2 === '3 คัน') ? 'selected' : '' }}>3 คัน</option>
                                            <option value="4 คัน" {{ ($data->support_SP2 === '4 คัน') ? 'selected' : '' }}>4 คัน</option>
                                            <option value="5 คัน" {{ ($data->support_SP2 === '5 คัน') ? 'selected' : '' }}>5 คัน</option>
                                            <option value="6 คัน" {{ ($data->support_SP2 === '6 คัน') ? 'selected' : '' }}>6 คัน</option>
                                            <option value="7 คัน" {{ ($data->support_SP2 === '7 คัน') ? 'selected' : '' }}>7 คัน</option>
                                            <option value="8 คัน" {{ ($data->support_SP2 === '8 คัน') ? 'selected' : '' }}>8 คัน</option>
                                            <option value="9 คัน" {{ ($data->support_SP2 === '9 คัน') ? 'selected' : '' }}>9 คัน</option>
                                            <option value="10 คัน" {{ ($data->support_SP2 === '10 คัน') ? 'selected' : '' }}>10 คัน</option>
                                            <option value="11 คัน" {{ ($data->support_SP2 === '11 คัน') ? 'selected' : '' }}>11 คัน</option>
                                            <option value="12 คัน" {{ ($data->support_SP2 === '12 คัน') ? 'selected' : '' }}>12 คัน</option>
                                            <option value="13 คัน" {{ ($data->support_SP2 === '13 คัน') ? 'selected' : '' }}>13 คัน</option>
                                            <option value="14 คัน" {{ ($data->support_SP2 === '14 คัน') ? 'selected' : '' }}>14 คัน</option>
                                            <option value="15 คัน" {{ ($data->support_SP2 === '15 คัน') ? 'selected' : '' }}>15 คัน</option>
                                            <option value="16 คัน" {{ ($data->support_SP2 === '16 คัน') ? 'selected' : '' }}>16 คัน</option>
                                            <option value="17 คัน" {{ ($data->support_SP2 === '17 คัน') ? 'selected' : '' }}>17 คัน</option>
                                            <option value="18 คัน" {{ ($data->support_SP2 === '18 คัน') ? 'selected' : '' }}>18 คัน</option>
                                            <option value="19 คัน" {{ ($data->support_SP2 === '19 คัน') ? 'selected' : '' }}>19 คัน</option>
                                            <option value="20 คัน" {{ ($data->support_SP2 === '20 คัน') ? 'selected' : '' }}>20 คัน</option>
                                          </select>
                                        @endif
                                      @endif
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

          <input type="hidden" name="_method" value="PATCH"/>
        </form>
      </section>
    </div>
  </section>

  <script>
    $(function () {
      $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
          alwaysShowClose: true
        });
      });
    })
  </script>

  <script>
    $(function () {
      $('[data-mask]').inputmask()
    })
  </script>

  {{-- image --}}
  <script type="text/javascript">
    $("#image-file,#Account_image,#image_checker_1,#image_checker_2,#image_income_1,#image_income_2").fileinput({
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

  @if($data->Buyer_latlong != NULL)
    @php
      @$SetBuyerlatlong = explode(",",$data->Buyer_latlong);
      @$Buyerlat = $SetBuyerlatlong[0];
      @$Buyerlong = $SetBuyerlatlong[1];
    @endphp
  @else 
    @php
      $Buyerlat = 0;
      $Buyerlong = 0;
    @endphp
  @endif

  @if($data->Support_latlong != NULL)
   @php
      @$SetSupportlatlong = explode(",",$data->Support_latlong);
      @$Supportlat = $SetSupportlatlong[0];
      @$Supportlong = $SetSupportlatlong[1];
    @endphp
  @else 
    @php
      $Supportlat = 0;
      $Supportlong = 0;
    @endphp
  @endif

  <script>
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 9,
        center: {lat: 6.6637053, lng: 101.2183787}
      });
      var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      // var labels = 'BA';

      var markers = locations.map(function(location, i) {
        return new google.maps.Marker({
          position: location,
          label: labels[i],
          // title: 'ตำแหน่งที่ตั้ง'
        });
      });
      

      // Add a marker clusterer to manage the markers.
      var markerCluster = new MarkerClusterer(map, markers,
          {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    }
    var locations = [
      {lat: {{ $Buyerlat }}, lng: {{ $Buyerlong }} },
      {lat: {{ $Supportlat }}, lng: {{ $Supportlong }} }
    ]
  </script>

  <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>
    
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHvHdio8MNE9aqZZmfvd49zHgLbixudMs&callback=initMap&language=th">
  </script>
@endsection
