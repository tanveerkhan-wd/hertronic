@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_student'] ?? 'Student')
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                @if($logged_user->type=='MinistryAdmin')
                    <h2 class="title"><a class="ajax_request no_sidebar_active" data-slug="admin/students" href="{{url('admin/students')}}"> <span>{{$translations['sidebar_nav_view_student'] ?? 'Students'}} > </span></a> {{$translations['gn_details'] ?? 'Details'}}</h2>
                @else
                    <h2 class="title"><span>@if($logged_user->type != 'HertronicAdmin'){{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/students" href="{{url('employee/students')}}">@else {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}} > </span><a class="ajax_request no_sidebar_active" data-slug="admin/students" href="{{url('admin/students')}}">@endif <span>{{$translations['sidebar_nav_view_student'] ?? 'Students'}} > </span></a> {{$translations['gn_details'] ?? 'Details'}}</h2>
                @endif
            </div>   
            @if($logged_user->type == 'HertronicAdmin' || $logged_user->type=='MinistryAdmin')
                <input type="hidden" id="is_HSA">
            @endif
            <div class="col-12">
                <div class="white_box pt-5 pb-5">
                    <div class="container-fliid">
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10">
                                <div class="text-center">
                                    <div class="profile_box">
                                        <div class="profile_pic">
                                            <img src="@if(!empty($mdata->stu_PicturePath)) {{url('public/images/students/')}}/{{$mdata->stu_PicturePath}} @else {{ url('public/images/user.png') }}@endif">
                                        </div>
                                    </div>
                                    <h5 class="profile_name">{{$mdata->stu_stu_StudentName}}</h5>
                                </div>
                                <div class="profile_info_container">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_student_name'] ?? 'Student Name'}}:</p>
                                                <p class="value">{{$mdata->stu_StudentName}} {{$mdata->gn_stu_StudentSurname}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_temp_citizen_id'] ?? 'Temp. Citizen ID'}} :</p>
                                                <p class="value">{{$mdata->stu_TempCitizenId}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_student_id'] ?? 'Student ID'}} :</p>
                                                <p class="value">{{$mdata->stu_StudentID}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_gender'] ?? 'Gender'}} :</p>
                                                <p class="value">{{$mdata->stu_StudentGender}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_date_Of_birth'] ?? 'Date Of Birth'}} :</p>
                                                <p class="value">@if(!empty($mdata->stu_DateOfBirth)) {{date('m/d/Y',strtotime($mdata->stu_DateOfBirth)) }} @endif</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_place_of_birth'] ?? 'Place Of Birth'}} :</p>
                                                <p class="value">{{$mdata->stu_PlaceOfBirth}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_address'] ?? 'Address'}} :</p>
                                                <p class="value">{{$mdata->stu_Address}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_municipality'] ?? 'Municipality'}} :</p>
                                                <p class="value">{{$mdata->municipality->mun_MunicipalityName_en ?? ''}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_nationality'] ?? 'Nationality'}} :</p>
                                                <p class="value">{{$mdata->nationality->nat_NationalityName_en ?? ''}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_citizenship'] ?? 'Citizenship'}} :</p>
                                                <p class="value">{{$mdata->citizenship->ctz_CitizenshipName_en ?? ''}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_religions'] ?? 'Religions'}} :</p>
                                                <p class="value">{{$mdata->riligeion->rel_ReligionName_en ?? ''}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_student_email'] ?? 'Student Email'}} :</p>
                                                <p class="value">{{$mdata->email}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_distance_in_kilometers'] ?? 'Distance In Kilometers'}} :</p>
                                                <p class="value">{{$mdata->stu_DistanceInKilometers}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_mobile_phone_number'] ?? 'Mobile Phone Number'}} :</p>
                                                <p class="value">{{$mdata->stu_MobilePhoneNumber}}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_phone'] ?? 'Phone'}} :</p>
                                                <p class="value">{{$mdata->stu_PhoneNumber}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_postal_code'] ?? 'Postal Code'}} :</p>
                                                <p class="value">{{$mdata->postalCode->pof_PostOfficeNumber ?? ''}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_father_name'] ?? 'Father’s Name'}} :</p>
                                                <p class="value">{{$mdata->stu_FatherName}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_mother_name'] ?? 'Mother Name'}} :</p>
                                                <p class="value">{{$mdata->stu_MotherName}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_father_job'] ?? 'Father’s Job'}} :</p>
                                                <p class="value">{{$mdata->jawFather->jaw_Name_en ?? ''}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_parent_email'] ?? 'Parent’s Email'}} :</p>
                                                <p class="value">{{$mdata->stu_ParentsEmail}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_Parent_phone_no'] ?? 'Parent’s Phone No.'}} :</p>
                                                <p class="value">{{$mdata->stu_ParentsEmail}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_special_needs'] ?? 'Special Needs'}} :</p>
                                                <p class="value">{{$mdata->stu_SpecialNeed}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <p class="label">{{$translations['gn_notes'] ?? 'Notes'}} :</p>
                                                <p class="value">{{$mdata->stu_Notes}}</p>
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

            