@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_ministry_super_admin'] ?? 'Ministry Super Admin')
@section('script', url('public/js/dashboard/ministry.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="admin/ministries" href="{{url('/admin/ministries')}}"><span>{{$translations['sidebar_nav_ministry_super_admin'] ?? 'Ministry Super Admin'}} > </span></a> {{$translations['gn_edit'] ?? 'Edit'}}</h2>
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
                                                <img id="user_img" src="@if(!empty($data->adm_Photo)) {{url('public/images/users/')}}/{{$data->adm_Photo}} @else {{ url('public/images/user.png') }}@endif">
                                                <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
                                            </div>
                                        </div>
                                        <div  class="upload_pic_link">
                                            <a href="javascript:void(0)">
                                            {{$translations['gn_upload_photo'] ?? 'Upload Photo'}}<input accept="image/jpeg,image/png" type="file" id="upload_profile" name="upload_profile"></a>
                                            
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <label>{{$translations['gn_first_name'] ?? 'First Name'}} *</label>
                                            <input type="text" name="fname" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_first_name'] ?? 'First Name'}}" value="{{$data->fname}}">
                                            <input id="aid" type="hidden" value="{{$data->id}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_last_name'] ?? 'Last Name'}} *</label>
                                            <input type="text" name="lname" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_last_name'] ?? 'Last Name'}}" value="{{$data->lname}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['ln_email'] ?? 'Email'}} *</label>
                                            <input type="text" name="email" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['ln_email'] ?? 'Email'}}" value="{{$data->email}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_phone'] ?? 'Phone'}}</label>
                                            <input type="number" name="adm_Phone" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone'] ?? 'Phone'}}" value="{{$data->adm_Phone}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_title'] ?? 'Title'}}</label>
                                            <input type="text" name="adm_Title" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_title'] ?? 'Title'}}" value="{{$data->adm_Title}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_government'] ?? 'Government'}} ID *</label>
                                            <input type="text" name="adm_GovId" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_government'] ?? 'Government'}} ID" value="{{$data->adm_GovId}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_address'] ?? 'Address'}}</label>
                                            <input type="text" class="form-control" name="adm_Address" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_address'] ?? 'Address'}}" value="{{$data->adm_Address}}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_gender'] ?? 'Gender'}} *</label>
                                            <select name="adm_Gender" class="form-control icon_control dropdown_control">
                                                <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                <option @if($data->adm_Gender == 'Male') selected @endif value="Male">{{$translations['gn_male'] ?? 'Male'}}</option>
                                                <option @if($data->adm_Gender == 'Female') selected @endif value="Female">{{$translations['gn_female'] ?? 'Female'}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_canton'] ?? 'Canton'}} *</label>
                                            <select name="fkAdmCan" id="fkAdmCan" class="form-control icon_control dropdown_control">
                                                <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                @foreach($data->cantons as $k => $v)
                                                	<option @if($data->fkAdmCan==$v->pkCan) selected @endif value="{{$v->pkCan}}">{{$v->can_CantonName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{$translations['gn_dob'] ?? 'Date of Birth'}} *</label>
                                            <input type="text" name="adm_DOB" class="form-control icon_control date_control datepicker" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_dob'] ?? 'Date of Birth'}}" value="@if(!empty($data->adm_DOB)){{date('m/d/Y',strtotime($data->adm_DOB))}}@endif">
                                        </div>
                                        <div class="form-group">
			                                <label>{{$translations['gn_status'] ?? 'Status'}} *</label>
			                                <select class="form-control" name="adm_Status" id="adm_Status">
			                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
			                                    <option @if($data->adm_Status == 'Active') selected @endif value="Active">{{$translations['gn_active'] ?? 'Active'}}</option>
			                                    <option @if($data->adm_Status == 'Inactive') selected @endif value="Inactive">{{$translations['gn_inactive'] ?? 'Inactive'}}</option>
			                                </select>
			                            </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
                                        <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="admin/ministries" href="{{url('/admin/ministries')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
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
<script type="text/javascript" src="{{ url('public/js/dashboard/ministry.js') }}"></script>
@endpush
            