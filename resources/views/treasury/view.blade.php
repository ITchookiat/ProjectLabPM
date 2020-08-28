@extends('layouts.master')
@section('title','แผนกการเงิน')
@section('content')

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

  <style>
    span:hover {
      color: blue;
    }
  </style>

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
                  รายการอนุมัติโอนเงิน (Approving transfers)
                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก การเงินใน")
                    <button class="btn btn-gray float-right">
                      ค่าคอม: <font color="red">{{ number_format($SumCommitprice) }}</font> บาท
                    </button>
                    <button class="btn btn-warning btn-xs float-right"></button>
                    <button class="btn btn-gray float-right">
                      ยอดจัด: <font color="red">{{ number_format($SumTopcar) }}</font> บาท
                    </button>
                    <button class="btn btn-warning btn-xs float-right"></button>
                    <button class="btn btn-gray float-right">
                        <i class="fa fa-calendar"></i>
                      @php
                        $dateStart = substr($newfdate, 8, 9);
                        $dateEnd = substr($newtdate, 8, 9);
                      @endphp
                        วันที่ {{ $dateStart }} ถึง {{ $dateEnd }}
                    </button>
                  @endif
                </h4>
              </div>
              <div class="card-body text-sm">
                <div class="row">
                  <div class="col-md-12">
                    <form method="get" action="{{ route('treasury', 1) }}">
                      <div class="float-right form-inline">
                        <div class="btn-group">
                          <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                            <span class="fas fa-print"></span> ปริ้นรายงาน
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-6" data-link="{{ route('treasury', 2) }}"> รายงานอนุมัติประจำวัน</a></li>
                            {{-- <li class="dropdown-divider"></li>
                            <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-7" data-link="{{ route('treasury', 3) }}"> รายงานโอนเงินประจำวัน</a></li> --}}
                          </ul>
                        </div>
                        <button type="submit" class="btn bg-warning btn-app">
                          <span class="fas fa-search"></span> Search
                        </button>
                      </div>
                      <br><br><br><p></p>
                      <div class="float-right form-inline">
                        <label>จากวันที่ : </label>
                        <input type="date" name="Fromdate" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />

                        <label>ถึงวันที่ : </label>
                        <input type="date" name="Todate" value="{{ ($newtdate != '') ?$newtdate: date('Y-m-d') }}" class="form-control" />
                      </div>
                    </form>
                    <br><br>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 col-sm-6 col-12">
                    <div class="info-box bg-lightblue">
                      <span class="info-box-icon bg-warning"><i class="fab fa-product-hunt"></i></span>
                      <div class="info-box-content">
                        <h5>รายการอนุมัติ PLoan (P03)</h5>
                        <span class="info-box-number">ประจำวันที่ {{ DateThai( date('Y-m-d')) }}</span>
                      </div>
                      <div class="info-box-content">
                        {{-- <h5>รวม :</h5>
                        <input type="text" name="Nickbuyer" style="text-align:right;" class="form-control" value=""/> --}}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 border-center">
                        <div class="table-responsive">
                          <table class="table table-striped table-valign-middle" id="table1">
                            <thead>
                              <tr>
                                <th class="text-center" style="width: 40px">No.</th>
                                <th class="text-left">สาขา</th>
                                <th class="text-left">ทะเบียน</th>
                                <th class="text-left">ผู้อนุมัติ</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-right"></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $key => $row)
                                @if($row->Type_Con == "P03")
                                  <tr>
                                    <td class="text-center"> {{$key+1}} </td>
                                    <td class="text-left"> {{$row->branch_car}} </td>
                                    <td class="text-left" data-toggle="modal" data-target="#modal-4" data-link="{{ route('SearchData', [1, $row->id]) }}" style="cursor: pointer;"> 
                                      <span>{{$row->License_car}}</span>
                                      @if ($row->Date_Appcar == date('Y-m-d'))
                                        <span class="badge bg-danger prem">NEW</span>
                                      @endif
                                      <i class="float-right fas fa-search-dollar"></i>
                                    </td>
                                    <td class="text-left">
                                      @if ($row->ManagerApp_car != NULL)
                                        {{$row->ManagerApp_car}} 
                                      @else
                                        {{$row->Approvers_car}} 
                                      @endif
                                    </td>
                                    <td class="text-center">
                                      @if ($row->UserCheckAc_car != NULL)
                                        <button type="button" class="btn btn-success btn-sm" title="{{ DateThai($row->DateCheckAc_car) }}" title="โอนเงินเรียบร้อยแล้ว">
                                          <i class="far fa-calendar-check"></i>&nbsp; Active
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-danger btn-sm" title="รอตรวจสอบ">
                                          <i class="fas fa-exclamation-circle prem"> </i>&nbsp; Recheck
                                        </button>
                                      @endif
                                    </td>
                                    <td class="text-right">
                                      <a data-toggle="modal" data-target="#modal-5" data-link="{{ route('SearchData', [2, $row->id]) }}" class="btn btn-warning btn-sm" title="ตรวจสอบบัญชี">
                                        <i class="far fa-edit"></i>
                                      </a>
                                    </td>
                                  </tr>
                                @endif
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-6 col-12">
                    <div class="info-box bg-lime">
                      <span class="info-box-icon bg-info"><i class="fab fa-medium"></i></span>
                      <div class="info-box-content">
                        <h5>รายการอนุมัติ Micro (P06)</h5>
                        <span class="info-box-number">ประจำวันที่ {{ DateThai( date('Y-m-d')) }}</span>
                      </div>
                      <div class="info-box-content">
                        {{-- <h5>รวม :</h5>
                        <input type="text" name="Nickbuyer" style="text-align:right;" class="form-control" value="#"/> --}}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 border-center">
                        <div class="table-responsive">
                          <table class="table table-striped table-valign-middle" id="table2">
                            <thead>
                              <tr>
                                <th class="text-center" style="width: 40px">No.</th>
                                <th class="text-left">สาขา</th>
                                <th class="text-left">ทะเบียน</th>
                                <th class="text-left">ผู้อนุมัติ</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-right"></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $key => $row)
                                @if($row->Type_Con == "P06")
                                  <tr>
                                    <td class="text-center"> {{$key+1}} </td>
                                    <td class="text-left"> {{$row->branch_car}} </td>
                                    <td class="text-left" data-toggle="modal" data-target="#modal-4" data-link="{{ route('SearchData', [1, $row->id]) }}" style="cursor: pointer;"> 
                                      <span>{{$row->License_car}}</span>
                                      @if ($row->Date_Appcar == date('Y-m-d'))
                                        <span class="badge bg-danger prem">NEW</span>
                                      @endif
                                      <i class="float-right fas fa-search-dollar"></i>
                                    </td>
                                    <td class="text-left">
                                      @if ($row->ManagerApp_car != NULL)
                                        {{$row->ManagerApp_car}} 
                                      @else
                                        {{$row->Approvers_car}} 
                                      @endif
                                    </td>
                                    <td class="text-center">
                                      @if ($row->UserCheckAc_car != NULL)
                                        <button type="button" class="btn btn-success btn-sm" title="{{ DateThai($row->DateCheckAc_car) }}" title="โอนเงินเรียบร้อยแล้ว">
                                          <i class="far fa-calendar-check"></i>&nbsp; Active
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-danger btn-sm" title="รอตรวจสอบ">
                                          <i class="fas fa-exclamation-circle prem"> </i>&nbsp; Recheck
                                        </button>
                                      @endif
                                    </td>
                                    <td class="text-right">
                                      <a data-toggle="modal" data-target="#modal-5" data-link="{{ route('SearchData', [2, $row->id]) }}" class="btn btn-warning btn-sm" title="ตรวจสอบบัญชี">
                                        <i class="far fa-edit"></i>
                                      </a>
                                    </td>
                                  </tr>
                                @endif
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <a id="button"></a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <!-- Pop up รายละเอียดค่าใช้จ่าย -->
  <div class="modal fade" id="modal-4">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <p>One fine body…</p>
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  <!-- Pop up ตรวจสอบหน้าเล่ม -->
  <div class="modal fade" id="modal-5">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-body">
          <p>One fine body…</p>
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  <!-- Pop up รายละเอียดค่าใช้จ่าย -->
  <div class="modal fade" id="modal-6">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <p>One fine body…</p>
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  <!-- Pop up รายละเอียดค่าใช้จ่าย -->
  <div class="modal fade" id="modal-7">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <p>One fine body…</p>
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>


  {{-- Popup --}}
  <script>
    $(function () {
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
      $("#modal-7").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-7 .modal-body").load(link, function(){
        });
      });
    });
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

  <script>
    function blinker() {
      $('.prem').fadeOut(1500);
      $('.prem').fadeIn(1500);
    }
    setInterval(blinker, 1500);
  </script>

@endsection
