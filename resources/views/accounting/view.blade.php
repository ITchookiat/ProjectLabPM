@extends('layouts.master')
@section('title','แผนกบัญชี')
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
                  รายการโอนเงินประจำวัน (Internal audit)
                </h4>
              </div>
              <div class="card-body text-sm">
                <div class="row">
                  <div class="col-md-12">
                    <form method="get" action="{{ route('Accounting', 1) }}">
                      <div class="float-right form-inline">
                        <div class="btn-group">
                          <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                            <span class="fas fa-print"></span> ปริ้นรายงาน
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a target="_blank" class="dropdown-item" data-toggle="modal" data-target="#modal-1" data-link="{{ route('Accounting', 2) }}"> รายงานตรวจสอบโอนเงิน</a></li>
                          </ul>
                        </div>
                        <button type="submit" class="btn bg-warning btn-app">
                          <span class="fas fa-search"></span> Search
                        </button>
                      </div>
                      <br><br><br><p></p>
                      <div class="float-right form-inline">
                        <label>จากวันที่ : </label>
                        <input type="date" name="Fromdate" value="{{ date('Y-m-d') }}" class="form-control" />

                        <label>ถึงวันที่ : </label>
                        <input type="date" name="Todate" value="{{ date('Y-m-d') }}" class="form-control" />
                      </div>
                    </form>
                    <br><br>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 col-sm-6 col-12">
                    <div class="info-box bg-orange">
                      <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                      <div class="info-box-content">
                        <h5>รายการอนุมัติ</h5>
                        <span class="info-box-number">ประจำวันที่ {{ DateThai( date('Y-m-d')) }}</span>
                      </div>
                      <div class="info-box-content">
                        <h5>รวม :</h5>
                        <input type="text" name="Nickbuyer" style="text-align:right;" class="form-control" value="{{ number_format($SumApp, 2) }}"/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 border-center">
                        <div class="table-responsive">
                          <table class="table table-striped table-valign-middle" id="table1">
                            <thead>
                              <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">เลขที่สัญญา</th>
                                <th class="text-left">ชื่อ-สกุล</th>
                                <th class="text-left">ยอด</th>
                                <th class="text-right"></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($dataApp as $key => $row)
                                <tr>
                                  <td class="text-center"> {{$key+1}} </td>
                                  <td class="text-center"> {{$row->Contract_buyer}}</td>
                                  <td class="text-left"> {{$row->Name_buyer}} {{$row->last_buyer}}</td>
                                  <td class="text-left"> {{ number_format($row->Top_car,2) }} </td>
                                  <td class="text-right">
                                    <a class="btn btn-success btn-sm" title="{{ $row->Approvers_car }}">
                                      <i class="fas fa-check-square"></i>
                                    </a>
                                  </td>
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
                      <span class="info-box-icon bg-info"><i class="fas fa-comments-dollar"></i></span>
                      <div class="info-box-content">
                        <h5>รายการโอนเงิน</h5>
                        <span class="info-box-number">ประจำวันที่ {{ DateThai( date('Y-m-d')) }}</span>
                      </div>
                      <div class="info-box-content">
                        <h5>รวม :</h5>
                        <input type="text" name="Nickbuyer" style="text-align:right;" class="form-control" value="{{ number_format($SumTrans, 2) }}"/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 border-center">
                        <div class="table-responsive">
                          <table class="table table-striped table-valign-middle" id="table2">
                            <thead>
                              <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">เลขที่สัญญา</th>
                                <th class="text-left">ชื่อ-สกุล</th>
                                <th class="text-left">ยอด</th>
                                <th class="text-right"></th>
                              </tr>
                            </thead>
                            <tbody>
                              @php $Sum1 = 0; @endphp
                              @foreach($dataTrans as $key => $row)
                                <tr>
                                  <td class="text-center"> {{$key+1}} </td>
                                  <td class="text-center"> {{$row->Contract_buyer}}</td>
                                  <td class="text-left"> {{$row->Name_buyer}} {{$row->last_buyer}}</td>
                                  <td class="text-left"> {{ number_format($row->Top_car,2) }} </td>
                                  <td class="text-right">
                                    <a target="_blank" href="{{ action('ReportAnalysController@ReportPDFIndex',[$row->id, 1]) }}" class="btn btn-info btn-sm" title="พิมพ์">
                                      <i class="fas fa-print"></i>
                                    </a>
                                  </td>
                                </tr>
                                @php
                                  $Sum1 += $row->Top_car;
                                @endphp
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
  <div class="modal fade" id="modal-1">
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
      $("#modal-1").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-1 .modal-body").load(link, function(){
        });
      });
    });
  </script>

  <script>
    $(function () {
      $("#table1,#table2").DataTable({
        "responsive": true,
        "autoWidth": false,
        "ordering": false,
        "lengthChange": true,
        "paging": true,
        "searching": true,
        "info": true,
        "order": [[ 1, "asc" ]],
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
