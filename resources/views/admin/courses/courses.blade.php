@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_courses'] ?? 'Courses')
@section('script', url('public/js/dashboard/course.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>@if(Auth::guard('admin')->user()->type=='MinistryAdmin') {{$translations['sidebar_nav_masters'] ?? 'Masters'}} @else {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}} @endif > </span>{{$translations['sidebar_nav_courses'] ?? 'Courses'}}</h2>
            </div>   
            <div class="col-md-4 mb-3">
                <input type="text" id="search_course" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>  
            <div class="col-md-4 text-md-right mb-3">
                
            </div> 
            <div class="col-md-2 col-6 mb-3">
               
            </div>
            <div class="col-md-2 col-6 mb-3">
                <a><button class="theme_btn show_modal full_width small_btn @if($logged_user->type !='MinistryAdmin') hide_content @endif" data-toggle="modal" data-target="#add_new">{{$translations['gn_add_new'] ?? 'Add New'}}</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="courses_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>UID</th>
                                    <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                                    <th>{{$translations['gn_alternative_name'] ?? 'Alternative Name'}}</th>
                                    <th>{{$translations['gn_notes'] ?? 'Notes'}}</th>
                                    <th><div class="action">{{$translations['gn_actions'] ?? 'Actions'}}</div></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Popup -->
<div class="theme_modal modal fade" id="add_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{url('public/images/ic_close_bg.png')}}" class="modal_top_bg">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{url('public/images/ic_close_circle_white.png')}}">
                </button>
                <form name="add-course-form">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <h5 class="modal-title" id="exampleModalCenterTitle">{{$translations['sidebar_nav_courses'] ?? 'Courses'}}</h5>
                            {{-- <div class="form-group">
                                <label>{{$translations['gn_name'] ?? 'Name'}} *</label>
                                <input type="text" name="crs_CourseName" id="crs_CourseName" class="form-control icon_control">
                            </div> --}}
                            <input type="hidden" id="pkCrs">
                            @foreach($languages as $k => $v)
                                <div class="form-group">
                                    <label>{{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
                                    <input type="text" name="crs_CourseName_{{$v->language_key}}" id="crs_CourseName_{{$v->language_key}}" class="form-control force_require icon_control" required="">
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label>{{$translations['gn_alternative_name'] ?? 'Alternative Name'}}</label>
                                <input type="text" name="crs_CourseAlternativeName" id="crs_CourseAlternativeName" class="form-control icon_control">
                            </div>
                            <div class="form-group">
                                <label>UID</label>
                                <input type="text" name="crs_Uid" id="crs_Uid" class="form-control icon_control">
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_type'] ?? 'Type'}} *</label>
                                <select name="crs_CourseType" id="crs_CourseType" class="form-control icon_control dropdown_control">
                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                    <option value="General">{{$translations['gn_general'] ?? 'General'}}</option>
                                    <option value="Specialization">{{$translations['gn_specialization'] ?? 'Specialization'}}</option>
                                    <option value="DummyOptionalCourse">{{$translations['gn_dummy_optional_course'] ?? 'Dummy Optional Course'}}</option>
                                    <option value="DummyForeignCourse">{{$translations['gn_dummy_foreign_course'] ?? 'Dummy Foreign Course'}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_is_foreign_language'] ?? 'Is it a Foreign Language'}}: *</label>
                                <div class="form-check custom_check_div">
                                    <input class="form-check-input" type="radio" name="crs_IsForeignLanguage" value="Yes">
                                    <label class="custom_radio"></label>
                                    <label class="form-check-label" for="Customer">{{$translations['gn_yes'] ?? 'Yes'}}</label>
                                </div>
                                <div class="form-check custom_check_div">
                                    <input class="form-check-input" type="radio" name="crs_IsForeignLanguage" checked="checked" value="No">
                                    <label class="custom_radio"></label>
                                    <label class="form-check-label" for="Customer">{{$translations['gn_no'] ?? 'No'}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                <input type="text" name="crs_Notes" id="crs_Notes" class="form-control icon_control">
                            </div>
                            <div class="text-center modal_btn ">
                                <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                </form>
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
                                <label>{{$translations['gn_delete_prompt'] ?? 'Are you sure you want to delete ?'}}</label>
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
@endsection

@push('datatable-scripts')
<!-- Include datatable Page JS -->
<script type="text/javascript" id="datatable_script" src="{{ url('public/js/dashboard/course.js') }}"></script>
@endpush
