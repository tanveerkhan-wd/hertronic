@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_employees'] ?? 'Employees')
@section('script', url('public/js/dashboard/employee.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row">
            @if($logged_user->type=='HertronicAdmin' || $logged_user->type=='MinistryAdmin') <input type="hidden" id="is_admin" value="1"> @endif
            <div class="col-12 mb-3">
            @if($logged_user->type=='MinistryAdmin')
                <h2 class="title"><a class="ajax_request no_sidebar_active" data-slug="admin/employees" href="{{url('/admin/employees')}}"><span>{{$translations['sidebar_nav_teachers'] ?? 'Teachers'}} > </span></a> {{$translations['gn_edit'] ?? 'Edit'}}</h2>
            @else
               <h2 class="title"><span>@if(Request::is('employee/*')){{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/employees" href="{{url('/employee/employees')}}"> @else {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}} > </span><a class="ajax_request no_sidebar_active" data-slug="admin/employees" href="{{url('/admin/employees')}}"> @endif <span>{{$translations['sidebar_nav_employees'] ?? 'Employees'}} > </span></a> {{$translations['gn_edit'] ?? 'Edit'}}</h2>
            @endif
            </div> 
        </div>
            <div class="white_box">
                <div class="theme_tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{$translations['gn_general_information'] ?? 'General Information'}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Current-tab" data-toggle="tab" href="#Current" role="tab" aria-controls="Current" aria-selected="true">{{$translations['gn_edit_engagement'] ?? 'Edit Engagement'}}</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form name='add-teacher-form'>
                            <div class="inner_tab" id="profile_detail">
                                <input type="hidden" id="sid" value="{{$mainSchool}}">
                                <input id="eid" type="hidden" value="{{$EmployeesDetail->id}}">
                                <input id="engid" type="hidden" value="{{$EmployeesDetail->pkEen}}">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <div class="text-center">
                                            <div class="profile_box">
                                                <div class="profile_pic">
                                                    <img id="user_img" src="@if(!empty($EmployeesDetail->emp_PicturePath)) {{url('public/images/users/')}}/{{$EmployeesDetail->emp_PicturePath}} @else {{ url('public/images/user.png') }}@endif">
                                                    <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
                                                </div>
                                            </div>
                                            <div  class="upload_pic_link">
                                                <a href="javascript:void(0)">
                                                {{$translations['gn_upload_photo'] ?? 'Upload Photo'}}<input type="file" id="upload_profile" name="upload_profile" accept="image/jpeg,image/png"></a>
                                                
                                            </div>
                                        </div>
                                        <input type="hidden" id="image_validation_msg" value="{{$translations['msg_image_validation'] ?? 'Please select a valid image'}}">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_name'] ?? 'Name'}} *</label>
                                                        <input type="text" name="emp_EmployeeName" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_name'] ?? 'Name'}}" value="{{$EmployeesDetail->emp_EmployeeName}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_email'] ?? 'Email'}} *</label>
                                                        <input type="text" name="email" id="email" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_email'] ?? 'Email'}}" value="{{$EmployeesDetail->email}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_phone'] ?? 'Phone'}} *</label>
                                                        <input type="number" name="emp_PhoneNumber" id="emp_PhoneNumber" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone_number'] ?? 'Phone Number'}}" value="{{$EmployeesDetail->emp_PhoneNumber}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_employee'] ?? 'Employee'}} ID *</label>
                                                        <input type="text" name="emp_EmployeeID" id="emp_EmployeeID" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} ID" value="{{$EmployeesDetail->emp_EmployeeID}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}} </label>
                                                        <input type="text" name="emp_TempCitizenId" id="emp_TempCitizenId" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}}" value="{{$EmployeesDetail->emp_TempCitizenId}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_gender'] ?? 'Gender'}}</label>
                                                        <select name="emp_EmployeeGender" id="emp_EmployeeGender" class="form-control icon_control dropdown_control">
                                                          <option @if($EmployeesDetail->emp_EmployeeGender == 'Male') selected @endif value="Male">{{$translations['gn_male'] ?? 'Male'}}</option>
                                                          <option @if($EmployeesDetail->emp_EmployeeGender == 'Female') selected @endif value="Female">{{$translations['gn_female'] ?? 'Female'}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_dob'] ?? 'Date of Birth'}}</label>
                                                        <input type="text" name="emp_DateOfBirth" id="emp_DateOfBirth" class="form-control icon_control date_control datepicker" value="@if(!empty($EmployeesDetail->emp_DateOfBirth)){{date('m/d/Y',strtotime($EmployeesDetail->emp_DateOfBirth))}}@endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_place_of_birth'] ?? 'Place of Birth'}} *</label>
                                                        <input type="text" name="emp_PlaceOfBirth" id="emp_PlaceOfBirth" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_place_of_birth'] ?? 'Place of Birth'}}" value="{{$EmployeesDetail->emp_PlaceOfBirth}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_country'] ?? 'Country'}} *</label>
                                                        <select name="fkEmpCny" class="form-control icon_control dropdown_control">
                                                          <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                          @foreach($Countries as $k => $v)
                                                            <option @if($EmployeesDetail->fkEmpCny == $v->pkCny) selected @endif value="{{$v->pkCny}}">{{$v->cny_CountryName}}</option>
                                                          @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_municipality'] ?? 'Municipality'}} *</label>
                                                        <select name="fkEmpMun" class="form-control icon_control dropdown_control">
                                                          <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                          @foreach($Municipalities as $k => $v)
                                                            <option @if($EmployeesDetail->fkEmpMun == $v->pkMun) selected @endif value="{{$v->pkMun}}">{{$v->mun_MunicipalityName}}</option>
                                                          @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_nationality'] ?? 'Nationality'}} *</label>
                                                        <select name="fkEmpNat" class="form-control icon_control dropdown_control">
                                                          <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                          @foreach($Nationalities as $k => $v)
                                                            <option @if($EmployeesDetail->fkEmpNat == $v->pkNat) selected @endif value="{{$v->pkNat}}">{{$v->nat_NationalityName}}</option>
                                                          @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_religion'] ?? 'Religion'}} *</label>
                                                        <select name="fkEmpRel" class="form-control icon_control dropdown_control">
                                                          <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                          @foreach($Religions as $k => $v)
                                                            <option @if($EmployeesDetail->fkEmpRel == $v->pkRel) selected @endif value="{{$v->pkRel}}">{{$v->rel_ReligionName}}</option>
                                                          @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_citizenship'] ?? 'Citizenship'}} *</label>
                                                        <select name="fkEmpCtz" class="form-control icon_control dropdown_control">
                                                          <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                          @foreach($Citizenships as $k => $v)
                                                            <option @if($EmployeesDetail->fkEmpCtz == $v->pkCtz) selected @endif value="{{$v->pkCtz}}">{{$v->ctz_CitizenshipName}}</option>
                                                          @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_postal_code'] ?? 'Postal Code'}} *</label>
                                                        <select name="fkEmpPof" class="form-control icon_control dropdown_control">
                                                          <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                          @foreach($PostalCodes as $k => $v)
                                                            <option @if($EmployeesDetail->fkEmpPof == $v->pkPof) selected @endif value="{{$v->pkPof}}">{{$v->pof_PostOfficeNumber}}</option>
                                                          @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_address'] ?? 'Address'}}</label>
                                                        <input type="text" name="emp_Address" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_address'] ?? 'Address'}}" value="{{$EmployeesDetail->emp_Address}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_status'] ?? 'Status'}} *</label>
                                                        <select class="form-control dropdown_control icon_control" name="emp_Status" id="emp_Status">
                                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                            <option @if($EmployeesDetail->emp_Status == 'Active') selected @endif value="Active">{{$translations['gn_active'] ?? 'Active'}}</option>
                                                            <option @if($EmployeesDetail->emp_Status == 'Inactive') selected @endif value="Inactive">{{$translations['gn_inactive'] ?? 'Inactive'}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                                        <input type="text" name="emp_Notes" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_note'] ?? 'Note'}}" value="{{$EmployeesDetail->emp_Notes}}">
                                                    </div>
                                                </div>
                                                <div class="row col-md-12">
                                                    
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-8 profile_de_details_add">

                                                        @foreach($EmployeesDetail->employeeEducation as $ke => $ve)
                                                            <div class="profile_info_container">
                                                              <div class="row">
                                                                <div class="col-12 text-right">
                                                                  <img src="{{url('public/images/ic_close_circle.png')}}" class="close_img rm_ed" data-eed="{{$ke+1}}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_university'] ?? 'University'}} :</label>
                                                                  <select id="fkEedUni_{{$ke+1}}" required onchange="fetchCollege(this)" name="fkEedUni_{{$ke+1}}" class="form-control icon_control dropdown_control">
                                                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                                    @foreach($Universities as $k =>$v)
                                                                      <option @if($ve->university->pkUni == $v->pkUni) selected @endif value="{{$v->pkUni}}">{{$v->uni_UniversityName}}</option>
                                                                    @endforeach
                                                                  </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_faculty'] ?? 'Faculty'}} ({{$translations['gn_college'] ?? 'College'}}) :*</label>
                                                                  <select id="fkEedCol_{{$ke+1}}" required name="fkEedCol_{{$ke+1}}" class="form-control icon_control dropdown_control college_sel">
                                                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                                    @foreach($ve->university->college as $k =>$v)
                                                                      <option @if($ve->college->pkCol == $v->pkCol) selected @endif value="{{$v->pkCol}}">{{$v['col_CollegeName_'.$current_language]}}</option>
                                                                    @endforeach
                                                                  </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_academic_degree'] ?? 'Academic Degree'}} :</label>
                                                                  <select id="fkEedAcd_{{$ke+1}}" required name="fkEedAcd_{{$ke+1}}" class="form-control icon_control dropdown_control">
                                                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                                    @foreach($AcademicDegrees as $k =>$v)
                                                                      <option @if($ve->academicDegree->pkAcd == $v->pkAcd) selected @endif value="{{$v->pkAcd}}">{{$v->acd_AcademicDegreeName}}</option>
                                                                    @endforeach
                                                                  </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_qualification_degree'] ?? 'Qualification Degree'}} :</label>
                                                                  <select id="fkEedQde_{{$ke+1}}" required name="fkEedQde_{{$ke+1}}" class="form-control icon_control dropdown_control">
                                                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                                    @foreach($QualificationDegrees as $k =>$v)
                                                                      <option @if($ve->qualificationDegree->pkQde == $v->pkQde) selected @endif value="{{$v->pkQde}}">{{$v->qde_QualificationDegreeName}}</option>
                                                                    @endforeach
                                                                  </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_designation'] ?? 'Designation'}} :</label>
                                                                  <select required id="fkEedEde_{{$ke+1}}" name="fkEedEde_{{$ke+1}}" class="form-control icon_control dropdown_control">
                                                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                                    @foreach($EmployeeDesignations as $k =>$v)
                                                                      <option @if($ve->employeeDesignation->pkEde == $v->pkEde) selected @endif value="{{$v->pkEde}}">{{$v->ede_EmployeeDesignationName}}</option>
                                                                    @endforeach
                                                                  </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_year_of_passing'] ?? 'Year of passing'}} :</label>
                                                                  <input required class="form-control datepicker-year date_control icon_control" type="text" id="eed_YearsOfPassing_{{$ke+1}}" name="eed_YearsOfPassing_{{$ke+1}}" value="{{$ve->eed_YearsOfPassing}}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_short_title'] ?? 'Short title'}} :</label>
                                                                  <input required class="form-control" type="text" id="eed_ShortTitle_{{$ke+1}}" name="eed_ShortTitle_{{$ke+1}}" value="{{$ve->eed_ShortTitle}}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_number_of_semesters'] ?? 'Number of semesters'}} :</label>
                                                                  <input required class="form-control" type="number" id="eed_SemesterNumbers_{{$ke+1}}" name="eed_SemesterNumbers_{{$ke+1}}" value="{{$ve->eed_SemesterNumbers}}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_ect_points'] ?? 'ECT points'}} :</label>
                                                                  <input required class="form-control" type="number" id="eed_EctsPoints_{{$ke+1}}" name="eed_EctsPoints_{{$ke+1}}" value="{{$ve->eed_EctsPoints}}">
                                                                </div>
                                                                  
                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_document'] ?? 'Document'}} :</label>
                                                                  <div class="upload_file">
                                                                    <input type="text" id="file_name_{{$ke+1}}" name="file_name_{{$ke+1}}" class="form-control" value="{{$ve->eed_PicturePath}}">
                                                                    <input class="diploma_file" type="file" id="eed_DiplomaPicturePath_{{$ke+1}}" name="eed_DiplomaPicturePath_{{$ke+1}}" accept="application/pdf,image/jpeg,image/png" />
                                                                  </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                  <label>{{$translations['gn_note'] ?? 'Note'}} :</label>
                                                                  <input class="form-control" type="text" id="eed_Notes_{{$ke+1}}" name="eed_Notes_{{$ke+1}}" value="{{$ve->eed_Notes}}">
                                                                </div>
                                                                <div class="form-group col-md-6 preview_exist_file">
                                                                  <label style="visibility: hidden; display: block;">{{$translations['gn_note'] ?? 'Note'}} :</label>
                                                                  <a class="theme_btn"  href="{{url('public/files/users')}}/{{$ve->eed_PicturePath}}" target="_blank">{{$translations['gn_preview'] ?? 'Preview'}}</a>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        @endforeach
                                                        
                                                        <div class="text-center">
                                                          <button class="theme_btn" id="add_qa" type="button">{{$translations['gn_add'] ?? 'Add'}} {{$translations['gn_qualification'] ?? 'Qualification'}}</button>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-2"></div>
                                                </div>
                                                {{-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_date_of_enrollment'] ?? 'Date of Enrollment'}} *</label>
                                                        <input type="text" id="start_date" name="start_date" class="form-control datepicker icon_control date_control" value="@if(!empty($EmployeesDetail->een_DateOfEngagement)){{date('m/d/Y',strtotime($EmployeesDetail->een_DateOfEngagement))}}@endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} </label>
                                                        <input type="text" id="end_date" name="end_date" class="form-control datepicker icon_control date_control" value="@if(!empty($EmployeesDetail->een_DateOfFinishEngagement)){{date('m/d/Y',strtotime($EmployeesDetail->een_DateOfFinishEngagement))}}@endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label>{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} *</label>
                                                      <select id="fkEenEty" name="fkEenEty" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($EngagementTypes as $k => $v)
                                                          <option @if($EmployeesDetail->fkEenEty == $v->pkEty) selected @endif value="{{$v->pkEty}}">{{$v->ety_EngagementTypeName}}</option>
                                                        @endforeach
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label>{{$translations['gn_hourly_rate'] ?? 'Hourly Rate'}} *</label>
                                                      <input type="number" name="een_WeeklyHoursRate" id="een_WeeklyHoursRate" class="form-control" value="{{$EmployeesDetail->een_WeeklyHoursRate}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label>{{$translations['gn_employee_type'] ?? 'Employee Type'}} *</label>
                                                      <select id="fkEenEpty" name="fkEenEpty" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($employeeType as $k => $v)
                                                          <option @if($EmployeesDetail->fkEenEpty == $v->pkEpty) selected @endif value="{{$v->pkEpty}}">{{$v->epty_Name}}</option>
                                                        @endforeach
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label>{{$translations['gn_notes'] ?? 'Notes'}} *</label>
                                                      <input type="text" name="een_Notes" id="een_Notes" class="form-control" value="{{$EmployeesDetail->een_Notes}}">
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
                                                <input type="hidden" name="emp_engagment_id" value="{{ $EmployeesDetail->pkEen }}">
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                             <div class="text-center">
                                                <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                                <a class="theme_btn red_btn ajax_request no_sidebar_active" @if(Request::is('employee/editEmployee/*')) data-slug="employee/employees" href="{{url('/employee/employees')}}" @else data-slug="admin/employees" href="{{url('/admin/employees')}}" @endif>{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1"></div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="tab-pane fade show" id="Current" role="tabpanel" aria-labelledby="Current-tab">
                            <div class="inner_tab" id="profile_detail3">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <div class="profile_info_container">
                                            <div class="row">
                                              <div class="col-12">
                                                <h6 class="profile_inner_title">{{$translations['gn_work_experience'] ?? 'Work Experience'}}</h6>
                                              </div>
                                              <div class="col-12">
                                                <div class="table-responsive">
                                                  <table class="profile_table">
                                                    <tbody>
                                                      @foreach($EmployeesDetail->EmployeesEngagement as $k => $v)
                                                      <tr>
                                                        <td>{{$k+1}}</td>
                                                        <td>
                                                          <p class="label">{{$v->school->sch_SchoolName ?? ''}} :</p>
                                                          <p class="value">
                                                              @if(isset($v->employeeType->epty_Name) && !empty($v->employeeType->epty_Name))
                                                                  @if($v->employeeType->epty_Name=='Principal') {{ $translations['gn_principal'] ?? 'Principal' }} 
                                                                  @elseif($v->employeeType->epty_Name=='Teacher') {{ $translations['gn_teacher'] ?? 'Teacher' }} 
                                                                  @elseif($v->employeeType->epty_Name=='SchoolCoordinator') {{ $translations['gn_school_coordinator'] ?? 'School Coordinator' }}
                                                                  @else
                                                                  @endif
                                                              @endif
                                                          </p>
                                                          <br>
                                                          <p class="label">{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} :</p>
                                                          <p class="value">{{$v->engagementType->ety_EngagementTypeName ?? ''}}</p>
                                                        </td>
                                                        <td>
                                                          <p class="label">{{$translations['gn_date_of_engagement'] ?? 'Date of Engagement'}} :</p>
                                                          <p class="value">{{date('m/d/Y',strtotime($v->een_DateOfEngagement))}}</p>
                                                          <br>
                                                          <p class="label">{{$translations['gn_hourly_rate'] ?? 'Hourly Rate'}} :</p>
                                                          <p class="value">{{$v->een_WeeklyHoursRate}}</p>
                                                        </td>
                                                        <td>
                                                          <p class="label">{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} :</p>
                                                          <p class="value">@if(!empty($v->een_DateOfFinishEngagement)){{date('m/d/Y',strtotime($v->een_DateOfFinishEngagement))}}@endif</p>
                                                        </td>
                                                      </tr>
                                                      @endforeach
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </div>
                                                
                                            </div>
                                        </div>
                                        <div class="text-center">
                                          {{-- @if($logged_user->type == 'SchoolCoordinator' || $logged_user->type == 'HertronicAdmin') --}}
                                            <button type="button" class="theme_btn" id="add_eng">{{$translations['gn_edit'] ?? 'Edit'}}</button>
                                          {{-- @endif --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-1"></div>
                                </div>
                            </div>
                            <!-- Add Engagement element -->
                            <div id="profile_eng_details" style="display: none;">
                                <form name="edit_eng_form">
                                @foreach($EmployeesDetail->EmployeesEngagement as $k => $v)
                                <div class="row" id="profile_eng_details_{{$k+1}}">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8 profile_info_container new_emp_eng">
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                <img src="{{url('public/images/ic_close_circle.png')}}" class="close_img rm_eng" data-eed="{{$k+1}}">
                                            </div>
                                            <input type="hidden" name="emp_engagment_id[]" id="emp_engagment_id" value="{{ $v->pkEen }}">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_date_of_enrollment'] ?? 'Date of Enrollment'}} *</label>
                                                    <input type="text" id="start_date" name="start_date[]" class="form-control datepicker icon_control date_control" value="@if(!empty($v->een_DateOfEngagement)){{date('m/d/Y',strtotime($v->een_DateOfEngagement))}}@endif">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} </label>
                                                    <input type="text" id="end_date" name="end_date[]" class="form-control datepicker icon_control date_control" value="@if(!empty($v->een_DateOfFinishEngagement)){{date('m/d/Y',strtotime($v->een_DateOfFinishEngagement))}}@endif">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} *</label>
                                                  <select id="fkEenEty" name="fkEenEty[]" class="form-control icon_control dropdown_control">
                                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                    @foreach($EngagementTypes as $k => $et_v)
                                                      <option @if($v->fkEenEty == $et_v->pkEty) selected @endif value="{{$et_v->pkEty}}">{{$et_v->ety_EngagementTypeName}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>{{$translations['gn_hourly_rate'] ?? 'Hourly Rate'}} *</label>
                                                  <input type="number" name="een_WeeklyHoursRate[]" id="een_WeeklyHoursRate" class="form-control" value="{{$v->een_WeeklyHoursRate}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>{{$translations['gn_employee_type'] ?? 'Employee Type'}} *</label>
                                                  <select id="fkEenEpty" name="fkEenEpty[]" class="form-control icon_control dropdown_control">
                                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                    @foreach($employeeType as $k => $et_v)
                                                      <option @if($v->fkEenEpty == $et_v->pkEpty) selected @endif value="{{$et_v->pkEpty}}">@if($et_v->epty_Name=='Principal') {{ $translations['gn_principal'] ?? 'Principal' }} @elseif($et_v->epty_Name=='Teacher') {{ $translations['gn_teacher'] ?? 'Teacher' }} @endif</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>{{$translations['gn_notes'] ?? 'Notes'}} *</label>
                                                  <input type="text" name="een_Notes[]" id="een_Notes" class="form-control" value="{{$v->een_Notes}}">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                @endforeach
                                <div class="col-md-12">
                                  <div class="form-group">
                                      <div class="card">
                                        <div class="card-body">
                                          <b>{{$translations['gn_note'] ?? 'Note'}}:</b> {{$translations['gn_end_date_note'] ?? 'Only enter "Date of Engagment End" date field if you wish to inactive the employee'}}
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                  
                                <div class="col-md-12">
                                    <div class="text-center">
                                         <div class="text-center">
                                            <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                            <button type="button" class="theme_btn red_btn engage_cancel">{{$translations['gn_cancel'] ?? 'Cancel'}}</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                                
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>

    <!-- Add Qualification element -->
    <div id="profile_de_details" style="display: none;">
      <div class="profile_info_container">
        <div class="row">
          <div class="col-12 text-right">
            <img src="{{url('public/images/ic_close_circle.png')}}" class="close_img rm_ed">
          </div>
          <div class="form-group col-md-6">
            <label>{{$translations['gn_university'] ?? 'University'}} :</label>
            <select id="fkEedUni" required onchange="fetchCollege(this)" name="fkEedUni" class="form-control icon_control dropdown_control">
              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
              @foreach($Universities as $k =>$v)
                <option value="{{$v->pkUni}}">{{$v->uni_UniversityName}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>{{$translations['gn_faculty'] ?? 'Faculty'}} ({{$translations['gn_college'] ?? 'College'}}) :*</label>
            <select id="fkEedCol" required name="fkEedCol" class="form-control icon_control dropdown_control college_sel">
              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>

            </select>
          </div>
          <div class="form-group col-md-6">
            <label>{{$translations['gn_academic_degree'] ?? 'Academic Degree'}} :</label>
            <select id="fkEedAcd" required name="fkEedAcd" class="form-control icon_control dropdown_control">
              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
              @foreach($AcademicDegrees as $k =>$v)
                <option value="{{$v->pkAcd}}">{{$v->acd_AcademicDegreeName}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>{{$translations['gn_qualification_degree'] ?? 'Qualification Degree'}} :</label>
            <select id="fkEedQde" required name="fkEedQde" class="form-control icon_control dropdown_control">
              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
              @foreach($QualificationDegrees as $k =>$v)
                <option value="{{$v->pkQde}}">{{$v->qde_QualificationDegreeName}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>{{$translations['gn_designation'] ?? 'Designation'}} :</label>
            <select required id="fkEedEde" name="fkEedEde" class="form-control icon_control dropdown_control">
              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
              @foreach($EmployeeDesignations as $k =>$v)
                <option value="{{$v->pkEde}}">{{$v->ede_EmployeeDesignationName}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>{{$translations['gn_year_of_passing'] ?? 'Year of passing'}} :</label>
            <input required class="form-control datepicker-year date_control icon_control" type="text" id="eed_YearsOfPassing" name="eed_YearsOfPassing">
          </div>
          <div class="form-group col-md-6">
            <label>{{$translations['gn_short_title'] ?? 'Short title'}} :</label>
            <input required class="form-control" type="text" id="eed_ShortTitle" name="eed_ShortTitle">
          </div>
          <div class="form-group col-md-6">
            <label>{{$translations['gn_number_of_semesters'] ?? 'Number of semesters'}} :</label>
            <input required class="form-control" type="number" id="eed_SemesterNumbers" name="eed_SemesterNumbers">
          </div>
          <div class="form-group col-md-6">
            <label>{{$translations['gn_ect_points'] ?? 'ECT points'}} :</label>
            <input required class="form-control" type="number" id="eed_EctsPoints" name="eed_EctsPoints">
          </div>
            
          <div class="form-group col-md-6">
            <label>{{$translations['gn_document'] ?? 'Document'}} :</label>
            <div class="upload_file">
              <input type="text" id="file_name" name="file_name" value="{{$translations['gn_upload'] ?? 'Upload'}}" class="form-control">
              <input class="diploma_file" required type="file" id="eed_DiplomaPicturePath" name="eed_DiplomaPicturePath" accept="application/pdf,image/jpeg,image/png" />
            </div>
          </div>

          <div class="form-group col-md-6">
            <label>{{$translations['gn_note'] ?? 'Note'}} :</label>
            <input class="form-control" type="text" id="eed_Notes" name="eed_Notes">
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" id="add_qualification_txt" value="{{$translations['msg_please_add_qualification'] ?? 'Please add a Qualification'}}">
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
<script type="text/javascript" src="{{ url('public/js/dashboard/employee.js') }}"></script>
@endpush
            