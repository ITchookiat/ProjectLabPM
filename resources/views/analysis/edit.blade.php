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
        <form name="form1" method="post" action="{{ action('AnalysController@update',[$id,$Gettype]) }}" enctype="multipart/form-data">
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
                          <h4>แก้ไขข้อมูลสัญญา...</h4>
                        @else
                          <h4>รายละเอียดข้อมูลสัญญา...</h4>
                        @endif
                      </div>
                    </div>
                    <div class="col-8">
                      <div class="card-tools d-inline float-right">
                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                          @if(auth::user()->type == "Admin")
                            <button type="submit" class="delete-modal btn btn-success">
                              <i class="fas fa-save"></i> อัพเดท
                            </button>
                            <a class="delete-modal btn btn-danger" href="{{ route('Analysis',1) }}">
                              <i class="far fa-window-close"></i> ยกเลิก
                            </a>
                          @elseif(auth::user()->type == "แผนก วิเคราะห์")
                            @if($data->StatusApp_car != 'อนุมัติ')
                              <button type="submit" class="delete-modal btn btn-success">
                                <i class="fas fa-save"></i> อัพเดท
                              </button>
                              <a class="delete-modal btn btn-danger" href="{{ route('Analysis',1) }}">
                                <i class="far fa-window-close"></i> ยกเลิก
                              </a>
                            @else
                              <a class="delete-modal btn btn-danger" href="{{ URL::previous() }}">
                                <i class="fas fa-undo"></i> ย้อนกลับ
                              </a>
                            @endif
                          @endif
                        @else
                          @if($data->StatusApp_car != 'อนุมัติ')
                            <button type="submit" class="delete-modal btn btn-success">
                              <i class="fas fa-save"></i> อัพเดท
                            </button>
                            <a class="delete-modal btn btn-danger" href="{{ route('Analysis',1) }}">
                              <i class="far fa-window-close"></i> ยกเลิก
                            </a>
                          @else
                            <a class="delete-modal btn btn-danger" href="{{ URL::previous() }}">
                              <i class="fas fa-undo"></i> ย้อนกลับ
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
                      <div class="col-sm-3">
                        {{-- <h1 class="m-0 text-dark">Dashboard v2</h1> --}}
                      </div>
                      <div class="col-sm-9">
                        <ol class="breadcrumb float-sm-right">
                          {{-- ผู้จัดการ --}}
                          @if($data->Top_car > 250000)
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
                          @endif
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
                              @if(auth::user()->type == "Admin" or auth::user()->position == "MASTER")
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
                            @if(auth::user()->type != "Admin" and auth::user()->position != "MASTER")
                              @if($data->Check_car != NULL)
                                <input type="hidden" name="MASTER" value="{{ $data->Check_car }}">
                              @endif
                            @endif
                          </div>
                          {{-- ปิดสิทธ์แก้ไข / เอกสารครบ --}}
                          <div class="float-right form-inline">
                            <i class="fas fa-grip-vertical"></i>
                            <span class="todo-wrap">
                              @if(auth::user()->type == "Admin" or auth::user()->position == "MASTER")
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
                            @if(auth::user()->type != "Admin" and auth::user()->position != "MASTER" and auth::user()->position != "STAFF")
                              <input type="hidden" name="doccomplete" value="{{ $data->DocComplete_car }}">
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
                          <a class="nav-link" id="Sub-custom-tab5" data-toggle="pill" href="#Sub-tab5" role="tab" aria-controls="Sub-tab4" aria-selected="false">Checker</a>
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
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right"><font color="red">เลขที่สัญญา : </font></label>
                                  <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Contract_buyer" class="form-control" maxlength="12" value="{{ $data->Contract_buyer }}" />
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="Contract_buyer" class="form-control" value="{{ $data->Contract_buyer }}" readonly/>
                                    @else
                                      @if($data->StatusApp_car == 'อนุมัติ')
                                        <input type="text" name="Contract_buyer" class="form-control" value="{{ $data->Contract_buyer }}"/>
                                      @else
                                        <input type="text" name="Contract_buyer" maxlength="8" class="form-control" data-inputmask="&quot;mask&quot;:&quot;99-9999/&quot;" data-mask="" value="{{ $data->Contract_buyer }}"/>
                                      @endif
                                    @endif
                                  @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right"><font color="red">วันที่ทำสัญญา : </font></label>
                                  <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="date" name="DateDue" class="form-control" value="{{ $newDateDue }}">
                                  @else
                                    <input type="date" name="DateDue" class="form-control" value="{{ $newDateDue }}" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}>
                                  @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ชื่อ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Namebuyer" value="{{ $data->Name_buyer }}" class="form-control" placeholder="ป้อนชื่อ" />
                                    @else
                                      <input type="text" name="Namebuyer" value="{{ $data->Name_buyer }}" class="form-control" placeholder="ป้อนชื่อ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">นามสกุล : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="lastbuyer" value="{{ $data->last_buyer }}" class="form-control" placeholder="ป้อนนามสกุล" />
                                    @else
                                      <input type="text" name="lastbuyer" value="{{ $data->last_buyer }}" class="form-control" placeholder="ป้อนนามสกุล" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ชื่อเล่น : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Nickbuyer" value="{{ $data->Nick_buyer }}" class="form-control" placeholder="ป้อนชื่อเล่น" />
                                    @else
                                      <input type="text" name="Nickbuyer" value="{{ $data->Nick_buyer }}" class="form-control" placeholder="ป้อนชื่อเล่น" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">สถานะ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Statusbuyer" class="form-control">
                                        <option value="" selected>--- เลือกสถานะ ---</option>
                                        @foreach ($Statusby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Status_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Statusbuyer" value="{{ $data->Status_buyer }}" class="form-control" readonly/>
                                      @else
                                        <select name="Statusbuyer" class="form-control">
                                          <option value="" disabled selected>--- เลือกสถานะ ---</option>
                                          @foreach ($Statusby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->Status_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เบอร์โทรศัพท์ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Phonebuyer" value="{{ $data->Phone_buyer }}" class="form-control"  placeholder="ป้อนเบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask=""/>
                                    @else
                                      <input type="text" name="Phonebuyer" value="{{ $data->Phone_buyer }}" class="form-control"  placeholder="ป้อนเบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6"> 
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เบอร์โทรอื่นๆ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Phone2buyer" value="{{ $data->Phone2_buyer }}" class="form-control"  placeholder="ป้อนเบอร์โทรอื่นๆ" />
                                    @else
                                      <input type="text" name="Phone2buyer" value="{{ $data->Phone2_buyer }}" class="form-control"  placeholder="ป้อนเบอร์โทรอื่นๆ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เลขประชาชนผู้ซื้อ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Idcardbuyer" value="{{ $data->Idcard_buyer }}" class="form-control"  placeholder="ป้อนเลขประชาชนผู้ซื้อ" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                                    @else
                                      <input type="text" name="Idcardbuyer" value="{{ $data->Idcard_buyer }}" class="form-control"  placeholder="ป้อนเลขประชาชนผู้ซื้อ" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">คู่สมรส : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Matebuyer" value="{{ $data->Mate_buyer }}" class="form-control"  placeholder="ป้อนคู่สมรส" />
                                    @else
                                      <input type="text" name="Matebuyer" value="{{ $data->Mate_buyer }}" class="form-control"  placeholder="ป้อนคู่สมรส" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ที่อยู่ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Addressbuyer" class="form-control" >
                                        <option value="" selected>--- เลือกที่อยู่ ---</option>
                                        @foreach ($Addby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Address_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Addressbuyer" value="{{ $data->Address_buyer }}" class="form-control"  placeholder="เลือกที่อยู่" readonly/>
                                      @else
                                        <select name="Addressbuyer" class="form-control" >
                                          <option value=""  selected>--- เลือกที่อยู่ ---</option>
                                          @foreach ($Addby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->Address_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ที่อยู่ปัจจุบัน/ส่งเอกสาร : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="AddNbuyer" value="{{ $data->AddN_buyer }}" class="form-control"  placeholder="ที่อยู่ปัจจุบัน/ส่งเอกสาร" />
                                    @else
                                      <input type="text" name="AddNbuyer" value="{{ $data->AddN_buyer }}" class="form-control"  placeholder="ที่อยู่ปัจจุบัน/ส่งเอกสาร" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">รายละเอียดที่อยู่ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="StatusAddbuyer" value="{{ $data->StatusAdd_buyer }}" class="form-control"  placeholder="ป้อนรายละเอียดที่อยู่" />
                                    @else
                                      <input type="text" name="StatusAddbuyer" value="{{ $data->StatusAdd_buyer }}" class="form-control"  placeholder="ป้อนรายละเอียดที่อยู่" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">สถานที่ทำงาน : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="Workplacebuyer" value="{{ $data->Workplace_buyer }}" class="form-control"  placeholder="ป้อนสถานที่ทำงาน" />
                                    @else
                                      <input type="text" name="Workplacebuyer" value="{{ $data->Workplace_buyer }}" class="form-control"  placeholder="ป้อนสถานที่ทำงาน" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ลักษณะบ้าน : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Housebuyer" class="form-control" >
                                        <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                        @foreach ($Houseby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->House_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Housebuyer" value="{{ $data->House_buyer }}" class="form-control"  placeholder="เลือกลักษณะบ้าน" readonly/>
                                      @else
                                        <select name="Housebuyer" class="form-control" >
                                          <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                          @foreach ($Houseby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->House_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ประเภทหลักทรัพย์ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="securitiesbuyer" class="form-control" >
                                        <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                        @foreach ($securitiesSPp as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->securities_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="securitiesbuyer" value="{{ $data->securities_buyer }}" class="form-control"  placeholder="ประเภทหลักทรัพย์" readonly/>
                                      @else
                                        <select name="securitiesbuyer" class="form-control" >
                                          <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                          @foreach ($securitiesSPp as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->securities_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เลขที่โฉนด : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="deednumberbuyer" value="{{$data->deednumber_buyer}}" class="form-control"  placeholder="เลขที่โฉนด" />
                                    @else
                                      <input type="text" name="deednumberbuyer" value="{{$data->deednumber_buyer}}" class="form-control"  placeholder="เลขที่โฉนด" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">เนื่อที่ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" name="areabuyer" value="{{$data->area_buyer}}" class="form-control"  placeholder="เนื้อที่" data-inputmask="&quot;mask&quot;:&quot;99-9-99&quot;" data-mask=""/>
                                    @else
                                      <input type="text" name="areabuyer" value="{{$data->area_buyer}}" class="form-control"  placeholder="เนื้อที่" data-inputmask="&quot;mask&quot;:&quot;99-9-99&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ประเภทบ้าน : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="HouseStylebuyer" class="form-control" >
                                        <option value="" selected>--- ประเภทบ้าน ---</option>
                                        @foreach ($HouseStyleby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->HouseStyle_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="HouseStylebuyer" value="{{ $data->HouseStyle_buyer }}" class="form-control"  placeholder="เลือกประเภทบ้าน" readonly/>
                                      @else
                                        <select name="HouseStylebuyer" class="form-control" >
                                          <option value="" selected>--- ประเภทบ้าน ---</option>
                                          @foreach ($HouseStyleby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->HouseStyle_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">อาชีพ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Careerbuyer" class="form-control" >
                                        <option value="" selected>--- อาชีพ ---</option>
                                        @foreach ($Careerby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Career_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Careerbuyer" value="{{ $data->Career_buyer }}" class="form-control"  placeholder="เลือกอาชีพ" readonly/>
                                      @else
                                        <select name="Careerbuyer" class="form-control" >
                                          <option value="" selected>--- อาชีพ ---</option>
                                          @foreach ($Careerby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->Career_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">รายได้ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Incomebuyer" class="form-control" >
                                        <option value="" selected>--- รายได้ ---</option>
                                        @foreach ($Incomeby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Income_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Incomebuyer" value="{{ $data->Income_buyer }}" class="form-control"  placeholder="เลือกรายได้" readonly/>
                                      @else
                                        <select name="Incomebuyer" class="form-control" >
                                          <option value="" selected>--- รายได้ ---</option>
                                          @foreach ($Incomeby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->Income_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ใบขับขี่ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Driverbuyer" class="form-control" >
                                        <option value="" selected>--- เลือกใบขับขี่ ---</option>
                                        @foreach ($Driverby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Driver_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Driverbuyer" value="{{ $data->Driver_buyer }}" class="form-control"  placeholder="เลือกใบขับขี่" readonly/>
                                      @else
                                        <select name="Driverbuyer" class="form-control" >
                                          <option value="" selected>--- เลือกใบขับขี่ ---</option>
                                          @foreach ($Driverby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->Driver_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">หักค่าใช้จ่าย : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" id="Beforeincome" name="Beforeincome" value="{{ number_format($data->BeforeIncome_buyer,0) }}" class="form-control"  placeholder="ก่อนหักค่าใช้จ่าย" onchange="income();" />
                                    @else
                                      <input type="text" id="Beforeincome" name="Beforeincome" value="{{ number_format($data->BeforeIncome_buyer,0) }}" class="form-control"  placeholder="ก่อนหักค่าใช้จ่าย" onchange="income();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }} />
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ประวัติการซื้อ/ค้ำ : </label>
                                  <div class="col-sm-4">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Purchasebuyer" class="form-control">
                                        <option value="" selected>--- ซื้อ ---</option>
                                        @foreach ($HisCarby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Purchase_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Purchasebuyer" value="{{ $data->Purchase_buyer }}" class="form-control" placeholder="ซื้อ" readonly/>
                                      @else
                                        <select name="Purchasebuyer" class="form-control">
                                          <option value="" selected>--- ซื้อ ---</option>
                                          @foreach ($HisCarby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->Purchase_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                  <div class="col-sm-4">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Supportbuyer" class="form-control">
                                        <option value="" selected>--- ค้ำ ---</option>
                                        @foreach ($HisCarby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Support_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Supportbuyer" value="{{ $data->Support_buyer }}" class="form-control" placeholder="ค้ำ" readonly/>
                                      @else
                                        <select name="Supportbuyer" class="form-control">
                                          <option value="" selected>--- ค้ำ ---</option>
                                          @foreach ($HisCarby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->Support_buyer) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">รายได้หลังหักค่าใช้จ่าย : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" id="Afterincome" name="Afterincome" value="{{ number_format($data->AfterIncome_buyer,0) }}" class="form-control"  placeholder="ก่อนหักค่าใช้จ่าย" onchange="income();" />
                                    @else
                                      <input type="text" id="Afterincome" name="Afterincome" value="{{ number_format($data->AfterIncome_buyer,0) }}" class="form-control"  placeholder="ก่อนหักค่าใช้จ่าย" onchange="income();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }} />
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">สถานะผู้เช่าซื้อ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="Gradebuyer" class="form-control" >
                                        <option value="" selected>--- สถานะผู้เช่าซื้อ ---</option>
                                        @foreach ($GradeBuyer as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Gradebuyer_car) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="Gradebuyer" value="{{ $data->Gradebuyer_car }}" class="form-control"  placeholder="เลือกสถานะผู้เช่าซื้อ" readonly/>
                                      @else
                                        <select name="Gradebuyer" class="form-control" >
                                          <option value="" selected>--- สถานะผู้เช่าซื้อ ---</option>
                                          @foreach ($GradeBuyer as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Gradebuyer_car) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">วัตถุประสงค์ของสินเชื่อ : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <select name="objectivecar" class="form-control" >
                                        <option value="" selected>--- วัตถุประสงค์ของสินเชื่อ ---</option>
                                        @foreach ($objectivecar as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Objective_car) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      @if($GetDocComplete != Null)
                                        <input type="text" name="objectivecar" value="{{ $data->Objective_car }}" class="form-control"  placeholder="เลือกวัตถุประสงค์ของสินเชื่อ" readonly/>
                                      @else
                                        <select name="objectivecar" class="form-control" >
                                          <option value="" selected>--- วัตถุประสงค์ของสินเชื่อ ---</option>
                                          @foreach ($objectivecar as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Objective_car) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @endif
                                    @endif
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
                              <div class="col-md-12">
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
                                <div class="form-group">
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
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ชื่อ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="nameSP" value="{{$data->name_SP}}" class="form-control" placeholder="ชื่อ" />
                                  @else
                                    <input type="text" name="nameSP" value="{{$data->name_SP}}" class="form-control" placeholder="ชื่อ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">นามสกุล : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="lnameSP" value="{{$data->lname_SP}}" class="form-control" placeholder="นามสกุล" />
                                  @else
                                    <input type="text" name="lnameSP" value="{{$data->lname_SP}}" class="form-control" placeholder="นามสกุล" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ชื่อเล่น : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="niknameSP" value="{{$data->nikname_SP}}" class="form-control" placeholder="ชื่อเล่น" />
                                  @else
                                    <input type="text" name="niknameSP" value="{{$data->nikname_SP}}" class="form-control" placeholder="ชื่อเล่น" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">สถานะ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="statusSP" class="form-control">
                                      <option value="" selected>--- สถานะ ---</option>
                                      @foreach ($Statusby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->status_SP) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="statusSP" value="{{$data->status_SP}}" class="form-control" placeholder="เลือกสถานะ" readonly/>
                                    @else
                                      <select name="statusSP" class="form-control">
                                        <option value="" selected>--- สถานะ ---</option>
                                          @foreach ($Statusby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->status_SP) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เบอร์โทร : </label>
                                <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="telSP" value="{{$data->tel_SP}}" class="form-control" placeholder="เบอร์โทร" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="telSP" value="{{$data->tel_SP}}" class="form-control" placeholder="เบอร์โทร" data-inputmask="&quot;mask&quot;:&quot;999-9999999,999-9999999&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ความสัมพันธ์ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="relationSP" class="form-control">
                                      <option value="" selected>--- ความสัมพันธ์ ---</option>
                                        @foreach ($relationSPp as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->relation_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="relationSP" value="{{$data->relation_SP}}" class="form-control" placeholder="เลือกความสัมพันธ์" readonly/>
                                    @else
                                      <select name="relationSP" class="form-control">
                                        <option value="" selected>--- ความสัมพันธ์ ---</option>
                                        @foreach ($relationSPp as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->relation_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">คู่สมรส : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="mateSP" value="{{$data->mate_SP}}" class="form-control" placeholder="คู่สมรส" />
                                  @else
                                    <input type="text" name="mateSP" value="{{$data->mate_SP}}" class="form-control" placeholder="คู่สมรส" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขบัตรประชาชน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="idcardSP" value="{{$data->idcard_SP}}" class="form-control" placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="idcardSP" value="{{$data->idcard_SP}}" class="form-control" placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ที่อยู่ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="addSP" class="form-control">
                                      <option value="" selected>--- ที่อยู่ ---</option>
                                        @foreach ($Addby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->add_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                    <input type="text" name="addSP" value="{{$data->add_SP}}" class="form-control" placeholder="เลือกที่อยู่" readonly/>
                                    @else
                                      <select name="addSP" class="form-control">
                                        <option value="" selected>--- ที่อยู่ ---</option>
                                          @foreach ($Addby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->add_SP) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ที่อยู่ปัจจุบัน/จัดส่งเอกสาร : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="addnowSP" value="{{$data->addnow_SP}}" class="form-control" placeholder="ที่อยู่ปัจจุบัน/จัดส่งเอกสาร" />
                                  @else
                                    <input type="text" name="addnowSP" value="{{$data->addnow_SP}}" class="form-control" placeholder="ที่อยู่ปัจจุบัน/จัดส่งเอกสาร" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">รายละเอียดที่อยู่ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="statusaddSP" value="{{$data->statusadd_SP}}" class="form-control" placeholder="รายละเอียดที่อยู่" />
                                  @else
                                    <input type="text" name="statusaddSP" value="{{$data->statusadd_SP}}" class="form-control" placeholder="รายละเอียดที่อยู่" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">สถานที่ทำงาน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="workplaceSP" value="{{$data->workplace_SP}}" class="form-control" placeholder="สถานที่ทำงาน" />
                                  @else
                                    <input type="text" name="workplaceSP" value="{{$data->workplace_SP}}" class="form-control" placeholder="สถานที่ทำงาน" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ลักษณะบ้าน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="houseSP" class="form-control">
                                      <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                        @foreach ($Houseby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->house_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="houseSP" value="{{$data->house_SP}}" class="form-control" placeholder="เลือกลักษณะบ้าน" readonly/>
                                    @else
                                      <select name="houseSP" class="form-control">
                                        <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                          @foreach ($Houseby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->house_SP) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประเภทหลักทรัพย์ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="securitiesSP" class="form-control">
                                      <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                        @foreach ($securitiesSPp as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->securities_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="securitiesSP" value="{{$data->securities_SP}}" class="form-control" placeholder="ประเภทหลักทรัพย์" readonly/>
                                    @else
                                      <select name="securitiesSP" class="form-control">
                                        <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                          @foreach ($securitiesSPp as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->securities_SP) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขที่โฉนด : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="deednumberSP" value="{{$data->deednumber_SP}}" class="form-control" placeholder="เลขที่โฉนด" />
                                  @else
                                    <input type="text" name="deednumberSP" value="{{$data->deednumber_SP}}" class="form-control" placeholder="เลขที่โฉนด" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เนื้อที่ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="areaSP" value="{{$data->area_SP}}" class="form-control" placeholder="เนื้อที่" data-inputmask="&quot;mask&quot;:&quot;99-9-99&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="areaSP" value="{{$data->area_SP}}" class="form-control" placeholder="เนื้อที่" data-inputmask="&quot;mask&quot;:&quot;99-9-99&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประเภทบ้าน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="housestyleSP" class="form-control">
                                      <option value="" selected>--- ประเภทบ้าน ---</option>
                                      @foreach ($HouseStyleby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->housestyle_SP) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                        <input type="text" name="housestyleSP" value="{{$data->housestyle_SP}}" class="form-control" placeholder="ประเภทบ้าน" readonly/>
                                    @else
                                      <select name="housestyleSP" class="form-control">
                                        <option value="" selected>--- ประเภทบ้าน ---</option>
                                        @foreach ($HouseStyleby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->housestyle_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">อาชีพ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="careerSP" class="form-control">
                                      <option value="" selected>--- อาชีพ ---</option>
                                      @foreach ($Careerby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->career_SP) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="careerSP" value="{{$data->career_SP}}" class="form-control" placeholder="อาชีพ" readonly/>
                                    @else
                                      <select name="careerSP" class="form-control">
                                        <option value="" selected>--- อาชีพ ---</option>
                                        @foreach ($Careerby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->career_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">รายได้ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="incomeSP" class="form-control">
                                      <option value="" selected>--- รายได้ ---</option>
                                      @foreach ($Incomeby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->income_SP) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                        <input type="text" name="incomeSP" value="{{$data->income_SP}}" class="form-control" placeholder="รายได้" readonly/>
                                    @else
                                      <select name="incomeSP" class="form-control">
                                        <option value="" selected>--- รายได้ ---</option>
                                        @foreach ($Incomeby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->income_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประวัติซื้อ/ค้ำ  : </label>
                                <div class="col-sm-4">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="puchaseSP" class="form-control">
                                      <option value="" selected>--- ซื้อ ---</option>
                                      @foreach ($HisCarby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->puchase_SP) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="puchaseSP" value="{{$data->puchase_SP}}" class="form-control" placeholder="ซื้อ" readonly/>
                                    @else
                                      <select name="puchaseSP" class="form-control">
                                        <option value="" selected>--- ซื้อ ---</option>
                                        @foreach ($HisCarby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->puchase_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                                <div class="col-sm-4">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="supportSP" class="form-control">
                                      <option value="" selected>--- ค้ำ ---</option>
                                      @foreach ($HisCarby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->support_SP) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="supportSP" value="{{$data->support_SP}}" class="form-control" placeholder="ค้ำ" readonly/>
                                    @else
                                      <select name="supportSP" class="form-control">
                                        <option value="" selected>--- ค้ำ ---</option>
                                        @foreach ($HisCarby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->support_SP) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
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
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="Brandcar" class="form-control" >
                                      <option value="" selected>--- ยี่ห้อ ---</option>
                                      @foreach ($Brandcarr as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->Brand_car) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="Brandcar" value="{{$data->Brand_car}}" class="form-control"  placeholder="ยี่ห้อ" readonly/>
                                    @else
                                      <select name="Brandcar" class="form-control" >
                                        <option value="" selected>--- ยี่ห้อ ---</option>
                                        @foreach ($Brandcarr as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Brand_car) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประเภทรถ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="Typecardetail" name="Typecardetail" class="form-control"  onchange="calculate();">
                                      <option value="" selected>--- ประเภทรถ ---</option>
                                      @foreach ($Typecardetail as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->Typecardetails) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="Typecardetail" name="Typecardetail" value="{{$data->Typecardetails}}" class="form-control"  placeholder="ปี" readonly/>
                                    @else
                                    <select id="Typecardetail" name="Typecardetail" class="form-control"  onchange="calculate();">
                                      <option value="" selected>--- ประเภทรถ ---</option>
                                      @foreach ($Typecardetail as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->Typecardetails) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">สี : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Colourcar" value="{{ $data->Colour_car }}" class="form-control"  placeholder="สี" />
                                  @else
                                    <input type="text" name="Colourcar" value="{{ $data->Colour_car }}" class="form-control"  placeholder="สี" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ปี : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="Yearcar" name="Yearcar" class="form-control"  onchange="calculate();">
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
                                      <input type="text" name="Yearcar" value="{{$data->Year_car}}" class="form-control"  placeholder="ปี" readonly/>
                                    @else
                                      <select id="Yearcar" name="Yearcar" class="form-control"  onchange="calculate();">
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
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ป้ายเดิม : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == 1)
                                    <input type="text" name="Licensecar"  value="{{ $data->License_car}}" class="form-control"  placeholder="ป้ายเดิม"/>
                                  @else
                                    <input type="text" name="Licensecar"  value="{{ $data->License_car}}" class="form-control"  readonly/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">กลุ่มปีรถยนต์ : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Groupyearcar" name="Groupyearcar" class="form-control"  value="{{ $data->Groupyear_car}}" readonly onchange="newformula();"/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ป้ายใหม่ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Nowlicensecar" value="{{$data->Nowlicense_car}}" class="form-control"  placeholder="ป้ายใหม่" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขไมล์ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Milecar" name="Milecar" value="{{$data->Mile_car}}" class="form-control"  placeholder="เลขไมล์" onchange="mile();" />
                                  @else
                                    <input type="text" id="Milecar" name="Milecar" value="{{$data->Mile_car}}" class="form-control"  placeholder="เลขไมล์" onchange="mile();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">รุ่น : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Modelcar" value="{{$data->Model_car}}" class="form-control"  placeholder="รุ่น" />
                                  @else
                                    <input type="text" name="Modelcar" value="{{$data->Model_car}}" class="form-control"  placeholder="รุ่น" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ราคากลาง : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Midpricecar" name="Midpricecar" value="{{$data->Midprice_car}}" class="form-control"  placeholder="ราคากลาง" oninput="mile();percent();"/>
                                  @else
                                    <input type="text" id="Midpricecar" name="Midpricecar" value="{{$data->Midprice_car}}" class="form-control"  placeholder="ราคากลาง" oninput="mile();percent();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <hr />
                          @include('analysis.script')

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ยอดจัด : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Topcar" name="Topcar" value="{{number_format($data->Top_car)}}" class="form-control"  placeholder="กรอกยอดจัด" oninput="calculate();balance();percent();" />
                                  @else
                                    <input type="text" id="Topcar" name="Topcar" value="{{number_format($data->Top_car)}}" class="form-control"  placeholder="กรอกยอดจัด" oninput="calculate();balance();percent();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                  <input type="hidden" id="TopcarOri" name="TopcarOri" class="form-control"  placeholder="กรอกยอดจัด" />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ชำระต่องวด : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Paycar" name="Paycar" value="{{$data->Pay_car}}" class="form-control"  readonly onchange="calculate()" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ระยะเวลาผ่อน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="Timeslackencar" name="Timeslackencar" class="form-control"  onchange="calculate();">
                                      <option value="" selected>--- ระยะเวลาผ่อน ---</option>
                                      @foreach ($Timeslackencarr as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->Timeslacken_car) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="Timeslackencar" name="Timeslackencar" value="{{$data->Timeslacken_car}}" class="form-control"  placeholder="ระยะเวลาผ่อน" readonly />
                                    @else
                                      <select id="Timeslackencar" name="Timeslackencar" class="form-control"  onchange="calculate();">
                                        <option value="" selected>--- ระยะเวลาผ่อน ---</option>
                                        @foreach ($Timeslackencarr as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Timeslacken_car) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ภาษี/ระยะเวลาผ่อน : </label>
                                <div class="col-sm-4">
                                  <input type="text" id="Taxcar" name="Taxcar" value="{{$data->Tax_car}}" class="form-control" readonly />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" id="Taxpaycar" name="Taxpaycar" value="{{$data->Taxpay_car}}" class="form-control" readonly />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ดอกเบี้ย/ปี : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Interestcar" name="Interestcar" class="form-control"  value="{{$data->Interest_car}}" placeholder="ดอกเบี้ย" readonly onchange="calculate();"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ค่างวด/ระยะเวลาผ่อน : </label>
                                <div class="col-sm-4">
                                  <input type="text" id="Paymemtcar" name="Paymemtcar" value="{{$data->Paymemt_car}}" class="form-control" readonly />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" id="Timepaymentcar" name="Timepaymentcar" value="{{$data->Timepayment_car}}" class="form-control" readonly />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">VAT : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="Vatcar" name="Vatcar" value="{{$data->Vat_car}}" class="form-control"  placeholder="7 %" value="7 %" readonly onchange="calculate()"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ยอดผ่อนชำระทั้งหมด : </label>
                                <div class="col-sm-4">
                                  <input type="text" id="Totalpay1car" name="Totalpay1car" value="{{$data->Totalpay1_car}}" class="form-control" readonly />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" id="Totalpay2car" name="Totalpay2car" value="{{$data->Totalpay2_car}}" class="form-control" readonly />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประกันภัย : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="Insurancecar" name="Insurancecar" class="form-control"  onchange="">
                                      <option value="" selected>--- ประกันภัย ---</option>
                                      @foreach ($Insurancecarr as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->Insurance_car) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="Insurancecar" name="Insurancecar" value="{{$data->Insurance_car}}" class="form-control"  placeholder="ประกันภัย" readonly />
                                    @else
                                      <select id="Insurancecar" name="Insurancecar" class="form-control"  onchange="">
                                        <option value="" selected>--- ประกันภัย ---</option>
                                        @foreach ($Insurancecarr as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Insurance_car) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เปอร์เซ็นจัดไฟแนนซ์ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Percentcar" value="{{$data->Percent_car}}" class="form-control int"  placeholder="เปอร์เซ็นจัดไฟแนนซ์" readonly/>
                                  @else
                                    <input type="text" name="Percentcar" value="{{$data->Percent_car}}" class="form-control int"  placeholder="เปอร์เซ็นจัดไฟแนนซ์" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">แบบ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="statuscar" name="statuscar" class="form-control" >
                                      <option value="" selected>--- เลือกแบบ ---</option>
                                      @foreach ($statuscarr as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->status_car) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="statuscar" name="statuscar" value="{{$data->status_car}}" class="form-control"  placeholder="สถานะ" readonly />
                                    @else
                                      <select id="statuscar" name="statuscar" class="form-control" >
                                        <option value="" selected>--- เลือกแบบ ---</option>
                                        @foreach ($statuscarr as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->status_car) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">วันที่ชำระงวดแรก : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="Dateduefirstcar" value="{{$data->Dateduefirst_car}}" class="form-control"  readonly placeholder="วันที่ชำระงวดแรก" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right"></label>
                                <div class="col-sm-8">
                                  <span class="todo-wrap">
                                    @if($data->Salemethod_car != Null)
                                      <input type="checkbox" id="4" name="Salemethod" value="{{ $data->Salemethod_car }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="4" name="Salemethod" value="on"/>
                                    @endif
                                    <label for="4" class="todo">
                                      <i class="fa fa-check"></i>
                                      กรรมสิทธิ์ในแบบซื้อขาย
                                    </label>
                                  </span>
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
                              $("#balancePrice").val(addCommas(balancePrice.toFixed(2)));

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

                          <hr />
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ผู้รับเงิน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Payeecar" value="{{$data->Payee_car}}" class="form-control"  placeholder="ผู้รับเงิน" />
                                  @else
                                    <input type="text" name="Payeecar" value="{{$data->Payee_car}}" class="form-control"  placeholder="ผู้รับเงิน" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขที่บัญชี : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Accountbrancecar" value="{{$data->Accountbrance_car}}" class="form-control"  placeholder="เลขที่บัญชี" maxlength="15"/>
                                  @else
                                    <input type="text" name="Accountbrancecar" value="{{$data->Accountbrance_car}}" class="form-control"  placeholder="เลขที่บัญชี" maxlength="15" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
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
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="branchbrancecar" value="{{$data->branchbrance_car}}" class="form-control"  placeholder="สาขาผู้รับเงิน" />
                                  @else
                                    <input type="text" name="branchbrancecar" value="{{$data->branchbrance_car}}" class="form-control"  placeholder="สาขาผู้รับเงิน" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
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
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Tellbrancecar" value="{{$data->Tellbrance_car}}" class="form-control"  placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="Tellbrancecar" value="{{$data->Tellbrance_car}}" class="form-control"  placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right"><font color="red">(* กรณีเป็นพนักงาน) </font>แนะนำ/นายหน้า : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="Agentcar" name="Agentcar" value="{{$data->Agent_car}}" class="form-control"  placeholder="แนะนำ/นายหน้า" />
                                  @else
                                    <input type="text" id="Agentcar" name="Agentcar" value="{{$data->Agent_car}}" class="form-control"  placeholder="แนะนำ/นายหน้า" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เลขที่บัญชี : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Accountagentcar" value="{{$data->Accountagent_car}}" class="form-control"  placeholder="เลขที่บัญชี" maxlength="15"/>
                                  @else
                                    <input type="text" name="Accountagentcar" value="{{$data->Accountagent_car}}" class="form-control"  placeholder="เลขที่บัญชี" maxlength="15" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                  <label class="col-sm-3 col-form-label text-right">ค่าคอม : </label>
                                  <div class="col-sm-8">
                                    @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                      <input type="text" id="Commissioncar" name="Commissioncar" value="{{number_format($data->Commission_car, 2)}}" class="form-control"  placeholder="ค่าคอม" oninput="commission()"/>
                                    @else
                                      <input type="text" id="Commissioncar" name="Commissioncar" value="{{number_format($data->Commission_car, 2)}}" class="form-control"  placeholder="ค่าคอม" oninput="commission()" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                    @endif
                                  </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">สาขา : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="branchAgentcar" value="{{$data->branchAgent_car}}" class="form-control"  placeholder="สาขานายหน้า"/>
                                  @else
                                    <input type="text" name="branchAgentcar" value="{{$data->branchAgent_car}}" class="form-control"  placeholder="สาขานายหน้า" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ประวัติการซื้อ/ค้ำ : </label>
                                <div class="col-sm-4">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="Purchasehistorycar" class="form-control">
                                      <option value="" selected>--- ซื้อ ---</option>
                                      @foreach ($HisCarby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->Purchasehistory_car) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="Purchasehistorycar" value="{{$data->Purchasehistory_car}}" class="form-control" placeholder="ซื้อ" readonly/>
                                    @else
                                      <select name="Purchasehistorycar" class="form-control">
                                        <option value="" selected>--- ซื้อ ---</option>
                                        @foreach ($HisCarby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Purchasehistory_car) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                                <div class="col-sm-4">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select name="Supporthistorycar" class="form-control">
                                      <option value="" selected>--- ค้ำ ---</option>
                                      @foreach ($HisCarby as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->Supporthistory_car) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" name="Supporthistorycar" value="{{$data->Purchasehistory_car}}" class="form-control" placeholder="ค้ำ" readonly/>
                                    @else
                                      <select name="Supporthistorycar" class="form-control">
                                        <option value="" selected>--- ค้ำ ---</option>
                                        @foreach ($HisCarby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->Supporthistory_car) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เบอร์โทรศัพท์ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Tellagentcar" value="{{$data->Tellagent_car}}" class="form-control"  placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask=""/>
                                  @else
                                    <input type="text" name="Tellagentcar" value="{{$data->Tellagent_car}}" class="form-control"  placeholder="เบอร์โทรศัพท์" data-inputmask="&quot;mask&quot;:&quot;999-9999999&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">หมายเหตุ : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="Notecar" value="{{$data->Note_car}}" class="form-control"  placeholder="หมายเหตุ"/>
                                  @else
                                    <input type="text" name="Notecar" value="{{$data->Note_car}}" class="form-control" placeholder="หมายเหตุ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
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
                        </div>
                        <div class="tab-pane fade" id="Sub-tab4" role="tabpanel" aria-labelledby="Sub-custom-tab4">
                          <h5 class="text-center"><b>แบบฟอร์มรายละเอียดค่าใช้จ่าย</b></h5>
                          <p></p>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">พรบ. : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="actPrice" name="actPrice" value="{{number_format($data->act_Price)}}" class="form-control" placeholder="พรบ." onchange="balance();"/>
                                  @else
                                    <input type="text" id="actPrice" name="actPrice" value="{{number_format($data->act_Price)}}" class="form-control" placeholder="พรบ." onchange="balance();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">เปอร์เซ็นต์ค่าคอม : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" name="vatPrice" value="{{$data->vat_Price}}" class="form-control" placeholder="เปอร์เซ็นต์ค่าคอม" />
                                  @else
                                    <input type="text" name="vatPrice" value="{{$data->vat_Price}}" class="form-control" placeholder="เปอร์เซ็นต์ค่าคอม" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                  <input type="hidden" id="tempTopcar" value="{{$data->Top_car}}" name="tempTopcar" class="form-control" placeholder="รวมยอดจัด" readonly/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ยอดปิดบัญชี : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="closeAccountPrice" name="closeAccountPrice" value="{{number_format($data->closeAccount_Price)}}" class="form-control" placeholder="ยอดปิดบัญชี" onchange="balance()"/>
                                  @else
                                    <input type="text" id="closeAccountPrice" name="closeAccountPrice" value="{{number_format($data->closeAccount_Price)}}" class="form-control" placeholder="ยอดปิดบัญชี" onchange="balance()" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ซื้อ ป2+/ป1 : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <input type="text" id="P2Price" name="P2Price" value="{{number_format($data->P2_Price)}}" class="form-control" placeholder="ซื้อ ป2+" onchange="balance();"/>
                                  @else
                                    <input type="text" id="P2Price" name="P2Price" value="{{number_format($data->P2_Price)}}" class="form-control" placeholder="ซื้อ ป2+" onchange="balance();" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                  @endif
                                  <input type="hidden" id="P2PriceOri" name="P2PriceOri" class="form-control" value="{{number_format($data->P2_Price)}}" placeholder="ซื้อ ป2+" onchange="calculate();" readonly/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <hr />
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ค่าใช้จ่ายขนส่ง : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="tranPrice" name="tranPrice" value="{{number_format($data->tran_Price)}}" class="form-control" placeholder="ค่าใช้จ่ายขนส่ง" onchange="balance();"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">อื่นๆ : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="otherPrice" name="otherPrice" value="{{number_format($data->other_Price)}}" class="form-control" placeholder="อื่นๆ" onchange="balance();"/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ค่าประเมิน : </label>
                                <div class="col-sm-8">
                                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                    <select id="evaluetionPrice" name="evaluetionPrice" class="form-control" onchange="balance();">
                                      <option value="" selected>--- ค่าประเมิน ---</option>
                                      @foreach ($evaluetionPricee as $key => $value)
                                        <option value="{{$key}}" {{ ($key == $data->evaluetion_Price) ? 'selected' : '' }}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @else
                                    @if($GetDocComplete != Null)
                                      <input type="text" id="evaluetionPrice" name="evaluetionPrice" value="{{ $data->evaluetion_Price }}" class="form-control" placeholder="พรบ." onchange="balance()" readonly/>
                                    @else
                                      <select id="evaluetionPrice" name="evaluetionPrice" class="form-control" onchange="balance();">
                                        <option value="" selected>--- ค่าประเมิน ---</option>
                                        @foreach ($evaluetionPricee as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->evaluetion_Price) ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                      </select>
                                    @endif
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">อากร : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="dutyPrice" name="dutyPrice" value="{{$data->duty_Price}}" class="form-control" placeholder="อากร" onchange="balance();" readonly />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ค่าการตลาด : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="marketingPrice" name="marketingPrice" value="{{ $data->marketing_Price }}" class="form-control" placeholder="การตลาด" onchange="balance();" readonly />
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">รวม คชจ. : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="totalkPrice" name="totalkPrice" value="{{number_format($data->totalk_Price, 2)}}" class="form-control" placeholder="รวม คชจ." onchange="balance();" readonly/>
                                  <input type="hidden" id="temptotalkPrice" name="temptotalkPrice" value="{{number_format($data->totalk_Price, 2)}}" class="form-control" placeholder="รวม คชจ." onchange="balance();" readonly/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <hr>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">คงเหลือ : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="balancePrice" name="balancePrice" value="{{number_format($data->balance_Price,2)}}" class="form-control" placeholder="คงเหลือ" readonly/>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">ค่าคอมหลังหัก 1.5%  : </label>
                                <div class="col-sm-8">
                                  <input type="text" id="commitPrice" name="commitPrice" value="{{number_format($data->commit_Price, 2)}}" class="form-control" placeholder="ค่าคอมหลังหัก" readonly/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right">หมายเหตุ : </label>
                                <div class="col-sm-8">
                                  <input type="text" name="notePrice" value="{{ $data->note_Price }}" class="form-control" placeholder="หมายเหตุ" />
                                </div>
                              </div>
                            </div>
                          @if($data->Payee_car == $data->Agent_car)
                            <div class="col-6">
                              <div class="form-group row mb-1">
                                <label class="col-sm-3 col-form-label text-right"><font color="red">รวมยอดโอน :</font> </label>
                                <div class="col-sm-8">
                                  <input type="text" value="{{ number_format($data->balance_Price+$data->commit_Price,2)}}" style="font-weight:bold;" class="form-control" readonly />
                                </div>
                              </div>
                            </div>
                          @endif
                          </div>
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
                      </div>
                    </div>

                    <input type="hidden" name="_method" value="PATCH"/>

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
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="nameSP2" value="{{$data->name_SP2}}" class="form-control" placeholder="ชื่อ" />
                                      @else
                                          <input type="text" name="nameSP2" value="{{$data->name_SP2}}" class="form-control" placeholder="ชื่อ" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
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
                                  <div class="form-group row mb-1">
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
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">สถานะ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="statusSP2" class="form-control">
                                          <option value="" selected>--- สถานะ ---</option>
                                          @foreach ($Statusby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->status_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="statusSP2" value="{{$data->status_SP2}}" class="form-control" placeholder="เลือกสถานะ" readonly/>
                                        @else
                                          <select name="statusSP2" class="form-control">
                                            <option value="" selected>--- สถานะ ---</option>
                                            @foreach ($Statusby as $key => $value)
                                              <option value="{{$key}}" {{ ($key == $data->status_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
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
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ความสัมพันธ์ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="relationSP2" class="form-control">
                                          <option value="" selected>--- ความสัมพันธ์ ---</option>
                                          @foreach ($relationSPp as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->relation_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="relationSP2" value="{{$data->relation_SP2}}" class="form-control" placeholder="เลือกความสัมพันธ์" readonly/>
                                        @else
                                          <select name="relationSP2" class="form-control">
                                            <option value="" selected>--- ความสัมพันธ์ ---</option>
                                            @foreach ($relationSPp as $key => $value)
                                              <option value="{{$key}}" {{ ($key == $data->relation_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
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
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">เลขบัตรประชาชน : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <input type="text" name="idcardSP2" value="{{$data->idcard_SP2}}" class="form-control" placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask=""/>
                                      @else
                                        <input type="text" name="idcardSP2" value="{{$data->idcard_SP2}}" class="form-control" placeholder="เลขบัตรประชาชน" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" {{ ($GetDocComplete !== NULL) ? 'readonly' : '' }}/>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ที่อยู่ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="addSP2" class="form-control">
                                          <option value="" selected>--- ที่อยู่ ---</option>
                                          @foreach ($Addby as $key => $value)
                                          <option value="{{$key}}" {{ ($key == $data->add_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                        <input type="text" name="addSP2" value="{{$data->add_SP2}}" class="form-control" placeholder="เลือกที่อยู่" readonly/>
                                        @else
                                          <select name="addSP2" class="form-control">
                                            <option value="" selected>--- ที่อยู่ ---</option>
                                            @foreach ($Addby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->add_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
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
                                  <div class="form-group row mb-1">
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
                                  <div class="form-group row mb-1">
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
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ลักษณะบ้าน : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="houseSP2" class="form-control">
                                          <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                          @foreach ($Houseby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->house_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                        <input type="text" name="houseSP2" value="{{$data->house_SP2}}" class="form-control" placeholder="เลือกลักษณะบ้าน" readonly/>
                                        @else
                                          <select name="houseSP2" class="form-control">
                                            <option value="" selected>--- เลือกลักษณะบ้าน ---</option>
                                            @foreach ($Houseby as $key => $value)
                                              <option value="{{$key}}" {{ ($key == $data->house_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ประเภทหลักทรัพย์ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="securitiesSP2" class="form-control">
                                          <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                          @foreach ($securitiesSPp as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->securities_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                        <input type="text" name="securitiesSP2" value="{{$data->securities_SP2}}" class="form-control" placeholder="ประเภทหลักทรัพย์" readonly/>
                                        @else
                                          <select name="securitiesSP2" class="form-control">
                                            <option value="" selected>--- ประเภทหลักทรัพย์ ---</option>
                                            @foreach ($securitiesSPp as $key => $value)
                                              <option value="{{$key}}" {{ ($key == $data->securities_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
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
                                  <div class="form-group row mb-1">
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
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ประเภทบ้าน : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="housestyleSP2" class="form-control">
                                          <option value="" selected>--- ประเภทบ้าน ---</option>
                                          @foreach ($HouseStyleby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->housestyle_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="housestyleSP2" value="{{$data->housestyle_SP2}}" class="form-control" placeholder="ประเภทบ้าน" readonly/>
                                        @else
                                          <select name="housestyleSP2" class="form-control">
                                            <option value="" selected>--- ประเภทบ้าน ---</option>
                                            @foreach ($HouseStyleby as $key => $value)
                                              <option value="{{$key}}" {{ ($key == $data->housestyle_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">อาชีพ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="careerSP2" class="form-control">
                                          <option value="" selected>--- อาชีพ ---</option>
                                          @foreach ($Careerby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->career_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                            <input type="text" name="careerSP2" value="{{$data->career_SP2}}" class="form-control" placeholder="อาชีพ" readonly/>
                                        @else
                                          <select name="careerSP2" class="form-control">
                                            <option value="" selected>--- อาชีพ ---</option>
                                            @foreach ($Careerby as $key => $value)
                                              <option value="{{$key}}" {{ ($key == $data->career_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">รายได้ : </label>
                                    <div class="col-sm-8">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="incomeSP2" class="form-control">
                                          <option value="" selected>--- รายได้ ---</option>
                                          @foreach ($Incomeby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->income_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="incomeSP2" value="{{$data->income_SP2}}" class="form-control" placeholder="รายได้" readonly/>
                                        @else
                                          <select name="incomeSP2" class="form-control" style="width: 200px;">
                                            <option value="" selected>--- รายได้ ---</option>
                                            @foreach ($Incomeby as $key => $value)
                                              <option value="{{$key}}" {{ ($key == $data->income_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">ประวัติซื้อ : </label>
                                    <div class="col-sm-4">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="puchaseSP2" class="form-control">
                                          <option value="" selected>--- ซื้อ ---</option>
                                          @foreach ($HisCarby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->puchase_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="puchaseSP2" value="{{$data->puchase_SP2}}" class="form-control" placeholder="ซื้อ" readonly/>
                                        @else
                                          <select name="puchaseSP2" class="form-control">
                                            <option value="" selected>--- ซื้อ ---</option>
                                            @foreach ($HisCarby as $key => $value)
                                              <option value="{{$key}}" {{ ($key == $data->puchase_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                      @endif
                                    </div>
                                    <div class="col-sm-4">
                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                        <select name="supportSP2" class="form-control">
                                          <option value="" selected>--- ค้ำ ---</option>
                                          @foreach ($HisCarby as $key => $value)
                                            <option value="{{$key}}" {{ ($key == $data->support_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @else
                                        @if($GetDocComplete != Null)
                                          <input type="text" name="supportSP2" value="{{$data->support_SP2}}" class="form-control" placeholder="ค้ำ" readonly/>
                                        @else
                                          <select name="supportSP2" class="form-control">
                                            <option value="" selected>--- ค้ำ ---</option>
                                            @foreach ($HisCarby as $key => $value)
                                              <option value="{{$key}}" {{ ($key == $data->support_SP2) ? 'selected' : '' }}>{{$value}}</option>
                                            @endforeach
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
    $("#image-file,#Account_image,#image_checker_1,#image_checker_2").fileinput({
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
      $SetBuyerlatlong = explode(",",$data->Buyer_latlong);
      $Buyerlat = $SetBuyerlatlong[0];
      $Buyerlong = $SetBuyerlatlong[1];
    @endphp
  @else 
    @php
      $Buyerlat = 0;
      $Buyerlong = 0;
    @endphp
  @endif

  @if($data->Support_latlong != NULL)
   @php
      $SetSupportlatlong = explode(",",$data->Support_latlong);
      $Supportlat = $SetSupportlatlong[0];
      $Supportlong = $SetSupportlatlong[1];
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
