@extends('layout.app_with_login')
@section('title', $translations['gn_profile'] ?? 'Profile')
@section('script', url('public/js/dashboard/profile.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
  <div class="container-fluid">
    <h5 class="title">{{$translations['gn_my_profile'] ?? 'My Profile'}}</h5>
        <div class="white_box">
            <div class="theme_tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{$translations['gn_general_information'] ?? 'General Information'}}</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="inner_tab" id="profile_detail">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="text-center">
                                        <div class="profile_box">
                                            <div class="profile_pic">
                                                <img src="@if(!empty($logged_user->adm_Photo)) {{url('public/images/users/')}}/{{$logged_user->adm_Photo}} @else {{ url('public/images/user.png') }}@endif">
                                            </div>
                                        </div>
                                        <h5 class="profile_name">{{$logged_user->name}}</h5>
                                        <p class="profile_mail">{{$logged_user->email}}</p>
                                    </div>
                                    <div class="profile_info_container">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_title'] ?? 'Title'}} :</p>
                                                    <p class="value">{{$logged_user->adm_Title}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_phone'] ?? 'Phone'}} :</p>
                                                    <p class="value">{{$logged_user->adm_Phone}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_government'] ?? 'Government'}} ID :</p>
                                                    <p class="value">{{$logged_user->adm_GovId}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_gender'] ?? 'Gender'}} :</p>
                                                    <p class="value">{{$logged_user->adm_Gender}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_dob'] ?? 'Date of Birth'}} :</p>
                                                    <p class="value">@if(!empty($logged_user->adm_DOB)){{date('m/d/Y',strtotime($logged_user->adm_DOB))}}@endif</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="theme_btn" id="edit_profile">{{$translations['gn_edit_profile'] ?? 'Edit Profile'}}</button>
                                        <button class="theme_btn" data-toggle="modal" data-target="#change_pass">{{$translations['gn_change_password'] ?? 'Change Password'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                        </div>
                        <div class="inner_tab" id="edit_profile_detail" style="display: none;">
                          <form id="edit-profile-form" name="edit-profile">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="text-center">
                                        <div class="profile_box">
                                            <div class="profile_pic">
                                                <img id="user_img" src="@if(!empty($logged_user->adm_Photo)) {{url('public/images/users/')}}/{{$logged_user->adm_Photo}} @else {{ url('public/images/user.png') }}@endif">
                                                <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
                                            </div>
                                            <div class="edit_pencile">
                                              <img src="{{ url('public/images/ic_pen.png') }}">
                                              <input type="file" id="upload_profile" name="upload_profile" accept="image/jpeg,image/png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <label>{{$translations['gn_name'] ?? 'Name'}}</label>
                                            <input type="text" name="name" class="form-control" value="{{$logged_user->adm_Name}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['ln_email'] ?? 'Email'}}</label>
                                            <input type="text" name="email" class="form-control" value="{{$logged_user->email}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_title'] ?? 'Title'}}</label>
                                            <input type="text" name="title" class="form-control" value="{{$logged_user->adm_Title}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_phone'] ?? 'Phone'}}</label>
                                            <input type="number" name="phone" class="form-control" value="{{$logged_user->adm_Phone}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_goverment'] ?? 'Government'}} ID</label>
                                            <input type="text" name="govt_id" class="form-control" value="{{$logged_user->adm_GovId}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_gender'] ?? 'Gender'}}</label>
                                            <select name="gender" class="form-control icon_control dropdown_control">
                                              <option @if($logged_user->adm_Gender == 'Male') {{'selected'}} @endif value="Male">Male</option>
                                              <option @if($logged_user->adm_Gender == 'Female') {{'selected'}} @endif value="Female">Female</option>
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_dob'] ?? 'Date of Birth'}}</label>
                                            <input type="text" name="dob" class="form-control icon_control date_control datepicker" value="@if(!empty($logged_user->adm_DOB)){{date('m/d/Y',strtotime($logged_user->adm_DOB))}}@endif">
                                          </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                        <button class="theme_btn red_btn" id="cancel_edit_profile" type="button">{{$translations['gn_cancel'] ?? 'Cancel'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
  </div>
          
           @if ($errors->any())
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
            @endif

            @php                                     
              $_REQUEST['data'] = (isset($_REQUEST['data']) && !empty($_REQUEST['data']))?$_REQUEST['data']:'profile';
            @endphp

<!-- change password Modal -->
    <div class="theme_modal modal fade" id="change_pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
              <img src="{{ url('public/images/ic_close_bg.png') }}" class="modal_top_bg">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <img src="{{ url('public/images/ic_close_circle_white.png') }}">
                </button>
                <form name="change-password-form">
                  <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                      <h5 class="modal-title" id="exampleModalCenterTitle">{{$translations['gn_change_password'] ?? 'Change Password'}}</h5>
                      <div class="form-group">
                        <label>{{$translations['gn_old_password'] ?? 'Old Password'}} *</label>
                        <input type="password" name="old_password" name="id" class="form-control pass_control icon_control" placeholder="">
                      </div>
                      <div class="form-group">
                        <label>{{$translations['gn_new_password'] ?? 'New Password'}} *</label>
                        <input type="password" name="new_password" id="new_password" class="form-control pass_control icon_control" placeholder="">
                      </div>
                      <div class="form-group">
                        <label>{{$translations['gn_confirm_password'] ?? 'Confirm Password'}} *</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control pass_control icon_control" placeholder="">
                      </div>
                      <div class="text-center modal_btn ">
                        <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                      </div>
                      <div class="text-center process_msg">
                        <p class="green_msg custom_success_msg"></p>
                        <p class="error_msg custom_error_msg"></p>
                    </div>
                    <div class="col-lg-1"></div>
                  </div>
                </form>
            </div>
        </div>
      </div>
    </div>


<!-- End Content Body -->
@endsection
@push('custom-styles')
<!-- Include this Page CSS -->
<link link rel="stylesheet" type="text/css" href="{{ url('public/css/jquery.datepick.css') }}">
<link link rel="stylesheet" type="text/css" href="{{ url('public/css/toastr.min.css') }}">
<style type="text/css">

div#upload-demo {
    height: 160px;
    width: 160px;
    display: inline-block;
    vertical-align: top;
    margin: 0 20px;
    border: 1px solid #59d6b9;
}

div#upload-demo .cr-viewport.cr-vp-circle {
    height: 160px !important;
    width: 160px !important;
    box-shadow: 0 0 2000px 2000px rgba(170, 234, 212, 0.4);
}

div#upload-demo .cr-boundary {
    width: 160px !important;
    height: 160px !important;
}

div#upload-demo img.cr-image {
    opacity: 0;
}

button.upload-result {
    margin-top: 30px;
}
.edit_icon input[type="file"]{
  top: 0;
}
</style>
@endpush
@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/profile.js') }}"></script>
@endpush