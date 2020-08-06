<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ชูเกียรติลิสซิ่ง</title>
  <link rel="icon" href="{{ asset('dist/img/leasingLogo.png') }}" type="image/ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">


  <style>
    .a1 {color: #E6E6FA;}
    .a2 {color: #4A0B52;}
    .a3 {color: #262A5E;}
    .a4 {color: #B1692E;}
    .a5 {color: #207B15;}
    .a6 {color: #E6E6FA;}

    /* The container */
    .con {
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 25px;
      -webkit-user-select: 10px;
      -moz-user-select: 10px;
      -ms-user-select: 10px;
      user-select: 10px;
    }

    /* Hide the browser's default checkbox */
    .con input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;

    }

    /* Create a custom checkbox */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 20px;
      width: 20px;
      background-color: #999;
    }

    /* On mouse-over, add a grey background color */
    .con:hover input ~ .checkmark {
      background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .con input:checked ~ .checkmark {
      background-color: #008000;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the checkmark when checked */
    .con input:checked ~ .checkmark:after {
      display: block;
    }

    /* Style the checkmark/indicator */
    .con .checkmark:after {
      left: 9px;
      top: 5px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
  </style>

  <style>
    .con2 {
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 25px;
      -webkit-user-select: 10px;
      -moz-user-select: 10px;
      -ms-user-select: 10px;
      user-select: 10px;
    }

    .con2 input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }

    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 20px;
      width: 20px;
      background-color: #999;
    }

    .con2:hover input ~ .checkmark {
      background-color: #ccc;
    }

    .con2 input:checked ~ .checkmark {
      background-color: red;
    }

    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    .con2 input:checked ~ .checkmark:after {
      display: block;
    }

    .con2 .checkmark:after {
      left: 9px;
      top: 5px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
  </style>

  <style>
    .con3 {
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 25px;
      -webkit-user-select: 10px;
      -moz-user-select: 10px;
      -ms-user-select: 10px;
      user-select: 10px;
      border-radius: 25px;
    }

    .con3 input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
      border-radius: 25px;
    }

    .checkmark3 {
      position: absolute;
      top: 0;
      left: 0;
      height: 20px;
      width: 20px;
      background-color: #999;
      border-radius: 25px;
    }

    .con3:hover input ~ .checkmark3 {
      background-color: #ccc;
    }

    .con3 input:checked ~ .checkmark3 {
      background-color: blue;
    }

    .checkmark3:after {
      content: "";
      position: absolute;
      display: none;
      border-radius: 25px;
    }

    .con3 input:checked ~ .checkmark3:after {
      display: block;
    }

    .con3 .checkmark3:after {
      left: 9px;
      top: 5px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
  </style>

  <style>
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -6px;
        margin-left: -1px;
        -webkit-border-radius: 0 6px 6px 6px;
        -moz-border-radius: 0 6px 6px;
        border-radius: 0 6px 6px 6px;
    }

    .dropdown-submenu:hover>.dropdown-menu {
        display: block;
    }

    .dropdown-submenu>a:after {
        display: block;
        content: " ";
        float: right;
        width: 0;
        height: 0;
        border-color: transparent;
        border-style: solid;
        border-width: 5px 0 5px 5px;
        border-left-color: #ccc;
        margin-top: 5px;
        margin-right: -10px;
    }

    .dropdown-submenu:hover>a:after {
        border-left-color: #fff;
    }

    .dropdown-submenu.pull-left {
        float: none;
    }

    .dropdown-submenu.pull-left>.dropdown-menu {
        left: -100%;
        margin-left: 10px;
        -webkit-border-radius: 6px 0 6px 6px;
        -moz-border-radius: 6px 0 6px 6px;
        border-radius: 6px 0 6px 6px;
    }
  </style>

  <style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    body::-webkit-scrollbar {
      display: none;
    }
    /* Hide scrollbar for IE and Edge */
    body {
      -ms-overflow-style: none;
    }
  </style>
  
  <style>
    #button {
      display: inline-block;
      background-color: #FF9800;
      width: 50px;
      height: 50px;
      text-align: center;
      border-radius: 4px;
      position: fixed;
      bottom: 30px;
      right: 30px;
      transition: background-color .3s, 
        opacity .5s, visibility .5s;
      opacity: 0;
      visibility: hidden;
      z-index: 1000;
    }
    #button::after {
      content: "\f077";
      font-family: FontAwesome;
      font-weight: normal;
      font-style: normal;
      font-size: 2em;
      line-height: 50px;
      color: #fff;
    }
    #button:hover {
      cursor: pointer;
      background-color: #333;
    }
    #button:active {
      background-color: #555;
    }
    #button.show {
      opacity: 1;
      visibility: visible;
    }

    /* Styles for the content section */
  </style>

  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>

  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  
  <script src="{{asset('js/sweetAlert.js')}}"></script>
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  <script src="{{ asset('plugins/filterizr/jquery.filterizr.min.js') }}"></script>

  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>


