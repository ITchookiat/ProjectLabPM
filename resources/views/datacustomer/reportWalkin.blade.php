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
  </head>
    <label align="right">ปริ้นวันที่ : <u>{{DateThai2($datenow)}}</u></label>
    <h2 class="card-title p-3" align="center" style="line-height: 0px;">รายงาน Customer Walkin</h2>
    <!-- <h4 class="card-title p-3" align="center">บริษัท ชูเกียรติลิสซิ่ง จำกัด โทรศัพท์. ( 073-450-700 )</h4> -->
    <h4 class="card-title p-3" align="center">
          @if($newfdate != Null)
            จากวันที่ {{DateThai2($newfdate)}}
          @endif

          @if($newtdate != Null)
            ถึงวันที่ {{DateThai2($newtdate)}}
          @endif
      </h4>
    <hr>
  <body>
    <br />
    <table border="1">
      <thead>
        <tr align="center" style="line-height: 150%;">
          <th width="30px" align="center" style="background-color: #FFFF00;"><b>ลำดับ</b></th>
          <th width="70px" align="center" style="background-color: #FFFF00;"><b>วันที่</b></th>
          <th width="50px" align="center" style="background-color: #FFFF00;"><b>สาขา</b></th>
          <th width="75px" align="center" style="background-color: #FFFF00;"><b>ทะเบียน</b></th>
          <th width="65px" align="center" style="background-color: #FFFF00;"><b>ยี่ห้อรถ</b></th>
          <!-- <th width="35px" align="center" style="background-color: #FFFF00;"><b>ปีรถ</b></th> -->
          <th width="70px" align="center" style="background-color: #FFFF00;"><b>ยอดจัด</b></th>
          <th width="140px" align="center" style="background-color: #FFFF00;"><b>ชื่อ-สกุล</b></th>
          <th width="70px" align="center" style="background-color: #FFFF00;"><b>เบอร์ติดต่อ</b></th>
          <th width="80px" align="center" style="background-color: #FFFF00;"><b>แหล่งที่มา</b></th>
          <th width="70px" align="center" style="background-color: #33FF00;"><b>ประเภทเงินกู้</b></th>
          <th width="75px" align="center" style="background-color: #33FF00;"><b>ประเภท</b></th>
        </tr>
      </thead>
      <tbody>
        @php
          $countlist = 0;
          $sumtopcar = 0;
        @endphp

        @foreach($data as $key => $value)
           @php
            @$countlist = $key+1;
            @$sumtopcar += $value->Top_car; 
           @endphp
        <tr align="center" style="line-height: 150%;">
            <td width="30px">{{$key+1}}</td>
            <td width="70px">{{DateThai(substr($value->created_at,0,10))}}</td>
            <td width="50px">{{$value->Branch_car}}</td>
            <td width="75px">{{$value->License_car}}</td>
            <td width="65px">{{($value->Brand_car != null)?$value->Brand_car: '-'}}</td>
            <!-- <td width="35px">{{($value->Year_car != null)?$value->Year_car: '-'}}</td> -->
            <td width="70px" align="right">{{number_format($value->Top_car,0)}} &nbsp;</td>
            <td width="140px" align="left"> {{$value->Name_buyer}}&nbsp;{{$value->Last_buyer}}</td>
            <td width="70px">{{substr(($value->Phone_buyer != null)?$value->Phone_buyer: '-',0,11)}}</td>
            <td width="80px" align="left"> {{$value->Resource_news}}</td>
            <td width="70px" align="center"> {{$value->Type_leasing}}</td>
            <td width="75px" align="left">
                @if($value->Status_leasing == '1')
                    ลูกค้าสอบถาม
                @elseif($value->Status_leasing == '2')
                    ลูกค้าจัดสินเชื่อ
                @endif
            </td>
        </tr>
        @endforeach
        <br>
        <tr align="center" style="background-color: #BEBEBE; line-height:150%;">
            <td width="100px">รวม {{$countlist}} ราย</td>
            <td width="190px" align="right">รวมยอดจัด &nbsp;</td>
            <td width="70px" align="right">{{number_format($sumtopcar,0)}} &nbsp;</td>
            <td width="435px" align="left">&nbsp;บาท</td>
        </tr>
      </tbody>
    </table>

  </body>
</html>
