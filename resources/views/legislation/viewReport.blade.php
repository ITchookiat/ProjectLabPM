@php
  date_default_timezone_set('Asia/Bangkok');
  $Y = date('Y') + 543;
  $Y2 = date('Y') + 531;
  $m = date('m');
  $d = date('d');
  //$date = date('Y-m-d');
  $time = date('H:i');
  $date = $Y.'-'.$m.'-'.$d;
  $date2 = $Y2.'-'.'01'.'-'.'01';
@endphp

<style>
  input[type="checkbox"] { position: absolute; opacity: 0; z-index: -1; }
  input[type="checkbox"]+span { font: 12pt sans-serif; color: #000; }
  input[type="checkbox"]+span:before { font: 12pt FontAwesome; content: '\00f096'; display: inline-block; width: 12pt; padding: 2px 0 0 3px; margin-right: 0.5em; }
  input[type="checkbox"]:checked+span:before { content: '\00f046'; }
  input[type="checkbox"]:focus+span:before { outline: 1px dotted #aaa; }
</style>

<style>
  [type="radio"]:checked,
  [type="radio"]:not(:checked) {
      position: absolute;
      left: -9999px;
  }
  [type="radio"]:checked + label,
  [type="radio"]:not(:checked) + label
  {
      position: relative;
      padding-left: 22px;
      cursor: pointer;
      line-height: 20px;
      display: inline-block;
      color: #666;
  }
  [type="radio"]:checked + label:before,
  [type="radio"]:not(:checked) + label:before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 20px;
      height: 20px;
      border: 1px solid #ddd;
      border-radius: 100%;
      background: #fff;
  }
  [type="radio"]:checked + label:after,
  [type="radio"]:not(:checked) + label:after {
      content: '';
      width: 12px;
      height: 12px;
      background: #F87DA9;
      position: absolute;
      top: 4px;
      left: 4px;
      border-radius: 100%;
      -webkit-transition: all 0.2s ease;
      transition: all 0.2s ease;
  }
  [type="radio"]:not(:checked) + label:after {
      opacity: 0;
      -webkit-transform: scale(0);
      transform: scale(0);
  }
  [type="radio"]:checked + label:after {
      opacity: 1;
      -webkit-transform: scale(1);
      transform: scale(1);
  }
</style>


<section class="content">
  <div class="card card-warning">
    <div class="card-header">
      <h4 class="card-title">
        @if($type == 9)
          ใบเสร็จชำระค่างวด
        @elseif($type == 15)
          รายงานบันทึกชำะค่างวด
        @elseif($type == 16)
          รายงานลูกหนี้ประนอมหนี้
        @elseif($type == 17)
          รายงานลูกหนี้
        @elseif($type == 18)
          รายงานลูกหนี้สืบพยาน
        @elseif($type == 19)
          รายงานลูกหนี้สืบทรัพย์
        @elseif($type == 20)
        รายงานตรวจสอบยอดชำระ
        @endif
      </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="card-body">
      @if($type == 9)
        <form name="form1" action="{{ route('legislation.report' ,[00, 1]) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
          @csrf
          
          <div class="row">
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label><font color="red">เลขที่สัญญา :</font></label>
                <input type="text" name="Contract" class="form-control" style="width: 170px;" data-inputmask="&quot;mask&quot;:&quot;99-9999/9999&quot;" data-mask="" required/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="float-right form-inline">
                <label>เลขที่ใบเสร็จ :</label>
                <input type="text" name="NumberBill" class="form-control" style="width: 170px;"/>
              </div>
            </div>
          </div>
          <p></p>

          <div class="row">
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>จากวันที่ : </label>
                <input type="date" name="Fdate" class="form-control" style="width: 170px;"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="float-right form-inline">
                <label>ถึงวันที่ : </label>
                <input type="date" name="Tdate" class="form-control" style="width: 170px;"/>
              </div>
            </div>
          </div>

          <p></p>
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
              <div class="form-inline">
                <button type="submit" class="btn bg-primary btn-app">
                  <i class="fas fa-print"></i> ปริ้น
                </button>
                <a class="btn btn-app bg-danger" href="{{ route('legislation',7) }}">
                  <i class="fas fa-times"></i> ยกเลิก
                </a>
              </div>
            </div>
          </div>

          <input type="hidden" name="_token" value="{{csrf_token()}}" />
        </form>
      @elseif($type == 15)
        <form name="form1" action="{{ route('legislation.report' ,[00, 15]) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
          @csrf
          
          <div class="row">
            <div class="col-md-6">
                <p class="text-center font-weight-bold"><font color="red">เลขที่สัญญา :</font></p>
                <input type="text" name="Contract" class="form-control text-center" style="padding:5px; width:200px; border-radius: 5px 0 5px 5px; font-size:24px;" data-inputmask="&quot;mask&quot;:&quot;99-9999/9999&quot;" data-mask="" required/>
            </div>
            <div class="col-md-6">
              <br>
              <button type="submit" class="btn bg-primary btn-app">
                <i class="fas fa-print"></i> ปริ้น
              </button>
              <a class="btn btn-app bg-danger" href="{{ route('legislation',7) }}">
                <i class="fas fa-times"></i> ยกเลิก
              </a>
            </div>
          </div>

          <input type="hidden" name="_token" value="{{csrf_token()}}" />
        </form>
      @elseif($type == 16)
        <form name="form1" action="{{ route('legislation.report' ,[00, 16]) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>จากวันที่ : </label>
                <input type="date" name="Fromdate" class="form-control" style="width: 200px;"/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="float-right form-inline">
                <label>ถึงวันที่ : </label>
                <input type="date" name="Todate" class="form-control" style="width: 200px;"/>
              </div>
            </div>
          </div>

          <p></p>
          <div class="row">
            <div class="col-md-2">
              <div class="" align="center">
                <label>&nbsp;&nbsp;&nbsp;&nbsp;สถานะ : </label>
              </div>
            </div>
            <div class="col-md-10">
              <div class="col-md-4">
                <label>
                  <input type="checkbox" id="test3" name="status" value="ชำระปกติ"/>
                  <span>ชำระปกติ</span>
                </label>
              </div>
              <div class="col-md-4">
                <label>
                  <input type="checkbox" id="test4" name="status" value="ขาดชำระ"/>
                  <span>ขาดชำระเกิน 3 งวด</span>
                </label>
              </div>
              <div class="col-md-4">
                <label>
                  <input type="checkbox" id="test5" name="status" value="ปิดบัญชี"/>
                  <span>ปิดบัญชี</span>
                </label>
              </div>
            </div>
          </div>

          <p></p>
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-8">
              <div class="form-inline">
                <button type="submit" class="btn bg-danger btn-app">
                  <span class="fa fa-file-pdf-o"></span> PDF
                </button>
                <a class="btn btn-app bg-danger" href="{{ route('legislation',7) }}">
                  <i class="fas fa-times"></i> ยกเลิก
                </a>
              </div>
            </div>
          </div>


        </form>
      @elseif($type == 17)
        <form name="form1" action="{{ route('legislation.report' ,[00, 17]) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>จากวันที่ : </label>
                <input type="date" name="Fromdate" class="form-control" value="{{ date('Y-m-d') }}" style="width: 180px;"/>
              </div>
            </div>
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>ถึงวันที่ : </label>
                <input type="date" name="Todate" class="form-control" value="{{ date('Y-m-d') }}" style="width: 180px;"/>
              </div>
            </div>
          </div>
          <br>

          <div class="row">
            <div class="col-md-3">
              <div class="" align="right">
                <label>สถานะ : </label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="" align="left">
                <label>
                  <input type="checkbox" id="test1" name="status" value="ลูกหนี้ฟ้อง"/>
                  <span>ลูกหนี้ฟ้อง</span>
                </label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="" align="left">
                <label>
                  <input type="checkbox" id="test2" name="status" value="ลูกหนี้ยังไม่ฟ้อง"/>
                  <span>ลูกหนี้ยังไม่ฟ้อง</span>
                </label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="" align="right">
              </div>
            </div>
            <div class="col-md-4">
              <div class="" align="left">
                <label>
                  <input type="checkbox" id="test3" name="status" value="ลูกหนี้ปิดจบงาน"/>
                  <span>ลูกหนี้ปิดจบงาน</span>
                </label>
              </div>
            </div>
          </div>

          <p></p>
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
              <div class="form-inline">
                <button type="submit" class="btn bg-success btn-app">
                  <i class="far fa-file-excel"></i> Excel
                </button>
                <a class="btn btn-app bg-danger" href="{{ route('legislation',2) }}">
                  <i class="fas fa-times"></i> ยกเลิก
                </a>
              </div>
            </div>
          </div>

        </form>
      @elseif($type == 18)
        <form name="form1" action="{{ route('legislation.report' ,[00, 18]) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>จากวันที่ : </label>
                <input type="date" name="Fromdate" class="form-control" value="{{ date('Y-m-d') }}" style="width: 180px;" required/>
              </div>
            </div>
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>ถึงวันที่ : </label>
                <input type="date" name="Todate" class="form-control" value="{{ date('Y-m-d') }}" style="width: 180px;" required/>
              </div>
            </div>
          </div>

          <br>
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
              <div class="form-inline">
                <button type="submit" class="btn bg-primary btn-app">
                  <i class="fas fa-print"></i> ปริ้น
                </button>
                <a class="btn btn-app bg-danger" href="{{ route('legislation',2) }}">
                  <i class="fas fa-times"></i> ยกเลิก
                </a>
              </div>
            </div>
          </div>
        </form>
      @elseif($type == 19)
        <form name="form1" action="{{ route('legislation.report' ,[00, 19]) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>จากวันที่ : </label>
                <input type="date" name="Fromdate" class="form-control" style="width: 180px;"/>
              </div>
            </div>
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>ถึงวันที่ : </label>
                <input type="date" name="Todate" class="form-control" style="width: 180px;"/>
              </div>
            </div>
          </div>
          <br>

          <div class="row">
            <div class="col-md-3">
              <div class="" align="right">
                <label>สถานะ : </label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="" align="left">
                <label>
                  <input type="checkbox" id="test1" name="status" value="Y"/>
                  <span>ลูกหนี้มีทรัพย์</span>
                </label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="" align="left">
                <label>
                  <input type="checkbox" id="test2" name="status" value="N"/>
                  <span>ลูกหนี้ไม่มีทรัพย์</span>
                </label>
              </div>
            </div>
          </div>

          <br>
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
              <div class="form-inline">
                <button type="submit" class="btn bg-primary btn-app">
                  <i class="fas fa-print"></i> ปริ้น
                </button>
                <a class="btn btn-app bg-danger" href="{{ route('legislation',8) }}">
                  <i class="fas fa-times"></i> ยกเลิก
                </a>
              </div>
            </div>
          </div>
        </form>
      @elseif($type == 20) {{--รายงานตรวจสอบยอดชำระ--}}
        <form name="form1" action="{{ route('legislation.report' ,[00, 20]) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="float-right form-inline">
                <label>จากวันที่ : </label>
                <input type="date" name="Fromdate" class="form-control" style="width: 200px;"/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="float-right form-inline">
                <label>ถึงวันที่ : </label>
                <input type="date" name="Todate" class="form-control" style="width: 200px;"/>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <div class="form-inline">
                <label>ผู้รับชำระ : </label>
                <select name="CashReceiver" class="form-control" style="width: 100%;">
                  <option value="" selected>--- เลือกผู้รับชำระ ---</option>
                  @foreach ($dataDB as $key => $value)
                  <option value="{{$value->name}}">{{$value->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
              <div class="form-inline">
                <button type="submit" class="btn bg-primary btn-app">
                  <i class="fas fa-print"></i> ปริ้น
                </button>
                <a class="btn btn-app bg-danger" href="{{ route('legislation',7) }}">
                  <i class="fas fa-times"></i> ยกเลิก
                </a>
              </div>
            </div>
          </div>
        </form>
      @endif
    </div>
  </div>
</section>

<script>
  $(function () {
      $('[data-mask]').inputmask()
  })
</script>
