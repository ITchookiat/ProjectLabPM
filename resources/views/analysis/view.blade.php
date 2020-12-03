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
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            @if($type == 1)
              <h4>รายการสัญญาเงินกู้ (Loan Agreement)</h4>
            @endif
          </div>
          <div class="col-sm-6">
            @if($type == 1)
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
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
          @if(auth::user()->type == 'Admin' or auth::user()->type == 'แผนก วิเคราะห์')
          <a href="{{ route('Analysis', 2) }}" class="btn btn-success btn-block mb-3">Compose</a>
        @else
          <a href="#" class="btn btn-success btn-block mb-3">Compose</a>
        @endif
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">List</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="vert-tabs-PLoan-tab" data-toggle="pill" href="#vert-tabs-PLoan" role="tab" aria-controls="vert-tabs-PLoan" aria-selected="true">
                <i class="fas fa-hdd"></i> สัญญาเงินกู้ PLoan (P03)
                @if($CountP03 != 0)
                  <span class="badge bg-primary float-right">{{$CountP03}}</span>
                @endif
              </a>
              <a class="nav-link" id="vert-tabs-Micro-tab" data-toggle="pill" href="#vert-tabs-Micro" role="tab" aria-controls="vert-tabs-Micro" aria-selected="false">
                <i class="fas fa-hdd"></i> สัญญาเงินกู้ Micro (P06)
                @if($CountP06 != 0)
                  <span class="badge bg-primary float-right">{{$CountP06}}</span>
                @endif
              </a>
              <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">
                <i class="fas fa-hdd"></i> สัญญาเงินกู้ พนักงาน (P07)
                @if($CountP07 != 0)
                  <span class="badge bg-primary float-right">{{$CountP07}}</span>
                @endif
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="card">
          <div class="card-body text-sm">
            @if($type == 1)
              <form method="get" action="{{ route('Analysis',1) }}">
                <div class="float-right form-inline">
                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                    <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                      <span class="fas fa-print"></span> ปริ้นรายงาน
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a target="_blank" class="dropdown-item" href="{{ action('ReportAnalysController@ReportDueDate', 8) }}"> รายงานขอเบิกเงินประจำวัน</a></li>
                      <li class="dropdown-divider"></li>
                      <li><a target="_blank" class="dropdown-item" href="{{ action('ReportAnalysController@ReportDueDate', 1) }}"> รายงานขออนุมัติประจำวัน</a></li>
                    </ul>
                  @endif
                  <button type="submit" class="btn bg-warning btn-app">
                    <span class="fas fa-search"></span> Search
                  </button>
                </div>
                <div class="float-right form-inline">
                  @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                    <label class="mr-sm-2">เลขที่สัญญา : </label>
                    <input type="type" name="Contno" value="{{$contno}}" maxlength="13" class="form-control"/>
                  @else
                    <label class="mr-sm-2">เลขที่สัญญา : </label>
                    <input type="type" name="Contno" value="{{$contno}}" maxlength="13" class="form-control"/>
                  @endif

                  <label class="mr-sm-2">จากวันที่ : </label>
                  <input type="date" name="Fromdate" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />

                  <label class="mr-sm-2">ถึงวันที่ : </label>
                  <input type="date" name="Todate" value="{{ ($newtdate != '') ?$newtdate: date('Y-m-d') }}" class="form-control" />
                </div>
                <div class="float-right form-inline">
                  <label for="text" class="mr-sm-2">สาขา : </label>
                  <select name="branch" class="form-control">
                    <option selected value="">------เลือกสาขา------</option>
                    <option value="ปัตตานี" {{ ($branch == 'ปัตตานี') ? 'selected' : '' }}>ปัตตานี (50)</option>
                    <option value="ยะลา" {{ ($branch == 'ยะลา') ? 'selected' : '' }}>ยะลา (51)</option>
                    <option value="นราธิวาส" {{ ($branch == 'นราธิวาส') ? 'selected' : '' }}>นราธิวาส (52)</option>
                    <option value="สายบุรี" {{ ($branch == 'สายบุรี') ? 'selected' : '' }}>สายบุรี (53)</option>
                    <option value="โกลก" {{ ($branch == 'โกลก') ? 'selected' : '' }}>โกลก (54)</option>
                    <option value="เบตง" {{ ($branch == 'เบตง') ? 'selected' : '' }}>เบตง (55)</option>
                    <option value="โคกโพธิ์" {{ ($branch == 'โคกโพธิ์') ? 'selected' : '' }}>โคกโพธิ์ (56)</option>
                    <option value="ตันหยงมัส" {{ ($branch == 'ตันหยงมัส') ? 'selected' : '' }}>ตันหยงมัส (57)</option>
                    <option value="บังนังสตา" {{ ($branch == 'บังนังสตา') ? 'selected' : '' }}>บังนังสตา (58)</option>
                  </select>

                  <label for="text" class="mr-sm-2">สถานะ : </label>
                  <select name="status" class="form-control">
                    <option selected value="">---------สถานะ--------</option>
                    <option value="อนุมัติ"{{ ($status == 'อนุมัติ') ? 'selected' : '' }}>อนุมัติ</option>
                    <option value="รออนุมัติ"{{ ($status == 'รออนุมัติ') ? 'selected' : '' }}>รออนุมัติ</option>
                  </select>
                </div>
              </form>
            @endif
          </div>
        </div>

        <div class="card card-primary card-outline">
          <div class="card-body p-0 text-sm">
            <div class="row">
              <div class="col-12 col-sm-12">
                <div class="tab-content" id="vert-tabs-tabContent">
                  <div class="tab-pane text-left fade active show" id="vert-tabs-PLoan" role="tabpanel" aria-labelledby="vert-tabs-PLoan-tab">
                    <div class="card-header">
                      <h3 class="card-title">รายการสัญญาเงินกู้ PLoan (P03)</h3>
                    </div>
                    <div class="col-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-valign-middle" id="table1">
                            <thead>
                              <tr>
                                <th class="text-center">สาขา</th>
                                <th class="text-left">เลขที่สัญญา</th>
                                <!-- <th class="text-left">แบบ</th> -->
                                <th class="text-left">ยีห้อ</th>
                                <th class="text-left">ทะเบียน</th>
                                <th class="text-left">ปี</th>
                                <th class="text-center">ยอดจัด</th>
                                <th class="text-center">% ยอดจัด</th>
                                <th class="text-center"></th>
                                <th class="text-left" style="width: 100px">สถานะ</th>
                                <th class="text-center" style="width: 105px"></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $row)
                                @if($row->Type_Con == "P03")
                                  <tr>
                                    <td class="text-center"> {{ $row->branch_car}} </td>
                                    <td class="text-left"> 
                                      {{ $row->Contract_buyer}} 
                                      {{-- @if ($row->Type_Con == "P03")
                                        <span class="badge bg-danger prem">PLoan</span>
                                      @endif --}}
                                    </td>
                                    <!-- <td class="text-left"> {{ $row->status_car}} </td> -->
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
                                    <td class="text-center">{{ ($row->Percent_car != Null) ? $row->Percent_car.'%' : ' ' }}</td>
                                    <td class="text-center">
                                      <div class="float-right form-inline">
                                        @if ( $row->DocComplete_car != Null)
                                          <h5><span class="badge badge-danger">
                                            <i class="fas fa-clipboard-check"></i>
                                          </span></h5>&nbsp;
                                          {{-- <button type="button" class="btn btn-danger btn-xs" title="ลบรายการ">
                                            <i class="fas fa-clipboard-check"></i>
                                          </button> --}}
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
                                          <i class="fas fa-user-check prem"></i>
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-warning btn-xs">
                                          <i class="fas fa-user-check prem"></i>
                                        </button>
                                      @endif

                                      @if ( $row->Approvers_car != Null)
                                        <button type="button" class="btn btn-success btn-xs">
                                          <i class="fas fa-user-tie prem"></i>
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-warning btn-xs">
                                          <i class="fas fa-user-tie prem"></i>
                                        </button>
                                      @endif

                                      @if($row->Top_car > 250000)
                                        @if ($row->ManagerApp_car != Null)
                                          <button type="button" class="btn btn-success btn-xs">
                                            <i class="fas fa-user-lock prem"></i>
                                          </button>
                                        @else
                                          <button type="button" class="btn btn-warning btn-xs">
                                            <i class="fas fa-user-lock prem"></i>
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

                                      {{-- แก้ไข / ดูรายการ --}}
                                      @if(auth::user()->type == "Admin")
                                        <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                          <i class="far fa-edit"></i>
                                        </a>
                                      @elseif(auth::user()->position == "MANAGER" or auth::user()->position == "AUDIT" or auth::user()->position == "MASTER" or auth::user()->position == "STAFF")
                                        @if($row->StatusApp_car == 'อนุมัติ')
                                          <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status]) }}" class="btn btn-success btn-sm" title="ดูรายการ">
                                            <i class="fas fa-eye"></i>
                                          </a>
                                        @else
                                          <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                            <i class="far fa-edit"></i>
                                          </a>
                                        @endif
                                      @endif

                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์") 
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
                                @endif
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-Micro" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                    <div class="card-header">
                      <h3 class="card-title">รายการสัญญาเงินกู้ Micro (P06)</h3>
                    </div>
                    <div class="col-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-valign-middle" id="table2">
                            <thead>
                              <tr>
                                <th class="text-center">สาขา</th>
                                <th class="text-left">เลขที่สัญญา</th>
                                <!-- <th class="text-left">แบบ</th> -->
                                <th class="text-left">ยีห้อ</th>
                                <th class="text-left">ทะเบียน</th>
                                <th class="text-left">ปี</th>
                                <th class="text-center">ยอดจัด</th>
                                <th class="text-center">% ยอดจัด</th>
                                <th class="text-center"></th>
                                <th class="text-left" style="width: 100px">สถานะ</th>
                                <th class="text-center" style="width: 105px"></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $row)
                                @if($row->Type_Con == "P06")
                                  <tr>
                                    <td class="text-center"> {{ $row->branch_car}} </td>
                                    <td class="text-left"> 
                                      {{ $row->Contract_buyer}} 
                                      {{-- @if($row->Type_Con == "P06")
                                        <span class="badge bg-info prem">Micro</span>
                                      @endif --}}
                                    </td>
                                    <!-- <td class="text-left"> {{ $row->status_car}} </td> -->
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
                                    <td class="text-center">{{ ($row->Percent_car != Null) ? $row->Percent_car.'%' : ' ' }}</td>
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
                                          <i class="fas fa-user-check prem"></i>
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-warning btn-xs">
                                          <i class="fas fa-user-check prem"></i>
                                        </button>
                                      @endif

                                      @if ( $row->Approvers_car != Null)
                                        <button type="button" class="btn btn-success btn-xs">
                                          <i class="fas fa-user-tie prem"></i>
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-warning btn-xs">
                                          <i class="fas fa-user-tie prem"></i>
                                        </button>
                                      @endif

                                      @if($row->Top_car > 250000)
                                        @if ($row->ManagerApp_car != Null)
                                          <button type="button" class="btn btn-success btn-xs">
                                            <i class="fas fa-user-lock prem"></i>
                                          </button>
                                        @else
                                          <button type="button" class="btn btn-warning btn-xs">
                                            <i class="fas fa-user-lock prem"></i>
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

                                      {{-- แก้ไข / ดูรายการ --}}
                                      @if(auth::user()->type == "Admin")
                                        <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                          <i class="far fa-edit"></i>
                                        </a>
                                      @elseif(auth::user()->position == "MANAGER" or auth::user()->position == "AUDIT" or auth::user()->position == "MASTER" or auth::user()->position == "STAFF")
                                        @if($row->StatusApp_car == 'อนุมัติ')
                                          <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status]) }}" class="btn btn-success btn-sm" title="ดูรายการ">
                                            <i class="fas fa-eye"></i>
                                          </a>
                                        @else
                                          <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                            <i class="far fa-edit"></i>
                                          </a>
                                        @endif
                                      @endif

                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์") 
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
                                @endif
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                    <div class="card-header">
                      <h3 class="card-title">รายการสัญญาเงินกู้ พนักงาน (P07)</h3>
                    </div>
                    <div class="col-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-valign-middle" id="table2">
                            <thead>
                              <tr>
                                <th class="text-center">สาขา</th>
                                <th class="text-left">เลขที่สัญญา</th>
                                <!-- <th class="text-left">แบบ</th> -->
                                <th class="text-left">ยีห้อ</th>
                                <th class="text-left">ทะเบียน</th>
                                <th class="text-left">ปี</th>
                                <th class="text-center">ยอดจัด</th>
                                <th class="text-center"></th>
                                <th class="text-left" style="width: 100px">สถานะ</th>
                                <th class="text-center" style="width: 105px"></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $row)
                                @if($row->Type_Con == "P07")
                                  <tr>
                                    <td class="text-center"> {{ $row->branch_car}} </td>
                                    <td class="text-left"> 
                                      {{ $row->Contract_buyer}} 
                                      {{-- @if($row->Type_Con == "P07")
                                        <span class="badge bg-warning prem">Staff</span>
                                      @endif --}}
                                    </td>
                                    <!-- <td class="text-left"> {{ $row->status_car}} </td> -->
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
                                    <td class="text-center">{{ ($row->Percent_car != Null) ? $row->Percent_car.'%' : ' ' }}</td>
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
                                          <i class="fas fa-user-check prem"></i>
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-warning btn-xs">
                                          <i class="fas fa-user-check prem"></i>
                                        </button>
                                      @endif

                                      @if ( $row->Approvers_car != Null)
                                        <button type="button" class="btn btn-success btn-xs">
                                          <i class="fas fa-user-tie prem"></i>
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-warning btn-xs">
                                          <i class="fas fa-user-tie prem"></i>
                                        </button>
                                      @endif

                                      @if($row->Top_car > 250000)
                                        @if ($row->ManagerApp_car != Null)
                                          <button type="button" class="btn btn-success btn-xs">
                                            <i class="fas fa-user-lock prem"></i>
                                          </button>
                                        @else
                                          <button type="button" class="btn btn-warning btn-xs">
                                            <i class="fas fa-user-lock prem"></i>
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

                                      {{-- แก้ไข / ดูรายการ --}}
                                      @if(auth::user()->type == "Admin")
                                        <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                          <i class="far fa-edit"></i>
                                        </a>
                                      @elseif(auth::user()->position == "MANAGER" or auth::user()->position == "AUDIT" or auth::user()->position == "MASTER" or auth::user()->position == "STAFF")
                                        @if($row->StatusApp_car == 'อนุมัติ')
                                          <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status]) }}" class="btn btn-success btn-sm" title="ดูรายการ">
                                            <i class="fas fa-eye"></i>
                                          </a>
                                        @else
                                          <a href="{{ action('AnalysController@edit',[$type,$row->id,$newfdate,$newtdate,$branch,$status]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                            <i class="far fa-edit"></i>
                                          </a>
                                        @endif
                                      @endif

                                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์") 
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
                                @endif
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
    </div>

    <a id="button"></a>
  </section>

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
      $("#table1,#table2").DataTable({
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
