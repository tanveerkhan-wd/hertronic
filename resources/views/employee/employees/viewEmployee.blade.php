@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_employees'] ?? 'Employees')
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
            @if($logged_user->type=='MinistryAdmin')
                <h2 class="title">{{$translations['sidebar_nav_teachers'] ?? 'Teachers'}}</h2>
            @else
                <h2 class="title"><span>@if(Request::is('employee/*')){{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/employees" href="{{url('/employee/employees')}}"> @else {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}} > </span><a class="ajax_request no_sidebar_active" data-slug="admin/employees" href="{{url('/admin/employees')}}"> @endif <span>{{$translations['sidebar_nav_employees'] ?? 'Employees'}} > </span></a> {{$translations['gn_details'] ?? 'Details'}}</h2>
            @endif
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
                                                <p class="value">{{$mdata->emp_EmployeeGender}}</p>
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
                                                <p class="label">{{$translations['gn_country'] ?? 'Country'}} :</p>
                                                <p class="value">{{isset($mdata->country->cny_CountryName) ? $mdata->country->cny_CountryName:''}}</p>
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
                                    </div><br>
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="profile_inner_title">{{$translations['gn_work_experience'] ?? 'Work Experience'}}</h6>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="table-responsive">
                                              <table class="profile_table">
                                                <tbody>
                                                  @forelse($mdata->employeesEngagement as $k => $value)
                                                  <tr>
                                                    <td>{{$k+1}}</td>
                                                    <td>
                                                      <p class="label">{{$translations['gn_employee_type'] ?? 'Employee Type'}} :</p>
                                                      <p class="value">
                                                        
                                                            @if($value->employeeType->epty_Name=='Principal') {{ $translations['gn_principal'] ?? 'Principal' }} 
                                                            @elseif($value->employeeType->epty_Name=='Teacher') {{ $translations['gn_teacher'] ?? 'Teacher' }} 
                                                            @elseif($value->employeeType->epty_Name=='SchoolCoordinator') {{ $translations['gn_school_coordinator'] ?? 'School Coordinator' }}@endif

                                                       </p>

                                                      <br>
                                                      <p class="label">{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} :</p>
                                                      <p class="value">{{$value->engagementType->ety_EngagementTypeName ?? ''}}</p>
                                                    </td>
                                                    <td>
                                                      <p class="label">{{$translations['gn_date_of_engagement'] ?? 'Date of Engagement'}} :</p>
                                                      <p class="value">@if(isset($value) && !empty($value->een_DateOfEngagement)){{date('m/d/Y',strtotime($value->een_DateOfEngagement))}}@endif</p>
                                                      <br>
                                                      <p class="label">{{$translations['gn_hourly_rate'] ?? 'Hourly Rate'}} :</p>
                                                      <p class="value">{{$value->een_WeeklyHoursRate ?? ''}}</p>
                                                    </td>
                                                    <td>
                                                      <p class="label">{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} :</p>
                                                      <p class="value">@if(isset($value) && !empty($value->een_DateOfFinishEngagement)){{date('m/d/Y',strtotime($value->een_DateOfFinishEngagement))}}@endif</p>
                                                    </td>
                                                  </tr>
                                                  @empty
                                                  <tr class="text-center">
                                                      {{$translations['gn_no_data_found'] ?? 'No Data Found'}}
                                                  </tr>
                                                  @endforelse
                                                </tbody>
                                              </table>
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
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
<!-- End Content Body -->
@endsection

            