@extends('layouts.master')
@section('title','Home')
@section('content')

<style>
  i:hover {
    color: blue;
  }
</style>

<div class="content-header">
  <div class="row justify-content-center">
    <div class="col-md-12 table-responsive">
      <div class="card">
        <div class="card-body">
          @if(session()->has('success'))
            <script type="text/javascript">
              toastr.success('{{ session()->get('success') }}')
            </script>
          @endif


          <div class="row mb-0">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">LAB PLoan-Micro</h1>
            </div>
            <div class="col-sm-6">
              @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก จัดไฟแนนท์" or auth::user()->type == "แผนก รถบ้าน")
                <a class="btn bg-warning btn-app float-right" data-toggle="modal" data-target="#modal-walkin" data-backdrop="static" data-keyboard="false" style="border-radius: 40px;">
                  <span class="fas fa-users prem fa-5x"></span> <label class="prem">WALK IN</label>
                </a>
              @endif
            </div>
          </div>

          <div align="center">
            <img class="img-responsive" src="{{ asset('dist/img/leasing03.png') }}" alt="User Image" style = "width: 43%">
          </div>

          <div class="row">
            {{-- <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h2>ระบบสินเชื่อ</h2>
                  <br><br>
                </div>
                @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก จัดไฟแนนท์" or auth::user()->type == "แผนก รถบ้าน" or auth::user()->type == "แผนก การเงินใน")
                <div class="icon">
                  <i class="a1 fa fa-sitemap" data-toggle="modal" data-target="#modal-default" style="cursor: pointer;"></i>
                </div>
                @endif
                <a href="#" class="small-box-footer">เพิ่มเติม <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h2>แผนกการเงิน</h2>
                  <br><br>
                </div>
                @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก เร่งรัด" or auth::user()->type == "แผนก กฏหมาย")
                <div class="icon">
                  <i class="a1 fas fa-gavel" data-toggle="modal" data-target="#modal-legislation" style="cursor: pointer;"></i>
                </div>
                @endif
                <a href="#" class="small-box-footer">เพิ่มเติม <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div> --}}
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

  <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" >
        <div class="modal-header">
          <div class="col text-center">
            <h4 class="modal-title">ระบบสินเชื่อ</h4>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก จัดไฟแนนท์" or auth::user()->type == "แผนก รถบ้าน" or auth::user()->type == "แผนก การเงินใน")
              @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก จัดไฟแนนท์" or auth::user()->type == "แผนก การเงินใน" or auth::user()->branch == 01 or auth::user()->branch == 03 or auth::user()->branch == 04 or auth::user()->branch == 05 or auth::user()->branch == 06 or auth::user()->branch == 07)
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="info-box bg-blue">
                    <span class="info-box-icon bg-blue">
                      <span class="info-box-icon">
                        <a href="{{ route('Analysis',1) }}" class="a1"><i class="fas fa-id-card fa-2x"></i></a>
                      </span>
                    </span>
                    <div class="info-box-content">
                      <span class="info-box-text"><br /></span>
                      <span class="info-box-number">เช่าซื้อ</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                        <span class="progress-description">
                          {{-- จำนวนรถที่อนุมัติ {{ $datafinance }} คัน --}}
                        </span>
                    </div>
                  </div>
                </div>
              @endif
            @endif
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>

  <!-- Walkin modal -->
  <form name="form2" action="{{ route('MasterDataCustomer.store') }}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="modal fade" id="modal-walkin" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 30px 30px 30px 30px;">
              <div class="modal-header bg-warning" style="border-radius: 30px 30px 30px 30px;">
                <div class="col text-center">
                  <h5 class="modal-title"><i class="fas fa-users"></i> ลูกค้า WALK IN</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">x</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                        <label class="col-sm-5 col-form-label text-right"><font color="red">*** ป้ายทะเบียน :</font> </label>
                        <div class="col-sm-7">
                          <input type="text" name="Licensecar" class="form-control" placeholder="ป้อนป้ายทะเบียน" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ยี่ห้อรถ : </label>
                        <div class="col-sm-7">
                          <select name="Brandcar" class="form-control">
                            <option value="" selected>--- ยี่ห้อ ---</option>
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
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right">รุ่นรถ : </label>
                        <div class="col-sm-7">
                          <input type="text" name="Modelcar" class="form-control" placeholder="ป้อนรุ่นรถ" />
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ประเภทรถ : </label>
                        <div class="col-sm-7">
                          <select id="Typecardetail" name="Typecardetail" class="form-control">
                            <option value="" selected>--- ประเภทรถ ---</option>
                            <option value="รถกระบะ">รถกระบะ</option>
                            <option value="รถตอนเดียว">รถตอนเดียว</option>
                            <option value="รถเก๋ง/7ที่นั่ง">รถเก๋ง/7ที่นั่ง</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right"><font color="red"> ยอดจัด : </font> </label>
                        <div class="col-sm-7">
                          <input type="text" id="topcar" name="Topcar" class="form-control" placeholder="ป้อนยอดจัด" oninput="addcomma();" maxlength="9" />
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ปีรถ : </label>
                        <div class="col-sm-7">
                          <select id="Yearcar" name="Yearcar" class="form-control">
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
                      <label class="col-sm-5 col-form-label text-right">ชื่อลูกค้า :</label>
                        <div class="col-sm-4">
                          <input type="text" name="Namebuyer" class="form-control" placeholder="ป้อนชื่อ"/>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" name="Lastbuyer" class="form-control" placeholder="นามสกุล"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">ชื่อนายหน้า :</label>
                        <div class="col-sm-7">
                          <input type="text" name="Nameagent" class="form-control" placeholder="ป้อนชื่อนายหน้า"/>
                        </div>
                        <!-- <div class="col-sm-3">
                          <input type="text" name="Lastagent" class="form-control" placeholder="ป้อนสกุล"/>
                        </div> -->
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right">เบอร์ลูกค้า :</label>
                        <div class="col-sm-7">
                          <input type="text" name="Phonebuyer" class="form-control" placeholder="ป้อนเบอร์ลูกค้า"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right">เบอร์นายหน้า :</label>
                        <div class="col-sm-7">
                          <input type="text" name="Phoneagent" class="form-control" placeholder="ป้อนเบอร์นายหน้า"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row mb-1">
                      <label class="col-sm-5 col-form-label text-right">เลขบัตร ปชช :</label>
                        <div class="col-sm-7">
                          <input type="text" name="IDCardbuyer" class="form-control" placeholder="ป้อนเลขบัตร ปชช" maxlength="13"/>
                        </div>
                        <br><br>
                        <label class="col-sm-5 col-form-label text-right">ประเภทเงินกู้ :</label>
                        <div class="col-sm-7">
                          <select id="TypeLeasing" name="TypeLeasing" class="form-control" required>
                              <option value="" selected>--- เลือกประเภทเงินกู้ ---</option>
                              <option value="PLoan">PLoan</option>
                              <option value="Micro">Micro</option>
                          </select>
                        </div>
                        <br><br>
                        <label class="col-sm-5 col-form-label text-right">ที่มาของลูกค้า :</label>
                        <div class="col-sm-7">
                        <select id="News" name="News" class="form-control" required>
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
                        <label class="col-sm-5 col-form-label text-right">สาขา :</label>
                        <div class="col-sm-7">
                          <select id="branchcar" name="branchcar" class="form-control" required>
                                <option value="" selected>--- เลือกสาขา ---</option>
                                <option value="ปัตตานี" {{ (auth::user()->branch == 01) ? 'selected' : '' }}>ปัตตานี</option>
                                <option value="ยะลา" {{ (auth::user()->branch == 03) ? 'selected' : '' }}>ยะลา</option>
                                <option value="นราธิวาส" {{ (auth::user()->branch == 04) ? 'selected' : '' }}>นราธิวาส</option>
                                <option value="สายบุรี" {{ (auth::user()->branch == 05) ? 'selected' : '' }}>สายบุรี</option>
                                <option value="โกลก" {{ (auth::user()->branch == 06) ? 'selected' : '' }}>โกลก</option>
                                <option value="เบตง" {{ (auth::user()->branch == 07) ? 'selected' : '' }}>เบตง</option>
                                <option value="โคกโพธิ์" {{ (auth::user()->branch == 26) ? 'selected' : '' }}>โคกโพธิ์</option>
                                <option value="ระแงะ" {{ (auth::user()->branch == 27) ? 'selected' : '' }}>ระแงะ</option>
                                <option value="บังนังสตา" {{ (auth::user()->branch == 28) ? 'selected' : '' }}>บังนังสตา</option>
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
                  <button type="submit" class="btn btn-success text-center" style="border-radius: 50px;">บันทึก</button>
                  <button type="button" class="btn btn-danger" style="border-radius: 50px;" data-dismiss="modal">ยกเลิก</button>
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
