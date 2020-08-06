@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
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

@php
  date_default_timezone_set('Asia/Bangkok');
  $date = date('Y-m-d', strtotime('-1 days'));
@endphp

@php
  date_default_timezone_set('Asia/Bangkok');
  $Y = date('Y') + 543;
  $m = date('m');
  $d = date('d');
  $time = date('H:i');
  $date2 = $Y.'-'.$m.'-'.$d;
@endphp

  <!-- Main content -->
  <section class="content">
    <div class="content-header">
      @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <strong>สำเร็จ!</strong> {{ session()->get('success') }}
        </div>
      @endif

      <section class="content">
        <div class="row justify-content-center">
          <div class="col-12 table-responsive">
            <div class="card">
              <div class="card-header">
                <h4>
                  @if($type == 3)
                    รายงานสินเชื่อ (Report Credit)
                  @elseif($type == 6)
                    รายงานสินเชื่อรถบ้าน
                  @elseif($type == 7)
                    รายงานส่งผู้บริหาร
                  @elseif($type == 11)
                    รายงานปรับโครงสร้าง
                  @elseif($type == 14)
                    รายงานมาตราการ COVID-19
                  @endif
                </h4>
              </div>

              <div class="card-body text-sm">
                @if($type == 3)
                  <div class="row">
                    <div class="col-md-12">
                      <form method="get" action="{{ route('Analysis', 3) }}">
                        <div class="float-right form-inline">
                          <a target="_blank" class="btn bg-success btn-app" href="{{ action('ExcelController@excel',$type) }}?&Fromdate={{$newfdate}}&Todate={{$newtdate}}&agen={{$agen}}&yearcar={{$yearcar}}&typecar={{$typecar}}&branch={{$branch}}">
                            <i class="far fa-file-excel"></i> Excel
                          </a>
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
                        </div>
                        <br><br>
                        <div class="float-right form-inline">
                          <label for="text" class="mr-sm-2">นายหน้า : </label>
                          <select name="agen" class="form-control" id="text" style="width: 180px">
                            <option selected disabled value="">---เลือกนายหน้า---</option>
                            @foreach($datadrop as $row)
                              <option value="{{ $row->Agent_car }}" {{ ($agen == $row->Agent_car) ? 'selected' : '' }}>{{ $row->Agent_car }}</otion>
                            @endforeach
                          </select>

                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <label for="text" class="mr-sm-2">ปี : </label>
                          <select name="yearcar" class="form-control" id="text" style="width: 180px">
                            <option selected disabled value="">---เลือกปี---</option>
                            @foreach($datayear as $row)
                              <option value="{{ $row->Year_car }}" {{ ($yearcar == $row->Year_car) ? 'selected' : '' }}>{{ $row->Year_car }}</otion>
                            @endforeach
                          </select>

                          <label for="text" class="mr-sm-2">แบบ : </label>
                          <select name="typecar" class="form-control" id="text" style="width: 180px">
                            <option selected disabled value="">---เลือกแบบ---</option>
                            @foreach($datastatus as $row)
                              <option value="{{ $row->status_car }}" {{ ($typecar == $row->status_car) ? 'selected' : '' }}>{{ $row->status_car }}</otion>
                            @endforeach
                          </select>
                          <label for="text" class="mr-sm-2">สาขา : </label>
                          <select name="branch" class="form-control" id="text" style="width: 180px">
                            <option selected disabled value="">---เลือกสาขา---</option>
                            @foreach($databranch as $row)
                              <option value="{{ $row->branch_car }}" {{ ($branch == $row->branch_car) ? 'selected' : '' }}>{{ $row->branch_car }}</otion>
                            @endforeach
                          </select>
                        </div>
                      </form>
                      <br><br>

                      <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead class="thead-dark bg-gray-light" >
                              <tr>
                                <th class="text-center">สาขา</th>
                                <th class="text-center">เลขที่สัญญา</th>
                                <th class="text-center">วันที่</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ยีห้อ</th>
                                <th class="text-center">ทะเบียนเดิม</th>
                                <th class="text-center">ปี</th>
                                <th class="text-center">ยอดจัด</th>
                                <th class="text-center">สถานะอนุมัติ</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $row)
                                <tr>
                                  <td class="text-center"> {{ $row->branch_car}} </td>
                                  <td class="text-center"> {{ $row->Contract_buyer}} </td>
                                  <td class="text-center">{{ DateThai($row->Date_Due)}}</td>
                                  <td class="text-center"> {{ $row->status_car}} </td>
                                  <td class="text-center"> {{ $row->Brand_car}} </td>
                                  <td class="text-center"> {{ $row->License_car}} </td>
                                  <td class="text-center"> {{ $row->Year_car}} </td>
                                  <td class="text-center">
                                    @if($row->Top_car != Null)
                                      {{ number_format($row->Top_car)}}
                                    @else
                                      0
                                    @endif
                                  </td>
                                  <td class="text-center">
                                    @if ( $row->Approvers_car != Null)
                                        {{ $row->Approvers_car }}
                                    @else
                                        <font color="red">รออนุมัติ</font>
                                    @endif
                                  </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div>
                @elseif($type == 6)
                  <div class="row">
                    <div class="col-md-12">
                      <form method="get" action="{{ route('Analysis', 6) }}">
                        <div class="float-right form-inline">
                          <a target="_blank" class="btn bg-success btn-app" href="{{ action('ExcelController@excel',$type) }}?&Fromdate={{$newfdate}}&Todate={{$newtdate}}&agen={{$agen}}&yearcar={{$yearcar}}">
                            <i class="far fa-file-excel"></i> Excel
                          </a>
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
                        </div>
                        <br><br>
                          <div class="float-right form-inline">
                          <label for="text" class="mr-sm-2">นายหน้า : </label>
                          <select name="agen" class="form-control" id="text" style="width: 180px">
                            <option selected disabled value="">---เลือกนายหน้า---</option>
                            @foreach($datadrop as $row)
                              <option value="{{ $row->agent_HC }}" {{ ($agen == $row->agent_HC) ? 'selected' : '' }}>{{ $row->agent_HC }}</otion>
                            @endforeach
                          </select>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <label for="text" class="mr-sm-2">ปี : </label>
                          <select name="yearcar" class="form-control" id="text" style="width: 180px">
                            <option selected disabled value="">---เลือกปี---</option>
                            @foreach($datayear as $row)
                              <option value="{{ $row->year_HC }}" {{ ($yearcar == $row->year_HC) ? 'selected' : '' }}>{{ $row->year_HC }}</otion>
                            @endforeach
                          </select>
                        </div>
                      </form>
                      <br><br>

                      <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead class="thead-dark bg-gray-light" >
                              <tr>
                                <th class="text-center">สาขา</th>
                                <th class="text-center">เลขที่สัญญา</th>
                                <th class="text-center">วันที่</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ยีห้อ</th>
                                <th class="text-center">ทะเบียนเดิม</th>
                                <th class="text-center">ปี</th>
                                <th class="text-center">ยอดจัด</th>
                                <th class="text-center">สถานะอนุมัติ</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $row)
                                <tr>
                                  <td class="text-center"> {{ $row->branchUS_HC}} </td>
                                  <td class="text-center"> {{ $row->Contract_buyer}} </td>
                                  <td class="text-center">{{ DateThai($row->Date_Due)}}</td>
                                  <td class="text-center"> {{ $row->baab_HC}} </td>
                                  <td class="text-center"> {{ $row->brand_HC}} </td>
                                  <td class="text-center"> {{ $row->oldplate_HC}} </td>
                                  <td class="text-center"> {{ $row->year_HC}} </td>
                                  <td class="text-center">
                                    @if($row->topprice_HC != Null)
                                      {{($row->topprice_HC)}}
                                    @else
                                      0
                                    @endif
                                  </td>
                                  <td class="text-center">
                                    @if ( $row->approvers_HC != Null)
                                        {{ $row->approvers_HC }}
                                    @else
                                        <font color="red">รออนุมัติ</font>
                                    @endif
                                  </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div>
                @elseif($type == 7)
                  <div class="row">
                    <div class="col-md-12">
                      <form method="get" action="{{ route('Analysis', 7) }}">
                        <div class="float-right form-inline">
                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>
                        <div class="float-right form-inline">
                          <label>จากวันที่ : </label>
                          <input type="date" name="Fromdate" style="width: 180px;" value="{{ ($fdate != '') ?$fdate: date('Y-m-d') }}" class="form-control" />
                          <label>ถึงวันที่ : </label>
                          <input type="date" name="Todate" style="width: 180px;" value="{{ ($tdate != '') ?$tdate: date('Y-m-d') }}" class="form-control" />
                        </div>
                      </form>

                      <form target="_blank" method="get" action="{{ action('ReportAnalysController@ReportDueDate', $type) }}">
                        <div align="left">
                          <button type="submit" class="btn bg-primary btn-app">
                            <span class="fas fa-print"></span> ปริ้นรายการ
                          </button >
                            <input type="hidden" name="Fromdate" style="width: 180px;" value="{{ ($fdate != '') ?$fdate: date('Y-m-d') }}" class="form-control" />
                            <input type="hidden" name="Todate" style="width: 180px;" value="{{ ($tdate != '') ?$tdate: date('Y-m-d') }}" class="form-control" />
                        </div>

                        <div class="table-responsive">
                          <table class="table table-bordered" id="table">
                            <thead class="thead-dark bg-gray-light" >
                              <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">สาขา</th>
                                <th class="text-center">เลขที่สัญญา</th>
                                <th class="text-center">วันที่</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ยีห้อ</th>
                                <th class="text-center">ทะเบียนเดิม</th>
                                <th class="text-center">ปี</th>
                                <th class="text-center">ยอดจัด</th>
                                <th class="text-center">สถานะอนุมัติ</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($dataReport as $row)
                                <tr>
                                  <td class="text-center">
                                  <label class="con3">
                                    <input type="checkbox" name="choose[]" value="{{$row->id}}" checked />
                                  <span class="checkmark3"></span>
                                  </label>
                                  </td>
                                  <td class="text-center"> {{ $row->branch_car}} </td>
                                  <td class="text-center"> {{ $row->Contract_buyer}} </td>
                                  <td class="text-center">{{ DateThai($row->Date_Due)}}</td>
                                  <td class="text-center"> {{ $row->status_car}} </td>
                                  <td class="text-center"> {{ $row->Brand_car}} </td>
                                  <td class="text-center"> {{ $row->License_car}} </td>
                                  <td class="text-center"> {{ $row->Year_car}} </td>
                                  <td class="text-center">
                                    @if($row->Top_car != Null)
                                      {{ number_format($row->Top_car)}}
                                    @else
                                      0
                                    @endif
                                  </td>
                                  <td class="text-center">
                                    @if ( $row->Approvers_car != Null)
                                        {{ $row->Approvers_car }}
                                    @else
                                        <font color="red">รออนุมัติ</font>
                                    @endif
                                  </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                      </form>
                    </div>
                  </div>
                @elseif($type == 11)
                  <div class="col-md-12">
                    <form method="get" action="{{ route('Analysis', 11) }}">
                      <div class="float-right form-inline">
                        <a target="_blank" class="btn bg-success btn-app" href="{{ action('ExcelController@excel',$type) }}?&Fromdate={{$newfdate}}&Todate={{$newtdate}}&agen={{$agen}}&yearcar={{$yearcar}}&typecar={{$typecar}}&branch={{$branch}}">
                          <i class="far fa-file-excel"></i> Excel
                        </a>
                        <button type="submit" class="btn bg-warning btn-app">
                          <span class="fas fa-search"></span> Search
                        </button>
                      </div>
                      <br><br><br><br>
                      <div class="float-right form-inline">
                        <label>จากวันที่ : </label>
                        <input type="date" name="Fromdate" style="width: 180px;" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />
                        <label>ถึงวันที่ : </label>
                        <input type="date" name="Todate" style="width: 180px;" value="{{ ($newtdate != '') ?$newtdate: date('Y-m-d') }}" class="form-control" />
                      </div>
                    </form>
                    <br><br>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="table">
                          <thead class="thead-dark bg-gray-light" >
                            <tr>
                              <th class="text-center">สาขา</th>
                              <th class="text-center">เลขที่สัญญา</th>
                              <th class="text-center">วันที่</th>
                              <th class="text-center">สถานะ</th>
                              <th class="text-center">ยีห้อ</th>
                              <th class="text-center">ทะเบียนเดิม</th>
                              <th class="text-center">ปี</th>
                              <th class="text-center">ยอดจัด</th>
                              <th class="text-center">สถานะอนุมัติ</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $row)
                              <tr>
                                <td class="text-center"> {{ $row->branch_car}} </td>
                                <td class="text-center"> {{ $row->Contract_buyer}} </td>
                                <td class="text-center">{{ DateThai($row->Date_Due)}}</td>
                                <td class="text-center"> {{ $row->status_car}} </td>
                                <td class="text-center"> {{ $row->Brand_car}} </td>
                                <td class="text-center"> {{ $row->License_car}} </td>
                                <td class="text-center"> {{ $row->Year_car}} </td>
                                <td class="text-center">
                                  @if($row->Top_car != Null)
                                    {{ number_format($row->Top_car)}}
                                  @else
                                    0
                                  @endif
                                </td>
                                <td class="text-center">
                                  @if ( $row->Approvers_car != Null)
                                      {{ $row->Approvers_car }}
                                  @else
                                      <font color="red">รออนุมัติ</font>
                                  @endif
                                </td>
                              </tr>
                              @endforeach
                          </tbody>
                        </table>
                    </div>
                  </div>
                @elseif($type == 14)
                  <div class="col-md-12">
                    <form method="get" action="{{ route('Analysis', 14) }}">
                      <div class="float-right form-inline">
                        <a target="_blank" class="btn bg-success btn-app" href="{{ action('ExcelController@excel',$type) }}?&Fromdate={{$newfdate}}&Todate={{$newtdate}}&agen={{$agen}}&yearcar={{$yearcar}}&typecar={{$typecar}}&branch={{$branch}}">
                          <i class="far fa-file-excel"></i> Excel
                        </a>
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
                      </div>
                    </form>
                    <br><br>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="table">
                          <thead class="thead-dark bg-gray-light" >
                            <tr>
                              <th class="text-center" style="width:90px;">สาขา</th>
                              <th class="text-center">เลขที่สัญญา</th>
                              <th class="text-center">วันที่</th>
                              <th class="text-center">สถานะ</th>
                              <th class="text-center">ยีห้อ</th>
                              <th class="text-center">ทะเบียนเดิม</th>
                              <th class="text-center">ปี</th>
                              <th class="text-center">ยอดจัด</th>
                              <th class="text-center">สถานะอนุมัติ</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $row)
                              <tr>
                                <td class="text-center">
                                  {{ $row->branch_car}}<br/>
                                  (<font color="blue" size="1px">{{ $row->Objective_car}}</font>)
                                </td>
                                <td class="text-center"> {{ $row->Contract_buyer}} </td>
                                <td class="text-center">{{ DateThai($row->Date_Due)}}</td>
                                <td class="text-center"> {{ $row->status_car}} </td>
                                <td class="text-center"> {{ $row->Brand_car}} </td>
                                <td class="text-center"> {{ $row->License_car}} </td>
                                <td class="text-center"> {{ $row->Year_car}} </td>
                                <td class="text-center">
                                  @if($row->Top_car != Null)
                                    {{ number_format($row->Top_car)}}
                                  @else
                                    0
                                  @endif
                                </td>
                                <td class="text-center">
                                  @if ( $row->Approvers_car != Null)
                                      {{ $row->Approvers_car }}
                                  @else
                                      <font color="red">รออนุมัติ</font>
                                  @endif
                                </td>
                              </tr>
                              @endforeach
                          </tbody>
                        </table>
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

  @if($type == 7)
    <script type="text/javascript">
      $(document).ready(function() {
        $('#table').DataTable( {
          "order": [[ 0, "asc" ]],
          "pageLength": 25
        } );
      } );
    </script>
  @else
    <script type="text/javascript">
      $(document).ready(function() {
        $('#table').DataTable( {
          "order": [[ 1, "asc" ]]
        } );
      } );
    </script>
  @endif

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
    $(".alert").fadeTo(3000, 1000).slideUp(1000, function(){
    $(".alert").alert('close');
    });
  </script>
@endsection
