@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_ministry_super_admin'] ?? 'Ministry Super Admin')
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="admin/ministries" href="{{url('/admin/ministries')}}"><span>{{$translations['sidebar_nav_ministry_super_admin'] ?? 'Ministry Super Admin'}} > </span></a> {{$translations['gn_details'] ?? 'Details'}}</h2>
            </div>   
            <div class="col-12">
                <div class="white_box pt-5 pb-5">
                    <div class="container-fliid">
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10">
                                <div class="text-center">
                                    <div class="profile_box">
                                        <div class="profile_pic">
                                            <img src="@if(!empty($mdata->adm_Photo)) {{url('public/images/users/')}}/{{$mdata->adm_Photo}} @else {{ url('public/images/user.png') }}@endif">
                                        </div>
                                    </div>
                                    <h5 class="profile_name">{{$mdata->adm_Name}}</h5>
                                </div>
                                <div class="profile_info_container">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">UID :</p>
                                                <p class="value">{{$mdata->adm_Uid}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_government'] ?? 'Government'}} ID :</p>
                                                <p class="value">{{$mdata->adm_GovId}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['ln_email'] ?? 'Email'}} :</p>
                                                <p class="value">{{$mdata->email}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_phone'] ?? 'Phone'}} :</p>
                                                <p class="value">{{$mdata->adm_Phone}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_gender'] ?? 'Gender'}} :</p>
                                                <p class="value">{{$mdata->adm_Gender}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_dob'] ?? 'Date of Birth'}} :</p>
                                                <p class="value">@if(!empty($mdata->adm_DOB)){{date('m/d/Y',strtotime($mdata->adm_DOB))}}@endif</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_country'] ?? 'Country'}} :</p>
                                                <p class="value">{{$mdata->country}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_state'] ?? 'State'}} :</p>
                                                <p class="value">{{$mdata->state}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_canton'] ?? 'Canton'}} :</p>
                                                <p class="value">{{$mdata->canton}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_status'] ?? 'Status'}} :</p>
                                                <p class="value">{{$mdata->adm_Status}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_address'] ?? 'Address'}} :</p>
                                                <p class="value">{{$mdata->adm_Address}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1"></div>
                        </div>
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

            