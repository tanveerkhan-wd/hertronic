@extends('layout.app_without_login')
@section('title','Reset Password')
@section('content')
<!-- 
View File for Reset Password
@package    Laravel
@subpackage View
@since      1.0
 -->
  <div class="auth_box">
    <!-- @if ($errors->any())
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif -->


    <form action="{{ url('admin/changePasswordPost') }}" method="post" id="loginForm" name="loginForm">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-lg-1"></div>
          <div class="col-lg-10">
            <h1>{{$translations['rp_reset_password'] ?? 'Reset Password'}}</h1>
            <input type="hidden" name="token" id="token" value="{{$token}}">
            <div class="form-group">
              <label>{{$translations['rp_password'] ?? 'Password'}}</label>
              <input type="password" placeholder="{{$translations['gn_new_password'] ?? 'New Password'}}" class="form-control" name="new_password" id="new_password">
            </div>

            <div class="form-group">
              <label>{{$translations['gn_confirm_password'] ?? 'Confirm Password'}}</label>
              <input type="password" placeholder="{{$translations['gn_confirm_password'] ?? 'Confirm Password'}}" class="form-control" name="confirm_password" id="confirm_password">
            </div>
            <div class="text-center">
              <button type="submit" class="theme_btn auth_btn">{{$translations['gn_confirm'] ?? 'Confirm'}}</button>
              <p><a href="{{ url('login') }}" class="auth_link">{{$translations['gn_login'] ?? 'Login'}}</a></p>
            </div>
            <div class="text-center process_msg"></div>
            <div class="row">
              <div class="col-lg-9">
                <div class="text-center">© Copyright {{ now()->year }} Hertronic | All Rights Reserved</div>
              </div>
              <div class="col-lg-3">
                <div class="custom-drop-down" id="custom-flag-drop-down">
                  <select onchange='langSwitch(this.value)' style="width:130px;">
                      @foreach($languages as $k => $v)
                        <option @if($current_language==$v->language_key) selected @endif value='{{$v->language_key}}' class="custom_flag {{$v->language_key}}" style="background-image:url({{url('public/images/languages')}}/{{$v->flag}});" data-title="{{$v->language_name}}">{{$v->language_name}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-1"></div>
      </div>
    </form>
  </div>
@endsection
@push('custom-styles')
<!-- Include this Page CSS -->
<link link rel="stylesheet" type="text/css" href="{{ url('public/css/toastr.min.css') }}">
@endpush
@push('custom-scripts')
  <script type="text/javascript" src="{{ url('public/js/login/reset_password.js') }}"></script>
  <script type="text/javascript" src="{{ url('public/js/toastr.min.js') }}"></script>
@endpush