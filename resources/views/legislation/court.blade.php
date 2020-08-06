@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
@section('content')

  <style>
    input[type="checkbox"] { position: absolute; opacity: 0; z-index: -1; }
    input[type="checkbox"]+span { font: 14pt sans-serif; color: #000; }
    input[type="checkbox"]+span:before { font: 14pt FontAwesome; content: '\00f096'; display: inline-block; width: 14pt; padding: 2px 0 0 3px; margin-right: 0.5em; }
    input[type="checkbox"]:checked+span:before { content: '\00f046'; }
    input[type="checkbox"]:focus+span:before { outline: 1px dotted #aaa; }
  </style>

  <style>
    #todo-list{
    width:100%;
    margin:0 auto 50px auto;
    padding:5px;
    background:white;
    position:relative;
    /*box-shadow*/
    -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
     -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
          box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
    /*border-radius*/
    -webkit-border-radius:5px;
     -moz-border-radius:5px;
          border-radius:5px;
    }
    #todo-list:before{
    content:"";
    position:absolute;
    z-index:-1;
    /*box-shadow*/
    -webkit-box-shadow:0 0 20px rgba(0,0,0,0.4);
     -moz-box-shadow:0 0 20px rgba(0,0,0,0.4);
          box-shadow:0 0 20px rgba(0,0,0,0.4);
    top:50%;
    bottom:0;
    left:10px;
    right:10px;
    /*border-radius*/
    -webkit-border-radius:100px / 10px;
     -moz-border-radius:100px / 10px;
          border-radius:100px / 10px;
    }
    .todo-wrap{
    display:block;
    position:relative;
    padding-left:35px;
    /*box-shadow*/
    -webkit-box-shadow:0 2px 0 -1px #ebebeb;
     -moz-box-shadow:0 2px 0 -1px #ebebeb;
          box-shadow:0 2px 0 -1px #ebebeb;
    }
    .todo-wrap:last-of-type{
    /*box-shadow*/
    -webkit-box-shadow:none;
     -moz-box-shadow:none;
          box-shadow:none;
    }
    input[type="checkbox"]{
    position:absolute;
    height:0;
    width:0;
    opacity:0;
    /* top:-600px; */
    }
    .todo{
    display:inline-block;
    font-weight:200;
    padding:10px 5px;
    height:37px;
    position:relative;
    }
    .todo:before{
    content:'';
    display:block;
    position:absolute;
    top:calc(50% + 2px);
    left:0;
    width:0%;
    height:1px;
    background:#cd4400;
    /*transition*/
    -webkit-transition:.25s ease-in-out;
     -moz-transition:.25s ease-in-out;
       -o-transition:.25s ease-in-out;
          transition:.25s ease-in-out;
    }
    .todo:after{
    content:'';
    display:block;
    position:absolute;
    z-index:0;
    height:18px;
    width:18px;
    top:9px;
    left:-25px;
    /*box-shadow*/
    -webkit-box-shadow:inset 0 0 0 2px #d8d8d8;
     -moz-box-shadow:inset 0 0 0 2px #d8d8d8;
          box-shadow:inset 0 0 0 2px #d8d8d8;
    /*transition*/
    -webkit-transition:.25s ease-in-out;
     -moz-transition:.25s ease-in-out;
       -o-transition:.25s ease-in-out;
          transition:.25s ease-in-out;
    /*border-radius*/
    -webkit-border-radius:4px;
     -moz-border-radius:4px;
          border-radius:4px;
    }
    .todo:hover:after{
    /*box-shadow*/
    -webkit-box-shadow:inset 0 0 0 2px #949494;
     -moz-box-shadow:inset 0 0 0 2px #949494;
          box-shadow:inset 0 0 0 2px #949494;
    }
    .todo .fa-check{
    position:absolute;
    z-index:1;
    left:-31px;
    top:0;
    font-size:1px;
    line-height:36px;
    width:36px;
    height:36px;
    text-align:center;
    color:transparent;
    text-shadow:1px 1px 0 white, -1px -1px 0 white;
    }
    :checked + .todo{
    color:#717171;
    }
    :checked + .todo:before{
    width:100%;
    }
    :checked + .todo:after{
    /*box-shadow*/
    -webkit-box-shadow:inset 0 0 0 2px #0eb0b7;
     -moz-box-shadow:inset 0 0 0 2px #0eb0b7;
          box-shadow:inset 0 0 0 2px #0eb0b7;
    }
    :checked + .todo .fa-check{
    font-size:20px;
    line-height:35px;
    color:#0eb0b7;
    }
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
        padding-left: 28px;
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
                  ลูกหนี้งานฟ้อง
                </h4>                  
                <div class="card card-warning card-tabs">
                  <div class="card-header p-0 pt-1">
                    <div class="container-fluid">
                      <div class="row mb-2">
                        <div class="col-sm-6">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link" href="{{ action('LegislationController@edit',[$id, 2]) }}">ข้อมูลผู้เช่าซื้อ</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link active" href="{{ action('LegislationController@edit',[$id, 3]) }}">ชั้นศาล</a>
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
                              <a class="nav-link" href="{{ action('LegislationController@edit',[$id, 4]) }}">ประนอมหนี้</a>
                              <a class="nav-link" href="{{ action('LegislationController@edit',[$id, 11]) }}">รูปและแผนที่</a>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>          
                </div>
              </div>
              <div class="card-body text-sm">
                <form name="form1" method="post" action="{{ action('LegislationController@update',[$id,$type]) }}" enctype="multipart/form-data">
                  @csrf
                  @method('put')

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
                    function CourtDate(){
                      //---------- วันสืบพยาน
                      var date1 = document.getElementById('examidaycourt').value;
                      var fannydate = document.getElementById('fuzzycourt').value;
                      var orderdaycourt = document.getElementById('orderdaycourt').value;
                      var ordersenddate = document.getElementById('ordersendcourt').value;
    
                      // if (ordersenddate == '') { // แสดงผลลัพธิ์ วันทีดึงจากระบบ
                        console.log(fannydate);
                        if (date1 != '') {
                          var Setdate = new Date(date1);
                          var newdate = new Date(Setdate);
                          if (fannydate != '') {
                            var Setdate = new Date(fannydate);
                            var newdate = new Date(Setdate);
    
                          }
                        }else if (fannydate != '') {
                          var Setdate = new Date(fannydate);
                          var newdate = new Date(Setdate);
                        }
    
                        newdate.setDate(newdate.getDate() + 30);
                        var dd = newdate.getDate();
                        var mm = newdate.getMonth() + 1;
                        var yyyy = newdate.getFullYear();
    
                        if (dd < 10) {
                          var Newdd = '0' + dd;
                        }else {
                          var Newdd = dd;
                        }
                        if (mm < 10) {
                          var Newmm = '0' + mm;
                        }else {
                          var Newmm = mm;
                        }
                        var result = yyyy + '-' + Newmm + '-' + Newdd;
                        document.getElementById('orderdaycourt').value = result;
                      // }
                      //---------- end ---------//
    
                      //---------- วันส่งคำบังคับ
                      var date2 = document.getElementById('orderdaycourt').value;
                      var ordersenddate = document.getElementById('ordersendcourt').value;
                        if (date2 != '') {
                          var Setdate = new Date(date2);
                          var newdate = new Date(Setdate);
                          if (ordersenddate != '') {
                            var Setdate = new Date(ordersenddate);
                            var newdate = new Date(Setdate);
                          }
                        }else if (ordersenddate != '') {
                          var Setdate = new Date(ordersenddate);
                          var newdate = new Date(Setdate);
                        }
    
                        newdate.setDate(newdate.getDate() + 45);
                        var dd = newdate.getDate();
                        var mm = newdate.getMonth() + 1;
                        var yyyy = newdate.getFullYear();
    
                        if (dd < 10) {
                          var Newdd = '0' + dd;
                        }else {
                          var Newdd = dd;
                        }
                        if (mm < 10) {
                          var Newmm = '0' + mm;
                        }else {
                          var Newmm = mm;
                        }
                        var result = yyyy + '-' + Newmm + '-' + Newdd;
                        document.getElementById('checkdaycourt').value = result;
                      //---------- end ---------//
                    }
                    // ฟังชันคำนวณ วันที่จาก การเลือก checkbox
                    function CourtDate2(){
                      var date = document.getElementById('checkdaycourt').value;
                      var checksenddate = document.getElementById('checksendcourt').value;
    
                      var checkFlag = document.getElementById("1").checked;
                      var messageFlag = document.getElementById("4").checked;
    
                      if (messageFlag == false) {
                        if (checkFlag == false) {
                          var Setdate = new Date(checksenddate);
                          var newdate = new Date(Setdate);
    
                          newdate.setDate(newdate.getDate() + 15);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var result = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('orderdaycourt').value = result;
                        }
                        else {
                          var Setdate = new Date(checksenddate);
                          var newdate = new Date(Setdate);
    
                          newdate.setDate(newdate.getDate() + 45);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var resultcheck = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('setofficecourt').value = resultcheck;
    
                          var sendoffice = document.getElementById('sendofficecourt').value;
                          var Setdate = new Date(resultcheck);
                          var newdate = new Date(Setdate);
    
                          if (Setdate != '') {
                            var Setdate = new Date(resultcheck);
                            var newdate = new Date(Setdate);
                            if (sendoffice != '') {
                              var Setdate = new Date(sendoffice);
                              var newdate = new Date(Setdate);
                            }
                          }else if (sendoffice != '') {
                            var Setdate = new Date(sendoffice);
                            var newdate = new Date(Setdate);
                          }
    
                          newdate.setDate(newdate.getDate() + 45);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var result = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('checkresultscourt').value = result;
                        }
                      }
                    }
                    // ฟังชันคำนวณ วันที่จาก ผู้เช่าซื้อกับผู้ค้ำ
                    function CheckMessege(){
                      var buyer = document.getElementById('buyercourt').value;
                      var Setbuyer = buyer.substring(8);
                      var support = document.getElementById('supportcourt').value;
                      var Setsupport = support.substring(8);
    
                      if (Setbuyer != '' && Setsupport != '') {
                        if (Setbuyer == Setsupport) {
                            var Setdate = new Date(buyer);
                            var newdate = new Date(Setdate);
    
                            newdate.setDate(newdate.getDate() + 45);
                            var dd = newdate.getDate();
                            var mm = newdate.getMonth() + 1;
                            var yyyy = newdate.getFullYear();
    
                            if (dd < 10) {
                              var Newdd = '0' + dd;
                            }else {
                              var Newdd = dd;
                            }
                            if (mm < 10) {
                              var Newmm = '0' + mm;
                            }else {
                              var Newmm = mm;
                            }
                            var result = yyyy + '-' + Newmm + '-' + Newdd;
                            document.getElementById('setofficecourt').value = result;
                        }
                        else if (Setbuyer > Setsupport) {
                          var Setdate = new Date(buyer);
                          var newdate = new Date(Setdate);
    
                          newdate.setDate(newdate.getDate() + 45);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var result = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('setofficecourt').value = result;
    
                        }
                        else if (Setbuyer < Setsupport) {
                          var Setdate = new Date(support);
                          var newdate = new Date(Setdate);
    
                          newdate.setDate(newdate.getDate() + 45);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var result = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('setofficecourt').value = result;
                        }
    
                        var sendoffice = document.getElementById('sendofficecourt').value;
                        var checkresults = new Date(result);
                        var newdate = new Date(checkresults);
    
                        if (checkresults != '') {
                          var Setdate = new Date(checkresults);
                          var newdate = new Date(Setdate);
                          if (sendoffice != '') {
                            var Setdate = new Date(sendoffice);
                            var newdate = new Date(Setdate);
                          }
                        }else if (sendoffice != '') {
                          var Setdate = new Date(sendoffice);
                          var newdate = new Date(Setdate);
                        }
    
                        newdate.setDate(newdate.getDate() + 45);
                        var dd = newdate.getDate();
                        var mm = newdate.getMonth() + 1;
                        var yyyy = newdate.getFullYear();
    
                        if (dd < 10) {
                          var Newdd = '0' + dd;
                        }else {
                          var Newdd = dd;
                        }
                        if (mm < 10) {
                          var Newmm = '0' + mm;
                        }else {
                          var Newmm = mm;
                        }
                        var resultcheck = yyyy + '-' + Newmm + '-' + Newdd;
                        document.getElementById('checkresultscourt').value = resultcheck;
                      }
                    }
                    function CalculateCap(){
                        var cap = document.getElementById('capitalcourt').value;
                        var Setcap = cap.replace(",","");
                        var ind = document.getElementById('indictmentcourt').value;
                        var Setind = ind.replace(",","");
    
                        var Sumcap = (Setcap * 0.1);
    
                        if(!isNaN(Setcap)){
                            document.form1.capitalcourt.value = addCommas(Setcap);
                            document.form1.pricelawyercourt.value = addCommas(Sumcap.toFixed(2));
                       }
                        if(!isNaN(Setind)){
                            document.form1.indictmentcourt.value = addCommas(Setind);
                       }
                    }
                  </script>

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
                              <small class="badge badge-primary" style="font-size: 25px;">
                                <i class="fas fa-sign"></i>&nbsp; สถานะ :
                                @if($data->Status_legis != Null)
                                  {{$data->Status_legis}}
                                @endif
                              </small>
                              <div class="form-inline">
                                <label>สถานะ : </label>
                                <select name="Statuslegis" class="form-control" style="width: 170px;">
                                  <option value="" selected>--------- status ----------</option>
                                  <option value="ปิดบัญชีชั้นศาล" {{ ($data->Status_legis === 'ปิดบัญชีชั้นศาล') ? 'selected' : '' }}>ปิดบัญชีชั้นศาล</option>
                                  <option value="ยึดรถชั้นศาล" {{ ($data->Status_legis === 'ยึดรถชั้นศาล') ? 'selected' : '' }}>ยึดรถชั้นศาล</option>
                                  <option value="ประนอมหนี้ชั้นศาล" {{ ($data->Status_legis === 'ประนอมหนี้ชั้นศาล') ? 'selected' : '' }}>ประนอมหนี้ชั้นศาล</option>
                                  @if($data->Status_legis != Null)
                                    <option disabled>------------------------------</option>
                                    <option value="{{$data->Status_legis}}" style="color:red" {{ ($data->Status_legis === $data->Status_legis) ? 'selected' : '' }}>{{$data->Status_legis}}</option>
                                  @endif
                                </select>
                                <input type="date" name="DateStatuslegis" class="form-control" style="width: 170px;" value="{{ $data->txtStatus_court }}">
                              </div>
                            </div>
                            
                            <div class="col-md-4">
                              <div class="float-right form-inline">
                                <a class="btn btn-app" data-toggle="modal" data-target="#modal-printinfo" data-backdrop="static" data-keyboard="false" style="background-color:blue; color:#FFFFFF;">
                                  <i class="fas fa-print"></i> ใบเสร็จ
                                </a>
                                <button type="submit" class="btn btn-app" style="background-color:#189100; color:#FFFFFF;">
                                  <i class="fas fa-save"></i> Save
                                </button>
                                <a class="btn btn-app" href="{{ route('legislation',2) }}" style="background-color:#DB0000; color:#FFFFFF;">
                                  <i class="fas fa-times"></i> ยกเลิก
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <h5 class="" align="left"><b>ขั้นตอนชั้นศาล</b></h5>
                  <div class="row">
                    <div class="col-12">
                      <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-1" data-toggle="pill" href="#tabs-1" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false"><i class="fas fa-toggle-on"></i> วันฟ้อง(45-60 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-2" data-toggle="pill" href="#tabs-2" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><i class="fas fa-toggle-on"></i> สืบพยาน(30 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-3" data-toggle="pill" href="#tabs-3" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fas fa-toggle-on"></i> ส่งคำบังคับ(45 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-4" data-toggle="pill" href="#tabs-4" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true"><i class="fas fa-toggle-on"></i> ตรวจผลหมาย(45 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-5" data-toggle="pill" href="#tabs-5" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true"><i class="fas fa-toggle-on"></i> ตั้งเจ้าพนักงาน(45 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-6" data-toggle="pill" href="#tabs-6" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true"><i class="fas fa-toggle-on"></i> ตรวจผลหมายตั้ง(45 วัน)</a>
                            </li>
                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="tabs-1" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                              <div class="row">
                                <div class="col-md-3">
                                  วันที่ฟ้อง
                                  <input type="date" id="fillingdatecourt" name="fillingdatecourt" class="form-control" value="{{ ($data->fillingdate_court) }}" required/>
                                </div>
                                <div class="col-md-3">
                                  ศาล
                                  <select name="lawcourt" class="form-control">
                                    <option value="" selected>--- ศาล ---</option>
                                    <option value="ศาลปัตตานี" {{ ($data->law_court === 'ศาลปัตตานี') ? 'selected' : '' }}>ศาลปัตตานี</option>
                                    <option value="ศาลยะลา" {{ ($data->law_court === 'ศาลยะลา') ? 'selected' : '' }}>ศาลยะลา</option>
                                    <option value="ศาลนราธิวาส" {{ ($data->law_court === 'ศาลนราธิวาส') ? 'selected' : '' }}>ศาลนราธิวาส</option>
                                    <option value="ศาลเบตง" {{ ($data->law_court === 'ศาลเบตง') ? 'selected' : '' }}>ศาลเบตง</option>
                                    <option value="ศาลนาทวี" {{ ($data->law_court === 'ศาลนาทวี') ? 'selected' : '' }}>ศาลนาทวี</option>
                                  </select>
                                </div>
                                <div class="col-md-3">
                                  เลขคดีดำ
                                  <input type="text" name="bnumbercourt" class="form-control" value="{{ ($data->bnumber_court) }}" />
                                </div>
                                <div class="col-md-3">
                                  เลขคดีแดง
                                  <input type="text" name="rnumbercourt" class="form-control" value="{{ ($data->rnumber_court) }}"  />
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  ทุนทรัพย์
                                  <input type="text" id="capitalcourt" name="capitalcourt" class="form-control" value="{{ number_format($data->capital_court, 2) }}" oninput="CalculateCap();"/>
                                </div>
                                <div class="col-md-3">
                                  ค่าฟ้อง
                                  <input type="text" id="indictmentcourt" name="indictmentcourt" class="form-control" value="{{ number_format($data->indictment_court, 2) }}" oninput="CalculateCap();"/>
                                </div>
                                <div class="col-md-3">
                                  ค่าทนาย
                                  <input type="text" id="pricelawyercourt" name="pricelawyercourt" class="form-control" value="{{ number_format($data->pricelawyer_court, 2) }}" readonly/>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันที่สืบพยาน
                                  <input type="date" id="examidaycourt" name="examidaycourt" class="form-control" value="{{ ($data->examiday_court) }}" oninput="CourtDate();" />
                                </div>
                                <div class="col-md-6">
                                  วันที่เลือน
                                  <input type="date" id="fuzzycourt" name="fuzzycourt" class="form-control" value="{{ ($data->fuzzy_court) }}" oninput="CourtDate();" />
                                </div>
                              </div>
                              หมายเหตุ
                              <textarea name="examinotecourt" class="form-control" rows="5">{{ ($data->examinote_court) }}</textarea>
                            </div>
                            <div class="tab-pane fade" id="tabs-3" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันที่ดึงจากระบบ
                                  <input type="date" id="orderdaycourt" name="orderdaycourt" class="form-control" value="{{ ($data->orderday_court) }}" readonly/>
                                </div>
                                <div class="col-md-6">
                                  วันที่ส่งจริง
                                  <input type="date" id="ordersendcourt" name="ordersendcourt" class="form-control" value="{{ ($data->ordersend_court) }}" oninput="CourtDate();" />
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-4" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                              <div class="row">
                                <div class="col-md-3">
                                  วันที่ตรวจผลหมาย
                                  <input type="date" id="checkdaycourt" name="checkdaycourt" class="form-control" value="{{ ($data->checkday_court) }}" oninput="CourtDate2();" readonly/>
                                </div>
                                <div class="col-md-3">
                                  วันทีผู้เช่าซื้อได้รับ
                                  <input type="date" id="buyercourt" name="buyercourt" class="form-control" value="{{ ($data->buyer_court) }}" oninput="CheckMessege();"/>
                                </div>
                                <div class="col-md-3">
                                  วันทีผู้ค้ำได้รับ
                                  <input type="date" id="supportcourt" name="supportcourt" class="form-control" value="{{ ($data->support_court) }}" oninput="CheckMessege();"/>
                                </div>
                                <div class="col-md-3">
                                  วันที่ตรวจผลหมายจริง
                                  <input type="date" id="checksendcourt" name="checksendcourt" class="form-control" value="{{ ($data->checksend_court) }}" onchange="CourtDate2();" />
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-9">
                                  หมายเหตุ
                                  <textarea name="notecourt" class="form-control" value="" rows="4" >{{ ($data->note_court) }}</textarea>
                                </div>
                                <div class="col-md-3">
                                  <p></p>
                                  <span class="todo-wrap">
                                    @if($data->social_flag == "infomation")
                                      <input type="checkbox" id="1" name="socialflag" value="{{ $data->social_flag }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="1" name="socialflag" value="infomation" onclick="CourtDate2()"/>
                                    @endif
                                    <label for="1" class="todo">
                                      <i class="fa fa-check"></i>
                                      ประกาศสื่ออิเล็กทรอนิกส์
                                    </label>
                                  </span>

                                  <span class="todo-wrap">
                                    @if($data->social_flag == "success")
                                      <input type="checkbox" id="4" name="socialflag" value="{{ $data->social_flag }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="4" name="socialflag" value="success" onclick="CourtDate2()"/>
                                    @endif
                                    <label for="4" class="todo">
                                      <i class="fa fa-check"></i>
                                      ได้รับผลหมายทั้งคู่
                                    </label>
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-5" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันทีตั้งเจ้าพนักงาน
                                  <input type="date" id="setofficecourt" name="setofficecourt" class="form-control" value="{{ $data->setoffice_court }}" readonly/>
                                </div>
                                <div class="col-md-6">
                                  วันที่ส่งจริง
                                  <input type="date" id="sendofficecourt" name="sendofficecourt" class="form-control" value="{{ $data->sendoffice_court }}" oninput="CheckMessege();CourtDate2();"/>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-6" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                              <div class="row">
                                <div class="col-md-3">
                                  วันที่ตรวจผลหมายตั้ง
                                  <input type="date" id="checkresultscourt" name="checkresultscourt" class="form-control" value="{{ $data->checkresults_court }}" readonly/>
                                </div>
                                <div class="col-md-3">
                                  วันที่ตรวจจริง
                                  <input type="date" id="sendcheckresultscourt" name="sendcheckresultscourt" class="form-control" value="{{ $data->sendcheckresults_court }}" oninput="Datesuccess();"/>
                                </div>
                                <div class="col-md-6">
                                  <div class="row"  align="center">
                                    <br>
                                    <div class="col-md-6">
                                      <input type="radio" id="test3" name="radio-receivedflag" value="Y" onclick="Functionhidden2()" {{ ($data->received_court === 'Y') ? 'checked' : '' }} />
                                      <label for="test3">ได้รับ</label>
                                    </div>
                                    <div class="col-md-6">
                                      <input type="radio" id="test4" name="radio-receivedflag" value="N" onclick="FunctionRadio2()" {{ ($data->received_court === 'N') ? 'checked' : '' }} />
                                      <label for="test4">ไม่ได้รับ</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <div class="row">
                                    <div class="col-md-7"></div>
                                    <div class="col-md-5">
                                       @if($data->received_court == "Y" or $data->received_court == Null)
                                         <div id="myDIV" style="display:none;">
                                       @else
                                        <div id="myDIV">
                                       @endif
  
                                          วันทีโทร
                                          <input type="date" id="telresultscourt" name="telresultscourt" class="form-control" value="{{ $data->telresults_court }}" />
                                          วันทีไปรับ
                                          <input type="date" id="dayresultscourt" name="dayresultscourt" class="form-control" value="{{ $data->dayresults_court }}" oninput="Datesuccess()"/>
  
                                       </div>
                                     </div>
                                   </div>
  

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="_method" value="PATCH"/>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <div class="modal fade" id="modal-printinfo">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form name="form2" method="post" action="{{ route('legislation.store',[$id, 2]) }}" target="_blank" id="formimage" enctype="multipart/form-data">
          @csrf
          <div class="card card-warning">
            <div class="card-header">
              <h4 class="card-title">ป้อนข้อมูลปิดบัญชี</h4>
              <div class="card-tools">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
              </div>
            </div>

            <script type="text/javascript">
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
                var num11 = document.getElementById('TopCloseAccount').value;
                var num1 = num11.replace(",","");
                var num22 = document.getElementById('PriceAccount').value;
                var num2 = num22.replace(",","");
                var num33 = document.getElementById('DiscountAccount').value;
                var num3 = num33.replace(",","");

                document.form2.TopCloseAccount.value = addCommas(num1);
                document.form2.PriceAccount.value = addCommas(num2);
                document.form2.DiscountAccount.value = addCommas(num3);
              }
            </script>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-5">
                  <div class="float-right form-inline">
                    <label>วันที่ปิดบัญชี : </label>
                    <input type="date" name="DateCloseAccount" class="form-control" style="width: 180px;" value="{{ (($data->DateStatus_legis !== Null) ?$data->DateStatus_legis: date('Y-m-d')) }}" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="float-right form-inline">
                    <label>ยอดปิดบัญชี : </label>
                    <input type="text" id="PriceAccount" name="PriceAccount" class="form-control" style="width: 180px;" placeholder="ป้อนยอดตั้งต้น" value="{{ number_format(($data->PriceStatus_legis !== Null) ?$data->PriceStatus_legis: 0) }}" oninput="addcomma();" maxlength="8" />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-5">
                  <div class="float-right form-inline">
                    <label>ยอดชำระ : </label>
                    <input type="text" id="TopCloseAccount" name="TopCloseAccount" class="form-control" style="width: 180px;" placeholder="ป้อนยอดชำระ" value="{{ number_format(($data->txtStatus_legis !== Null) ?$data->txtStatus_legis: 0) }}" oninput="addcomma();" maxlength="8" />
                    <input type="hidden" name="ContractNo" class="form-control" value="{{$data->Contract_legis}}"/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="float-right form-inline">
                    <label>ยอดส่วนลด : </label>
                    <input type="text" id="DiscountAccount" name="DiscountAccount" class="form-control" style="width: 180px;" placeholder="ป้อนยอดส่วนลด" value="{{ number_format(($data->Discount_legis !== Null) ?$data->Discount_legis: 0) }}" oninput="addcomma();" maxlength="8" />
                  </div>
                </div>
              </div>
            </div>
            <div align="center">
              <button id="submit" type="submit" class="btn btn-primary"><span class="fa fa-id-card-o"></span> พิมพ์</button>
            </div>
            <br>
          </div>

      </form>
      </div>
    </div>
  </div>

  <script>
    function FunctionRadio2() {
      var x = document.getElementById("myDIV");
      if (x.style.display === "none") {
      x.style.display = "block";
      } else {
      x.style.display = "none";
      }
    }

    function Functionhidden2() {
      var x = document.getElementById("myDIV");
      x.style.display = "none";
    }
  </script>
  
  <script>
    function FunctionRadio() {
      var x = document.getElementById("ShowMe");
      if (x.style.display === "none") {
      x.style.display = "block";
      } else {
      x.style.display = "none";
      }
    }

    function Functionhidden() {
      var x = document.getElementById("ShowMe");
      x.style.display = "none";
    }
  </script>
@endsection
