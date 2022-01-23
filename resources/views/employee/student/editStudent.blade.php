@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_students'] ?? 'Students')
@section('script', url('public/js/dashboard/student.js'))
@section('content')	
<!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 mb-3">
				@if($logged_user->type=='MinistryAdmin')
					<h2 class="title"><a class="ajax_request no_sidebar_active" data-slug="admin/students" href="{{url('admin/students')}}"> <span>{{$translations['sidebar_nav_students'] ?? 'Students'}} > </span></a> {{$translations['gn_edit'] ?? 'Edit'}}</h2>

				@else
					<h2 class="title"><span>@if($logged_user->type != 'HertronicAdmin'){{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/students" href="{{url('employee/students')}}"> @else {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}} > </span><a class="ajax_request no_sidebar_active" data-slug="admin/students" href="{{url('admin/students')}}"> @endif<span>{{$translations['sidebar_nav_students'] ?? 'Students'}} > </span></a> {{$translations['gn_edit'] ?? 'Edit'}}</h2>
				@endif
            </div> 
            @if($logged_user->type == 'HertronicAdmin'  || $logged_user->type=='MinistryAdmin')
            <input type="hidden" id="is_HSA">
            @endif
        <div class="col-12">
            <div class="white_box pt-5 pb-5">
                <div class="container-fliid">
                    <form name="add-student-form">
	                    <div class="row">
	                        <div class="col-lg-3"></div>
	                        <div class="col-lg-6">
	                        	<input type="hidden" id="image_validation_msg" value="{{$translations['msg_image_validation'] ?? 'Please select a valid image'}}">
	                            <div class="text-center">
	                                <div class="profile_box">
	                                    <div class="profile_pic">
	                       	                <img id="user_img" src="@if(!empty($aStudentData->stu_PicturePath)) {{url('public/images/students')}}/{{$aStudentData->stu_PicturePath}} @else {{ url('public/images/user.png') }}@endif">
	                                        <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
	                                    </div>
	                                    <div class="edit_pencile">
	                                        <img src="{{url('public/images/ic_pen.png')}}">
	                                        <input type="file" id="upload_profile" name="stu_PicturePath" accept="image/jpeg,image/png">
	                                    </div>
	                                </div>
	                            </div>
		                            <div class="">
		                                <div class="form-group">
		                                    <label>{{$translations['gn_first_name'] ?? 'First Name'}} *</label>
		                                    <input type="text" name="stu_StudentName" value="{{$aStudentData->stu_StudentName}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_first_name'] ?? 'First Name'}}">
		                                    <input id="aid" type="hidden" value="{{$aStudentData->id}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_last_name'] ?? 'Last Name'}} *</label>
		                                    <input type="text" name="stu_StudentSurname"  value="{{$aStudentData->stu_StudentSurname}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_last_name'] ?? 'Last Name'}}">
		                                </div>
		                                {{-- <div class="form-group">
		                                    <label>{{$translations['gn_student_id'] ?? 'Student ID'}} *</label>

		                                    <input type="text" id="stu_StudentID" name="stu_StudentID" value="{{$aStudentData->stu_StudentID}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_student_id'] ?? 'Student Id'}}">
		                                </div>
		                                <div class="form-group form-check">
		                                    <input type="checkbox" class="form-check-input" id="havent_identification_number">
		                                    <label class="custom_checkbox"></label>
		                                    <label class="form-check-label label-text" for="exampleCheck1">{{$translations['gn_havent_identification_number'] ?? 'Haven’t Identification number'}}</label>
		                                </div> --}}
		                                <div class="form-group">
		                                    <label>{{$translations['gn_student_id'] ?? 'Student ID'}} *</label>

		                                    <input @if(!empty($aStudentData->stu_TempCitizenId) && empty($aStudentData->stu_StudentID)) disabled @endif type="text" id="stu_StudentID" name="stu_StudentID" value="{{$aStudentData->stu_StudentID}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}}  {{$translations['gn_student_id'] ?? 'Student Id'}}">
		                                </div>
		                                <div class="form-group form-check">
		                                    <input @if(empty($aStudentData->stu_StudentID)) checked @endif type="checkbox" class="form-check-input" id="havent_identification_number">
		                                    <label class="custom_checkbox"></label>
		                                    <label class="form-check-label label-text" for="exampleCheck1">{{$translations['gn_havent_identification_number'] ?? 'Haven’t Identification number'}}</label>
		                                </div>
		                                <div class="form-group opt_tmp_id @if(empty($aStudentData->stu_TempCitizenId) || !empty($aStudentData->stu_StudentID) ) hide_content @endif">
		                                    <label>{{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}} *</label>
		                                    <input type="text" name="stu_TempCitizenId" value="{{$aStudentData->stu_TempCitizenId}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}}">
		                                </div>

		                                <div class="form-group">
		                                    <label>{{$translations['gn_gender'] ?? 'Gender'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="stu_StudentGender">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                <option @if($aStudentData->stu_StudentGender == 'Male') selected @endif value="Male">{{$translations['gn_male'] ?? 'Male'}}</option>
                                                <option @if($aStudentData->stu_StudentGender == 'Female') selected @endif value="Female">{{$translations['gn_female'] ?? 'Female'}}</option>
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_date_Of_birth'] ?? 'Date Of Birth'}} *</label>
		                                    <input type="text" name="stu_DateOfBirth" value="{{date('d-m-Y',strtotime($aStudentData->stu_DateOfBirth))}}" class="form-control icon_control date_control datepicker" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_dob'] ?? 'Date of birth'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_place_of_birth'] ?? 'Place Of Birth'}} *</label>
		                                    <input type="text" name="stu_PlaceOfBirth" value="{{$aStudentData->stu_PlaceOfBirth}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} Place of birth">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_municipality'] ?? 'Municipality'}}*</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuMun">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @foreach($municipality as $value)
		                                        	<option @if($aStudentData->fkStuMun == $value->pkMun) selected @endif value="{{$value->pkMun}}">{{$value->mun_MunicipalityName}}</option>
		                                        @endforeach
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_nationality'] ?? 'Nationality'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuNat">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @foreach($nationality as $value)
		                                        	<option @if($aStudentData->fkStuNat == $value->pkNat) selected @endif value="{{$value->pkNat}}">{{$value->nat_NationalityName}}</option>
		                                        @endforeach
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_citizenship'] ?? 'Citizenship'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuCtz">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @foreach($citizenship as $value)
		                                        	<option @if($aStudentData->fkStuCtz == $value->pkCtz) selected @endif value="{{$value->pkCtz}}">{{$value->ctz_CitizenshipName}}</option>
		                                        @endforeach
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_religions'] ?? 'Religions'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuRel">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @foreach($religion as $value)
		                                        	<option @if($aStudentData->fkStuRel == $value->pkRel) selected @endif value="{{$value->pkRel}}">{{$value->rel_ReligionName}}</option>
		                                        @endforeach
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_address'] ?? 'Address'}} *</label>
		                                    <input type="text" name="stu_Address" value="{{$aStudentData->stu_Address}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_address'] ?? 'Address'}}">
		                                </div>

		                                <div class="form-group">
		                                    <label>{{$translations['gn_student_email'] ?? 'Student Email'}} *</label>
		                                    <input type="text" name="email" class="form-control" value="{{$aStudentData->email}}" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_email'] ?? 'Email'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_distance_in_kilometers'] ?? 'Distance In Kilometers'}}</label>
		                                    <input type="text" name="stu_DistanceInKilometers" value="{{$aStudentData->stu_DistanceInKilometers}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} Kilometers">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_phone'] ?? 'Student Phone'}} *</label>
		                                    <input type="text" name="stu_PhoneNumber" value="{{$aStudentData->stu_PhoneNumber}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone_number'] ?? 'Phone number'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_mobile_phone_number'] ?? 'Mobile Phone Number'}}</label>
		                                    <input type="text" name="stu_MobilePhoneNumber" value="{{$aStudentData->stu_MobilePhoneNumber}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone_number'] ?? 'Phone number'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_postal_code'] ?? 'Postal Code'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuPof">
		                                    	<option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @foreach($postalCode as $value)
		                                        	<option @if($aStudentData->fkStuPof == $value->pkPof) selected @endif value="{{$value->pkPof}}">{{$value->pof_PostOfficeNumber}}</option>
		                                        @endforeach
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_father_name'] ?? 'Father’s Name'}}</label>
		                                    <input type="text" name="stu_FatherName" value="{{$aStudentData->stu_FatherName}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_father_name'] ?? 'Father’s Name'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_mother_name'] ?? 'Mother Name'}}</label>
		                                    <input type="text" name="stu_MotherName" value="{{$aStudentData->stu_MotherName}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_mother_name'] ?? 'Mother Name'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_father_job'] ?? 'Father’s Job'}}</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuFatherJaw">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @foreach($jawWork as $value)
		                                        	<option @if($aStudentData->fkStuFatherJaw == $value->pkJaw) selected @endif value="{{$value->pkJaw}}">{{$value->jaw_Name}}</option>
		                                        @endforeach
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_mother_job'] ?? 'Mother’s Job'}}</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuMotherJaw">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @foreach($jawWork as $value)
		                                        	<option @if($aStudentData->fkStuMotherJaw == $value->pkJaw) selected @endif value="{{$value->pkJaw}}">{{$value->jaw_Name}}</option>
		                                        @endforeach
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_parent_email'] ?? 'Parent’s Email'}} *</label>
		                                    <input type="text" name="stu_ParentsEmail" value="{{$aStudentData->stu_ParentsEmail}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_email'] ?? 'Email'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_Parent_phone_no'] ?? 'Parent’s Phone No.'}} *</label>
		                                    <input type="number" name="stu_ParantsPhone" value="{{$aStudentData->stu_ParantsPhone}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone_number'] ?? 'Phone number'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_special_needs'] ?? 'Special Needs'}}</label>
		                                    <select class="form-control icon_control dropdown_control" name="stu_SpecialNeed">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        <option @if($aStudentData->stu_SpecialNeed == 'Yes') selected @endif value="Yes">{{$translations['gn_yes'] ?? 'Yes'}}</option>
		                                        <option @if($aStudentData->stu_SpecialNeed == 'No') selected @endif value="No">{{$translations['gn_no'] ?? 'No'}}</option>
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_notes'] ?? 'Notes'}}</label>
		                                    <input type="text" name="stu_Notes" value="{{$aStudentData->stu_Notes}}" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_note'] ?? 'Note'}}">
		                                </div>
		                                
		                            </div>
		                        <div class="text-center">
	                            	<button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
	                                <a class="theme_btn red_btn ajax_request no_sidebar_active" @if($logged_user->type == 'HertronicAdmin' || $logged_user->type == 'MinistryAdmin') data-slug="admin/students" href="{{url('/admin/students')}}" @else data-slug="employee/students" href="{{url('/employee/students')}}" @endif>{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
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
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
@endsection
@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/student.js') }}"></script>
@endpush