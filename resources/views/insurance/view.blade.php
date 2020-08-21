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

  @php
    date_default_timezone_set('Asia/Bangkok');
    $Y = date('Y') + 543;
    $m = date('m');
    $d = date('d');
    $time = date('H:i');
    $date2 = $Y.'-'.$m.'-'.$d;
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
                <div class="row">
                  <div class="col-8">
                    <div class="form-inline">
                      <h4>
                        @if($type == 1)
                        สต็อกรถใช้งานบริษัท (Company car stock)
                        @endif
                      </h4>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card-tools d-inline float-right">
                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                        <a class="btn bg-success btn-sm" data-toggle="modal" data-target="#modal-newcar" data-backdrop="static" data-keyboard="false" style="border-radius: 40px;">
                          <span class="fas fa-plus"></span> เพิ่มใหม่
                        </a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body text-sm">
                <div class="col-md-12">
                  <form method="get" action="{{ route('Insure',1) }}">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="float-right form-inline">
                          <label>จากวันที่ : </label>
                          <input type="date" name="Fromdate" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />

                          <label>ถึงวันที่ : </label>
                          <input type="date" name="Todate" value="{{ ($newtdate != '') ?$newtdate: date('Y-m-d') }}" class="form-control" />

                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                  <hr>
                @if($type == 1)
                  <div class="table-responsive">
                    <table class="table table-striped table-valign-middle table-bordered" id="table1">
                      <thead>
                        <tr>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center">แจ้งเตือน</th>
                          <th class="text-center">วันที่คีย์</th>
                          <th class="text-center">ป้ายทะเบียน</th>
                          <th class="text-center">ยี่ห้อรถ</th>
                          <th class="text-center">รุ่นรถ</th>
                          <th class="text-center">เลขตัวถัง</th>
                          <th class="text-center">หมายเหตุ</th>
                          <th class="text-center">ตัวเลือก</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data as $key => $row)
                        <tr>
                          <td class="text-center" style="vertical-align: text-top;">{{$key+1}}</td>
                          <td class="text-center" style="vertical-align: text-top;">
                            <div class="form-inline">
                              <!-- แจ้งเตือนทะเบียน -->
                              @if($row->Register_expire != null)
                                  @php
                                      date_default_timezone_set('Asia/Bangkok');
                                      $ifdate = date('Y-m-d');
                                  @endphp
                                  @if($ifdate < $row->Register_expire)
                                    @php
                                      $Cldate = date_create($row->Register_expire);
                                      $nowCldate = date_create($ifdate);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    @if($duration <= 30)
                                      <p><span class="btn btn-warning btn-xs"><label class="prem" style="font-size:12px;">ทะเบียน ({{$duration}})</label></span></p>
                                    @endif
                                  @else
                                  &nbsp;<p><span class="btn btn-danger btn-xs"><label class="prem" style="font-size:12px;">ทะเบียนหมดอายุ</label></span></p>
                                  @endif
                              @endif
                              <!-- แจ้งเตือนประกัน -->
                              @if($row->Insure_expire != null)
                                  @php
                                      date_default_timezone_set('Asia/Bangkok');
                                      $ifdate = date('Y-m-d');
                                  @endphp
                                  @if($ifdate < $row->Insure_expire)
                                    @php
                                      $Cldate = date_create($row->Insure_expire);
                                      $nowCldate = date_create($ifdate);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    @if($duration <= 30)
                                      &nbsp;<p><span class="btn btn-warning btn-xs"><label class="prem" style="font-size:12px;">ประกัน ({{$duration}})</label></span></p>
                                    @endif
                                  @else
                                  &nbsp;<p><span class="btn btn-danger btn-xs"><label class="prem" style="font-size:12px;">ประกันหมดอายุ</label></span></p>
                                  @endif
                              @endif
                              <!-- แจ้งเตือน พรบ -->
                              @if($row->Act_expire != null)
                                  @php
                                      date_default_timezone_set('Asia/Bangkok');
                                      $ifdate = date('Y-m-d');
                                  @endphp
                                  @if($ifdate < $row->Act_expire)
                                    @php
                                      $Cldate = date_create($row->Act_expire);
                                      $nowCldate = date_create($ifdate);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    @if($duration <= 30)
                                    &nbsp;<p><span class="btn btn-warning btn-xs"><label class="prem" style="font-size:12px;">พรบ. ({{$duration}})</label></span></p>
                                    @endif
                                  @else
                                  &nbsp;<p><span class="btn btn-danger btn-xs"><label class="prem" style="font-size:12px;">พรบ.หมดอายุ</label></span></p>
                                  @endif
                              @endif
                              <!-- แจ้งเตือนเช็คระยะ -->
                              @if($row->Check_car != null)
                                  @php
                                      date_default_timezone_set('Asia/Bangkok');
                                      $ifdate = date('Y-m-d');
                                  @endphp
                                  @if($ifdate < $row->Check_car)
                                    @php
                                      $Cldate = date_create($row->Check_car);
                                      $nowCldate = date_create($ifdate);
                                      $ClDateDiff = date_diff($Cldate,$nowCldate);
                                      $duration = $ClDateDiff->format("%a วัน")
                                    @endphp
                                    @if($duration <= 30)
                                    &nbsp;<p><span class="btn btn-warning btn-xs"><label class="prem" style="font-size:12px;">เช็คระยะ ({{$duration}})</label></span></p>
                                    @endif
                                  @else
                                  &nbsp;<p><span class="btn btn-danger btn-xs"><label class="prem" style="font-size:12px;">เช็คระยะหมดอายุ</label></span></p>
                                  @endif
                              @endif
                            </div>
                          </td>
                          <td class="text-center" style="vertical-align: text-top;">{{DateThai($row->Date_useradd)}}</td>
                          <td class="text-center" style="vertical-align: text-top;">{{$row->Number_register}}</td>
                          <td class="text-center" style="vertical-align: text-top;">{{$row->Brand_car}}</td>
                          <td class="text-center" style="vertical-align: text-top;">{{$row->Version_car}}</td>
                          <td class="text-center" style="vertical-align: text-top;">{{$row->Engno_car}}</td>
                          <td class="text-left" style="vertical-align: text-top;"> {{$row->Note_car}}</td>
                          <td class="text-center" style="vertical-align: text-top;">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-view" title="ดูรายการ"
                              data-backdrop="static" data-keyboard="false"
                              data-link="{{ route('MasterInsure.edit',[$row->Insure_id]) }}?type={{1}}">
                              <i class="far fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit" title="แก้ไขรายการ"
                              data-backdrop="static" data-keyboard="false"
                              data-link="{{ route('MasterInsure.edit',[$row->Insure_id]) }}?type={{2}}">
                              <i class="far fa-edit"></i>
                            </button>
                            <form method="post" class="delete_form" action="{{ route('MasterInsure.destroy',[$row->Insure_id]) }}" style="display:inline;">
                              {{csrf_field()}}
                              <input type="hidden" name="_method" value="DELETE" />
                              <button type="submit" data-name="{{ $row->Number_register }}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                <i class="far fa-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
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
        "ordering": false,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "order": [[ 1, "asc" ]],
      });
    });
  </script>

