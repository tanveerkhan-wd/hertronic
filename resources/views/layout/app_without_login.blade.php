<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ @csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - Hertronic</title>
  <!-- Tell the browser to be responsive to screen width -->
  <!-- <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> -->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/animate.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/custom.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/custom-rt.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('public/css/msdropdown/dd.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ url('public/css/msdropdown/flags.css') }}" />

  <style type="text/css">
   .alert a{
    text-decoration: none;
   }
   .alert{
        margin: 25px;
    }
    .alert.alert-danger {    
    top: 2pc !important;
}
.alert.alert-success {    
    top: 2pc !important;
}
  </style>
  @stack('custom-styles')
</head>
<body class="hold-transition login-page">
  @if (Session::has('middleware_error'))
      <input type="hidden" id="error_msg" value="{!! session('middleware_error') !!}">
  @endif  
  <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
  <div class="auth_container" id="contents" style="opacity: 0;">
    <div class="auth_logo text-center">
        <a href="{{url('/')}}"><img src="{{ url('public/images/ic_login_logo.png') }}" alt="Hetronic Logo" class="login_logo"></a>
    </div>
<!-- <div class="login-box">
  <div class="login-logo">
      <img src="assets/images/ic_login_logo.png" alt="Hetronic Logo" class="login_logo">
  </div> -->
@yield('content')
<!-- /.login-box -->
</div>

<input type="hidden" id="field_required_txt" value="{{$translations['validate_field_required'] ?? 'This field is required'}}">
<input type="hidden" id="email_validate_txt" value="{{$translations['validate_email_field'] ?? 'Please enter a valid email address'}}">
<input type="hidden" id="minlength_validate_txt" value="{{$translations['validate_minlength'] ?? 'Please enter at least {0} characters.'}}">
<input type="hidden" id="maxlength_validate_txt" value="{{$translations['validate_maxlength'] ?? 'Please enter no more than {0} characters.'}}">
<input type="hidden" id="validate_password_txt" value="{{$translations['validate_password'] ?? 'The password must be a combination of characters, numbers, one uppercase letter and special characters'}}">
<input type="hidden" id="validate_password_equalto_txt" value="{{$translations['validate_password_equalto'] ?? 'New password and Confirm password does not match'}}">
<input type="hidden" id="validate_equalto_txt" value="{{$translations['validate_equalto'] ?? 'Please enter the same value again'}}">


<script type="text/javascript" src="{{ url('public/js/all.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/owl.carousel.js') }}"></script>  
<script type="text/javascript" src="{{ url('public/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/custom.js') }}"></script>  
<script src="{{ url('public/js/msdropdown/jquery.dd.min.js') }}"></script>
<script src="{{ url('public/js/jquery.validate.js') }}"></script>
<script src="{{ url('public/js/custom_validation_msg.js') }}"></script>
<script src="{{ url('public/js/promise.min.js') }}"></script>
<script src="{{ url('public/js/additional-methods.js') }}"></script>
<script type="text/javascript">
    //show middleware authentication error
      if ($('#error_msg').val()) {
          toastr.error($('#error_msg').val());
      }
    //end

    wow = new WOW({
          animateClass: 'animated',
          offset:       100,
          callback:     function(box) {
            console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
          }
      });
      wow.init();
      

    // $(window).load(function() {
    //         $(".preloader").fadeOut("slow");
    // });
    $(document).ready(function() {
      $("#language_drop_down").msDropdown();
    })
  </script> 


@stack('custom-scripts')
</body>
</html>