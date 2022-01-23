@extends('layout.app_with_login')
@section('title','Ministry Sub Admin')
@section('script', url('public/js/dashboard/sub_admin.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="admin/subAdmins" href="{{url('/admin/subAdmins')}}"><span>{{$translations['gn_sub_admin'] ?? 'Sub Admin'}} > </span></a> {{$translations['gn_add'] ?? 'Add'}}</h2>
            </div>   
            <div class="col-12">
                <div class="white_box pt-5 pb-5">
                    <div class="container-fliid">
                    	<form name="add-ministry-form">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="text-center">
                                        <div class="profile_box">
                                            <div class="profile_pic">
                                                <img id="user_img" src="{{ url('public/images/user.png') }}">
                                                <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
                                            </div>
                                        </div>
                                        <div  class="upload_pic_link">
                                            <a href="javascript:void(0)">
                                            {{$translations['gn_upload_photo'] ?? 'Upload Photo'}}<input type="file" accept="image/jpeg,image/png" id="upload_profile" name="upload_profile"></a>
                                            
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <label>{{$translations['gn_first_name'] ?? 'First Name'}} *</label>
                                            <input type="text" name="fname" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_first_name'] ?? 'First Name'}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_last_name'] ?? 'Last Name'}} *</label>
                                            <input type="text" name="lname" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_last_name'] ?? 'Last Name'}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['ln_email'] ?? 'Email'}} *</label>
                                            <input type="text" name="email" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['ln_email'] ?? 'Email'}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_phone'] ?? 'Phone'}}</label>
                                            <input type="text" name="adm_Phone" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone'] ?? 'Phone'}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_title'] ?? 'Title'}}</label>
                                            <input type="text" name="adm_Title" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_title'] ?? 'Title'}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_government'] ?? 'Government'}} ID *</label>
                                            <input type="text" name="adm_GovId" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_government'] ?? 'Government'}} ID">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_address'] ?? 'Address'}}</label>
                                            <input type="text" name="adm_Address" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_address'] ?? 'Address'}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_gender'] ?? 'Gender'}} *</label>
                                            <select name="adm_Gender" class="form-control icon_control dropdown_control">
                                                <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                <option value="Male">{{$translations['gn_male'] ?? 'Male'}}</option>
                                                <option value="Female">{{$translations['gn_female'] ?? 'Female'}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_canton'] ?? 'Canton'}} *</label>
                                            <select name="fkAdmCan" class="form-control icon_control dropdown_control">
                                                <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                @foreach($data as $k => $v)
                                                    <option value="{{$v->pkCan}}">{{$v->can_CantonName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_dob'] ?? 'Date of Birth'}} *</label>
                                            <input type="text" name="adm_DOB" class="form-control icon_control date_control datepicker" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_dob'] ?? 'Date of Birth'}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_status'] ?? 'Status'}} *</label>
                                            <select class="form-control" name="adm_Status" id="can_Status">
                                                <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                <option value="Active">{{$translations['gn_active'] ?? 'Active'}}</option>
                                                <option value="Inactive">{{$translations['gn_inactive'] ?? 'Inactive'}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                        <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="admin/subAdmins" href="{{url('/admin/subAdmins')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
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
<!-- End Content Body -->
@endsection

@push('custom-scripts')
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
@endpush

@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/sub_admin.js') }}"></script>
@endpush
            