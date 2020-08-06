
<section class="content">
  <div class="card card-warning">
    <div class="card-header">
      <h4 class="card-title">
        @if($type == 2)
          รายงานอนุมัติประจำวัน
        @elseif($type == 3)
          รายงานโอนเงินประจำวัน
        @endif
      </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>

    <div class="card-body">
      @if ($type == 2)
        <form name="form1" action="{{ route('treasury.ReportDueDate' , 2) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>จากวันที่ : </label>
                <input type="date" name="Fromdate" class="form-control" value="{{ date('Y-m-d') }}" style="width: 170px;"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="float-right form-inline">
                <label>ถึงวันที่ : </label>
                <input type="date" name="Todate" class="form-control" value="{{ date('Y-m-d') }}" style="width: 170px;"/>
              </div>
            </div>
          </div>

          <p></p>
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
              <div class="form-inline">
                <button type="submit" class="btn bg-primary btn-app">
                  <i class="fas fa-print"></i> ปริ้น
                </button>
                <a class="btn btn-app bg-danger" href="{{ URL::previous() }}">
                  <i class="fas fa-times"></i> ยกเลิก
                </a>
              </div>
            </div>
          </div>

          <input type="hidden" name="_token" value="{{csrf_token()}}" />
        </form>
      @elseif ($type == 3)
        <form name="form1" action="{{ route('treasury.ReportDueDate' , 3) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-5">
              <div class="float-right form-inline">
                <label>จากวันที่ : </label>
                <input type="date" name="Fromdate" class="form-control" value="{{ date('Y-m-d') }}" style="width: 170px;"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="float-right form-inline">
                <label>ถึงวันที่ : </label>
                <input type="date" name="Todate" class="form-control" value="{{ date('Y-m-d') }}" style="width: 170px;"/>
              </div>
            </div>
          </div>

          <p></p>
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
              <div class="form-inline">
                <button type="submit" class="btn bg-primary btn-app">
                  <i class="fas fa-print"></i> ปริ้น
                </button>
                <a class="btn btn-app bg-danger" href="{{ URL::previous() }}">
                  <i class="fas fa-times"></i> ยกเลิก
                </a>
              </div>
            </div>
          </div>

          <input type="hidden" name="_token" value="{{csrf_token()}}" />
        </form>
      @endif
    </div>
  </div>
</section>

