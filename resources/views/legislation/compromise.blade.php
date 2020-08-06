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
                  @if ($data->Flag == "C")
                    ลูกหนี้ประนอมหนี้ (ประนอมเก่า)
                  @else
                    ลูกหนี้ประนอมหนี้
                  @endif
                </h4>                  
                <div class="card card-warning card-tabs">
                  <div class="card-header p-0 pt-1">
                    <div class="container-fluid">
                      <div class="row mb-2">
                        @if ($data->Flag == "C")
                          <div class="col-sm-6">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link" href="{{ route('legislation',7) }}">หน้าหลัก</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link active" href="{{ action('LegislationController@edit',[$id, 4]) }}">ประนอมหนี้</a>
                              </li>
                            </ul>
                          </div>
                        @else
                          <div class="col-sm-6">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link" href="{{ action('LegislationController@edit',[$id, 2]) }}">ข้อมูลผู้เช่าซื้อ</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="{{ action('LegislationController@edit',[$id, 3]) }}">ชั้นศาล</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="{{ action('LegislationController@edit',[$id, 7]) }}">ชั้นบังคับคดี</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="{{ action('LegislationController@edit',[$id, 13]) }}">โกงเจ้าหนี้</a>
                              </li>
                            </ul>
                          </div>
                          <div class="col-sm-6">
                            <div class="float-right form-inline">
                              <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <a class="nav-link" href="{{ action('LegislationController@edit',[$id, 8]) }}">สืบทรัพย์</a>
                                <a class="nav-link active" href="{{ action('LegislationController@edit',[$id, 4]) }}">ประนอมหนี้</a>
                                <a class="nav-link" href="{{ action('LegislationController@edit',[$id, 11]) }}">รูปและแผนที่</a>
                              </ul>
                            </div>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>          
                </div>
              </div>
              <div class="card-body text-sm">
                <form name="form1" method="post" action="{{ action('LegislationController@update',[$id,$type]) }}" enctype="multipart/form-data">
                  @csrf
                  @method('put')

                  <div class="row">
                    <div class="col-md-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-id-badge fa-2x"></i></span>
          
                        <div class="info-box-content">
                          <div class="form-inline">
                            <div class="col-md-3">
                              <span class="info-box-number"><font style="font-size: 30px;">{{ $data->Contract_legis }}</font></span>
                              <span class="info-box-text"><font style="font-size: 20px;">{{ $data->Name_legis }}</font></span>
                            </div>

                            <div class="col-md-5">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <small class="badge badge-danger" style="font-size: 25px;">
                                <i class="fas fa-child"></i>&nbsp; สถานะ :
                                @if($data->Status_Promise != Null)
                                  {{$data->Status_Promise}}
                                @endif
                              </small>
                              <div class="form-inline">
                                <label>สถานะ : </label>
                                <select name="" class="form-control" style="width: 170px;">
                                  <option value="" selected>--------- status ----------</option>
                                  <option value="ปิดบัญชีประนอมหนี้" {{ ($data->Status_Promise === 'ปิดบัญชีประนอมหนี้') ? 'selected' : '' }}>ปิดบัญชีประนอมหนี้</option>
                                  <option value="จ่ายจบประนอมหนี้" {{ ($data->Status_Promise === 'จ่ายจบประนอมหนี้') ? 'selected' : '' }}>จ่ายจบประนอมหนี้</option>
                                </select>
                                <input type="date" name="" class="form-control" style="width: 170px;" value="" disabled>
                              </div>
                            </div>
                            
                            <div class="col-md-4">
                              <div class="float-right form-inline">
                                @if($dataPranom != 0)
                                  <button type="button"class="btn btn-app" style="background-color:blue; color:#FFFFFF;" 
                                    data-toggle="modal" data-target="#modal-default" data-link="{{ action('LegislationController@edit',[$id, 5]) }}">
                                    <i class="fas fa-plus"></i> เพิ่มชำระ
                                  </button>
                                @else
                                  <a class="btn btn-app" style="background-color:#CCCCCC; color:#FFFFFF;">
                                    <i class="fas fa-plus"></i> เพิ่มชำระ
                                  </a>
                                @endif
                                <button type="submit" class="btn btn-app" style="background-color:#189100; color:#FFFFFF;">
                                  <i class="fas fa-save"></i> Save
                                </button>
                                <a class="btn btn-app" href="{{ route('legislation',7) }}" style="background-color:#DB0000; color:#FFFFFF;">
                                  <i class="fas fa-times"></i> ยกเลิก
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

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
                    function Comma(){
                      var num11 = document.getElementById('TotalPromise').value;
                      var num1 = num11.replace(",","");
                      var num22 = document.getElementById('PayallPromise').value;
                      var num2 = num22.replace(",","");
                      var num66 = document.getElementById('SumPromise').value;
                      var num6 = num66.replace(",","");
                      var num88 = document.getElementById('SumAllPromise').value;
                      var num8 = num88.replace(",","");

                      document.form1.TotalPromise.value = addCommas(num1);
                      document.form1.PayallPromise.value = addCommas(num2);
                      document.form1.SumPromise.value = addCommas(num6);
                      document.form1.SumAllPromise.value = addCommas(num8);
                    }
                    function Discount() {
                        var txtSum = document.getElementById('SumPromise').value;
                        var txtDis = document.getElementById('DiscountPromise').value;
                        var txtComma = txtDis.replace(",","");
                        var txtSumhide = document.getElementById('Sumhide').value;
                        var txtDishide = document.getElementById('Discounthide').value;

                        // if (txtSetPay1 != 0 || txtSetPay2 != 0 || txtSetPay3 != 0) {
                        //   var result = parseFloat(txtSumhide) - parseFloat(txtSetPay1) - parseFloat(txtSetPay2) - parseFloat(txtSetPay3);
                        //   console.log(result);

                        if (txtDis != txtDishide) {
                          var SetDiscount = parseFloat(txtDis) - parseFloat(txtDishide);
                          // var result = parseFloat(result) - parseFloat(SetDiscount);
                          var result = parseFloat(txtSumhide) - parseFloat(SetDiscount);
                        }else if (txtDis == 0) {
                          console.log(txtDis);
                          var result = parseFloat(txtSumhide);
                        }

                        if (!isNaN(result)) {
                          document.form1.SumPromise.value = addCommas(result);
                        }
                    }
                    function DuePay() {
                        var SumPayAll = document.getElementById('SumPayAll').value;
                        var txtSumPayAll = SumPayAll.replace(",","");
                        var txtDuepay = document.getElementById('DuePayPromise').value;
                        var txtSetDue = txtDuepay.replace(",","");

                        var Sum = (parseFloat(txtSumPayAll) / parseFloat(txtSetDue));
                        var result = Math.floor(Sum);

                        if (txtSetDue == 0) {
                          console.log(txtSetDue);
                          var result = 0;
                        }

                        if (!isNaN(result)) {
                          document.form1.DuePromise.value = result;
                          document.form1.DuePayPromise.value = numberWithCommas(txtSetDue);
                        }
                    }
                    function numberWithCommas(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                  </script>

                  <h5 class="" align="left"><b>รายละเอียดประนอมหนี้</b></h5>
                  <div class="row">
                    <div class="col-12">
                      <div class="card card-danger card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-1" data-toggle="pill" href="#tabs-1" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false"><i class="fas fa-toggle-on"></i> ข้อมูลประนอมหนี้</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-2" data-toggle="pill" href="#tabs-2" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><i class="fas fa-toggle-on"></i> ตารางผ่อนชำระ</a>
                            </li>
                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="tabs-1" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                              <div class="row">
                                <div class="col-md-8">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="float-right form-inline">
                                        <label>ยอดประนอมหนี้ : </label>
                                        <input type="text" name="TotalPromise" id="TotalPromise" value="{{ number_format($data->Total_Promise,0) }}" class="form-control" style="width: 200px;" oninput="Comma();" required/>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="float-right form-inline">
                                        <script>
                                          function income(){
                                            console.log(document.getElementById("TypePromise").value);
                                              var Getid = document.getElementById("TypePromise").value;
                                              if (Getid == "ประนอมหลังยึดทรัพย์") {
                                                $('#DateShow').show();
                                              }else {
                                                $('#DateShow').hide();
                                              }
                                          }
                                        </script>

                                        <label>ประเภทประนอมหนี้ :</label>
                                        <select id="TypePromise" name="TypePromise" class="form-control" style="width: 200px;" onchange="income();" required>
                                          <option value="" selected>--- เลือกประนอม ---</option>
                                          <option value="ประนอมที่ศาล" {{ ($data->Type_Promise === 'ประนอมที่ศาล') ? 'selected' : '' }}>ประนอมที่ศาล</option>
                                          <option value="ประนอมที่บริษัท" {{ ($data->Type_Promise === 'ประนอมที่บริษัท') ? 'selected' : '' }}>ประนอมที่บริษัท</option>
                                          <option value="ประนอมหลังยึดทรัพย์" {{ ($data->Type_Promise === 'ประนอมหลังยึดทรัพย์') ? 'selected' : '' }}>ประนอมหลังยึดทรัพย์</option>
                                          <option value="ประนอมโกงเจ้าหนี้" {{ ($data->Type_Promise === 'ประนอมโกงเจ้าหนี้') ? 'selected' : '' }}>ประนอมโกงเจ้าหนี้</option>
                                        </select>
                                      </div>
                                    </div>
                                    <br><br><br>

                                    @if($data->Type_Promise != "ประนอมหลังยึดทรัพย์")
                                      <div id="DateShow" style="display:none">
                                    @else
                                      <div id="DateShow">
                                    @endif
                                      <div class="col-md-6">
                                        <div class="float-right form-inline">
                                          <label>วันงดขายเข้าตลาด :</label>
                                          <input type="date" name="DateNsalePromise" value="{{ $data->DateNsale_Promise }}" class="form-control" style="width: 200px;"/>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="float-right form-inline">
                                          <label>วันครบกำหนด :</label>
                                          <input type="date" name="DatesetPromise" value="{{ $data->Dateset_Promise }}" class="form-control" style="width: 200px;"/>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="float-right form-inline">
                                        <label>ยอดที่ต้องชำระ :</label>
                                        <input type="text" name="PayallPromise" id="PayallPromise" value="{{ $data->Payall_Promise }}" class="form-control" style="width: 200px;" oninput="Comma();"/>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="float-right form-inline">
                                        <label>ยอดคงเหลือ : </label>
                                        <input type="text" id="SumPromise" name="SumPromise" value="{{ number_format($SumPay, 0) }}" class="form-control" style="width: 200px;" readonly/>
                                        <input type="hidden" id="Sumhide" name="Sumhide" value="{{ $SumPay }}" class="form-control" style="width: 200px;"/>
                                        <input type="hidden" id="SumPayAll" name="SumPayAll" value="{{ $SumAllPAy }}" class="form-control" style="width: 200px;"/>
                                      </div>
                                    </div>

                                    <div class="col-md-6"></div>

                                    <div class="col-md-6">
                                      <div class="float-right form-inline">
                                        <label>ส่วนลด :</label>
                                        <input type="text" id="DiscountPromise" name="DiscountPromise" value="{{ number_format(($data->Discount_Promise != '') ?$data->Discount_Promise: 0) }}" class="form-control" style="width: 200px;" onkeyup="Discount();" />
                                        <input type="hidden" id="Discounthide" name="Discounthide" value="{{ $data->Discount_Promise }}" class="form-control" style="width: 200px;" />
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="float-right form-inline">
                                        <label>จำนวนงวด :</label>
                                        <input type="text" name="DuePromise" id="DuePromise" value="{{ $data->Due_Promise }}" class="form-control" style="width: 200px;" readonly/>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="float-right form-inline">
                                        <label>งวดละ :</label>
                                        <input type="text" name="DuePayPromise" id="DuePayPromise" value="{{ number_format(($data->DuePay_Promise != '') ?$data->DuePay_Promise: 0) }}" class="form-control" style="width: 200px;" oninput="DuePay();"/>
                                      </div>
                                    </div>

                                    <br><br><br>
                                    <div class="col-md-6">
                                      <div class="float-right form-inline">
                                        <label><font color="red">วันที่ชำระล่าสุด : </font></label>
                                        @if($data->Date_Payment != Null)
                                          <input type="text" name="DatelastPromise" value="{{ DateThai($data->Date_Payment) }}" class="form-control" style="width: 200px;" readonly/>
                                        @else
                                          <input type="text" name="DatelastPromise" class="form-control" style="width: 200px;" readonly/>
                                        @endif
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="float-right form-inline">
                                        <label><font color="red">ยอดชำระล่าสุด : </font></label>
                                        <input type="text" name="SumAllPromise" id="SumAllPromise" value="{{ number_format($data->Gold_Payment, 2) }}" class="form-control" style="width: 200px;" oninput="Comma();" readonly/>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="form-inline" align="right">
                                    <label>หมายเหตุ : </label>
                                    <textarea name="NotePromise" rows="10" class="form-control" style="width: 100%">{{$data->Note_Promise}}</textarea>
                                  </div>
                                </div>
                              </div>
                            </div>

                <input type="hidden" name="_method" value="PATCH"/>
              </form>
                            <div class="tab-pane fade" id="tabs-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                              <div class="table-responsive">
                                <table class="table table-bordered" id="table">
                                    <thead class="thead-dark bg-gray-light" >
                                      <tr>
                                        <th class="text-center" style="width:100px">ลำดับ</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">ยอดชำระ</th>
                                        <th class="text-center">ประเภท</th>
                                        <th class="text-center">เลขที่ใบเสร็จ</th>
                                        <th class="text-center">ลงชื่อ</th>
                                        <th class="text-center" style="width:150px">action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($dataPay as $key => $row)
                                      <tr>
                                        <td class="text-center"> {{$key+1}} </td>
                                        <td class="text-center"> {{ DateThai($row->Date_Payment) }}</td>
                                        <td class="text-center"> {{ number_format($row->Gold_Payment, 2) }} </td>
                                        <td class="text-center"> {{$row->Type_Payment}} </td>
                                        <td class="text-center"> {{$row->Jobnumber_Payment}} </td>
                                        <td class="text-center"> {{$row->Adduser_Payment}} </td>
                                        <td class="text-center">
                                          <a target="_blank" href="{{ route('legislation.report' ,[$row->Payment_id, 2]) }}" class="btn btn-warning btn-sm" title="ปริ้นใบเสร็จ">
                                            <i class="fas fa-print"></i> ปริ้น
                                          </a>
                                          <form method="post" class="delete_form" action="{{ action('LegislationController@destroy',[$row->Payment_id, 2]) }}" style="display:inline;">
                                          {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button type="submit" data-name="{{ $row->Jobnumber_Payment }}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                              <i class="far fa-trash-alt"></i> ลบ
                                            </button>
                                          </form>
                                        </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                </table>

                                <div class="form-inline" align="center">
                                  <label><font color="red">ค่างวดทั้งหมด : </font></label>
                                  <input type="text" value="{{ number_format($Getdata, 2) }}" class="form-control" style="width: 100px;" readonly/>

                                  <label><font color="red">ยอดชำระ : </font></label>
                                  <input type="text" value="{{ number_format($SumCount, 2) }}" class="form-control" style="width: 100px;" readonly/>

                                  <label><font color="red">ส่วนลด : </font></label>
                                  <input type="text" value="{{ number_format($data->Discount_Promise, 2) }}" class="form-control" style="width: 100px;" readonly/>

                                  <label><font color="red">ยอดคงเหลือ : </font></label>
                                  <input type="text" value="{{ number_format($Getdata - ($SumCount + $data->Discount_Promise), 2) }}" class="form-control" style="width: 100px;" readonly/>
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
          </div>
        </div>
      </section>
    </div>
  </section>


  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-default">
        <div class="modal-body">
          <p>One fine body…</p>
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  {{-- Popup --}}
  <script>
    $(function () {
      $("#modal-default").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-default .modal-body").load(link, function(){
        });
      });
    });
  </script>
  
  <script type="text/javascript">
    $(document).ready(function() {
      $('#table').DataTable( {
        "searching" : false,
        "lengthChange" : false,
        "info" : false,
        "pageLength": 5,
      } );
    } );
  </script>

@endsection
