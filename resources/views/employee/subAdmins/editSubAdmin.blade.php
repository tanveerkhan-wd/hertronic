@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_sub_admins'] ?? 'Sub Admins')
@section('script', url('public/js/dashboard/school_sub_admin.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-3">
                   <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/subAdmins" href="{{url('/employee/subAdmins')}}"><span>{{$translations['sidebar_nav_admin_staff'] ?? 'Admin Staff'}} > </span></a> {{$translations['gn_edit'] ?? 'Edit'}}</h2>
                </div> 
            </div>
            
            <div class="white_box">
                <div class="theme_tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{$translations['gn_general_information'] ?? 'General Information'}}</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="Current-tab" data-toggle="tab" href="#Current" role="tab" aria-controls="Current" aria-selected="true">Access Priviledges</a>
                        </li> -->
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="inner_tab" id="profile_detail">
                                <form id="edit-subAdmin-form" name='add-subAdmin-form'>
                                <input type="hidden" id="sid" value="{{$mdata->EmployeesEngagement[0]->fkEenSch}}">
                                <input id="aid" type="hidden" value="{{$mdata->id}}">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <div class="text-center">
                                            <div class="profile_box">
                                                <div class="profile_pic">
                                                    <img id="user_img" src="@if(!empty($mdata->emp_PicturePath)) {{url('public/images/users/')}}/{{$mdata->emp_PicturePath}} @else {{ url('public/images/user.png') }}@endif">
                                                    <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
                                                </div>
                                            </div>
                                            <div  class="upload_pic_link">
                                                <a href="javascript:void(0)">
                                                {{$translations['gn_upload_photo'] ?? 'Upload Photo'}}<input accept="image/jpeg,image/png" type="file" id="upload_profile" name="upload_profile"></a>
                                                
                                            </div>
                                            <input type="hidden" id="image_validation_msg" value="{{$translations['msg_image_validation'] ?? 'Please select a valid image'}}">

                                           <!--  <p class="profile_mail">john.smith@gmail.com</p> -->
                                        </div>
                                        <div class="profile_info_container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_name'] ?? 'Name'}} *</label>
                                                        <input type="text" name="emp_EmployeeName" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_name'] ?? 'Name'}}" value="{{$mdata->emp_EmployeeName}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_email'] ?? 'Email'}} *</label>
                                                        <input type="text" name="email" id="email" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_email'] ?? 'Email'}}" value="{{$mdata->email}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_phone'] ?? 'Phone'}} *</label>
                                                        <input type="number" name="emp_PhoneNumber" id="emp_PhoneNumber" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone_number'] ?? 'Phone Number'}}" value="{{$mdata->emp_PhoneNumber}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_employee'] ?? 'Employee'}} ID *</label>
                                                        <input type="text" name="emp_EmployeeID" id="emp_EmployeeID" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} ID" value="{{$mdata->emp_EmployeeID}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}} </label>
                                                        <input type="text" name="emp_TempCitizenId" id="emp_TempCitizenId" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}}" value="{{$mdata->emp_TempCitizenId}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_gender'] ?? 'Gender'}}</label>
                                                        <select name="emp_EmployeeGender" id="emp_EmployeeGender" class="form-control icon_control dropdown_control">
                                                          <option @if($mdata->emp_EmployeeGender == 'Male') selected @endif value="Male">{{$translations['gn_male'] ?? 'Male'}}</option>
                                                          <option @if($mdata->emp_EmployeeGender == 'Female') selected @endif value="Female">{{$translations['gn_female'] ?? 'Female'}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_start_date'] ?? 'Start Date'}} *</label>
                                                        <input type="text" id="start_date" name="start_date" class="form-control datepicker icon_control date_control" value="@if(!empty($mdata->EmployeesEngagement[0]->een_DateOfEngagement)){{date('m/d/Y',strtotime($mdata->EmployeesEngagement[0]->een_DateOfEngagement))}}@endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_end_date'] ?? 'End Date'}} </label>
                                                        <input type="text" id="end_date" name="end_date" class="form-control datepicker icon_control date_control" value="@if(!empty($mdata->EmployeesEngagement[0]->een_DateOfFinishEngagement)){{date('m/d/Y',strtotime($mdata->EmployeesEngagement[0]->een_DateOfFinishEngagement))}}@endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_dob'] ?? 'Date of Birth'}}</label>
                                                        <input type="text" name="emp_DateOfBirth" id="emp_DateOfBirth" class="form-control icon_control date_control datepicker" value="@if(!empty($mdata->emp_DateOfBirth)){{date('m/d/Y',strtotime($mdata->emp_DateOfBirth))}}@endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_place_of_birth'] ?? 'Place of Birth'}} *</label>
                                                        <input type="text" name="emp_PlaceOfBirth" id="emp_PlaceOfBirth" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_place_of_birth'] ?? 'Place of Birth'}}" value="{{$mdata->emp_PlaceOfBirth}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_country'] ?? 'Country'}} *</label>
                                                        <select name="fkEmpCny" class="form-control icon_control dropdown_control">
                                                          <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                          @foreach($Countries as $k => $v)
                                                            <option @if($mdata->fkEmpCny == $v->pkCny) selected @endif value="{{$v->pkCny}}">{{$v->cny_CountryName}}</option>
                                                          @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_address'] ?? 'Address'}}</label>
                                                        <input type="text" name="emp_Address" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_address'] ?? 'Address'}}" value="{{$mdata->emp_Address}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_status'] ?? 'Status'}} *</label>
                                                        <select class="form-control dropdown_control icon_control" name="emp_Status" id="emp_Status">
                                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                            <option @if($mdata->emp_Status == 'Active') selected @endif value="Active">{{$translations['gn_active'] ?? 'Active'}}</option>
                                                            <option @if($mdata->emp_Status == 'Inactive') selected @endif value="Inactive">{{$translations['gn_inactive'] ?? 'Inactive'}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                                        <input type="text" name="emp_Notes" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_note'] ?? 'Note'}}" value="{{$mdata->emp_Notes}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="row">
                                                {{-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_date_of_enrollment'] ?? 'Date of Enrollment'}} *</label>
                                                        <input type="text" id="eng_start_date" name="eng_start_date" class="form-control datepicker icon_control date_control" value="@if(!empty($mdata->EmployeesEngagement[0])){{date('m/d/Y',strtotime($mdata->EmployeesEngagement[0]->een_DateOfEngagement))}}@endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} </label>
                                                        <input type="text" id="eng_end_date" name="eng_end_date" class="form-control datepicker icon_control date_control" value="@if(!empty($mdata->EmployeesEngagement[0]->een_DateOfFinishEngagement)){{date('m/d/Y',strtotime($mdata->EmployeesEngagement[0]->een_DateOfFinishEngagement))}}@endif">
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label>{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} *</label>
                                                      <select id="fkEenEty" name="fkEenEty" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($EngagementTypes as $k => $v)
                                                          <option @if($mdata->EmployeesEngagement[0]->fkEenEty == $v->pkEty) selected @endif value="{{$v->pkEty}}">{{$v->ety_EngagementTypeName}}</option>
                                                        @endforeach
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label>{{$translations['gn_hourly_rate'] ?? 'Hourly Rate'}} *</label>
                                                      <input type="number" name="een_WeeklyHoursRate" id="een_WeeklyHoursRate" class="form-control" value="{{$mdata->EmployeesEngagement[0]->een_WeeklyHoursRate}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label>{{$translations['gn_employee_type'] ?? 'Employee Type'}} *</label>
                                                      <select id="fkEenEpty" name="fkEenEpty" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($employeeType as $k => $v)
                                                          <option @if($mdata->EmployeesEngagement[0]->fkEenEpty == $v->pkEpty) selected @endif value="{{$v->pkEpty}}">
                                                            @if(!empty($v->epty_subCatName) && $v->epty_subCatName=='Clerk')
                                                                {{$translations['gn_clerk'] ?? 'Clerk'}} 
                                                            @elseif($v->epty_Name=='SchoolSubAdmin') {{$translations['gn_school_sub_admin'] ?? 'School Sub Admin'}} 
                                                            @endif
                                                          </option>
                                                        @endforeach
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label>{{$translations['gn_notes'] ?? 'Notes'}} *</label>
                                                      <input type="text" name="een_Notes" id="een_Notes" class="form-control" value="{{$mdata->EmployeesEngagement[0]->een_Notes}}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="card">
                                                  <div class="card-body">
                                                    <b>{{$translations['gn_note'] ?? 'Note'}}:</b> {{$translations['gn_end_date_note'] ?? 'Only enter "Date of Engagment End" date field if you wish to inactive the employee'}}
                                                  </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="emp_engagment_id" value="{{ $mdata->EmployeesEngagement[0]->pkEen }}">
                                        </div>
                                        <div class="text-center">
                                             <div class="text-center">
                                                <button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
                                                <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="employee/subAdmins" href="{{url('/employee/subAdmins')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1"></div>
                                </div>
                            </form>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade show" id="Current" role="tabpanel" aria-labelledby="Current-tab">
                            <div class="inner_tab" id="profile_detail2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-grey">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <strong>1. School</strong>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" checked="">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>View</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Add</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Edit</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Delete</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-grey">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <strong>2. User Management</strong>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" checked="">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>View</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Add</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Edit</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Delete</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-grey">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <strong>3. Organization</strong>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" checked="">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>View</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Add</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Edit</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Delete</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-grey">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <strong>4. Exam Result</strong>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" checked="">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>View</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Add</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Edit</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Delete</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-grey">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <strong>5. Attendance</strong>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" checked="">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>View</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Add</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Edit</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Delete</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-grey">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <strong>6. Reports</strong>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" checked="">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>View</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Add</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Edit</strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="custom_checkbox"></label>
                                                        <label class="form-check-label label-text" for="exampleCheck1"><strong>Delete</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                             <div class="text-center">
                                                <button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
                                                <button type="button" class="theme_btn red_btn">{{$translations['gn_cancel'] ?? 'Cancel'}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/school_sub_admin.js') }}"></script>
@endpush
            