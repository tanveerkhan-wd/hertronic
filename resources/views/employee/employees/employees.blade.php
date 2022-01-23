@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_employees'] ?? 'Employees')
@section('script', url('public/js/dashboard/employee.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            @if($logged_user->type=='HertronicAdmin' || $logged_user->type=='MinistryAdmin') <input type="hidden" id="is_admin" value="1"> @endif
            <div class="col-12 mb-3">
            @if($logged_user->type=='MinistryAdmin')
                <h2 class="title">{{$translations['sidebar_nav_teachers'] ?? 'Teachers'}}</h2>
            @else
                <h2 class="title"><span>@if(Request::is('employee/employees')){{$translations['sidebar_nav_user_management'] ?? 'User Management'}} @else {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}} @endif > </span>{{$translations['sidebar_nav_employees'] ?? 'Employees'}}
                </h2>
            @endif
            </div>   
            <div class="col-md-4 mb-3">
                <input type="text" id="search_teacher" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>
            @if(Request::is('admin/employees'))
            <div class="col-md-2 col-6 mb-3">
                
            </div>
            @endif
            <div class="col-md-2 col-6 mb-3">
                
            </div>
            <div class="col-md-4 text-md-right mb-3">
                <div class="row">
                    <div class="col-6 text-right pr-0 pt-1">
                        <label class="blue_label">{{$translations['gn_employee_type'] ?? 'Employee Type'}}</label>
                    </div>
                    <div class="col-6">
                        <select class="form-control without_border icon_control dropdown_control" id="employee_types">
                            <option value="" selected>Select</option>
                            @forelse($employeeType as $empTypVal)
                                <option value="{{ $empTypVal->epty_Name }}">@if($empTypVal->epty_Name=='Principal') {{ $translations['gn_principal'] ?? 'Principal' }} @elseif($empTypVal->epty_Name=='Teacher') {{ $translations['gn_teacher'] ?? 'Teacher' }} @elseif($empTypVal->epty_Name=='SchoolCoordinator') {{ $translations['gn_school_coordinator'] ?? 'SchoolCoordinator' }} @endif</option>
                            @empty
                                <option >No Data Found</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </div> 
            @if(Request::is('employee/employees'))
            <div class="col-md-2 col-6 mb-3">
                <a><button class="theme_btn small_btn" data-toggle="modal" data-target="#add_new">{{$translations['gn_add_new'] ?? 'Add New'}}</button></a>
            </div>
            @endif
        </div>
        <input type="hidden" id="emp_not_engaged" value="{{$translations['gn_not_engaged'] ?? 'Not Engaged'}}">
        <input type="hidden" id="teacher_txt" value="{{$translations['gn_teacher'] ?? 'Teacher'}}">
        <input type="hidden" id="principal_txt" value="{{$translations['gn_principal'] ?? 'Principal'}}">
        <input type="hidden" id="school_coordinator_txt" value="{{$translations['gn_school_coordinator'] ?? 'School Coordinator'}}">
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="teacher_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>UID</th>
                                    <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                                    <th>{{$translations['gn_email'] ?? 'Email'}}</th>
                                    <th>{{$translations['gn_employee_type'] ?? 'Employee Type'}}</th>
                                    {{-- <th>{{$translations['gn_engagement_type'] ?? 'Engagment Type'}}</th> --}}
                                    <th>{{$translations['gn_status'] ?? 'Status'}}</th>
                                    <th>{{$translations['gn_actions'] ?? 'Actions'}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div>


    <div class="theme_modal modal fade" id="delete_prompt" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{url('public/images/ic_close_bg.png')}}" class="modal_top_bg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{url('public/images/ic_close_circle_white.png')}}">
                    </button>
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10">
                                <h5 class="modal-title" id="exampleModalCenterTitle">{{$translations['gn_delete'] ?? 'Delete'}}</h5>
                                <div class="form-group text-center">
                                    <label>{{$translations['gn_delete_prompt'] ?? 'Are you sure you want to delete'}} ?</label>
                                    <input type="hidden" id="did">
                                </div>
                                <div class="text-center modal_btn ">
                                    <button style="display: none;" class="theme_btn show_delete_modal full_width small_btn" data-toggle="modal" data-target="#delete_prompt">{{$translations['gn_delete'] ?? 'Delete'}}</button>
                                    <button type="button" onclick="confirmDelete()" class="theme_btn">{{$translations['gn_yes'] ?? 'Yes'}}</button>
                                    <button type="button" data-dismiss="modal" class="theme_btn red_btn">{{$translations['gn_no'] ?? 'No'}}</button>
                                </div>
                            </div>
                            <div class="col-lg-1"></div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="theme_modal modal fade" id="add_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{url('public/images/ic_close_bg.png')}}" class="modal_top_bg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{url('public/images/ic_close_circle_white.png')}}">
                    </button>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <h5 class="modal-title" id="exampleModalCenterTitle">{{$translations['gn_employee'] ?? 'Employee'}}</h5>
                            
                            <div class="text-center modal_btn">
                                <a class="ajax_request no_sidebar_active" data-slug="employee/addEmployee" href="{{url('/employee/addEmployee')}}"><button type="button" data-dismiss="modal" class="theme_btn">{{$translations['gn_add_new'] ?? 'Add New'}} {{$translations['gn_employee'] ?? 'Employee'}}</button></a>
                                <p class="mt-3 mb-3">{{$translations['gn_or'] ?? 'OR'}}</p>
                                <a class="ajax_request no_sidebar_active" data-slug="employee/engageEmployee" href="{{url('/employee/engageEmployee')}}"><button type="button" data-dismiss="modal" class="theme_btn">{{$translations['gn_engage_employee'] ?? 'Engage Employee'}}</button></a>
                            </div>
                            <div class="text-center mt-3">
                                <span><small> ({{$translations['gn_engage_employee_note'] ?? 'If the employee is already registered with system than you can Engage with your school'}})</small></span>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Content Body -->
@endsection

@push('datatable-scripts')
<!-- Include datatable Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/employee.js') }}"></script>
@endpush