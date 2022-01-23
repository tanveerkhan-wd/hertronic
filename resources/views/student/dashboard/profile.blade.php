@extends('layout.app_with_login')
@section('title', $translations['gn_profile'] ?? 'Profile')
@section('script', url('public/js/dashboard/employee_profile.js'))
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
                    <li class="nav-item">
                        <a class="nav-link" id="Current-tab" data-toggle="tab" href="#Current" role="tab" aria-controls="Current" aria-selected="true">{{$translations['gn_qualifications'] ?? 'Qualifications'}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="true">{{$translations['gn_work_experience'] ?? 'Work Experience'}}</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="inner_tab" id="profile_detail">
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                    <div class="text-center">
                                        <div class="profile_box">
                                            <div class="profile_pic">
                                                <img src="@if(!empty($logged_user->emp_PicturePath)) {{url('public/images/users/')}}/{{$logged_user->emp_PicturePath}} @else {{ url('public/images/user.png') }}@endif">
                                            </div>
                                        </div>
                                        <h5 class="profile_name">{{$logged_user->emp_EmployeeName}}</h5>
                                        <p class="profile_mail">{{$logged_user->email}}</p>
                                    </div>
                                    <div class="profile_info_container">
                                        <div class="row">
                                          <div class="col-12">
                                            <h6 class="profile_inner_title">{{$translations['gn_general_information'] ?? 'General Information'}}</h6>
                                          </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">ID :</p>
                                                    <p class="value">{{$logged_user->emp_EmployeeID}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_gender'] ?? 'Gender'}} :</p>
                                                    <p class="value">{{$logged_user->emp_EmployeeGender}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_dob'] ?? 'Date of Birth'}}:</p>
                                                    <p class="value">@if(!empty($logged_user->emp_DateOfBirth)){{date('m/d/Y',strtotime($logged_user->emp_DateOfBirth))}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_place_of_birth'] ?? 'Place of Birth'}} :</p>
                                                    <p class="value">{{$logged_user->emp_PlaceOfBirth}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_phone'] ?? 'Phone'}} :</p>
                                                    <p class="value">{{$logged_user->emp_PhoneNumber}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_municipality'] ?? 'Municipality'}} :</p>
                                                    <p class="value">@if(isset($EmployeesDetail->municipality)){{$EmployeesDetail->municipality->mun_MunicipalityName}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_nationality'] ?? 'Nationality'}} :</p>
                                                    <p class="value">@if(isset($EmployeesDetail->nationality)){{$EmployeesDetail->nationality->nat_NationalityName}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_religion'] ?? 'Religion'}} :</p>
                                                    <p class="value">@if(isset($EmployeesDetail->religion)){{$EmployeesDetail->religion->rel_ReligionName}} @endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_citizenship'] ?? 'Citizenship'}} :</p>
                                                    <p class="value">@if(isset($EmployeesDetail->citizenship)){{$EmployeesDetail->citizenship->ctz_CitizenshipName}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_postal_code'] ?? 'Postal Code'}} :</p>
                                                    <p class="value">@if(isset($EmployeesDetail->postalCode)){{$EmployeesDetail->postalCode->pof_PostOfficeNumber}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_address'] ?? 'Address'}} :</p>
                                                    <p class="value">{{$logged_user->emp_Address}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="theme_btn" id="edit_profile">{{$translations['gn_edit_profile'] ?? 'Edit Profile'}}</button>
                                        <button class="theme_btn" data-toggle="modal" data-target="#change_pass">{{$translations['gn_change_password'] ?? 'Change Password'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
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
                                                <img id="user_img" src="@if(!empty($logged_user->emp_PicturePath)) {{url('public/images/users/')}}/{{$logged_user->emp_PicturePath}} @else {{ url('public/images/user.png') }}@endif">
                                                <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
                                            </div>
                                            <div class="edit_pencile">
                                              <img src="{{ url('public/images/ic_pen.png') }}">
                                              <input type="file" id="upload_profile" name="upload_profile" accept="image/jpeg,image/png" oninvalid="setCustomValidity('Please select a valid image')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                          <div class="form-group">
                                              <label>{{$translations['gn_name'] ?? 'Name'}} *</label>
                                              <input type="text" name="emp_EmployeeName" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_name'] ?? 'Name'}}" value="{{$logged_user->emp_EmployeeName}}">
                                              <input id="aid" type="hidden" value="{{$logged_user->id}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_employee'] ?? 'Employee'}} ID *</label>
                                            <input type="text" name="emp_EmployeeID" id="emp_EmployeeID" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} ID" value="{{$logged_user->emp_EmployeeID}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}} </label>
                                            <input type="text" name="emp_TempCitizenId" id="emp_TempCitizenId" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}}" value="{{$logged_user->emp_TempCitizenId}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_gender'] ?? 'Gender'}}</label>
                                            <select name="emp_EmployeeGender" id="emp_EmployeeGender" class="form-control icon_control dropdown_control">
                                              <option @if($logged_user->emp_EmployeeGender == 'Male') selected @endif value="Male">{{$translations['gn_male'] ?? 'Male'}}</option>
                                              <option @if($logged_user->emp_EmployeeGender == 'Female') selected @endif value="Female">{{$translations['gn_female'] ?? 'Female'}}</option>
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_dob'] ?? 'Date of Birth'}}</label>
                                            <input type="text" name="emp_DateOfBirth" id="emp_DateOfBirth" class="form-control icon_control date_control datepicker" value="@if(!empty($logged_user->emp_DateOfBirth)){{date('m/d/Y',strtotime($logged_user->emp_DateOfBirth))}}@endif">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_place_of_birth'] ?? 'Place of Birth'}} *</label>
                                            <input type="text" name="emp_PlaceOfBirth" id="emp_PlaceOfBirth" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_place_of_birth'] ?? 'Place of Birth'}}" value="{{$logged_user->emp_PlaceOfBirth}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_country'] ?? 'Country'}} *</label>
                                            <select name="fkEmpCny" class="form-control icon_control dropdown_control">
                                              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                              @foreach($Countries as $k => $v)
                                                <option @if($EmployeesDetail->fkEmpCny == $v->pkCny) selected @endif value="{{$v->pkCny}}">{{$v->cny_CountryName}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_municipality'] ?? 'Municipality'}} *</label>
                                            <select name="fkEmpMun" class="form-control icon_control dropdown_control">
                                              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                              @foreach($Municipalities as $k => $v)
                                                <option @if($EmployeesDetail->fkEmpMun == $v->pkMun) selected @endif value="{{$v->pkMun}}">{{$v->mun_MunicipalityName}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_nationality'] ?? 'Nationality'}} *</label>
                                            <select name="fkEmpNat" class="form-control icon_control dropdown_control">
                                              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                              @foreach($Nationalities as $k => $v)
                                                <option @if($EmployeesDetail->fkEmpNat == $v->pkNat) selected @endif value="{{$v->pkNat}}">{{$v->nat_NationalityName}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_religion'] ?? 'Religion'}} *</label>
                                            <select name="fkEmpRel" class="form-control icon_control dropdown_control">
                                              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                              @foreach($Religions as $k => $v)
                                                <option @if($EmployeesDetail->fkEmpRel == $v->pkRel) selected @endif value="{{$v->pkRel}}">{{$v->rel_ReligionName}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_citizenship'] ?? 'Citizenship'}} *</label>
                                            <select name="fkEmpCtz" class="form-control icon_control dropdown_control">
                                              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                              @foreach($Citizenships as $k => $v)
                                                <option @if($EmployeesDetail->fkEmpCtz == $v->pkCtz) selected @endif value="{{$v->pkCtz}}">{{$v->ctz_CitizenshipName}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_address'] ?? 'Address'}}</label>
                                            <input type="text" name="emp_Address" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_address'] ?? 'Address'}}" value="{{$logged_user->emp_Address}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_phone'] ?? 'Phone'}} *</label>
                                            <input type="number" name="emp_PhoneNumber" id="emp_PhoneNumber" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone_number'] ?? 'Phone Number'}}" value="{{$logged_user->emp_PhoneNumber}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_email'] ?? 'Email'}} *</label>
                                            <input type="text" name="email" id="email" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_email'] ?? 'Email'}}" value="{{$logged_user->email}}">
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_postal_code'] ?? 'Postal Code'}} *</label>
                                            <select name="fkEmpPof" class="form-control icon_control dropdown_control">
                                              <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                              @foreach($PostalCodes as $k => $v)
                                                <option @if($EmployeesDetail->fkEmpPof == $v->pkPof) selected @endif value="{{$v->pkPof}}">{{$v->pof_PostOfficeNumber}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                            <input type="text" name="emp_Notes" id="emp_Notes" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_note'] ?? 'Note'}}" value="{{$logged_user->emp_Notes}}">
                                          </div>
                                      </div>
                                    <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
                                        <button class="theme_btn red_btn" id="cancel_edit_profile" type="button">{{$translations['gn_cancel'] ?? 'Cancel'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                          </form>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="Current" role="tabpanel" aria-labelledby="Current-tab">
                        <div class="inner_tab" id="profile_detail2">
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                    <div class="profile_info_container">
                                        <div class="row">
                                          <div class="col-12">
                                            <h6 class="profile_inner_title">{{$translations['gn_education_qualifications'] ?? 'Education Qualifications'}}</h6>
                                          </div>
                                          <div class="col-12">
                                            <div class="table-responsive">
                                              <table class="profile_table">
                                                <tbody>
                                                  @foreach($EmployeesDetail->employeeEducation as $ke => $ve)
                                                    <tr>
                                                      <td>{{$ke+1}}</td>
                                                      <td><p class="label">{{$translations['gn_faculty'] ?? 'Faculty'}} ({{$translations['gn_college'] ?? 'College'}}) :*</p>
                                                            <p class="value">{{$ve->college->col_CollegeName}}</p>
                                                      </td>
                                                      <td>
                                                        <p class="label">{{$translations['gn_university'] ?? 'University'}} :</p>
                                                      <p class="value">{{$ve->university->uni_UniversityName}}</p>
                                                      </td>
                                                      <td>
                                                        <p class="label">{{$translations['gn_year_of_passing'] ?? 'Year of passing'}} :</p>
                                                      <p class="value">{{$ve->eed_YearsOfPassing}}</p>
                                                      </td>
                                                      <td>
                                                        <p class="label">{{$translations['gn_document'] ?? 'Document'}} :</p>
                                                      <p class="value"><a target="_blank" href="{{url('public/files/users')}}/{{$ve->eed_PicturePath}}">{{$ve->eed_PicturePath}}</a></p>
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
                                        <button class="theme_btn" id="edit_profile2">{{$translations['gn_edit_profile'] ?? 'Edit Profile'}}</button>
                                        <button class="theme_btn" data-toggle="modal" data-target="#change_pass">{{$translations['gn_change_password'] ?? 'Change Password'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                        <div class="inner_tab" id="edit_profile_detail2" style="display: none;">
                          <form name="employee-education-detail-form">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6 profile_de_details_add">
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
                                      </div>
                                    </div>
                                    @endforeach
                                    <div class="text-center">
                                      <button class="theme_btn min_btn" id="add_qa" type="button">{{$translations['gn_add'] ?? 'Add'}}</button>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
                                        <button class="theme_btn red_btn" id="cancel_edit_profile2" type="button">{{$translations['gn_cancel'] ?? 'Cancel'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                          </form>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
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
                                                      <p class="label">{{$v->school->sch_SchoolName}} :</p>
                                                      <p class="value">{{$v->employeeType->epty_Name}}</p>
                                                      <br>
                                                      <p class="label">{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} :</p>
                                                      <p class="value">{{$v->engagementType->ety_EngagementTypeName}}</p>
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
                                      @if($logged_user->type == 'SchoolCoordinator')
                                        <button class="theme_btn" id="edit_profile3">{{$translations['gn_edit_profile'] ?? 'Edit Profile'}}</button>
                                      @endif
                                        <button class="theme_btn" data-toggle="modal" data-target="#change_pass">{{$translations['gn_change_password'] ?? 'Change Password'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                        <div class="inner_tab" id="edit_profile_detail3" style="display: none;">
                            <form name="engage-emp-form">
                              <input type="hidden" id="sid" name="sid" value="{{$MainSchool}}">
                                  <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8 profile_eng_details_add">
                                      @foreach($EmployeesEngagements as $ke => $v)
                                        <div class="profile_info_container">
                                          <div class="row">
                                          <div class="col-12 text-right">
                                              <img src="{{url('public/images/ic_close_circle.png')}}" class="rm_eng close_img" data-eed="{{$k+1}}">
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>{{$translations['gn_date_of_engagement'] ?? 'Date of Engagement'}} *</label>
                                                  <input required type="text" id="start_date_{{$ke+1}}" name="start_date_{{$ke+1}}" class="form-control icon_control date_control datepicker_norm" value="@if(!empty($v->een_DateOfEngagement)){{date('m/d/Y',strtotime($v->een_DateOfEngagement))}}@endif">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} </label>
                                                  <input  type="text" id="end_date_{{$ke+1}}" name="end_date_{{$ke+1}}" class="form-control icon_control date_control datepicker_norm" value="@if(!empty($v->een_DateOfFinishEngagement)){{date('m/d/Y',strtotime($v->een_DateOfFinishEngagement))}}@endif">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>{{$translations['gn_week_hourly_rate'] ?? 'Week Hourly Rate'}} *</label>
                                                  <input required type="text" id="een_WeeklyHoursRate_{{$ke+1}}" name="een_WeeklyHoursRate_{{$ke+1}}" class="form-control" value="{{$v->een_WeeklyHoursRate}}">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} *</label>
                                                  <select required id="fkEenEty_{{$ke+1}}" name="fkEenEty_{{$ke+1}}" class="form-control icon_control dropdown_control">
                                                      <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                      @foreach($EngagementTypes as $k => $ve)
                                                        <option @if($v->fkEenEty == $ve->pkEty) selected @endif value="{{$ve->pkEty}}">{{$ve->ety_EngagementTypeName}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>{{$translations['gn_employee_type'] ?? 'Employee Type'}} *</label>
                                                  <select required id="fkEenEpty_{{$ke+1}}" name="fkEenEpty_{{$ke+1}}" class="form-control icon_control dropdown_control">
                                                      <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                      @foreach($EmployeeTypes as $k => $ve)
                                                        <option @if($v->fkEenEpty == $ve->pkEpty) selected @endif value="{{$ve->pkEpty}}">@if(!empty($ve->epty_subCatName)){{$ve->epty_subCatName}} @else {{$ve->epty_Name}} @endif</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                                  <input type="text" id="note_{{$ke+1}}" name="note_{{$ke+1}}" class="form-control" value="{{$v->een_Notes}}">
                                              </div>
                                          </div>
                                        </div>
                                      </div>
                                    @endforeach
                                    <div class="text-center add_eng_btn">
                                      <button class="theme_btn min_btn" id="add_eng" type="button">{{$translations['gn_add'] ?? 'Add'}}</button>
                                    </div>
                                  </div>
                                  <div class="col-md-2"></div>
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
                                      <button type="Submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                      <button class="theme_btn red_btn" id="cancel_edit_profile3" type="button">{{$translations['gn_cancel'] ?? 'Cancel'}}</button>
                                  </div>
                              </div>
                          </form>
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

                    <!-- Add Engagement element -->
                    <div id="profile_eng_details" style="display: none;">
                      <div class="profile_info_container new_emp_eng">
                        <div class="row">
                        <div class="col-12 text-right">
                            <img src="{{url('public/images/ic_close_circle.png')}}" class="close_img rm_eng" data-eed="">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{$translations['gn_date_of_engagement'] ?? 'Date of Engagement'}} *</label>
                                <input required type="text" id="start_date" name="start_date" class="form-control icon_control date_control datepicker_future">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} </label>
                                <input type="text" id="end_date" name="end_date" class="form-control icon_control date_control datepicker_future">
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
                                    @foreach($EmployeeTypes as $k => $v)
                                      @if($v->epty_Name != 'SchoolCoordinator')
                                        <option value="{{$v->pkEpty}}">@if(!empty($v->epty_subCatName)){{$v->epty_subCatName}} @else {{$v->epty_Name}} @endif</option>
                                      @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                <input type="text" id="note" name="note" class="form-control">
                            </div>
                        </div>
                      </div>
                    </div>
                    </div>

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
  <input type="hidden" id="add_qualification_txt" value="{{$translations['msg_please_add_qualification'] ?? 'Please add a Qualification'}}">
  <input type="hidden" id="add_engagment_txt" value="{{$translations['msg_please_add_engagment'] ?? 'Please add an engagment'}}">
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
<script type="text/javascript" src="{{ url('public/js/dashboard/employee_profile.js') }}"></script>
@endpush