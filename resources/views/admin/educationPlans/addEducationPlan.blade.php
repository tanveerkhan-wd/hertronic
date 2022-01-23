@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_education_plan'] ?? 'Education Plan')
@section('script', url('public/js/dashboard/education_plan.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_education_plan'] ?? 'Education Plan'}} > </span>{{$translations['gn_add_new'] ?? 'Add New'}}</h2>
            </div>   
            <div class="col-12">
                <div class="white_box pt-3 pb-3">
                    <div class="container-fliid">
                        <form name="add-education-plan-form">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pl-5 pr-5">
                                    <div>
                                        <p class="mt-2"><strong>{{$translations['sidebar_nav_education_plan'] ?? 'Education Plan'}}</strong></p>
                                    </div>
                                    <div class="bg-color-form">
                                        <div class="row">
                                            @foreach($languages as $k => $v)
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
                                                    <input type="text" name="epl_EducationPlanName_{{$v->language_key}}" id="epl_EducationPlanName_{{$v->language_key}}" class="form-control force_require icon_control" required="">
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['sidebar_nav_education_program'] ?? 'Education Program'}} *</label>
                                                    <select name="fkEplEdp" id="fkEplEdp" class="form-control icon_control dropdown_control">
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
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['sidebar_nav_national_education_plan'] ?? 'National Education Plan'}} *</label>
                                                    <select name="fkEplNep" id="fkEplNep" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($nationalEducationPlan as $k => $v)
                                                            <option value="{{$v->pkNep}}">{{$v->nep_NationalEducationPlanName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['sidebar_nav_education_profile'] ?? 'Education Profile'}} *</label>
                                                    <select name="fkEplEpr" id="fkEplEpr" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($educationProfile as $k => $v)
                                                            <option value="{{$v->pkEpr}}">{{$v->epr_EducationProfileName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['sidebar_nav_qualification_degree'] ?? 'Qualification Degree'}} *</label>
                                                    <select name="fkEplQde" id="fkEplQde" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($qualificationDegree as $k => $v)
                                                            <option value="{{$v->pkQde}}">{{$v->qde_QualificationDegreeName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mt-2"><strong>{{$translations['gn_select'] ?? 'Select'}} {{$translations['gn_grade'] ?? 'Grade'}}</strong></p>
                                    </div>
                                    <div class="bg-color-form">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>{{$translations['sidebar_nav_education_plan'] ?? 'Education Plan'}} {{$translations['gn_for'] ?? 'for'}} : <label class="edp_label"> </label></p>
                                                <div class="form-group">
                                                    <label>{{$translations['gn_grade'] ?? 'Grade'}} *</label>
                                                    <select name="fkEplGra" id="fkEplGra" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($grade as $k => $v)
                                                            <option value="{{$v->pkGra}}">{{$v->gra_GradeName}} ({{$v->gra_GradeNameRoman}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="mt-2"><strong>{{$translations['gn_mandatory_courses'] ?? 'Mandatory Courses'}}</strong></p>
                                        <div class="table-responsive mt-2">
                                            <table class="color_table mcg_table">
                                                <tr>
                                                    <th width="10%">Sr. No</th>
                                                    <th width="45%">{{$translations['gn_courses'] ?? 'Courses'}}</th>
                                                    <th width="20%">{{$translations['gn_hours'] ?? 'Hours'}}</th>
                                                    <th width="30%">{{$translations['gn_action'] ?? 'Action'}}</th>
                                                </tr>
                                                <tr class="mcg mcg_main">
                                                    <td>1</td>
                                                    <td>
                                                        <select class="form-control icon_control dropdown_control" id="mcg_select">
                                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                            @foreach($course as $k => $v)
                                                                <option value="{{$v->pkCrs}}">{{$v->crs_CourseName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input onkeyup="cleanHrs(this)" type="text" id="mcg_hrs"></td>
                                                    <td>
                                                        <a onclick="addMCG(this)" href="javascript:void(0)" class="theme_btn min_btn">{{$translations['gn_add'] ?? 'Add'}}</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="mt-2"><strong>{{$translations['gn_optional_courses'] ?? 'Optional Courses'}}</strong></p>
                                        <div class="table-responsive mt-2">
                                            <table class="color_table ocg_table">
                                                <tr>
                                                    <th width="10%">Sr. No</th>
                                                    <th width="45%">{{$translations['gn_courses'] ?? 'Courses'}}</th>
                                                    <th width="20%">{{$translations['gn_hours'] ?? 'Hours'}}</th>
                                                    <th width="30%">{{$translations['gn_action'] ?? 'Action'}}</th>
                                                </tr>
                                                <tr class="ocg ocg_main">
                                                    <td>1</td>
                                                    <td>
                                                        <select class="form-control icon_control dropdown_control" id="ocg_select">
                                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                            @foreach($optionalCoursesGroup as $k => $v)
                                                                <option value="{{$v->pkCrs}}">{{$v->crs_CourseName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input onkeyup="cleanHrs(this)" type="text" id="ocg_hrs"></td>
                                                    <td>
                                                        <a onclick="addOCG(this)" href="javascript:void(0)" class="theme_btn min_btn">{{$translations['gn_add'] ?? 'Add'}}</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                 
                                    <div class="col-md-12">
                                        <p class="mt-2"><strong>{{$translations['gn_mandatory_foreign_language_courses'] ?? 'Mandatory Foreign Language Courses'}}</strong></p>
                                        <div class="table-responsive mt-2">
                                            <table class="color_table fcg_table">
                                                <tr>
                                                    <th width="10%">Sr. No</th>
                                                    <th width="45%">{{$translations['gn_courses'] ?? 'Courses'}}</th>
                                                    <th width="20%">{{$translations['gn_hours'] ?? 'Hours'}}</th>
                                                    <th width="30%">{{$translations['gn_action'] ?? 'Action'}}</th>
                                                </tr>
                                                <tr class="fcg fcg_main">
                                                    <td>1</td>
                                                    <td>
                                                        <select class="form-control icon_control dropdown_control" id="fcg_select">
                                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                            @foreach($foreignLanguageGroup as $k => $v)
                                                                <option value="{{$v->pkCrs}}">{{$v->crs_CourseName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input onkeyup="cleanHrs(this)" type="text" id="fcg_hrs"></td>
                                                    <td>
                                                        <a onclick="addFCG(this)" href="javascript:void(0)" class="theme_btn min_btn">{{$translations['gn_add'] ?? 'Add'}}</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                        <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="admin/educationPlans" href="{{url('/admin/educationPlans')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
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
<input type="hidden" id="hours_validate_txt" value="{{$translations['validate_hours'] ?? 'Please add hours'}}">
<input type="hidden" id="OCG_validate_txt" value="{{$translations['validate_OCG'] ?? 'Please select an Optional Language Course'}}">
<input type="hidden" id="FCG_validate_txt" value="{{$translations['validate_FCG'] ?? 'Please select a Foreign Language Course'}}">
<input type="hidden" id="MCG_validate_txt" value="{{$translations['validate_MCG'] ?? 'Please select a Mandatory Language Course'}}">
<script type="text/javascript">
    var FCG = [];
    var OCG = [];
    var MCG = [];
    $(function() {
      showLoader(false);
    });
</script>
<!-- End Content Body -->
@endsection

@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/education_plan.js') }}"></script>
@endpush
            