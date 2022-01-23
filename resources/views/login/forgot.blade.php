@extends('layout.app_without_login')
@section('title','Forgot Password')
@section('content')
<!-- 
View File for Forgot Password
@package    Laravel
@subpackage View
@since      1.0
 -->
  <!-- /.login-logo -->
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

    <form action="{{ url('forgotPasswordPost') }}" method="post" id="loginForm" name="loginForm">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-lg-1"></div>
          <div class="col-lg-10">
            <h1>{{$translations['fp_forgot_password'] ?? 'Forgot Password'}}</h1>
            <p class="auth_text">{{$translations['fp_sub_heading'] ?? 'Please enter your registered Email address'}}</p>
            <div class="form-group">
              <label>{{$translations['fp_email'] ?? 'Email'}}</label>
              <input type="text" name="email" class="form-control" placeholder="{{$translations['fp_enter_email'] ?? 'Email'}}">
            </div>
            <div class="text-center">
              <button class="theme_btn auth_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
              <p><a href="{{ url('login') }}" class="auth_link">{{$translations['fp_login'] ?? 'Login'}}</a></p>
            </div>
            <div class="text-center process_msg">
              @if(session()->has('success'))
                  <p class="green_msg">
                      {{ session()->get('success') }}
                  </p>
              @endif
              @if ($errors->any())
                 <!--  <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <ul> -->
                          @foreach ($errors->all() as $error)
                              <p class="error_msg">{{ $error }}</p>
                          @endforeach
                     <!--  </ul>
                  </div> -->
              @endif
            </div>
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
  <!-- /.login-box-body -->
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ url('public/js/login/forgot.js') }}"></script>
@endpush