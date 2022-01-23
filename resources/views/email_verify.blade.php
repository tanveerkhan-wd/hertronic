@extends('layout.app_without_login')
@section('title','Email Verify')
@section('content')
<!-- 
View File for Verify email
@package    Laravel
@subpackage View
@since      1.0
 -->
    <div class="auth_box">
      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            @if($status)
                <h3 style="color:green;">
                    {{ $message }} <a style="color:green;text-decoration: underline !important;" href="<?=url('/')?>">Hertronic</a>
                </h3>
            @endif
            @if (!$status)
                <h3 style="color:red;"> {{ $message }}</h3>
            @endif
          </div>
        </div>
    </div>

@endsection