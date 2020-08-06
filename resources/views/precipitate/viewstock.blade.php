@extends('layouts.master')
@section('title','แผนกกฏหมาย')
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
                  @if($type == 5)
                    ระบบสต็อกรถเร่งรัด
                  @elseif($type == 11)
                    ระบบปรับโครงสร้างหนี้
                  @endif
                </h4>
              </div>
              <div class="card-body text-sm">
                @if($type == 5)
                  <form method="get" action="{{ route('Precipitate', 5) }}">
                    <div class="float-right form-inline">
                      <a href="{{ route('Precipitate', 6) }}" class="btn bg-success btn-app">
                        <span class="fas fa-plus"></span> เพิ่มข้อมูล
                      </a>
                      <div class="btn-group">
                        <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                          <span class="fas fa-print"></span> ปริ้นรายงาน
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a target="_blank" class="dropdown-item" href="{{ action('PrecController@ReportPrecDue',[00,00]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{5}}&Statuscar={{$Statuscar}}"> PDF</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a target="_blank" class="dropdown-item" href="{{ action('PrecController@excel') }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{5}}&Statuscar={{$Statuscar}}"> Excel</a></li>
                        </ul>
                      </div>
                      <button type="submit" class="btn bg-warning btn-app">
                        <span class="fas fa-search"></span> Search
                      </button>
                    </div>
                    <br><br><br><p></p>
                    <div class="float-right form-inline">
                      <label for="text" class="mr-sm-2">สถานะ : </label>
                      <select name="Statuscar" class="form-control mb-2 mr-sm-2" id="text" style="width: 180px">
                        <option selected value="">---เลือกสถานะ---</option>
                        <option value="1" {{ ($Statuscar == '1') ? 'selected' : '' }}> ยึดจากลูกค้าครั้งแรก</otion>
                        <option value="2" {{ ($Statuscar == '2') ? 'selected' : '' }}> ลูกค้ามารับรถคืน</otion>
                        <option value="3" {{ ($Statuscar == '3') ? 'selected' : '' }}> ยึดจากลูกค้าครั้งที่ 2</otion>
                        <option value="4" {{ ($Statuscar == '4') ? 'selected' : '' }}> รับรถจากของกลาง</otion>
                        <option value="5" {{ ($Statuscar == '5') ? 'selected' : '' }}> ส่งรถบ้าน</otion>
                        <option value="6" {{ ($Statuscar == '6') ? 'selected' : '' }}> ลูกค้าส่งรถคืน</otion>
                        <option value="7" {{ ($Statuscar == '7') ? 'selected' : '' }}> รถยึดที่ถือครอง</otion>
                      </select>
                      <label>จากวันที่ : </label>
                      <input type="date" name="Fromdate" style="width: 180px;" value="{{ ($fdate != '') ?$fdate: '' }}" class="form-control" />
                      <label>ถึงวันที่ : </label>
                      <input type="date" name="Todate" style="width: 180px;" value="{{ ($tdate != '') ?$tdate: '' }}" class="form-control" />
                    </div>
                  </form>

                  <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                      <thead class="thead-dark bg-gray-light" >
                        <tr>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center" width="70px">วันที่ยึด</th>
                          <th class="text-center" width="70px">ระยะเวลา</th>
                          <th class="text-center">เลขที่สัญญา</th>
                          <th class="text-center">ชื่อ-สกุล</th>
                          <!-- <th class="text-center">ยี่ห้อ</th> -->
                          <th class="text-center" width="70px">ทะเบียน</th>
                          <!-- <th class="text-center">ปีรถ</th> -->
                          <th class="text-center">ทีมยึด</th>
                          <th class="text-center">ค่ายึด</th>
                          <!-- <th class="text-center" width="120px">รายละเอียด</th> -->
                          <th class="text-center" width="120px">สถานะ</th>
                          <th class="text-center">ตัวเลือก</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data as $key => $row)
                          <tr>
                            <td class="text-center"> {{ $key+1 }} </td>
                            <td class="text-center"> {{ DateThai($row->Date_hold) }} </td>
                            <td class="text-center">
                              @if($row->Statuscar == 1 or $row->Statuscar == 3 or $row->Statuscar == 7)
                                @php
                                  $nowday = date('Y-m-d');
                                  $Cldate = date_create($row->Date_hold);
                                  $nowCldate = date_create($nowday);
                                  $ClDateDiff = date_diff($Cldate,$nowCldate);
                                  $duration = $ClDateDiff->format("%a วัน")
                                @endphp
                                <font color="red">{{$duration}}</font>
                              @else
                                @if($row->Datesend_Stockhome != null)
                                  @php
                                    $Cldate = date_create($row->Date_hold);
                                    $nowCldate = date_create($row->Datesend_Stockhome);
                                    $ClDateDiff = date_diff($Cldate,$nowCldate);
                                    $duration = $ClDateDiff->format("%a วัน")
                                  @endphp
                                  <font color="green" title="วันที่ส่งรถบ้าน {{DateThai($row->Datesend_Stockhome)}}">{{$duration}}</font>
                                @elseif($row->Date_came != null)
                                  @php
                                    $Cldate = date_create($row->Date_hold);
                                    $nowCldate = date_create($row->Date_came);
                                    $ClDateDiff = date_diff($Cldate,$nowCldate);
                                    $duration = $ClDateDiff->format("%a วัน")
                                  @endphp
                                  <font color="blue" title="วันที่มารับคืน {{DateThai($row->Date_came)}}">{{$duration}}</font>
                                @else
                                  @php
                                    $Cldate = date_create($row->Date_hold);
                                    $nowCldate = date_create($row->Dateupdate_hold);
                                    $ClDateDiff = date_diff($Cldate,$nowCldate);
                                    $duration = $ClDateDiff->format("%a วัน")
                                  @endphp
                                  <font color="blue">{{$duration}}</font>
                                @endif
                              @endif
                            </td>
                            <td class="text-center"> {{ $row->Contno_hold }} </td>
                            <td class="text-left"> {{ $row->Name_hold }} </td>
                            <td class="text-center"> {{ $row->Number_Regist }} </td>
                            <td class="text-center"> {{ $row->Team_hold }} </td>
                            <td class="text-right">
                              @if($row->Price_hold == Null)
                                {{ $row->Price_hold }}
                              @else
                                {{ number_format($row->Price_hold, 2) }}
                              @endif
                            </td>
                            <td class="text-center">
                              @if($row->Statuscar == 1)
                                ยึดจากลูกค้าครั้งแรก
                              @elseif($row->Statuscar == 2)
                                <font color="#FF33C1">ลูกค้ามารับรถคืน</font>
                              @elseif($row->Statuscar == 3)
                                <font color="#FF8B00">ยึดจากลูกค้าครั้งที่ 2</font>
                              @elseif($row->Statuscar == 4)
                                <font color="#001BFF">รับรถจากของกลาง</font>
                              @elseif($row->Statuscar == 5)
                                <font color="#046817">ส่งรถบ้าน</font>
                              @elseif($row->Statuscar == 6)
                                <font color="#068998">ลูกค้าส่งรถคืน</font>
                              @endif
                            </td>
                            <td class="text-center">
                              <a href="{{ action('PrecController@edit',[$row->Hold_id,$type]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                <i class="far fa-edit"></i> แก้ไข
                              </a>
                              <form method="post" class="delete_form" action="{{ action('PrecController@destroy',[$row->Hold_id,$type]) }}" style="display:inline;">
                              {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE" />
                                <button type="submit" data-name="{{ $row->Contno_hold }}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                  <i class="far fa-trash-alt"></i> ลบ
                                </button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                  </div>

                @elseif($type == 11)
                  <form method="get" action="{{ route('Precipitate', 11) }}">
                    <div align="right" class="form-inline">
                      <a href="{{ route('Precipitate', 12) }}" class="btn btn-primary btn-app">
                        <span class="fa fa-plus"></span> เพิ่มข้อมูล
                      </a>
                      <!-- <a target="_blank" href="{{ action('PrecController@excel') }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{5}}" class="btn btn-success btn-app">
                        <span class="fa fa-file-excel-o"></span> Excel
                      </a>
                      <a target="_blank" href="{{ action('PrecController@ReportPrecDue',[00,00]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{5}}&Statuscar={{$Statuscar}}" class="btn btn-danger btn-app">
                        <span class="fa fa-file-pdf-o"></span> PDF
                      </a> -->
                      <button type="submit" class="btn btn-warning btn-app">
                        <span class="glyphicon glyphicon-search"></span> Search
                      </button >
                      <p></p>
                      <label>จากวันที่ : </label>
                      <input type="date" name="Fromdate" style="width: 150px;" value="{{ ($fdate != '') ?$fdate: '' }}" class="form-control" />
                      <label>ถึงวันที่ : </label>
                      <input type="date" name="Todate" style="width: 150px;" value="{{ ($tdate != '') ?$tdate: '' }}" class="form-control" />
                    </div>
                  </form>
                @endif

                <a id="button"></a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
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
      $("#table").DataTable({
        "responsive": true,
        "autoWidth": false,
        "ordering": true,
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
