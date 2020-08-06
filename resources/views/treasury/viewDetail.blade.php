<link type="text/css" rel="stylesheet" href="{{ asset('css/magiczoomplus.css') }}"/>
<script type="text/javascript" src="{{ asset('js/magiczoomplus.js') }}"></script>

@php
  $Currdate = date('2020-06-02');
@endphp

<style>
  #todo-list{
  width:100%;
  margin:0 auto 50px auto;
  padding:5px;
  background:white;
  position:relative;
  /*box-shadow*/
  -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
  -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
        box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
  /*border-radius*/
  -webkit-border-radius:5px;
  -moz-border-radius:5px;
        border-radius:5px;}
  #todo-list:before{
  content:"";
  position:absolute;
  z-index:-1;
  /*box-shadow*/
  -webkit-box-shadow:0 0 20px rgba(0,0,0,0.4);
  -moz-box-shadow:0 0 20px rgba(0,0,0,0.4);
        box-shadow:0 0 20px rgba(0,0,0,0.4);
  top:50%;
  bottom:0;
  left:10px;
  right:10px;
  /*border-radius*/
  -webkit-border-radius:100px / 10px;
  -moz-border-radius:100px / 10px;
        border-radius:100px / 10px;
  }
  .todo-wrap{
  display:block;
  position:relative;
  padding-left:35px;
  /*box-shadow*/
  -webkit-box-shadow:0 2px 0 -1px #ebebeb;
  -moz-box-shadow:0 2px 0 -1px #ebebeb;
        box-shadow:0 2px 0 -1px #ebebeb;
  }
  .todo-wrap:last-of-type{
  /*box-shadow*/
  -webkit-box-shadow:none;
  -moz-box-shadow:none;
        box-shadow:none;
  }
  input[type="checkbox"]{
  position:absolute;
  height:0;
  width:0;
  opacity:0;
  /* top:-600px; */
  }
  .todo{
  display:inline-block;
  font-weight:200;
  padding:10px 5px;
  height:37px;
  position:relative;
  }
  .todo:before{
  content:'';
  display:block;
  position:absolute;
  top:calc(50% + 10px);
  left:0;
  width:0%;
  height:1px;
  background:#cd4400;
  /*transition*/
  -webkit-transition:.25s ease-in-out;
  -moz-transition:.25s ease-in-out;
    -o-transition:.25s ease-in-out;
        transition:.25s ease-in-out;
  }
  .todo:after{
  content:'';
  display:block;
  position:absolute;
  z-index:0;
  height:18px;
  width:18px;
  top:9px;
  left:-25px;
  /*box-shadow*/
  -webkit-box-shadow:inset 0 0 0 2px #d8d8d8;
  -moz-box-shadow:inset 0 0 0 2px #d8d8d8;
        box-shadow:inset 0 0 0 2px #d8d8d8;
  /*transition*/
  -webkit-transition:.25s ease-in-out;
  -moz-transition:.25s ease-in-out;
    -o-transition:.25s ease-in-out;
        transition:.25s ease-in-out;
  /*border-radius*/
  -webkit-border-radius:4px;
  -moz-border-radius:4px;
        border-radius:4px;
  }
  .todo:hover:after{
  /*box-shadow*/
  -webkit-box-shadow:inset 0 0 0 2px #949494;
  -moz-box-shadow:inset 0 0 0 2px #949494;
        box-shadow:inset 0 0 0 2px #949494;
  }
  .todo .fa-check{
  position:absolute;
  z-index:1;
  left:-31px;
  top:0;
  font-size:1px;
  line-height:36px;
  width:36px;
  height:36px;
  text-align:center;
  color:transparent;
  text-shadow:1px 1px 0 white, -1px -1px 0 white;
  }
  :checked + .todo{
  color:#717171;
  }
  :checked + .todo:before{
  width:100%;
  }
  :checked + .todo:after{
  /*box-shadow*/
  -webkit-box-shadow:inset 0 0 0 2px #0eb0b7;
  -moz-box-shadow:inset 0 0 0 2px #0eb0b7;
        box-shadow:inset 0 0 0 2px #0eb0b7;
  }
  :checked + .todo .fa-check{
  font-size:20px;
  line-height:35px;
  color:#0eb0b7;
  }
  /* Delete Items */

  .delete-item{
  display:block;
  position:absolute;
  height:36px;
  width:36px;
  line-height:36px;
  right:0;
  top:0;
  text-align:center;
  color:#d8d8d8;
  opacity:0;
  }
  .todo-wrap:hover .delete-item{
  opacity:1;
  }
  .delete-item:hover{
  color:#cd4400;
  }
