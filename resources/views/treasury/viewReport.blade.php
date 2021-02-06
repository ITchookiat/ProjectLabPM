
<section class="content">
  <div class="card card-warning">
    <div class="card-header">
      <h4 class="card-title">
        @if($type == 2)
          รายงานอนุมัติประจำวัน (Ploan)
        @elseif($type == 3)
          รายงานอนุมัติประจำวัน (Micro)
        @endif
      </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>

    <div class="card-body text-sm">
      @if ($type == 2)
        <form name="form1" action="{{ route('treasury.ReportDueDate' , 101) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
      @elseif ($type == 3)
        <form name="form1" action="{{ route('treasury.ReportDueDate' , 102) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
      @endif
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="form-group row mb-1">
              <label class="col-sm-4 col-form-label text-right">จากวันที่ :</label>
              <div class="col-sm-8">
                <input type="date" name="Fromdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm"/>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group row mb-1">
              <label class="col-sm-4 col-form-label text-right">ถึงวันที่ :</label>
              <div class="col-sm-8">
                <input type="date" name="Todate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm"/>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary text-center">
            <i class="fas fa-print"></i> ปริ้น
          </button>
          <a type="button" class="btn btn-danger" href="{{ URL::previous() }}">
            <i class="fas fa-times"></i> ยกเลิก
          </a>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
      </form>
    </div>
  </div>
</section>

