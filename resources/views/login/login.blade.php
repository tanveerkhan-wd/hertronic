@extends('layout.app_without_login')
@section('title','Login')
@section('content')
<!-- 
View File for Login Page
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
      @endif

      @if (\Session::has('success'))
          <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <ul>
                  <li>{!! \Session::get('success') !!}</li>
              </ul>
          </div>
      @endif -->
      <form action="{{ url('login') }}" method="post" id="loginForm" name="loginForm">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-lg-1"></div>
          <div class="col-lg-10">
            <h1>{{$translations['ln_login'] ?? 'Login'}}</h1>
            <div class="form-group">
              <label>{{$translations['ln_email'] ?? 'Email'}}</label>
              <input type="text" name="email" class="form-control" placeholder="{{$translations['ln_enter_email'] ?? 'Enter Email'}}">
            </div>
            <div class="form-group">
              <label>{{$translations['ln_password'] ?? 'Password'}}</label>
              <input type="password" name="password" class="form-control" placeholder="{{$translations['ln_enter_password'] ?? 'Enter Password'}}">
            </div>
            <div class="text-center">
              <button type="submit" class="theme_btn auth_btn">{{$translations['ln_login'] ?? 'Login'}}</button>
              <p><a href="{{ url('forgotPass') }}" class="auth_link">{{$translations['ln_forgot_password'] ?? 'Forgot Password'}}?</a></p>
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
                <!-- <select onchange='langSwitch(this.value)' id="language_drop_down" style="width:130px;">
                      @foreach($languages as $k => $v)
                        <option @if($current_language==$v->language_key) selected @endif value='{{$v->language_key}}' data-image="{{url('public/images/msdropdown/icons/blank.gif')}}" data-imagecss="flag {{$v->language_key}}" data-title="{{$v->language_name}}">{{$v->language_name}}</option>
                      @endforeach
                  </select> -->
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
      <img src="{{ url('public/images/ic_login_shape1.png') }}" class="login_botton_shape">
    </form>
    </div>

@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ url('public/js/login/login.js') }}"></script>
@endpush