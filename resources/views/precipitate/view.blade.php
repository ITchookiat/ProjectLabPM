@extends('layouts.master')
@section('title','แผนกเร่งรัดหนี้สิน')
@section('content')

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
                    ระบบปล่อยงาน
                  @elseif($type == 2)
                    รายงานแยกทีมติดตาม
                  @elseif($type == 3)
                    ระบบแจ้งเตือนติดตาม
                  @endif
                </h4>
              </div>
              <div class="card-body text-sm">

                @if($type == 1) {{-- ระบบ ปล่อยงานตาม --}}
                  <form method="get" action="{{ route('Precipitate', 1) }}">
                    <div class="float-right form-inline">
                      <div class="btn-group">
                        <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                          <span class="fas fa-print"></span> ปริ้นใบงาน
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a target="_blank" class="dropdown-item" href="{{ action('PrecController@ReportPrecDue',[00,00]) }}?Fromdate={{$newfdate}}&Todate={{$newtdate}}&type={{1}}"> ใบงานตาม</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a target="_blank" class="dropdown-item" href="{{ action('PrecController@ReportPrecDue',[00,00]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{7}}"> ใบงานโนติส</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a target="_blank" class="dropdown-item" href="{{ action('PrecController@ReportPrecDue',[00,00]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{9}}"> ใบงานเร่งรัด</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a target="_blank" class="dropdown-item" href="{{ action('PrecController@ReportPrecDue',[00,00]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{10}}"> ใบงานเตรียมฟ้อง</a></li>
                        </ul>
                      </div>
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
                @elseif($type == 2) {{-- รายงาน แยกตามทีม --}}
                  <form method="get" action="{{ route('Precipitate', 2) }}">
                    <div class="float-right form-inline">
                      <a target="_blank" class="btn bg-success btn-app">
                        <i class="far fa-file-excel"></i> Excel
                      </a>
                      <a target="_blank" class="btn bg-danger btn-app">
                        <i class="far fa-file-pdf"></i> PDF
                      </a>
                      <button type="submit" class="btn bg-warning btn-app">
                        <span class="fas fa-search"></span> Search
                      </button>
                    </div>
                    <br><br><br><p></p>
                    <div class="float-right form-inline">
                      <label for="text" class="mr-sm-2">ทีมติดตาม : </label>
                      <select name="follower" class="form-control" id="text" style="width: 195px">
                        <option value="" {{ ($follower == '') ? 'selected' : '' }}>-- เลือกทั้งหมด --</otion>
                        <option value="008" {{ ($follower == '008') ? 'selected' : '' }}> 008 - เจ๊ะฟารีด๊ะห์ เจ๊ะกาเดร์</otion>
                        <option value="99" {{ ($follower == '99') ? 'selected' : '' }}> 99 - ติดตามรวม</otion>
                        <option value="102" {{ ($follower == '102') ? 'selected' : '' }}>102 - นายอับดุลเล๊าะ กาซอ</otion>
                        <option value="104" {{ ($follower == '104') ? 'selected' : '' }}>104 - นายอนุวัฒน์ อับดุลรานี</otion>
                        <option value="105" {{ ($follower == '105') ? 'selected' : '' }}>105 - นายธีรวัฒน์ เจ๊ะกา</otion>
                        <option value="112" {{ ($follower == '112') ? 'selected' : '' }}>112 - นายราชัน เจ๊ะกา</otion>
                        <option value="113" {{ ($follower == '113') ? 'selected' : '' }}>113 - นายฟิฏตรี วิชา</otion>
                        <option value="114" {{ ($follower == '114') ? 'selected' : '' }}>114 - นายอานันท์ กาซอ</otion>
                      </select>

                      <label>จากวันที่ : </label>
                      <input type="date" name="Fromdate" style="width: 180px;" value="{{ ($fdate != '') ?$fdate: '' }}" class="form-control" />
                      <label>ถึงวันที่ : </label>
                      <input type="date" name="Todate" style="width: 180px;" value="{{ ($tdate != '') ?$tdate: '' }}" class="form-control" />
                    </div>
                  </form>
                  <br><br>
                @elseif($type == 3) {{-- ระบบ แจ้งเตือนติดตาม --}}
                  <form method="get" action="{{ route('Precipitate', 3) }}">
                    <div class="float-right form-inline">
                      <a class="btn bg-success btn-app" href="{{ action('PrecController@excel') }}?Fromstart={{$fstart}}&Toend={{$tend}}&Fromdate={{$fdate}}&Todate={{$tdate}}&type={{3}}">
                        <i class="far fa-file-excel"></i> Excel
                      </a>
                      <button type="submit" class="btn bg-warning btn-app">
                        <span class="fas fa-search"></span> Search
                      </button>
                    </div>
                    <br><br><br><p></p>
                    <div class="float-right form-inline">
                      <label>จากงวดที่ : </label>
                      <input type="text" name="Fromstart" style="width: 165px;" value="{{ ($fstart != '') ?$fstart: '' }}" class="form-control" />
                      <label>ถึงงวดที่ : </label>
                      <input type="text" name="Toend" style="width: 165px;" value="{{ ($tend != '') ?$tend: '' }}" class="form-control" />
                    </div>
                    <br><br>
                    <div class="float-right form-inline">
                      <label>จากวันที่ : </label>
                      <input type="date" name="Fromdate" style="width: 165px;" value="{{ ($fdate != '') ?$fdate: '' }}" class="form-control" />
                      <label>&nbsp;&nbsp;ถึงวันที่ : </label>
                      <input type="date" name="Todate" style="width: 165px;" value="{{ ($tdate != '') ?$tdate: '' }}" class="form-control" />
                    </div>
                  </form>
                @endif

                @if($type == 1)
                  <div class="card card-warning card-tabs">
                    <div class="card-header p-0 pt-1">
                      <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="custom-tabs-1" data-toggle="pill" href="#tabs-1" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">ปล่อยงานตาม</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-2" data-toggle="pill" href="#tabs-2" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">ปล่อยงานโนติส</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-3" data-toggle="pill" href="#tabs-3" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">ปล่อยงานเร่งรัด</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-4" data-toggle="pill" href="#tabs-4" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true">ปล่อยงานเตรียมฟ้อง</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade active show" id="tabs-1" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                          <div class="table-responsive">
                            <table class="table table-bordered" id="table">
                              <thead class="thead-dark bg-gray-light" >
                                <tr>
                                  <th class="text-center">ลำดับ</th>
                                  <th class="text-center">เลขที่สัญญา</th>
                                  <th class="text-center">ชื่อ-สกุล</th>
                                  <th class="text-center">ชำระล่าสุด</th>
                                  <th class="text-center">งวดจริง</th>
                                  <th class="text-center">คงเหลือ</th>
                                  <th class="text-center">พนง.</th>
                                  <th class="text-center">สถานะ</th>
                                  <th class="text-center">ตัวเลือก</th>
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
                                      $LPAYD = date_create($row->LPAYD);
                                      @endphp
                                      {{ date_format($LPAYD, 'd-m-Y')}}
                                    </td>
                                    <td class="text-center"> {{$row->HLDNO}} </td>
                                    <td class="text-center"> {{number_format($row->BALANC - $row->SMPAY, 2 )}} </td>
                                    <td class="text-center"> {{$row->BILLCOLL}} </td>
                                    <td class="text-center"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->CONTSTAT)) }} </td>
                                    <td class="text-center">
                                      @php
                                        $StrCon = explode("/",$row->CONTNO);
                                        $SetStr1 = $StrCon[0];
                                        $SetStr2 = $StrCon[1];
                                      @endphp
                                      <a target="_blank" href="{{ action('PrecController@ReportPrecDue',[$SetStr1,$SetStr2]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{2}}" class="btn btn-sm bg-green" title="พิมพ์">
                                        <i class="far fa-address-card"></i> ใบแจ้งหนี้
                                      </a>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                          <div class="table-responsive">
                            <table class="table table-bordered" id="table1">
                              <thead class="thead-dark bg-gray-light" >
                                <tr>
                                  <th class="text-center">ลำดับ</th>
                                  <th class="text-center">เลขที่สัญญา</th>
                                  <th class="text-center">ชื่อ-สกุล</th>
                                  <th class="text-center">ชำระล่าสุด</th>
                                  <th class="text-center">งวดจริง</th>
                                  <th class="text-center">คงเหลือ</th>
                                  <th class="text-center">พนง.</th>
                                  <th class="text-center">สถานะ</th>
                                  <th class="text-center">ตัวเลือก</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($dataNotice as $key => $row)
                                  <tr>
                                    <td class="text-center"> {{$key+1}} </td>
                                    <td class="text-center"> {{$row->CONTNO}}</td>
                                    <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                                    <td class="text-center">
                                      @php
                                      $LPAYD = date_create($row->LPAYD);
                                      @endphp
                                      {{ date_format($LPAYD, 'd-m-Y')}}
                                    </td>
                                    <td class="text-center"> {{$row->HLDNO}} </td>
                                    <td class="text-center"> {{number_format($row->BALANC - $row->SMPAY, 2 )}} </td>
                                    <td class="text-center"> {{$row->BILLCOLL}} </td>
                                    <td class="text-center"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->CONTSTAT)) }} </td>
                                    <td class="text-center">
                                        @php
                                            $StrCon = explode("/",$row->CONTNO);
                                            $SetStr1 = $StrCon[0];
                                            $SetStr2 = $StrCon[1];
                                        @endphp
                                        <a target="_blank" href="{{ action('PrecController@ReportPrecDue',[$SetStr1,$SetStr2]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{4}}" class="btn btn-sm bg-green" title="พิมพ์">
                                          <i class="far fa-address-card"></i> ใบแจ้งหนี้
                                        </a>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-3" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                          <div class="table-responsive">
                            <table class="table table-bordered" id="table2">
                              <thead class="thead-dark bg-gray-light" >
                                <tr>
                                  <th class="text-center">ลำดับ</th>
                                  <th class="text-center">เลขที่สัญญา</th>
                                  <th class="text-center">ชื่อ-สกุล</th>
                                  <th class="text-center">ชำระล่าสุด</th>
                                  <th class="text-center">งวดจริง</th>
                                  <th class="text-center">คงเหลือ</th>
                                  <th class="text-center">พนง.</th>
                                  <th class="text-center">สถานะ</th>
                                  <th class="text-center">ตัวเลือก</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($dataPrec as $key => $row)
                                  <tr>
                                    <td class="text-center"> {{$key+1}} </td>
                                    <td class="text-center"> {{$row->CONTNO}}</td>
                                    <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                                    <td class="text-center">
                                      @php
                                      $LPAYD = date_create($row->LPAYD);
                                      @endphp
                                      {{ date_format($LPAYD, 'd-m-Y')}}
                                    </td>
                                    <td class="text-center"> {{$row->HLDNO}} </td>
                                    <td class="text-center"> {{number_format($row->BALANC - $row->SMPAY, 2 )}} </td>
                                    <td class="text-center"> {{$row->BILLCOLL}} </td>
                                    <td class="text-center"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->CONTSTAT)) }} </td>
                                    <td class="text-center">
                                        @php
                                            $StrCon = explode("/",$row->CONTNO);
                                            $SetStr1 = $StrCon[0];
                                            $SetStr2 = $StrCon[1];
                                        @endphp
                                        <a target="_blank" href="{{ action('PrecController@ReportPrecDue',[$SetStr1,$SetStr2]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{11}}" class="btn btn-sm bg-green" title="พิมพ์">
                                          <i class="far fa-address-card"></i> ใบแจ้งหนี้
                                        </a>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-4" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                          <div class="table-responsive">
                            <table class="table table-bordered" id="table2">
                              <thead class="thead-dark bg-gray-light" >
                                <tr>
                                  <th class="text-center">ลำดับ</th>
                                  <th class="text-center">เลขที่สัญญา</th>
                                  <th class="text-center">ชื่อ-สกุล</th>
                                  <th class="text-center">ชำระล่าสุด</th>
                                  <th class="text-center">งวดจริง</th>
                                  <th class="text-center">คงเหลือ</th>
                                  <th class="text-center">พนง.</th>
                                  <th class="text-center">สถานะ</th>
                                  <th class="text-center">ตัวเลือก</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($dataLegis as $key => $row)
                                  <tr>
                                    <td class="text-center"> {{$key+1}} </td>
                                    <td class="text-center"> {{$row->CONTNO}}</td>
                                    <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                                    <td class="text-center">
                                      @php
                                      $LPAYD = date_create($row->LPAYD);
                                      @endphp
                                      {{ date_format($LPAYD, 'd-m-Y')}}
                                    </td>
                                    <td class="text-center"> {{$row->HLDNO}} </td>
                                    <td class="text-center"> {{number_format($row->BALANC - $row->SMPAY, 2 )}} </td>
                                    <td class="text-center"> {{$row->BILLCOLL}} </td>
                                    <td class="text-center"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->CONTSTAT)) }} </td>
                                    <td class="text-center">
                                        @php
                                            $StrCon = explode("/",$row->CONTNO);
                                            $SetStr1 = $StrCon[0];
                                            $SetStr2 = $StrCon[1];
                                        @endphp
                                        <a target="_blank" href="{{ action('PrecController@ReportPrecDue',[$SetStr1,$SetStr2]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{12}}" class="btn btn-sm bg-green" title="พิมพ์">
                                          <i class="far fa-address-card"></i> ใบแจ้งหนี้
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
                  </div>
                @endif
                @if($type == 2 or $type == 3)
                  <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                      <thead class="thead-dark bg-gray-light" >
                        <tr>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center">เลขที่สัญญา</th>
                          <th class="text-center">ชื่อ-สกุล</th>
                          @if($type == 3)
                            <th class="text-center">เบอร์โทร</th>
                          @endif
                          <th class="text-center">ชำระล่าสุด</th>
                          <th class="text-center">งวดละ</th>
                          <th class="text-center">งวดจริง</th>
                          <th class="text-center">คงเหลือ</th>
                          <th class="text-center">พนง</th>
                          <th class="text-center">สถานะ</th>
                          @if($type == 1)
                            <th class="text-center">ตัวเลือก</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data as $key => $row)
                          <tr>
                            <td class="text-center"> {{$key+1}} </td>
                            <td class="text-center"> {{$row->CONTNO}}</td>
                            <td class="text-left"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->SNAM.$row->NAME1)."   ".str_replace(" ","",$row->NAME2))}} </td>
                            @if($type == 3)
                              <td class="text-left"> {{iconv('Tis-620','utf-8', $row->TELP)}} </td>
                            @endif
                            <td class="text-center">
                              @php
                              $LPAYD = date_create($row->LPAYD);
                              @endphp
                              {{ date_format($LPAYD, 'd-m-Y')}}
                            </td>
                            @if($type == 3)
                              <td class="text-center"> {{number_format($row->T_LUPAY, 2)}} </td>
                            @else
                              <td class="text-center"> {{number_format($row->DAMT, 2)}} </td>
                            @endif
                            <td class="text-center"> {{$row->HLDNO}} </td>
                            <td class="text-center"> {{number_format($row->BALANC - $row->SMPAY, 2 )}} </td>
                            <td class="text-center"> {{$row->BILLCOLL}} </td>
                            <td class="text-center"> {{iconv('Tis-620','utf-8',str_replace(" ","",$row->CONTSTAT)) }} </td>
                              @if($type == 1)
                                <td class="text-center">
                                  @php
                                     $StrCon = explode("/",$row->CONTNO);
                                     $SetStr1 = $StrCon[0];
                                     $SetStr2 = $StrCon[1];
                                  @endphp
                                  @if($type == 1)
                                    <a target="_blank" href="{{ action('PrecController@ReportPrecDue',[$SetStr1,$SetStr2]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{2}}" class="btn btn-sm bg-blue" title="พิมพ์">
                                      <span class="fa fa-id-card-o"></span> ใบแจ้งหนี้
                                    </a>
                                  @elseif($type == 4)
                                    <a target="_blank" href="{{ action('PrecController@ReportPrecDue',[$SetStr1,$SetStr2]) }}?Fromdate={{$fdate}}&Todate={{$tdate}}&type={{4}}" class="btn btn-sm bg-blue" title="พิมพ์">
                                      <span class="fa fa-id-card-o"></span> ใบแจ้งหนี้
                                    </a>
                                  @endif
                                </td>
                              @endif
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
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

  @if($type == 1)
    <script type="text/javascript">
      $(document).ready(function() {
        $('#table,#table1,#table2,#table3').DataTable( {
          "order": [[ 1, "asc" ]]
        } );
      } );
    </script>
  @elseif($type == 2 OR $type == 3)
    <script type="text/javascript">
      $(document).ready(function() {
        $('#table').DataTable( {
          "order": [[ 0, "asc" ]],
          "pageLength": 50
        } );
      } );
    </script>
  @endif

  <script type="text/javascript">
    $(".alert").fadeTo(3000, 1000).slideUp(1000, function(){
    $(".alert").alert('close');
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
