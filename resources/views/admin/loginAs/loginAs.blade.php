@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_login_as'] ?? 'Login As')
@section('script', url('public/js/dashboard/login_as.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span>{{$translations['sidebar_nav_login_as'] ?? 'Login as'}}</h2>
            </div>   
            <div class="col-md-4 mb-3">
                <input type="text" id="search_login_as" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>  
            <div class="col-md-8 text-md-right mb-3">
                <div class="row">
                    <div class="col-8">
                        <label class="blue_label">{{$translations['gn_roles'] ?? 'Roles'}}</label>
                    </div>
                    <div class="col-4">
                        <select id="role_type" class="form-control without_border icon_control dropdown_control">
                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                            <option value="MinistryAdmin">{{$translations['gn_ministry_super_admin'] ?? 'Ministry Super Admin'}}</option>
                            <option value="SchoolCoordinator">{{$translations['gn_school_coordinator'] ?? 'School Coordinator'}}</option>
                            <option value="Teacher">{{$translations['gn_teacher'] ?? 'Teacher'}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="login_as_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>UID</th>
                                    <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                                    <th>{{$translations['gn_roles'] ?? 'Roles'}}</th>
                                    <th>{{$translations['ln_email'] ?? 'Email'}}</th>
                                    <th>{{$translations['gn_status'] ?? 'Status'}}</th>
                                    <th><div class="action">{{$translations['sidebar_nav_login_as'] ?? 'Login as'}}</div></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="school_coordinator_txt" value="{{$translations['gn_school_coordinator'] ?? 'School Coordinator'}}">
<input type="hidden" id="teacher_txt" value="{{$translations['gn_teacher'] ?? 'Teacher'}}">
<input type="hidden" id="msa_txt" value="{{$translations['gn_ministry_super_admin'] ?? 'Ministry Super Admin'}}">

<div class="theme_modal modal fade" id="login_prompt" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <label>{{$translations['gn_delete_prompt'] ?? 'Are you sure you want to login ?'}}</label>
                                <input type="hidden" id="did">
                            </div>
                            <div class="text-center modal_btn ">
                                <button style="display: none;" class="theme_btn show_delete_modal full_width small_btn" data-toggle="modal" data-target="#delete_prompt">{{$translations['sidebar_nav_languages'] ?? 'Login as'}}</button>
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
<!-- End Content Body -->
@endsection

@push('datatable-scripts')
<!-- Include datatable Page JS -->
<script type="text/javascript" id="datatable_script" src="{{ url('public/js/dashboard/login_as.js') }}"></script>
@endpush
