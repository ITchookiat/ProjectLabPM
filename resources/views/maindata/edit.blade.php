@extends('layouts.master')
@section('title','ข้อมูลหลัก')
@section('content')

  <!-- Main content -->
  <section class="content">
    <div class="content-header">
      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
            <li>กรุณากรอกข้อมูลให้ครบช่อง {{$error}}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="" style="text-align:center;"><b>ข้อมูลสมาชิกผู้ใช้งาน</b></h3>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-12"> <br />
                    <form method="post" action="{{ action('UserController@update',$id) }}" enctype="multipart/form-data">
                      @csrf
                      @method('put')

                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>Username : </label>
                            <input type="text" name="main_username" class="form-control" style="width: 400px;" placeholder="ป้อนชื่อผู้ใช้" value="{{$user->username}}" />
                          </div>
                        </div>
                      </div>
    
                      <br>
                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>Name : </label>
                            <input type="text" name="main_name" class="form-control" style="width: 400px;" placeholder="ป้อนชื่อ" value="{{$user->name}}" />
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>Enail : </label>
                            <input type="text" name="main_email" class="form-control" style="width: 400px;" placeholder="ป้อนอีเมลล์" value="{{$user->email}}" />
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>สาขา : </label>
                            <select name="branch" class="form-control" style="width: 400px;">
                              <option value="" selected>--------- สาขา ----------</option>
                              <option value="99" {{ ($user->branch === '99') ? 'selected' : '' }}>Admin</option>
                              <option value="01" {{ ($user->branch === '01') ? 'selected' : '' }}>สาขา ปัตตานี</option>
                              <option value="03" {{ ($user->branch === '03') ? 'selected' : '' }}>สาขา ยะลา</option>
                              <option value="04" {{ ($user->branch === '04') ? 'selected' : '' }}>สาขา นราธิวาส</option>
                              <option value="05" {{ ($user->branch === '05') ? 'selected' : '' }}>สาขา สายบุรี</option>
                              <option value="06" {{ ($user->branch === '06') ? 'selected' : '' }}>สาขา โกลก</option>
                              <option value="07" {{ ($user->branch === '07') ? 'selected' : '' }}>สาขา เบตง</option>
                              <option value="10" {{ ($user->branch === '10') ? 'selected' : '' }}>สาขา รถบ้าน</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>แผนก : </label>
                            <select name="section_type" class="form-control" style="width: 400px;">
                              <option value="" selected>--------- แผนก ----------</option>
                              <option value="Admin" {{ ($user->type === 'Admin') ? 'selected' : '' }}>Admin</option>
                              <option value="แผนก วิเคราะห์" {{ ($user->type === 'แผนก วิเคราะห์') ? 'selected' : '' }}>แผนก วิเคราะห์</option>
                              <option value="แผนก จัดไฟแนนท์" {{ ($user->type === 'แผนก จัดไฟแนนท์') ? 'selected' : '' }}>แผนก จัดไฟแนนท์</option>
                              <option value="แผนก รถบ้าน" {{ ($user->type === 'แผนก รถบ้าน') ? 'selected' : '' }}>แผนก รถบ้าน</option>
                              <option value="แผนก กฏหมาย" {{ ($user->type === 'แผนก กฏหมาย') ? 'selected' : '' }}>แผนก กฏหมาย</option>
                              <option value="แผนก เร่งรัด" {{ ($user->type === 'แผนก เร่งรัด') ? 'selected' : '' }}>แผนก เร่งรัด</option>
                              <option value="แผนก การเงินนอก" {{ ($user->type === 'แผนก การเงินนอก') ? 'selected' : '' }}>แผนก การเงินนอก</option>
                              <option value="แผนก การเงินใน" {{ ($user->type === 'แผนก การเงินใน') ? 'selected' : '' }}>แผนก การเงินใน</option>
                              <option value="แผนก บัญชี" {{ ($user->type === 'แผนก บัญชี') ? 'selected' : '' }}>แผนก บัญชี</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>ตำแหน่ง : </label>
                            <select name="position" class="form-control" style="width: 400px;">
                              <option value="" selected>--------- ตำแหน่ง ----------</option>
                              <option value="Admin" {{ ($user->position === 'Admin') ? 'selected' : '' }}>Admin</option>
                              <option value="MANAGER" {{ ($user->position === 'MANAGER') ? 'selected' : '' }}>MANAGER</option>
                              <option value="AUDIT" {{ ($user->position === 'AUDIT') ? 'selected' : '' }}>AUDIT</option>
                              <option value="MASTER" {{ ($user->position === 'MASTER') ? 'selected' : '' }}>MASTER</option>
                              <option value="STAFF" {{ ($user->position === 'STAFF') ? 'selected' : '' }}>STAFF</option>
                            </select>
                          </div>
                        </div>
                      </div>
    
                      <br>
                      <div class="form-group" align="center">
                        <button type="submit" class="delete-modal btn btn-success">
                          <span class="glyphicon glyphicon-floppy-save"></span> อัพเดท
                        </button>
                        <a class="delete-modal btn btn-danger" href="{{ route('ViewMaindata') }}">ยกเลิก</a>
                      </div>
                      <input type="hidden" name="_method" value="PATCH"/>
                    </form>
    
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <script>
    $(".alert").fadeTo(3000, 500).slideUp(500, function(){
    $(".alert").alert('close');
    });;
  </script>

@endsection
