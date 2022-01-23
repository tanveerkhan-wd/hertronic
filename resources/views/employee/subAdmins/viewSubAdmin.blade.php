@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_sub_admins'] ?? 'Sub Admins')
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/subAdmins" href="{{url('/employee/subAdmins')}}"><span>{{$translations['sidebar_nav_admin_staff'] ?? 'Admin Staff'}} > </span></a> {{$translations['gn_details'] ?? 'Details'}}</h2>
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
                                            <img src="@if(!empty($mdata->emp_PicturePath)) {{url('public/images/users/')}}/{{$mdata->emp_PicturePath}} @else {{ url('public/images/user.png') }}@endif">
                                        </div>
                                    </div>
                                    <h5 class="profile_name">{{$mdata->emp_EmployeeName}}</h5>
                                </div>
                                <div class="profile_info_container">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_employee'] ?? 'Employee'}} ID :</p>
                                                <p class="value">{{$mdata->emp_EmployeeID}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}} :</p>
                                                <p class="value">{{$mdata->emp_TempCitizenId}}</p>
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
                                                <p class="value">{{$mdata->emp_PhoneNumber}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_gender'] ?? 'Gender'}} :</p>
                                                <p class="value">@if($mdata->emp_EmployeeGender=='Male') {{$translations['gn_male'] ?? 'Male'}} @else {{$translations['gn_female'] ?? 'Female'}} @endif</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_dob'] ?? 'Date of Birth'}} :</p>
                                                <p class="value">@if(!empty($mdata->emp_DateOfBirth)){{date('m/d/Y',strtotime($mdata->emp_DateOfBirth))}}@endif</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_start_date'] ?? 'Start Date'}} :</p>
                                                <p class="value">@if(!empty($mdata->EmployeesEngagement[0]->een_DateOfEngagement)){{date('m/d/Y',strtotime($mdata->EmployeesEngagement[0]->een_DateOfEngagement))}}@endif</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_end_date'] ?? 'End Date'}} :</p>
                                                <p class="value">@if(!empty($mdata->EmployeesEngagement[0]->een_DateOfFinishEngagement)){{date('m/d/Y',strtotime($mdata->EmployeesEngagement[0]->een_DateOfFinishEngagement))}}@endif</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_country'] ?? 'Country'}} :</p>
                                                <p class="value">{{$mdata->country['cny_CountryName_'.$current_language]}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_status'] ?? 'Status'}} :</p>
                                                <p class="value">@if($mdata->emp_Status=='Active') {{$translations['gn_active'] ?? 'Active'}} @else {{$translations['gn_inactive'] ?? 'Inactive'}} @endif</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_address'] ?? 'Address'}} :</p>
                                                <p class="value">{{$mdata->emp_Address}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($mdata->employeesEngagement as $k=>$v)
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} :</p>
                                                    <p class="value">{{$v->engagementType->ety_EngagementTypeName ?? ''}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_employee_type'] ?? 'Employee Type'}} :</p>
                                                    <p class="value">
                                                        @if(!empty($v->employeeType->epty_subCatName) && !empty($v->employeeType->epty_subCatName=='Clerk'))
                                                            {{$translations['gn_clerk'] ?? 'Clerk'}}
                                                        @else
                                                            @if($v->employeeType->epty_Name=='SchoolSubAdmin') {{ $translations['gn_school_sub_admin'] ?? 'School Sub Admin' }} 
                                                            @elseif($v->employeeType->epty_Name=='SchoolCoordinator')
                                                                {{ $translations['gn_school_coordinator'] ?? 'SchoolCoordinator' }}
                                                            @else
                                                                {{ $v->employeeType->epty_Name }}
                                                            @endif

                                                        @endif  
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_date_of_engagement'] ?? 'Date of Engagement'}} :</p>
                                                    <p class="value">@if(!empty($v->een_DateOfEngagement)) {{date('m/d/Y',strtotime($v->een_DateOfEngagement))}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_hourly_rate'] ?? 'Hourly Rate'}} :</p>
                                                    <p class="value">{{$v->een_WeeklyHoursRate ?? ''}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}}  :</p>
                                                    <p class="value">@if(!empty($v->een_DateOfFinishEngagement)) {{date('m/d/Y',strtotime($v->een_DateOfFinishEngagement))}}@endif</p>
                                                </div>
                                            </div>

                                        @endforeach
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
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
<!-- End Content Body -->
@endsection

            