@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_colleges'] ?? 'Colleges')
@section('script', url('public/js/dashboard/college.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 col-md-5 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_masters'] ?? 'Masters'}} > </span>{{$translations['sidebar_nav_colleges'] ?? 'Colleges'}}</h2>
            </div>   
            <div class="col-md-4 mb-3 offset-md-3">
                <input type="text" id="search_college" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>  
            <div class="col-md-4 col-lg-3 text-md-right mb-3 ">
               <div class="row">
                    <div class="col-5 text-right p-0 pt-1">
                        <label class="blue_label">{{$translations['gn_ownership_type'] ?? 'Ownership Type'}}</label>
                    </div>
                    <div class="col-7 pr-0">
                        <select id="ownership_filter" class="form-control without_border icon_control dropdown_control">
                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                            @foreach($ownership as $k => $v)
                                <option value="{{$v->pkOty}}">{{$v->oty_OwnershipTypeName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3 text-md-right mb-3">
                <div class="row">
                    <div class="col-4 text-right pr-0 pt-1">
                        <label class="blue_label">{{$translations['gn_university'] ?? 'University'}}</label>
                    </div>
                    <div class="col-8">
                        <select id="university_filter" class="form-control without_border icon_control dropdown_control">
                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                            @foreach($university as $k =>$v)
                                <option value="{{$v->pkUni}}">{{$v->uni_UniversityName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2 text-md-right mb-3">
                <div class="row">
                    <div class="col-4 text-right pr-0 pt-1">
                        <label class="blue_label">{{$translations['gn_country'] ?? 'Country'}}</label>
                    </div>
                    <div class="col-8">
                        <select id="country_filter" class="form-control without_border icon_control dropdown_control">
                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                            @foreach($country as $k =>$v)
                                <option value="{{$v->pkCny}}">{{$v->cny_CountryName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2 text-md-right mb-3">
                <div class="row">
                    <div class="col-4 text-right pr-0 pt-1">
                        <label class="blue_label">{{$translations['gn_founded'] ?? 'Founded'}}</label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="year_filter" class="form-control datepicker-year  date_control icon_control" placeholder="Year">
                    </div>
                </div>
            </div> 
            <div class="col-md-4 col-lg-2 col-6 mb-3">
                <a><button class="theme_btn show_modal full_width small_btn" data-toggle="modal" data-target="#add_new">{{$translations['gn_add_new'] ?? 'Add New'}}</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="colleges_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>UID</th>
                                    <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                                    <th>{{$translations['gn_university'] ?? 'University'}}</th>
                                    <th>{{$translations['gn_country'] ?? 'Country'}}</th>
                                    <th>{{$translations['gn_started_year'] ?? 'Started Year'}}</th>
                                    <th>{{$translations['gn_ownership_type'] ?? 'Ownership Type'}}</th>
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
                <form name="add-college-form">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <h5 class="modal-title" id="exampleModalCenterTitle">{{$translations['sidebar_nav_colleges'] ?? 'Colleges'}}</h5>
                            <div class="text-center">
                                <div class="profile_box">
                                    <div class="profile_pic">
                                        <img id="college_img" src="{{ url('public/images/user.png') }}">
                                        <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
                                    </div>
                                </div>
                                <div  class="upload_pic_link">
                                    <a href="javascript:void(0)">
                                    {{$translations['gn_upload_photo'] ?? 'Upload Photo'}}<input type="file" id="upload_profile" name="upload_profile"></a>
                                    
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label>{{$translations['gn_name'] ?? 'Name'}} *</label>
                                <input type="text" name="col_CollegeName" id="col_CollegeName" class="form-control icon_control datepicker">
                            </div> --}}
                            <input type="hidden" id="pkCol">
                            @foreach($languages as $k => $v)
                                <div class="form-group">
                                    <label>{{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
                                    <input type="text" name="col_CollegeName_{{$v->language_key}}" id="col_CollegeName_{{$v->language_key}}" class="form-control force_require icon_control" required="">
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label>{{$translations['gn_founded'] ?? 'Founded'}} *</label>
                                <input type="text" name="col_YearStartedFounded" id="col_YearStartedFounded" class="form-control datepicker-year  date_control icon_control">
                               
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_country'] ?? 'Country'}} *</label>
                                <select class="form-control icon_control dropdown_control" name="fkColCny" id="fkColCny">
                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                    @foreach($country as $k =>$v)
                                        <option value="{{$v->pkCny}}">{{$v->cny_CountryName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_ownership_type'] ?? 'Ownership Type'}} *</label>
                                <select class="form-control icon_control dropdown_control" name="fkColOty" id="fkColOty">
                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                    @foreach($ownership as $k => $v)
                                        <option value="{{$v->pkOty}}">{{$v->oty_OwnershipTypeName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_belongs_to_university'] ?? 'Belongs to University'}} : *</label>
                                <div class="form-check custom_check_div">
                                    <input class="form-check-input" type="radio" name="col_BelongsToUniversity" id="Customer" value="Yes">
                                    <label class="custom_radio"></label>
                                    <label class="form-check-label" for="Customer">{{$translations['gn_yes'] ?? 'Yes'}}</label>
                                </div>
                                <div class="form-check custom_check_div">
                                    <input class="form-check-input" type="radio" name="col_BelongsToUniversity" checked="checked" id="Customer" value="No">
                                    <label class="custom_radio"></label>
                                    <label class="form-check-label" for="Customer">{{$translations['gn_no'] ?? 'No'}}</label>
                                </div>
                            </div>
                            <div class="form-group university_option" style="display: none;">
                                <label>{{$translations['gn_university'] ?? 'University'}} *</label>
                                <select class="form-control icon_control dropdown_control" name="fkColUni" id="fkColUni">
                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                    @foreach($university as $k =>$v)
                                        <option value="{{$v->pkUni}}">{{$v->uni_UniversityName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                <input type="text" name="col_Notes" id="col_Notes" class="form-control icon_control">
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
<script type="text/javascript" src="{{ url('public/js/dashboard/college.js') }}"></script>
@endpush
