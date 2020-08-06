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
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('index','home') }}" class="brand-link">
      <img src="{{ asset('dist/img/leasingLogo1.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CHOOKIAT LEASING</span>
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
          @if(auth::user()->type == "Admin")
            <li class="nav-item has-treeview {{ Request::is('maindata/view*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-window-restore"></i>
                <p>
                  ข้อมูลหลัก
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                  <a href="{{ route('ViewMaindata') }}" class="nav-link active">
                    <i class="far fa-id-badge text-red nav-icon"></i>
                    <p>ข้อมูลผู้ใช้งานระบบ</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif

          <li class="nav-item has-treeview {{ Request::is('Analysis/*') ? 'menu-open' : '' }}{{ Request::is('DataCustomer/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa fa-sitemap"></i>
              <p>
                ระบบสินเชื่อ
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            
            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก จัดไฟแนนท์" or auth::user()->type == "แผนก รถบ้าน" or auth::user()->type == "แผนก การเงินใน")
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview {{ Request::is('Analysis/Home/1') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/2') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/3') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/4') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/5') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/6') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/7') ? 'menu-open' : '' }} {{ Request::is('Analysis/edit/1/*') ? 'menu-open' : '' }} {{ Request::is('Analysis/edit/4/*') ? 'menu-open' : '' }} {{ Request::is('Analysis/deleteImageEach/1/*') ? 'menu-open' : '' }} {{ Request::is('Analysis/deleteImageEach/4/*') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link">
                    <i class="far fa-window-restore text-red nav-icon"></i>
                    <p>
                      PLoan - Micro
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="margin-left: 15px;">
                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก รถบ้าน" or auth::user()->type == "แผนก การเงินใน" or auth::user()->branch == 01 or auth::user()->branch == 03 or auth::user()->branch == 04 or auth::user()->branch == 05 or auth::user()->branch == 06 or auth::user()->branch == 07)
                        <li class="nav-item">
                          <a href="{{ route('Analysis',1) }}" class="nav-link {{ Request::is('Analysis/Home/1') ? 'active' : '' }} {{ Request::is('Analysis/Home/2') ? 'active' : '' }} {{ Request::is('Analysis/edit/1/*/*/*/*/*') ? 'active' : '' }}">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>PLoan-Micro</p>
                          </a>
                          <a href="{{ route('Analysis',3) }}" class="nav-link {{ Request::is('Analysis/Home/3') ? 'active' : '' }}">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Report PLoan-Micro</p>
                          </a>
                        </li>
                      @endif
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview {{ Request::is('DataCustomer/Home/1') ? 'menu-open' : '' }} {{ Request::is('DataCustomer/Home/2') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link">
                    <i class="far fa-window-restore text-red nav-icon"></i>
                    <p>
                      Model Walk-in
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="margin-left: 15px;">
                      @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก รถบ้าน" or auth::user()->type == "แผนก การเงินใน" or auth::user()->branch == 01 or auth::user()->branch == 03 or auth::user()->branch == 04 or auth::user()->branch == 05 or auth::user()->branch == 06 or auth::user()->branch == 07)
                        <li class="nav-item">
                          <a href="{{ route('DataCustomer',1) }}" class="nav-link {{ Request::is('DataCustomer/Home/1') ? 'active' : '' }}">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Customer Walk-in</p>
                          </a>
                          <a href="{{ route('DataCustomer',2) }}" class="nav-link {{ Request::is('DataCustomer/Home/2') ? 'active' : '' }}">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Report Walk-in</p>
                          </a>
                        </li>
                      @endif
                  </ul>
                </li>
              </ul>
            @endif
          </li>

          {{-- <li class="nav-item has-treeview {{ Request::is('Precipitate/*') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/8') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/9') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/10') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/11') ? 'menu-open' : '' }} {{ Request::is('Analysis/edit/8/*') ? 'menu-open' : '' }} {{ Request::is('Analysis/deleteImageEach/8/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon far fa-handshake"></i>
              <p>
                แผนกเร่งรัด
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก เร่งรัด")
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview {{ Request::is('Precipitate/Home/3') ? 'menu-open' : '' }} {{ Request::is('Precipitate/Home/1') ? 'menu-open' : '' }} {{ Request::is('Precipitate/Home/4') ? 'menu-open' : '' }} {{ Request::is('Precipitate/Home/5') ? 'menu-open' : '' }} {{ Request::is('Precipitate/Home/11') ? 'menu-open' : '' }} {{ Request::is('Precipitate/Home/6') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/8') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/9') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/10') ? 'menu-open' : '' }} {{ Request::is('Analysis/Home/11') ? 'menu-open' : '' }} {{ Request::is('Analysis/edit/8/*') ? 'menu-open' : '' }} {{ Request::is('Analysis/deleteImageEach/8/*') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link">
                    <i class="far fa-window-restore text-red nav-icon"></i>
                    <p>
                      ระบบ
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="margin-left: 15px;">
                    <li class="nav-item">
                      <a href="{{ route('Precipitate',3) }}" class="nav-link {{ Request::is('Precipitate/Home/3') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>ระบบแจ้งเตือนติดตาม</p>
                      </a>
                      <a href="{{ route('Precipitate',1) }}" class="nav-link {{ Request::is('Precipitate/Home/1') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>ระบบปล่อยงาน</p>
                      </a>
                      <a href="{{ route('Precipitate',5) }}" class="nav-link {{ Request::is('Precipitate/Home/5') ? 'active' : '' }} {{ Request::is('Precipitate/Home/6') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>ระบบสต็อกรถเร่งรัด</p>
                      </a>
                      <a href="{{ route('Analysis',8) }}" class="nav-link {{ Request::is('Analysis/Home/8') ? 'active' : '' }} {{ Request::is('Analysis/Home/9') ? 'active' : '' }} {{ Request::is('Analysis/edit/8/*/*/*/*/*') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>ระบบปรับโครงสร้างหนี้</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>

              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview {{ Request::is('Precipitate/Home/2') ? 'menu-open' : '' }} {{ Request::is('Precipitate/Home/7') ? 'menu-open' : '' }} {{ Request::is('Precipitate/Home/8') ? 'menu-open' : '' }} {{ Request::is('Precipitate/Home/9') ? 'menu-open' : '' }} {{ Request::is('Precipitate/Home/10') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link">
                    <i class="far fa-window-restore text-red nav-icon"></i>
                    <p>
                      รายงาน
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="margin-left: 15px;">
                    <li class="nav-item">
                      <a href="{{ route('Precipitate',2) }}" class="nav-link {{ Request::is('Precipitate/Home/2') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>รายงาน แยกตามทีม</p>
                      </a>
                      <a href="{{ route('Precipitate',7) }}" class="nav-link {{ Request::is('Precipitate/Home/7') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>รายงาน งานประจำวัน</p>
                      </a>
                      <a href="{{ route('Precipitate',8) }}" class="nav-link {{ Request::is('Precipitate/Home/8') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>รายงาน รับชำระค่าติดตาม</p>
                      </a>
                      <a href="{{ route('Precipitate',9) }}" class="nav-link {{ Request::is('Precipitate/Home/9') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>รายงาน ใบรับฝาก</p>
                      </a>
                      <a href="{{ route('Precipitate',10) }}" class="nav-link {{ Request::is('Precipitate/Home/10') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>รายงาน หนังสือขอยืนยัน</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            @endif
          </li> --}}

          {{-- <li class="nav-item has-treeview {{ Request::is('Legislation/*') ? 'menu-open' : '' }} {{ Request::is('Legislation/edit/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-gavel"></i>
              <p>
                แผนกกฏหมาย
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก กฏหมาย" or auth::user()->type == "แผนก เร่งรัด" or auth::user()->type == "แผนก การเงินนอก")
              <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                  <a href="{{ route('legislation',1) }}" class="nav-link {{ Request::is('Legislation/Home/1') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>รายชื่อส่งฟ้อง</p>
                  </a>
                  <a href="{{ route('legislation',6) }}" class="nav-link {{ Request::is('Legislation/Home/6') ? 'active' : '' }} {{ Request::is('Legislation/edit/*/6') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>ลูกหนี้เตรียมฟ้อง</p>
                  </a>
                  <a href="{{ route('legislation',2) }}" class="nav-link {{ Request::is('Legislation/Home/2') ? 'active' : '' }} {{ Request::is('Legislation/edit/*/2') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>ลูกหนี้ฟ้อง</p>
                  </a>
                  <a href="{{ route('legislation',8) }}" class="nav-link {{ Request::is('Legislation/Home/8') ? 'active' : '' }} {{ Request::is('Legislation/edit/*/8') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>ลูกหนี้สืบทรัพย์</p>
                  </a>
                  <a href="{{ route('legislation',7) }}" class="nav-link {{ Request::is('Legislation/Home/7') ? 'active' : '' }} {{ Request::is('Legislation/edit/*/4') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>ลูกหนี้ประนอมหนี้</p>
                  </a>
                  <a href="{{ route('legislation',10) }}" class="nav-link {{ Request::is('Legislation/Home/10') ? 'active' : '' }} {{ Request::is('Legislation/edit/*/10') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>ลูกหนี้ของกลาง</p>
                  </a>
                </li>
              </ul>
            @endif
          </li> --}}

          <li class="nav-item has-treeview {{ Request::is('Treasury/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <span id="ShowData"></span>
              {{-- <span class="badge badge-danger navbar-badge">3</span> --}}
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                แผนกการเงิน
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก การเงินใน")
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

            @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก บัญชี")
              <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                  <a href="{{ route('Accounting', 1) }}" class="nav-link {{ Request::is('Account/Home/1') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Internal Audit</p>
                  </a>
                  <a href="{{ route('Accounting', 3) }}" class="nav-link {{ Request::is('Account/Home/3') ? 'active' : '' }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Report Credit</p>
                  </a>
                </li>
              </ul>
            @endif
          </li>

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