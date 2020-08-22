  @php
    function DateThai($strDate){
      $strYear = date("Y",strtotime($strDate))+543;
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("d",strtotime($strDate));
      //$strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      $strMonthCut = Array("" , "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฟษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฟศจิกายน","ธันวาคม");
      $strMonthThai=$strMonthCut[$strMonth];
      return "$strDay $strMonthThai $strYear";
      //return "$strDay-$strMonthThai-$strYear";
    }
  @endphp
  <section class="content">
   @if($type == 1)
      <div class="modal-header bg-info" style="border-radius: 30px 30px 0px 0px;">
        <div class="col text-center">
          <h5 class="modal-title"><i class="fas fa-car"></i> {{$data->Number_register}}</h5>
        </div>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-dark">
              <div class="card-header">
                <h5 class="card-title"><i class="far fa-clock text-red"></i> วันหมดอายุทะเบียน</h5>
              </div>
              <div class="card-body text-center">
                @if($data->Register_expire != null)
                  {{DateThai($data->Register_expire)}}
                    @php
                        date_default_timezone_set('Asia/Bangkok');
                        $ifdate = date('Y-m-d');
                    @endphp
                    @if($ifdate < $data->Register_expire)
                      @php
                        $Cldate = date_create($data->Register_expire);
                        $nowCldate = date_create($ifdate);
                        $ClDateDiff = date_diff($Cldate,$nowCldate);
                      @endphp
                      <p style="color:red;font-size:14px;">( เหลือ @if($ClDateDiff->y != 0) {{$ClDateDiff->y}} ปี @endif @if($ClDateDiff->m != 0){{$ClDateDiff->m}} เดือน @endif {{$ClDateDiff->d}} วัน )</p>
                    @else
                      <p class="prem" style="color:red;font-size:14px;"> หมดอายุแล้ว </p>
                    @endif
                @else
                  <p style="color:red;font-size:7px;"> !!! </p>
                  <p style="color:red;font-size:14px;"> ไม่ได้ระบุวันที่ </p>
                @endif
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-dark">
              <div class="card-header">
                <h5 class="card-title"><i class="far fa-clock text-blue"></i> วันหมดอายุประกัน</h5>
                <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div> -->
              </div>
              <div class="card-body text-center">
                @if($data->Insure_expire != null)
                  {{DateThai($data->Insure_expire)}}
                    @php
                        date_default_timezone_set('Asia/Bangkok');
                        $ifdate = date('Y-m-d');
                    @endphp
                    @if($ifdate < $data->Insure_expire)
                      @php
                        $Cldate = date_create($data->Insure_expire);
                        $nowCldate = date_create($ifdate);
                        $ClDateDiff = date_diff($Cldate,$nowCldate);
                      @endphp
                      <p style="color:red;font-size:14px;">( เหลือ @if($ClDateDiff->y != 0) {{$ClDateDiff->y}} ปี @endif @if($ClDateDiff->m != 0){{$ClDateDiff->m}} เดือน @endif {{$ClDateDiff->d}} วัน )</p>
                    @else
                      <p class="prem" style="color:red;font-size:14px;"> หมดอายุแล้ว </p>
                    @endif
                @else
                  <p style="color:red;font-size:7px;"> !!! </p>
                  <p style="color:red;font-size:14px;"> ไม่ได้ระบุวันที่ </p>
                @endif
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card card-dark">
              <div class="card-header">
                <h5 class="card-title"><i class="far fa-clock text-yellow"></i> วันหมดอายุ พรบ.</h5>
              </div>
              <div class="card-body text-center">
                @if($data->Act_expire != null)
                  {{DateThai($data->Act_expire)}}
                    @php
                        date_default_timezone_set('Asia/Bangkok');
                        $ifdate = date('Y-m-d');
                    @endphp
                    @if($ifdate < $data->Act_expire)
                      @php
                        $Cldate = date_create($data->Act_expire);
                        $nowCldate = date_create($ifdate);
                        $ClDateDiff = date_diff($Cldate,$nowCldate);
                      @endphp
                      <p style="color:red;font-size:14px;">( เหลือ @if($ClDateDiff->y != 0) {{$ClDateDiff->y}} ปี @endif @if($ClDateDiff->m != 0){{$ClDateDiff->m}} เดือน @endif {{$ClDateDiff->d}} วัน )</p>
                    @else
                      <p class="prem" style="color:red;font-size:14px;"> หมดอายุแล้ว </p>
                    @endif
                @else
                  <p style="color:red;font-size:7px;"> !!! </p>
                  <p style="color:red;font-size:14px;"> ไม่ได้ระบุวันที่ </p>
                @endif
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card card-dark">
              <div class="card-header">
                <h5 class="card-title"><i class="far fa-clock text-green"></i> วันที่เช็คระยะ</h5>
              </div>
              <div class="card-body text-center">
                @if($data->Check_car != null)
                  {{DateThai($data->Check_car)}}
                    @php
                        date_default_timezone_set('Asia/Bangkok');
                        $ifdate = date('Y-m-d');
                    @endphp
                    @if($ifdate < $data->Check_car)
                      @php
                        $Cldate = date_create($data->Check_car);
                        $nowCldate = date_create($ifdate);
                        $ClDateDiff = date_diff($Cldate,$nowCldate);
                      @endphp
                      <p style="color:red;font-size:14px;">( เหลือ @if($ClDateDiff->y != 0) {{$ClDateDiff->y}} ปี @endif @if($ClDateDiff->m != 0){{$ClDateDiff->m}} เดือน @endif {{$ClDateDiff->d}} วัน )</p>
                    @else
                      <p class="prem" style="color:red;font-size:14px;"> หมดอายุแล้ว </p>
                    @endif
                @else
                  <p style="color:red;font-size:7px;"> !!! </p>
                  <p style="color:red;font-size:14px;"> ไม่ได้ระบุวันที่ </p>
                @endif
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-6">
            <div class="form-group row mb-1">
              <label class="col-sm-4 col-form-label text-right">ป้ายทะเบียน :</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" value="{{$data->Number_register}}" readonly/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group row mb-1">
            <label class="col-sm-4 col-form-label text-right">ยี่ห้อรถ : </label>
              <div class="col-sm-7">
                <input type="text" class="form-control" value="{{$data->Brand_car}}" readonly/>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group row mb-1">
            <label class="col-sm-4 col-form-label text-right">รุ่นรถ : </label>
              <div class="col-sm-7">
                <input type="text" class="form-control" value="{{$data->Version_car}}" readonly/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group row mb-1">
            <label class="col-sm-4 col-form-label text-right">ประเภทรถ : </label>
              <div class="col-sm-7">
                <input type="text" class="form-control" value="{{$data->Type_car}}" readonly/>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group row mb-1">
            <label class="col-sm-4 col-form-label text-right">เลขตัวถัง :</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" value="{{$data->Engno_car}}" readonly/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group row mb-1">
            <label class="col-sm-4 col-form-label text-right">ปีรถ : </label>
              <div class="col-sm-7">
                <input type="text" class="form-control" value="{{$data->Year_car}}" readonly/>
              </div>
            </div>
          </div>
        </div>
        <br>
      </div>
   @endif
   @if($type == 2)
      <form name="form1" action="{{ route('MasterInsure.update',[$data->Insure_id]) }}" method="post" id="formimage" enctype="multipart/form-data">
          @csrf
          @method('put')
          <input type="hidden" name="_method" value="PATCH"/>

        <div class="modal-header bg-warning" style="border-radius: 30px 30px 0px 0px;">
          <div class="col text-center">
            <h5 class="modal-title"><i class="fas fa-edit"></i> แก้ไขรายการ</h5>
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
                  <input type="text" name="Registercar" class="form-control" value="{{$data->Number_register}}" placeholder="ป้อนป้ายทะเบียน" required/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-1">
              <label class="col-sm-4 col-form-label text-right">ยี่ห้อรถ : </label>
                <div class="col-sm-7">
                  <select name="Brandcar" class="form-control">
                    <option value="" selected>--- ยี่ห้อ ---</option>
                    <option value="MAZDA" {{ ($data->Brand_car === 'MAZDA') ? 'selected' : '' }}>MAZDA</option>
                    <option value="FORD" {{ ($data->Brand_car === 'FORD') ? 'selected' : '' }}>FORD</option>
                    <option value="ISUZU" {{ ($data->Brand_car === 'ISUZU') ? 'selected' : '' }}>ISUZU</option>
                    <option value="MITSUBISHI" {{ ($data->Brand_car === 'MITSUBISHI') ? 'selected' : '' }}>MITSUBISHI</option>
                    <option value="TOYOTA" {{ ($data->Brand_car === 'TOYOTA') ? 'selected' : '' }}>TOYOTA</option>
                    <option value="NISSAN" {{ ($data->Brand_car === 'NISSAN') ? 'selected' : '' }}>NISSAN</option>
                    <option value="HONDA" {{ ($data->Brand_car === 'HONDA') ? 'selected' : '' }}>HONDA</option>
                    <option value="CHEVROLET" {{ ($data->Brand_car === 'CHEVROLET') ? 'selected' : '' }}>CHEVROLET</option>
                    <option value="MG" {{ ($data->Brand_car === 'MG') ? 'selected' : '' }}>MG</option>
                    <option value="SUZUKI" {{ ($data->Brand_car === 'SUZUKI') ? 'selected' : '' }}>SUZUKI</option>
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
                  <input type="text" name="Versioncar" class="form-control" value="{{$data->Version_car}}" placeholder="ป้อนรุ่นรถ" />
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-1">
              <label class="col-sm-4 col-form-label text-right">ประเภทรถ : </label>
                <div class="col-sm-7">
                  <select id="Typecar" name="Typecar" class="form-control">
                    <option value="" selected>--- ประเภทรถ ---</option>
                    <option value="รถใช้งาน" {{ ($data->Type_car === 'รถใช้งาน') ? 'selected' : '' }}>รถใช้งาน</option>
                    <option value="รถ Demo" {{ ($data->Type_car === 'รถ Demo') ? 'selected' : '' }}>รถ Demo</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group row mb-1">
              <label class="col-sm-5 col-form-label text-right">เลขตัวถัง :</label>
                <div class="col-sm-7">
                  <input type="text" name="Engnocar" class="form-control" value="{{$data->Engno_car}}" placeholder="ป้อนเลขตัวถัง"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group row mb-1">
              <label class="col-sm-4 col-form-label text-right">ปีรถ : </label>
                <div class="col-sm-7">
                  <select id="Yearcar" name="Yearcar" class="form-control">
                    <option value="{{$data->Year_car}}" selected>{{$data->Year_car}}</option>
                    <option value="">--- เลือกปี ---</option>
                      @php
                          $Year = date('Y');
                      @endphp
                      @for ($i = 0; $i < 15; $i++)
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
              <label class="col-sm-5 col-form-label text-right">วันหมดอายุทะเบียน :</label>
                <div class="col-sm-7">
                  <input type="date" name="RegisterExpire" value="{{$data->Register_expire}}" class="form-control"/>
                </div>
              </div>
              <div class="form-group row mb-1">
              <label class="col-sm-5 col-form-label text-right">วันหมดอายุประกัน :</label>
                <div class="col-sm-7">
                  <input type="date" name="InsureExpire" value="{{$data->Insure_expire}}" class="form-control"/>
                </div>
              </div>
              <div class="form-group row mb-1">
              <label class="col-sm-5 col-form-label text-right">วันหมดอายุ พรบ. :</label>
                <div class="col-sm-7">
                  <input type="date" name="ActExpire" value="{{$data->Act_expire}}" class="form-control"/>
                </div>
              </div>
              <div class="form-group row mb-1">
              <label class="col-sm-5 col-form-label text-right">วันที่เช็คระยะ :</label>
                <div class="col-sm-7">
                  <input type="date" name="Checkcar" value="{{$data->Check_car}}" class="form-control"/>
                </div>
              </div>
            </div>
            <div class="col-6">
            <div class="form-group row mb-1">
              <label class="col-sm-4 col-form-label text-right">หมายเหตุ :</label>
                <div class="col-sm-7">
                  <textarea class="form-control" name="Notecar" rows="6" placeholder="ป้อนหมายเหตุ...">{{$data->Note_car}}</textarea>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <!-- <input type="hidden" name="NameUser" value="{{auth::user()->name}}" class="form-control" placeholder="ป้อนชื่อ"/> -->
          <div style="text-align: center;">
              <button type="submit" class="btn btn-success text-center" style="border-radius: 50px;">อัพเดท</button>
              <button type="button" class="btn btn-danger" style="border-radius: 50px;" data-dismiss="modal">ยกเลิก</button>
          </div>
        </div>
      </form>
    @endif
  </section>