</head>

<body  class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse" style="height: auto;">
  <!-- Site wrapper -->
  <div class="wrapper">

    <!-- =============================================== -->

    @include('layouts.header')
    @include('layouts.sidebar')

    <!-- =============================================== -->

    <div class="content-wrapper">
      @yield('content')
    </div>

    <div class="control-sidebar-bg"></div>

    <!-- โปรแกรมคำนวณค่างวด -->
    <form name="form">
      <div class="modal fade" id="modal-program">

        <script>
            function commas(nStr){
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
            function goProcess(){
              var Getyear = document.getElementById('Caryear').value;
              if(Getyear >= 2015 && Getyear <= 2020){
                var Getgroup = '2015 - 2020';
              }else if(Getyear >= 2012 && Getyear <= 2014){
                var Getgroup = '2012 - 2014';
              }else if(Getyear >= 2010 && Getyear <= 2011){
                var Getgroup = '2010 - 2011';
                }else if(Getyear >= 2009){
                var Getgroup = '2009';
                }else if(Getyear >= 2008){
                var Getgroup = '2008';
                }else if(Getyear >= 2007){
                var Getgroup = '2007';
                }else if(Getyear >= 2006){
                var Getgroup = '2006';
                }else if(Getyear >= 2005){
                var Getgroup = '2005';
                }else if(Getyear >= 2004){
                var Getgroup = '2004';
                }else if(Getyear >= 2003){
                var Getgroup = '2003';
                }else{
                Getgroup = '-';
              }
              document.form.Cargroup.value = Getgroup;
              var typedetail = document.getElementById('Cartype').value;
              var timelack = document.getElementById('Timelenght').value;
              if(typedetail == 'รถกระบะ' && Getgroup == '2015 - 2020'){
                // $("#Timelenght").append("<option value='1'>12</option><option value='1.5'>18</option><option value='2'>24</option><option value='2.5'>30</option><option value='3'>36</option><option value='3.5'>42</option><option value='4'>48</option><option value='4.5'>54</option><option value='5'>60</option><option value='5.5'>66</option><option value='6'>72</option><option value='6.5'>78</option><option value='7'>84</option>");
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '5.55';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '6.00';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '6.45';
                }else{
                document.form.Carinterest.value = '7.15';
                }
                }
              else if(typedetail == 'รถกระบะ' && Getgroup == '2012 - 2014'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '9.45';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '9.55';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '9.65';
                }else{
                document.form.Carinterest.value = '';
                }
                }
              else if(typedetail == 'รถกระบะ' && Getgroup == '2010 - 2011'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '10.80';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '10.90';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '11';
                }else{
                document.form.Carinterest.value = '';
                }
                }
              else if(typedetail == 'รถกระบะ' && Getgroup == '2009'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '12.45';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '12.55';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '12.65';
                }else{
                document.form.Carinterest.value = '';
                }
                }
              else if(typedetail == 'รถกระบะ' && Getgroup == '2008'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '14.35';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '14.45';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '14.55';
                }else{
                document.form.Carinterest.value = '';
                }
                }
              else if(typedetail == 'รถกระบะ' && Getgroup == '2007'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '14.45';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '14.55';
                }else{
                document.form.Carinterest.value = '';
                }
                }
              else if(typedetail == 'รถกระบะ' && Getgroup == '2006'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '14.55';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '14.75';
                }else{
                document.form.Carinterest.value = '';
                }
                }
              else if(typedetail == 'รถกระบะ' && Getgroup == '2005'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '18.65';
                }else{
                document.form.Carinterest.value = '';
                }
                }
              else if(typedetail == 'รถกระบะ' && Getgroup == '2004'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '18.65';
                }else{
                document.form.Carinterest.value = '';
                }
                }
              else if(typedetail == 'รถกระบะ' && Getgroup == '2003'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '18.65';
                }else{
                document.form.Carinterest.value = '';
                }
              }

              if(typedetail == 'รถตอนเดียว' && Getyear > 2014 && Getyear <= 2020){
                if(timelack == ''){
                  document.form1.Interestcar.value = '';
                }else if(timelack <= 5){
                  document.form1.Interestcar.value = '10.80';
                }else{
                  document.form1.Interestcar.value = '';
                }
              }
              else if(typedetail == 'รถตอนเดียว' && Getyear > 2012 && Getyear <= 2014){
                if(timelack == ''){
                  document.form1.Interestcar.value = '';
                }else if(timelack <= 5){
                  document.form1.Interestcar.value = '12.60';
                }else{
                  document.form1.Interestcar.value = '';
                }
              }
              else if(typedetail == 'รถตอนเดียว' && Getyear > 2009 && Getyear <= 2012){
                if(timelack == ''){
                  document.form1.Interestcar.value = '';
                }else if(timelack <= 5){
                  document.form1.Interestcar.value = '14.40';
                }else{
                  document.form1.Interestcar.value = '';
                }
              }
              else if(typedetail == 'รถตอนเดียว' && Getyear > 2007 && Getyear <= 2009){
                if(timelack == ''){
                  document.form1.Interestcar.value = '';
                }else if(timelack <= 4){
                  document.form1.Interestcar.value = '16.80';
                }else{
                  document.form1.Interestcar.value = '';
                }
              }
              else if(typedetail == 'รถตอนเดียว' && Getyear > 2005 && Getyear <= 2007){
                if(timelack == ''){
                  document.form1.Interestcar.value = '';
                }else if(timelack <= 4){
                  document.form1.Interestcar.value = '18.60';
                }else{
                  document.form1.Interestcar.value = '';
                }
              }
              else if(typedetail == 'รถตอนเดียว' && Getyear > 2003 && Getyear <= 2005){
                if(timelack == ''){
                  document.form1.Interestcar.value = '';
                }else if(timelack <= 3){
                  document.form1.Interestcar.value = '20.40';
                }else{
                  document.form1.Interestcar.value = '';
                }
              }

              if(typedetail == 'รถเก๋ง/7ที่นั่ง' && Getgroup == '2015 - 2020'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '6.05';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '6.50';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '6.95';
                }else{
                document.form.Carinterest.value = '7.65';
                }
              }
              else if(typedetail == 'รถเก๋ง/7ที่นั่ง' && Getgroup == '2012 - 2014'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '9.60';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '9.70';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '9.80';
                }else{
                document.form.Carinterest.value = '';
                }
              }
              else if(typedetail == 'รถเก๋ง/7ที่นั่ง' && Getgroup == '2010 - 2011'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '10.95';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '11.05';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '11.15';
                }else{
                document.form.Carinterest.value = '';
                }
              }
              else if(typedetail == 'รถเก๋ง/7ที่นั่ง' && Getgroup == '2009'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '12.60';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '12.70';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '12.80';
                }else{
                document.form.Carinterest.value = '';
                }
              }
              else if(typedetail == 'รถเก๋ง/7ที่นั่ง' && Getgroup == '2008'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '14.50';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '14.60';
                }else if(timelack > 5 && timelack <= 6){
                document.form.Carinterest.value = '14.70';
                }else{
                document.form.Carinterest.value = '';
                }
              }
              else if(typedetail == 'รถเก๋ง/7ที่นั่ง' && Getgroup == '2007'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '14.60';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '14.70';
                }else{
                document.form.Carinterest.value = '';
                }
              }
              else if(typedetail == 'รถเก๋ง/7ที่นั่ง' && Getgroup == '2006'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '14.70';
                }else if(timelack > 4 && timelack <= 5){
                document.form.Carinterest.value = '14.90';
                }else{
                document.form.Carinterest.value = '';
                }
              }
              else if(typedetail == 'รถเก๋ง/7ที่นั่ง' && Getgroup == '2005'){
                if(timelack == ''){
                document.form.Carinterest.value = '';
                }else if(timelack <= 4){
                document.form.Carinterest.value = '19.00';
                }else{
                document.form.Carinterest.value = '';
                }
              }

              var num11 = document.getElementById('Cartop').value;
              var num1 = num11.replace(",","");
              var num4 = document.getElementById('Timelenght').value;
              var num2 = document.getElementById('Carinterest').value;
              document.form.Cartop.value = commas(num1);

              $('#Cartype,#Caryear').change(function(){
                $('#Guestyear').hide();
                $('#Timelenght').show();
                if(Getyear > 2014 && Getyear <= 2020 ){
                  if(typedetail == 'รถตอนเดียว'){
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").show();
                    $("#Timelenght option[value='5']").show();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }else{
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").show();
                    $("#Timelenght option[value='5']").show();
                    $("#Timelenght option[value='5.5']").show();
                    $("#Timelenght option[value='6']").show();
                    $("#Timelenght option[value='6.5']").show();
                    $("#Timelenght option[value='7']").show();
                  }
                }
                else if(Getyear > 2009 && Getyear <= 2014 ){
                  if(typedetail == 'รถตอนเดียว'){
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").show();
                    $("#Timelenght option[value='5']").show();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }else{
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").show();
                    $("#Timelenght option[value='5']").show();
                    $("#Timelenght option[value='5.5']").show();
                    $("#Timelenght option[value='6']").show();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }
                }
                else if(Getyear > 2007 && Getyear <= 2009 ){
                  if(typedetail == 'รถตอนเดียว'){
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").hide();
                    $("#Timelenght option[value='5']").hide();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }else{
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").show();
                    $("#Timelenght option[value='5']").show();
                    $("#Timelenght option[value='5.5']").show();
                    $("#Timelenght option[value='6']").show();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }
                  }
                else if(Getyear > 2005 && Getyear <= 2007 ){
                  if(typedetail == 'รถตอนเดียว'){
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").hide();
                    $("#Timelenght option[value='5']").hide();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }else{
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").show();
                    $("#Timelenght option[value='5']").show();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }
                  }
                else if(Getyear > 2003 && Getyear <= 2005 ){
                  if(typedetail == 'รถตอนเดียว'){
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").hide();
                    $("#Timelenght option[value='4']").hide();
                    $("#Timelenght option[value='4.5']").hide();
                    $("#Timelenght option[value='5']").hide();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }else{
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").hide();
                    $("#Timelenght option[value='5']").hide();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }
                  }
                else if(Getyear > 2003 && Getyear <= 2005 ){
                  if(typedetail == 'รถตอนเดียว'){
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").hide();
                    $("#Timelenght option[value='4']").hide();
                    $("#Timelenght option[value='4.5']").hide();
                    $("#Timelenght option[value='5']").hide();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }else{
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").hide();
                    $("#Timelenght option[value='5']").hide();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }
                  }
                else if(Getyear > 2002 && Getyear <= 2003 ){
                  if(typedetail == 'รถตอนเดียว'){
                    $("#Timelenght option[value='1']").hide();
                    $("#Timelenght option[value='1.5']").hide();
                    $("#Timelenght option[value='2']").hide();
                    $("#Timelenght option[value='2.5']").hide();
                    $("#Timelenght option[value='3']").hide();
                    $("#Timelenght option[value='3.5']").hide();
                    $("#Timelenght option[value='4']").hide();
                    $("#Timelenght option[value='4.5']").hide();
                    $("#Timelenght option[value='5']").hide();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }else{
                    $("#Timelenght option[value='1']").show();
                    $("#Timelenght option[value='1.5']").show();
                    $("#Timelenght option[value='2']").show();
                    $("#Timelenght option[value='2.5']").show();
                    $("#Timelenght option[value='3']").show();
                    $("#Timelenght option[value='3.5']").show();
                    $("#Timelenght option[value='4']").show();
                    $("#Timelenght option[value='4.5']").hide();
                    $("#Timelenght option[value='5']").hide();
                    $("#Timelenght option[value='5.5']").hide();
                    $("#Timelenght option[value='6']").hide();
                    $("#Timelenght option[value='6.5']").hide();
                    $("#Timelenght option[value='7']").hide();
                  }
                  }
                else{
                  $("#Timelenght option[value='1']").hide();
                  $("#Timelenght option[value='1.5']").hide();
                  $("#Timelenght option[value='2']").hide();
                  $("#Timelenght option[value='2.5']").hide();
                  $("#Timelenght option[value='3']").hide();
                  $("#Timelenght option[value='3.5']").hide();
                  $("#Timelenght option[value='4']").hide();
                  $("#Timelenght option[value='4.5']").hide();
                  $("#Timelenght option[value='5']").hide();
                  $("#Timelenght option[value='5.5']").hide();
                  $("#Timelenght option[value='6']").hide();
                  $("#Timelenght option[value='6.5']").hide();
                  $("#Timelenght option[value='7']").hide();
                }
              });

              if(num4 == '1'){
                var period = '12';
                }else if(num4 == '1.5'){
                var period = '18';
                }else if(num4 == '2'){
                var period = '24';
                }else if(num4 == '2.5'){
                var period = '30';
                }else if(num4 == '3'){
                var period = '36';
                }else if(num4 == '3.5'){
                var period = '42';
                }else if(num4 == '4'){
                var period = '48';
                }else if(num4 == '4.5'){
                var period = '54';
                }else if(num4 == '5'){
                var period = '60';
                }else if(num4 == '5.5'){
                var period = '66';
                }else if(num4 == '6'){
                var period = '72';
                }else if(num4 == '6.5'){
                var period = '78';
                }else if(num4 == '7'){
                var period = '84';
              }

              var totaltopcar = parseFloat(num1);
              var a = (num2*num4)+100;
              var b = (((totaltopcar*a)/100)*1.07)/period;
              var result = Math.ceil(b/10)*10;
              var durate = result/1.07;
              var durate2 = durate.toFixed(2)*period;
              var tax = result-durate;
              var tax2 = tax.toFixed(2)*period;
              var total = result*period;
              var total2 = durate2+tax2;

              if(!isNaN(result)){
                document.form.Carpay.value = commas(result.toFixed(0));
                document.form.Cartop.value = commas(totaltopcar);
              }
            }
        </script>

        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title" align="center">โปรแกรมคำนวณค่างวด</h4>
            </div>
            <div class="modal-body">
              <br>
              <div class="row">
                  <div class="col-md-10">
                    <div class="form-inline" align="right">
                      <label>ยอดจัด : </label>
                      <input type="text" id="Cartop" name="Cartop" class="form-control" style="width: 250px;" maxlength="9" placeholder="กรอกยอดจัด" oninput="goProcess();" />
                    </div>
                  </div>
                  <div class="col-md-2">
                  <div class="form-inline" align="right">

                  </div>
                  </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-inline" align="right">
                    <label>ประเภทรถ : </label>
                    <select id="Cartype" name="Cartype" class="form-control" style="width: 250px;" onchange="goProcess();">
                      <option value="" selected>--- ประเภทรถ ---</option>
                      <option value="รถกระบะ">รถกระบะ</option>
                      <option value="รถตอนเดียว">รถตอนเดียว</option>
                      <option value="รถเก๋ง/7ที่นั่ง">รถเก๋ง/7ที่นั่ง</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-2">
                <div class="form-inline" align="right">
                </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-inline" align="right">
                    <label>ปี : </label>
                    <select id="Caryear" name="Caryear" class="form-control" style="width: 250px;" onchange="goProcess();">
                      <option value="" selected>--- เลือกปี ---</option>
                      @php
                          $Tempyear = date('Y');
                      @endphp
                      @for ($i = 0; $i < 20; $i++)
                          <option value="{{ $Tempyear }}">{{ $Tempyear }}</option>
                          @php
                              $Tempyear -= 1;
                          @endphp
                      @endfor
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-inline" align="right">
                    <input type="text" id="Cargroup" name="Cargroup" class="form-control" style="width: 120px;display:none;" onchange="goProcess();"/>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-inline" align="right">
                    <label>ระยะเวลาผ่อน : </label>
                    <input type="text" id="Guestyear" class="form-control" style="width: 250px;" readonly />
                    <select id="Timelenght" name="Timelenght" class="form-control" style="width: 250px;display:none;" onchange="goProcess();">
                      <option value="" selected>--- ระยะเวลาผ่อน ---</option>
                      <option value="1">12</option>
                      <option value="1.5">18</option>
                      <option value="2">24</option>
                      <option value="2.5">30</option>
                      <option value="3">36</option>
                      <option value="3.5">42</option>
                      <option value="4">48</option>
                      <option value="4.5">54</option>
                      <option value="5">60</option>
                      <option value="5.5">66</option>
                      <option value="6">72</option>
                      <option value="6.5">78</option>
                      <option value="7">84</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                <div class="form-inline" align="right">

                </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-inline" align="right">
                    <label>ดอกเบี้ย: </label>
                    <input type="text" id="Carinterest" name="Carinterest" class="form-control" style="width: 250px;" placeholder="ดอกเบี้ย" readonly onchange="goProcess();"/>
                  </div>
                </div>
                <div class="col-md-2">
                <div class="form-inline" align="right">

                </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-inline" align="right">
                    <label>ชำระต่องวด : </label>
                    <input type="text" id="Carpay" name="Carpay" class="form-control" style="width: 220px;padding:40px;font-size:40px;" readonly onchange="goProcess();" />
                    <label>บาท</label>
                  </div>
                </div>

                <div class="col-md-2">
                <div class="form-inline" align="right">

                </div>
                </div>
              </div>
              <hr>
            <div class="footer" align="center">
              <button type="button" class="btn btn-danger" data-dismiss="modal"> ปิด <i class="fa fa-times-circle"></i> </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </form>
    <!-- โปรแกรมคำนวณค่างวด -->

  </div>

</body>
</html>
