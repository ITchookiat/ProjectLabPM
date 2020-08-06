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
                <h4 class="">
                  @if($type == 1)
                    ลูกค้า walk-in (Customer walk-in)
                  @elseif($type == 2)
                    รายงาน walk-in (Report Customer walk-in)
                  @endif
                </h4>
              </div>
              <div class="card-body text-sm">
                <div class="col-md-12">
                  <form method="get" action="{{ route('DataCustomer',1) }}">
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
                @if($type == 1)
                  <div class="table-responsive">
                    <table class="table table-striped table-valign-middle" id="table1">
                      <thead>
                        <tr>
                          <th class="text-center" style="width:10px;"></th>
                          <th class="text-center">ลำดับ</th>
                          <th class="text-center">วันที่ walkin</th>
                          <th class="text-center">ป้ายทะเบียน</th>
                          <th class="text-center">ยอดจัด</th>
                          <th class="text-center">ชื่อลูกค้า</th>
                          <th class="text-center">เบอร์ติดต่อ</th>
                          <th class="text-center">เลขบัตร ปชช</th>
                          <th class="text-center">ตัวเลือก</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data as $key => $row)
                          <tr>
                            <td class="text-center">
                              <form method="post" class="delete_form" action="{{ action('DataCustomerController@destroy',[$row->Customer_id]) }}" style="display:inline;">
                              {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE" />
                                <button type="submit" data-name="" class="delete-modal btn-danger btn-xs AlertForm" title="ลบรายการ">
                                  <i class="far fa-trash-alt"></i>
                                </button>
                              </form>
                            </td>
                            <td class="text-center">{{$key+1}}</td>
                            <td class="text-center">{{DateThai(substr($row->created_at,0,10))}}</td>
                            <td class="text-center">{{$row->License_car}}</td>
                            <td class="text-center">{{number_format($row->Top_car,2)}}</td>
                            <td class="text-center">{{$row->Name_buyer}}</td>
                            <td class="text-center">{{$row->Phone_buyer}}</td>
                            <td class="text-center">{{$row->IDCard_buyer}}</td>
                            <td class="text-center">
                              @if($row->Status_leasing == 1) 
                                <a href="{{ route('DataCustomer.savestatus', [2, $row->Customer_id]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i> จัดสินเชื่อ
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

  <!-- pop up เพิ่มไฟล์อัพโหลด -->
  {{-- <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content" style="border-radius:50px;">
            <div class="modal-header bg-success" style="border-radius:30px 30px 0px 0px;">
              <div class="col text-center">
                <h4 class="modal-title">อัพโหลดไฟล์</h4>
              </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <br />
            @if(count($errors) > 0)
              <div class="alert alert-danger">
              Upload Validation Error<br><br>
              <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
              </div>
            @endif

            <div class="modal-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-3 col-form-label text-right">ชื่อไฟล์ : </label>
                      <div class="col-sm-8">
                        <input type="text" name="title" class="form-control" placeholder="ป้อนชื่อไฟล์"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-3 col-form-label text-right">รายละเอียด : </label>
                      <div class="col-sm-8">
                        <input type="text" name="description" class="form-control" placeholder="ป้อนรายละเอียด (ถ้ามี)"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-3 col-form-label text-right"> เลือกไฟล์ :</label>
                      <div class="col-sm-8">
                        <!-- <input type="file" name="file" required/> -->
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">เลือกไฟล์ที่ต้องการ</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br/>
                <input type="hidden" name="uploader" value="{{auth::user()->name}}"/>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn btn-success" style="border-radius:50px;">อัพโหลด</button>
                <button type="button" class="btn btn-danger" style="border-radius:50px;" data-dismiss="modal">ยกเลิก</button>
            </div>
            <br>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  </form> --}}

  <div class="modal fade" id="modal-preview">
    <div class="modal-dialog modal-xl">
      <div class="modal-content bg-default">
        <div class="modal-body">
          <p>One fine body…</p>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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

  <script>
    $(function () {
      $("#modal-preview").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-preview .modal-body").load(link, function(){
        });
      });
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
    function blinker() {
      $('.prem').fadeOut(1500);
      $('.prem').fadeIn(1500);
    }
    setInterval(blinker, 1500);
  </script>

<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>

<script type="text/javascript">
	$(document).ready(function(e) {
	increaseNotify();
    setInterval(increaseNotify, 3000);
  });
  function increaseNotify(){ // โหลดตัวเลขทั้งหมดที่ถูกส่งมาแสดง
    $.ajax({
      url: "increase.php",
      type: 'GET',
      success: function(obj) {
        var obj = JSON.parse(obj);
        $(".badge_number").text(obj.badge_number);
      }
    });
  }
  function decreaseNotify(){ // ลบตัวเลข badge number
    $.ajax({
      url: "decrease.php",
      type: 'GET',
      success: function(obj) {
        
      }
    });
  }
</script>

@endsection
