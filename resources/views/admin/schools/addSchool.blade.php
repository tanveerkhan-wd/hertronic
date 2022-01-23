@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_school_management'] ?? 'School Management')
@section('script', url('public/js/dashboard/school.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_school_management'] ?? 'School Management'}} > </span>{{$translations['gn_add_new'] ?? 'Add New'}}</h2>
            </div>   
            <div class="col-12">
                <div class="white_box pt-3 pb-3">
                    <div class="container-fliid">
                        <form name="add-school-form">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pl-5 pr-5">
                                    <div class="bg-color-form">
                                        <div class="row">
                                            @foreach($languages as $k => $v)
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
                                                    <input type="text" name="sch_SchoolName_{{$v->language_key}}" id="sch_SchoolName_{{$v->language_key}}" class="form-control force_require icon_control" required="">
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_ministry_license_number'] ?? 'Ministry License Number'}} *</label>
                                                    <input type="text" name="sch_MinistryApprovalCertificate" id="sch_MinistryApprovalCertificate" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-color-form">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>{{$translations['sidebar_nav_education_program'] ?? 'Education Program'}}</label>
                                                    <select onchange="fetchEPlan(this.value)" name="fkEplEdp" id="fkEplEdp" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($educationProgram as $tkey => $tvalue)
                                                            <option value="{{$tvalue['pkEdp']}}">{{$translations['gn_'] ?? $tvalue['edp_Name']}}</option>
                                                            {{-- Sub Parent --}}
                                                            @foreach($tvalue['children'] as $ckey=> $cValue)
                                                                @if($cValue['edp_ParentId']==$tvalue['pkEdp'])
                                                                    <option value="{{$cValue['pkEdp']}}">&emsp;&emsp;{{$translations['gn_'] ?? $cValue['edp_Name']}}</option>
                                                                    {{-- Sub Sub Parent --}}
                                                                    @foreach($cValue['children'] as $cckey=> $ccValue)
                                                                        @if($ccValue['edp_ParentId']==$cValue['pkEdp'])
                                                                            <option value="{{$ccValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $ccValue['edp_Name']}}</option>
                                                                            {{-- Sub Sub Sub Parent --}}
                                                                            @foreach($ccValue['children'] as $skey=> $sValue)
                                                                                @if($sValue['edp_ParentId']==$ccValue['pkEdp'])
                                                                                    <option value="{{$sValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $sValue['edp_Name']}}</option>
                                                                                    {{-- Sub Sub Sub Sub Parent --}}
                                                                                    @foreach($sValue['children'] as $sskey=> $ssValue)
                                                                                        @if($ssValue['edp_ParentId']==$sValue['pkEdp'])
                                                                                            <option value="{{$ssValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $ssValue['edp_Name']}}</option>
                                                                                        @endif
                                                                                    @endforeach

                                                                                @endif
                                                                            @endforeach

                                                                        @endif
                                                                    @endforeach

                                                                @endif
                                                            @endforeach 
                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_education_plan'] ?? 'Education Plan'}} </label>
                                                    <select name="eplan" id="eplan" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group visibility_hidden">sdf</div>
                                                <div class="form-group">
                                                    <button onclick="addPlan()" type="button" class="theme_btn min_btn">{{$translations['gn_add'] ?? 'Add'}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-2">
                                            <table class="color_table school_plan_table" style="display: none;">
                                                <tr>
                                                    <th width="6%">Sr. No</th>
                                                    <th width="15%">{{$translations['gn_parent_category'] ?? 'Parent Category'}}</th>
                                                    <th width="12%">{{$translations['gn_child_category'] ?? 'Child Category'}}</th>
                                                    <th width="15%">{{$translations['gn_education_plan'] ?? 'Education Plan'}}</th>
                                                    <th width="15%">{{$translations['gn_national_education_plan'] ?? 'National Education Plan'}}</th>
                                                    <th width="12%">{{$translations['gn_qualification_degree'] ?? 'Qualification Degree'}}</th>
                                                    <th width="12%">{{$translations['gn_education_profile'] ?? 'Education Profile'}}</th>
                                                    <th width="10%">{{$translations['gn_action'] ?? 'Action'}}</th>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                    </div>
                                    <div class="bg-color-form">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_school_coordinator'] ?? 'School Coordinator'}} {{$translations['gn_name'] ?? 'Name'}} *</label>
                                                    <input type="text" name="sch_CoordName" id="sch_CoordName" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_school_coordinator'] ?? 'School Coordinator'}} {{$translations['gn_email'] ?? 'Email'}} *</label>
                                                    <input type="text" name="sch_CoordEmail" id="sch_CoordEmail" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                        <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="admin/schools" href="{{url('/admin/schools')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="education_plan_validate_txt" value="{{$translations['validate_education_plan'] ?? 'Please select an Education Plan'}}">
<script type="text/javascript">
    var SP = [];
    $(function() {
      showLoader(false);
    });
</script>
<!-- End Content Body -->
@endsection

@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/school.js') }}"></script>
@endpush
            