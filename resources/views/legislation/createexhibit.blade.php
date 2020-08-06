@extends('layouts.master')
@section('title','ลูกหนี้ของกลาง')
@section('content')

  <link href="https://cdnjs0.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>

  @php
    date_default_timezone_set('Asia/Bangkok');
    $Y = date('Y') + 543;
    $Y2 = date('Y') + 542;
    $m = date('m');
    $d = date('d');
    //$date = date('Y-m-d');
    $time = date('H:i');
    $date = $Y.'-'.$m.'-'.$d;
    $date2 = $Y2.'-'.$m.'-'.$d;
  @endphp

  <!-- Main content -->
  <section class="content">
    <div class="content-header">
      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>กรุณากรอกข้อมูลอีกครั้ง ({{$error}}) </li>
            @endforeach
          </ul>
        </div>
      @endif

      <section class="content">
        <div class="row justify-content-center">
          <div class="col-12 table-responsive">
            <div class="card">
              @if($type == 11)
                <form name="form1" action="{{ route('legislation.store',[00, $type]) }}" method="post" id="formimage" enctype="multipart/form-data">
                  @csrf
                  <div class="card-header">
                    <div class="row">
                      <div class="col-4">
                        <div class="form-inline">
                          <h4>เพิ่มข้อมูลของกลาง...</h4>
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="row">
                          <div class="col-9"></div>
                          <div class="col-3">
                            <div class="card-tools d-inline float-right">
                              <button type="submit" class="delete-modal btn btn-success">
                                <i class="fas fa-save"></i> บันทึก
                              </button>
                              <a class="delete-modal btn btn-danger" href="{{ route('legislation',10) }}">
                                <i class="far fa-window-close"></i> ยกเลิก
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-sm">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-9">
                          <div class="card card-warning">
                            <div class="card-header">
                              <h3 class="card-title"><i class="fa fa-user"></i> ข้อมูลผู้เช่าซื้อ</h3>
              
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                </button>
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font color="red">เลขที่สัญญา : </font></label>
                                    <input type="text" name="ContractNo" class="form-control" style="width: 250px;" maxlength="12" placeholder="ป้อนเลขที่สัญญา" required/>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font>วันที่รับเรื่อง : </font></label>
                                    <input type="date" name="DateExhibit" class="form-control" style="width: 250px;" value="{{ date('Y-m-d') }}">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font>ชื่อ-สกุลผู้เช่าซื้อ : </font></label>
                                    <input type="text" name="NameContract" class="form-control" style="width: 250px;" placeholder="ป้อนชื่อ-สกุลผู้เช่าซื้อ"/>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font>สถานีตำรวจภูธร : </font></label>
                                    <input type="text" name="PoliceStation" class="form-control" style="width: 250px;" placeholder="ป้อนสถานีภูธร">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font>ชื่อผู้ต้องหา : </font></label>
                                    <input type="text" name="NameSuspect" class="form-control" style="width: 250px;" placeholder="ป้อนชื่อผู้ต้องหา"/>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font>ข้อหา : </font></label>
                                    <select name="PlaintExhibit" class="form-control" style="width: 250px">
                                      <option selected value="">---เลือกข้อหา---</option>
                                      <option value="ยาบ้า">ยาบ้า</otion>
                                      <option value="พืชกระท่อม">พืชกระท่อม</otion>
                                      <option value="ศุลกากร">ศุลกากร</otion>
                                      <option value="จราจร">จราจร</otion>
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font>พนักงานสอบสวน : </font></label>
                                    <input type="text" name="InquiryOfficial" class="form-control" style="width: 250px;" placeholder="ป้อนพนักงานสอบสวน"/>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font>เบอร์โทรศัพท์ : </font></label>
                                    <input type="text" name="InquiryOfficialtel" class="form-control" style="width: 250px;" placeholder="ป้อนพนักงานสอบสวน"/>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font>บอกเลิกสัญญา : </font></label>
                                    <select id="TerminateExhibit" name="TerminateExhibit" class="form-control" style="width: 250px">
                                      <<option value="เร่งรัด">เร่งรัด</otion>
                                      <optionoption selected value="">---เลือกบอกเลิกสัญญา---</option>
                                        value="ทนาย">ทนาย</otion>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="float-right form-inline">
                                    <label><font>ประเภทของกลาง : </font></label>
                                    <select id="TypeExhibit" name="TypeExhibit" class="form-control" style="width: 250px">
                                      <option selected value="">---เลือกประเภท---</option>
                                      <option value="ของกลาง">ของกลาง</otion>
                                      <option value="ยึดตามมาตราการ(ปปส.)">ยึดตามมาตราการ(ปปส.)</otion>
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6" id="ShowTerminate" style="display:none;">
                                  <div class="float-right form-inline">
                                    <label><font>วันที่ทนายส่งเรื่อง : </font></label>
                                    <input type="date" name="DateLawyersend" class="form-control" style="width: 250px;"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="card card-warning">
                            <div class="card-header">
                              <h3 class="card-title"><i class="fa  fa-edit"></i> หมายเหตุ</h3>
              
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                </button>
                              </div>
                            </div>
                            <div class="card-body">
                              <textarea class="form-control" name="NoteExhibit" placeholder="ป้อนหมายเหตุ" style="width:100%;" rows="8"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>

                      <script>
                          $('#TypeExhibit').change(function(){
                            var value = document.getElementById('TypeExhibit').value;
                              if(value == 'ของกลาง'){
                                $('#ShowType1').show();
                                $('#ShowType2').hide();
                              }
                              else if(value == 'ยึดตามมาตราการ(ปปส.)'){
                                $('#ShowType1').hide();
                                $('#ShowType2').show();
                              }
                              else{
                                $('#ShowType1').hide();
                                $('#ShowType2').hide();
                              }
                          });
                          $('#TerminateExhibit').change(function(){
                            var value = document.getElementById('TerminateExhibit').value;
                              if(value == 'ทนาย'){
                                $('#ShowTerminate').show();
                              }
                              else{
                                $('#ShowTerminate').hide();
                              }
                          });
                      </script>
                      
                      <div id="ShowType1" style="display:none;">
                        <div class="card card-danger">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-arrows"></i> ประเภทของกลาง</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>วันที่สอบคำให้การ : </font></label>
                                  <input type="date" name="DateGiveword" class="form-control" style="width: 250px"/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>ชั้นสำนวน : </font></label>
                                  <select name="TypeGiveword" class="form-control" style="width: 250px">
                                    <option selected value="">---เลือกคำให้การ---</option>
                                    <option value="พนักงานสอบสวน">ชั้นพนักงานสอบสวน</otion>
                                    <option value="พนักงานอัยการ">ชั้นพนักงานอัยการ</otion>
                                    <option value="ชั้นศาล">ชั้นศาล</otion>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>ผล : </font></label>
                                  <select name="ResultExhibit1" class="form-control" style="width: 250px">
                                    <option selected value="">---เลือกผล---</option>
                                      <option value="คืน">คืน</otion>
                                      <option value="ไม่คืน">ไม่คืน</otion>
                                  </select>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>วันที่เช็คสำนวน : </font></label>
                                  <input type="date" name="DateCheckexhibit" class="form-control" style="width: 250px"/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>วันที่เตรียมเอกสาร : </font></label>
                                  <input type="date" name="DatePreparedoc" class="form-control" style="width: 250px"/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>วิธีดำเนินการ : </font></label>
                                  <select id="ProcessExhibit1" name="ProcessExhibit1" class="form-control" style="width: 250px">
                                    <option selected value="">---เลือกวิธีดำเนินการ---</option>
                                    <option value="รับคืน">รับคืน</otion>
                                    <option value="ไม่รับคืน">ไม่รับคืน</otion>
                                  </select>
                                </div>
                              </div>
                            </div>

                            <script>
                              $('#ProcessExhibit1').change(function(){
                                var value = document.getElementById('ProcessExhibit1').value;
                                var today = new Date();
                                var date = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, "0")+'-'+today.getDate().toString().padStart(2, "0");
                                  if(value != ''){
                                    $('#DategetResult1').val(date);
                                  }
                                  else{
                                    $('#DategetResult1').val('');
                                  }
                              });
                            </script>

                            <div class="row">
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>วันที่ยื่นคำร้อง : </font></label>
                                  <input type="date" name="DateSendword" class="form-control" style="width: 250px"/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>วันทีไต่สวน : </font></label>
                                  <input type="date" name="DateInvestigate" class="form-control" style="width: 250px"/>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>วันที่ดำเนินการ : </font></label>
                                  <input type="date" id="DategetResult1" name="DategetResult1" class="form-control" style="width: 250px"/>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div id="ShowType2" style="display:none;">
                        <div class="card card-danger">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-gg"></i> ประเภทยึดตามมาตราการ(ปปส.)</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-4">
                                  <div class="float-right form-inline">
                                    <label><font>วันทีส่งรายละเอียด : </font></label>
                                    <input type="date" name="DateSenddetail" class="form-control" style="width: 250px"/>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="float-right form-inline">
                                  <label><font>ผล : </font></label>
                                  <select name="ResultExhibit2" class="form-control" style="width: 250px">
                                    <option selected value="">---เลือกผล---</option>
                                      <option value="รับเช็ค">รับเช็ค</otion>
                                      <option value="รับรถ">รับรถ</otion>
                                  </select>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>วิธีดำเนินการ : </font></label>
                                  <select id="ProcessExhibit2" name="ProcessExhibit2" class="form-control" style="width: 250px">
                                    <option selected value="">---เลือกวิธีดำเนินการ---</option>
                                    <option value="ไปรับเช็ค">ไปรับเช็ค</otion>
                                    <option value="ไปรับรถ">ไปรับรถ</otion>
                                  </select>
                                </div>
                              </div>
                            </div>

                            <script>
                                $('#ProcessExhibit2').change(function(){
                                  var value = document.getElementById('ProcessExhibit2').value;
                                  var today = new Date();
                                  var date = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, "0")+'-'+today.getDate().toString().padStart(2, "0");
                                    if(value != ''){
                                      $('#DategetResult2').val(date);
                                    }
                                    else{
                                      $('#DategetResult2').val('');
                                    }
                                });
                            </script>

                            <div class="row">
                              <div class="col-md-8"></div>
                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <label><font>วันที่ดำเนินการ : </font></label>
                                  <input type="date" id="DategetResult2" name="DategetResult2" class="form-control" style="width: 250px"/>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <input type="hidden" name="_token" value="{{csrf_token()}}" />
                      <input type="hidden" name="type" value="12" />
                      <br>
                    </div>
                  </div>
                </form>
              @endif
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <script type="text/javascript">
    $("#image-file").fileinput({
      uploadUrl:"{{ route('MasterAnalysis.store') }}",
      theme:'fa',
      uploadExtraData:function(){
        return{
          _token:"{{csrf_token()}}",
        }
      },
      allowedFileExtensions:['jpg','png','gif'],
      maxFileSize:10240
    })
  </script>

  <script>
    $(function () {
      $('[data-mask]').inputmask()
    })
  </script>
@endsection
