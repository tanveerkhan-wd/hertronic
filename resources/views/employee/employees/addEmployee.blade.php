@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_employees'] ?? 'Employees')
@section('script', url('public/js/dashboard/employee.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
               <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/employees" href="{{url('/employee/employees')}}"><span>{{$translations['sidebar_nav_employees'] ?? 'Employees'}} > </span></a> {{$translations['gn_add'] ?? 'Add'}}</h2>
            </div> 
        </div>
        
        <form name='add-teacher-form'>
        <div class="white_box">
            <div class="theme_tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{$translations['gn_general_information'] ?? 'General Information'}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="Current-tab" data-toggle="tab" href="#Current" role="tab" aria-controls="Current" aria-selected="true">{{$translations['gn_add_engagement'] ?? 'Add Engagement'}}</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="inner_tab" id="profile_detail">
                            <input type="hidden" id="sid" value="{{$mainSchool}}">
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                    <div class="text-center">
                                        <div class="profile_box">
                                            <div class="profile_pic">
                                                <img id="user_img" src="{{ url('public/images/user.png') }}">
                                                <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
                                            </div>
                                        </div>
                                        <div  class="upload_pic_link">
                                            <a href="javascript:void(0)">
                                            {{$translations['gn_upload_photo'] ?? 'Upload Photo'}}<input type="file" id="upload_profile" name="upload_profile" accept="image/jpeg,image/png"></a>
                                            
                                        </div>
                                       <!--  <p class="profile_mail">john.smith@gmail.com</p> -->
                                    </div>
                                    <input type="hidden" id="image_validation_msg" value="{{$translations['msg_image_validation'] ?? 'Please select a valid image'}}">

                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_name'] ?? 'Name'}} *</label>
                                                    <input type="text" name="emp_EmployeeName" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_name'] ?? 'Name'}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_email'] ?? 'Email'}} *</label>
                                                    <input type="text" name="email" id="email" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_email'] ?? 'Email'}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_phone'] ?? 'Phone'}} *</label>
                                                    <input type="number" name="emp_PhoneNumber" id="emp_PhoneNumber" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone_number'] ?? 'Phone Number'}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_employee'] ?? 'Employee'}} ID *</label>
                                                    <input type="text" name="emp_EmployeeID" id="emp_EmployeeID" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} ID">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}} </label>
                                                    <input type="text" name="emp_TempCitizenId" id="emp_TempCitizenId" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_gender'] ?? 'Gender'}}</label>
                                                    <select name="emp_EmployeeGender" id="emp_EmployeeGender" class="form-control icon_control dropdown_control">
                                                      <option value="Male">{{$translations['gn_male'] ?? 'Male'}}</option>
                                                      <option value="Female">{{$translations['gn_female'] ?? 'Female'}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_dob'] ?? 'Date of Birth'}}</label>
                                                    <input type="text" name="emp_DateOfBirth" id="emp_DateOfBirth" class="form-control icon_control date_control datepicker">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_place_of_birth'] ?? 'Place of Birth'}} *</label>
                                                    <input type="text" name="emp_PlaceOfBirth" id="emp_PlaceOfBirth" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_place_of_birth'] ?? 'Place of Birth'}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_country'] ?? 'Country'}} *</label>
                                                    <select name="fkEmpCny" class="form-control icon_control dropdown_control">
                                                      <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                      @foreach($Countries as $k => $v)
                                                        <option value="{{$v->pkCny}}">{{$v->cny_CountryName}}</option>
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
                                                        <option value="{{$v->pkMun}}">{{$v->mun_MunicipalityName}}</option>
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
                                                        <option value="{{$v->pkNat}}">{{$v->nat_NationalityName}}</option>
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
                                                        <option value="{{$v->pkRel}}">{{$v->rel_ReligionName}}</option>
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
                                                        <option value="{{$v->pkCtz}}">{{$v->ctz_CitizenshipName}}</option>
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
                                                        <option value="{{$v->pkPof}}">{{$v->pof_PostOfficeNumber}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_address'] ?? 'Address'}}</label>
                                                    <input type="text" name="emp_Address" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_address'] ?? 'Address'}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_status'] ?? 'Status'}} *</label>
                                                    <select class="form-control dropdown_control icon_control" name="emp_Status" id="emp_Status">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        <option value="Active">{{$translations['gn_active'] ?? 'Active'}}</option>
                                                        <option value="Inactive">{{$translations['gn_inactive'] ?? 'Inactive'}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                                    <input type="text" name="emp_Notes" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_note'] ?? 'Note'}}">
                                                </div>
                                            </div>
                                            <div class="row col-md-12">
                                                
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8 profile_de_details_add">
                                                    
                                                    <div class="text-center">
                                                      <button class="theme_btn" id="add_qa" type="button">{{$translations['gn_add'] ?? 'Add'}} {{$translations['gn_qualification'] ?? 'Qualification'}}</button>
                                                    </div>

                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_date_of_enrollment'] ?? 'Date of Enrollment'}} *</label>
                                                    <input type="text" id="start_date" name="start_date" class="form-control datepicker icon_control date_control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} </label>
                                                    <input type="text" id="end_date" name="end_date" class="form-control datepicker icon_control date_control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} *</label>
                                                  <select id="fkEenEty" name="fkEenEty" class="form-control icon_control dropdown_control">
                                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                    @foreach($EngagementTypes as $k => $v)
                                                      <option value="{{$v->pkEty}}">{{$v->ety_EngagementTypeName}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>{{$translations['gn_hourly_rate'] ?? 'Hourly Rate'}} *</label>
                                                  <input type="number" name="een_WeeklyHoursRate" id="een_WeeklyHoursRate" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>{{$translations['gn_employee_type'] ?? 'Employee Type'}} *</label>
                                                  <select id="fkEenEpty" name="fkEenEpty" class="form-control icon_control dropdown_control">
                                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                    @foreach($employeeType as $k => $v)
                                                      <option value="{{$v->pkEpty}}">{{$v->epty_Name}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>{{$translations['gn_notes'] ?? 'Notes'}} *</label>
                                                  <input type="text" name="een_Notes" id="een_Notes" class="form-control">
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
                                            </div> --}}
                                        </div>
                                    </div>
                                    <input type="hidden" id="msg_add_engagemnet_field" value="{{ $translations['msg_add_engagement'] ?? 'Add Engagement' }}">
                                    <div class="text-center">
                                         <div class="text-center">
                                            <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                            <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="employee/employees" href="{{url('/employee/employees')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade show" id="Current" role="tabpanel" aria-labelledby="Current-tab">
                        <div class="inner_tab">
                        <!-- Add Engagement element -->
                        <div class="row" id="profile_eng_details" style="display: none;">
                              <div class="col-md-2"></div>
                              <div class="col-md-8 profile_info_container new_emp_eng">
                                <div class="row">
                                <div class="col-12 text-right">
                                    <img src="{{url('public/images/ic_close_circle.png')}}" class="close_img rm_eng" data-eed="">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$translations['gn_date_of_engagement'] ?? 'Date of Engagement'}} *</label>
                                        <input required type="text" id="start_date" name="start_date" class="form-control datepicker icon_control date_control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} </label>
                                        <input type="text" id="end_date" name="end_date" class="form-control datepicker icon_control date_control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$translations['gn_week_hourly_rate'] ?? 'Week Hourly Rate'}} *</label>
                                        <input required type="text" id="een_WeeklyHoursRate" name="een_WeeklyHoursRate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} *</label>
                                        <select required id="fkEenEty" name="fkEenEty" class="form-control icon_control dropdown_control">
                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                            @foreach($EngagementTypes as $k => $v)
                                              <option value="{{$v->pkEty}}">{{$v->ety_EngagementTypeName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$translations['gn_employee_type'] ?? 'Employee Type'}} *</label>
                                        <select required id="fkEenEpty" name="fkEenEpty" class="form-control icon_control dropdown_control">
                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                            @foreach($employeeType as $k => $v)
                                              <option value="{{$v->pkEpty}}">@if($v->epty_Name=='Principal') {{ $translations['gn_principal'] ?? 'Principal' }} @elseif($v->epty_Name=='Teacher') {{ $translations['gn_teacher'] ?? 'Teacher' }} @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                        <input type="text" id="een_Notes" name="een_Notes" class="form-control">
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2"></div>

                        </div>
                            <div class="text-center add_eng_btn">
                              <button class="theme_btn min_btn" id="add_eng" type="button">{{$translations['gn_add'] ?? 'Add'}}</button>
                            </div>
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
                                    <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="employee/employees" href="{{url('/employee/employees')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
                                </div>
                            </div>
                          </div>                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
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
            