<script>
  $(function () {
    $("#modal-view").on("show.bs.modal", function (e) {
      var link = $(e.relatedTarget).data("link");
      $("#modal-view .modal-content").load(link, function(){
      });
    });

    $("#modal-edit").on("show.bs.modal", function (e) {
      var link = $(e.relatedTarget).data("link");
      $("#modal-edit .modal-content").load(link, function(){
      });
    });

  });
</script>

  <!-- Add new car modal -->
  <form name="form2" action="{{ route('MasterInsure.store',[$row->Insure_id]) }}" method="post" enctype="multipart/form-data">
    @csrf
      <input type="hidden" name="type" value="1"/>
      <div class="modal fade" id="modal-newcar" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 30px 30px 30px 30px;">
              <div class="modal-header bg-success" style="border-radius: 30px 30px 0px 0px;">
                <div class="col text-center">
                  <h5 class="modal-title"><i class="fas fa-plus"></i> เพิ่มรายการใหม่</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">x</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                        <label class="col-sm-5 col-form-label text-right"><font color="red">*** ป้ายทะเบียน :</font> </label>
                        <div class="col-sm-7">
                          <input type="text" name="Registercar" class="form-control" placeholder="ป้อนป้ายทะเบียน" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ยี่ห้อรถ : </label>
                        <div class="col-sm-7">
                          <select name="Brandcar" class="form-control">
                            <option value="" selected>--- ยี่ห้อ ---</option>
                            <option value="MAZDA">MAZDA</option>
                            <option value="FORD">FORD</option>
                            <option value="ISUZU">ISUZU</option>
                            <option value="MITSUBISHI">MITSUBISHI</option>
                            <option value="TOYOTA">TOYOTA</option>
                            <option value="NISSAN">NISSAN</option>
                            <option value="HONDA">HONDA</option>
                            <option value="CHEVROLET">CHEVROLET</option>
                            <option value="MG">MG</option>
                            <!-- <!-- <option value="SUZUKI">SUZUKI</option> -->
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right">รุ่นรถ : </label>
                        <div class="col-sm-7">
                          <input type="text" name="Versioncar" class="form-control" placeholder="ป้อนรุ่นรถ" />
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ประเภทรถ : </label>
                        <div class="col-sm-7">
                          <select id="Typecar" name="Typecar" class="form-control">
                            <option value="" selected>--- ประเภทรถ ---</option>
                            <option value="รถกระบะ">รถกระบะ</option>
                            <option value="รถตอนเดียว">รถตอนเดียว</option>
                            <option value="รถเก๋ง/7ที่นั่ง">รถเก๋ง/7ที่นั่ง</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right">เลขตัวถัง :</label>
                        <div class="col-sm-7">
                          <input type="text" name="Engnocar" class="form-control" placeholder="ป้อนเลขตัวถัง"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ปีรถ : </label>
                        <div class="col-sm-7">
                          <select id="Yearcar" name="Yearcar" class="form-control">
                            <option value="" selected>--- เลือกปี ---</option>
                              @php
                                  $Year = date('Y');
                              @endphp
                              @for ($i = 0; $i < 15; $i++)
                                <option value="{{ $Year }}">{{ $Year }}</option>
                                @php
                                    $Year -= 1;
                                @endphp
                              @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right">วันหมดอายุทะเบียน :</label>
                        <div class="col-sm-7">
                          <input type="date" name="RegisterExpire" class="form-control"/>
                        </div>
                      </div>
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right">วันหมดอายุประกัน :</label>
                        <div class="col-sm-7">
                          <input type="date" name="InsureExpire" class="form-control"/>
                        </div>
                      </div>
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right">วันหมดอายุ พรบ. :</label>
                        <div class="col-sm-7">
                          <input type="date" name="ActExpire" class="form-control"/>
                        </div>
                      </div>
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right">วันที่เช็คระยะ :</label>
                        <div class="col-sm-7">
                          <input type="date" name="Checkcar" class="form-control"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                    <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">หมายเหตุ :</label>
                        <div class="col-sm-7">
                          <textarea class="form-control" name="Notecar" rows="6" placeholder="ป้อนหมายเหตุ..."></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
              <hr>
              </div>

              <input type="hidden" name="NameUser" value="{{auth::user()->name}}" class="form-control" placeholder="ป้อนชื่อ"/>
              <div style="text-align: center;">
                  <button type="submit" class="btn btn-success text-center" style="border-radius: 50px;">บันทึก</button>
                  <button type="button" class="btn btn-danger" style="border-radius: 50px;" data-dismiss="modal">ยกเลิก</button>
              </div>
              <br>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
  </form>

  <!-- Pop up ดูรายละเอียด -->
  <div class="modal fade" id="modal-view">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border-radius: 30px 30px 30px 30px;">
        
      </div>
    </div>
  </div>

  <!-- Pop up แก้ไข -->
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border-radius: 30px 30px 30px 30px;">
        
      </div>
    </div>
  </div>


@endsection
