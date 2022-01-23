@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_sub_admins'] ?? 'Sub Admins')
@section('script', url('public/js/dashboard/school_sub_admin.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span>{{$translations['sidebar_nav_admin_staff'] ?? 'Admin Staff'}}</h2>
            </div>   
            <div class="col-md-4 mb-3">
                <input type="text" id="search_sub_admin" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>
            <div class="col-md-3 text-md-right mb-3">
                <div class="row">
                    <div class="col-4 text-right pt-1 p-0">
                        <label class="blue_label">{{$translations['gn_start_date'] ?? 'Start Date'}}</label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="start_date" class="form-control datepicker date_control icon_control">
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-md-right mb-3">
                <div class="row">
                    <div class="col-4 text-right pt-1 p-0">
                        <label class="blue_label">{{$translations['gn_end_date'] ?? 'End Date'}}</label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="end_date" class="form-control datepicker date_control icon_control">
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4 text-md-right mb-3">
                <div class="row">
                    <div class="col-6 text-right pr-0 pt-1">
                        <label class="blue_label">{{$translations['gn_export'] ?? 'Export'}}</label>
                    </div>
                    <div class="col-6">
                        <select class="form-control without_border icon_control dropdown_control">
                            <option selected>PDF</option>
                            <option>PDF</option>
                            <option>PDF</option>
                        </select>
                    </div>
                </div>
            </div> 
            <div class="col-md-2 col-6 mb-3">
                <a href="#"></a><button class="theme_btn full_width small_btn">{{$translations['gn_export'] ?? 'Export'}}</button>
            </div> -->
            <div class="col-md-2 col-6 mb-3">
                <a><button class="theme_btn small_btn" data-toggle="modal" data-target="#add_new">{{$translations['gn_add_new'] ?? 'Add New'}}</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="sub_admin_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>UID</th>
                                    <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                                    <th>{{$translations['gn_email'] ?? 'Email'}}</th>
                                    <th>{{$translations['gn_start_date'] ?? 'Start Date'}}</th>
                                    <th>{{$translations['gn_end_date'] ?? 'End Date'}}</th>
                                    <th>{{$translations['gn_status'] ?? 'Status'}}</th>
                                    <th><div class="action">{{$translations['gn_actions'] ?? 'Actions'}}</div></th>
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
                                <h5 class="modal-title" id="exampleModalCenterTitle">Sub Admin</h5>
                                
                                <div class="text-center modal_btn">
                                    <a class="ajax_request no_sidebar_active" data-slug="employee/addSubAdmin" href="{{url('/employee/addSubAdmin')}}"><button type="button" data-dismiss="modal" class="theme_btn">{{$translations['gn_add_new'] ?? 'Add New'}} {{$translations['gn_admin_staff'] ?? 'Admin Staff'}}</button></a>
                                    <p class="mt-3 mb-3">{{$translations['gn_or'] ?? 'OR'}}</p>
                                    <a href="javascript:void(0)"><button type="button" data-dismiss="modal" class="theme_btn">{{$translations['gn_existing_user'] ?? 'Existing User'}}</button></a>
                                </div>
                                <div class="text-center mt-3">
                                    <span><small> ({{$translations['gn_existing_user_msg'] ?? 'If you want to give an access to existing user then please select existing user'}})</small></span>
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
<script type="text/javascript" src="{{ url('public/js/dashboard/school_sub_admin.js') }}"></script>
@endpush