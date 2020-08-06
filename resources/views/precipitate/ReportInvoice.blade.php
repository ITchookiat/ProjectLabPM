<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    @php
      function DateThai($strDate){
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
      }
      function DateThai2($strDate){
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("" , "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
      }
    @endphp
    @if($type == 10)
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

        $thb = ($data->EXP_AMT*100+1)/100;
        $thb1 = ($PayAmount*100+1)/100;
        $thb2 = ($BalanceAmount*100+1)/100;
        $EXP_AMT = num2thai($thb);
        $Pay_Amount = num2thai($thb1);
        $Balance_Amount = num2thai($thb2);
      @endphp
    @endif
    <style>
      td.container > div {
          width: 100%;
          height: 100%;
          overflow:hidden;
      }
      td.container {
          height: 20px;
      }
    </style>
  </head>

  @if($type == 10)
    <br/>
      <h1 class="card-title p-3" align="center" style="line-height: 10px;"><b>บริษัท ชูเกียรติลิสซิ่ง จำกัด</b></h1>
      <h3 class="card-title p-3" align="center" style="letter-spacing: 0.3px;"><b>17/8 ม.4 ต.รูสะมิแล อ.เมือง จ.ปัตตานี   โทร. 073-450700-4 </b></h3>
    <hr>
  @elseif($type == 2 or $type == 4 or $type == 11 or $type == 12)
    <label align="right">วันที่ : <u>{{DateThai($date)}}</u></label>
    <h2 class="card-title p-3" align="center" style="line-height:5px;">รายงาน ใบแจ้งหนี้ (บริษัท ชูเกียรติลิสซิ่ง จำกัด)</h2>
  @endif
  <body>

    @if($type == 10)
      <br>
        <table border="0">
          @php
          $Date = date('Y-m-d');
          @endphp
          <tr style="line-height: 150%;">
            <td width="270px"> {{-- $data->CONTNO --}}</td>
            <td width="230px"> วันที่ {{DateThai2($Date)}} </td>
          </tr>
          <tr style="line-height: 20%;">
            <td width="500px"> </td>
          </tr>
          <tr style="letter-spacing: 0.2px;">
            <td width="30px">เรื่อง </td>
            <td width="200px">ขอยืนยันหนังสือบอกเลิกสัญญาฉบับเดิม</td>
            <td width="270px"></td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="30px">เรียน </td>
            <td width="150px">1. คุณ{{ str_replace('นางสาว','',str_replace('นาง','', str_replace('นาย','', iconv('TIS-620', 'utf-8', $data->NAME1." ".$data->NAME2)))) }}</td>
            <td width="320px">ผู้เช่าซื้อ</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="30px"> </td>
            <td width="150px">2. คุณ{{ str_replace('นางสาว','',str_replace('นาง','', str_replace('นาย','', iconv('TIS-620', 'utf-8', $data->NAME)))) }}</td>
            <td width="320px">ผู้ค้ำประกัน</td>
          </tr>
          <tr>
            <td width="500px"> </td>
          </tr>
          <tr style="line-height: 150%;letter-spacing: 0.15px;">
            <!-- <td width="30px"> </td> -->
            <td width="500px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              ตามที่คุณ{{ str_replace('นางสาว','',str_replace('นาง','', str_replace('นาย','', iconv('TIS-620', 'utf-8', $data->NAME1." ".$data->NAME2)))) }}
              ได้ตกลงทำสัญญาเช่าซื้อรถยนต์ยี่ห้อ {{ iconv('TIS-620', 'utf-8', $data->TYPE) }} หมายเลขทะเบียน {{ iconv('TIS-620', 'utf-8', $data->REGNO) }}
              หมายเลขตัวถัง {{$data->STRNO }} {{-- $New_STRNO --}} หมายเลขเครื่อง {{$data->ENGNO}} {{--$New_ENGNO--}}
              สี{{ iconv('TIS-620', 'utf-8', $data->COLOR) }} จากบริษัท ชูเกียรติลิสซิ่ง จำกัด ผู้ให้เช่าซื้อโดยการเช่าซื้อดังกล่าวได้มี
              คุณ{{ str_replace('นางสาว','',str_replace('นาง','', str_replace('นาย','', iconv('TIS-620', 'utf-8', $data->NAME)))) }}   เข้าค้ำประกัน
              ในกรณีที่ผู้เช่าซื้อละเมิดข้อสัญญา รายละเอียดท่านทั้งสองทราบดีอยู่แล้วนั้น
            </td>
          </tr>
          <tr style="line-height: 20%;">
            <td width="500px"></td>
          </tr>
          <tr style="line-height: 150%;letter-spacing: 0.15px;">
            <td width="500px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              ปรากฏว่า คุณ{{ str_replace('นางสาว','',str_replace('นาง','', str_replace('นาย','', iconv('TIS-620', 'utf-8', $data->NAME1." ".$data->NAME2)))) }}
              ผู้เช่าซื้อ ได้ผิดนัดไม่ชำระค่าเช่าซื้อตั้งแต่ งวดที่ {{$data->EXP_FRM}} ประจำวันที่ {{DateThai2($Datehold)}} เป็นต้นมา และยังคงค้างชำระรวมเป็นเงินทั้งสิ้น {{number_format($data->EXP_AMT, 0)}} บาท ({{$EXP_AMT}})
            </td>
          </tr>
          <tr style="line-height: 20%;">
            <td width="500px"> </td>
          </tr>
          <tr style="line-height: 150%;letter-spacing: 0.15px;">
            <td width="500px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              ต่อมาเมื่อวันที่ {{DateThai2($DatecancleContract)}} บริษัทฯ ได้ทำการบอกเลิกสัญญากับคุณ{{ str_replace('นางสาว','',str_replace('นาง','', str_replace('นาย','', iconv('TIS-620', 'utf-8', $data->NAME1." ".$data->NAME2)))) }}
              ผู้เช่าซื้อแล้ว และมี ผลให้สัญญาเลิกกันแล้ว คุณ{{ str_replace('นางสาว','',str_replace('นาง','', str_replace('นาย','', iconv('TIS-620', 'utf-8', $data->NAME1." ".$data->NAME2)))) }} จึงมีหน้าที่
              ต้องส่งมอบรถยนต์คืนในสภาพเรียบร้อยใช้การได้ดี ต่อมา เมื่อวันที่ {{DateThai2($AcceptDate)}} คุณ{{ str_replace('นางสาว','',str_replace('นาง','', str_replace('นาย','', iconv('TIS-620', 'utf-8', $data->NAME1." ".$data->NAME2)))) }}
              ก็ได้ชำระเงินจำนวน {{number_format($PayAmount)}} บาท ซึ่งปัจจุบันยังคงขาด อยู่อีกจำนวน {{number_format($BalanceAmount)}} บาท ({{$Balance_Amount}})
            </td>
          </tr>
          <tr style="line-height: 20%;">
            <td width="500px"> </td>
          </tr>
          <tr style="line-height: 150%;letter-spacing: 0.15px;">
            <td width="500px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              ฉะนั้น บริษัทฯยังคงถือเอาหนังสือบอกเลิกสัญญาฉบับลงวันที่ {{DateThai2($DatecancleContract)}} และท่านยังมีหน้าที่ต้องส่ง มอบรถยนต์คืนในสภาพเรียบร้อยใช้การได้ดี หากท่านทั้งสองยังเพิกเฉยไม่ส่งมอบรถยนต์หรือชำระหนี้ดังกล่าวอีก
              บริษัทฯ จำเป็นต้องดำเนินคดีกับท่านทั้งสองตามกฏหมายต่อไป
            </td>
          </tr>
          <tr>
            <td width="500px"> </td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="250px"> {{-- $data->CONTNO --}}</td>
            <td width="250px"> ขอแสดงความนับถือ </td>
          </tr>
          <tr>
            <td width="500px"> </td>
          </tr>
          <tr style="line-height: 150%;letter-spacing: 0.2px;">
            <td width="230px"> {{-- $data->CONTNO --}}</td>
            <td width="280px"> ( นางอรุณวรรณ   แก้วมลทิน ) </td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="255px"> {{-- $data->CONTNO --}}</td>
            <td width="240px"> ผู้รับมอบอำนาจ </td>
          </tr>
        </table>
    @elseif($type == 2 or $type == 4 or $type == 11 or $type == 12)
      @foreach($data as $key => $value)
        <h3 align="left"><u>ประวัติผู้เช่าซื้อ/กู้</u></h3>
        <br />
        <table border="0">
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>เลขที่สัญญา</b></td>
            <td width="80px">{{$value->CONTNO}}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>ชือ - สกุล</b></td>
            <td width="200px">{{ iconv('TIS-620', 'utf-8', $value->NAME1." ".$value->NAME2) }}</td>
            <td width="50px"><b>ชือเล่น</b></td>
            <td width="100px">{{ iconv('TIS-620', 'utf-8', $value->NICKNM) }}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>ที่อยู่</b></td>
            <td width="400px">{{ iconv('TIS-620', 'utf-8', $value->ADDRES) }}&nbsp;&nbsp;&nbsp;ตำบล{{ iconv('TIS-620', 'utf-8', $value->TUMB) }}&nbsp;&nbsp;&nbsp;อำเภอ{{ iconv('TIS-620', 'utf-8', $value->AUMPDES) }}&nbsp;&nbsp;&nbsp;จังหวัด{{ iconv('TIS-620', 'utf-8', $value->PROVDES) }}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>ทีทำงาน</b></td>
            <td width="200px">{{ iconv('TIS-620', 'utf-8', $value->CUSOFFIC) }}</td>
            <td width="50px"><b>เบอร์โทร</b></td>
            <td width="200px">{{$value->TELP}}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="50px"><b>หมายเหตุ</b></td>
            <td width="400px">{{ iconv('TIS-620', 'utf-8', $value->CUSMEMO) }}</td>
          </tr>
        </table>

        <h3 align="left"><u>ผู้ค่ำประกัน</u></h3>
        <br />
        <table border="0">
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>ชือ - สกุล</b></td>
            <td width="200px">{{ iconv('TIS-620', 'utf-8', $value->NAME) }}</td>
            <td width="50px"><b>ชือเล่น</b></td>
            <td width="100px">{{ iconv('TIS-620', 'utf-8', $value->NICKARMGAR) }}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>ที่อยู่</b></td>
            <td width="400px">{{ iconv('TIS-620', 'utf-8', $value->ADDARMGAR) }}&nbsp;&nbsp;&nbsp;ตำบล{{ iconv('TIS-620', 'utf-8', $value->TUMBARMGAR) }}&nbsp;&nbsp;&nbsp;อำเภอ{{ iconv('TIS-620', 'utf-8', $value->AUMARMGAR) }}&nbsp;&nbsp;&nbsp;จังหวัด{{ iconv('TIS-620', 'utf-8', $value->PROARMGAR) }}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>ทีทำงาน</b></td>
            <td width="200px">{{ iconv('TIS-620', 'utf-8', $value->OFFICARMGAR) }}</td>
            <td width="50px"><b>เบอร์โทร</b></td>
            <td width="200px">{{ iconv('TIS-620', 'utf-8', $value->TELPARMGAR) }}</td>
          </tr>
        </table>

        <h3 align="left"><u>รายละเอียดรถยนต์</u></h3>
        <br />
        <table border="0">
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>ยี่ห้อ</b></td>
            <td width="100px">{{ iconv('TIS-620', 'utf-8', $value->TYPE) }}</td>
            <td width="80px"><b>แบบ</b></td>
            <td width="100px">{{$value->MODEL}}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>สี</b></td>
            <td width="100px">{{ iconv('TIS-620', 'utf-8', $value->COLOR) }}</td>
            <td width="80px"><b>หมายเลขตัวถัง</b></td>
            <td width="200px">{{ iconv('TIS-620', 'utf-8', $value->STRNO) }}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>หมายเลขเครื่อง</b></td>
            <td width="100px">{{ iconv('TIS-620', 'utf-8', $value->ENGNO) }}</td>
            <td width="80px"><b>หมายเลขทะเบียน</b></td>
            <td width="100px">{{ iconv('TIS-620', 'utf-8', $value->REGNO) }}</td>
          </tr>
        </table>

        <h3 align="left"><u>รายละเอียดสัญญา</u></h3>
        <br />
        <table border="" width="100%">
            <tr style="line-height: 220%;">
                <td width="4%"></td>
                <!-- ฝั่งซ้าย -->
                <td width="33%">
                  <!-- บน -->
                  <table border="">
                    <tr>
                      <td width="100px"><b>วันทำสัญญา</b></td>
                      <td width="140px">{{DateThai($value->SDATE)}}</td>
                    </tr>
                    <tr>
                      <td width="100px"><b>จำนวนงวด</b></td>
                      <td width="140px">{{$value->T_NOPAY}}</td>
                    </tr>
                    <tr>
                      <td width="100px"><b>วันที่ผ่อนงวดแรก</b></td>
                      <td width="140px">{{DateThai($value->FDATE)}}</td>
                    </tr>
                    <tr>
                      <td width="100px"><b>วันที่ผ่อนงวดสุดท้าย</b></td>
                      <td width="140px">{{DateThai($value->LDATE)}}</td>
                    </tr>
                  </table>
                  <br>
                  <br>
                  <!-- ล่าง -->
                  <table style="border-top-style: dashed;border-bottom-style: dashed;border-left-style: dashed;border-right-style: dashed;">
                    <tr style="line-height: 220%;">
                      <td>
                        <table border="0">
                          <tr>
                            <td width="100px"><b>วันที่ชำระล่าสุด</b></td>
                            <td width="70px" align="right">{{DateThai($value->LPAYD)}}</td>
                          </tr>
                          <tr>
                            <td width="100px"><b>จำนวนเงินชำระล่าสุด</b></td>
                            <td width="70px" align="right">{{number_format($value->LPAYA, 2)}}</td>
                          </tr>
                          <tr>
                            <td width="100px"><b>ลูกหนี้คงเหลือ</b></td>
                            <td width="70px" align="right">{{number_format($value->BALANC - $value->SMPAY, 2)}}</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>

                <td width="10%"></td>
                <!-- ฝั่งขวา -->
                <td width="50%">
                  <table style="border-top-style: dashed;border-bottom-style: dashed;border-left-style: dashed;border-right-style: dashed;">
                    <tr style="line-height: 200%;">
                      <td>
                        <table border="0">
                          <tr>
                            <td width="10px"></td>
                            <td width="100px" colspan="2"><b>ผ่อนงวดละ</b></td>
                            <td width="90px" colspan="2" align="right">{{number_format($value->T_LUPAY, 2)}}</td>
                          </tr>
                          <tr>
                            <td width="10px"></td>
                            <td width="100px" colspan="2"><b>ชำระแล้ว</b></td>
                            <td width="90px" colspan="2" align="right">{{number_format($value->SMPAY, 2)}}</td>
                          </tr>
                          <tr>
                            <td width="10px"></td>
                            <td width="100px" colspan="2"><b>คงค้าง งวด</b></td>
                            <td width="90px" colspan="2" align="right">{{number_format($value->HLDNO, 2)}}</td>
                          </tr>
                          <tr>
                            <td width="10px"></td>
                            <td width="30px"><b>งวดที่ :</b></td>
                            <td width="70px" align="center">{{$value->EXP_FRM}}</td>
                            <td width="40px"><b>ถึงงวดที่ :</b></td>
                            <td width="50px" align="right">{{$value->EXP_TO}}</td>
                          </tr>
                          <tr>
                            <td width="10px"></td>
                            <td width="100px" colspan="2"><b>ยอดเงินคงค้าง</b></td>
                            <td width="90px" colspan="2" align="right">{{number_format($value->EXP_AMT, 2)}}</td>
                          </tr>
                          <tr>
                            <td width="10px"></td>
                            <td width="100px" colspan="2"><b>เบี้ยปรับ</b></td>
                            <td width="90px" colspan="2" align="right">{{number_format($SumPay, 2)}}</td>
                          </tr>
                          <tr>
                            <td width="10px"></td>
                            <td width="100px" colspan="2"><b>ค่าตาม+ค่าบอกเลิก</b></td>
                            <td width="90px" colspan="2" align="right">
                              @if($type == 2)
                                @if($value->HLDNO < 1.99)
                                  @php
                                    $Count = 1200 + 850;
                                  @endphp
                                @elseif($value->HLDNO < 2.99)
                                  @php
                                    $Count = 2400 + 850;
                                  @endphp
                                @elseif($value->HLDNO < 3.99)
                                  @php
                                    $Count = 3600 + 850;
                                  @endphp
                                @elseif($value->HLDNO < 4.69)
                                  @php
                                    $Count = 4800 + 850;
                                  @endphp
                                @endif
                                {{number_format($Count, 2)}}
                              @elseif($type == 4)
                                @if($value->HLDNO <= 4.99)
                                  @php
                                    $Count = 8800 + 850;
                                  @endphp
                                @elseif($value->HLDNO >= 5.00)
                                  @php
                                    $Count = 11000 + 850;
                                  @endphp
                                @endif
                                {{number_format($Count, 2)}}
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td width="10px"></td>
                            <td width="100px" colspan="2"><b>ค่าโนติส</b></td>
                            <td width="90px" colspan="2" align="right">
                              @php
                                $Notice = 0;
                              @endphp
                              @if($type == 2)
                                @php
                                  $Notice = 0;
                                @endphp
                              @elseif($type == 4)
                                @php
                                  $Notice = 1500;
                                @endphp
                              @endif
                              {{number_format($Notice, 2)}}
                            </td>
                          </tr>
                          <tr>
                            <td width="10px"></td>
                            <td width="100px" colspan="2"><b>รวมยอด</b></td>
                            <td width="90px" colspan="2" align="right">
                              @php
                                @$Sum = $value->EXP_AMT + $SumPay + $Count + $Notice;
                              @endphp
                              {{number_format($Sum, 2)}}
                            </td>
                          </tr>
                        </table>
                      </td>
                     </tr>
                  </table>
                </td>
            </tr>
        </table>

        <h3 align="left"><u>ผู้แนะนำ</u></h3>
        <br />
        <table border="0">
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>ชือ - สกุล</b></td>
            <td width="150px">{{ iconv('TIS-620', 'utf-8', $value->FNAME." ".$value->LNAME) }}</td>
            <td width="80px"><b>เลขผู้แนะนำ</b></td>
            <td width="80px">{{$value->MEMBERID}}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>ที่อยู่</b></td>
            <td width="400px">{{ iconv('TIS-620', 'utf-8', $value->ADDRESS) }}</td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="80px"><b>เบอร์โทร</b></td>
            <td width="80px">{{ iconv('TIS-620', 'utf-8', $value->TELPTBROKER) }}</td>
          </tr>
        </table>
        <table border="0">
          <tr style="line-height:10%;">
            <td></td>
          </tr>
          <tr style="line-height: 200%;">
            <td width="30px"></td>
            <td width="40px"><b>ผู้ติดตาม</b></td>
            <td width="190px">..............................................................</td>
            <td width="50px"><b>วันที่ส่งงาน</b></td>
            <td width="190px">......................................................................</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="30px"></td>
            <td width="50px"><b>ผลการตาม</b></td>
            <td width="460px">
              ...................................................................................
              ............................................................................
            </td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="30px"></td>
            <td width="50px"></td>
            <td width="460px">
              ...................................................................................
              ............................................................................
            </td>
          </tr>
        </table>
      @endforeach
    @endif

  </body>
</html>
