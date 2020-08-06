@extends('layouts.master')
@section('title','ร้อมูลรถยนต์มือ 2')
@section('content')

  @php
    date_default_timezone_set('Asia/Bangkok');
    $Y = date('Y') + 543;
    $Y2 = date('Y') + 542;
    $m = date('m');
    $d = date('d');
    //$date = date('Y-m-d');
    $time = date('H:i');
    $date = $Y.'-'.$m.'-'.$d;
    $date2 = $Y2.'-'.$m.'-'.$d;
  @endphp

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>

  <section class="content">
    <div class="content-header">
      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>กรุณากรอกข้อมูลอีกครั้ง ({{$error}}) </li>
            @endforeach
          </ul>
        </div>
      @endif

      <section class="content">
        <form name="form1" action="{{ action('PrecController@update',[$id,$type]) }}" method="post" id="formimage" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-4">
                      <div class="form-inline">
                        <h4>
                        @if($type == 6)
                          แก้ไขข้อมูลสต็อกรถเร่งรัด
                        @endif
                        </h4>
                      </div>
                    </div>
                    <div class="col-8">
                      <div class="row">
                        <div class="col-9">
                        </div>
                        <div class="col-3">
                          <div class="card-tools d-inline float-right">
                            <button type="submit" class="delete-modal btn btn-success">
                              <i class="fas fa-save"></i> อัพเดท
                            </button>
                            <a class="delete-modal btn btn-danger" href="{{ route('Precipitate', 5) }}">
                              <i class="far fa-window-close"></i> ยกเลิก
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body text-sm">

                  <div class="row">
                    <div class="col-md-12">
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
      
                        function comma(){
                          var num11 = document.getElementById('Pricehold').value;
                          var num1 = num11.replace(",","");
                          document.form1.Pricehold.value = addCommas(num1);
        
                          var num22 = document.getElementById('Amounthold').value;
                          var num2 = num22.replace(",","");
                          document.form1.Amounthold.value = addCommas(num2);
        
                          var num33 = document.getElementById('Payhold').value;
                          var num3 = num33.replace(",","");
                          document.form1.Payhold.value = addCommas(num3);
        
                          var num44 = document.getElementById('CapitalAccount').value;
                          var num4 = num44.replace(",","");
                          document.form1.CapitalAccount.value = addCommas(num4);
        
                          var num55 = document.getElementById('CapitalTopprice').value;
                          var num5 = num55.replace(",","");
                          document.form1.CapitalTopprice.value = addCommas(num5);
                        }
                      </script>
                        
                        <div class="card card-warning">
                          <div class="card-header">
                            <h3 class="card-title">ข้อมูลทั่วไป</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>เลขที่สัญญา : </label>
                                  <input type="text" name="Contno" class="form-control" style="width: 250px;" value="{{ $data->Contno_hold }}" />
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ชื่อ - สกุล : </label>
                                  <input type="text" name="NameCustomer" class="form-control" style="width: 250px;" value="{{ $data->Name_hold }}" >
                                </div>
                              </div>
                            </div>
          
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ยี่ห้อ : </label>
                                  <select name="Brandcar" class="form-control" style="width: 250px;">
                                    <option value="" disabled selected>--- ยี่ห้อ ---</option>
                                    @foreach ($Brandcarr as $key => $value)
                                      <option value="{{$key}}" {{ ($key == $data->Brandcar_hold) ? 'selected' : '' }}>{{$value}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ทะเบียน : </label>
                                  <input type="text" name="Number_Regist" class="form-control" style="width: 250px;" value="{{ $data->Number_Regist }}" >
                                </div>
                              </div>
                            </div>
          
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ปี : </label>
                                  <select name="Yearcar" class="form-control" style="width: 250px;">
                                    <option value="{{ $data->Year_Product }}" selected>{{ $data->Year_Product }}</option>
                                    <option value="" disabled>--------------------</option>
                                    @php
                                        $Year = date('Y');
                                    @endphp
                                    @for ($i = 0; $i < 30; $i++)
                                        <option value="{{ $Year }}">{{ $Year }}</option>
                                        @php
                                            $Year -= 1;
                                        @endphp
                                    @endfor
                                  </select>
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>วันที่ยึด : </label>
                                  <input type="date" name="Datehold" class="form-control" style="width: 250px;" value="{{ $data->Date_hold }}">
                                </div>
                              </div>
                            </div>
          
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ทีมยึด : </label>
                                  <select name="Teamhold" class="form-control" style="width: 250px">
                                    <option selected disabled value="">---เลือกทีมยึด---</option>
                                    @foreach ($Teamhold as $key => $value)
                                      <option value="{{$key}}" {{ ($key == $data->Team_hold) ? 'selected' : '' }}>{{$value}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ค่ายึด : </label>
                                  @if($data->Price_hold == Null)
                                    <input type="text" id="Pricehold" name="Pricehold" class="form-control" style="width: 250px;" placeholder="ป้อนค่ายึด" oninput="comma();">
                                  @else
                                    <input type="text" id="Pricehold" name="Pricehold" class="form-control" style="width: 250px;" value="{{ number_format($data->Price_hold) }}" oninput="comma();">
                                  @endif
                                </div>
                              </div>
                            </div>
          
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label><font color="red">สถานะรถ : </font></label>
                                  <select name="Statuscar" class="form-control" style="width: 250px">
                                    <option selected value="">---เลือกสถานะ---</option>
                                    @foreach ($Statuscar as $key => $value)
                                      <option value="{{$key}}" {{ ($key == $data->Statuscar) ? 'selected' : '' }}>{{$value}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label style="vertical-align: top;">รายละเอียด : </label>
                                  <textarea name="Note" class="form-control" placeholder="ป้อนรายละเอียด" rows="2" style="width: 250px;">{{ $data->Note_hold }}</textarea>
                                </div>
                              </div>
                            </div>
      
                            <hr>
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>วันที่มารับรถคืน : </label>
                                  <input type="date" name="Datecame" class="form-control" style="width: 250px;" value="{{ $data->Date_came }}" >
                                </div>
                              </div>
                            </div>
          
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ค่างวดยึดค้าง : </label>
                                  @if($data->Amount_hold == Null)
                                    <input type="text" id="Amounthold" name="Amounthold" class="form-control" style="width: 250px;" placeholder="ป้อนค่างวดยึดค้าง" oninput="comma();">
                                  @else
                                    <input type="text" id="Amounthold" name="Amounthold" class="form-control" style="width: 250px;" placeholder="ป้อนค่างวดยึดค้าง" oninput="comma();" value="{{ number_format($data->Amount_hold) }}" >
                                  @endif
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ชำระค่างวดยึด : </label>
                                  @if($data->Pay_hold == Null)
                                    <input type="text" id="Payhold" name="Payhold" class="form-control" style="width: 250px;" placeholder="ป้อนชำระค่างวดยึด" oninput="comma();">
                                  @else
                                    <input type="text" id="Payhold" name="Payhold" class="form-control" style="width: 250px;" placeholder="ป้อนชำระค่างวดยึด" oninput="comma();" value="{{ number_format($data->Pay_hold) }}">
                                  @endif
                                </div>
                              </div>
                            </div>
          
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>วันที่เช็คต้นทุน : </label>
                                  <input type="date" name="DatecheckCapital" class="form-control" style="width: 250px;" value="{{ $data->Datecheck_Capital }}">
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>วันที่ส่งรถบ้าน : </label>
                                  <input type="date" name="DatesendStockhome" class="form-control" style="width: 250px;" value="{{ $data->Datesend_Stockhome }}">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card card-warning">
                          <div class="card-header">
                            <h3 class="card-title">ข้อมูลผู้เช่าซื้อ</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>วันที่ส่งจดหมาย : </label>
                                  <input type="date" name="DatesendLetter" class="form-control" style="width: 250px;" value="{{ $data->Datesend_Letter }}">
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label bel>เลขบาร์โค๊ด : </label>
                                  <input type="text" name="BarcodeNo" class="form-control" style="width: 250px;" placeholder="ป้อนเลขบาร์โค๊ด" value="{{ $data->Barcode_No }}">
                                </div>
                              </div>
                            </div>
        
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ต้นทุนบัญชี : </label>
                                  @if($data->Capital_Account == Null)
                                    <input type="text" id="CapitalAccount" name="CapitalAccount" class="form-control" style="width: 250px;" placeholder="ป้อนต้นทุนบัญชี" oninput="comma();">
                                  @else
                                    <input type="text" id="CapitalAccount" name="CapitalAccount" class="form-control" style="width: 250px;" oninput="comma();" value="{{ number_format($data->Capital_Account,2) }}">
                                  @endif
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ต้นทุนยอดจัด : </label>
                                  @if($data->Capital_Topprice == Null)
                                    <input type="text" id="CapitalTopprice" name="CapitalTopprice" class="form-control" style="width: 250px;" placeholder="ป้อนต้นทุนยอดจัด" oninput="comma();">
                                  @else
                                    <input type="text" id="CapitalTopprice" name="CapitalTopprice" class="form-control" style="width: 250px;" oninput="comma();" value="{{ number_format($data->Capital_Topprice,2) }}">
                                  @endif
                                </div>
                              </div>
                            </div>
        
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label style="vertical-align: top;">หมายเหตุ : </label>
                                  <textarea name="Note2" class="form-control" placeholder="ป้อนหมายเหตุ" rows="2" style="width: 250px;">{{ $data->Note2_hold }}</textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card card-warning">
                          <div class="card-header">
                            <h3 class="card-title">ข้อมูลผู้ค้ำ</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>จดหมาย : </label>
                                  <input type="text" name="Letter" class="form-control" style="width: 250px;" placeholder="ป้อนจดหมาย" value="{{ $data->Letter_hold }}">
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>วันส่ง : </label>
                                  <input type="date" name="Datesend" class="form-control" style="width: 250px;" value="{{ $data->Date_send }}">
                                </div>
                              </div>
                            </div>
          
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>บาร์โค๊ดผู้ค้ำ : </label>
                                  <input type="text" name="Barcode2" class="form-control" style="width: 250px;" placeholder="ป้อนบาร์โค๊ด" value="{{ $data->Barcode2 }}">
                                </div>
                              </div>
                              @if($data->Accept_hold == 'ได้รับ')
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                    <label>วันที่จะขายได้ : </label>
                                    <input type="date" name="sell" class="form-control" style="width: 250px;" value="{{ $data->Date_accept_hold }}" readonly>
                                  </div>
                                </div>
                              @endif
                            </div>
          
                            <div class="row">
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>รับ : </label>
                                  <select name="Accept" class="form-control" style="width: 250px">
                                    <option selected disabled value="">---เลือกสถานะ---</option>
                                    @foreach ($Accept as $key => $value)
                                      <option value="{{$key}}" {{ ($key == $data->Accept_hold) ? 'selected' : '' }}>{{$value}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="float-right form-inline">
                                  <label>ขายได้ : </label>
                                  <input type="text" name="Soldout" class="form-control" style="width: 250px;" placeholder="ป้อนข้อมูล" value="{{ $data->Soldout_hold }}">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
      
                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <input type="hidden" name="type" value="6" />
                        <input type="hidden" readonly name="Cartype" value="{{ $type }}" class="form-control" />
                        <input type="hidden" name="_method" value="PATCH"/>

                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>
  </section>

@endsection
