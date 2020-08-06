@php
  date_default_timezone_set('Asia/Bangkok');
  $Y = date('Y') + 543;
  $Y2 = date('Y') + 531;
  $m = date('m');
  $d = date('d');

  $time = date('H:i');
  $date = $Y.'-'.$m.'-'.$d;
  $date2 = $Y2.'-'.'01'.'-'.'01';
@endphp

<section class="content">
  <div class="card card-warning">
    <div class="card-header">
      <h4 class="card-title"><b>เพิ่มข้อมูลชำระ</b></h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>

    <div class="card-body">
      <form name="form2" action="{{ route('legislation.store',[$id, $type]) }}" method="post" id="formimage" enctype="multipart/form-data">
        @csrf

        <script>
          function adds(nStr){
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

          function sperate(){
            var input = document.getElementById('GoldPayment').value,   //ค่างวดรับชำระ
                inputCut = input.replace(",",""),
                def = document.getElementById('DuePrice').value,        //ค่างวดจากระบบ
                state = 0;
                round = Math.floor(input/def);
            
            for (var i = 1; i <= round; i++) {
              input -= def;
              state = 30 * i;
              console.log(i, def, state);
            }
            if (round == 0) {
              if (input > 0) {
                state += 30;
                console.log(i, input, state);
              }
              
            }

            var DatePay = document.getElementById('Datepay').value,
                Setdate = new Date(DatePay);

            Setdate.setDate(Setdate.getDate() + state);
            var dd = Setdate.getDate(),
                mm = Setdate.getMonth() + 1,
                yyyy = Setdate.getFullYear();

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
            console.log(result);

            document.form2.GoldPayment.value = adds(inputCut);
            document.getElementById('DatePayment').value = result;
          }
        </script>

        @if($data != NULL)
          <input type="hidden" id="Datepay" name="Datepay" class="form-control" value="{{ $data->Date_Payment }}"/>
          <input type="hidden" id="DuePrice" name="DuePrice" class="form-control" value="{{ $data->DuePay_Promise }}"/>
        @endif
        
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <label>วันที่ : </label>
                <input type="date" id="DatePayment" name="DatePayment" class="form-control" value="{{ date('Y-m-d') }}" style="width: 200px;"/>
                
                <label>ยอดชำระ :</label>
                <input type="text" name="GoldPayment" id="GoldPayment" class="form-control" value="" style="width: 200px;"  onchange="sperate();" maxlength="7"/>
              </div>

              <div class="col-md-6">
                <label>ประเภทชำระ : </label>
                <select name="TypePayment" class="form-control" style="width: 200px;" required>
                  <option value="" selected>--- ประเภทชำระ ---</option>
                  <option value="ชำระเงินสด">ชำระเงินสด</option>
                  <option value="ชำระผ่านโอน">ชำระผ่านโอน</option>
                  <option value="เงินก้อนแรก">เงินก้อนแรก</option>
                </select>

                <label>หมายเหตุ :</label>
                <input type="text" name="NotePayment" class="form-control" value="" style="width: 200px;"/>
                <input type="hidden" name="AdduserPayment" class="form-control" style="width: 200px;" value="{{ Auth::user()->name }}"/>
                <input type="hidden" name="FlagPayment" class="form-control" value="Y"/>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <br>
            <div class="form-inline">
              <button type="submit" class="btn btn-app" style="background-color:#189100; color:#FFFFFF;">
                <i class="fas fa-save"></i> Save
              </button>
              <a class="btn btn-app" href="{{ action('LegislationController@edit',[$id, 4]) }}" style="background-color:#DB0000; color:#FFFFFF;">
                <i class="fas fa-times"></i> ยกเลิก
              </a>
            </div>
          </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
      </form>
    </div>
  </div>
</section>