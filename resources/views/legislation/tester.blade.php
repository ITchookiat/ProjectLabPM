@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
@section('content')

      <section class="content-header">
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="box box-danger box-solid">
          <div class="box-body">
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="type" class="control-label">ประเภทรถ : </label>
                            <select id="type" class="form-control" onchange="dochange('{{ route('get-json') }}', 'type', this.value, '', 'year');">
                                <option value="0">- เลือกรถ -</option>
                                <option value="1">- รถกระบะ -</option>
                                <option value="2">- รถเก๋ง -</option>
                                <option value="3">- รถตอนเดียว -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="year" class="control-label">ปี : </label>
                            <select id="year" class="form-control"
                                onchange="dochange('{{ route('get-json') }}', 'year', document.getElementById('type').value, this.value, 'interest');">
                                <option value='0'>- เลือกปี -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="interest" class="control-label">งวด : </label>
                            <select id="interest" class="form-control"
                                onchange="dochange('{{ route('get-json') }}', 'interest', document.getElementById('interest').value, this.value, 'showtext');">
                                <option value='0'>- งวด -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="showtext" class="control-label">ดอกเบี้ย : </label>
                            <select id="showtext" class="form-control">
                                <option value='0'>- ดอกเบี้ย -</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>

    </section>
@endsection
