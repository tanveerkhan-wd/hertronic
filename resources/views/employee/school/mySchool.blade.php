@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_my_school'] ?? 'My School')
@section('script', url('public/js/dashboard/my_school.js'))
@section('content')	
<!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 mb-3">
               <h2 class="title"><span>{{$translations['gn_school'] ?? 'School'}} > </span> {{$translations['sidebar_nav_my_school'] ?? 'My School'}}</h2>
            </div> 
		</div>
		
        <div class="white_box">
            <div class="theme_tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{$translations['gn_basic_information'] ?? 'Basic Information'}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="Current-tab" data-toggle="tab" href="#Current" role="tab" aria-controls="Current" aria-selected="true">{{$translations['gn_about'] ?? 'About'}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="Three-tab" data-toggle="tab" href="#Three" role="tab" aria-controls="Three" aria-selected="true">{{$translations['gn_education_program'] ?? 'Education Program'}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="Fourth-tab" data-toggle="tab" href="#Fourth" role="tab" aria-controls="Fourth" aria-selected="true">{{$translations['gn_principal'] ?? 'Principal'}}</a>
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
                                                <img src="@if(!empty($SchoolDetail->sch_SchoolLogo)) {{url('public/images/schools/')}}/{{$SchoolDetail->sch_SchoolLogo}} @else {{ url('public/images/img4.png') }}@endif">
                                            </div>
                                        </div>
                                        <h5 class="profile_name">{{$SchoolDetail['sch_SchoolName_'.$current_language]}}</h5>
                                    </div>
                                    <div class="profile_info_container">
                                        <div class="row">
                                        	<div class="col-12">
                                        		<h6 class="profile_inner_title">{{$translations['gn_basic_information'] ?? 'Basic Information'}}</h6>
                                        	</div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_school'] ?? 'School'}} ID :</p>
                                                    <p class="value">@if(!empty($SchoolDetail->sch_SchoolId)){{$SchoolDetail->sch_SchoolId}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_ministry_license_number'] ?? 'Ministry License No'}}:</p>
                                                    <p class="value">@if(!empty($SchoolDetail->sch_MinistryApprovalCertificate)){{$SchoolDetail->sch_MinistryApprovalCertificate}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_email'] ?? 'Email'}} :</p>
                                                    <p class="value">@if(!empty($SchoolDetail->sch_SchoolEmail)){{$SchoolDetail->sch_SchoolEmail}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_phone'] ?? 'Phone'}} :</p>
                                                    <p class="value">@if(!empty($SchoolDetail->sch_PhoneNumber)){{$SchoolDetail->sch_PhoneNumber}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_zipcode'] ?? 'Zip Code'}} :</p>
                                                    <p class="value">@if(isset($SchoolDetail->postalCode)){{$SchoolDetail->postalCode->pof_PostOfficeNumber}}@endif</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_address'] ?? 'Address'}} :</p>
                                                    <p class="value">@if(!empty($SchoolDetail->sch_Address)){{$SchoolDetail->sch_Address}}@endif</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile_info_container">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="profile_inner_title">{{$translations['gn_school_coordinator'] ?? 'School Coordinator'}}</h6>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_name'] ?? 'Name'}} :</p>
                                                    <p class="value">{{$logged_user->emp_EmployeeName}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_email'] ?? 'Email'}} :</p>
                                                    <p class="value">{{$logged_user->email}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="theme_btn" id="edit_profile">{{$translations['gn_edit_profile'] ?? 'Edit Profile'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                        
                        <div class="inner_tab" id="edit_profile_detail" style="display: none;">
                        	<form id="edit-profile-form" name="school-basic">
                        	<div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="text-center">
                                        <div class="profile_box">
                                            <div class="profile_pic">
                                                <img id="user_img" src="@if(!empty($SchoolDetail->sch_SchoolLogo)) {{url('public/images/schools/')}}/{{$SchoolDetail->sch_SchoolLogo}} @else {{ url('public/images/img4.png') }}@endif">
                                            </div>
                                            <div class="edit_pencile">
                                            	<img src="{{url('public/images/ic_pen.png')}}">
                                            	<input type="file" id="upload_profile" name="upload_profile">
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="col-lg-3"></div>
                                <div class="col-lg-10 offset-lg-1">
                                	<div class="profile_info_container">
                                        <div class="row">
                                        	<div class="col-12">
                                        		<h6 class="profile_inner_title">{{$translations['gn_basic_information'] ?? 'Basic Information'}}</h6>
                                        	</div>
                                        	<input type="hidden" id="sid" name="sid" value="{{$SchoolDetail->pkSch}}">
                                        	@foreach($languages as $k => $v)
                                        	<div class="col-md-6">
				                                <div class="form-group">
				                                    <label>{{$translations['gn_school'] ?? 'School'}} {{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
				                                    <input type="text" name="sch_SchoolName_{{$v->language_key}}" id="sch_SchoolName_{{$v->language_key}}" class="form-control force_require icon_control" required="" value="{{$SchoolDetail['sch_SchoolName_'.$v->language_key]}}">
				                                </div>
				                            </div>
				                            @endforeach
                                        	<div class="col-md-6">
                                        		<div class="form-group">
                                                	<label>{{$translations['gn_school'] ?? 'School'}} ID *</label>
                                                	<input type="text" name="sch_SchoolId" id="sch_SchoolId" class="form-control" value="@if(!empty($SchoolDetail->sch_SchoolId)){{$SchoolDetail->sch_SchoolId}}@endif">
                                                </div>
                                        	</div>
                                        	<div class="col-md-6">
                                        		<div class="form-group">
                                                	<label>{{$translations['gn_email'] ?? 'Email'}} *</label>
                                                	<input type="text" name="sch_SchoolEmail" id="sch_SchoolEmail" class="form-control" value="@if(!empty($SchoolDetail->sch_SchoolEmail)){{$SchoolDetail->sch_SchoolEmail}}@endif">
                                                </div>
                                        	</div>
                                        	<div class="col-md-6">
                                        		<div class="form-group">
                                                	<label>{{$translations['gn_phone'] ?? 'Phone'}} *</label>
                                                	<input type="number" name="sch_PhoneNumber" id="sch_PhoneNumber" class="form-control" value="@if(!empty($SchoolDetail->sch_PhoneNumber)){{$SchoolDetail->sch_PhoneNumber}}@endif">
                                                </div>
                                        	</div>
                                        	<div class="col-md-6">
	                                        	<div class="form-group">
			                                        <label>{{$translations['gn_postal_code'] ?? 'Postal Code'}} *</label>
			                                        <select name="fkSchPof" id="fkSchPof" class="form-control icon_control dropdown_control">
			                                        	<option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
			                                            @foreach($PostalCodes as $k => $v)
			                                            	<option @if($SchoolDetail->fkSchPof == $v->pkPof) selected @endif value="{{$v->pkPof}}">{{$v->pof_PostOfficeNumber}}</option>
			                                            @endforeach
			                                        </select>
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group">
			                                        <label>{{$translations['gn_ownership_type'] ?? 'Ownership Type'}} *</label>
			                                        <select name="fkSchOty" id="fkSchOty" class="form-control icon_control dropdown_control">
			                                        	<option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
			                                            @foreach($OwnershipTypes as $k => $v)
			                                            	<option @if($SchoolDetail->fkSchOty == $v->pkOty) selected @endif value="{{$v->pkOty}}">{{$v->oty_OwnershipTypeName}}</option>
			                                            @endforeach
			                                        </select>
			                                    </div>
			                                </div>
                                        	<div class="col-md-6">
                                        		<div class="form-group">
                                                	<label>{{$translations['gn_address'] ?? 'Address'}}</label>
                                                	<input type="text" id="sch_Address" name="sch_Address" class="form-control" value="@if(!empty($SchoolDetail->sch_Address)){{$SchoolDetail->sch_Address}}@endif">
                                                </div>
                                        	</div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_founder'] ?? 'Founder'}} *</label>
                                                    <input type="text" name="sch_Founder" id="sch_Founder" class="form-control" value="@if(!empty($SchoolDetail->sch_Founder)){{$SchoolDetail->sch_Founder}}@endif">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_founding_date'] ?? 'Founding Date'}} *</label>
                                                    <input type="text" name="sch_FoundingDate" id="sch_FoundingDate" class="form-control date_control datepicker icon_control" value="@if(!empty($SchoolDetail->sch_FoundingDate)){{date('m/d/Y',strtotime($SchoolDetail->sch_FoundingDate))}}@endif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                	 <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
                                        <button type="button" id="cancel_edit_profile" class="theme_btn red_btn">{{$translations['gn_cancel'] ?? 'Cancel'}}</button>
                                    </div>
                                </div>
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
                                        		<h6 class="profile_inner_title">{{$translations['gn_about'] ?? 'About'}} {{$translations['gn_school'] ?? 'School'}}</h6>
                                        	</div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <p class="value">{{$SchoolDetail->sch_AboutSchool}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile_info_container">
                                        <div class="row">
                                        	<div class="col-12">
                                        		<h6 class="profile_inner_title">{{$translations['gn_photos_of_school'] ?? 'Photos of School'}}</h6>
                                        	</div>
                                        	@foreach($SchoolDetail->schoolPhoto as $k => $v)
                                    		<div class="col-lg-2 col-md-4 text-center">
                                    			<img src="{{url('public/images/schools')}}/{{$v->sph_SchoolPhoto}}" class="rounded mb-2">
                                    		</div>
                                    		@endforeach
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="theme_btn " id="edit_profile2" >{{$translations['gn_edit_profile'] ?? 'Edit Profile'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>

                        <div class="inner_tab" id="edit_profile_detail2" style="display: none;">
                        	<form id="edit-profile-form" name="school-about">
                        	<div class="row">
                                <input type="hidden" id="sid" name="sid" value="{{$SchoolDetail->pkSch}}">
                                <div class="col-lg-10 offset-lg-1">
                                	<div class="profile_info_container">
                                        <div class="row">
                                        	<div class="col-12">
                                        		<h6 class="profile_inner_title">{{$translations['gn_about'] ?? 'About'}} {{$translations['gn_school'] ?? 'School'}}</h6>
                                        	</div>
                                        	<div class="col-md-12">
                                        		<div class="form-group">
                                                	<textarea rows="6" name="sch_AboutSchool" id="sch_AboutSchool" class="form-control">{{$SchoolDetail->sch_AboutSchool}}</textarea>
                                                </div>
                                        	</div>
                                        </div>
                                    </div>
                                    <div class="profile_info_container">
                                        <div class="row">
                                        	<div class="col-12">
                                        		<h6 class="profile_inner_title">{{$translations['gn_photos_of_school'] ?? 'Photos of School'}}</h6>
                                        	</div>
                                        	<div class="col-12 img_show_div">
                                        		@foreach($SchoolDetail->schoolPhoto as $k => $v)
                                        		<div class="col-md-2 old_sch_imgs" id="sch_img_{{$v->pkSph}}">
                                        			<img src="{{url('public/images/schools')}}/{{$v->sph_SchoolPhoto}}">
                                        			<span class="close_spn" oid="{{$v->pkSph}}"><img src="{{url('public/images/ic_delete.png')}}"></span>
                                        		</div>
                                        		@endforeach
                                        	</div>
                                        	<div class="col-md-12 text-center">
                                        		<input multiple id="school_imgs" name="school_imgs[]" type="file" style="display: none;">
                                                <button class="theme_btn min_btn" id="upload_link" type="button">{{$translations['gn_browse'] ?? 'Browse'}}</button>
                                        	</div>
                                        </div>
                                    </div>
                                	 <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
                                        <button type="button" id="cancel_edit_profile2" class="theme_btn red_btn">{{$translations['gn_cancel'] ?? 'Cancel'}}</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                       
                    </div>
                    <div class="tab-pane fade show" id="Three" role="tabpanel" aria-labelledby="Three-tab">
                        <div class="inner_tab" id="profile_detail3">
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                  
                                    <div class="profile_info_container">
                                        <div class="row">
                                        	<div class="col-12">
                                        		<h6 class="profile_inner_title">{{$translations['gn_education_program'] ?? 'Education Program'}}</h6>
                                                <table class="color_table school_plan_table">
                                                    <tr>
                                                        <th width="7%">Sr. No</th>
                                                        <th width="15%">{{$translations['gn_parent_category'] ?? 'Parent Category'}}</th>
                                                        <th width="12%">{{$translations['gn_child_category'] ?? 'Child Category'}}</th>
                                                        <th width="15%">{{$translations['gn_education_plan'] ?? 'Education Plan'}}</th>
                                                        <th width="15%">{{$translations['gn_national_education_plan'] ?? 'National Education Plan'}}</th>
                                                        <th width="12%">{{$translations['gn_qualification_degree'] ?? 'Qualification Degree'}}</th>
                                                        <th width="12%">{{$translations['gn_education_profile'] ?? 'Education Profile'}}</th>
                                                        <th width="10%">{{$translations['gn_status'] ?? 'Status'}}</th>
                                                    </tr>
                                                    @foreach($SchoolDetail->schoolEducationPlanAssignment as $k => $v)
                                                        <tr class="sch sch_{{$v->educationPlan->pkEpl}} ">
                                                            <td>{{$k+1}}</td>
                                                            <td>@if($v->educationProgram->edp_ParentId == 0) - @else {{$v->educationProgram->parent['edp_Name_'.$current_language]}} @endif</td>
                                                            <td>{{$v->educationProgram['edp_Name_'.$current_language]}}</td>
                                                            <td>{{$v->educationPlan['epl_EducationPlanName_'.$current_language]}}</td>
                                                            <td>{{$v->educationPlan->nationalEducationPlan['nep_NationalEducationPlanName_'.$current_language]}}</td>
                                                            <td>{{$v->educationPlan->QualificationDegree['qde_QualificationDegreeName_'.$current_language]}}</td>
                                                            <td>{{$v->educationPlan->educationProfile['epr_EducationProfileName_'.$current_language]}}</td>
                                                            <td>@if($v->sep_Status == 'Active') {{$translations['gn_active'] ?? 'Active'}} @else {{$translations['gn_inactive'] ?? 'Inactive'}} @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                        	</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade show" id="Fourth" role="tabpanel" aria-labelledby="Fourth-tab">
                        <div class="inner_tab" id="profile_detail4">
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10">

                                    <div class="profile_info_container">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="profile_inner_title">{{$translations['gn_principal'] ?? 'Principal'}}</h6>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <?php
                                                    $pname = '';
                                                    $date = '';
                                                    foreach($SchoolDetail->employeesEngagement as $k => $v){
                                                        if($v->employeeType->epty_Name=='Principal') {
                                                            $pname = $v->employee->emp_EmployeeName;
                                                            $date = date('m/d/Y',strtotime($v->een_DateOfEngagement)) .' - '. $translations['gn_present'] ?? 'Present';
                                                        }
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_name'] ?? 'Name'}} :</p>
                                                    <p class="value">{{$pname}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <p class="label">{{$translations['gn_duration'] ?? 'Duration'}} :</p>
                                                    <p class="value">{{$date}}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-center">
                                        <button class="theme_btn" id="edit_profile4" type="button">{{$translations['gn_edit_profile'] ?? 'Edit Profile'}}</button>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>

                        <div class="inner_tab" id="edit_profile_detail4" style="display: none;">
                            <form name="school_principal">
                            <div class="row">
                                <input type="hidden" id="sid" name="sid" value="{{$SchoolDetail->pkSch}}">
                                <div class="col-lg-10 offset-lg-1">
                                    <div class="profile_info_container">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="profile_inner_title">{{$translations['gn_principal'] ?? 'Principal'}}</h6>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_select_existing_employee'] ?? 'Select an existing employee'}} ? : *</label>
                                                    <div class="form-check custom_check_div">
                                                        <input class="form-check-input" type="radio" name="sel_exists_employee" id="Customer1" value="Yes">
                                                        <label class="custom_radio"></label>
                                                        <label class="form-check-label" for="Customer1">{{$translations['gn_yes'] ?? 'Yes'}}</label>
                                                    </div>
                                                    <div class="form-check custom_check_div">
                                                        <input class="form-check-input" type="radio" name="sel_exists_employee" checked="checked" id="Customer1" value="No">
                                                        <label class="custom_radio"></label>
                                                        <label class="form-check-label" for="Customer1">{{$translations['gn_no'] ?? 'No'}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 add_new_principal">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_name'] ?? 'Name'}}</label>
                                                    <input type="text" id="principal_name" name="principal_name" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 add_new_principal">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_email'] ?? 'Email'}}</label>
                                                    <input type="text" id="principal_email" name="principal_email" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_start_date'] ?? 'Start Date'}} *</label>
                                                    <input type="text" id="start_date" name="start_date" class="form-control icon_control date_control start_date" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_end_date'] ?? 'End Date'}} </label>
                                                    <input type="text" id="end_date" name="end_date" class="form-control icon_control date_control" value="">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 exists_employee" style="display: none;">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_employees'] ?? 'Employees'}} *</label>
                                                    <select name="principal_sel" id="principal_sel" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($SchoolDetail->employeesEngagement as $k => $v)
                                                            <?php
                                                                $status = '';
                                                                if($v->employeeType->epty_Name=='SchoolCoordinator'){
                                                                    $type = $translations['gn_school_coordinator'] ?? 'School Coordinator';
                                                                }elseif ($v->employeeType->epty_Name=='Teacher') {
                                                                    $type = $translations['gn_teacher'] ?? 'Teacher';
                                                                }elseif ($v->employeeType->epty_Name=='Principal') {
                                                                    $type = $translations['gn_principal'] ?? 'Principal';
                                                                    if($v->een_DateOfFinishEngagement == null){
                                                                        $status = $translations['gn_active'] ?? 'Active';
                                                                    }
                                                                }
                                                                
                                                            ?>
                                                            <option value="{{$v->employee->id}}">{{$v->employee->emp_EmployeeName}} ({{$type}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
                                        <button type="button" id="cancel_edit_profile4" class="theme_btn red_btn">{{$translations['gn_cancel'] ?? 'Cancel'}}</button>
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


<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
@endsection
@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/my_school.js') }}"></script>
@endpush