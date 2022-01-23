@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_enroll_students'] ?? 'Enroll Students')
@section('script', url('public/js/dashboard/enroll_students.js'))
@section('content')

<div class="section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 mb-3">
				<h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/students" href="{{url('/employee/students')}}"><span>{{$translations['sidebar_nav_students'] ?? 'Students'}} > </span></a> {{$translations['gn_enroll'] ?? 'Enroll'}}</h2>
            </div> 
		</div>
        <input type="hidden" id="student_sel_valid_txt" value="{{$translations['msg_student_sel_exist'] ?? 'A student is already selected'}}">
        <input type="hidden" id="student_sel_txt" value="{{$translations['msg_sel_student'] ?? 'Please select a student'}}">
		<div class="col-md-12">
            <div class="white_box p-5 pl-3 pr-3">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="">
                            <div class="form-group">
                            	<label>{{$translations['gn_search_students'] ?? 'Search Students'}}</label>
                				<input type="text" id="search_students" class="form-control icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
                				
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                    	<div class="table-responsive mt-2 main_table">
                            <table id="enroll_stu_listing" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>{{$translations['gn_student_id'] ?? 'Student ID'}} </th>
                                        <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                                        <th>{{$translations['gn_surname'] ?? 'Surname'}}</th>
                                        <th>{{$translations['gn_action'] ?? 'Action'}}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-12 sel_emp_div" style="display: none;">
                            <p class="mt-2"><strong>{{$translations['gn_student'] ?? 'Student'}}</strong></p>
                            <div class="table-responsive mt-2">
                                <table class="color_table sel_emp_table">
                                    <tr>
                                        <th width="10%">Sr. No</th>
                                        <th width="25%">{{$translations['gn_student_id'] ?? 'Student ID'}}</th>
                                        <th width="20%">{{$translations['gn_name'] ?? 'Name'}}</th>
                                        <th width="15%">{{$translations['gn_surname'] ?? 'Surname'}}</th>
                                        <th width="30%">{{$translations['gn_action'] ?? 'Action'}}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <form name="enroll-stu-form">
                        	<input type="hidden" name="select_student" id="students_id">
                            <div class="profile_info_container">
                                <div class="row">
                                    <div class="col-md-12">
                                    	<h6 class="profile_inner_title">{{$translations['gn_details_enrollment'] ?? 'Details for Enrollment'}}</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_date_of_enrollment'] ?? 'Date of Enrollment'}} *</label>
                                            <input type="text" id="ste_EnrollmentDate" name="ste_EnrollmentDate" class="form-control icon_control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_main_book_number'] ?? 'Main Book No.'}} *</label>
                                            <select class="form-control icon_control dropdown_control" name="fkSteMbo" id="fkSteMbo">
                                                <option selected value="">Select</option>
                                                @forelse($mainBooks as $mbvalue)
                                                    <option value="{{$mbvalue->pkMbo }}">{{ $mbvalue->mbo_MainBookNameRoman }}</option>
                                                @empty
                                                    <option selected>No data found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_order_no'] ?? 'Order No.'}} *</label>
                                            <input type="number" name="ste_MainBookOrderNumber" id="ste_MainBookOrderNumber" class="form-control">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_school_year'] ?? 'School Year'}} *</label>
                                            <select class="form-control icon_control dropdown_control" name="fkSteSye" id="fkSteSye">
                                                <option value="" selected>Select</option>
                                                @forelse($schoolYear as $yeValue)
                                                    <option value="{{$yeValue->pkSye }}">{{ $yeValue->sye_NameNumeric }}</option>
                                                @empty
                                                    <option selected>No data found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_education_program'] ?? 'Education Program'}} *</label>
                                            <select class="form-control icon_control dropdown_control" name="fkSteEdp" id="fkSteEdp">
                                                <option value="" selected>Select</option>
                                                @forelse($educationProg as $mbvalue)
                                                    <option value="{{$mbvalue->pkEdp }}">{{ $mbvalue->edp_Name }}</option>
                                                @empty
                                                    <option selected>No data found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="msg_select_education_plan" value="{{ $translations['msg_select_education_plan'] ?? 'Please select education plan' }}">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_education_plan'] ?? 'Education Plan'}} * 
                                                <button type="button" class="btn-darkinfo" onclick="viewEduPlan()">  i </button>
                                            </label>
                                            <select class="form-control icon_control dropdown_control" name="fkSteEpl" id="fkSteEpl">
                                                <option value="" selected>Select</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_grade'] ?? 'Grade'}} *</label>
                                            <select class="form-control icon_control dropdown_control" name="fkSteGra" id="fkSteGra">
                                            	<option selected value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_enroll_based_on'] ?? 'Enroll Based On'}} </label>
                                            <textarea class="form-control icon_control" name="ste_EnrollBasedOn" id="ste_EnrollBasedOn"> </textarea>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_ste_Reason'] ?? 'Reason'}} </label>
                                            <textarea class="form-control icon_control" name="ste_Reason" id="ste_Reason"> </textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_finishing_date'] ?? 'Finishing Date'}} </label>
                                            <input type="text" id="ste_FinishingDate" name="ste_FinishingDate" class="form-control icon_control datepicker">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_breaking_date'] ?? 'Breaking Date'}} </label>
                                            <input type="text" id="ste_BreakingDate" name="ste_BreakingDate" class="form-control icon_control datepicker">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_expelling_date'] ?? 'Expelling Date'}} </label>
                                            <input type="text" id="ste_ExpellingDate" name="ste_ExpellingDate" class="form-control icon_control datepicker">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="text-center">

                    					<button type="Submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                    					<a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="employee/students" href="{{url('/employee/students')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>

                    					</div>
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


<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
@endsection
@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/enroll_students.js') }}"></script>
@endpush