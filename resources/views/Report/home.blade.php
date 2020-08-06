@extends('layouts.master')
@section('title','รายงานใบเบิกเงิน')
@section('content')

@php
  date_default_timezone_set('Asia/Bangkok');
  $date = date('Y-m-d', strtotime('-1 days'));
@endphp

@php
function DateThai($strDate){
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));
  $strMonthCut = Array("" , "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
}
@endphp

  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

  <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

    <section class="content-header">
      <h1>
        รายงานใบเบิกเงิน
        <small>it all starts here</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <!-- <div class="box-header with-border">
          <ul class="nav nav-pills ml-auto p-2">
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('finance', 1) }}">ประเภทจัดประจำเดือน</a>
            </li>
          </ul>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div> -->

          <div class="box-body">
            @if(session()->has('success'))
              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <strong>สำเร็จ!</strong> {{ session()->get('success') }}
              </div>
            @endif

            <form method="get" action="{{ route('finance', 1) }}">
              <div align="right" class="form-inline">
                <a target="_blank" href="{{ route('finance', 2) }}" class="btn btn-primary btn-app">
                  <span class="glyphicon glyphicon-print"></span> ปริ้นรายการ
                </a>

                <button type="submit" class="btn btn-warning btn-app">
                  <span class="glyphicon glyphicon-search"></span> Search
                </button>
                <p></p>
              </div>
            </form>

            <table class="table table-bordered" style="width: 70%" align="center">
              <thead class="thead-light bg-gray-light">
                <tr>
                  <!-- <td><center>แบบ</center></td>
                  <td><center>ปัตตานี (01)</center></td>
                  <td><center>ยะลา (03)</center></td>
                  <td><center>นราธิวาส (04)</center></td>
                  <td><center>สายบุรี (05)</center></td>
                  <td><center>สุไหงโก-ลก (06)</center></td>
                  <td><center>เบตง (07)</center></td>
                  <td><center>ยอดรวม</center></td> -->
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <br>
          </div>
        <script type="text/javascript">
          $(function() {
             $('#table1, #table2, #table22, #table3, #table33, #table4, #table44, #table5, #table55, #table6, #table66, #table7, #table77').DataTable(
               {
                 "ordering" : false,
                 "lengthChange" : false,
                 "paging" : false,
                 "searching" : false,
                 "info" : true,
                 "autoWidth" : true,
                  "oLanguage": {
                  "sLengthMenu": "แสดง _MENU_ รายการ ต่อหนึ่งหน้า",
                  "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                  "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ",
                  "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
                  "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ รายการ)",
                  "oPaginate": {
                  "sFirst": "หน้าแรก",
                  "sPrevious": "ก่อนหน้า",
                  "sNext": "ถัดไป",
                  "sLast": "หน้าสุดท้าย"
                  },
                  "sSearch": "ค้นหา :"
                  }
                  } );
                  }
             );
        </script>
        <script>
          $(".alert").fadeTo(3000, 500).slideUp(500, function(){
          $(".alert").alert('close');
          });
        </script>
      </div>
    </section>

    <div class="modal fade" id="modal-default" style="display: none;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Default Modal</h4>
          </div>
          <!-- send link to viewdetail page -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

@endsection
