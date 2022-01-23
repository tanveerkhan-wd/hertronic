@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_village_schools'] ?? 'Village Schools')
@section('script', url('public/js/dashboard/village_school.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_school'] ?? 'School'}} > </span>{{$translations['sidebar_nav_village_schools'] ?? 'Village Schools'}}</h2>
            </div>   
            <div class="col-md-4 mb-3">
                <input type="text" id="search_village_school" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>  
            <div class="col-md-4 text-md-right mb-3">
                
            </div> 
            <div class="col-md-2 col-6 mb-3">
               
            </div>
            <div class="col-md-2 col-6 mb-3">
                <a><button class="theme_btn show_modal full_width small_btn @if($logged_user->type !='SchoolCoordinator' && $logged_user->type !='SchoolSubAdmin') hide_content is_HSA @endif" data-toggle="modal" data-target="#add_new">{{$translations['gn_add_new'] ?? 'Add New'}}</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="village_school_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>UID</th>
                                    <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                                    <th>{{$translations['gn_main_school'] ?? 'Main School'}}</th>
                                    <th>{{$translations['gn_residence'] ?? 'Residence'}}</th>
                                    <th>{{$translations['gn_phone'] ?? 'Phone'}}</th>
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
                <form name="add-village-school-form">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <h5 class="modal-title" id="exampleModalCenterTitle">{{$translations['sidebar_nav_village_schools'] ?? 'Village Schools'}}</h5>
                            <input type="hidden" id="pkVsc">
                            <input type="hidden" id="fkVscSch" value="{{$mainSchool}}">
                            @foreach($languages as $k => $v)
                                <div class="form-group">
                                    <label>{{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
                                    <input type="text" name="vsc_VillageSchoolName_{{$v->language_key}}" id="vsc_VillageSchoolName_{{$v->language_key}}" class="form-control force_require icon_control" required="">
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label>{{$translations['gn_postal_code'] ?? 'Postal Code'}} *</label>
                                <select name="fkVscPof" id="fkVscPof" class="form-control icon_control dropdown_control">
                                  <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                  @foreach($PostalCodes as $k => $v)
                                    <option value="{{$v->pkPof}}">{{$v->pof_PostOfficeNumber}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_residence'] ?? 'Residence'}} *</label>
                                <input type="text" name="vsc_Residence" id="vsc_Residence" class="form-control icon_control">
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_phone'] ?? 'Phone'}}</label>
                                <input type="number" name="vsc_PhoneNumber" id="vsc_PhoneNumber" class="form-control icon_control">
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_address'] ?? 'Address'}}</label>
                                <input type="text" name="vsc_Address" id="vsc_Address" class="form-control icon_control">
                            </div>
                            <div class="form-group">
                                <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                <input type="text" name="vsc_Notes" id="vsc_Notes" class="form-control icon_control">
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
<script type="text/javascript" id="datatable_script" src="{{ url('public/js/dashboard/village_school.js') }}"></script>
@endpush
