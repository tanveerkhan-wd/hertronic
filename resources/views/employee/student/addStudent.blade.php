@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_students'] ?? 'Students')
@section('script', url('public/js/dashboard/student.js'))
@section('content')	
<!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 mb-3">
				<h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/students" href="{{url('/employee/students')}}"><span>{{$translations['sidebar_nav_students'] ?? 'Students'}} > </span></a> {{$translations['gn_add_new'] ?? 'Add New'}}</h2>
            </div> 
            @if($logged_user->type == 'HertronicAdmin')
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
	                       	                <img id="user_img" src="{{ url('public/images/user.png') }}">
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
		                                    <input type="text" name="stu_StudentName" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_first_name'] ?? 'First Name'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_last_name'] ?? 'Last Name'}} *</label>
		                                    <input type="text" name="stu_StudentSurname" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_last_name'] ?? 'Last Name'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_student_id'] ?? 'Student ID'}}*</label>
		                                    <input type="text" id="stu_StudentID" name="stu_StudentID" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_student_id'] ?? 'Student Id'}}">
		                                </div>
		                                <div class="form-group form-check">
		                                    <input type="checkbox" class="form-check-input" id="havent_identification_number">
		                                    <label class="custom_checkbox"></label>
		                                    <label class="form-check-label label-text" for="exampleCheck1">{{$translations['gn_havent_identification_number'] ?? 'Haven’t Identification number'}}</label>
		                                </div>

		                                <div class="form-group opt_tmp_id">
			                                <div class="form-group opt_tmp_id hide_content">
			                                    <label>{{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID*'}}</label>
			                                    <input type="text" name="stu_TempCitizenId" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}}">
			                                </div>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_gender'] ?? 'Gender'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="stu_StudentGender">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        <option value="Male">{{$translations['gn_male'] ?? 'Male'}}</option>
		                                        <option value="Female">{{$translations['gn_female'] ?? 'Female'}}</option>
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_date_Of_birth'] ?? 'Date Of Birth'}} *</label>
		                                    <input type="text" name="stu_DateOfBirth" class="form-control icon_control date_control datepicker" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_dob'] ?? 'Date of Birth'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_place_of_birth'] ?? 'Place Of Birth'}} *</label>
		                                    <input type="text" name="stu_PlaceOfBirth" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} Place of birth">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_municipality'] ?? 'Municipality'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuMun">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @forelse($municipality as $value)
		                                        	<option value="{{$value->pkMun}}">{{$value->mun_MunicipalityName}}</option>
		                                        @empty
		                                        	<option>No Data Available!</option>
		                                        @endforelse
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_nationality'] ?? 'Nationality'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuNat">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @forelse($nationality as $value)
		                                        	<option value="{{$value->pkNat}}">{{$value->nat_NationalityName}}</option>
		                                        @empty
		                                        	<option>No Data Available!</option>
		                                        @endforelse
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_citizenship'] ?? 'Citizenship'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuCtz">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @forelse($citizenship as $value)
		                                        	<option value="{{$value->pkCtz}}">{{$value->ctz_CitizenshipName}}</option>
		                                        @empty
		                                        	<option>No Data Available!</option>
		                                        @endforelse
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_religions'] ?? 'Religions'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuRel">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @forelse($religion as $value)
		                                        	<option value="{{$value->pkRel}}">{{$value->rel_ReligionName}}</option>
		                                        @empty
		                                        	<option>No Data Available!</option>
		                                        @endforelse
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_address'] ?? 'Address'}} *</label>
		                                    <input type="text" name="stu_Address" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} Address">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_student_email'] ?? 'Student Email'}} *</label>
		                                    <input type="text" id="email" name="email" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_email'] ?? 'Email'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_distance_in_kilometers'] ?? 'Distance In Kilometers'}} </label>
		                                    <input type="text" name="stu_DistanceInKilometers" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} Kilometers">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_phone'] ?? 'Student Phone'}} *</label>
		                                    <input type="number" name="stu_PhoneNumber" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone_number'] ?? 'Phone number'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_mobile_phone_number'] ?? 'Mobile Phone Number'}}</label>
		                                    <input type="number" name="stu_MobilePhoneNumber" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone_number'] ?? 'Phone number'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_postal_code'] ?? 'Postal Code'}} *</label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuPof">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @forelse($postalCode as $value)
		                                        	<option value="{{$value->pkPof}}">{{$value->pof_PostOfficeNumber}}</option>
		                                        @empty
		                                        	<option>No Data Available!</option>
		                                        @endforelse
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_father_name'] ?? 'Father’s Name'}} </label>
		                                    <input type="text" name="stu_FatherName" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_father_name'] ?? 'Father’s Name'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_mother_name'] ?? 'Mother Name'}} </label>
		                                    <input type="text" name="stu_MotherName" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_mother_name'] ?? 'Mother Name'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_father_job'] ?? 'Father’s Job'}} </label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuFatherJaw">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @forelse($jawWork as $value)
		                                        	<option value="{{$value->pkJaw}}">{{$value->jaw_Name}}</option>
		                                        @empty
		                                        	<option>No Data Available!</option>
		                                        @endforelse
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_mother_job'] ?? 'Mother’s Job'}} </label>
		                                    <select class="form-control icon_control dropdown_control" name="fkStuMotherJaw">
		                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
		                                        @forelse($jawWork as $value)
		                                        	<option value="{{$value->pkJaw}}">{{$value->jaw_Name}}</option>
		                                        @empty
		                                        	<option>No Data Available!</option>
		                                        @endforelse
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_parent_email'] ?? 'Parent’s Email'}} *</label>
		                                    <input type="text" name="stu_ParentsEmail" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_email'] ?? 'Email'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_Parent_phone_no'] ?? 'Parent’s Phone No.'}} *</label>
		                                    <input type="number" name="stu_ParantsPhone" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_phone'] ?? 'phone'}}">
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_special_needs'] ?? 'Special Needs'}}</label>
		                                    <select class="form-control icon_control dropdown_control" name="stu_SpecialNeed">
		                                        <option value="Yes">{{$translations['gn_yes'] ?? 'Yes'}}</option>
		                                        <option value="No">{{$translations['gn_no'] ?? 'No'}}</option>
		                                    </select>
		                                </div>
		                                <div class="form-group">
		                                    <label>{{$translations['gn_notes'] ?? 'Notes'}}</label>
		                                    <input type="text" name="stu_Notes" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_note'] ?? 'Note'}}">
		                                </div>
		                                
		                            </div>
		                        <div class="text-center">
	                            	<button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
	                                <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="employee/students" href="{{url('/employee/students')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
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