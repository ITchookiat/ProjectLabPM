<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

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

    <SCRIPT>
      function toggleOption(thisselect) {
          var selected = thisselect.options[thisselect.selectedIndex].value;
          toggleRow(selected);
      }

      function toggleRow(id) {
        var row = document.getElementById(id);
        if (row.style.display == '') {
          row.style.display = 'none';
        }
        else {
           row.style.display = '';
        }
      }

      function showRow(id) {
        var row = document.getElementById(id);
        row.style.display = '';
      }

      function hideRow(id) {
        var row = document.getElementById(id);
        row.style.display = 'none';
      }

      function hideAll() {
       hideRow('optionA');
       hideRow('optionB');
       hideRow('optionC');
       hideRow('optionD');
     }
    </SCRIPT>

  </head>
    <label align="right">วันที่ : <u>{{$date2}}</u></label>
    <h2 class="card-title p-3" align="center" style="font-weight: bold;line-height:1px;">รายงานขออนุมัติโอนเงินไฟแนนซ์</h2>
    <h4 class="card-title p-3" align="center">บริษัท ชูเกียรติลิสซิ่ง จำกัด</h4>
    <hr>
  <body>
    <br />
    <table border="1">
      <thead>
        <tr align="center" style="line-height: 250%;">
          <th align="center" width="50px" style="background-color: #33FF00;"><b>ยี่ห้อ</b></th>
          <th align="center" width="65px" style="background-color: #BEBEBE;"><b>แบบ</b></th>
          <th align="center" width="20px" style="background-color: #BEBEBE;"><b>สาขา</b></th>
          <th align="center" width="45px" style="background-color: #BEBEBE;"><b>ทะเบียน</b></th>
          <th align="center" width="35px" style="background-color: #BEBEBE;"><b>ยอดจัด</b></th>
          <th align="center" width="55px" style="background-color: #BEBEBE;"><b>เพิ่มเติม</b></th>
          <th align="center" width="40px" style="background-color: #FFFF00;"><b>คจช.ขนส่ง</b></th>
          <th align="center" width="25px" style="background-color: #FFFF00;"><b>อื่นๆ</b></th>
          <th align="center" width="35px" style="background-color: #FFFF00;"><b>ค่าประเมิน</b></th>
          <th align="center" width="25px" style="background-color: #FFFF00;"><b>อากร</b></th>
          <th align="center" width="35px" style="background-color: #FFFF00;"><b>การตลาด</b></th>
          <th align="center" width="45px" style="background-color: #BEBEBE;"><b>รวมค่าใช้จ่าย</b></th>
          <th align="center" width="35px" style="background-color: #BEBEBE;"><b>คงเหลือ</b></th>
          <th align="center" width="35px" style="background-color: #BEBEBE;"><b>หัก 1.5 %</b></th>
          <th align="center" width="110px" style="background-color: #BEBEBE;"><b>ผู้รับเงิน</b></th>
          <th align="center" width="110px" style="background-color: #BEBEBE;"><b>ผู้รับคอม</b></th>
          <th align="center" width="50px" style="background-color: #BEBEBE;"><b>รวม</b></th>
        </tr>
      </thead>
      <tbody>
        @php
          $countcar = 0;
          $sumArcsum = 0;
          $sumbalance = 0;
          $sumall = 0;
          $sumtopcar = 0;
          $sumtotalkprice = 0;
          $sumbalanceprice = 0;
          $sumcommitprice = 0;

          $dataCount = count($dataReport);
        @endphp

        @if($dataCount != 0)
          @foreach($dataReport as $key => $value)
            @php
              $countcar = $key+1;
              $sumtopcar += $value->Top_car;

              @$sumtotran_Price += str_replace(",","",$value->tran_Price);
              @$sumtoother_Price += str_replace(",","",$value->other_Price);
              $sumtotransport = $sumtotran_Price +  $sumtoother_Price;
              @$sumtocloseAccount_Price += str_replace(",","",$value->closeAccount_Price);

              @$sumtoevaluetion_Price += str_replace(",","",$value->evaluetion_Price);
              @$sumtomarketing_Price += str_replace(",","",$value->marketing_Price);
              @$sumtoduty_Price += str_replace(",","",$value->duty_Price);
              @$sumtototalk_Price += str_replace(",","",$value->totalk_Price);
              $sumtocompany = $sumtoevaluetion_Price + $sumtomarketing_Price + $sumtoduty_Price;

              $sumbalanceprice += str_replace(",","",$value->balance_Price);
              $sumcommitprice += str_replace(",","",$value->commit_Price);
            @endphp
            <tr align="center" style="line-height: 200%;">
              <td width="50px" rowspan="4" style="background-color: #33FF00; line-height:750%;">{{$value->Brand_car}}</td>
              <td width="65px" rowspan="4" style="line-height:750%;">{{$value->status_car}}</td>
              <td width="20px" rowspan="4" style="line-height:750%;">
                @if($value->branch_car == 'ปัตตานี')
                  ปน
                @elseif($value->branch_car == 'ยะลา')
                  ยล
                @elseif($value->branch_car == 'นราธิวาส')
                  นธ
                @elseif($value->branch_car == 'สายบุรี')
                  สบ
                @elseif($value->branch_car == 'โกลก')
                  กล
                @elseif($value->branch_car == 'เบตง')
                  บต
                @endif
              </td>
              @if($value->note_Price == Null)
              <td width="45px" rowspan="4" style="line-height:750%;">{{$value->License_car}}</td>
              @else
              <td width="45px" rowspan="3" style="line-height:500%;">{{$value->License_car}}</td>
              @endif
              <td width="35px" rowspan="4" style="line-height:750%;">{{number_format($value->Top_car)}}</td>
              <td width="55px">
                @if($value->act_Price != 0)
                  พรบ. {{number_format($value->act_Price)}}
                @endif
              </td>
              <td width="40px" rowspan="4" style="background-color: #FFFF00; line-height:750%;">{{number_format($value->tran_Price,0)}}</td>
              <td width="25px" rowspan="4" style="background-color: #FFFF00; line-height:750%;">{{number_format($value->other_Price,0)}}</td>
              <td width="35px" rowspan="4" style="background-color: #FFFF00; line-height:750%;">{{ $value->evaluetion_Price }}</td>
              <td width="25px" rowspan="4" style="background-color: #FFFF00; line-height:750%;">{{ $value->duty_Price }}</td>
              <td width="35px" rowspan="4" style="background-color: #FFFF00; line-height:750%;">{{ $value->marketing_Price }}</td>
              <td width="45px" rowspan="4" style="line-height:750%;">{{number_format($value->totalk_Price,0)}}</td>
              <td width="35px" rowspan="4" style="line-height:750%;">{{number_format($value->balance_Price,0)}}</td>
              <td width="35px" rowspan="4" style="line-height:750%;">{{number_format($value->commit_Price,2)}}</td>
              <td width="110px">{{$value->Payee_car}}</td>
              <td width="110px">{{$value->Agent_car}}</td>
              <td width="50px">
                @if($value->Accountbrance_car == $value->Accountagent_car and $value->Accountbrance_car != Null)
                  @php
                      $ArcSum = $value->balance_Price + $value->commit_Price;
                      $sumArcsum = $sumArcsum + $ArcSum;
                  @endphp
                  {{number_format($ArcSum,2)}}
                @elseif($value->Accountbrance_car == Null)
                  สด {{number_format($value->balance_Price,2)}}
                  @php
                  $sumArcsum = $sumArcsum + $value->balance_Price;
                  @endphp
                @else
                  รถ {{number_format($value->balance_Price,2)}}
                  @php
                  $sumArcsum = $sumArcsum + $value->balance_Price;
                  @endphp
                @endif
              </td>
            </tr>
            <tr align="center" style="line-height: 200%;">
              <td width="55px">
                @if($value->closeAccount_Price != 0)
                  ปิดบัญชี {{number_format($value->closeAccount_Price)}}
                @endif
              </td>
              <td width="110px">
                @if($value->Accountbrance_car != Null)
                  บัญชี :{{$value->Accountbrance_car}}
                @endif
              </td>
              <td width="110px">
                @if($value->Accountagent_car != Null)
                  บัญชี :{{$value->Accountagent_car}}
                @endif
              </td>
              <td width="50px">
                @if($value->Accountbrance_car != $value->Accountagent_car and $value->Accountagent_car != Null)
                  คอม {{ number_format($value->commit_Price,2) }}
                  @php
                    $sumbalance = $sumbalance + $value->commit_Price;
                  @endphp
                @elseif($value->Accountagent_car == Null and $value->Agent_car != Null)
                  สด {{number_format($value->commit_Price,2)}}
                  @php
                    $sumbalance = $sumbalance + $value->commit_Price;
                  @endphp
                @elseif($value->Accountagent_car == Null)
                @endif
              </td>
            </tr>
            <tr align="center" style="line-height: 200%;">
              <td width="55px">
                
              </td>
              <td width="110px">
                @if($value->Accountbrance_car != Null)
                  สาขา :{{$value->branchbrance_car}}
                @endif
              </td>
              <td width="110px">
                @if($value->Accountagent_car != Null)
                  สาขา :{{$value->branchAgent_car}}
                @endif
              </td>
              <td width="50px">

              </td>
            </tr>
            <tr align="center" style="line-height: 200%;">
              @if($value->note_Price == Null)
              @else
              <td width="45px" style="background-color: #FFFF00;">{{ $value->note_Price }}</td>
              @endif
              <td width="55px">
                @if($value->P2_Price != 0)
                  @if($value->P2_Price > 6900)
                    ซื้อป1 {{number_format($value->P2_Price)}}
                  @else
                    ซื้อป2+ {{number_format($value->P2_Price)}}
                  @endif
                @endif
              </td>
              <td width="110px">
                @if($value->Tellbrance_car != Null)
                  โทร : {{$value->Tellbrance_car}}
                @endif
              </td>
              <td width="110px">
                @if($value->Tellagent_car != Null)
                    โทร : {{$value->Tellagent_car}}
                @endif
              </td>
              <td width="50px" style="background-color: #00FF89;">
                @if($value->Approvers_car == 'อรุณวรรณ แก้วมลทิน')
                  อรุณวรรณ
                @elseif($value->Approvers_car == 'นายอำพัน ดือราแมหะยี')
                  อำพัน
                @elseif($value->Approvers_car == 'ศิราภรณ์ ขาวมะลิ')
                  ศิราภรณ์
                @elseif($value->Approvers_car == 'นายซอลาฮุดดีน ตอแก')
                  ซอลาฮุดดีน
                @endif
              </td>
            </tr>
            <br>
          @endforeach
          @php
            $sumall = $sumArcsum + $sumbalance;
          @endphp
            <!-- <tr align="center">
              <td width="115px" style="background-color: #FFFF00; line-height:250%;">รวมยอดจัดเป็นคัน    {{$countcar}}    คัน</td>
              <td width="100px" style="background-color: #00FFFF; line-height:250%;">รวมยอดจัดเป็นเงิน      {{number_format($sumtopcar,2)}}</td>
              <td width="120px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายขนส่ง     {{number_format($sumtotransport,2)}}</td>
              <td width="95px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายบริษัท     {{number_format($sumtototalk_Price - $sumtotransport,2)}}</td>
              <td width="115px" style="background-color: #00FFFF; line-height:250%;">รวมค่ารถ     {{number_format($sumbalanceprice,2)}}</td>
              <td width="110px" style="background-color: #00FFFF; line-height:250%;">รวมค่าคอม     {{number_format($sumcommitprice,2)}}</td>
              <td width="160px" style="background-color: #FFFF00; line-height:250%;">ยอดรวมอนุมัติ        {{number_format($sumall,2)}}</td>
            </tr> -->
            <tr align="center">
              <td width="215px" style="background-color: #FFFF00; line-height:250%;">รวมยอดจัดเป็นคัน    {{$countcar}}    คัน</td>
              <td width="330px" style="background-color: #00FFFF; line-height:250%;"></td>
              <!-- <td width="95px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายบริษัท     {{number_format($sumtocompany)}}</td> -->
              <!-- <td width="95px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายบริษัท     {{number_format($sumtototalk_Price - $sumtotransport - $sumtocloseAccount_Price,2)}}</td> -->
              <td width="110px" style="background-color: #FFFF00; line-height:250%;">รวมค่ารถ     {{number_format($sumbalanceprice,2)}}</td>
              <td width="160px" style="background-color: #FFFF00; line-height:250%;">รวมค่าคอม     {{number_format($sumcommitprice,2)}}</td>
            </tr>
            <tr align="center">
              <td width="215px" style="background-color: #FFFF00; line-height:250%;">รวมยอดจัดเป็นเงิน      {{number_format($sumtopcar,2)}}</td>
              <td width="120px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายขนส่ง     {{number_format($sumtotransport,2)}}</td>
              <td width="95px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายบริษัท     {{number_format($sumtototalk_Price - $sumtotransport,2)}}</td>
              <td width="115px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายทั้งหมด    {{number_format($sumtototalk_Price,2)}}</td>
              <td width="270px" style="background-color: #FFFF00; line-height:250%;">ยอดรวมอนุมัติ        {{number_format($sumall,2)}}</td>
            </tr>
        @endif
      </tbody>
    </table>

  </body>
</html>
