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
                  <div class="col-6">
                    <div class="form-inline">
                      <h5>
                        @if($type == 1)
                          ลูกค้า walk-in (Customer walk-in)
                        @elseif($type == 2)
                          รายงาน walk-in (Report Customer walk-in)
                        @endif
                      </h5>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="card-tools d-inline float-right">
                      <a class="btn bg-warning btn-sm" data-toggle="modal" data-target="#modal-walkin" data-backdrop="static" data-keyboard="false" style="border-radius: 20px;">
                        <span class="fas fa-users"></span> Add New
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body text-sm">
                <div class="col-md-12">
                  <form method="get" action="{{ route('DataCustomer',1) }}">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="float-right form-inline">
                          <div class="btn-group">
                            <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                              <span class="fas fa-print"></span> Print
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a target="_blank" class="dropdown-item" href="{{ route('MasterDataCustomer.show',[0]) }}?Fromdate={{$newfdate}}&Todate={{$newtdate}}&Status={{$status}}&Type={{1}}&Typelab={{$typeLab}}"> 
                                  <i class="fas fa-file-pdf text-red"></i> Print PDF
                                </a>
                              </li>
                              <li class="dropdown-divider"></li>
                              <li>
                                <a target="_blank" class="dropdown-item" href="{{ route('MasterDataCustomer.show',[0]) }}?Fromdate={{$newfdate}}&Todate={{$newtdate}}&Status={{$status}}&Type={{2}}&Typelab={{$typeLab}}"> 
                                  <i class="fas fa-file-excel text-green"></i> Print Excel
                                </a>
                              </li>
                            </ul>
                          </div>
                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="float-right form-inline">
                          <label>จากวันที่ : </label>
                          <input type="date" name="Fromdate" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />

                          <label>ถึงวันที่ : </label>
                          <input type="date" name="Todate" value="{{ ($newtdate != '') ?$newtdate: date('Y-m-d') }}" class="form-control" />
                       
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="float-right form-inline">

                          <label>ประเภทเงินกู้ : </label>
                          <select name="Typelab" class="form-control">
                            <option selected value="">--- เลือกประเภท ----</option>
                            <option value="PLoan"{{ ($typeLab == 'PLoan') ? 'selected' : '' }}>PLoan</otion>
                            <option value="Micro"{{ ($typeLab == 'Micro') ? 'selected' : '' }}>Micro</otion>
                          </select>

                          <label>สถานะ : </label>
                          <select name="Status" class="form-control">
                            <option selected value="">----- เลือกสถานะ ----</option>
                            <option value="ลูกค้าสอบถาม"{{ ($status == '1') ? 'selected' : '' }}>ลูกค้าสอบถาม</otion>
                            <option value="ลูกค้าจัดสินเชื่อ"{{ ($status == '2') ? 'selected' : '' }}>ลูกค้าจัดสินเชื่อ</otion>
                          </select>

                        </div>
                      </div>
                    </div>
                  </form>
                  <hr>
                  @if($type == 1)
                    <div class="table-responsive">
                      <table class="table table-striped table-valign-middle" id="table1">
                        <thead>
                          <tr>
                            <th class="text-center" style="width:10px;"></th>
                            <th class="text-center">ลำดับ</th>
                            <th class="text-center">วันที่</th>
                            <th class="text-left">ป้ายทะเบียน</th>
                            <th class="text-center">ยอดจัด</th>
                            <th class="text-left">ชื่อลูกค้า</th>
                            <th class="text-left">เบอร์ติดต่อ</th>
                            <th class="text-left">เลขบัตร ปชช</th>
                            <th class="text-center">ประเภทเงินกู้</th>
                            <th class="text-center">เข้าสาขา</th>
                            <th class="text-center">ตัวเลือก</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $key => $row)
                            <tr>
                              <td class="text-center">
                                @if($row->Status_leasing == 1 or auth::user()->type == "Admin")
                                  <form method="post" class="delete_form" action="{{ route('MasterDataCustomer.destroy',[$row->Customer_id]) }}" style="display:inline;">
                                  {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" data-name="" class="delete-modal btn-danger btn-xs AlertForm" title="ลบรายการ">
                                      <i class="far fa-trash-alt"></i>
                                    </button>
                                  </form>
                                @endif
                              </td>
                              <td class="text-center">{{$key+1}}</td>
                              <td class="text-center">{{DateThai(substr($row->created_at,0,10))}}</td>
                              <td class="text-left">{{$row->License_car}}</td>
                              <td class="text-right">{{number_format($row->Top_car,2)}}</td>
                              <td class="text-left">{{($row->Name_buyer != Null) ? $row->Name_buyer : '-'}}   {{$row->Last_buyer}}</td>
                              <td class="text-left">{{($row->Phone_buyer != Null) ? $row->Phone_buyer : '-'}}</td>
                              <td class="text-left">{{($row->IDCard_buyer != Null) ? $row->IDCard_buyer : '-'}}</td>
                              <td class="text-center">{{$row->Type_leasing}}</td>
                              <td class="text-center">{{$row->Branch_car }}</td>
                              <td class="text-center">
                                @if($row->Status_leasing == 1) 
                                  <a href="{{ route('DataCustomer.savestatus', [2, $row->Customer_id]) }}" class="btn btn-warning btn-sm" title="ส่งจัดเงินกู้">
                                    <i class="far fa-edit"></i> จัดเงินกู้
                                  </a>
                                @else
                                  <a href="#" class="btn btn-success btn-sm" title="แก้ไขรายการ">
                                    <i class="fas fa-check"></i> ส่งแล้ว
                                  </a> 
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @elseif($type == 2)
                    wait
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

  <!-- Walkin modal -->
  <form name="form2" action="{{ route('MasterDataCustomer.store') }}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="modal fade" id="modal-walkin" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 20px 20px 20px 20px;">
              <div class="modal-header bg-warning" style="border-radius: 20px 20px 20px 20px;">
                <div class="col text-center">
                  <h6 class="modal-title"><i class="fas fa-users pr-1"></i> ลูกค้า WALK IN</h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">x</span>
                </button>
              </div>
              <div class="modal-body text-sm">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                        <label class="col-sm-4 col-form-label text-right"><font color="red">*** ป้ายทะเบียน :</font> </label>
                        <div class="col-sm-8">
                          <input type="text" name="Licensecar" class="form-control form-control-sm" placeholder="ป้อนป้ายทะเบียน" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ยี่ห้อรถ : </label>
                        <div class="col-sm-7">
                          <select name="Brandcar" class="form-control form-control-sm" required>
                            <option value="" selected style="color:red">--- ยี่ห้อรถยนต์ ------</option>
                            <option value="ISUZU">ISUZU</option>
                            <option value="MITSUBISHI">MITSUBISHI</option>
                            <option value="TOYOTA">TOYOTA</option>
                            <option value="MAZDA">MAZDA</option>
                            <option value="FORD">FORD</option>
                            <option value="NISSAN">NISSAN</option>
                            <option value="HONDA">HONDA</option>
                            <option value="CHEVROLET">CHEVROLET</option>
                            <option value="MG">MG</option>
                            <option value="SUZUKI">SUZUKI</option>
                            <option value="" style="color:red">--- ยี่ห้อรถจักรยานยนต์ ------</option>
                            <option value="HONDA">HONDA</option>
                            <option value="YAMAHA">YAMAHA</option>
                            <option value="KAWASAKI">KAWASAKI</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">รุ่นรถ : </label>
                        <div class="col-sm-8">
                          <input type="text" name="Modelcar" class="form-control form-control-sm" placeholder="ป้อนรุ่นรถ" />
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ประเภทรถ : </label>
                        <div class="col-sm-7">
                          <select id="Typecardetail" name="Typecardetail" class="form-control form-control-sm">
                            <option value="" selected style="color:red">--- ประเภทรถรถยนต์ ---</option>
                            <option value="รถกระบะ">รถกระบะ</option>
                            <option value="รถตอนเดียว">รถตอนเดียว</option>
                            <option value="รถเก๋ง/7ที่นั่ง">รถเก๋ง/7ที่นั่ง</option>
                            <option value="" style="color:red">--- ประเภทรถจักรยานยนต์ ------</option>
                            <option value="เกียร์ธรรมดา">เกียร์ธรรมดา</option>
                            <option value="รถออโตเมติก">รถออโตเมติก</option>
                            <option value="BigBike">BigBike</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right"><font color="red"> ยอดจัด : </font> </label>
                        <div class="col-sm-8">
                          <input type="text" id="topcar" name="Topcar" class="form-control form-control-sm" placeholder="ป้อนยอดจัด" oninput="addcomma();" maxlength="9" />
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ปีรถ : </label>
                        <div class="col-sm-7">
                          <select id="Yearcar" name="Yearcar" class="form-control form-control-sm">
                            <option value="" selected>--- เลือกปี ---</option>
                              @php
                                  $Year = date('Y');
                              @endphp
                              @for ($i = 0; $i < 20; $i++)
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
                      <label class="col-sm-4 col-form-label text-right">ชื่อลูกค้า :</label>
                        <div class="col-sm-4">
                          <input type="text" name="Namebuyer" class="form-control form-control-sm" placeholder="ป้อนชื่อ" required/>
                        </div>
                        <div class="col-sm-4">
                          <input type="text" name="Lastbuyer" class="form-control form-control-sm" placeholder="นามสกุล" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ชื่อนายหน้า :</label>
                        <div class="col-sm-7">
                          <input type="text" name="Nameagent" class="form-control form-control-sm" placeholder="ป้อนชื่อนายหน้า"/>
                        </div>
                        <!-- <div class="col-sm-3">
                          <input type="text" name="Lastagent" class="form-control form-control-sm" placeholder="ป้อนสกุล"/>
                        </div> -->
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">เบอร์ลูกค้า :</label>
                        <div class="col-sm-8">
                          <input type="text" name="Phonebuyer" class="form-control form-control-sm" placeholder="ป้อนเบอร์ลูกค้า"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">เบอร์นายหน้า :</label>
                        <div class="col-sm-7">
                          <input type="text" name="Phoneagent" class="form-control form-control-sm" placeholder="ป้อนเบอร์นายหน้า"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">เลขบัตร ปชช :</label>
                        <div class="col-sm-8">
                          <input type="text" name="IDCardbuyer" class="form-control form-control-sm" placeholder="ป้อนเลขบัตร ปชช" maxlength="13"/>
                        </div>
                        <br><br>
                        <label class="col-sm-4 col-form-label text-right">ประเภทเงินกู้ :</label>
                        <div class="col-sm-8">
                          <select id="TypeLeasing" name="TypeLeasing" class="form-control form-control-sm" required>
                              <option value="" selected>--- เลือกประเภทเงินกู้ ---</option>
                              <option value="P03">P03 - สัญญาเงินกู้รถยนต์</option>
                              <option value="P04">P04 - สัญญาเงินกู้รถจักรยานยนต์</option>
                              <option value="P06">P06 - สัญญาเงินกู้ส่วนบุคคล</option>
                              <option value="P07">P07 - สัญญาเงินกู้พนักงาน</option>
                          </select>
                        </div>
                        <br><br>
                        <label class="col-sm-4 col-form-label text-right">ที่มาของลูกค้า :</label>
                        <div class="col-sm-8">
                        <select id="News" name="News" class="form-control form-control-sm" required>
                            <option value="" selected>--- เลือกแหล่งที่มา ---</option>
                            <option value="นายหน้าแนะนำ">นายหน้าแนะนำ</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Line">Line</option>
                            <option value="ป้ายโฆษณา">ป้ายโฆษณา</option>
                            <option value="วิทยุ">วิทยุ</option>
                            <option value="เพื่อนแนะนำ">เพื่อนแนะนำ</option>
                          </select>
                        </div>
                        <br><br>
                        <label class="col-sm-4 col-form-label text-right">สาขา :</label>
                        <div class="col-sm-8">
                          <select id="branchcar" name="branchcar" class="form-control form-control-sm" required>
                            <option value="" selected>--- เลือกสาขา ---</option>
                            <option value="ปัตตานี" {{ (auth::user()->branch == 50) ? 'selected' : '' }}>ปัตตานี(50)</option>
                            <option value="ยะลา" {{ (auth::user()->branch == 51) ? 'selected' : '' }}>ยะลา(51)</option>
                            <option value="นราธิวาส" {{ (auth::user()->branch == 52) ? 'selected' : '' }}>นราธิวาส(52)</option>
                            <option value="สายบุรี" {{ (auth::user()->branch == 53) ? 'selected' : '' }}>สายบุรี(53)</option>
                            <option value="โกลก" {{ (auth::user()->branch == 54) ? 'selected' : '' }}>โกลก(54)</option>
                            <option value="เบตง" {{ (auth::user()->branch == 55) ? 'selected' : '' }}>เบตง(55)</option>
                            <option value="โคกโพธิ์" {{ (auth::user()->branch == 56) ? 'selected' : '' }}>โคกโพธิ์(56)</option>
                            <option value="ตันหยงมัส" {{ (auth::user()->branch == 57) ? 'selected' : '' }}>ตันหยงมัส(57)</option>
                            <option value="รือเสาะ" {{ (auth::user()->branch == 58) ? 'selected' : '' }}>รือเสาะ(58)</option>
                            <option value="บันนังสตา" {{ (auth::user()->branch == 59) ? 'selected' : '' }}>บันนังสตา(59)</option>
                            <option value="ยะหา" {{ (auth::user()->branch == 60) ? 'selected' : '' }}>ยะหา(60)</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">หมายเหตุ :</label>
                        <div class="col-sm-7">
                          <textarea class="form-control" name="Notecar" rows="7" placeholder="ป้อนหมายเหตุ..."></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>

              <input type="hidden" name="Nameuser" value="{{auth::user()->name}}"/>

              <div style="text-align: center;">
                  <button type="submit" class="btn btn-success text-center" style="border-radius: 10px;">บันทึก</button>
                  <button type="button" class="btn btn-danger" style="border-radius: 10px;" data-dismiss="modal">ยกเลิก</button>
              </div>
              <br>
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
        "ordering": false,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "order": [[ 1, "asc" ]],
      });
    });
  </script>

  <script>
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
      var num11 = document.getElementById('topcar').value;
      var num1 = num11.replace(",","");
      document.form2.topcar.value = addCommas(num1);
    }
  </script>
@endsection
