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

@php
  function num2thai($thb) {
    list($thb, $ths) = explode('.', $thb);
    $ths = substr($ths.'00', 0, 0);
    $thaiNum = array('','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า');
    $unitBaht = array('บาทถ้วน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
    $unitSatang = array('สตางค์','สิบ');
    $THB = '';
    $j = 0;
    for($i=strlen($thb)-1; $i>=0; $i--,$j++) {
    $num = $thb[$i];
    $tnum = $thaiNum[$num];
    $unit = $unitBaht[$j];
    switch(true) {
    case $j==0 && $num==1 && strlen($thb)>1: $tnum = 'เอ็ด'; break;
    case $j==1 && $num==1: $tnum = ''; break;
    case $j==1 && $num==2: $tnum = 'ยี่'; break;
    case $j==6 && $num==1 && strlen($thb)>7: $tnum = 'เอ็ด'; break;
    case $j==7 && $num==1: $tnum = ''; break;
    case $j==7 && $num==2: $tnum = 'ยี่'; break;
    case $j!=0 && $j!=6 && $num==0: $unit = ''; break;
    }
    $S = $tnum . $unit;
    $THB = $S . $THB;
    }
    if($ths=='00') {
    $THS = 'ถ้วน';
    } else {
    $j=0;
    $THS = '';
    for($i=strlen($ths)-1; $i>=0; $i--,$j++) {
    $num = $ths[$i];
    $tnum = $thaiNum[$num];
    $unit = $unitSatang[$j];
    switch(true) {
    case $j==0 && $num==1 && strlen($ths)>1: $tnum = 'เอ็ด'; break;
    case $j==1 && $num==1: $tnum = ''; break;
    case $j==1 && $num==2: $tnum = 'ยี่'; break;
    case $j!=0 && $j!=6 && $num==0: $unit = ''; break;
    }
    $S = $tnum . $unit;
    $THS = $S . $THS;
    }
    }
    return $THB.$THS;
  }

  if($type == 1 OR $type == 2){
    $thb = $dataDB->Gold_Payment.".00";
    $Pay_Amount = num2thai($thb);
  }elseif($type == 3){
    $thb = $dataDB->txtStatus_legis.".00";
    $Pay_Amount = num2thai($thb);
  }

@endphp

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

<!-- ส่วนหัว -->
  @if($type == 1 or $type == 2)
    <table border="0">
      <tbody>
        <tr>
          <th width="10px"></th>
          <th width="200px" align="left">วันที่ชำระ : {{ DateThai($dataDB->Date_Payment) }}</th>
          <th width="230px" align="left"></th>
          <th width="110px" align="right">พิมพ์วันที่ : {{ DateThai(date('d-m-Y')) }}</th>
        </tr>
        <tr>
          <th width="10px"></th>
          <th width="200px" align="left">เลขที่ใบเสร็จ : {{ $dataDB->Jobnumber_Payment }}<b></b></th>
        </tr>
      </tbody>
    </table>
    <h3 class="card-title p-3" align="center">ใบเสร็จรับชำระค่างวด</h3>
    <hr>
  @elseif($type == 3)
    <h3 class="card-title p-3" align="center">ใบเสร็จปิดบัญชี</h3>
    <hr>
  @elseif($type == 16)
    <label align="right">ปริ้นวันที่ : <u>{{ date('d-m-Y') }}</u></label>
    <h1 align="center" style="font-weight: bold;line-height:1px;"><b>ลูกหนี้ประนอมหนี้ @if($status != '')({{$status}})@endif</b></h1>
     @if($newfdate != '')
      <h3 align="center" style="font-weight: bold;"><b>ช่วงระหว่างวันที่ {{DateThai($newfdate)}} ถึงวันที่ {{DateThai($newtdate)}}</b></h3>
     @endif
    <hr>
  @elseif($type == 10)
    <label align="right">วันที่ : <u>{{ date('d-m-Y') }}</u></label>
    <h1 align="center" style="font-weight: bold;line-height:1px;"><b>ลูกหนี้ของกลาง</b></h1>
    <hr>
  @elseif($type == 15)
    <label align="right">วันที่ : <u>{{ date('d-m-Y') }}</u></label>
    <h2 class="card-title p-3" align="center"><u>รายงานบันทึกชำะค่างวด</u></h2>
    <!-- <hr> -->
  @elseif($type == 20)
    <label align="right">วันที่ปริ้น : <u>{{ date('d-m-Y') }}</u></label>
    <h2 class="card-title p-3" align="center" style="font-weight: bold;line-height:3px;"><b>รายงานตรวจสอบยอดชำระ</b></h2>
    @if($newfdate != '')
    <h5 class="card-title p-3" align="center" style="font-weight: bold;line-height:3px;">ระหว่างวันที่ {{DateThai($newfdate)}} ถึง วันที่ {{DateThai($newtdate)}}</h5>
    @endif
    <hr>
  @endif

<!-- ส่วนข้อมูล -->
  @if($type == 1 or $type == 2)
    <body style="margin-top: 0 0 0px;">
      <br>
      <table border="0">
        <tbody>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ชื่อ - นามสกุล : </b></th>
            <th width="10px"></th>
            <th width="150px" align="left">{{ iconv('Tis-620','utf-8',str_replace(" ","",$data->SNAM.$data->NAME1)."   ".str_replace(" ","",$data->NAME2)) }}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>เลขที่สัญญา :</b></th>
            <th width="10px"></th>
            <th width="150px" align="left">{{ $dataDB->Contract_legis }}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ที่อยู่ :</b></th>
            <th width="10px"></th>
            <th width="300px" align="left">
              {{
                iconv('Tis-620','utf-8',str_replace(" ","",$data->ADDRES))." ต.".iconv('Tis-620','utf-8',str_replace(" ","",$data->TUMB))." อ.".iconv('Tis-620','utf-8',str_replace(" ","",$data->AUMPDES))
                ." จ.".iconv('Tis-620','utf-8',str_replace(" ","",$data->PROVDES))."  ". $data->ZIP
              }}
            </th>
          </tr>
          <tr style="line-height:200%;">
            <th width="80px" align="right"><b>ยี่ห้อ :</b></th>
            <th width="10px"></th>
            <th width="150px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->TYPE))}}</th>
            <th width="80px" align="right"><b>ป้ายทะเบียน :</b></th>
            <th width="10px"></th>
            <th width="150px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->REGNO))}}</th>
          </tr>
          <tr style="line-height:200%;">
            <th width="80px" align="right"><b>แบบ :</b></th>
            <th width="10px"></th>
            <th width="150px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->BAAB))}}</th>
            <th width="80px" align="right"><b>สี :</b></th>
            <th width="10px"></th>
            <th width="150px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->COLOR))}}</th>
          </tr>
        </tbody>
      </table>
      <br>

      <table border="0">
        <tbody>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>งวดละ : </b></th>
            <th width="150px" align="center">
              {{number_format($dataDB->DuePay_Promise,2)}} บาท
              {{--
              {{ $dataDB->Period_Payment }} - {{ $dataDB->Period_Payment }}
              @if($dataDB->Gold_Payment < $dataDB->DuePay_Promise)
                *
              @endif
              --}}
            </th>
            <th width="150px" align="right"></th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ประเภทชำระ : </b></th>
            <th width="150px" align="center"> {{ $dataDB->Type_Payment }}</th>
            <th width="150px" align="right"></th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"></th>
            <th width="300px" align="right">
              @php
                $SetPrice = ($dataDB->Gold_Payment / 1.07);
              @endphp
              {{number_format($SetPrice, 2)}}
            </th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"></th>
            <th width="300px" align="right">7%</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"></th>
            <th width="300px" align="right">
              @php
                $SetVat = ($dataDB->Gold_Payment * 7) / 107;
              @endphp
              {{number_format($SetVat, 2)}}
            </th>
          </tr>
          <tr style="line-height:10%;">
            <th></th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ยอดสุทธิ : </b></th>
            <th width="150px" align="center"><b> ( {{  $Pay_Amount  }} )</b></th>
            <th width="150px" align="right">{{number_format($dataDB->Gold_Payment, 2)}}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ส่วนลด : </b></th>
            <th width="300px" align="right">{{number_format($dataDB->Discount_Promise, 2)}}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ยอดคงเหลือ : </b></th>
            <th width="300px" align="right">{{number_format($dataDB->Sum_Promise, 2)}} บาท</th>
          </tr>
        </tbody>
      </table>

      <table border="0">
        <tbody>
        <tr style="line-height:170%;">
            <th></th>
          </tr>
          <tr style="line-height:150%;">
            <th width="200px" align="center">(..............................................)</th>
            <th width="200px" align="center">(..............................................)</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="200px" align="center">ผู้รับเงิน</th>
            <th width="200px" align="center">ผู้จ่ายเงิน</th>
          </tr>
        </tbody>
      </table>
    </body>
  @elseif($type == 3)
    <body style="margin-top: 0 0 0px;">
      <br>
      <table border="0">
        <tbody>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ชื่อ - นามสกุล : </b></th>
            <th width="10px"></th>
            <th width="150px" align="left">{{ iconv('Tis-620','utf-8',str_replace(" ","",$data->SNAM.$data->NAME1)."   ".str_replace(" ","",$data->NAME2)) }}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>เลขที่สัญญา :</b></th>
            <th width="10px"></th>
            <th width="150px" align="left">{{ $dataDB->Contract_legis }}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ที่อยู่ :</b></th>
            <th width="10px"></th>
            <th width="300px" align="left">
              {{
                iconv('Tis-620','utf-8',str_replace(" ","",$data->ADDRES))." ต.".iconv('Tis-620','utf-8',str_replace(" ","",$data->TUMB))." อ.".iconv('Tis-620','utf-8',str_replace(" ","",$data->AUMPDES))
                ." จ.".iconv('Tis-620','utf-8',str_replace(" ","",$data->PROVDES))."  ". $data->ZIP
              }}
            </th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยี่ห้อ :</b></th>
            <th width="10px"></th>
            <th width="150px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->TYPE))}}</th>
            <th width="80px" align="right"><b>ป้ายทะเบียน :</b></th>
            <th width="10px"></th>
            <th width="150px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->REGNO))}}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>แบบ :</b></th>
            <th width="10px"></th>
            <th width="150px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->BAAB))}}</th>
            <th width="80px" align="right"><b>สี :</b></th>
            <th width="10px"></th>
            <th width="150px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->COLOR))}}</th>
          </tr>
        </tbody>
      </table>
      <br><br>

      <table border="0">
        <tbody>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>วันที่รับชำระ : </b></th>
            <th width="150px" align="center">{{ DateThai($dataDB->DateStatus_legis) }}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"></th>
            <th width="300px" align="right">
              @php
                $SetPrice = ($dataDB->txtStatus_legis / 1.07);
              @endphp
              {{number_format($SetPrice, 2)}}
            </th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"></th>
            <th width="300px" align="right">7%</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"></th>
            <th width="300px" align="right">
              @php
                $SetVat = ($dataDB->txtStatus_legis * 7) / 107;
              @endphp
              {{number_format($SetVat, 2)}}
            </th>
          </tr>
          <tr style="line-height:10%;">
            <th></th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยอดสุทธิ : </b></th>
            <th width="150px" align="center"><b> ( {{  $Pay_Amount  }} )</b></th>
            <th width="150px" align="right">{{number_format($dataDB->txtStatus_legis, 2)}}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยอดส่วนลด : </b></th>
            <th width="300px" align="right">{{number_format($dataDB->Discount_legis, 2)}}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยอดปิดบัญชี : </b></th>
            <th width="300px" align="right">{{number_format($dataDB->PriceStatus_legis, 2)}}</th>
          </tr>
          <tr style="line-height:180%;">
            <th width="80px" align="right"><b>ยอดคงเหลือ : </b></th>
            <th width="300px" align="right">
              @php
                $SetCountPrice = ($dataDB->txtStatus_legis + $dataDB->Discount_legis) - $dataDB->PriceStatus_legis;
              @endphp
              {{number_format($SetCountPrice , 2)}} บาท
            </th>
          </tr>
        </tbody>
      </table>

      <table border="0">
        <tbody>
        <tr style="line-height:150%;">
            <th></th>
          </tr>
          <tr style="line-height:180%;">
            <th width="200px" align="center">(..............................................)</th>
            <th width="200px" align="center">(..............................................)</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="200px" align="center">ผู้รับเงิน</th>
            <th width="200px" align="center">ผู้จ่ายเงิน</th>
          </tr>
        </tbody>
      </table>
    </body>
  @elseif($type == 16)
    <body>
      <br>
      <table border="1">
          <tr align="center" style="background-color: yellow;line-height: 200%;font-weight:bold;">
            <th style="width: 30px">ลำดับ</th>
            <th style="width: 65px">วันที่ประนอม</th>
            <th style="width: 80px">ระยะเวลา</th>
            <th>เลขที่สัญญา</th>
            <th style="width: 125px">ชื่อ-สกุล</th>
            <th style="width: 70px">เบอร์โทร</th>
            <th style="width: 60px">ยอดประนอม</th>
            <th style="width: 55px">ชำระแล้ว</th>
            <th style="width: 55px">ยอดคงเหลือ</th>
            <th style="width: 50px">งวดละ</th>
            <th style="width: 65px">วันชำระล่าสุด</th>
            <th style="width: 55px">สถานะ</th>
          </tr>
          @foreach($data as $key => $row)
          <tr style="line-height: 150%;">
            <td align="center" style="width: 30px">{{$key+1}}</td>
            <td align="center" style="width: 65px">{{DateThai($row->Date_Promise)}}</td>
            <td align="left" style="width: 80px">
              @if($row->Status_legis == "ปิดบัญชีประนอมหนี้" or $row->Status_legis == "ยึดรถหลังฟ้อง")
                @php
                  $Cldate = date_create($row->Date_Promise);
                  $nowCldate = date_create($row->DateUpState_legis);
                  $ClDateDiff = date_diff($Cldate,$nowCldate);
                  $duration = $ClDateDiff->format("%a วัน")
                @endphp
                <!-- <font color="green">{{$duration}}</font> -->
                <font color="green">{{$ClDateDiff->y}} ปี {{$ClDateDiff->m}} เดือน {{$ClDateDiff->d}} วัน</font>
              @else
                @php
                  $nowday = date('Y-m-d');
                  $Cldate = date_create($row->Date_Promise);
                  $nowCldate = date_create($nowday);
                  $ClDateDiff = date_diff($Cldate,$nowCldate);
                  $duration = $ClDateDiff->format("%a วัน")
                @endphp
                <!-- <font>{{$duration}}</font> -->
                <font>{{$ClDateDiff->y}} ปี {{$ClDateDiff->m}} เดือน {{$ClDateDiff->d}} วัน</font>
              @endif
            </td>
            <td align="center">{{$row->Contract_legis}}</td>
            <td style="width: 125px"> {{$row->Name_legis}}</td>
            <td align="left" style="width: 70px">
              @if($countDatasmart != 0)
                @foreach($SmartInfo as $key => $row1)
                  @if($row1->CONTNO == $row->Contract_legis)
                    {{ str_limit(iconv('Tis-620','utf-8',str_replace(" ","",$row1->TELP)),11)}}
                  @endif
                @endforeach
              @else
                -
              @endif
            </td>
            <td align="center" style="width: 60px"> {{number_format($row->Total_Promise,2)}} &nbsp;</td>
            <td align="center" style="width: 55px"> {{number_format($row->Total_Promise - $row->Sum_Promise,2)}} &nbsp;</td>
            <td align="center" style="width: 55px"> {{number_format($row->Sum_Promise,2)}} &nbsp;</td>
            <td align="center" style="width: 50px"> {{number_format($row->DuePay_Promise,2)}} &nbsp; </td>
            <td align="center" style="width: 65px">
              @foreach($dataPay as $key => $value)
                @if($row->legisPromise_id == $value->legis_Com_Payment_id)
                      {{DateThai($value->Date_Payment)}}
                @endif
              @endforeach
            </td>
            <td align="center" style="width: 55px">
              @php
                @$sumTotal += $row->Total_Promise;
                @$sumRemain += $row->Sum_Promise;
                $lastday = date('Y-m-d', strtotime("-90 days"));
              @endphp
              @if($row->Status_legis == "ปิดบัญชีประนอมหนี้" or $row->Status_legis == "ยึดรถหลังฟ้อง")
                <button type="button" class="btn btn-success btn-sm" title="ปิดบัญชี">
                  <span class="glyphicon glyphicon-ok prem"></span> ปิดบัญชี
                </button>
              @else
                @foreach($dataPay as $key => $value)
                  @if($row->legisPromise_id == $value->legis_Com_Payment_id)
                       @if($value->Date_Payment < $lastday)
                        <font color="red"> ขาดชำระ </font>
                       @else
                        <font color="green"> ชำระปกติ </font>
                       @endif
                     @endif
                @endforeach
              @endif
            </td>
          </tr>
          @endforeach
      </table>
      <table border="0" style="background-color:yellow;">
        <tr>
          <td align="center" style="width: 261px">รวมยอดประนอมหนี้ {{number_format(@$sumTotal,2)}} บาท&nbsp;</td>
          <td align="center" style="width: 250px">รวมยอดชำระแล้ว  {{number_format(@$sumTotal - @$sumRemain,2)}} บาท&nbsp;</td>
          <td align="center" style="width: 265px">รวมยอดคงเหลือ  {{number_format(@$sumRemain,2)}} บาท&nbsp;</td>
        </tr>
      </table>
    </body>
  @elseif($type == 10)
   <body>
     <br>
     <table border="1">
       <thead>
         <tr align="center" style="background-color: yellow;">
           <th style="width: 30px">ลำดับ</th>
           <th style="width: 60px">วันที่รับเรื่อง</th>
           <th>เลขที่สัญญา</th>
           <th style="width: 110px">ชื่อ-สกุลผู้เช่าซื้อ</th>
           <th style="width: 110px">ชื่อผู้ต้องหา</th>
           <th style="width: 50px">ข้อหา</th>
           <th style="width: 110px">ชื่อ พนง.สอบสวน</th>
           <th style="width: 60px">โทรศัพท์</th>
           <th style="width: 50px">สถานีภูธร</th>
           <th style="width: 50px">บอกเลิก</th>
           <th style="width: 100px">ประเภท</th>
         </tr>
       </thead>
       <tbody>
         @foreach($data as $key => $row)
         <tr>
           <td align="center" style="width: 30px">{{$key+1}}</td>
           <td align="center" style="width: 60px">{{DateThai($row->Dateaccept_legis)}}</td>
           <td align="center">{{$row->Contract_legis}}</td>
           <td style="width: 110px"> {{$row->Name_legis}}</td>
           <td style="width: 110px"> {{$row->Suspect_legis}}</td>
           <td align="center" style="width: 50px"> {{$row->Plaint_legis}}</td>
           <td style="width: 110px"> {{$row->Inquiryofficial_legis}}</td>
           <td align="center" style="width: 60px"> {{$row->Inquiryofficialtel_legis}}</td>
           <td align="center" style="width: 50px"> {{$row->Policestation_legis}}</td>
           <td align="center" style="width: 50px"> {{$row->Terminate_legis}}</td>
           <td align="center" style="width: 100px"> {{$row->Typeexhibit_legis}}</td>
         </tr>
         @endforeach
       </tbody>
     </table>
   </body>
  @elseif($type == 15)
    <body style="margin-top: 0 0 0px;">
      <table border="0">
        <tbody>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>เลขที่สัญญา :</b></th>
            <th width="10px"></th>
            <th width="180px" align="left">{{ iconv('Tis-620','utf-8',str_replace(" ","",$data->CONTNO)) }}</th>
            <th width="50px" align="right"><b>ยี่ห้อ :</b></th>
            <th width="10px"></th>
            <th width="70px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->TYPE))}}</th>
            <th width="50px" align="right"><b>ป้ายทะเบียน :</b></th>
            <th width="10px"></th>
            <th width="100px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->REGNO))}}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ชื่อ - นามสกุล : </b></th>
            <th width="10px"></th>
            <th width="180px" align="left">{{ iconv('Tis-620','utf-8',str_replace(" ","",$data->SNAM.$data->NAME1)."   ".str_replace(" ","",$data->NAME2)) }}</th>
            <th width="50px" align="right"><b>สี :</b></th>
            <th width="10px"></th>
            <th width="90px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->COLOR))}}</th>
            <th width="30px" align="right"><b>แบบ :</b></th>
            <th width="10px"></th>
            <th width="100px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->BAAB))}}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ที่อยู่ :</b></th>
            <th width="10px"></th>
            <th width="180px" align="left">
              {{iconv('Tis-620','utf-8',str_replace(" ","",$data->ADDRES))." ต.".iconv('Tis-620','utf-8',str_replace(" ","",$data->TUMB))." อ.".iconv('Tis-620','utf-8',str_replace(" ","",$data->AUMPDES))
                ." จ.".iconv('Tis-620','utf-8',str_replace(" ","",$data->PROVDES))."  ". $data->ZIP}}
            </th>
            <th width="50px" align="right"><b>เลขตัวถัง :</b></th>
            <th width="10px"></th>
            <th width="230px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->STRNO))}}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>โทรศัพท์ : </b></th>
            <th width="10px"></th>
            <th width="180px" align="left">{{ iconv('Tis-620','utf-8',str_replace(" ","",$data->TELP)) }}</th>
            <th width="50px" align="right"><b>เลขตัวเครื่อง :</b></th>
            <th width="10px"></th>
            <th width="70px">{{iconv('Tis-620','utf-8',str_replace(" ","",$data->ENGNO))}}</th>
          </tr>
          <tr style="line-height:150%;">
            <th></th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>ยอดประนอมหนี้ : </b></th>
            <th width="10px"></th>
            <th width="50px" align="left">{{ number_format($dataDB[0]->Total_Promise, 2) }}</th>
            <th width="50px" align="right"><b>งวดละ :</b></th>
            <th width="10px"></th>
            <th width="70px">{{ number_format($dataDB[0]->DuePay_Promise, 2) }}</th>
          </tr>
          <tr style="line-height:150%;">
            <th width="80px" align="right"><b>จำนวนงวด : </b></th>
            <th width="10px"></th>
            <th width="50px" align="left">{{ $dataDB[0]->Due_Promise }} งวด</th>
            <th width="50px" align="right"><b>ประนอมที่ :</b></th>
            <th width="10px"></th>
            <th width="70px">{{ $dataDB[0]->Type_Promise }}</th>
          </tr>
        </tbody>
      </table>
      <br><br>

      <!-- หัวเรื่อง -->
      <table border="0" align="center">
        <tr align="center" style="line-height: 250%;">
          <th align="center" width="50px" style="background-color: #33FF00;"><b>ลำดับ</b></th>
          <th align="center" width="90px" style="background-color: #BEBEBE;"><b>ค่างวด</b></th>
          <th align="center" width="90px" style="background-color: #BEBEBE;"><b>เลขที่ใบเสร็จ</b></th>
          <th align="center" width="90px" style="background-color: #BEBEBE;"><b>วันที่ชำระ</b></th>
          <th align="center" width="110px" style="background-color: #BEBEBE;"><b>จำนวนรับ</b></th>
          <th align="center" width="130px" style="background-color: #BEBEBE;"><b>ผู้รับ</b></th>
        </tr>
      </table>

      @php
        $SetCountPrice = 0;
        $SetSumPrice = 0;
        $SetDiscount = 0;
      @endphp

      <!-- เนื้อหา -->
      <table border="0" align="center">
        <tbody>
          @foreach($dataDB as $key => $value)
            @php
                $SetCountPrice = $SetCountPrice + $value->Gold_Payment;
                $SetSumPrice = $value->Sum_Promise;
                $SetDiscount = $value->Discount_Promise;
            @endphp
            <tr align="center" style="line-height: 180%;">
              <td width="50px">{{ $key+1 }}</td>
              <td width="90px">{{ number_format($value->DuePay_Promise, 2) }}</td>
              <td width="90px">{{ $value->Jobnumber_Payment }}</td>
              <td width="90px">{{ $value->Date_Payment }}</td>
              <td width="110px">{{ number_format($value->Gold_Payment, 2) }}</td>
              <td width="130px">{{ $value->Adduser_Payment }}</td>
            </tr>
          @endforeach
          <tr style="line-height: 50%;">
              <td></td>
            </tr>
            <tr align="center" style="line-height: 250%;">
              <td width="140px" style="background-color: #FFFF00;"></td>
              <td width="90px" style="background-color: #FFFF00;">จำนวนงวดจ่ายจริง &nbsp;&nbsp;{{ $dataCount }} งวด</td>
              <td width="90px" style="background-color: #FFFF00;">ส่วนลด &nbsp;&nbsp;{{ number_format($SetDiscount, 2) }} บาท</td>
              <td width="110px" style="background-color: #FFFF00;">รวมยอดชำระ &nbsp;&nbsp;{{ number_format($SetCountPrice, 2) }} บาท</td>
              <td width="130px" style="background-color: #FFFF00;">รวมยอดคงเหลือ &nbsp;&nbsp;{{ number_format($SetSumPrice, 2) }} บาท</td>
            </tr>
        </tbody>
      </table>
    </body>
  @elseif($type == 20)
    <body>
      <br>
      <table border="1">
          <tr align="center" style="background-color: yellow;line-height: 150%;font-weight:bold;">
            <th style="width: 30px">ลำดับ</th>
            <th style="width: 70px">เลขที่สัญญา</th>
            <th style="width: 150px">ชื่อ - สกุล</th>
            <th style="width: 70px">วันที่รับชำระ</th>
            <th style="width: 70px">ยอดชำระ</th>
            <th style="width: 65px">ประเภทชำระ</th>
            <th style="width: 75px">เลขที่ใบเสร็จ</th>
            <th style="width: 130px">ผู้รับชำระ</th>
            <th style="width: 120px">หมายเหตุ</th>
          </tr>
          @foreach($data as $key => $row)
            @php
              @$sumTotal = $key+1;
              @$sumPayment += $row->Gold_Payment;
            @endphp
          <tr style="line-height: 110%;">
            <td align="center" style="width: 30px">{{$key+1}}</td>
            <td align="center" style="width: 70px">{{$row->Contract_legis}}</td>
            <td align="left" style="width: 150px">&nbsp;{{$row->Name_legis}}</td>
            <td align="center" style="width: 70px">{{DateThai(substr($row->created_at,0,10))}}</td>
            <td align="right" style="width: 70px">{{number_format($row->Gold_Payment,2)}} &nbsp;</td>
            <td align="center" style="width: 65px">{{$row->Type_Payment}}</td>
            <td align="center" style="width: 75px">{{$row->Jobnumber_Payment}}</td>
            <td align="left" style="width: 130px">&nbsp; {{$row->Adduser_Payment}}</td>
            <td align="left" style="width: 120px">&nbsp; {{$row->Note_Payment}}</td>
          </tr>
          @endforeach
      </table>
      <table border="1" style="background-color:#F6FEA1;">
        <tr>
          <td align="center" style="width: 100px"><b>รวม {{@$sumTotal}} รายการ</b></td>
          <td align="right" style="width: 220px"><b>รวมยอดชำระ </b></td>
          <td align="right" style="width: 70px"><b>{{number_format(@$sumPayment,2)}} </b></td>
          <td align="left" style="width: 390px"><b>บาท</b></td>
        </tr>
      </table>
    </body>
  @endif

</html>
