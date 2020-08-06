@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('Saveregist') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="new-password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        
                        <div class="form-inline form-group">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              สาขา</label>
                              &nbsp;&nbsp;&nbsp;
                            <select name="branch" class="form-control" style="width: 330px;">
                              <option selected disabled value="" >เลือกสาขา</option>
                              <option value="99" > Admin</option>
                              <option value="01" > สาขา ปัตตานี</option>
                              <option value="03" > สาขา ยะลา</option>
                              <option value="04" > สาขา นราธิวาส</option>
                              <option value="05" > สาขา สายบุรี</option>
                              <option value="06" > สาขา โกลก</option>
                              <option value="07" > สาขา เบตง</option>
                              <option value="10" > สาขา รถบ้าน</option>
                            </select>
                          </div>

                        <div class="form-inline form-group">
                          <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            แผนก</label>
                            &nbsp;&nbsp;&nbsp;
                          <select name="section_type" class="form-control" style="width: 330px;">
                            <option selected disabled value="" >เลือกแผนก</option>
                            <option value="Admin"> Admin</option>
                            <option value="แผนก วิเคราะห์"> แผนก วิเคราะห์</option>
                            <option value="แผนก จัดไฟแนนท์"> แผนก จัดไฟแนนท์</option>
                            <option value="แผนก รถบ้าน"> แผนก รถบ้าน</option>
                            <option value="แผนก กฏหมาย"> แผนก กฏหมาย</option>
                            <option value="แผนก เร่งรัด"> แผนก เร่งรัด</option>
                            <option value="แผนก การเงินนอก"> แผนก การเงินนอก</option>
                            <option value="แผนก การเงินใน"> แผนก การเงินใน</option>
                            <option value="แผนก บัญชี"> แผนก บัญชี</option>
                          </select>
                        </div>

                        <div class="form-inline form-group">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              ตำแหน่ง</label>
                              &nbsp;&nbsp;&nbsp;
                            <select name="position" class="form-control" style="width: 330px;">
                              <option selected disabled value="" >เลือกตำแหน่ง</option>
                              <option value="Admin" > Admin</option>
                              <option value="MANAGER" > MANAGER</option>
                              <option value="AUDIT" > AUDIT</option>
                              <option value="MASTER" > MASTER</option>
                              <option value="STAFF" > STAFF</option>
                            </select>
                          </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4" align="center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                                <a class="delete-modal btn btn-danger" href="{{ route('ViewMaindata') }}">ยกเลิก</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
