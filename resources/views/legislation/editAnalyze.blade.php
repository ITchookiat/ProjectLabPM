@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
@section('content')

@php
  function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
    //return "$strDay-$strMonthThai-$strYear";
  }
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
          border-radius:5px;
    }
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
    top:calc(50% + 2px);
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

  <!-- Main content -->
  <section class="content">
    <div class="content-header">
      @if(session()->has('success'))
        <script type="text/javascript">
          toastr.success('{{ session()->get('success') }}')
        </script>
      @endif

      <section class="content">
        <form name="form1" method="post" action="{{ action('LegislationController@update',[$id,$type]) }}" enctype="multipart/form-data">
          @csrf
          @method('put')
            <div class="row justify-content-center">
              <div class="col-12 table-responsive">
                <div class="card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-4">
                        <div class="form-inline">
                          <h4>ข้อมูลเตรียมเอกสาร...</h4>
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="row">
                          <div class="col-3">
                          </div>
                          <div class="col-3">
                          </div>
                          <div class="col-6">
                            <div class="float-right form-inline">
                              @if($data->Flag_status == 1)
                              <a class="btn btn-primary" href="{{ action('LegislationController@updateLegislation',[$id,$type]) }}?&Flag={{2}}" style="background-color:#031261; color:#FFFFFF;">
                                <i class="fas fa-share-square"></i> ส่งทนาย
                              </a>
                              &nbsp;&nbsp;
                              @else
                              <a class="btn btn-primary" style="background-color:#CCCCCC; color:#FFFFFF;">
                                <i class="fas fa-share-square"></i> ส่งทนาย
                              </a>
                              &nbsp;&nbsp;
                              @endif
                              <button type="submit" class="btn btn-success" style="background-color:#189100; color:#FFFFFF;">
                                <i class="fas fa-save"></i> บันทึก
                              </button>
                              &nbsp;&nbsp;
                              <a class="btn btn-danger" href="{{ route('legislation',6) }}" style="background-color:#DB0000; color:#FFFFFF;">
                                <i class="far fa-window-close"></i> ยกเลิก
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-sm">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="card card-warning">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-street-view"></i> ข้อมูลผู้เช่าซื้อ</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                               <div class="col-md-4">
                                 เลขที่สัญญา
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ $data->Contract_legis }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                ชื่อ - นามสกุล
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ $data->Name_legis }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                เลขบัตรประชาชน
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ $data->Idcard_legis }}" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" readonly/>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                               <div class="col-md-4">
                                 ป้ายทะเบียน
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ $data->register_legis }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                ยี่ห้อ
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ $data->BrandCar_legis }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                ปีรถ
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ $data->YearCar_legis }}" readonly/>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                               <div class="col-md-4">
                                 ประเภทรถ
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ $data->Category_legis }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                เลขไมล์
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ number_format($data->Mile_legis, 2) }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                วันที่ทำสัญญา
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ DateThai($data->DateDue_legis) }}" readonly/>
                                </div>
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-md-4">
                                ยอดจัด
                                <div class="form-inline" align="left">
                                  <input type="text" name="Paylegis" class="form-control" style="width: 100%;" value="{{ number_format($data1->NCARCST ,2) }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                ค่าผ่อน
                                <div class="form-inline" align="left">
                                  <input type="text" name="Periodlegis" class="form-control" style="width: 100%;" value="{{ number_format($data1->TOT_UPAY, 2) }}" readonly/>
                                </div>
                              </div>
                               <div class="col-md-4">
                                 จำนวนงวดทั้งหมด
                                <div class="form-inline" align="left">
                                  <input type="text" name="Countperiodlegis" class="form-control" style="width: 100%;" value="{{$data1->T_NOPAY }}" readonly/>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                ค้างจากงวดที่
                                <div class="form-inline" align="left">
                                  <input type="text" name="Beforeperiodlegis" class="form-control" style="width: 100%;" value="{{ $data1->EXP_FRM }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                ถึงงวดที่
                                <div class="form-inline" align="left">
                                  <input type="text" name="Remainperiodlegis" class="form-control" style="width: 100%;" value="{{ $data1->EXP_TO }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                ชำระแล้ว
                                <div class="form-inline" align="left">
                                  <input type="text" name="Beforemoeylegis" class="form-control" style="width: 100%;" value="{{ number_format($data1->SMPAY, 2) }}" readonly/>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                ค้าง
                                <div class="form-inline" align="left">
                                  <input type="text" name="Staleperiodlegis" class="form-control" style="width: 100%;" value="{{ number_format($data1->EXP_PRD, 0) }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                ค้างงวดจริง
                                <div class="form-inline" align="left">
                                  <input type="text" name="Realperiod_legis" class="form-control" style="width: 100%;" value="{{ number_format($data1->HLDNO, 2) }}" readonly/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                ลูกหนี้คงเหลือ
                                <div class="form-inline" align="left">
                                  <input type="text" name="Sumperiodlegis" class="form-control" style="width: 100%;" value="{{ number_format($data1->BALANC - $data1->SMPAY, 2) }}" readonly/>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                วันที่หยุด Vat
                                <div class="form-inline" align="left">
                                  @if($data->DateVAT_legis == Null)
                                    <input type="text" name="DateVATlegis" class="form-control" style="width: 100%;" value="{{ $data1->DTSTOPV }}" readonly/>
                                  @else
                                    <input type="text" name="DateVATlegis" class="form-control" style="width: 100%;" value="{{ DateThai($data1->DTSTOPV) }}" readonly/>
                                  @endif
                                </div>
                              </div>
                              <div class="col-md-4">
                                ชื่อผู้ค้ำ
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ $data->NameGT_legis }}" readonly/>
                                </div>
                              </div>
                               <div class="col-md-4">
                                 เลขบัตรประชาชน
                                <div class="form-inline" align="left">
                                  <input type="text" class="form-control" style="width: 100%;" value="{{ $data->IdcardGT_legis }}" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" readonly/>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <input type="hidden" name="Phonelegis" class="form-control" style="width: 100%;" value="{{ (iconv('TIS-620', 'utf-8', $data1->TELP)) }}" readonly/>
                      </div>

                      <div class="col-md-3">
                        <div class="card card-warning">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-tasks"></i> เอกสาร</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                              </button>
                            </div>
                          </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="" id="todo-list">
                                  <span class="todo-wrap">
                                    @if($data->Terminatebuyer_list != Null)
                                      <input type="checkbox" id="7" name="Terminatebuyerlist" value="{{ $data->Terminatebuyer_list }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="7" name="Terminatebuyerlist" value="on"/>
                                    @endif
                                    <label for="7" class="todo">
                                      <i class="fa fa-check"></i>
                                      สัญญาบอกเลิกผู้ซื้อ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    @if($data->Terminatesupport_list != Null)
                                      <input type="checkbox" id="8" name="Terminatesupportlist" value="{{ $data->Terminatesupport_list }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="8" name="Terminatesupportlist" value="on"/>
                                    @endif
                                    <label for="8" class="todo">
                                      <i class="fa fa-check"></i>
                                      สัญญาบอกเลิกผู้ค้ำ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    @if($data->Acceptbuyerandsup_list != Null)
                                      <input type="checkbox" id="9" name="Acceptbuyerandsuplist" value="{{ $data->Acceptbuyerandsup_list }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="9" name="Acceptbuyerandsuplist" value="on"/>
                                    @endif
                                    <label for="9" class="todo">
                                      <i class="fa fa-check"></i>
                                      ใบตอบรับผู้ซื้อ - ผู้ค้ำ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    @if($data->Twodue_list != Null)
                                      <input type="checkbox" id="10" name="Twoduelist" value="{{ $data->Twodue_list }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="10" name="Twoduelist" value="on"/>
                                    @endif
                                    <label for="10" class="todo">
                                      <i class="fa fa-check"></i>
                                      หนังสือ 2 งวด
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    @if($data->AcceptTwodue_list != Null)
                                      <input type="checkbox" id="11" name="AcceptTwoduelist" value="{{ $data->AcceptTwodue_list }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="11" name="AcceptTwoduelist" value="on"/>
                                    @endif
                                    <label for="11" class="todo">
                                      <i class="fa fa-check"></i>
                                      ใบตอบรับหนังสือ 2 งวด
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    @if($data->Confirm_list != Null)
                                      <input type="checkbox" id="12" name="Confirmlist" value="{{ $data->Confirm_list }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="12" name="Confirmlist" value="on"/>
                                    @endif
                                    <label for="12" class="todo">
                                      <i class="fa fa-check"></i>
                                      หนังสือยืนยันการบอกเลิก
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    @if($data->Accept_list != Null)
                                      <input type="checkbox" id="13" name="Acceptlist" value="{{ $data->Accept_list }}" checked="checked"/>
                                    @else
                                      <input type="checkbox" id="13" name="Acceptlist" value="on"/>
                                    @endif
                                    <label for="13" class="todo">
                                      <i class="fa fa-check"></i>
                                      ใบตอบรับ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="card card-warning">
                          <div class="card-header">
                            <h3 class="card-title"><i class="far fa-comment-alt"></i> หมายเหตุ</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <textarea name="NotebyAnalysis" class="form-control" rows="14">{{ $data->Noteby_legis }}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </div>

            <input type="hidden" name="_method" value="PATCH"/>
        </form>
      </section>
    </div>
  </section>

  <script>
    $(function () {
      $('[data-mask]').inputmask()
    })
  </script>
@endsection
