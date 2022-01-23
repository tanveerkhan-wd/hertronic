@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_employees'] ?? 'Employees')
@section('script', url('public/js/dashboard/engage_employee.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
               <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/employees" href="{{url('/employee/employees')}}"><span>{{$translations['sidebar_nav_employees'] ?? 'Employees'}} > </span></a> {{$translations['gn_engagement'] ?? 'Engagement'}}</h2>
            </div> 
        </div>
        <input type="hidden" id="teacher_txt" value="{{$translations['gn_teacher'] ?? 'Teacher'}}">
        <input type="hidden" id="principal_txt" value="{{$translations['gn_principal'] ?? 'Principal'}}">
        <input type="hidden" id="school_coordinator_txt" value="{{$translations['gn_school_coordinator'] ?? 'School Coordinator'}}">
        <input type="hidden" id="emp_sel_valid_txt" value="{{$translations['msg_emp_sel_exist'] ?? 'An employee is already selected'}}">
        <input type="hidden" id="emp_sel_txt" value="{{$translations['msg_sel_emp'] ?? 'Please select an employee'}}">
        <div class="col-md-12">
            <div class="white_box p-5 pl-3 pr-3">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="">
                            <div class="form-group">
                                <label>{{$translations['gn_search_employees'] ?? 'Search Employees'}}</label>
                                <input type="text" id="search_employee" class="form-control icon_control search_control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_name'] ?? 'Name'}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <label class="blue_label">{{$translations['gn_employee_type'] ?? 'Employee Type'}}</label>
                        <select class="form-control without_border icon_control dropdown_control" id="employee_types">
                            <option value="" selected>Select</option>
                            @forelse($employeeType as $empTypVal)
                                <option value="{{ $empTypVal->epty_Name }}">@if($empTypVal->epty_Name=='Principal') {{ $translations['gn_principal'] ?? 'Principal' }} @elseif($empTypVal->epty_Name=='Teacher') {{ $translations['gn_teacher'] ?? 'Teacher' }} @endif</option>
                            @empty
                                <option >No Data Found</option>
                            @endforelse
                        </select>
                    </div>
                    <input type="hidden" id="emp_not_engaged" value="{{$translations['gn_not_engaged'] ?? 'Not Engaged'}}">
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="blue_label">{{$translations['gn_engagement_type'] ?? 'Engagement Type'}}</label>
                            <select class="form-control without_border icon_control dropdown_control" id="employee_eng_types">
                                <option value="" selected>Select</option>
                                <option value="1">{{$translations['gn_engaged'] ?? 'Engaged'}}</option>
                                <option value="2">{{$translations['gn_not_engaged'] ?? 'Not Engaged'}}</option>
                            </select>  
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive mt-2 main_table">
                            <table id="eng_emp_listing" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>{{$translations['gn_employee'] ?? 'Employee'}} ID</th>
                                        <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                                        <th>{{$translations['gn_email'] ?? 'Email'}}</th>
                                        <th>{{$translations['gn_employee_type'] ?? 'Employee Type'}}</th>
                                        <th>{{$translations['gn_status'] ?? 'Status'}}</th>
                                        <th>{{$translations['gn_action'] ?? 'Action'}}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-12 sel_emp_div" style="display: none;">
                            <p class="mt-2"><strong>{{$translations['gn_employee'] ?? 'Employee'}}</strong></p>
                            <div class="table-responsive mt-2">
                                <table class="color_table sel_emp_table">
                                    <tr>
                                        <th width="10%">Sr. No</th>
                                        <th width="25%">{{$translations['gn_employee'] ?? 'Employee'}} ID</th>
                                        <th width="20%">{{$translations['gn_name'] ?? 'Name'}}</th>
                    <!--                     <th width="20%">{{$translations['gn_designation'] ?? 'Designation'}}</th> -->
                                        <th width="30%">{{$translations['gn_action'] ?? 'Action'}}</th>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <form name="engage-emp-form">
                            <div class="profile_info_container">
                                <input type="hidden" id="eid" name="eid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="profile_inner_title">{{$translations['gn_engagement_details'] ?? 'Details for Engagement'}}</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_date_of_engagement'] ?? 'Date of Engagement'}} *</label>
                                            <input type="text" id="start_date" name="start_date" class="form-control icon_control date_control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} </label>
                                            <input type="text" id="end_date" name="end_date" class="form-control icon_control date_control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_week_hourly_rate'] ?? 'Week Hourly Rate'}} *</label>
                                            <input type="text" id="een_WeeklyHoursRate" name="een_WeeklyHoursRate" class="form-control">
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
                                            <label>{{$translations['gn_employee_type'] ?? 'Employee Type'}} *</label>
                                            <select id="fkEenEpty" name="fkEenEpty" class="form-control icon_control dropdown_control">
                                                <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                @foreach($EmployeeTypes as $k => $v)
                                                  <option value="{{$v->pkEpty}}"> @if($v->epty_Name=='Principal') {{ $translations['gn_principal'] ?? 'Principal' }} @elseif($v->epty_Name=='Teacher') {{ $translations['gn_teacher'] ?? 'Teacher' }} @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{$translations['gn_note'] ?? 'Note'}} </label>
                                            <input type="text" id="een_notes" name="een_notes" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="card">
                                      <div class="card-body">
                                        <b>{{$translations['gn_note'] ?? 'Note'}}:</b> {{$translations['gn_end_date_note'] ?? 'Only enter "Date of Engagement End" date field if you wish to inactive the employee'}}
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="Submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                    <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="employee/employees" href="{{url('/employee/employees')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="text-center">
                            <button type="Submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                            <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="employee/employees" href="{{url('/employee/employees')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
                        </div>
                    </div> -->
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
<script type="text/javascript" src="{{ url('public/js/dashboard/engage_employee.js') }}"></script>
@endpush
            