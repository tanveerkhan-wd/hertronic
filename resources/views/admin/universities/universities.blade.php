@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_universities'] ?? 'Universities')
@section('script', url('public/js/dashboard/university.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 col-md-5 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_masters'] ?? 'Masters'}} > </span>{{$translations['sidebar_nav_universities'] ?? 'Universities'}}</h2>
            </div>   
            <div class="col-md-4 mb-3 offset-md-3">
                <input type="text" id="search_university" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>  
            <div class="col-md-4 text-md-right mb-3">
               <div class="row">
                    <div class="col-5 text-right pt-1 pr-0">
                        <label class="blue_label">{{$translations['gn_ownership_type'] ?? 'Ownership Type'}}</label>
                    </div>
                    <div class="col-7">
                        <select id="ownership_filter" class="form-control without_border icon_control dropdown_control">
                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                            @foreach($ownership as $k => $v)
                                <option value="{{$v->pkOty}}">{{$v->oty_OwnershipTypeName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> 
            <div class="col-md-3 text-md-right mb-3">
                <div class="row">
                    <div class="col-4 text-right pt-1 pr-0">
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
            <div class="col-md-3 text-md-right mb-3">
                <div class="row">
                    <div class="col-4 text-right pt-1 p-0">
                        <label class="blue_label">{{$translations['gn_started_year'] ?? 'Started Year'}}</label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="year_filter" class="form-control datepicker-year date_control icon_control" placeholder="{{$translations['gn_year'] ?? 'Year'}}">
                    </div>
                </div>
            </div> 
            <div class="col-md-2 col-6 mb-3">
                <a><button class="theme_btn show_modal full_width small_btn" data-toggle="modal" data-target="#add_new">{{$translations['gn_add_new'] ?? 'Add New'}}</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="universities_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>UID</th>
                                    <th>{{$translations['gn_name'] ?? 'Name'}}</th>
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
                <form name="add-university-form">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <h5 class="modal-title" id="exampleModalCenterTitle">{{$translations['sidebar_nav_universities'] ?? 'Universities'}}</h5>
                            <div class="text-center">
                                <div class="profile_box">
                                    <div class="profile_pic">
                                        <img id="university_img" src="{{ url('public/images/user.png') }}">
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
                                <input type="text" name="uni_UniversityName" id="uni_UniversityName" class="form-control icon_control datepicker">
                            </div> --}}
                            <input type="hidden" id="pkUni">
                            @foreach($languages as $k => $v)
                                <div class="form-group">
                                    <label>{{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
                                    <input type="text" name="uni_UniversityName_{{$v->language_key}}" id="uni_UniversityName_{{$v->language_key}}" class="form-control force_require icon_control" required="">
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label>{{$translations['gn_started_year'] ?? 'Started Year'}} *</label>
                                <input type="text" name="uni_YearStartedFounded" id="uni_YearStartedFounded" class="form-control datepicker-year  date_control icon_control">
                               
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_country'] ?? 'Country'}} *</label>
                                <select class="form-control icon_control dropdown_control" name="fkUniCny" id="fkUniCny">
                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                    @foreach($country as $k =>$v)
                                        <option value="{{$v->pkCny}}">{{$v->cny_CountryName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_ownership_type'] ?? 'Ownership Type'}} *</label>
                                <select class="form-control icon_control dropdown_control" name="fkUniOty" id="fkUniOty">
                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                    @foreach($ownership as $k => $v)
                                        <option value="{{$v->pkOty}}">{{$v->oty_OwnershipTypeName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                <input type="text" name="uni_Notes" id="uni_Notes" class="form-control icon_control">
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
<script type="text/javascript" src="{{ url('public/js/dashboard/university.js') }}"></script>
@endpush