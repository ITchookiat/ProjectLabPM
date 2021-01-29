@php
  function active($currect_page) {
    $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
    $url = end($url_array);
    if($currect_page == $url) {
      echo 'active'; //class name in css
    }
  }
@endphp

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4 sidebar-dark-warning">
    <!-- Brand Logo -->
    <a href="{{ route('index','home') }}" class="brand-link">
      <img src="{{ asset('dist/img/ploan.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CHOOKIAT LABPM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->username }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview {{ Request::is('MasterAnalysis') ? 'menu-open' : '' }} {{ Request::is('Analysis/*') ? 'menu-open' : '' }}{{ Request::is('DataCustomer/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa fa-sitemap"></i>
              <p>
                ระบบเงินกู้
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            
            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก จัดไฟแนนท์" or auth::user()->type == "แผนก การเงินใน")
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview {{ Request::is('MasterAnalysis') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/7') ? 'menu-open' : '' }} {{ Request::is('Analysis/edit/1/*') ? 'menu-open' : '' }}
                                                 {{ Request::is('Analysis/deleteImageEach/1/*/*/*/*/*/*') ? 'menu-open' : '' }} {{ Request::is('DataCustomer/Home/1') ? 'menu-open' : '' }} {{ Request::is('DataCustomer/Home/2') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link">
                    <i class="far fa-window-restore text-red nav-icon"></i>
                    <p>
                      PLoan - Micro
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="margin-left: 15px;">
                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก จัดไฟแนนท์" or auth::user()->type == "แผนก การเงินใน")
                        <li class="nav-item">
                          @php
                            if (isset($_GET['type'])) {
                              if ($_GET['type'] == 1 || $_GET['type'] == 2) {
                                $SetActive1 = true;
                              }
                            }
                          @endphp
                          <a href="{{ route('MasterAnalysis.index') }}?type={{1}}" class="nav-link @if(isset($SetActive1)) {{($SetActive1 == true) ? 'active' : '' }} @endif {{ Request::is('Analysis/Home/1') ? 'active' : '' }} {{ Request::is('Analysis/Home/2') ? 'active' : '' }} {{ Request::is('Analysis/edit/1/*/*/*/*/*') ? 'active' : '' }} {{ Request::is('DataCustomer/Home/1') ? 'active' : '' }}">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>เงินกู้รถยนต์</p>
                          </a>
                          <a href="{{ route('MasterAnalysis.index') }}?type={{3}}" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>เงินกู้จักรยานยนต์</p>
                          </a>
                        </li>
                      @endif
                  </ul>
                </li>
              </ul>
            @endif
          </li>

          <li class="nav-item has-treeview {{ Request::is('Treasury/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <span style="color: blue;" id="ShowData"></span>
              {{-- <span class="badge badge-danger navbar-badge">3</span> --}}
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                แผนกการเงิน
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก การเงินใน" or auth::user()->type == "แผนก วิเคราะห์")
              <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                  <a href="{{ route('treasury', 1) }}" class="nav-link {{ Request::is('Treasury/Home/1') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Approving Transfers</p>
                  </a>
                </li>
              </ul>
            @endif
          </li>

          <li class="nav-item has-treeview {{ Request::is('Account/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon fab fa-leanpub"></i>
              <span id="ShowData"></span>
              <p>
                แผนกบัญชี
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก บัญชี" or auth::user()->type == "แผนก วิเคราะห์")
              <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                  <a href="{{ route('Accounting', 1) }}" class="nav-link {{ Request::is('Account/Home/1') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Internal Audit</p>
                  </a>
                  <a href="{{ route('Accounting', 3) }}" class="nav-link {{ Request::is('Account/Home/3') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Report PLoan-Micro</p>
                  </a>
                </li>
              </ul>
            @endif
          </li>

          @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก ประกันภัย")
          <li class="nav-item has-treeview {{ Request::is('Insure/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa fa-gg-circle"></i>
              <span id="ShowData"></span>
              <p>
                แผนกประกันภัย
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

              <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                  <a href="{{ route('Insure', 1) }}" class="nav-link {{ Request::is('Insure/Home/1') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>สต็อกรถใช้งานบริษัท</p>
                  </a>
                </li>
              </ul>
          </li>
          @endif

          {{-- <li class="nav-header">Documents Part</li>

          <li class="nav-item has-treeview {{ Request::is('Document/*') ? 'menu-open' : '' }}">
            <a href="{{ route('document', 1) }}" class="nav-link active bg-yellow">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Data warehouse
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
              <!-- <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                  <a href="{{ route('document', 1) }}" class="nav-link {{ Request::is('Document/Home/1') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>รายการเอกสาร</p>
                  </a>
                </li>
              </ul> -->
          </li> --}}
        </ul>
      </nav>
    </div>
  </aside>

  <script type="text/javascript">
    SearchData(); //เรียกใช้งานทันที
    var Data = setInterval(() => {SearchData()}, 10000);

    function SearchData(){ 
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url:"{{ route('SearchData', [3, 0]) }}",
        method:"GET",
        data:{},
    
        success:function(result){ //เสร็จแล้วทำอะไรต่อ
          $('#ShowData').html(result);
        }
      });
    };
  </script>