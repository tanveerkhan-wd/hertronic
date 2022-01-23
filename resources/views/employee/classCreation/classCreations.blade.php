@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_class_creation'] ?? 'Class Creation')
@section('script', url('public/js/dashboard/class_creation.js'))
@section('content')	
<!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
        <input type="hidden" id="current_language" value="{{ $current_language }}">
        <div class="row">
			<div class="col-12 mb-3">
               <h2 class="title"><span>{{$translations['sidebar_nav_organization'] ?? 'Organization'}} > </span> {{$translations['sidebar_nav_class_creation'] ?? 'Class Creation'}}</h2>
            </div>
            <div class="col-md-4 mb-3">
                <input type="text" id="search_class_creations" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>
            <div class="col-md-3 text-md-right mb-3">
                <div class="row">
                    <div class="col-6 text-right pr-0 pt-1">
                        <label class="blue_label">{{$translations['gn_grade'] ?? 'Grade'}}</label>
                    </div>
                    <div class="col-6">
                        <select class="form-control without_border icon_control dropdown_control" id="searchGrade">
                            <option value="" selected>Select</option>
                            @forelse($searchGrade as $gs)
                                <option value="{{$gs['gra_GradeName']}}">{{$gs['gra_GradeName']}}</option>
                            @empty
                                <option>No Data Found</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-md-right mb-3">
                <div class="row">
                    <div class="col-6 text-right pr-0 pt-1">
                        <label class="blue_label">{{$translations['gn_school_year'] ?? 'School Year'}}</label>
                    </div>
                    <div class="col-6">
                        <select class="form-control without_border icon_control dropdown_control" id="search_sch_year">
                            <option value="" selected>Select</option>
                            @forelse($searchSchYear as $sy)
                                <option value="{{$sy['sye_NameNumeric']}}">{{$sy['sye_NameNumeric']}}</option>
                            @empty
                                <option >No Data Found</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </div> 
            <div class="col-md-2 col-6 mb-3">
                <a><button class="theme_btn small_btn ajax_request no_sidebar_active" data-slug="employee/classCreation" href="{{url('/employee/classCreation')}}">{{$translations['gn_add_new'] ?? 'Add New'}}</button></a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="class_creation_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>{{$translations['gn_class'] ?? 'Class'}}</th>
                                    <th>{{$translations['gn_grade'] ?? 'Grade'}}</th>
                                    <th>{{$translations['gn_no_of_students'] ?? 'No. of Students'}}</th>
                                    <th>{{$translations['gn_class_year'] ?? 'Class Year'}}</th>
                                    <th>{{$translations['gn_homeroom_teacher'] ?? 'Homeroom Teacher'}}</th>
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

</div>
@endsection

@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/class_creation.js') }}"></script>
@endpush