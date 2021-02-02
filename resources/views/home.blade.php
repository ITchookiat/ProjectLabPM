@extends('layouts.master')
@section('title','Home')
@section('content')

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@200&display=swap');
  </style>

  <style>
    i:hover {
      color: blue;
    }
  </style>

  <style>
    @import url('https://fonts.googleapis.com/css?family=Roboto:300');
    section {
      width: 100%;
      height: 100vh;
      box-sizing: border-box;
      padding: 140px 0; 
      
    }

    .card {
      position: relative;
      min-width: 0px;
      height: auto;
      overflow: hidden;
      border-radius: 15px;
      margin: 0 auto;
      padding: 40px 20px;
      box-shadow: 0 10px 15px rgba(0,0,0,0.3);
      transition: .5s;
    }
    .card:hover {
      transform:scale(1.1);
    }
    .card_red, .card_red .title .fa {
      background: linear-gradient(-45deg, #ffec61, #f321d7);
    }
    .card_violet, .card_violet .title .fa  {
      background: linear-gradient(-45deg, #f403d1, #64b5f6);
    }
    .card_three, .card_three .title .fa  {
      background: linear-gradient(-45deg, #24ff72, #9a4eff);
    }

    .card:before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 40%;
      background: rgba(255, 255, 255, .1);
      z-index: 1;
      transform: skewY(-5deg) scale(1.5);
    }

    .title .fa {
      color: #fff;
      font-size: 60px;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      text-align: center;
      line-height: 100px;
      box-shadow: 0 10px 10px rgba(0, 0, 0, .1);
    }
    .title h2 {
      position: relative;
      margin: 20px 0 0;
      padding: 0;
      color: #fff;
      font-size: 28px;
      z-index: 2;
    }
    .price {
      position: relative;
      z-index: 2;
    }
    .price h4 {
      margin: 0;
      padding: 20px 0;
      color: #fff;
      font-size: 60px;
    }
    .option {
      position: relative;
      z-index: 2;
    }
    .option ul {
      margin: 0;
      padding: 0;
    }
    .option ul li {
      margin: 0 0 10px;
      padding: 0;
      list-style: none;
      color: #fff;
      font-size: 16px;
    }
    .card a {
      display: block;
      position: relative;
      z-index: 2;
      background-color: #fff;
      color: #262ff;
      min-width: 150px;
      height: 40px;
      text-align: center;
      margin: 20px auto 0;
      line-height: 40px;
      border-radius: 40px;
      font-size: 16px;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 5px 10px rgba(0,0,0, .1);
    }
    .card a:hover {
      
    }
  </style>

  @if(session()->has('success'))
    <script type="text/javascript">
      toastr.success('{{ session()->get('success') }}')
    </script>
  @endif

  <div class="pricing-header px-3 py-3 pt-md-3 pb-md-0 mx-auto text-center">
    <div class="card-tools">
      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก จัดไฟแนนท์" or auth::user()->type == "แผนก รถบ้าน")
        <a class="btn bg-warning btn-app float-right" data-toggle="modal" data-target="#modal-walkin" data-backdrop="static" data-keyboard="false" style="border-radius: 40px;">
          <span class="fas fa-users prem fa-5x"></span> <label class="prem">WALK IN</label>
        </a>
      @endif
    </div>
    {{-- <div align="center">
      <a href="{{ route('MasterAnalysis.index') }}?type={{1}}"><img class="img-responsive" src="{{ asset('dist/img/leasing03.png') }}" alt="User Image" style = "width: 53%"></a>
    </div> --}}
  </div>
  
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-6 col-md-6">
          <div class="card-body">
            <div class="card card_red text-center">
                <div class="title">
                  <i class="fa fa-product-hunt" aria-hidden="true"></i>
                  <h2 style="font-family: 'Prompt', sans-serif;">PLoan Agreement</h2>
                </div>
                <div class="price">
                  <h4></h4>
                </div>
                <div class="option text-left">
                  <div class="card-body">
                    <ul>
                      <li><a href="{{ route('MasterAnalysis.index') }}?type={{1}}"><i class="fas fa-car fa-lg pr-2"></i>สัญญาเงินกู้รถยนต์ P03</a></li>
                      <li><a href="{{ route('MasterAnalysis.index') }}?type={{3}}"><i class="fas fa-biking fa-lg pr-2"></i>สัญญาเงินกู้รถจักรยานยนต์ P04</a></li>
                      <li><a href="{{ route('MasterAnalysis.index') }}?type={{4}}"><i class="fas fa-user fa-lg pr-2"></i>สัญญาเงินกู้พนักงาน P07</a></li>
                    </ul>
                  </div>
                </div>
                {{-- <a href="#">View Now</a> --}}
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
          <div class="card-body">
            <div class="card card_violet text-center">
              <div class="title">
                <i class="fa fa-medium" aria-hidden="true"></i>
                <h2 style="font-family: 'Prompt', sans-serif;">Micro Agreement</h2>
              </div>
              <div class="price">
                <h4></h4>
              </div>
              <div class="option text-left">
                <div class="card-body">
                  <ul>
                    <li><a href="{{ route('MasterAnalysis.index') }}?type={{5}}"><i class="fas fa-car fa-lg pr-2"></i>สัญญาเงินกู้รถยนต์ P06</a></li>
                    <li><i aria-hidden="true"></i><br><br><br><br></li>
                  </ul>
                </div>
              </div>
              {{-- <a href="#">View Now</a> --}}
            </div>
          </div>
        </div>
        {{-- <div class="col-12 col-sm-4 col-md-4">
          <div class="card-body">
            <div class="card card_three text-center">
              <div class="title">
                <i class="fa fa-question" aria-hidden="true"></i>
                <h2>Standart</h2>
              </div>
              <div class="price">
                <h4><sup>$</sup>50</h4>
              </div>
              <div class="option">
                <ul>
                  <li><i class="fa fa-check" aria-hidden="true"></i>50 GB Space</li>
                  <li><i class="fa fa-check" aria-hidden="true"></i>5 Domain Names</li>
                  <li><i class="fa fa-check" aria-hidden="true"></i>20 Emails Addresse</li>
                  <li><i class="fa fa-times" aria-hidden="true"></i>Live Support</li>
                  </ul>
              </div>
              <a href="#">Order Now</a>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </div>

  <!-- Walkin modal -->
  <form name="form2" action="{{ route('MasterDataCustomer.store') }}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="modal fade" id="modal-walkin" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 20px 20px 20px 20px;">
              <div class="modal-header bg-warning" style="border-radius: 20px 20px 20px 20px;">
                <div class="col text-center">
                  <h6 class="modal-title"><i class="fas fa-users pr-1"></i> ลูกค้า WALK IN</h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">x</span>
                </button>
              </div>
              <div class="modal-body text-sm">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                        <label class="col-sm-4 col-form-label text-right"><font color="red">*** ป้ายทะเบียน :</font> </label>
                        <div class="col-sm-8">
                          <input type="text" name="Licensecar" class="form-control form-control-sm" placeholder="ป้อนป้ายทะเบียน" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ยี่ห้อรถ : </label>
                        <div class="col-sm-7">
                          <select name="Brandcar" class="form-control form-control-sm" required>
                            <option value="" selected style="color:red">--- ยี่ห้อรถยนต์ ------</option>
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
                            <option value="" style="color:red">--- ยี่ห้อรถจักรยานยนต์ ------</option>
                            <option value="HONDA">HONDA</option>
                            <option value="YAMAHA">YAMAHA</option>
                            <option value="KAWASAKI">KAWASAKI</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">รุ่นรถ : </label>
                        <div class="col-sm-8">
                          <input type="text" name="Modelcar" class="form-control form-control-sm" placeholder="ป้อนรุ่นรถ" />
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ประเภทรถ : </label>
                        <div class="col-sm-7">
                          <select id="Typecardetail" name="Typecardetail" class="form-control form-control-sm">
                            <option value="" selected style="color:red">--- ประเภทรถรถยนต์ ---</option>
                            <option value="รถกระบะ">รถกระบะ</option>
                            <option value="รถตอนเดียว">รถตอนเดียว</option>
                            <option value="รถเก๋ง/7ที่นั่ง">รถเก๋ง/7ที่นั่ง</option>
                            <option value="" style="color:red">--- ประเภทรถจักรยานยนต์ ------</option>
                            <option value="เกียร์ธรรมดา">เกียร์ธรรมดา</option>
                            <option value="รถออโตเมติก">รถออโตเมติก</option>
                            <option value="BigBike">BigBike</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right"><font color="red"> ยอดจัด : </font> </label>
                        <div class="col-sm-8">
                          <input type="text" id="topcar" name="Topcar" class="form-control form-control-sm" placeholder="ป้อนยอดจัด" oninput="addcomma();" maxlength="9" />
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ปีรถ : </label>
                        <div class="col-sm-7">
                          <select id="Yearcar" name="Yearcar" class="form-control form-control-sm">
                            <option value="" selected>--- เลือกปี ---</option>
                              @php
                                  $Year = date('Y');
                              @endphp
                              @for ($i = 0; $i < 20; $i++)
                                <option value="{{ $Year }}">{{ $Year }}</option>
                                @php
                                    $Year -= 1;
                                @endphp
                              @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ชื่อลูกค้า :</label>
                        <div class="col-sm-4">
                          <input type="text" name="Namebuyer" class="form-control form-control-sm" placeholder="ป้อนชื่อ" required/>
                        </div>
                        <div class="col-sm-4">
                          <input type="text" name="Lastbuyer" class="form-control form-control-sm" placeholder="นามสกุล" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ชื่อนายหน้า :</label>
                        <div class="col-sm-7">
                          <input type="text" name="Nameagent" class="form-control form-control-sm" placeholder="ป้อนชื่อนายหน้า"/>
                        </div>
                        <!-- <div class="col-sm-3">
                          <input type="text" name="Lastagent" class="form-control form-control-sm" placeholder="ป้อนสกุล"/>
                        </div> -->
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">เบอร์ลูกค้า :</label>
                        <div class="col-sm-8">
                          <input type="text" name="Phonebuyer" class="form-control form-control-sm" placeholder="ป้อนเบอร์ลูกค้า"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">เบอร์นายหน้า :</label>
                        <div class="col-sm-7">
                          <input type="text" name="Phoneagent" class="form-control form-control-sm" placeholder="ป้อนเบอร์นายหน้า"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">เลขบัตร ปชช :</label>
                        <div class="col-sm-8">
                          <input type="text" name="IDCardbuyer" class="form-control form-control-sm" placeholder="ป้อนเลขบัตร ปชช" maxlength="13"/>
                        </div>
                        <br><br>
                        <label class="col-sm-4 col-form-label text-right">ประเภทเงินกู้ :</label>
                        <div class="col-sm-8">
                          <select id="TypeLeasing" name="TypeLeasing" class="form-control form-control-sm" required>
                              <option value="" selected>--- เลือกประเภทเงินกู้ ---</option>
                              <option value="P03">P03 - สัญญาเงินกู้รถยนต์</option>
                              <option value="P04">P04 - สัญญาเงินกู้รถจักรยานยนต์</option>
                              <option value="P06">P06 - สัญญาเงินกู้ส่วนบุคคล</option>
                              <option value="P07">P07 - สัญญาเงินกู้พนักงาน</option>
                          </select>
                        </div>
                        <br><br>
                        <label class="col-sm-4 col-form-label text-right">ที่มาของลูกค้า :</label>
                        <div class="col-sm-8">
                        <select id="News" name="News" class="form-control form-control-sm" required>
                            <option value="" selected>--- เลือกแหล่งที่มา ---</option>
                            <option value="นายหน้าแนะนำ">นายหน้าแนะนำ</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Line">Line</option>
                            <option value="ป้ายโฆษณา">ป้ายโฆษณา</option>
                            <option value="วิทยุ">วิทยุ</option>
                            <option value="เพื่อนแนะนำ">เพื่อนแนะนำ</option>
                          </select>
                        </div>
                        <br><br>
                        <label class="col-sm-4 col-form-label text-right">สาขา :</label>
                        <div class="col-sm-8">
                          <select id="branchcar" name="branchcar" class="form-control form-control-sm" required>
                            <option value="" selected>--- เลือกสาขา ---</option>
                            <option value="ปัตตานี" {{ (auth::user()->branch == 50) ? 'selected' : '' }}>ปัตตานี(50)</option>
                            <option value="ยะลา" {{ (auth::user()->branch == 51) ? 'selected' : '' }}>ยะลา(51)</option>
                            <option value="นราธิวาส" {{ (auth::user()->branch == 52) ? 'selected' : '' }}>นราธิวาส(52)</option>
                            <option value="สายบุรี" {{ (auth::user()->branch == 53) ? 'selected' : '' }}>สายบุรี(53)</option>
                            <option value="โกลก" {{ (auth::user()->branch == 54) ? 'selected' : '' }}>โกลก(54)</option>
                            <option value="เบตง" {{ (auth::user()->branch == 55) ? 'selected' : '' }}>เบตง(55)</option>
                            <option value="โคกโพธิ์" {{ (auth::user()->branch == 56) ? 'selected' : '' }}>โคกโพธิ์(56)</option>
                            <option value="ตันหยงมัส" {{ (auth::user()->branch == 57) ? 'selected' : '' }}>ตันหยงมัส(57)</option>
                            <option value="รือเสาะ" {{ (auth::user()->branch == 58) ? 'selected' : '' }}>รือเสาะ(58)</option>
                            <option value="บังนังสตา" {{ (auth::user()->branch == 59) ? 'selected' : '' }}>บังนังสตา(59)</option>
                            <option value="ยะหา" {{ (auth::user()->branch == 60) ? 'selected' : '' }}>ยะหา(60)</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">หมายเหตุ :</label>
                        <div class="col-sm-7">
                          <textarea class="form-control" name="Notecar" rows="7" placeholder="ป้อนหมายเหตุ..."></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>

              <input type="hidden" name="Nameuser" value="{{auth::user()->name}}"/>

              <div style="text-align: center;">
                  <button type="submit" class="btn btn-success text-center" style="border-radius: 10px;">บันทึก</button>
                  <button type="button" class="btn btn-danger" style="border-radius: 10px;" data-dismiss="modal">ยกเลิก</button>
              </div>
              <br>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
  </form>

  <script>
      function blinker() {
      $('.prem').fadeOut(1500);
      $('.prem').fadeIn(1500);
      }
      setInterval(blinker, 1500);
  </script>

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
    function addcomma(){
      var num11 = document.getElementById('topcar').value;
      var num1 = num11.replace(",","");
      document.form2.topcar.value = addCommas(num1);
    }
  </script>
@endsection
