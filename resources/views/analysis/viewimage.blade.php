@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
@section('content')

  @php
    date_default_timezone_set('Asia/Bangkok');
    $date = date('Y-m-d', strtotime('-1 days'));
    $Currdate = date('2020-06-02');
  @endphp

  @php
    date_default_timezone_set('Asia/Bangkok');
    $Y = date('Y') + 543;
    $m = date('m');
    $d = date('d');
    $time = date('H:i');
    $date2 = $Y.'-'.$m.'-'.$d;
  @endphp

  <link type="text/css" rel="stylesheet" href="{{ asset('css/magiczoomplus.css') }}"/>
  <script type="text/javascript" src="{{ asset('js/magiczoomplus.js') }}"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>

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
                  <div class="col-4">
                    <div class="form-inline">
                      <h4>รูปภาพประกอบทั้งหมด</h4>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-9"></div>
                      <div class="col-3">
                        <div class="card-tools d-inline float-right">
                          <a href="{{ action('AnalysController@edit',[$type,$id,$fdate,$tdate,$branch,$status,$path]) }}" class="btn bg-danger">
                            <i class="far fa-arrow-alt-circle-left"></i> ย้อนกลับ
                            </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body text-sm">

                <input type="hidden" name="fdate" value="{{ $fdate }}" />
                <input type="hidden" name="tdate" value="{{ $tdate }}" />
                <input type="hidden" name="branch" value="{{ $branch }}" />
                <input type="hidden" name="status" value="{{ $status }}" />
                <input type="hidden" name="status" value="{{ $path }}" />

                @if($countData == 0)
                  <div class="col-md-12" align="center">
                    <p>ไม่มีรูปแล้ว</p>
                  </div>
                @else
                  <div class="row">
                    @foreach($data as $key => $row)
                      <div class="col-sm-2 ">
                        @if($created_at < $Currdate)
                          <a href="{{ asset('upload-image/'.$row->Name_fileimage) }}" data-toggle="lightbox" data-title="รูปภาพประกอบ">
                            <img src="{{ asset('upload-image/'.$row->Name_fileimage) }}" class="img-fluid mb-2 img-bordered" alt="white sample" style="width: 180px; height: 160px;" >
                          </a>
                        @else
                          <a href="{{ asset('upload-image/'.$path.'/'.$row->Name_fileimage) }}" data-toggle="lightbox" data-title="รูปภาพประกอบ">
                            <img src="{{ asset('upload-image/'.$path.'/'.$row->Name_fileimage) }}" class="img-fluid mb-2 img-bordered" alt="white sample" style="width: 180px; height: 160px;" >
                          </a>
                        @endif
                        <div align="center">
                          <a href="{{ action('AnalysController@destroyImage',[$type,$row->fileimage_id,$fdate,$tdate,$branch,$status,$path])}}?mainid={{$id}}" class="btn btn-danger btn-sm DeleteImage">
                            <span class="glyphicon glyphicon-trash"></span> ลบ
                          </a>
                          <br><br>
                        </div>
                      </div>
                    @endforeach
                  </div>
                @endif

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>


  <script>
    $(function () {
      $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
          alwaysShowClose: true
        });
      });
    })
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#table').DataTable( {
        "order": [[ 1, "asc" ]]
      } );
    });
  </script>

  <script type="text/javascript">
    $(".alert").fadeTo(3000, 1000).slideUp(1000, function(){
    $(".alert").alert('close');
    });
  </script>

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
@endsection
