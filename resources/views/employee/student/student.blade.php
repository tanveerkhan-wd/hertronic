@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_student'] ?? 'Student')
@section('script', url('public/js/dashboard/student.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                @if($logged_user->type=='MinistryAdmin')
                    <h2 class="title">{{$translations['sidebar_nav_view_student'] ?? 'Students'}} </h2>
                @else
                    <h2 class="title"><span>@if(Request::is('employee/students')){{$translations['sidebar_nav_user_management'] ?? 'User Management'}} @else {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}} @endif > </span>{{$translations['sidebar_nav_students'] ?? 'Students'}}</h2>
                @endif
            </div>   
            <div class="col-md-4 mb-3">
                <input type="text" id="search_student" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>  
            <div class="col-md-4 text-md-right mb-3">
                <div class="row">
                    
                </div>
            </div> 
            <div class="col-md-2 col-6 mb-3">
                
            </div>
            <div class="col-md-2 col-6 mb-3">
                @if(Request::is('employee/students'))
                <a><button class="theme_btn small_btn" data-toggle="modal" data-target="#add_new">{{$translations['gn_add_new'] ?? 'Add New'}}</button></a>
                @endif
            </div>
        </div>
        @if($logged_user->type == 'HertronicAdmin' || $logged_user->type=='MinistryAdmin')
            <input type="hidden" id="is_HSA">
        @endif

        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="student_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>{{$translations['gn_student_id'] ?? 'Student Id'}}</th>
                                    <th>{{$translations['gn_student_name'] ?? 'Student Name'}}</th>
                                    <th>{{$translations['gn_place_of_birth'] ?? 'Place of birth'}}</th>
                                    <th>{{$translations['gn_gender'] ?? 'Gender'}}</th>
                                    <th>{{$translations['ln_address'] ?? 'Address'}}</th>
                                    <th><div class="action">{{$translations['gn_actions'] ?? 'Actions'}}</div></th>
                                </tr>
                            </thead>
                        </table>
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">{{$translations['gn_student'] ?? 'Student'}}</h5>
                            
                            <div class="text-center modal_btn">
                                <a class="ajax_request no_sidebar_active" data-slug="employee/addStudent" href="{{url('employee/addStudent')}}">
                                    <button type="button" data-dismiss="modal" class="theme_btn">{{$translations['gn_add_new_student'] ?? 'Add New Student'}}</button>
                                </a>

                                <p class="mt-3 mb-3">{{$translations['gn_or'] ?? 'OR'}}</p>
                                <a class="ajax_request no_sidebar_active" data-slug="employee/enrollStudents" href="{{url('/employee/enrollStudents')}}"><button type="button" data-dismiss="modal" class="theme_btn">{{$translations['gn_enroll_student'] ?? 'Enroll Student'}}</button></a>
                            </div>
                            <div class="text-center mt-3">
                                <span><small> ( {{$translations['gn_enroll_student_note'] ?? 'If the student is already registered with system than you can Enroll with your school'}} )</small></span>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
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
<!-- End Content Body -->
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
@endsection

@push('datatable-scripts')
<!-- Include datatable Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/student.js') }}"></script>
@endpush