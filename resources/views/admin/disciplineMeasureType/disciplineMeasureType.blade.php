@section('title','Discipline Measure Type')
@section('script', url('public/js/dashboard/discipline_measure.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_student_masters'] ?? 'Student Masters'}} > </span>{{$translations['sidebar_nav_dmt'] ?? 'Discipline Measure Type'}}</h2>
            </div>   
            <div class="col-md-4 mb-3">
                <input type="text" id="search_disciplineMeasureType" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>  
            <div class="col-md-4 text-md-right mb-3">
                
            </div> 
            <div class="col-md-2 col-6 mb-3">
               
            </div>
            <div class="col-md-2 col-6 mb-3">
                <a><button class="theme_btn show_modal full_width small_btn" data-toggle="modal" data-target="#add_new">{{$translations['gn_add_new'] ?? 'Add New'}}</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="disciplineMeasureType_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>UID</th>
                                    <th>{{$translations['gn_name'] ?? 'Name'}}</th>
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
                <form name="add-disciplineMeasureType-form">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <h5 class="modal-title" id="exampleModalCenterTitle">{{$translations['sidebar_nav_dmt'] ?? 'Discipline Measure Type'}}</h5>
                            <div class="form-group">
                                <input type="hidden" name="smt_Uid" id="smt_Uid" value="SBE" class="form-control icon_control">
                                <input type="hidden" id="pkSmt">
                            </div>
                            @foreach($languages as $k => $v)
                                <div class="form-group">
                                    <label>{{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
                                    <input type="text" name="smt_DisciplineMeasureName_{{$v->language_key}}" id="smt_DisciplineMeasureName_{{$v->language_key}}" class="form-control force_require icon_control" required="">
                                </div>
                            @endforeach 
                            <div class="form-group">
                                <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                <input type="text" name="smt_Notes" id="smt_Notes" class="form-control icon_control">
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
<script type="text/javascript" id="datatable_script" src="{{ url('public/js/dashboard/discipline_measure.js') }}"></script>
@endpush
@extends('layout.app_with_login')
