@extends('layouts.master')
@section('title','แผนกกฏหมาย')
@section('content')

@php
  date_default_timezone_set('Asia/Bangkok');
  $date = date('Y-m-d', strtotime('-1 days'));
@endphp

@php
  date_default_timezone_set('Asia/Bangkok');
  $Y = date('Y') + 543;
  $Y2 = date('Y');
  $m = date('m');
  $d = date('d');
  $time = date('H:i');
  $date = $Y2.'-'.$m.'-'.$d;
  $date2 = $Y.'-'.$m.'-'.$d;
@endphp

@php
  function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
    //return "$strDay-$strMonthThai-$strYear";
  }
@endphp

  <!-- Main content -->
  <section class="content">
    <div class="content-header">
      @if(session()->has('success'))
        <script type="text/javascript">
          toastr.success('{{ session()->get('success') }}')
        </script>
      @endif

      <section class="content">
        <div class="row justify-content-center">
          <div class="col-12 table-responsive">
            <div class="card">
              <div class="card-header">
                <h4 class="">
                  @if($type == 1)
                    รายชื่อส่งฟ้อง
                  @elseif($type == 2)
                    ลูกหนี้ฟ้อง
                  @elseif($type == 6)
                    ลูกหนี้เตรียมฟ้อง
                  @elseif($type == 7)
                    ลูกหนี้ประนอมหนี้
                  @elseif($type == 8)
                    ลูกหนี้สืบทรัพย์
                  @elseif($type == 10)
                    ลูกหนี้ของกลาง
                  @elseif($type == 12)
                    ลูกหนี้ขายฝาก
                  @endif
                </h4>
              </div>
              <div class="card-body text-sm">

                <div class="row">
                  @if($type == 1)   {{--รายชื่อ--}}
                    <div class="col-md-12">
                      <div class="tab-content">
                        <div class="table-responsive">
                          <table class="table table-bordered" id="table">
                            <thead class="thead-dark bg-gray-light" >
                              <tr>
                                <th class="text-center" style="width: 10px">ลำดับ</th>
                                <th class="text-center">เลขที่สัญญา</th>
                                <th class="text-center">ชื่อ-สกุล</th>
                                <th class="text-center">วันที่ทำสัญญา</th>
                                <th class="text-center">ยอดคงเหลือ</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ค้างงวดจริง</th>
                                <th class="text-center" style="width: 130px">ตัวเลือก</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($arrayMerge as $key => $row)
                                <tr>
                                  <td class="text-center"> {{$key+1}} </td>
                                  <td class="text-center">
                                    {{$row->CONTNO}}
                                    @php
                                      $StatusCheck = (iconv('TIS-620', 'utf-8', str_replace(" ","",$row->CONTSTAT)));
                                    @endphp
                                    @if($StatusCheck == "ป")
                                      <span class="label label-warning">ประนอม</span>
                                    @endif
                                  </td>
                                  <td class="text-left">{{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}}</td>
                                  <td class="text-center"> {{ DateThai($row->FDATE) }} </td>
                                  <td class="text-center"> {{ number_format($row->BALANC - $row->SMPAY, 2) }} </td>
                                  <td class="text-center">
                                    @php
                                      $Flag = "N";
                                      $SetBaab = iconv('Tis-620','utf-8',str_replace(" ","",$row->BAAB));
                                    @endphp

                                    @foreach($result2 as $key => $value)
                                      @if($row->CONTNO == $value->CONTNO)
                                        มีหลักพรัทย์
                                        @php
                                          $Flag = "Y";
                                          $Realty = "มีหลักพรัทย์";
                                        @endphp
                                      @endif
                                    @endforeach

                                    @if($Flag == "N")
                                      @if($SetBaab == "มีหลักพรัทย์")
                                        มีหลักพรัทย์
                                        @php
                                          $Realty = "มีหลักพรัทย์";
                                        @endphp
                                      @else
                                        ไม่มีหลักพรัทย์
                                        @php
                                          $Realty = "ไม่มีหลักพรัทย์";
                                        @endphp
                                      @endif
                                    @endif
                                  </td>
                                  <td class="text-center"> {{$row->HLDNO}} </td>
                                  <td class="text-center">
                                    @php
                                      $StrCon = explode("/",$row->CONTNO);
                                      $SetStr1 = $StrCon[0];
                                      $SetStr2 = $StrCon[1];

                                      $Tax = "N";
                                      $TaxStat = "N";
                                    @endphp

                                    @foreach($dataDB as $key => $row1)
                                      @if($row->CONTNO == $row1->Contract_legis)
                                          @if($row1->Flag_status == 1)
                                            <button class="btn btn-warning btn-sm" title="จัดเตรียมฟ้อง">
                                              <i class="fas fa-check-square"></i> เตรียมฟ้อง
                                            </button>
                                          @elseif($row1->Flag_status == 3)
                                            <button class="btn btn-success btn-sm" title="ลูกหนี้ประนอมหนี้">
                                              <i class="fas fa-balance-scale"></i> ประนอมหนี้
                                            </button>
                                          @else
                                            <button class="btn btn-success btn-sm" title="ขั้นตอนการฟ้อง">
                                              <i class="fas fa-gavel"></i> ลูกหนี้ฟ้อง
                                            </button>
                                          @endif
                                        @php
                                          $Tax = "Y";
                                          $TaxStat = "Y";
                                        @endphp
                                      @endif
                                    @endforeach

                                    @if($StatusCheck != "ป")
                                      @if($Tax == "N")
                                        <a href="{{ route('legislation.Savestore', [$SetStr1,$SetStr2,$Realty,1]) }}" id="edit" class="btn btn-danger btn-sm" title="จัดเตรียมเอกสาร">
                                          <i class="fas fa-external-link-alt"></i> ส่งเอกสาร
                                        </a>
                                      @endif
                                    @else
                                      @if($TaxStat == "N")
                                        <a href="{{ route('legislation.Savestore', [$SetStr1,$SetStr2,$Realty,2]) }}" id="edit" class="btn btn-info btn-sm" title="ประนอมหนี้">
                                          <i class="fas fa-external-link-alt"></i> ส่งประนอม
                                        </a>
                                      @endif
                                    @endif
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  @elseif($type == 2)  {{--ลูกหนี้ฟ้อง--}}
                    <div class="col-md-12">
                      <form method="get" action="{{ route('legislation', 2) }}">
                        <div class="float-right form-inline">
                          <div class="btn-group">
                            <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                              <span class="fas fa-print"></span> ปริ้นรายงาน
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-4" data-link="{{ route('legislation', 17) }}"> รายงานลูกหนี้</a></li>
                              <li class="dropdown-divider"></li>
                              <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-5" data-link="{{ route('legislation', 18) }}"> รายงานลูกหนี้สืบพยาน</a></li>
                            </ul>
                          </div>
                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>
                        <br><br><br><p></p>
                        <div class="float-right form-inline">
                          <label for="text" class="mr-sm-2">สถานะปิดงาน : </label>
                          <select name="StateLegis" class="form-control" id="text" style="width: 180px">
                            <option selected value="">--- สถานะ ---</option>
                            <option value="จ่ายจบก่อนฟ้อง" {{ ($StateLegis == 'จ่ายจบก่อนฟ้อง') ? 'selected' : '' }}>จ่ายจบก่อนฟ้อง</otion>
                            <option value="ยึดรถก่อนฟ้อง" {{ ($StateLegis == 'ยึดรถก่อนฟ้อง') ? 'selected' : '' }}>ยึดรถก่อนฟ้อง</otion>
                            <option value="ปิดบัญชีประนอมหนี้" {{ ($StateLegis == 'ปิดบัญชีประนอมหนี้') ? 'selected' : '' }}>ปิดบัญชีประนอมหนี้</otion>
                            <option value="ยึดรถหลังฟ้อง" {{ ($StateLegis == 'ยึดรถหลังฟ้อง') ? 'selected' : '' }}>ยึดรถหลังฟ้อง</otion>
                            <option value="หมดอายุความคดี" {{ ($StateLegis == 'หมดอายุความคดี') ? 'selected' : '' }}>หมดอายุความคดี</otion>
                          </select>
  
                          <label for="text" class="mr-sm-2">สถานะ : </label>
                          <select name="StateCourt" class="form-control" id="text" style="width: 180px">
                            <option selected value="">--- สถานะ ---</option>
                            <option value="ชั้นศาล" {{ ($StateCourt == 'ชั้นศาล') ? 'selected' : '' }}>ชั้นศาล</otion>
                            <option value="ชั้นบังคับคดี" {{ ($StateCourt == 'ชั้นบังคับคดี') ? 'selected' : '' }}>ชั้นบังคับคดี</otion>
                          </select>
                        </div>
                        <br><br>
                        <div class="float-right form-inline">
                          <label>จากวันที่ : </label>
                          <input type="date" name="Fromdate" style="width: 180px;" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />
  
                          <label>ถึงวันที่ : </label>
                          <input type="date" name="Todate" style="width: 180px;" value="{{ ($newtdate != '') ?$newtdate: date('Y-m-d') }}" class="form-control" />
                        </div>
                      </form>
                      <br><br>
                    </div>
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                          <thead class="thead-dark bg-gray-light" >
                            <tr>
                              {{-- <th class="text-center">No.</th> --}}
                              <th class="text-center" style="width: 70px">Job.</th>
                              <th class="text-center">ชื่อ-สกุล</th>
                              <th class="text-center" style="width: 40px">วันถืองาน</th>
                              <th class="text-center" style="width: 60px">วันฟ้อง</th>
                              <th class="text-center" style="width: 40px">ระยะเวลา</th>
                              <th class="text-center" style="width: 100px">สถานะลูกหนี้</th>
                              <th class="text-center" style="width: 100px">สถานะทรัพย์</th>
                              <th class="text-center" style="width: 100px">สถานะประนอม</th>
                              <th class="text-center" style="width: 70px">ผู้ส่งฟ้อง</th>
                              <th class="text-center" style="width: 50px">ตัวเลือก</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $key => $row)
                              <tr>
                                {{-- <td class="text-center"> {{$key+1}} </td> --}}
                                <td class="text-center"> {{$row->Contract_legis}}</a></td>
                                <td class="text-left"> {{$row->Name_legis}} </td>
                                <td class="text-center">  <!-- วันถืองาน -->
                                  @if($row->DateComplete_court != Null)
                                    @php
                                      $Cldate = date_create($row->Datesend_Flag);
                                      $nowCldate = date_create($row->DateComplete_court);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <font color="green">{{$duration}}</font>
                                  @elseif($row->DateUpState_legis != Null)
                                    @php
                                      $Cldate = date_create($row->Datesend_Flag);
                                      $nowCldate = date_create($row->DateUpState_legis);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <font color="green">{{$duration}}</font>
                                  @elseif($row->DateComplete_court == Null)
                                    @php
                                      $Cldate = date_create($row->Datesend_Flag);
                                      $nowCldate = date_create($date);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <font color="red">{{$duration}}</font>
                                  @endif
                                </td>
                                <td class="text-center">  <!-- วันฟ้อง -->
                                  @if($row->fillingdate_court != NUll)
                                    {{ DateThai($row->fillingdate_court) }}
                                  @endif
                                </td>
                                <td class="text-center">  <!-- ระยะเวลา -->
                                  @if($row->Status_legis != Null)
                                    @php
                                      $Cldate = date_create($row->DateComplete_court);
                                      $nowCldate = date_create($row->DateUpState_legis);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <font color="green">{{$duration}}</font>
                                  @else
                                    @php
                                      $Cldate = date_create($row->fillingdate_court);
                                      $nowCldate = date_create($date);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <font color="red">{{$duration}}</font>
                                  @endif
                                </td>
                                <td class="text-center">  <!-- สถานะลูกหนี้ -->
                                  @if($row->Status_legis != NULL)
                                    <button type="button" class="btn btn-success btn-sm" title="{{ $row->Status_legis }}">
                                      <i class="fas fa-check-square prem"></i> {{ $row->Status_legis }}
                                    </button>
                                  @else   <!-- ชั้นศาล -->
                                    @php
                                      $SetText = 'รอฟ้อง';
                                      $Newdate = date_create($date);
                                    @endphp
    
                                    @if($row->examiday_court != Null) <!-- วันที่สืบพยาน -->
                                      @php
                                        $Tab1 = date_create($row->examiday_court);
                                        $DateEx = date_diff($Newdate,$Tab1);
                                      @endphp
    
                                      @if($row->fuzzy_court != Null)  <!-- วันที่ส่งจริง/ส่งคำบังคับ -->
                                        @php
                                          $Tab1 = date_create($row->fuzzy_court);
                                          $DateEx = date_diff($Newdate,$Tab1);
                                        @endphp
                                      @endif
    
                                      @if($row->ordersend_court != Null)  <!-- วันที่ตรวจผลหมายจริง -->
                                        @php
                                          $Tab2 = date_create($row->ordersend_court);
                                          $DateEx2 = date_diff($Newdate,$Tab2);
                                        @endphp
                                      @elseif($row->ordersend_court == Null)
                                        @php
                                          $Tab2 = date_create($row->orderday_court);
                                          $DateEx2 = date_diff($Newdate,$Tab2);
                                        @endphp
                                      @endif
    
                                      @if($row->checkday_court != Null) <!-- วันที่ตรวจผลหมาย -->
                                        @php
                                          $Tab3 = date_create($row->checkday_court);
                                          $DateEx3 = date_diff($Newdate,$Tab3);
                                        @endphp
                                      @endif
    
                                      @if($row->sendoffice_court != Null) <!-- วันที่ตั้งเจ้าพนักงาน -->
                                        @php
                                          $Tab4 = date_create($row->sendoffice_court);
                                          $DateEx4 = date_diff($Newdate,$Tab4);
                                        @endphp
                                      @elseif($row->sendoffice_court == Null)
                                        @php
                                          $Tab4 = date_create($row->setoffice_court);
                                          $DateEx4 = date_diff($Newdate,$Tab4);
                                        @endphp
                                      @endif
    
                                      @if($row->sendcheckresults_court != Null) <!-- วันที่ตรวจผลหมายตั้ง -->
                                        @php
                                          $Tab5 = date_create($row->sendcheckresults_court);
                                          $DateEx5 = date_diff($Newdate,$Tab5);
                                        @endphp
                                      @elseif($row->sendcheckresults_court == Null)
                                        @php
                                          $Tab5 = date_create($row->checkresults_court);
                                          $DateEx5 = date_diff($Newdate,$Tab5);
                                        @endphp
                                      @endif
    
                                      @if($row->datepreparedoc_case != Null) <!-- เตรียมเอกสาร/ชั้นบังคับคดี -->
                                        @php
                                          $Tab6 = date_create($row->datepreparedoc_case);
                                          $DateEx6 = date_diff($Newdate,$Tab6);
                                        @endphp
                                      @else
                                        @php
                                          $Tab6 = date_create("0000-00-00");
                                          $DateEx6 = date_diff($Newdate,$Tab6);
                                        @endphp
                                      @endif
    
                                      @if($row->datesetsequester_case != Null)  <!-- ยึดทรัพย์/ชั้นบังคับคดี -->
                                        @php
                                          $Tab7 = date_create($row->datesetsequester_case);
                                          $DateEx7 = date_diff($Newdate,$Tab7);
                                        @endphp
                                      @else
                                        @php
                                          $Tab7 = date_create("0000-00-00");
                                          $DateEx7 = date_diff($Newdate,$Tab7);
                                        @endphp
                                      @endif
    
                                      @if($row->DateNotice_cheat != Null) <!-- วันที่แจ้งความ/โกงเจ้าหนี้ -->
                                        @php
                                          $Tab8 = date_create($row->DateNotice_cheat);
                                          $DateEx8 = date_diff($Newdate,$Tab8);
                                        @endphp
                                      @else
                                        @php
                                          $Tab8 = date_create("0000-00-00");
                                          $DateEx8 = date_diff($Newdate,$Tab8);
                                        @endphp
                                      @endif
    
                                      @if($Newdate <= $Tab1)
                                        @if($DateEx->days <= 7)
                                          <button type="button" class="btn btn-danger btn-sm prem" title="วันสืบพยาน {{ DateThai($Tab1->format('Y-m-d')) }}">
                                            <i class="fas fa-bell"></i> สืบพยาน {{ $DateEx->days }} วัน</span>
                                          </button>
                                        @else
                                          <button type="button" class="btn btn-warning btn-sm" title="วันสืบพยาน {{ DateThai($Tab1->format('Y-m-d')) }}">
                                            <i class="fas fa-clock prem"></i> รอสืบพยาน
                                          </button>
                                        @endif
                                      @elseif($Newdate <= $Tab2)
                                        @if($DateEx2->days <= 7)
                                          <button type="button" class="btn btn-danger btn-sm prem" title="วันส่งคำบังคับ {{ DateThai($Tab2->format('Y-m-d')) }}">
                                            <i class="fas fa-bell"></i> ส่งคำบังคับ {{ $DateEx2->days }} วัน</span>
                                          </button>
                                        @else
                                          <button type="button" class="btn btn-warning btn-sm" title="วันส่งคำบังคับ {{ DateThai($Tab2->format('Y-m-d')) }}">
                                            <i class="fas fa-clock prem"></i> รอส่งคำบังคับ
                                          </button>
                                        @endif
                                      @elseif($Newdate <= $Tab3)
                                        @if($DateEx3->days <= 7)
                                          <button type="button" class="btn btn-danger btn-sm prem" title="วันตรวจผลหมาย {{ DateThai($Tab3->format('Y-m-d')) }}">
                                            <i class="fas fa-bell"></i> ตรวจผลหมาย {{ $DateEx3->days }} วัน</span>
                                          </button>
                                        @else
                                          <button type="button" class="btn btn-warning btn-sm" title="วันตรวจผลหมาย {{ DateThai($Tab3->format('Y-m-d')) }}">
                                            <i class="fas fa-clock prem"></i> รอตรวจผลหมาย
                                          </button>
                                        @endif
                                      @elseif($Newdate <= $Tab4)
                                        @if($row->checksend_court != Null)
                                          @if($DateEx4->days <= 7)
                                            <button type="button" class="btn btn-danger btn-sm" title="วันตั้งเจ้าพนักงาน {{ DateThai($Tab4->format('Y-m-d')) }}">
                                              <span class="fa fa-bello text-white prem"> ตั้งเจ้าพนักงาน {{ $DateEx4->days }} วัน</span>
                                            </button>
                                          @else
                                            <button type="button" class="btn btn-warning btn-sm" title="วันตั้งเจ้าพนักงาน {{ DateThai($Tab4->format('Y-m-d')) }}">
                                              <i class="fas fa-clock prem"></i> รอตั้งเจ้าพนักงาน
                                            </button>
                                          @endif
                                        @else
                                          <button type="button" class="btn btn-warning btn-sm" title="วันตั้งเจ้าพนักงาน {{ DateThai($Tab4->format('Y-m-d')) }}">
                                            <i class="fas fa-clock prem"></i> รอผลตรวจหมายจริง
                                          </button>
                                        @endif
                                      @elseif($Newdate <= $Tab5)
                                        @if($DateEx5->days <= 7)
                                          <button type="button" class="btn btn-danger btn-sm prem" title="วันตรวจผลหมายตั้ง {{ DateThai($Tab5->format('Y-m-d')) }}">
                                            <i class="fas fa-bell"></i> ตรวจผลหมายตั้ง {{ $DateEx5->days }} วัน</span>
                                          </button>
                                        @else
                                          <button type="button" class="btn btn-warning btn-sm" title="วันตรวจผลหมายตั้ง {{ DateThai($Tab5->format('Y-m-d')) }}">
                                            <i class="fas fa-clock prem"></i> รอตรวจผลหมายตั้ง
                                          </button>
                                        @endif
                                      @else
                                        @if($Newdate <= $Tab6)  <!-- เตรียมเอกสาร/ชั้นบังคับคดี -->
                                          @if($DateEx6->days <= 7)
                                            <button type="button" class="btn btn-danger btn-sm prem" title="วันที่คัดฉโหนด {{ DateThai($Tab6->format('Y-m-d')) }}">
                                              <i class="fas fa-bell"></i> คัดโฉนด {{ $DateEx6->days }} วัน</span>
                                            </button>
                                          @else
                                            <button type="button" class="btn btn-warning btn-sm" title="วันที่คัดฉโหนด {{ DateThai($Tab6->format('Y-m-d')) }}">
                                              <i class="fas fa-clock prem"></i> รอคัดโฉนด
                                            </button>
                                          @endif
                                        @elseif($Newdate <= $Tab7)  <!-- ยึดทรัพย์/ชั้นบังคับคดี -->
                                          @if($DateEx7->days <= 7)
                                            <button type="button" class="btn btn-danger btn-sm" title="วันที่คัดฉโหนด {{ DateThai($Tab7->format('Y-m-d')) }}">
                                              <span class="fas fa-bell text-white prem"> ตั้งเรื่องยึดทรัพย์ {{ $DateEx7->days }} วัน</span>
                                            </button>
                                          @else
                                            <button type="button" class="btn btn-warning btn-sm" title="วันที่คัดฉโหนด {{ DateThai($Tab7->format('Y-m-d')) }}">
                                              <i class="fa fa-clock-o prem"></i> ตั้งเรื่องยึดทรัพย์
                                            </button>
                                          @endif
                                        @elseif($row->resultsequester_case != Null) <!-- ประกาศขาย/ชั้นบังคับคดี -->
                                          @if($row->resultsequester_case == "ขายไม่ได้")
                                            <button type="button" class="btn btn-danger btn-sm prem" title="บังคับคดี/ขายไม่ได้">
                                              <i class="fas fa-bell"></i> บังคับคดี/ขายไม่ได้</span>
                                            </button>
                                          @else
                                            @if($row->resultsell_case == "เต็มจำนวน")
                                              <button type="button" class="btn btn-success btn-sm" title="ขายได้/เต็มจำนวน">
                                                <i class="fa fa-check-square-o prem"></i> ขายได้/เต็มจำนวน
                                              </button>
                                            @elseif($row->resultsell_case == "ไม่เต็มจำนวน")
                                              <button type="button" class="btn btn-danger btn-sm" title="ขายได้/เต็มจำนวน">
                                                <span class="fas fa-bell text-white prem"> ขายได้/ไม่เต็มจำนวน</span>
                                              </button>
                                            @else
                                            <button type="button" class="btn btn-warning btn-sm" title="รอผลจากการขาย">
                                              <i class="fas fa-clock prem"></i> รอผลจากการขาย
                                            </button>
                                            @endif
                                          @endif
                                        @elseif($Newdate <= $Tab8)  <!-- โกงเจ้าหนี้ -->
                                          @if($DateEx8->days <= 7)
                                            <button type="button" class="btn btn-danger btn-sm prem" title="วันที่แจ้งความ {{ DateThai($Tab8->format('Y-m-d')) }}">
                                              <i class="fas fa-bell"></i> โกงเจ้าหนี้ {{ $DateEx8->days }} วัน</span>
                                            </button>
                                          @else
                                            <button type="button" class="btn btn-warning btn-sm" title="วันที่แจ้งความ {{ DateThai($Tab8->format('Y-m-d')) }}">
                                              <i class="fas fa-clock prem"></i> โกงเจ้าหนี้
                                            </button>
                                          @endif
                                        @else
                                          <button type="button" class="btn btn-warning btn-sm" title="รอขั้นตอนต่อไป">
                                            <i class="fas fa-clock prem"></i> รอขั้นตอนต่อไป
                                          </button>
                                        @endif
                                      @endif
                                    @else
                                      @if($row->fillingdate_court == Null)
                                        <button type="button" class="btn btn-danger btn-sm" title="รอฟ้อง">
                                          <i class="fas fa-exclamation-triangle prem"></i> รอฟ้อง
                                        </button>
                                      @elseif($row->fillingdate_court != Null)
                                      <button type="button" class="btn btn-warning btn-sm" title="สถานะฟ้อง">
                                        <i class="fas fa-clock"></i> ฟ้อง
                                      </button>
                                      @endif
                                    @endif
                                  @endif
                                </td>
                                <td class="text-center">  <!-- สถานะทรัพย์ -->
                                  @if($row->Date_asset != Null)
                                    @php
                                      $Getdate = date_create($row->sequester_asset);
                                      $Newdate = date_create($date);
                                      $DateEx = date_diff($Newdate,$Getdate);
                                    @endphp
    
                                    @if($row->sendsequester_asset == "สืบทรัพย์ไม่เจอ")
                                        @php
                                          $Getdate = date_create($row->NewpursueDate_asset);
                                          $DateEx = date_diff($Newdate,$Getdate);
                                        @endphp
    
                                        @if($Newdate <= $Getdate)
                                          @if($DateEx->days <= 7)
                                            <button type="button" class="btn btn-danger btn-sm prem" title="วันสืบทรัพย์ {{DateThai($row->NewpursueDate_asset)}}">
                                              <i class="fas fa-bell"></i> สืบทรัพย์ใหม่ {{ $DateEx->days }} วัน</span>
                                            </button>
                                          @else
                                            <button type="button" class="btn btn-warning btn-sm" title="รอสืบทรัพย์ {{DateThai($row->NewpursueDate_asset)}}">
                                              <i class="fas fa-clock prem"></i> รอสืบทรัพย์
                                            </button>
                                          @endif
                                        @else
                                          <button type="button" class="btn btn-gray btn-sm prem" title="วันสืบทรัพย์ล่าสุด {{DateThai($row->NewpursueDate_asset)}}">
                                            <i class="fas fa-hourglass-half"></i> ไม่มีการอัพเดต </span>
                                          </button>
                                        @endif
                                    @elseif($row->sendsequester_asset == "สืบทรัพย์เจอ")
                                      <button type="button" class="btn btn-success btn-sm" title="สืบทรัพย์เจอ">
                                        <i class="fas fa-clipboard-check prem"></i> สืบทรัพย์เจอ
                                      </button>
                                    @elseif($row->sendsequester_asset == "หมดอายุความคดี")
                                      <button type="button" class="btn btn-primary btn-sm" title="หมดอายุความ">
                                        <i class="fas fa-gavel prem"></i> หมดอายุความคดี
                                      </button>
                                    @elseif($row->sendsequester_asset == "จบงานสืบทรัพย์")
                                      <button type="button" class="btn btn-success btn-sm" title="จบงานสืบทรัพย์">
                                        <i class="fas fa-gavel prem"></i> จบงานสืบทรัพย์
                                      </button>
                                    @else
                                      @if($row->propertied_asset == "Y")
                                        <button type="button" class="btn btn-success btn-sm" title="มีทรัพย์">
                                          <i class="fas fa-map-marked-alt prem"></i> มีทรัพย์
                                        </button>
                                      @elseif($row->propertied_asset == "N")
                                        @if($row->NewpursueDate_asset != Null)
                                          @php
                                            $Getdate = date_create($row->NewpursueDate_asset);
                                            $DateEx = date_diff($Newdate,$Getdate);
                                          @endphp
    
                                          @if($Newdate <= $Getdate)
                                            @if($DateEx->days <= 7)
                                              <button type="button" class="btn btn-danger btn-sm prem" title="สืบทรัพย์ {{DateThai($row->sequester_asset)}}">
                                                <span class="fa fa-bell text-white"> สืบทรัพย์ {{ $DateEx->days }} วัน</span>
                                              </button>
                                            @else
                                              <button type="button" class="btn btn-warning btn-sm" title="รอสืบทรัพย์ {{DateThai($row->sequester_asset)}}">
                                                <i class="fa fa-clock-o text-white prem"></i> รอสืบทรัพย์
                                              </button>
                                            @endif
                                          @endif
                                        @else
                                          <button type="button" class="btn btn-gray btn-sm" title="รอผลสืบทรัพย์">
                                            <i class="fas fa-hourglass-half prem"></i> รอผลสืบทรัพย์
                                          </button>
                                        @endif
                                      @endif
                                    @endif
                                  @else
                                    <button type="button" class="btn btn-gray btn-sm" title="ไม่มีข้อมูล">
                                      <i class="far fa-question-circle prem"></i> ไม่มีข้อมูล
                                    </button>
                                  @endif
                                </td>
                                <td class="text-center">  <!-- ประนอมหนี้ -->
                                  @php
                                    $lastday = date('Y-m-d', strtotime("-90 days"));
                                  @endphp
    
                                  @if($row->Status_Promise != NULL)
                                    <button type="button" class="btn btn-success btn-sm" title="ปิดบัญชี">
                                      <i class="fas fa-user-check prem"></i> ปิดบัญชี
                                    </button>
                                  @else
                                    @if($row->KeyCompro_id != Null)
                                      @foreach($dataPay as $key => $value)
                                        @if($row->legisPromise_id == $value->legis_Com_Payment_id)
                                          @if($value->Date_Payment < $lastday)
                                            <button type="button" class="btn btn-danger btn-sm" title="วันชำระล่าสุด {{DateThai($value->Date_Payment)}}">
                                              <i class="far fa-thumbs-down prem"></i> ขาดชำระ
                                            </button>
                                          @else
                                            <button type="button" class="btn btn-info btn-sm" title="วันชำระล่าสุด {{DateThai($value->Date_Payment)}}">
                                              <i class="far fa-thumbs-up prem"></i> ชำระปกติ
                                            </button>
                                          @endif
                                        @endif
                                      @endforeach
                                    @else
                                      <button type="button" class="btn btn-gray btn-sm" title="ไม่มีข้อมูล">
                                        <i class="far fa-question-circle prem"></i> ไม่มีข้อมูล
                                      </button>
                                    @endif
                                  @endif
                                </td>
                                <td class="text-center"> {{$row->User_court}} </td>
                                <td class="text-center">
                                  <a href="{{ action('LegislationController@edit',[$row->id,$type]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                    <i class="far fa-edit"></i>
                                  </a>
                                  <form method="post" class="delete_form" action="{{ action('LegislationController@destroy',[$row->id ,1]) }}" style="display:inline;">
                                  {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                      <i class="far fa-trash-alt"></i>
                                    </button>
                                  </form>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  @elseif($type == 6)  {{--ลูกหนี้เตรียมฟ้อง--}}
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                          <thead class="thead-dark bg-gray-light" >
                            <tr>
                              <th class="text-center">ลำดับ</th>
                              <th class="text-center">เลขที่สัญญา</th>
                              <th class="text-center">ชื่อ-สกุล</th>
                              <th class="text-center">งวด</th>
                              <th class="text-center">วันรับงาน</th>
                              <th class="text-center">ระยะเวลา</th>
                              <th class="text-center">ผู้จัดเตรียม</th>
                              <th class="text-center">หมายเหตุ</th>
                              <th class="text-center" style="width: 80px">สถานะ</th>
                              <th class="text-center" style="width: 110px">ตัวเลือก</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $key => $row)
                              <tr>
                                <td class="text-center"> {{$key+1}}</td>
                                <td class="text-center"> {{$row->Contract_legis}}</td>
                                <td class="text-left"> {{$row->Name_legis}}</td>
                                <td class="text-center">
                                  @php
                                     $StrCon = explode("/",$row->Contract_legis);
                                     $SetStr1 = $StrCon[0];
                                     $SetStr2 = $StrCon[1];
                                  @endphp
    
                                  @foreach($result as $key => $row1)
                                    @if($row->Contract_legis == $row1->CONTNO)
                                      @if($row->Realperiod_legis < $row1->HLDNO)
                                        {{$row1->HLDNO}}
                                      @else
                                        {{$row->Realperiod_legis}}
                                      @endif
                                    @endif
                                  @endforeach
                                </td>
                                <td class="text-center"> {{ DateThai($row->Date_legis) }}</td>
                                <td class="text-center">
                                  @if($row->Datesend_Flag == null)
                                    @php
                                      $nowday = date('Y-m-d');
                                      $Cldate = date_create($row->Date_legis);
                                      $nowCldate = date_create($nowday);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <font color="red">{{$duration}}</font>
                                  @else
                                    @php
                                      $Cldate = date_create($row->Date_legis);
                                      $nowCldate = date_create($row->Datesend_Flag);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <font color="green">{{$duration}}</font>
                                  @endif
                                </td>
                                <td class="text-center"> {{ $row->UserSend2_legis }}</td>
                                <td class="text-left" style="width:200px;"> {{ $row->Noteby_legis }} </td>
                                <td class="text-center">
                                  @if($row->Flag_status == '1')
                                  <button type="button" class="btn btn-danger btn-sm" title="เตรียมเอกสาร">
                                    <i class="far fa-calendar-check"></i> เตรียม
                                  </button>
                                  @else
                                  <button type="button" class="btn btn-success btn-sm" title="วันส่งทนาย {{ DateThai($row->Datesend_Flag) }}">
                                    <i class="far fa-calendar-check"></i> ส่งทนาย
                                  </button>
                                  @endif
                                </td>
                                <td class="text-center">
                                  <a href="{{ action('LegislationController@edit',[$row->id,$type]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                    <i class="far fa-edit"></i> แก้ไข
                                  </a>
                                  <form method="post" class="delete_form" action="{{ action('LegislationController@destroy',[$row->id ,1]) }}" style="display:inline;">
                                  {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit"  data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                      <i class="far fa-trash-alt"></i> ลบ
                                    </button>
                                  </form>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  @elseif($type == 7)  {{--ลูกหนี้ประนอมหนี้--}}
                    <div class="col-md-12">
                      <form method="get" >
                        <div class="float-right form-inline">
                          <div class="btn-group">
                            <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                              <span class="fas fa-print"></span> ปริ้นรายงาน
                            </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-1" data-link="{{ route('legislation', 9) }}"> ใบเสร็จรับชำระ</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-2" data-link="{{ route('legislation', 15) }}"> รายงานบันทึกชำะค่างวด</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-3" data-link="{{ route('legislation', 16) }}"> รายงานลูกหนี้ประนอม</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-6" data-link="{{ route('legislation', 20) }}"> รายงานตรวจสอบยอดชำระ</a></li>
                              </ul>
                          </div>
                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>
                        <br><br><br><p></p>
                        <div class="float-right form-inline">
                          <label>จากวันที่ : </label>
                          <input type="date" name="Fromdate" value="{{ ($newfdate != '') ?$newfdate: '' }}" style="width: 180px;" class="form-control" />
  
                          <label>ถึงวันที่ : </label>
                          <input type="date" name="Todate" value="{{ ($newtdate != '') ?$newtdate: '' }}" style="width: 180px;" class="form-control" />
                        
                          <label for="text" class="mr-sm-2">สถานะ : </label>
                          <select name="status" class="form-control" id="text" style="width: 178px">
                            <option selected value="">--- สถานะ ---</option>
                            <option value="ชำระปกติ" {{($status == 'ชำระปกติ') ? 'selected' : '' }}>ชำระปกติ</otion>
                            <option value="ขาดชำระ" {{($status == 'ขาดชำระ') ? 'selected' : '' }}>ขาดชำระ</otion>
                            <option value="ปิดบัญชี" {{($status == 'ปิดบัญชี') ? 'selected' : '' }}>ปิดบัญชี</otion>
                          </select>
                        </div>
                     </form>
                     <br><br>
                    </div>
    
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                          <thead class="thead-dark bg-gray-light" >
                            <tr>
                              <th class="text-center">ลำดับ</th>
                              <th class="text-center">เลขที่สัญญา</th>
                              <th class="text-center">ชื่อ-สกุล</th>
                              <th class="text-center">ประนอม</th>
                              <th class="text-center">ระยะเวลา</th>
                              <th class="text-center">ยอดประนอม</th>
                              <th class="text-center">ยอดคงเหลือ</th>
                              <th class="text-center">ผู้ส่งประนอม</th>
                              <th class="text-center">สถานะ</th>
                              <th class="text-center" style="width: 50px">ตัวเลือก</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $key => $row)
                              <tr>
                                <td class="text-center"> {{$key+1}} </td>
                                <td class="text-center">
                                  {{$row->Contract_legis}}
                                  @if($row->Flag == "C")
                                    <span class="label label-warning">ประนอม</span>
                                  @endif
                                </td>
                                <td class="text-left"> {{$row->Name_legis}} </td>
                                <td class="text-center"> {{DateThai($row->Date_Promise)}}</td>
                                <td class="text-center">
                                  @if($row->Status_Promise == "ปิดบัญชีประนอมหนี้" or $row->Status_Promise == "จ่ายจบประนอมหนี้")
                                    @php
                                      $Cldate = date_create($row->Date_Promise);
                                      $nowCldate = date_create($row->DateStatus_Promise);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <span data-toggle="tooltip" title="{{$ClDateDiff->y}} ปี {{$ClDateDiff->m}} เดือน {{$ClDateDiff->d}} วัน"><font color="green" title="test">{{$duration}}</font></span>
                                  @else
                                    @php
                                      $nowday = date('Y-m-d');
                                      $Cldate = date_create($row->Date_Promise);
                                      $nowCldate = date_create($nowday);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <span data-toggle="tooltip" title="{{$ClDateDiff->y}} ปี {{$ClDateDiff->m}} เดือน {{$ClDateDiff->d}} วัน"><font color="red">{{$duration}}</font></span>
                                  @endif
                                </td>
                                <td class="text-center"> {{number_format($row->Total_Promise,2)}}</td>
                                <td class="text-center"> {{number_format($row->Sum_Promise,2)}}</td>
                                <td class="text-center">{{ $row->User_Promise }}</td>
                                <td class="text-center">
                                  @php
                                    $lastday = date('Y-m-d', strtotime("-90 days"));
                                  @endphp
    
                                  @if($row->Status_Promise == "ปิดบัญชีประนอมหนี้")
                                    <button data-toggle="tooltip" type="button" class="btn btn-success btn-sm" title="ปิดบัญชี">
                                      <span class="glyphicon glyphicon-ok prem"></span> ปิดบัญชี
                                    </button>
                                  @elseif($row->Status_Promise == "จ่ายจบประนอมหนี้")
                                    <button data-toggle="tooltip" type="button" class="btn btn-success btn-sm" title="จ่ายจบ">
                                      <span class="glyphicon glyphicon-ok prem"></span> จ่ายจบ
                                    </button>
                                  @else
                                    @foreach($dataPay as $key => $value)
                                      @if($row->legisPromise_id == $value->legis_Com_Payment_id)
                                        @if(substr($value->CPayments_at,0,10) < $lastday)
                                          <button data-toggle="tooltip" type="button" class="btn btn-danger btn-sm" title="วันชำระล่าสุด {{DateThai(substr($value->CPayments_at,0,10))}}">
                                            <i class="far fa-thumbs-down"></i> ขาดชำระ
                                          </button>
                                        @else
                                          <button data-toggle="tooltip" type="button" class="btn btn-info btn-sm" title="วันชำระล่าสุด {{DateThai(substr($value->CPayments_at,0,10))}}">
                                            <i class="far fa-thumbs-up"></i> ชำระปกติ
                                          </button>
                                        @endif
                                      @endif
                                    @endforeach
                                   @endif
    
                                </td>
                                <td class="text-center">
                                  <a href="{{ action('LegislationController@edit',[$row->id, 4]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                    <i class="far fa-edit"></i>
                                  </a>
                                  @if($row->Flag == "C")
                                    <form method="post" class="delete_form" action="{{ action('LegislationController@destroy',[$row->id ,1]) }}" style="display:inline;">
                                    {{csrf_field()}}
                                      <input type="hidden" name="_method" value="DELETE" />
                                      <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                        <i class="far fa-trash-alt"></i>
                                      </button>
                                    </form>
                                  @endif
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  @elseif($type == 8)  {{--ลูกหนี้สืบทรัพย์--}}
                    <div class="col-md-12">
                      <form method="get" action="{{ route('legislation', 8) }}">
                        <div class="float-right form-inline">
                          <div class="btn-group">
                            <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                              <span class="fas fa-print"></span> ปริ้นรายงาน
                            </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-4" data-link="{{ route('legislation', 19) }}"> รายงานสืบทรัพย์</a></li>
                              </ul>
                          </div>
                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>
                        <br><br><br><p></p>
                        <div class="float-right form-inline">
                          <label>จากวันที่ : </label>
                          <input type="date" name="Fromdate" style="width: 180px;" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />
  
                          <label>ถึงวันที่ : </label>
                          <input type="date" name="Todate" style="width: 180px;" value="{{ ($newtdate != '') ?$newtdate: date('Y-m-d') }}" class="form-control" />
                        
                          <label for="text" class="mr-sm-2">สถานะ : </label>
                          <select name="status" class="form-control" id="text" style="width: 177px">
                            <option selected value="">--- สถานะ ---</option>
                            <option value="Y" {{ ($SetSelect == 'Y') ? 'selected' : '' }}>มีทรัพย์</otion>
                            <option value="N" {{ ($SetSelect == 'N') ? 'selected' : '' }}>ไม่มีทรัพย์</otion>
                            <option value="หมดอายุความ" {{ ($SetSelect == 'หมดอายุความ') ? 'selected' : '' }}>หมดอายุความ</otion>
                            <option value="จบงานสืบทรัพย์" {{ ($SetSelect == 'จบงานสืบทรัพย์') ? 'selected' : '' }}>จบงานสืบทรัพย์</otion>
                          </select>
                        </div>
                      </form>
                      <br><br>
                    </div>
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                          <thead class="thead-dark bg-gray-light" >
                            <tr>
                              <th class="text-center" style="width: 30px">No.</th>
                              <th class="text-center">เลขที่สัญญา</th>
                              <th class="text-center">ชื่อ-สกุล</th>
                              <th class="text-center">วันที่สืบทรัพย์</th>
                              <th class="text-center">ระยะเวลา</th>
                              <th class="text-center">สถานะทรัพย์</th>
                              <th class="text-center">สถานะแจ้งเตือน</th>
                              <th class="text-center">ผู้สืบทรัพย์</th>
                              <th class="text-center" style="width: 100px">ตัวเลือก</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $key => $row)
                              <tr>
                                <td class="text-center"> {{$key+1}} </td>
                                <!-- <td class="text-center"><a href="#" data-toggle="modal" data-target="#modal_default" data-backdrop="static" data-keyboard="false">{{$row->Contract_legis}}</a></td> -->
                                <td class="text-center"> {{$row->Contract_legis}}</td>
                                <td class="text-left"> {{$row->Name_legis}} </td>
                                <td class="text-center"> {{ DateThai($row->Date_asset) }}</td>
                                <td class="text-center">  <!-- ระยะเวลา -->
                                  @if($row->Dateresult_asset != Null)
                                    @php
                                      $Cldate = date_create($row->Date_asset);
                                      $nowCldate = date_create($row->Dateresult_asset);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    <font color="green">{{$duration}}</font>
                                  @else
                                    @if($row->propertied_asset == "Y")
                                      @php
                                        $Cldate = date_create($row->Date_asset);
                                        $nowCldate = date_create($row->Dateresult_asset);
                                        $ClDateDiff = date_diff($Cldate,$nowCldate);
                                        $duration = $ClDateDiff->format("%a วัน")
                                      @endphp
                                      <font color="green">{{$duration}}</font>
                                    @elseif($row->propertied_asset == "N")
                                      @php
                                        $Cldate = date_create($date);
                                        $nowCldate = date_create($row->Date_asset);
                                        $ClDateDiff = date_diff($Cldate,$nowCldate);
                                        $duration = $ClDateDiff->format("%a วัน")
                                      @endphp
                                      <font color="red">{{$duration}}</font>
                                    @endif
                                  @endif
                                </td>
                                <td class="text-center">  <!-- สถานะทรัพย์ -->
                                  @if($row->propertied_asset == "Y")
                                    <button type="button" class="btn btn-success btn-sm" title="มีทรัพย์">
                                      <i class="fa fa-map prem"></i> มีทรัพย์
                                    </button>
                                  @elseif($row->propertied_asset == "N")
                                    <button type="button" class="btn btn-danger btn-sm" title="ไม่มีทรัพย์">
                                      <i class="fa fa-map prem"></i> ไม่มีทรัพย์
                                    </button>
                                  @endif
                                </td>
                                <td class="text-center">  <!-- สถานะแจ้งเตือน -->
                                  @if($row->Date_asset != Null)
                                    @php
                                      $Getdate = date_create($row->sequester_asset);
                                      $Newdate = date_create($date);
                                      $DateEx = date_diff($Newdate,$Getdate);
                                    @endphp
    
                                    @if($row->sendsequester_asset == "สืบทรัพย์ไม่เจอ")
                                        @php
                                          $Getdate = date_create($row->NewpursueDate_asset);
                                          $DateEx = date_diff($Newdate,$Getdate);
                                        @endphp
    
                                        @if($Newdate <= $Getdate)
                                          @if($DateEx->days <= 7)
                                            <button type="button" class="btn btn-danger btn-sm" title="วันสืบทรัพย์ {{DateThai($row->NewpursueDate_asset)}}">
                                              <span class="fa fa-bell prem"> สืบทรัพย์ใหม่ {{ $DateEx->days }} วัน</span>
                                            </button>
                                          @else
                                            <button type="button" class="btn btn-warning btn-sm" title="รอสืบทรัพย์ {{DateThai($row->NewpursueDate_asset)}}">
                                              <i class="fa fa-clock-o prem"></i> รอสืบทรัพย์
                                            </button>
                                          @endif
                                        @else
                                          <button type="button" class="btn btn-gray btn-sm prem" title="วันสืบทรัพย์ล่าสุด {{DateThai($row->NewpursueDate_asset)}}">
                                            <span class="fa fa-hourglass-half active"> ไม่มีการอัพเดต </span>
                                          </button>
                                        @endif
                                    @elseif($row->sendsequester_asset == "สืบทรัพย์เจอ")
                                      <button type="button" class="btn btn-success btn-sm" title="สืบทรัพย์เจอ">
                                        <i class="fa fa-check-square-o prem"></i> สืบทรัพย์เจอ
                                      </button>
                                    @elseif($row->sendsequester_asset == "หมดอายุความคดี")
                                      <button type="button" class="btn btn-primary btn-sm" title="หมดอายุความ">
                                        <i class="fa fa-gavel prem"></i> หมดอายุความคดี
                                      </button>
                                    @elseif($row->sendsequester_asset == "จบงานสืบทรัพย์")
                                      <button type="button" class="btn btn-success btn-sm" title="จบงานสืบทรัพย์">
                                        <i class="fa fa-gavel prem"></i> จบงานสืบทรัพย์
                                      </button>
                                    @else
                                      @if($row->propertied_asset == "Y")
                                        <button type="button" class="btn btn-success btn-sm" title="มีทรัพย์">
                                          <i class="fa fa-check-square-o prem"></i> มีทรัพย์
                                        </button>
                                      @elseif($row->propertied_asset == "N")
                                        @if($row->NewpursueDate_asset != Null)
                                          @php
                                            $Getdate = date_create($row->NewpursueDate_asset);
                                            $DateEx = date_diff($Newdate,$Getdate);
                                          @endphp
    
                                          @if($Newdate <= $Getdate)
                                            @if($DateEx->days <= 7)
                                              <button type="button" class="btn btn-danger btn-sm" title="สืบทรัพย์ {{DateThai($row->sequester_asset)}}">
                                                <span class="fa fa-bell text-white prem"> สืบทรัพย์ {{ $DateEx->days }} วัน</span>
                                              </button>
                                            @else
                                              <button type="button" class="btn btn-warning btn-sm" title="รอสืบทรัพย์ {{DateThai($row->sequester_asset)}}">
                                                <i class="fa fa-clock-o text-white prem"></i> รอสืบทรัพย์
                                              </button>
                                            @endif
                                          @endif
                                        @else
                                          <button type="button" class="btn btn-gray btn-sm" title="รอผลสืบทรัพย์">
                                            <i class="fa fa-hourglass-half active prem"></i> รอผลสืบทรัพย์
                                          </button>
                                        @endif
                                      @endif
                                    @endif
                                  @endif
                                </td>
                                <td class="text-center"> {{ $row->User_asset }}</td>
                                <td class="text-center">
                                  <a href="{{ action('LegislationController@edit',[$row->id,$type]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                    <i class="far fa-edit"></i>
                                  </a>
                                  <form method="post" class="delete_form" action="{{ action('LegislationController@destroy',[$row->id ,1]) }}"  style="display:inline;">
                                  {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button disabled type="submit" class="delete-modal btn btn-danger btn-sm" title="ลบรายการ">
                                      <i class="far fa-trash-alt"></i>
                                    </button>
                                  </form>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  @elseif($type == 10) {{--ลูกหนี้ของกลาง--}}
                    <div class="col-md-12">
                      <form method="get" action="{{ route('legislation', 10) }}">
                        <div class="float-right form-inline">
                            <a href="{{ route('legislation', 11) }}" class="btn bg-success btn-app">
                              <i class="fas fa-plus"></i> เพิ่มข้อมูล
                            </a>
                            <div class="btn-group">
                              <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                                <span class="fas fa-print"></span> ปริ้นรายงาน
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a target="_blank" class="dropdown-item" href="{{ route('legislation.report', [00,10]) }}?&Fromdate={{$fdate}}&Todate={{$tdate}}&TerminateExhibit={{$terminateexhibit}}&Typeexhibit={{$typeexhibit}}">
                                  <i class="fa fa-file-pdf-o text-red"></i> &nbsp;&nbsp; PDF</a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li><a target="_blank" class="dropdown-item" href="{{ route('legislation.report', [00,10]) }}?&Fromdate={{$fdate}}&Todate={{$tdate}}&TerminateExhibit={{$terminateexhibit}}&Typeexhibit={{$typeexhibit}}">
                                  <i class="fa fa-file-excel-o text-green"></i> &nbsp;&nbsp; Excel</a>
                                </li>
                              </ul>
                            </div>
                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>

                        <br><br><br><p></p>
                        <div class="float-right form-inline">
                          <label for="text" class="mr-sm-2">บอกเลิกสัญญา : </label>
                          <select name="TerminateExhibit" class="form-control" id="text" style="width: 180px">
                            <option selected value="">--- เลือกสถานะ ---</option>
                            <option value="เร่งรัด" {{ ($terminateexhibit == 'เร่งรัด') ? 'selected' : '' }}>เร่งรัด</otion>
                            <option value="ทนาย" {{ ($terminateexhibit == 'ทนาย') ? 'selected' : '' }}>ทนาย</otion>
                          </select>
                          <label for="text" class="mr-sm-2">&nbsp;ประเภท : </label>
                          <select name="Typeexhibit" class="form-control" id="text" style="width: 177px">
                            <option selected value="">---เลือกประเภท---</option>
                            <option value="ของกลาง" {{ ($typeexhibit == 'ของกลาง') ? 'selected' : '' }}>ของกลาง</otion>
                            <option value="ยึดตามมาตราการ(ปปส.)" {{ ($typeexhibit == 'ยึดตามมาตราการ(ปปส.)') ? 'selected' : '' }}>ยึดตามมาตราการ(ปปส.)</otion>
                          </select>
                        </div>

                        <br><br>
                        <div class="float-right form-inline">
                          <label for="text" class="mr-sm-2">จากวันที่ : </label>
                          <input type="date" name="Fromdate" style="width: 180px;" value="{{ ($fdate != '') ?$fdate: '' }}" class="form-control" />
                          <label for="text" class="mr-sm-2">&nbsp;&nbsp;ถึงวันที่ : </label>
                          <input type="date" name="Todate" style="width: 177px;" value="{{ ($tdate != '') ?$tdate: '' }}" class="form-control" />
                        </div>
                      </form>
                      <br><br>
                    </div>
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                          <thead class="thead-dark bg-gray-light" >
                            <tr>
                              <th class="text-center" style="width: 40px">ลำดับ</th>
                              <th class="text-center">เลขที่สัญญา</th>
                              <th class="text-center">ชื่อ-สกุลผู้เช่าซื้อ</th>
                              <th class="text-center">ชื่อผู้ต้องหา</th>
                              <th class="text-center">ข้อหา</th>
                              <th class="text-center">บอกเลิก</th>
                              <th class="text-center">ประเภท</th>
                              <th class="text-center">สถานะแจ้งเตือน</th>
                              <th class="text-center" style="width: 150px">ตัวเลือก</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $key => $row)
                            <tr>
                              <td class="text-center">{{$key+1}}</td>
                              <td class="text-center">{{$row->Contract_legis}}</td>
                              <td class="text-left"> {{$row->Name_legis}}</td>
                              <td class="text-left"> {{$row->Suspect_legis}}</td>
                              <td class="text-center"> {{$row->Plaint_legis}}</td>
                              <td class="text-center"> {{$row->Terminate_legis}}</td>
                              <td class="text-center"> {{$row->Typeexhibit_legis}}</td>
                              <td class="text-center">
                                @if($row->Typeexhibit_legis == 'ของกลาง')
                                  @if($row->Dategetresult_legis != null)
                                  <button type="button" class="btn btn-success btn-sm" title="{{DateThai($row->Dategetresult_legis)}}">
                                    <i class="fa fa-check-circle prem"></i> จบงาน
                                  </button>
                                  @elseif($row->Dateinvestigate_legis != null)
                                      @php
                                        $datecheck = date('Y-m-d');
                                        $Cldate = date_create($row->Dateinvestigate_legis);
                                        $nowCldate = date_create($datecheck);
                                        $ClDateDiff = date_diff($Cldate,$nowCldate);
                                        // $duration = $ClDateDiff->format("อีก %a วัน");
                                      @endphp
                                      @if($datecheck > $row->Dateinvestigate_legis)
                                        <button type="button" class="btn btn-warning btn-sm" title="{{DateThai($row->Dateinvestigate_legis)}}">
                                         <i class="fa fa-question-circle prem"></i> เลยไต่สวนแล้ว
                                        </button>
                                      @elseif($ClDateDiff->days <= 7)
                                        <button type="button" class="btn btn-danger btn-sm prem" title="{{DateThai($row->Dateinvestigate_legis)}}">
                                         <i class="fa fa-question-circle"></i> ไต่สวนอีก {{$ClDateDiff->days}} วัน
                                        </button>
                                      @endif
                                  @elseif($row->Datesendword_legis != null)
                                      <button type="button" class="btn btn-warning btn-sm" title="{{DateThai($row->Datesendword_legis)}}">
                                       <i class="fa fa-question-circle prem"></i> ยื่นคำร้อง
                                      </button>
                                  @elseif($row->Datepreparedoc_legis != null)
                                      <button type="button" class="btn btn-primary btn-sm" title="{{DateThai($row->Datepreparedoc_legis)}}">
                                       <i class="fa fa-question-circle prem"></i> เตรียมเอกสาร
                                      </button>
                                  @elseif($row->Datecheckexhibit_legis != null)
                                      <button type="button" class="btn btn-primary btn-sm" title="{{DateThai($row->Datecheckexhibit_legis)}}">
                                       <i class="fa fa-question-circle prem"></i> เช็คสำนวน
                                      </button>
                                  @elseif($row->Dategiveword_legis != null)
                                      <button type="button" class="btn btn-primary btn-sm" title="{{DateThai($row->Dategiveword_legis)}}">
                                       <i class="fa fa-question-circle prem"></i> สอบคำให้การ
                                      </button>
                                  @else
                                    <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                     <i class="fa fa-question-circle prem"></i> ยังไม่มีแจ้งเตือน
                                    </button>
                                  @endif
                                @endif
                                @if($row->Typeexhibit_legis == 'ยึดตามมาตราการ(ปปส.)')
                                  @if($row->Dategetresult_legis != null)
                                  <button type="button" class="btn btn-success btn-sm" title="{{DateThai($row->Dategetresult_legis)}}">
                                    <i class="fa fa-check-circle prem"></i> จบงาน
                                  </button>
                                  @elseif($row->Datesenddetail_legis != null)
                                    <button type="button" class="btn btn-danger btn-sm" title="{{DateThai($row->Datesenddetail_legis)}}">
                                     <i class="fa fa-question-circle prem"></i> ส่งรายละเอียด
                                    </button>
                                  @else
                                      <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                       <i class="fa fa-question-circle prem"></i> ยังไม่มีแจ้งเตือน
                                      </button>
                                    @endif
                                @endif
                              </td>
                              <td class="text-center">
                                <a href="{{ action('LegislationController@edit',[$row->Legisexhibit_id, 10]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i>
                                </a>
                                <form method="post" class="delete_form" action="{{ action('LegislationController@destroy',[$row->Legisexhibit_id ,3]) }}"  style="display:inline;">
                                {{csrf_field()}}
                                  <input type="hidden" name="_method" value="DELETE" />
                                  <button type="submit" data-name="{{ $row->Contract_legis }}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                    <i class="far fa-trash-alt"></i>
                                  </button>
                                </form>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  @elseif($type == 12) {{--ลูกหนี้ขายฝาก--}}
                    <div class="col-md-12">
                     <hr>
                     <div class="table-responsive">
                       <table class="table table-bordered" id="table">
                          <thead class="thead-dark bg-gray-light" >
                            <tr>
                              <th class="text-center" style="width: 10px">ลำดับ</th>
                              <th class="text-center">เลขที่สัญญา</th>
                              <th class="text-center">ชื่อ-สกุล</th>
                              <th class="text-center">วันที่ทำสัญญา</th>
                              <th class="text-center">ยอดคงเหลือ</th>
                              <!-- <th class="text-center">ยอดชำระล่าสุด</th> -->
                              <th class="text-center">ค้างงวดจริง</th>
                              <th class="text-center">ระยะเวลา</th>
                              <th class="text-center">แจ้งเตือนสถานะ</th>
                              <th class="text-center">ตัวเลือก</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($dataLand as $key => $row)
                            <tr>
                              <td class="text-center" style="widtd: 10px">{{$key+1}}</td>
                              <td class="text-center">{{$row->ContractNo_legis}}</td>
                              <td class="text-left">{{$row->Name_legis}}</td>
                              <td class="text-center">{{ DateThai($row->DateDue_legis) }} </td>
                              <td class="text-center">{{ number_format($row->Sumperiod_legis, 2) }} </td>
                              <!-- <td class="text-center">{{ number_format($row->Beforemoney_legis, 2) }} </td> -->
                              <td class="text-center">{{$row->Realperiod_legis}}</td>
                              <td class="text-center">
                                @if($row->Datestatusland_legis == null or $row->Statusland_legis == 'ไม่จบงาน')
                                  @php
                                    $nowday = date('Y-m-d');
                                    $Cldate = date_create($row->Date_legis);
                                    $nowCldate = date_create($nowday);
                                    $ClDateDiff = date_diff($Cldate,$nowCldate);
                                    $duration = $ClDateDiff->format("%a วัน")
                                  @endphp
                                  <font color="red">{{$duration}}</font>
                                @else
                                  @php
                                    $Cldate = date_create($row->Date_legis);
                                    $nowCldate = date_create($row->Datestatusland_legis);
                                    $ClDateDiff = date_diff($Cldate,$nowCldate);
                                    $duration = $ClDateDiff->format("%a วัน")
                                  @endphp
                                  <font color="green">{{$duration}}</font>
                                @endif
                              </td>
                              <td class="text-center">
                                @if($row->Datestatusland_legis != null)
                                <button type="button" class="btn btn-success btn-sm" title="{{DateThai($row->Datestatusland_legis)}}">
                                  @if($row->Statusland_legis == "จบงาน")
                                  <i class="fa fa-check-circle prem"></i> จบงาน
                                  @elseif($row->Statusland_legis == "ปิดบัญชี")
                                  <i class="fa fa-check-circle prem"></i> ปิดบัญชี
                                  @endif
                                </button>
                                @elseif($row->Datecheckasset_legis != null)
                                  <button type="button" class="btn btn-danger btn-sm" title="{{DateThai($row->Datecheckasset_legis)}}">
                                   <i class="fa fa-question-circle prem"></i> ไปตรวจทรัพย์{{$row->Resultcheck_legis}}
                                  </button>
                                @elseif($row->Datepost_legis != null)
                                    <button type="button" class="btn btn-danger btn-sm" title="{{DateThai($row->Datepost_legis)}}">
                                     <i class="fa fa-question-circle prem"></i> ติดประกาศ
                                    </button>
                                @elseif($row->Dateeviction_legis != null)
                                    <button type="button" class="btn btn-danger btn-sm" title="{{DateThai($row->Dateeviction_legis)}}">
                                     <i class="fa fa-question-circle prem"></i> ทำเรื่องขับไล่
                                    </button>
                                @elseif($row->Dateadjudicate_legis != null)
                                    <button type="button" class="btn btn-danger btn-sm" title="{{DateThai($row->Dateadjudicate_legis)}}">
                                     <i class="fa fa-question-circle prem"></i> พิพากษา
                                    </button>
                                @elseif($row->Dateinvestigate_legis != null)
                                    <button type="button" class="btn btn-danger btn-sm" title="{{DateThai($row->Dateinvestigate_legis)}}">
                                     <i class="fa fa-question-circle prem"></i> สืบสวน
                                    </button>
                                @elseif($row->Datepetition_legis != null)
                                    <button type="button" class="btn btn-danger btn-sm" title="{{DateThai($row->Datepetition_legis)}}">
                                     <i class="fa fa-question-circle prem"></i> ยื่นคำร้อง
                                    </button>
                                @elseif($row->Dategetnotice_legis != null)
                                    <button type="button" class="btn btn-danger btn-sm" title="{{DateThai($row->Dategetnotice_legis)}}">
                                     <i class="fa fa-question-circle prem"></i> รับใบตอบรับ
                                    </button>
                                @elseif($row->Datenotice_legis != null)
                                    <button type="button" class="btn btn-danger btn-sm" title="{{DateThai($row->Datenotice_legis)}}">
                                     <i class="fa fa-question-circle prem"></i> ส่งโนติส
                                    </button>
                                @else
                                  <button type="button" class="btn btn-gray btn-sm" title="ยังไม่มีแจ้งเตือน">
                                   <i class="fa fa-question-circle prem"></i> ยังไม่มีแจ้งเตือน
                                  </button>
                                @endif
                              </td>
                              <td class="text-center">
                                <a href="{{ action('LegislationController@edit',[$row->Legisland_id, 12]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                  <span class="glyphicon glyphicon-pencil"></span> แก้ไข
                                </a>
                                <div class="form-inline form-group">
                                  <form method="post" class="delete_form" action="{{ action('LegislationController@destroy',[$row->Legisland_id ,4]) }}">
                                  {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="delete-modal btn btn-danger btn-sm" title="ลบรายการ" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?')">
                                      <span class="glyphicon glyphicon-trash"></span> ลบ
                                    </button>
                                  </form>
                                </div>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                     </div>
                    </div>

                  @endif
                </div>

                <a id="button"></a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <!-- Pop up ปริ้นใบเสร็จ -->
  <div class="modal fade" id="modal-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          {{-- <p>One fine body…</p> --}}
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  <!-- Pop up รายงานบันทึกชำะค่างวด -->
  <div class="modal fade" id="modal-2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          {{-- <p>One fine body…</p> --}}
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  <!-- Pop up รายงานลูกหนี้ประนอม -->
  <div class="modal fade" id="modal-3">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          {{-- <p>One fine body…</p> --}}
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  <!-- Pop up รายงานลูกหนี้ -->
  <div class="modal fade" id="modal-4">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          {{-- <p>One fine body…</p> --}}
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  <!-- Pop up รายงานลูกหนี้สืบพยาน -->
  <div class="modal fade" id="modal-5">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          {{-- <p>One fine body…</p> --}}
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  <!-- Pop up รายงานตรวจสอบยอดชำระ -->
  <div class="modal fade" id="modal-6">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          {{-- <p>One fine body…</p> --}}
        </div>
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

  {{-- Popup --}}
  <script>
    $(function () {
      $("#modal-1").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-1 .modal-body").load(link, function(){
        });
      });
      $("#modal-2").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-2 .modal-body").load(link, function(){
        });
      });
      $("#modal-3").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-3 .modal-body").load(link, function(){
        });
      });
      $("#modal-4").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-4 .modal-body").load(link, function(){
        });
      });
      $("#modal-5").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-5 .modal-body").load(link, function(){
        });
      });
      $("#modal-6").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-6 .modal-body").load(link, function(){
        });
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#table,#table1').DataTable( {
        "order": [[ 0, "asc" ]]
      });
    });
  </script>

  <script>
    function blinker() {
    $('.prem').fadeOut(1500);
    $('.prem').fadeIn(1500);
    }
    setInterval(blinker, 1500);
  </script>
@endsection
