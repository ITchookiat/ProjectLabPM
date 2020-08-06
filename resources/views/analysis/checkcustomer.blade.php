@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
@section('content')

@php
  date_default_timezone_set('Asia/Bangkok');
  $date = date('Y-m-d', strtotime('-1 days'));

  date_default_timezone_set('Asia/Bangkok');
  $Y = date('Y') + 543;
  $m = date('m');
  $d = date('d');
  $time = date('H:i');
  $date2 = $Y.'-'.$m.'-'.$d;

  function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("" , "01","02","03","04","05","06","07","08","09","10","11","12");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay/$strMonthThai/$strYear";
  }
  function DateThai1($strDate){
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("" , "มกราคม.","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
  }
@endphp

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>

    <!-- <section class="content-header">
      <h1>
        ปรับโครงสร้างหนี้
        <small>it all starts here</small>
      </h1>
    </section> -->
<style>
  input:read-only {
  background-color: yellow;
  }
</style>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h4 align="center"><b>เช็คข้อมูลลูกค้าปรับโครงสร้างหนี้</b></h4>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>


          <div class="box-body">
            @if(session()->has('success'))
              <div class="alert alert-success alert-dismissible" role="alert" align="center">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <strong>สำเร็จ!</strong> {{ session()->get('success') }}
              </div>
            @endif

            <div class="row">
              <div class="col-md-12">

                <hr>
                <div class="row">
                  <div class="col-md-4">
                      <div class="form-inline" align="right">
                        <label>เลขที่สัญญา : </label>
                        @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @else
                        <input type="text" value="{{$data[0]->CONTNO}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @endif
                      </div>
                    </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>ชื่อลูกค้า : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->SNAM))}}{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->NAME1))}}   {{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->NAME2))}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>

                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label><font color="red">อายุ</font> : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{$data[0]->AGE}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                      <div class="form-inline" align="right">
                        <label>วันทำสัญญา : </label>
                        @if($data == null)
                          <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @else
                          <input type="text" value="{{DateThai1($data[0]->ISSUDT)}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @endif
                      </div>
                    </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>ที่อยู่ : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{iconv('TIS-620', 'utf-8',$data[0]->ADDRES)}} {{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->TUMB))}} {{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->AUMPDES))}} {{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->PROVDES))}} {{$data[0]->ZIP}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>

                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>เบอร์โทร : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->TELP))}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                      <div class="form-inline" align="right">
                        <label>เงินลงทุน : </label>
                        @if($data == null)
                          <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @else
                          <input type="text" value="{{number_format($data[0]->NCARCST,2)}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @endif
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>จำนวดงวด : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{$data[0]->T_NOPAY}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>ดอกเบี้ย : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 118px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{$data[0]->EFRATE}}" class="form-control" style="width: 118px;background-color:white;" readonly/>
                      @endif
                      <label>ต่อปี</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                      <div class="form-inline" align="right">
                        <label><font color="red">ค่างวดละ</font> : </label>
                        @if($data == null)
                          <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @else
                          <input type="text" value="{{number_format($data[0]->DAMT,2)}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @endif
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>ชำระแล้ว : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{number_format($data[0]->SMPAY,2)}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>คงเหลือ : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{number_format($data[0]->BALANC - $data[0]->SMPAY,2)}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                      <div class="form-inline" align="right">
                        <label>ผ่อนมาแล้ว : </label>
                        @if($data == null)
                          <input type="text" class="form-control" style="width: 120px;background-color:white;" readonly/>
                        @else
                          <input type="text" value="{{$dataPAYcount}}" class="form-control" style="width: 120px;background-color:white;" readonly/>
                        @endif
                        <label>งวด</label>
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>ผ่อนคงเหลือ : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 120px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{$dataNOPAYcount}}" class="form-control" style="width: 120px;background-color:white;" readonly/>
                      @endif
                      <label>งวด</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <!-- <label>เงินต้นใหม่ : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{number_format(round(($data[0]->NCARCST / $data[0]->T_NOPAY)*$dataNOPAYcount),2)}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif -->
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                      <div class="form-inline" align="right">
                        <label>ยี่ห้อรถ : </label>
                        @if($data == null)
                          <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @else
                          <input type="text" value="{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->TYPE))}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @endif
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>รุ่นรถ : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->MODEL))}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>สีรถ : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->COLOR))}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                      <div class="form-inline" align="right">
                        <label>ทะเบียนรถ : </label>
                        @if($data == null)
                          <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @else
                          <input type="text" value="{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->REGNO))}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                        @endif
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label><font color="red">ปีรถ</font> : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->MANUYR))}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-inline" align="right">
                      <label>ขนาด cc : </label>
                      @if($data == null)
                        <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @else
                        <input type="text" value="{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->CC))}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                      @endif
                    </div>
                  </div>
                </div>
                <hr>
                @if($data != null)
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <p><b>ตารางผ่อนชำระ</b></p>
                      <div class="table-responsive">
                        <table class="table table-bordered" id="table" align="center">
                           <thead class="thead-dark bg-gray-light" >
                             <tr>
                               <th class="text-center">งวดที่</th>
                               <th class="text-center">วันที่ดิว</th>
                               <th class="text-center">ค่างวด</th>
                               <th class="text-center">วันที่ชำระ</th>
                               <th class="text-center">ยอดชำระ</th>
                               <th class="text-center">เลขที่ใบกำกับ</th>
                               <th class="text-center">วันที่ใบกำกับ</th>
                               <th class="text-center">เงินต้น</th>
                               <th class="text-center">ดอกเบี้ย</th>
                             </tr>
                           </thead>
                           <tbody>
                             @foreach($data as $key => $row)
                                @if($row->DATE1 != null)
                                 <tr>
                                   <td class="text-center">{{$row->NOPAY}}</td>
                                   <td class="text-center">{{DateThai($row->DDATE)}}</td>
                                   <td class="text-center">{{number_format($row->DAMT,2)}}</td>
                                   @if($row->DATE1 != null)
                                     <td class="text-center">{{DateThai($row->DATE1)}}</td>
                                   @else
                                     <td class="text-center"></td>
                                   @endif
                                   @if($row->PAYMENT != 0)
                                     <td class="text-center">{{number_format($row->PAYMENT,2)}}</td>
                                   @else
                                     <td class="text-center"></td>
                                   @endif
                                   <td class="text-center">{{$row->TAXINV}}</td>
                                   @if($row->TAXDT != null)
                                     <td class="text-center">{{DateThai($row->TAXDT)}}</td>
                                   @else
                                     <td class="text-center"></td>
                                   @endif
                                   <td class="text-center">{{number_format($row->TONEFFR,2)}}</td>
                                   <td class="text-center">{{number_format($row->INTEFFR,2)}}</td>
                                 </tr>
                                @else
                                 <tr style="color:red;">
                                   <td class="text-center">{{$row->NOPAY}}</td>
                                   <td class="text-center">{{DateThai($row->DDATE)}}</td>
                                   <td class="text-center">{{number_format($row->DAMT,2)}}</td>
                                   @if($row->DATE1 != null)
                                     <td class="text-center">{{DateThai($row->DATE1)}}</td>
                                   @else
                                     <td class="text-center"></td>
                                   @endif
                                   @if($row->PAYMENT != 0)
                                     <td class="text-center">{{number_format($row->PAYMENT,2)}}</td>
                                   @else
                                     <td class="text-center"></td>
                                   @endif
                                   <td class="text-center">{{$row->TAXINV}}</td>
                                   @if($row->TAXDT != null)
                                     <td class="text-center">{{DateThai($row->TAXDT)}}</td>
                                   @else
                                     <td class="text-center"></td>
                                   @endif
                                   <td class="text-center">{{number_format($row->TONEFFR,2)}}</td>
                                   <td class="text-center">{{number_format($row->INTEFFR,2)}}</td>
                                 </tr>
                                @endif
                              @endforeach
                           </tbody>
                         </table>
                    </div>
                  </div>
                @endif
              </div>
           </div>

        </div>

      </div>
    </section>

    <section class="content">
      <div class="content-header">
        @if(session()->has('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <strong>สำเร็จ!</strong> {{ session()->get('success') }}
          </div>
        @endif
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
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-4">
                        <div class="form-inline">
                          <h4>
                          เช็คข้อมูลลูกค้าปรับโครงสร้างหนี้
                          </h4>
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="row">
                          <div class="col-8">
                          </div>
                          <div class="col-4">
                            <form method="get" action="{{ route('Analysis',10) }}">
                              <div align="right" class="form-inline">
                                <label>เลขที่สัญญา : </label>
                                @if($data == null)
                                  <input type="type" name="Contno" maxlength="12" style="padding:3px;width:150px;border-radius: 5px 0 5px 5px; font-size:20px;"/>
                                @else
                                  <input type="type" name="Contno" value="{{$Contno}}" maxlength="12" style="padding:3px;width:150px;border-radius: 5px 0 5px 5px; font-size:20px;"/>
                                @endif
                                <button type="submit" class="btn btn-info">
                                  <span class="fas fa-search"></span>
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-sm">

                    <div class="row">
                      <div class="col-md-12">

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
                                <div class="col-4">
                                  <div class="float-right form-inline">
                                  <label>เลขที่สัญญา : </label>
                                  @if($data == null)
                                  <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                                  @else
                                  <input type="text" value="{{$data[0]->CONTNO}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                                  @endif
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="float-right form-inline">
                                  <label>ชื่อลูกค้า : </label>
                                  @if($data == null)
                                    <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                                  @else
                                    <input type="text" value="{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->SNAM))}}{{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->NAME1))}}   {{iconv('TIS-620', 'utf-8',str_replace(" ","",$data[0]->NAME2))}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                                  @endif
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="float-right form-inline">
                                    <label><font color="red">อายุ</font> : </label>
                                    @if($data == null)
                                      <input type="text" class="form-control" style="width: 150px;background-color:white;" readonly/>
                                    @else
                                      <input type="text" value="{{$data[0]->AGE}}" class="form-control" style="width: 150px;background-color:white;" readonly/>
                                    @endif
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ยี่ห้อ : </label>
                                  <select name="Brandcar" class="form-control" style="width: 250px;">
                                    <option value="" disabled selected>--- เลือกยี่ห้อ ---</option>
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
                                  </select>
                                  </div>
                                </div>
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ทะเบียน : </label>
                                  <input type="text" name="Number_Regist" class="form-control" style="width: 250px;" placeholder="ป้อนทะเบียน" >
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ปี : </label>
                                  <select name="Yearcar" class="form-control" style="width: 250px;">
                                    <option value="" disabled selected>--- เลือกปี ---</option>
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
                                  <input type="date" name="Datehold" class="form-control" style="width: 250px;" value="{{ date('Y-m-d') }}">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ทีมยึด : </label>
                                  <select name="Teamhold" class="form-control" style="width: 250px">
                                    <option selected value="">---เลือกทีมยึด---</option>
                                      <option value="008">008 - เจ๊ะฟารีด๊ะห์ เจ๊ะกาเดร์</otion>
                                      <option value="102">102 - นายอับดุลเล๊าะ กาซอ</otion>
                                      <option value="104">104 - นายอนุวัฒน์ อับดุลรานี</otion>
                                      <option value="105">105 - นายธีรวัฒน์ เจ๊ะกา</otion>
                                      <option value="112">112 - นายราชัน เจ๊ะกา</otion>
                                      <option value="113">113 - นายฟิฏตรี วิชา</otion>
                                      <option value="114">114 - นายอานันท์ กาซอ</otion>
                                  </select>
                                  </div>
                                </div>
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ค่ายึด : </label>
                                  <input type="text" id="Pricehold" name="Pricehold" class="form-control" style="width: 250px;" placeholder="ป้อนค่ายึด" oninput="comma();">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label><font color="red">สถานะรถ : </font></label>
                                  <select name="Statuscar" class="form-control" style="width: 250px">
                                    <option selected value="">---เลือกสถานะ---</option>
                                      <option value="1">ยึดจากลูกค้าครั้งแรก</otion>
                                      <option value="2">ลูกค้ามารับรถคืน</otion>
                                      <option value="3">ยึดจากลูกค้าครั้งที่ 2</otion>
                                      <option value="4">รับรถจากของกลาง</otion>
                                      <option value="5">ส่งรถบ้าน</otion>
                                      <option value="6">ลูกค้าส่งรถคืน</otion>
                                  </select>
                                  </div>
                                </div>
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label style="vertical-align: top;">รายละเอียด : </label>
                                  <textarea name="Note" class="form-control" placeholder="ป้อนรายละเอียด" rows="2" style="width: 250px;"></textarea>
                                  </div>
                                </div>
                              </div>

                              <hr>
                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>วันที่มารับรถคืน : </label>
                                  <input type="date" name="Datecame" class="form-control" style="width: 250px;">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ค่างวดยึดค้าง : </label>
                                  <input type="text" id="Amounthold" name="Amounthold" class="form-control" style="width: 250px;" placeholder="ป้อนค่างวดยึดค้าง" oninput="comma();" >
                                  </div>
                                </div>
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ชำระค่างวดยึด : </label>
                                  <input type="text" id="Payhold" name="Payhold" class="form-control" style="width: 250px;" placeholder="ป้อนชำระค่างวดยึด" oninput="comma();">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>วันที่เช็คต้นทุน : </label>
                                  <input type="date" name="DatecheckCapital" class="form-control" style="width: 250px;">
                                  </div>
                                </div>
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>วันที่ส่งรถบ้าน : </label>
                                  <input type="date" name="DatesendStockhome" class="form-control" style="width: 250px;">
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
                                  <input type="date" name="DatesendLetter" class="form-control" style="width: 250px;">
                                  </div>
                                </div>
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>เลขบาร์โค๊ด : </label>
                                  <input type="text" name="BarcodeNo" class="form-control" style="width: 250px;" placeholder="ป้อนเลขบาร์โค๊ด">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ต้นทุนบัญชี : </label>
                                  <input type="text" id="CapitalAccount" name="CapitalAccount" class="form-control" style="width: 250px;" placeholder="ป้อนต้นทุนบัญชี" oninput="comma();">
                                  </div>
                                </div>
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ต้นทุนยอดจัด : </label>
                                  <input type="text" id="CapitalTopprice" name="CapitalTopprice" class="form-control" style="width: 250px;" placeholder="ป้อนต้นทุนยอดจัด" oninput="comma();">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label style="vertical-align: top;">หมายเหตุ : </label>
                                  <textarea name="Note2" class="form-control" placeholder="ป้อนหมายเหตุ" rows="2" style="width: 250px;"></textarea>
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
                                  <input type="text" name="Letter" class="form-control" style="width: 250px;" placeholder="ป้อนจดหมาย">
                                  </div>
                                </div>
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                    <label>วันส่ง : </label>
                                    <input type="date" name="Datesend" class="form-control" style="width: 250px;">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>บาร์โค๊ดผู้ค้ำ : </label>
                                  <input type="text" name="Barcode2" class="form-control" style="width: 250px;" placeholder="ป้อนบาร์โค๊ด">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>รับ : </label>
                                  <!-- <input type="text" name="Accept" class="form-control" style="width: 250px;" placeholder="ป้อนข้อมูล"> -->
                                  <select name="Accept" class="form-control" style="width: 250px">
                                    <option selected disabled value="">---เลือก---</option>
                                      <option value="ได้รับ">ได้รับ</otion>
                                      <option value="รอส่ง">รอส่ง</otion>
                                      <option value="ส่งใหม่">ส่งใหม่</otion>
                                  </select>
                                  </div>
                                </div>
                                <div class="col-5">
                                  <div class="float-right form-inline">
                                  <label>ขายได้ : </label>
                                  <input type="text" name="Soldout" class="form-control" style="width: 250px;" readonly>
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

@endsection
