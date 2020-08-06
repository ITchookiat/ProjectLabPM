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
    <h2 class="card-title p-3" align="center">รายงานขออนุมัติมาตรการช่วยเหลือ Covid-19</h2>
    <h4 class="card-title p-3" align="center">บริษัท ชูเกียรติลิสซิ่ง จำกัด โทรศัพท์. ( 073-450-700 )</h4>
    <hr>
  <body>
    <br />
    <table border="1">
      <thead>
        <tr align="center" style="line-height: 250%;">
          <th width="60px" align="center" style="background-color: #33FF00;"><b>เลขที่สัญญาเดิม</b></th>
          <th width="90px" align="center" style="background-color: #BEBEBE;"><b>มาตรการ</b></th>
          <th width="100px" align="center" style="background-color: #BEBEBE;"><b>เจ้าหน้าที่</b></th>
          <th width="50px" align="center" style="background-color: #BEBEBE;"><b>ทะเบียน</b></th>
          <th width="60px" align="center" style="background-color: #BEBEBE;"><b>ยี่ห้อ</b></th>
          <th width="30px" align="center" style="background-color: #FFFF00;"><b>ปีรถ</b></th>
          <th width="80px" align="center" style="background-color: #FFFF00;"><b>ยอดจัด</b></th>
          <th width="50px" align="center" style="background-color: #FFFF00;"><b>ค่างวด</b></th>
          <th width="50px" align="center" style="background-color: #FFFF00;"><b>ระยะเวลา</b></th>
          <th width="50px" align="center" style="background-color: #FFFF00;"><b>ดอกเบี้ย</b></th>
          <th width="50px" align="center" style="background-color: #BEBEBE;"><b>VAT</b></th>
          <th width="80px" align="center" style="background-color: #BEBEBE;"><b>ยอดผ่อนรวม</b></th>
          <th width="60px" align="center" style="background-color: #BEBEBE;"><b>วันชำระงวดแรก</b></th>
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
            $sumtotalkprice += str_replace(",","",$value->totalk_Price);
            $sumbalanceprice += str_replace(",","",$value->balance_Price);
            $sumcommitprice += str_replace(",","",$value->commit_Price);
          @endphp
          <tr align="center" style="line-height: 250%;">
            <td width="60px">{{$value->Note_car}}</td>
            <td width="90px">{{$value->Objective_car}}</td>
            <td width="100px" align="left"> {{$value->Loanofficer_car}}</td>
            <td width="50px">{{$value->License_car}}</td>
            <td width="60px">{{$value->Brand_car}}</td>
            <td width="30px">{{$value->Year_car}}</td>
            <td width="80px">{{number_format($value->Top_car,2)}}</td>
            <td width="50px">{{$value->Pay_car}}</td>
            <td width="50px">{{$value->Timeslacken_car}}</td>
            <td width="50px">{{$value->Interest_car}} %</td>
            <td width="50px">{{$value->Vat_car}}</td>
            <td width="80px">{{$value->Totalpay1_car}}</td>
            <td width="60px">
              @php
                $DateFirst = date_create($value->Dateduefirst_car);
                $NewDateFirst = date_format($DateFirst, 'd-m-Y');
              @endphp
              {{$NewDateFirst}}
            </td>
          </tr>
          {{--
          <tr align="center" style="line-height: 200%;">
            <td width="50px" rowspan="3" style="background-color: #33FF00; line-height:550%;">{{$value->Brand_car}}</td>
            <td width="25px" rowspan="2" style="line-height:450%;">
              @if($value->branch_car == 'ปัตตานี')
                ปน
              @elseif($value->branch_car == 'ยะลา')
                ยล
              @elseif($value->branch_car == 'นราธิวาส')
                นธ
              @elseif($value->branch_car == 'สายบุรี')
                สบ
              @elseif($value->branch_car == 'สุไหงโก-ลก')
                กล
              @elseif($value->branch_car == 'เบตง')
                บต
              @endif
            </td>
            <td width="50px" rowspan="2" style="line-height:450%;">{{$value->License_car}}</td>
            <td width="40px" rowspan="2" style="line-height:450%;">{{number_format($value->Top_car)}}</td>
            <td width="60px">
              @if($value->act_Price != 0)
                พรบ. {{number_format($value->act_Price)}}
              @endif
            </td>
            <td width="40px" rowspan="3" style="background-color: #FFFF00; line-height:550%;">{{number_format($value->tran_Price)}}</td>
            <td width="30px" rowspan="3" style="background-color: #FFFF00; line-height:550%;">{{number_format($value->other_Price)}}</td>
            <td width="40px" rowspan="3" style="background-color: #FFFF00; line-height:550%;">{{ $value->evaluetion_Price }}</td>
            <td width="30px" rowspan="3" style="background-color: #FFFF00; line-height:550%;">{{ $value->duty_Price }}</td>
            <td width="40px" rowspan="3" style="background-color: #FFFF00; line-height:550%;">{{ $value->marketing_Price }}</td>
            <td width="50px" rowspan="3" style="line-height:550%;">{{number_format($value->totalk_Price)}}</td>
            <td width="40px" rowspan="3" style="line-height:550%;">{{number_format($value->balance_Price)}}</td>
            <td width="35px" rowspan="3" style="line-height:550%;">{{number_format($value->commit_Price)}}</td>
            <td width="105px">{{$value->Payee_car}}</td>
            <td width="105px">{{$value->Agent_car}}</td>
            <td width="50px">
              @if($value->Accountbrance_car == $value->Accountagent_car and $value->Accountbrance_car != Null)
                @php
                    $ArcSum = $value->balance_Price + $value->commit_Price;
                    $sumArcsum = $sumArcsum + $ArcSum;
                @endphp
                {{number_format($ArcSum)}}
              @elseif($value->Accountbrance_car == Null)
                สด {{number_format($value->balance_Price)}}
                @php
                $sumArcsum = $sumArcsum + $value->balance_Price;
                @endphp
              @else
                รถ {{number_format($value->balance_Price)}}
                @php
                $sumArcsum = $sumArcsum + $value->balance_Price;
                @endphp
              @endif
            </td>
          </tr>
          <tr align="center" style="line-height: 200%;">
            <td width="60px">
              @if($value->closeAccount_Price != 0)
                ปิดบัญชี {{number_format($value->closeAccount_Price)}}
              @endif
            </td>
            <td width="105px">
              @if($value->Accountbrance_car != Null)
                บัญชี :{{$value->Accountbrance_car}}/{{$value->branchbrance_car}}
              @endif
            </td>
            <td width="105px">
              @if($value->Accountagent_car != Null)
                บัญชี :{{$value->Accountagent_car}}/{{$value->branchAgent_car}}
              @endif
            </td>
            <td width="50px">
              @if($value->Accountbrance_car != $value->Accountagent_car and $value->Accountagent_car != Null)
                คอม {{ number_format($value->commit_Price) }}
                @php
                  $sumbalance = $sumbalance + $value->commit_Price;
                @endphp
              @elseif($value->Accountagent_car == Null and $value->Agent_car != Null)
                สด {{number_format($value->commit_Price)}}
                @php
                  $sumbalance = $sumbalance + $value->commit_Price;
                @endphp
              @elseif($value->Accountagent_car == Null)
              @endif
            </td>
          </tr>
          <tr align="center" style="line-height: 200%;">
            <td colspan="3"> <b>{{$value->status_car}}</b></td>
            <td width="60px">
              @if($value->P2_Price != 0)
                @if($value->P2_Price > 6700)
                  ซื้อป1 {{number_format($value->P2_Price)}}
                @else
                  ซื้อป2+ {{number_format($value->P2_Price)}}
                @endif
              @endif
            </td>
            <td width="105px">
              @if($value->Tellbrance_car != Null)
                โทร : {{$value->Tellbrance_car}}
              @endif
            </td>
            <td width="105px">
              @if($value->Tellagent_car != Null)
                  โทร : {{$value->Tellagent_car}}
              @endif
            </td>
            <td width="50px"></td>
          </tr>
          --}}
          <br>
        @endforeach
        @php
          $sumall = $sumArcsum + $sumbalance;
        @endphp
          <tr align="center" style="line-height: 200%;">
            <td width="150px" style="background-color: #FFFF00; line-height:250%;">รวมยอดจัดเป็นคัน    {{$countcar}}    คัน</td>
            <td width="100px" style="background-color: #00FFFF; line-height:250%;"></td>
            <td width="110px" style="background-color: #00FFFF; line-height:250%;"></td>
            <td width="110px" style="background-color: #00FFFF; line-height:250%;">รวมยอดจัดเป็นเงิน      {{number_format($sumtopcar)}}</td>
            <td width="100px" style="background-color: #00FFFF; line-height:250%;"></td>
            <td width="100px" style="background-color: #00FFFF; line-height:250%;"></td>
            <td width="140px" style="background-color: yellow; line-height:250%;">ยอดรวมอนุมัติ        {{number_format($sumall)}}</td>
          </tr>
      @endif
      </tbody>
    </table>

  </body>
</html>
