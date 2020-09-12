<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ชูเกียรติเงินกู้ Ploan-Micro</title>
  <link rel="icon" href="{{ asset('dist/img/leasing03.png') }}" type="image/ico" />
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

  <script>
    function blinker() {
    $('.prem').fadeOut(2000);
    $('.prem').fadeIn(2000);
    }
    setInterval(blinker, 3000);
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

  </div>

</body>
</html>
