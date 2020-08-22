@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
@section('content')

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
                    รายการสินเชื่อ (PLoan-Micro)
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
                  @endif
                </h4>
              </div>
              <div class="card-body text-sm">
                <div class="card card-warning card-tabs">
                  <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs">

                      @if($type == 1)
                        <li class="nav-item">
                          <a class="nav-link active" id="Tab-Main-1" href="{{ route('Analysis', 1) }}" >หน้าหลัก</a>
                        </li>
                        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                          <li class="nav-item">
                            <a class="nav-link" id="Tab-sub-1" href="{{ route('Analysis', 2) }}" >แบบฟอร์มผู้เช่าซื้อ</a>
                          </li>
                        @endif
                      @endif

                      {{-- <li class="nav-item">
                        <a class="nav-link" href="#">แบบฟอร์มผู้ค้ำ</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">แบบฟอร์มรถยนต์</a>
                      </li>
                      @if($type == 1)
                        <li class="nav-item">
                          <a class="nav-link" href="#">แบบฟอร์มค่าใช้จ่าย</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#">Checker</a>
                        </li>
                      @endif --}}
                    </ul>
                  </div>
                  
                  @if($type == 1)
                    <div class="col-md-12">
                      <form method="get" action="{{ route('Analysis',1) }}">
                        <p></p>
                        <div class="row mb-0">
                          <div class="col-md-12">
                            <div class="float-right form-inline">
                              @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                <a target="_blank" href="{{ action('ReportAnalysController@ReportDueDate', $type) }}" class="btn bg-primary btn-app">
                                  <span class="fas fa-print"></span> ปริ้นรายการ
                                </a>
                              @endif

                              <button type="submit" class="btn bg-warning btn-app">
                                <span class="fas fa-search"></span> Search
                              </button>
                            </div>
                          </div>
                        </div>
                        <div class="row mb-1">
                          <div class="col-md-12">
                            <div class="float-right form-inline">
                              @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                                <label class="mr-sm-2">เลขที่สัญญา : </label>
                                <input type="type" name="Contno" value="{{$contno}}" maxlength="12" class="form-control"/>
                              @else
                                <label class="mr-sm-2">เลขที่สัญญา : </label>
                                <input type="type" name="Contno" value="{{$contno}}" maxlength="12" class="form-control"/>
                              @endif

                              <label class="mr-sm-2">จากวันที่ : </label>
                              <input type="date" name="Fromdate" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />

                              <label class="mr-sm-2">ถึงวันที่ : </label>
                              <input type="date" name="Todate" value="{{ ($newtdate != '') ?$newtdate: date('Y-m-d') }}" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="row mb-0">
                          <div class="col-md-12">
                            <div class="float-right form-inline">
                              <label for="text" class="mr-sm-2">สาขา : </label>
                              <select name="branch" class="form-control">
                                <option selected value="">----------เลือกสาขา--------</option>
                                <option value="ปัตตานี" {{ ($branch == 'ปัตตานี') ? 'selected' : '' }}>ปัตตานี</otion>
                                <option value="ยะลา" {{ ($branch == 'ยะลา') ? 'selected' : '' }}>ยะลา</otion>
                                <option value="นราธิวาส" {{ ($branch == 'นราธิวาส') ? 'selected' : '' }}>นราธิวาส</otion>
                                <option value="สายบุรี" {{ ($branch == 'สายบุรี') ? 'selected' : '' }}>สายบุรี</otion>
                                <option value="โกลก" {{ ($branch == 'โกลก') ? 'selected' : '' }}>โกลก</otion>
                                <option value="เบตง" {{ ($branch == 'เบตง') ? 'selected' : '' }}>เบตง</otion>
                              </select>

                              <label for="text" class="mr-sm-2">&nbsp;&nbsp;&nbsp;สัญญา : </label>
                              <select name="TypeContract" class="form-control">
                                <option selected value="">-----เลือกสัญญา-----</option>
                                <option value="P03" {{ ($typeCon == 'P03') ? 'selected' : '' }}>PLoan (P03)</otion>
                                <option value="P06" {{ ($typeCon == 'P06') ? 'selected' : '' }}>Micro (P06)</otion>
                              </select>

                              <label for="text" class="mr-sm-2">สถานะ : </label>
                              <select name="status" class="form-control">
                                <option selected value="">---------สถานะ--------</option>
                                <option value="อนุมัติ"{{ ($status == 'อนุมัติ') ? 'selected' : '' }}>อนุมัติ</otion>
                                <option value="รออนุมัติ"{{ ($status == 'รออนุมัติ') ? 'selected' : '' }}>รออนุมัติ</otion>
                              </select>
                            </div>
                          </div>
                        </div>


                      </form>
                    </div>
                    <hr>
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-valign-middle" id="table1">
                            <thead>
                              <tr>
                                <th class="text-center">สาขา</th>
                                <th class="text-left">เลขที่สัญญา</th>
                                <th class="text-left">แบบ</th>
                                <th class="text-left">ยีห้อ</th>
                                <th class="text-left">ทะเบียน</th>
                                <th class="text-left">ปี</th>
                                <th class="text-center">ยอดจัด</th>
                                <th class="text-center"></th>
                                <th class="text-left" style="width: 250px">สถานะ</th>
                                <th class="text-center" style="width: 100px"></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $row)
                                <tr>
                                  <td class="text-center"> {{ $row->branch_car}} </td>
                                  <td class="text-left"> 
                                    {{ $row->Contract_buyer}} 
                                    @if ($row->Flag == "N" or $row->Flag == "Y")
                                      <span class="badge bg-danger prem">PLoan</span>
                                    @elseif($row->Flag == "D" or $row->Flag == "E")
                                      <span class="badge bg-info prem">Micro</span>
                                    @endif
                                  </td>
                                  <td class="text-left"> {{ $row->status_car}} </td>
                                  <td class="text-left"> {{ $row->Brand_car}} </td>
                                  <td class="text-left"> {{ $row->License_car}} </td>
                                  <td class="text-left"> {{ $row->Year_car}} </td>
                                  <td class="text-right">
                                    @if($row->Top_car != Null)
                                      {{ number_format($row->Top_car)}}
                                    @else
                                      0
                                    @endif
                                  </td>
                                  <td class="text-center">
                                    <div class="float-right form-inline">
                                      @if ( $row->DocComplete_car != Null)
                                        <h5><span class="badge badge-danger">
                                          <i class="fas fa-clipboard-check"></i>
                                        </span></h5>&nbsp;
                                      @endif

                                      @if ( $row->tran_Price != 0)
                                        <h5><span class="badge badge-info">
                                            <i class="fas fa-spell-check"></i>
                                        </span></h5>
                                      @endif
                                    </div>
                                  </td>
                                  <td class="text-left">
                                    @if ( $row->Check_car != Null)
                                      <button type="button" class="btn btn-success btn-xs">
                                        <i class="fas fa-user-check prem"></i> หัวหน้า
                                      </button>
                                    @else
                                      <button type="button" class="btn btn-warning btn-xs">
                                        <i class="fas fa-user-check prem"></i> หัวหน้า
                                      </button>
                                    @endif

                                    @if ( $row->Approvers_car != Null)
                                      <button type="button" class="btn btn-success btn-xs">
                                        <i class="fas fa-user-check prem"></i> Audit
                                      </button>
                                    @else
                                      <button type="button" class="btn btn-warning btn-xs">
                                        <i class="fas fa-user-check prem"></i> Audit
                                      </button>
                                    @endif

                                    @if($row->Top_car > 250000)
                                      @if ($row->ManagerApp_car != Null)
                                        <button type="button" class="btn btn-success btn-xs">
                                          <i class="fas fa-user-tie prem"></i> ผู้จัดการ
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-warning btn-xs">
                                          <i class="fas fa-user-tie prem"></i> ผู้จัดการ
                                        </button>
                                      @endif
                                    @endif
                                  </td>
                                  <td class="text-right">
                                    <a target="_blank" href="{{ action('ReportAnalysController@ReportPDFIndex',[$row->id,$type]) }}" class="btn btn-info btn-sm" title="พิมพ์">
                                      <i class="fas fa-print"></i>
                                    </a>

                                    @if($branch == "")
                                      @php $branch = 'Null'; @endphp
                                    @endif
                                    @if($status == "")
                                      @php $status = 'Null'; @endphp
                                    @endif
                                    @if($typeCon == "")
                                      @php $typeCon = 'Null'; @endphp
                                    @endif

                                    {{-- แก้ไข / ดูรายการ --}}
                                    @if(auth::user()->type == "Admin")
                                      <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status,$typeCon]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                        <i class="far fa-edit"></i>
                                      </a>
                                    @elseif(auth::user()->position == "MANAGER" or auth::user()->position == "AUDIT" or auth::user()->position == "MASTER" or auth::user()->position == "STAFF")
                                      @if($row->StatusApp_car == 'อนุมัติ')
                                        <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status,$typeCon]) }}" class="btn btn-success btn-sm" title="ดูรายการ">
                                          <i class="fas fa-eye"></i>
                                        </a>
                                      @else
                                        <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status,$typeCon]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                          <i class="far fa-edit"></i>
                                        </a>
                                      @endif
                                    @endif

                                    @if(auth::user()->type == "Admin") 
                                      <form method="post" class="delete_form" action="{{ action('AnalysController@destroy',[$row->id,$type]) }}" style="display:inline;">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" data-name="{{ $row->Contract_buyer }}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                          <i class="far fa-trash-alt"></i>
                                        </button>
                                      </form>
                                    @elseif(auth::user()->position == "MASTER" or auth::user()->position == "STAFF")
                                      @if($row->StatusApp_car != 'อนุมัติ')
                                        <form method="post" class="delete_form" action="{{ action('AnalysController@destroy',[$row->id,$type]) }}" style="display:inline;">
                                          {{csrf_field()}}
                                          <input type="hidden" name="_method" value="DELETE" />
                                          <button type="submit" data-name="{{ $row->Contract_buyer }}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                            <i class="far fa-trash-alt"></i>
                                          </button>
                                        </form>
                                      @endif
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
        </div>
      </section>
    </div>
  </section>

  <form action="{{ route('MasterAnalysis.store') }}" method="post">
    <div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">เพิ่มรายการ</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ป้ายทะเบียน :</label>
                      <div class="col-sm-8">
                        <input type="text" name="RegCar" class="form-control" placeholder="ป้อนป้ายทะเบียน" required/>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">เบอร์ลูกค้า :</label>
                      <div class="col-sm-8">
                        <input type="text" name="Phone_buyer" class="form-control" placeholder="ป้อนเบอร์ลูกค้า"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">เบอร์นายหน้า :</label>
                      <div class="col-sm-8">
                        <input type="text" name="Phone_agen" class="form-control" placeholder="ป้อนเบอร์นายหน้า"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">หมายเหตุ :</label>
                      <div class="col-sm-8">
                        <textarea class="form-control" name="Note_buyer" rows="3" placeholder="ป้อนหมายเหตุ..."></textarea>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
              <button type="submit" class="btn btn-primary text-center">บันทึก</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  </form>

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
    $(function () {
      $("#table1").DataTable({
        "responsive": true,
        "autoWidth": false,
        "ordering": true,
        "lengthChange": true,
        "order": [[ 1, "asc" ]],
      });
    });
  </script>

  <script>
    function blinker() {
    $('.prem').fadeOut(2000);
    $('.prem').fadeIn(2000);
    }
    setInterval(blinker, 2000);
  </script>

@endsection
