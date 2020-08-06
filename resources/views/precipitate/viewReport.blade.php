@extends('layouts.master')
@section('title','แผนกเร่งรัดหนี้สิน')
@section('content')

  @php
    function DateThai($strDate){
      $strYear = date("Y",strtotime($strDate))+543;
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("d",strtotime($strDate));
      $strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      $strMonthThai=$strMonthCut[$strMonth];
      return "$strDay $strMonthThai $strYear";
    }
  @endphp

  <style>
    #todo-list{
    width:100%;
    margin:0 auto 0px auto;
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
          border-radius:5px;
    }
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
    top:calc(50% + 2px);
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
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-12 table-responsive">
            <div class="card">
              <div class="card-header">
                <h4 class="">
                  @if($type == 7)
                    รายงาน งานประจำวัน
                  @elseif($type == 8)
                    รายงาน รับชำระค่าติดตาม
                  @elseif($type == 9)
                    รายงาน ใบรับฝาก
                  @elseif($type == 10)
                    รายงาน หนังสือขอยืนยันบอกเลิกสัญญา
                  @endif
                </h4>
              </div>
              <div class="card-body text-sm">
                <!-- ส่วนพื้นที่ค้นหา -->
                @if($type == 7)
                  <form method="get" action="{{ route('Precipitate', 7) }}">
                    <div class="float-right form-inline">
                      <a href="{{ action('PrecController@excel') }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{1}}" class="btn bg-success btn-app">
                        <i class="far fa-file-excel"></i> Excel
                      </a>
                      <button type="submit" class="btn bg-warning btn-app">
                        <span class="fas fa-search"></span> Search
                      </button>
                    </div>
                    <br><br><br><p></p>
                    <div class="float-right form-inline">
                      <label>จากวันที่ : </label>
                      <input type="date" name="Fromdate" style="width: 180px;" value="{{ ($fdate != '') ?$fdate: '' }}" class="form-control" />
                      <label>ถึงวันที่ : </label>
                      <input type="date" name="Todate" style="width: 180px;" value="{{ ($tdate != '') ?$tdate: '' }}" class="form-control" />
                    </div>
                  </form>
                  <br><br>
                @elseif($type == 8)
                  <form method="get" action="{{ route('Precipitate', 8) }}">
                    <div class="row">
                      <div class="col-md-10">
                        <div class="float-right form-inline">
                          <i class="fas fa-grip-vertical"></i>
                          <span class="todo-wrap">
                            @if($Office != Null)
                              <input type="checkbox" id="1" name="DataOffice" value="{{ $Office }}" checked="checked"/ >
                            @else
                              <input type="checkbox" id="1" name="DataOffice" value="Y"/ >
                            @endif
                            <label for="1" class="todo">
                              <i class="fa fa-check"></i>
                              <font color="red">แสดงข้อมูลบริษัท</font>
                            </label>
                          </span>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="float-right form-inline">
                          <a target="_blank" id="SendData" class="btn bg-danger btn-app" href="{{ action('PrecController@ReportPrecDue',[00,00]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{8}}&DataOffice={{$Office}}">
                            <i class="far fa-file-pdf"></i> PDF
                          </a>
                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="float-right form-inline">
                      <label>จากวันที่ : </label>
                      <input type="date" name="Fromdate" style="width: 180px;" value="{{ ($fdate != '') ?$fdate: '' }}" class="form-control" />
                      <label>ถึงวันที่ : </label>
                      <input type="date" name="Todate" style="width: 180px;" value="{{ ($tdate != '') ?$tdate: '' }}" class="form-control" />
                    </div>
                  </form>
                  <br><br>
                @elseif($type == 9)
                  <form method="get" action="{{ route('Precipitate', 9) }}">
                    <div class="row">
                      <div class="col-12">
                        <div class="float-right form-inline">
                          <label>ดิววันที่ : </label>
                          <input type="date" name="SelectDate" style="width: 180px;" value="{{ ($newdate != '') ?$newdate: '' }}" class="form-control" />
                          <a class="btn bg-success btn-app" href="{{ action('PrecController@excel') }}?SelectDate={{$newdate}}&type={{9}}">
                            <i class="far fa-file-excel"></i> Excel
                          </a>
                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>
                      </div>  
                    </div>
                  </form>
                @elseif($type == 10) {{-- ระบบ หนังสือบอกเลิก --}}
                    <form method="get" action="{{ route('Precipitate', 10) }}">
                      <div class="row">
                        <div class="col-12">
                          <div class="float-right form-inline">
                            <label>เลขที่สัญญา : </label>
                            <input type="type" name="Contno" value="{{$contno}}" style="padding:5px;width:180px;border-radius: 5px 0 5px 5px; font-size:20px;"/>
                            <button type="submit" class="btn bg-warning btn-app">
                              <span class="fas fa-search"></span> Search
                            </button>
                          </div>
                        </div>
                      </div>
                    </form>
                @endif

                <!-- ส่วนพื้นที่แสดงผล -->
                @if($type == 7)
                  <div class="card card-warning card-tabs">
                    <div class="card-header p-0 pt-1">
                      <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="custom-tabs-1" data-toggle="pill" href="#tabs-1" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">ปล่อยงานตาม & โนติส</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-2" data-toggle="pill" href="#tabs-2" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">ปล่อยงานเร่งรัด & เตรียมฟ้อง</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade active show" id="tabs-1" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                          <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                              <div class="info-box bg-orange">
                                <span class="info-box-icon bg-warning"><i class="fas fa-people-arrows"></i></span>
                                <div class="info-box-content">
                                  <h5>ปล่อยงานตาม (3.00 - 4.96)</h5>
                                  <span class="info-box-number">ดิววันที่ {{DateThai($newfdate)}}</span>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-12 border-center">
                                  <div class="table-responsive">
                                  <table class="table table-bordered" id="table">
                                      <thead class="thead-dark bg-gray-light" >
                                        <tr>
                                          <!-- <th class="text-center">ลำดับ</th> -->
                                          <th class="text-center">เลขที่สัญญา</th>
                                          <th class="text-center">ชื่อ-สกุล</th>
                                          <th class="text-center">ค้างจริง</th>
                                          <th class="text-center">พนง</th>
                                          <th class="text-center">สถานะ</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($dataFollow as $key => $row)
                                          <tr>
                                            <!-- <td class="text-center"> {{$key+1}} </td> -->
                                            <td class="text-center"> {{$row->CONTNO}}</td>
                                            <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                                            <td class="text-center"> {{$row->HLDNO}} </td>
                                            <td class="text-center"> {{$row->BILLCOLL}} </td>
                                            <td class="text-center"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->CONTSTAT)) }} </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-6 col-12">
                              <div class="info-box bg-primary">
                                <span class="info-box-icon bg-info"><i class="fas fa-people-carry"></i></span>
                                <div class="info-box-content">
                                  <h5>ปล่อยงานโนติส (4.70 - 5.69)</h5>
                                  <span class="info-box-number">ดิววันที่ {{DateThai($fdate)}}</span>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-12 border-center">
                                  <div class="table-responsive">
                                  <table class="table table-bordered" id="table">
                                      <thead class="thead-dark bg-gray-light" >
                                        <tr>
                                          <!-- <th class="text-center">ลำดับ</th> -->
                                          <th class="text-center">เลขที่สัญญา</th>
                                          <th class="text-center">ชื่อ-สกุล</th>
                                          <th class="text-center">ค้างจริง</th>
                                          <th class="text-center">พนง</th>
                                          <th class="text-center">สถานะ</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($dataNotice as $key => $row)
                                          <tr>
                                            <!-- <td class="text-center"> {{$key+1}} </td> -->
                                            <td class="text-center"> {{$row->CONTNO}}</td>
                                            <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                                            <td class="text-center"> {{$row->HLDNO}} </td>
                                            <td class="text-center"> {{$row->BILLCOLL}} </td>
                                            <td class="text-center"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->CONTSTAT)) }} </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                          <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                              <div class="info-box bg-orange">
                                <span class="info-box-icon bg-warning"><i class="fas fa-hands-helping"></i></span>
                                <div class="info-box-content">
                                  <h5>ปล่อยงานเร่งรัด (3.70 - 4.69)</h5>
                                  <span class="info-box-number">ดิววันที่ {{DateThai($fdate)}}</span>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-12 border-center">
                                  <div class="table-responsive">
                                  <table class="table table-bordered" id="table">
                                      <thead class="thead-dark bg-gray-light" >
                                        <tr>
                                          <!-- <th class="text-center">ลำดับ</th> -->
                                          <th class="text-center">เลขที่สัญญา</th>
                                          <th class="text-center">ชื่อ-สกุล</th>
                                          <th class="text-center">ค้างจริง</th>
                                          <th class="text-center">พนง</th>
                                          <th class="text-center">สถานะ</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($dataPrec as $key => $row)
                                          <tr>
                                            <!-- <td class="text-center"> {{$key+1}} </td> -->
                                            <td class="text-center"> {{$row->CONTNO}}</td>
                                            <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                                            <td class="text-center"> {{$row->HLDNO}} </td>
                                            <td class="text-center"> {{$row->BILLCOLL}} </td>
                                            <td class="text-center"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->CONTSTAT)) }} </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-6 col-12">
                              <div class="info-box bg-primary">
                                <span class="info-box-icon bg-info"><i class="fas fa-gavel"></i></span>
                                <div class="info-box-content">
                                  <h5>ปล่อยงานเตรียมฟ้อง (5.70 - 6.69)</h5>
                                  <span class="info-box-number">ดิววันที่ {{DateThai($fdate)}}</span>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-12 border-center">
                                  <div class="table-responsive">
                                  <table class="table table-bordered" id="table">
                                      <thead class="thead-dark bg-gray-light" >
                                        <tr>
                                          <!-- <th class="text-center">ลำดับ</th> -->
                                          <th class="text-center">เลขที่สัญญา</th>
                                          <th class="text-center">ชื่อ-สกุล</th>
                                          <th class="text-center">ค้างจริง</th>
                                          <th class="text-center">พนง</th>
                                          <th class="text-center">สถานะ</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($dataLegis as $key => $row)
                                          <tr>
                                            <!-- <td class="text-center"> {{$key+1}} </td> -->
                                            <td class="text-center"> {{$row->CONTNO}}</td>
                                            <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                                            <td class="text-center"> {{$row->HLDNO}} </td>
                                            <td class="text-center"> {{$row->BILLCOLL}} </td>
                                            <td class="text-center"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->CONTSTAT)) }} </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @elseif($type == 8)
                  <hr />
                  <div class="row" align="left">
                    <div class="col-md-4">
                      <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-info">
                          <h3 class="widget-user-username">ทีมแบเลาะ (102)</h3>
                          <h5 class="widget-user-desc">2.5 - 4.67</h5>
                        </div>
                        <div class="widget-user-image">
                          <img class="img-circle" src="{{ asset('/dist/img/102.png') }}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($fdate)}}</h5>
                                <span class="description-text">จากวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($tdate)}}</h5>
                                <span class="description-text">ถึงวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="description-block">
                                @php
                                  $summary102 = 0;
                                @endphp
                                @foreach($data as $key => $value)
                                  @if($value->BILLCOLL == 102)
                                    @php
                                      $summary102 += $value->TOTAMT;
                                    @endphp
                                    @if($value->CANDATE != "")
                                      @php
                                        $summary102 -= $value->TOTAMT;
                                      @endphp
                                    @endif
                                  @endif
                                @endforeach
                                <h5 class="description-header">{{number_format($summary102, 2)}}</h5>
                                <span class="description-text">รวม</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-info">
                          <h3 class="widget-user-username">ทีมแบฮะ (104)</h3>
                          <h5 class="widget-user-desc">2.5 - 4.67</h5>
                        </div>
                        <div class="widget-user-image">
                          <img class="img-circle" src="{{ asset('/dist/img/104.png') }}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($fdate)}}</h5>
                                <span class="description-text">จากวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($tdate)}}</h5>
                                <span class="description-text">ถึงวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="description-block">
                                @php
                                  $summary104 = 0;
                                @endphp
                                @foreach($data as $key => $value)
                                  @if($value->BILLCOLL == 104)
                                    @php
                                      $summary104 += $value->TOTAMT;
                                    @endphp
                                    @if($value->CANDATE != "")
                                      @php
                                        $summary104 -= $value->TOTAMT;
                                      @endphp
                                    @endif
                                  @endif
                                @endforeach
                                <h5 class="description-header">{{number_format($summary104, 2)}}</h5>
                                <span class="description-text">รวม</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-info">
                          <h3 class="widget-user-username">ทีมพี่เบร์ (105)</h3>
                          <h5 class="widget-user-desc">2.5 - 4.67</h5>
                        </div>
                        <div class="widget-user-image">
                          <img class="img-circle" src="{{ asset('/dist/img/105.png') }}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($fdate)}}</h5>
                                <span class="description-text">จากวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($tdate)}}</h5>
                                <span class="description-text">ถึงวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="description-block">
                                @php
                                  $summary105 = 0;
                                @endphp
                                @foreach($data as $key => $value)
                                  @if($value->BILLCOLL == 105)
                                    @php
                                      $summary105 += $value->TOTAMT;
                                    @endphp
                                    @if($value->CANDATE != "")
                                      @php
                                        $summary105 -= $value->TOTAMT;
                                      @endphp
                                    @endif
                                  @endif
                                @endforeach
                                <h5 class="description-header">{{number_format($summary105, 2)}}</h5>
                                <span class="description-text">รวม</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" align="left">
                    <div class="col-md-4">
                      <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-info">
                          <h3 class="widget-user-username">ทีมแบยี (113)</h3>
                          <h5 class="widget-user-desc">2.5 - 4.67</h5>
                        </div>
                        <div class="widget-user-image">
                          <img class="img-circle" src="{{ asset('/dist/img/113.png') }}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($fdate)}}</h5>
                                <span class="description-text">จากวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($tdate)}}</h5>
                                <span class="description-text">ถึงวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="description-block">
                                @php
                                  $summary113 = 0;
                                @endphp
                                @foreach($data as $key => $value)
                                  @if($value->BILLCOLL == 113)
                                    @php
                                      $summary113 += $value->TOTAMT;
                                    @endphp
                                    @if($value->CANDATE != "")
                                      @php
                                        $summary113 -= $value->TOTAMT;
                                      @endphp
                                    @endif
                                  @endif
                                @endforeach
                                <h5 class="description-header">{{number_format($summary113, 2)}}</h5>
                                <span class="description-text">รวม</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-danger">
                          <h3 class="widget-user-username">ทีมแบลัง (112)</h3>
                          <h5 class="widget-user-desc">4.7 - 5.69</h5>
                        </div>
                        <div class="widget-user-image">
                          <img class="img-circle" src="{{ asset('/dist/img/112.png') }}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($fdate)}}</h5>
                                <span class="description-text">จากวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($tdate)}}</h5>
                                <span class="description-text">ถึงวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="description-block">
                                @php
                                  $summary112 = 0;
                                @endphp
                                @foreach($data as $key => $value)
                                  @if($value->BILLCOLL == 112)
                                    @php
                                      $summary112 += $value->TOTAMT;
                                    @endphp
                                    @if($value->CANDATE != "")
                                      @php
                                        $summary112 -= $value->TOTAMT;
                                      @endphp
                                    @endif
                                  @endif
                                @endforeach
                                <h5 class="description-header">{{number_format($summary112, 2)}}</h5>
                                <span class="description-text">รวม</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-danger">
                          <h3 class="widget-user-username">ทีมแบนัน (114)</h3>
                          <h5 class="widget-user-desc">4.7 - 5.69</h5>
                        </div>
                        <div class="widget-user-image">
                          <img class="img-circle" src="{{ asset('/dist/img/114.png') }}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($fdate)}}</h5>
                                <span class="description-text">จากวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($tdate)}}</h5>
                                <span class="description-text">ถึงวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="description-block">
                                @php
                                  $summary114 = 0;
                                @endphp
                                @foreach($data as $key => $value)
                                  @if($value->BILLCOLL == 114)
                                    @php
                                      $summary114 += $value->TOTAMT;
                                    @endphp
                                    @if($value->CANDATE != "")
                                      @php
                                        $summary114 -= $value->TOTAMT;
                                      @endphp
                                    @endif
                                  @endif
                                @endforeach
                                <h5 class="description-header">{{number_format($summary114, 2)}}</h5>
                                <span class="description-text">รวม</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" align="left">
                    <div class="col-md-6">
                      <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-warning">
                          <h3 class="widget-user-username">CKL</h3>
                          <h5 class="widget-user-desc">Founder & CEO</h5>
                        </div>
                        <div class="widget-user-image">
                          <img class="img-circle" src="{{ asset('/dist/img/leasingLogo1.jpg') }}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($fdate)}}</h5>
                                <span class="description-text">จากวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($tdate)}}</h5>
                                <span class="description-text">ถึงวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="description-block">
                                @php
                                  $summaryCKL = 0;
                                @endphp
                                @foreach($data as $key => $value)
                                  @if($value->BILLCOLL == "CKL   ")
                                    @php
                                      $summaryCKL += $value->TOTAMT;
                                    @endphp
                                    @if($value->CANDATE != "")
                                      @php
                                        $summaryCKL -= $value->TOTAMT;
                                      @endphp
                                    @endif
                                  @endif
                                @endforeach

                                <h5 class="description-header">{{number_format($summaryCKL, 2)}}</h5>
                                <span class="description-text">รวม</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-warning">
                          <h3 class="widget-user-username">ผลรวม</h3>
                          <h5 class="widget-user-desc">Founder & CEO</h5>
                        </div>
                        <div class="widget-user-image">
                          <img class="img-circle" src="{{ asset('/dist/img/sum.png') }}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($fdate)}}</h5>
                                <span class="description-text">จากวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{DateThai($tdate)}}</h5>
                                <span class="description-text">ถึงวันที่</span>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="description-block">
                                @php
                                  $summary = 0;
                                @endphp
                                    @php
                                      $summary = $summary102 + $summary104 + $summary105 + $summary113 + $summary112 + $summary114 + $summaryCKL;
                                    @endphp
                                <h5 class="description-header">{{number_format($summary, 2)}}</h5>
                                <span class="description-text">รวม</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @elseif($type == 9)
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card card-widget widget-user-2">
                        <div class="widget-user-header bg-yellow">
                          <div class="widget-user-image">
                            <img class="img-circle" src="{{ asset('/dist/img/listbook.png') }}" alt="User Avatar">
                          </div>
                          <h3 class="widget-user-username">รายชื่อผู้ค้ำ</h3>
                          <h5 class="widget-user-desc">2 - 2.99</h5>
                        </div>
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-12 border-center">
                              <div class="table-responsive">
                              <table class="table table-bordered" id="table">
                                  <thead class="thead-dark bg-gray-light" >
                                    <tr>
                                      <th class="text-center">ลำดับ</th>
                                      <th class="text-center">ชื่อ-สกุล</th>
                                      <th class="text-center">เลขที่สัญญา</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($dataSup as $key => $row)
                                      <tr>
                                        <td class="text-center"> {{$key+1}} </td>
                                        <td class="text-left"> {{iconv('Tis-620','utf-8',$row->NAME)}} </td>
                                        <td class="text-center"> {{$row->CONTNO}}</td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card card-widget widget-user-2">
                        <div class="widget-user-header bg-red">
                          <div class="widget-user-image">
                            <img class="img-circle" src="{{ asset('/dist/img/analy.png') }}" alt="User Avatar">
                          </div>
                          <h3 class="widget-user-username">รายชื่อผู้ซื้อและผู้ค้ำ</h3>
                          <h5 class="widget-user-desc">3 - 4.69</h5>
                        </div>

                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-12 border-center">
                              <div class="table-responsive">
                              <table class="table table-bordered" id="table">
                                  <thead class="thead-dark bg-gray-light" >
                                    <tr>
                                      <th class="text-center">ลำดับ</th>
                                      <th class="text-center">ชื่อ-สกุล</th>
                                      <th class="text-center">เลขที่สัญญา</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($dataUseSup as $key => $row)
                                      <tr>
                                        <td class="text-center"> {{$key+1}} </td>
                                        <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                                        <td class="text-center"> {{$row->CONTNO}}</td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @elseif($type == 10) {{-- ระบบ หนังสือบอกเลิก --}}
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead class="thead-dark bg-gray-light" >
                              <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">เลขที่สัญญา</th>
                                <th class="text-center">ชื่อ-สกุล</th>
                                <th class="text-center">วันทำสัญญา</th>
                                <th class="text-center">ลูกหนี้คงเหลือ</th>
                                <th class="text-center">ยอดค้างชำระ</th>
                                <th class="text-center">ค้างงวดจริง</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center" style="width: 100px">ตัวเลือก</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $key => $row)
                                <tr>
                                  <td class="text-center"> {{$key+1}} </td>
                                  <td class="text-center"> {{$row->CONTNO}}</td>
                                  <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                                  <td class="text-center">
                                    @php
                                    $StrCon = explode("/",$row->CONTNO);
                                    $SetStr1 = $StrCon[0];
                                    $SetStr2 = $StrCon[1];

                                    $ISSUDT= date_create($row->ISSUDT);
                                    @endphp
                                    {{ date_format($ISSUDT, 'd-m-Y')}}
                                  </td>
                                  <td class="text-center text-danger"> {{number_format($row->BALANC - $row->SMPAY,2)}} </td>
                                  <td class="text-center text-danger"> {{number_format($row->EXP_AMT,2)}} </td>
                                  <td class="text-center text-danger"> {{number_format($row->HLDNO,2)}} </td>
                                  <td class="text-center"> {{iconv('Tis-620','utf-8', $row->CONTSTAT)}} </td>
                                  <td class="text-center">
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-addinfo" data-str1="{{$SetStr1}}" data-str2="{{ $SetStr2 }}" title="{{$SetStr1.'/'.$SetStr2}}" data-backdrop="static" data-keyboard="false">
                                      <i class="fa fa-edit"></i> เพิ่มข้อมูล
                                    </button>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                    </div>
                  </div>
                @endif

                <a id="button"></a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <div class="modal fade" id="modal-addinfo">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form name="form1" method="post" action="{{ route('MasterPrecipitate.store') }}" target="_blank" enctype="multipart/form-data">
          @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="title" align="center"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <input type="date" id="Datepay" name="AcceptDate" class="form-control" required/>
              <br>
              <input type="text" id="PayAmount" name="PayAmount" class="form-control" placeholder="ป้อนยอดชำระ" oninput="addcomma();" required/>
              <br>
              <input type="text" id="BalanceAmount" name="BalanceAmount" class="form-control" placeholder="ป้อนยอดคงขาด" oninput="addcomma();" required/>
              <input type="hidden" name="type" class="form-control" value="10" />
              <input type="hidden" id="contno" name="contno" class="form-control" />
            </div>
            <div align="center">
              <button id="submit" type="submit" class="btn btn-primary"><span class="fa fa-id-card-o"></span> พิมพ์</button>
            </div>
            <br/>
      </form>
      </div>
    </div>
  </div>

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

  <script type="text/javascript">
    $(document).ready(function(){
      $('#SendData').click(function() {
          var Getflag = $('#1').val();

        $.ajax({
          methods:'POST',
          url:"{{ route('Precipitate', 8) }}",
          data:Getflag,
          success:function(data){
          }
        });
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#table,#table1,#table2,#table3').DataTable( {
        "order": [[ 0, "asc" ]],
        "pageLength": 10,
        "searching": true,
      } );
    } );
  </script>

  <script type="text/javascript">
    // $("#submit").click(function () {
    //   $("#modal-addinfo").modal('toggle');
    //   location.reload();
    // });
    $('#modal-addinfo').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var SetStr1 = button.data('str1')
      var SetStr2 = button.data('str2')
      var Contno = SetStr1 + '/' +SetStr2
      var title = 'เลขที่สัญญา : '+ SetStr1 + '/' + SetStr2
      var modal = $(this);
      modal.find('.modal-body #SetStr1').val(SetStr1);
      modal.find('.modal-body #SetStr2').val(SetStr2);
      modal.find('.modal-body #contno').val(Contno);
      modal.find('.modal-header #title').text(title);
    });

    $("#btnclose").click(function () {
      $("#modal-addinfo").modal('hide');
      var Datepay = ''
      var PayAmount = ''
      var BalanceAmount = ''
      $('#Datepay').val(Datepay);
      $('#PayAmount').val(PayAmount);
      $('#BalanceAmount').val(BalanceAmount);
    });
  </script>

  <script type="text/javascript">
    function addCommas(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
      return x1 + x2;
    }
    function addcomma(){
      var num11 = document.getElementById('PayAmount').value;
      var num1 = num11.replace(",","");
      var num22 = document.getElementById('BalanceAmount').value;
      var num2 = num22.replace(",","");
      document.form1.PayAmount.value = addCommas(num1);
      document.form1.BalanceAmount.value = addCommas(num2);
    }
  </script>

@endsection