</style>

<section class="content">
  <div class="card card-warning">
    <div class="card-header">
      <h4 class="card-title">
        @if ($GetType == 1)
          <i class="fas fa-search-dollar"></i>&nbsp;
          รายละเอียดค่าใช้จ่าย
        @elseif ($GetType == 2)
          <i class="far fa-address-card"></i>&nbsp;
          ตรวจสอบบัญชีหน้าเล่ม
        @endif
      </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>

    <div class="card-body text-sm">
      @if ($GetType == 1)
        <div class="row">
          <div class="col-md-5">
            <div class="float-right form-inline">
              <label>ยอดจัด : </label>
            <input type="text" class="form-control text-right" style="width: 200px;" value="{{number_format($data->Top_car)}}" readonly/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="float-right form-inline">
              <label>พรบ. : </label>
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{number_format($data->act_Price)}}" readonly/>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-5">
            <div class="float-right form-inline">
              <label>ยอดปิดบัญชี : </label>
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{number_format($data->closeAccount_Price)}}" readonly/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="float-right form-inline">
              @if($data->P2_Price == "6500" or $data->P2_Price == "0")
                <label>ซื้อป2+ : </label>
              @else
                <label>ซื้อป1 : </label>
              @endif
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{number_format($data->P2_Price)}}" readonly/>
            </div>
          </div>
        </div>

        <hr>
        <div class="row">
          <div class="col-md-5">
            <div class="float-right form-inline">
              <label>คจช.ขนส่ง : </label>
            <input type="text" class="form-control text-right" style="width: 200px;" value="{{number_format($data->tran_Price, 2)}}" readonly/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="float-right form-inline">
              <label>อื้นๆ : </label>
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{number_format($data->other_Price, 2)}}" readonly/>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-5">
            <div class="float-right form-inline">
              <label>ค่าประเมิน : </label>
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{$data->evaluetion_Price}}" readonly/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="float-right form-inline">
              <label>อากร : </label>
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{$data->duty_Price}}" readonly/>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-5">
            <div class="float-right form-inline">
              <label>การตลาด : </label>
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{$data->marketing_Price}}" readonly/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="float-right form-inline">
              <label>รวมค่าใช้จ่าย : </label>
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{number_format($data->totalk_Price, 2)}}" readonly/>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-5">
            <div class="float-right form-inline">
              <label>คงเหลือ : </label>
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{number_format($data->balance_Price, 2)}}" readonly/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="float-right form-inline">
              <label>หัก 1.5% : </label>
              <input type="text" class="form-control text-right" style="width: 200px;" value="{{number_format($data->commit_Price, 2)}}" readonly/>
            </div>
          </div>
        </div>
      @elseif ($GetType == 2)
        <form name="form1" action="{{ route('treasury.updateAnalysis' ,[1, $data->id]) }}" method="get" id="formimage" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="form-inline">
                <div class="col-sm-6">
                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title">ผู้รับเงิน</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>

                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>ชื่อ : </label>
                            <input type="text" class="form-control text-right" style="width: 220px;" value="{{$data->Payee_car}}" readonly/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>บัญชี : </label>
                            <input type="text" class="form-control text-right" style="width: 220px;" value="{{$SetAccount}}" readonly/>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>สาขา : </label>
                          <input type="text" class="form-control text-right" style="width: 220px;" value="{{$data->branchbrance_car}}" readonly/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>โทรศัพท์ : </label>
                            <input type="text" class="form-control text-right" style="width: 220px;" value="{{$SetTell}}" readonly/>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            @if($data->Payee_car == $data->Agent_car and $data->Accountbrance_car == $data->Accountagent_car)
                              <label>ยอดรถ : </label>
                            @else
                              <label><font color="red">ยอดโอนรถ : </font></label>
                            @endif
                          <input type="text" class="form-control text-right" style="width: 220px; background-color: red; color: white" value="{{number_format($data->balance_Price, 2)}}" readonly/>
                          </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title">ผู้รับค่าคอม</h3>
      
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>ชื่อ : </label>
                            <input type="text" class="form-control text-right" style="width: 220px;" value="{{$data->Agent_car}}" readonly/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>บัญชี : </label>
                            <input type="text" class="form-control text-right" style="width: 220px;" value="{{$SetAccountGT}}" readonly/>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>สาขา : </label>
                          <input type="text" class="form-control text-right" style="width: 220px;" value="{{$data->branchAgent_car}}" readonly/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>โทรศัพท์ : </label>
                            <input type="text" class="form-control text-right" style="width: 220px;" value="{{$SetTellGT}}" readonly/>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            @if($data->Payee_car == $data->Agent_car and $data->Accountbrance_car == $data->Accountagent_car)
                            <label>ยอดค่าคอม : </label>
                          @else
                            <label><font color="red">ยอดโอนค่าคอม : </font></label>
                          @endif
                          <input type="text" class="form-control text-right" style="width: 220px; background-color: red; color: white" value="{{number_format($data->commit_Price, 2)}}" readonly/>
                          </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                {{-- <div class="col-sm-6">
                  @if($data->License_car != NULL)
                    @php
                      $Setlisence = $data->License_car;
                    @endphp
                  @endif

                  @if(substr($data->createdBuyers_at,0,10) < $Currdate)
                    @if ($data->AccountImage_car != NULL)
                      <a href="{{ asset('upload-image/'.$data->AccountImage_car) }}" class="MagicZoom" data-gallery="gallery" data-options="hint:true; zoomMode:off; variableZoom: true" style="width: 500px; height: auto;">
                        <img src="{{ asset('upload-image/'.$data->AccountImage_car) }}" style="width: 300px; height: auto;">
                      </a>
                    @endif
                  @else
                    @if ($data->AccountImage_car != NULL)
                      <a href="{{ asset('upload-image/'.$Setlisence.'/'.$data->AccountImage_car) }}" class="MagicZoom" data-gallery="gallery" data-options="hint:true; zoomMode:off; variableZoom: true" style="width: 500px; height: auto;">
                        <img src="{{ asset('upload-image/'.$Setlisence.'/'.$data->AccountImage_car) }}" style="width: 300px; height: auto;">
                      </a>
                    @endif
                  @endif
                </div> --}}
              </div>
            </div>
          </div>

          @php
            $sumArcsum = 0;
          @endphp
          @if($data->Payee_car == $data->Agent_car and $data->Accountbrance_car == $data->Accountagent_car)
            @php
              $sumArcsum = $data->balance_Price + $data->commit_Price;
            @endphp
          @endif

          <div class="row">
              <div class="col-5">
                @if($data->Payee_car == $data->Agent_car and $data->Accountbrance_car == $data->Accountagent_car)
                  <div class="float-right form-inline">
                    <label><font color="red">* ยอดโอนรวม : </font></label>
                    <input type="text" class="form-control text-right" style="width: 220px; background-color: red; color: white" value="{{ number_format($sumArcsum, 2) }}" readonly/>
                  </div>
                @endif
              </div>
            @if(auth::user()->type != 2)
              <div class="col-5">
                <div class="float-right form-inline">
                  <i class="fas fa-grip-vertical"></i>
                  <span class="todo-wrap">
                    <input type="checkbox" id="1" class="checkbox" name="checkAccount" value="{{ auth::user()->name }}" {{ ($data->UserCheckAc_car !== NULL) ? 'checked' : '' }}> <!-- checked="checked"  -->
                    <label for="1" class="todo">
                      <i class="fa fa-check"></i>
                      <span class="text"><font color="red">ข้อมูลถูกต้อง</font></span>
                    </label>
                  </span>
                </div>
              </div>
              <div class="col-2">
                <div class="card-tools d-inline float-right">
                  <button type="submit" class="delete-modal btn btn-success">
                    <i class="fas fa-save"></i> บันทึก
                  </button>
                  <a class="delete-modal btn btn-danger" href="{{ URL::previous() }}">
                    <i class="far fa-window-close"></i> ยกเลิก
                  </a>
                </div>
              </div>
            @endif
          </div>
        </form>

      @endif

    </div>
  </div>
</section>

<script>
  $(function () {
    $('[data-mask]').inputmask()
  })
</script>

