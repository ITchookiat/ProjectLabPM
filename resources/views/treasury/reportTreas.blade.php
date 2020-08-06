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

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

<!-- ส่วนหัว -->
  @if($type == 3)
    <label align="right">ปริ้นวันที่ : <u>{{ date('d-m-Y') }}</u></label>
    <h1 align="center" style="font-weight: bold;line-height:1px;"><b>รายงานอนุมัติการโอนเงิน</b></h1>
    <h3 align="center" style="font-weight: bold;line-height:10px;"><b>จากวันที่ {{DateThai($newfdate)}} ถึงวันที่ {{DateThai($newtdate)}}</b></h3>
    <hr>
  @endif

<!-- ส่วนข้อมูล -->
  @if($type == 3)
    <body>
      <br>
      <table border="1">
          <tr align="center" style="background-color: yellow;line-height: 200%;font-weight:bold;">
            <th style="width: 25px">ลำดับ</th>
            <th style="width: 50px">เลขที่สัญญา</th>
            <th style="width: 50px">ทะเบียน</th>
            <th style="width: 95px">ยอดจัด</th>
            <th style="width: 95px">ยอดโอน</th>
            <th style="width: 160px">ผู้โอน</th>
          </tr>
          @foreach($dataReport as $key => $row)
          {{-- <tr style="line-height: 200%;">
            <td align="center" style="width: 25px"> {{$key+1}}</td>
            <td align="center" style="width: 50px"> {{DateThai($row->Date_asset)}}</td>
            <td align="center" style="width: 50px"> {{$row->Contract_legis}}</td>
            <td align="left" style="width: 95px"> {{$row->Name_legis}}</td>
            <td align="left" style="width: 160px"> {{$row->Address_legis}}</td>
            <td align="center" style="width: 55px"> {{$row->Idcard_legis}}</td>
            <td align="left" style="width: 95px"> {{$row->NameGT_legis}}</td>
            <td align="left" style="width: 160px"> {{$row->AddressGT_legis}}</td>
            <td align="center" style="width: 55px"> {{$row->IdcardGT_legis}}</td>
            <td align="center" style="width: 65px">
              @foreach($SetaArry as $value)
                @if($value['id_status'] == $row->id)
                  {{$value['txt_status']}}
                @endif
              @endforeach
            </td>
          </tr> --}}
          @endforeach
      </table>
    </body>
  @endif

</html>
