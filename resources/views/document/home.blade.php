@extends('layouts.master')
@section('title','แผนกการเงิน')
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
    span:hover {
      color: blue;
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
        <div class="row justify-content-center">
          <div class="col-12 table-responsive">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-6">
                    <div class="form-inline">
                      <h5>คลังข้อมูล (Data warehouse)</h5>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="card-tools d-inline float-right">
                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                        <a class="btn bg-success btn-sm" data-toggle="modal" data-target="#modal-lg" data-backdrop="static">
                          <span class="fas fa-plus"></span> New Folder
                        </a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body text-sm">
                <div class="row">
                  <div class="col-12">
                    <div class="card card-primary">
                      <div class="card-body">
                        <div class="row">
                          @foreach($data as $row)
                            <div class="col-sm-2">
                            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์")
                              <form method="post" class="delete_form float-right" action="{{ action('DocumentController@destroy',[$row->folder_id,1]) }}" style="display:inline;">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE" />
                                <input type="hidden" name="foldername" value="{{$row->folder_name}}" />
                                <button type="submit" data-name="โฟลเดอร์ {{$row->folder_name}}" class="delete-modal btn btn-xs AlertForm text-red" title="ลบโฟลเดอร์">
                                  <i class="far fa-trash-alt"></i>
                                </button>
                              </form>
                            @endif
                              <a href="{{ action('DocumentController@edit',[$row->folder_id, 1]) }}">
                                <img src="{{ asset('dist/img/folder2.png') }}" class="img-fluid">
                              </a>
                              <p align="center"> {{$row->folder_name}}</p>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <!-- pop up create new folder -->
  <form action="{{ route('document.store', 1) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content" style="border-radius:50px;">
            <div class="modal-header bg-success" style="border-radius:30px 30px 0px 0px;">
              <div class="col text-center">
                <h4 class="modal-title">สร้างโฟลเดอร์</h4>
              </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <br />

            <div class="modal-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-3 col-form-label text-right">ชื่อโฟลเดอร์ : </label>
                      <div class="col-sm-8">
                        <input type="text" name="foldername" class="form-control" placeholder="ป้อนชื่อโฟลเดอร์ใหม่"/>
                      </div>
                    </div>
                  </div>
                </div>
                <br/>
                <input type="hidden" name="creator" value="{{auth::user()->name}}"/>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn btn-success" style="border-radius:50px;">สร้าง</button>
                <button type="button" class="btn btn-danger" style="border-radius:50px;" data-dismiss="modal">ยกเลิก</button>
            </div>
            <br>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  </form>

  <div class="modal fade" id="modal-preview">
    <div class="modal-dialog modal-xl">
      <div class="modal-content bg-default">
        <div class="modal-body">
          <p>One fine body…</p>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- button-to-top --}}
  <script>
    var btn = $('#button');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });
  </script>

  <script>
    $(function () {
      $("#modal-preview").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-preview .modal-body").load(link, function(){
        });
      });
    });
  </script>

  <script>
    $(function () {
      $("#table1").DataTable({
        "responsive": true,
        "autoWidth": false,
        "ordering": false,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "order": [[ 1, "asc" ]],
      });
    });
  </script>

  <script>
    function blinker() {
      $('.prem').fadeOut(1500);
      $('.prem').fadeIn(1500);
    }
    setInterval(blinker, 1500);
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
  </script>


@endsection
