@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_education_plan'] ?? 'Education Plan')
@section('script', url('public/js/dashboard/education_plan.js'))
@section('content')
<?php $mcdata = []; $ocdata = []; $fcdata = [];?>
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>@if(Auth::guard('admin')->user()->type=='HertronicAdmin') {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}} > @endif</span> <a class="ajax_request no_sidebar_active" data-slug="admin/educationPlans" href="{{url('/admin/educationPlans')}}"><span>{{$translations['sidebar_nav_education_plan'] ?? 'Education Plan'}} > </span></a> {{$translations['gn_edit'] ?? 'Edit'}}</h2>
            </div>   
            <div class="col-12">
                <div class="white_box pt-3 pb-3">
                    <div class="container-fliid">
                        <form name="add-education-plan-form" id="edit-education-plan">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pl-5 pr-5">
                                    <div>
                                        <p class="mt-2"><strong>{{$translations['sidebar_nav_education_plan'] ?? 'Education Plan'}}</strong></p>
                                    </div>
                                    <div class="bg-color-form">
                                        <div class="row">
                                            <input type="hidden" id="eid" value="{{$mdata->pkEpl}}">
                                            @foreach($languages as $k => $v)
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
                                                    <input type="text" name="epl_EducationPlanName_{{$v->language_key}}" id="epl_EducationPlanName_{{$v->language_key}}" class="form-control force_require icon_control" value="{{$mdata['epl_EducationPlanName_'.$v->language_key]}}" required="">
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{$translations['sidebar_nav_education_program'] ?? 'Education Program'}} *</label>
                                                    <select name="fkEplEdp" id="fkEplEdp" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($educationProgram as $tkey => $tvalue)
                                                            <option  @if($mdata->fkEplEdp == $tvalue['pkEdp']) selected @endif value="{{$tvalue['pkEdp']}}">{{$translations['gn_'] ?? $tvalue['edp_Name']}}</option>
                                                            {{-- Sub Parent --}}
                                                            @foreach($tvalue['children'] as $ckey=> $cValue)
                                                                @if($cValue['edp_ParentId']==$tvalue['pkEdp'])
                                                                    <option @if($mdata->fkEplEdp == $cValue['pkEdp']) selected @endif value="{{$cValue['pkEdp']}}">&emsp;&emsp;{{$translations['gn_'] ?? $cValue['edp_Name']}}</option>
                                                                    {{-- Sub Sub Parent --}}
                                                                    @foreach($cValue['children'] as $cckey=> $ccValue)
                                                                        @if($ccValue['edp_ParentId']==$cValue['pkEdp'])
                                                                            <option @if($mdata->fkEplEdp == $ccValue['pkEdp']) selected @endif value="{{$ccValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $ccValue['edp_Name']}}</option>
                                                                            {{-- Sub Sub Sub Parent --}}
                                                                            @foreach($ccValue['children'] as $skey=> $sValue)
                                                                                @if($sValue['edp_ParentId']==$ccValue['pkEdp'])
                                                                                    <option @if($mdata->fkEplEdp == $sValue['pkEdp']) selected @endif value="{{$sValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $sValue['edp_Name']}}</option>
                                                                                    {{-- Sub Sub Sub Sub Parent --}}
                                                                                    @foreach($sValue['children'] as $sskey=> $ssValue)
                                                                                        @if($ssValue['edp_ParentId']==$ssValue['pkEdp'])
                                                                                            <option @if($mdata->fkEplEdp == $sValue['pkEdp']) selected @endif value="{{$ssValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $ssValue['edp_Name']}}</option>
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
                                                            <option @if($mdata->fkEplNep == $v->pkNep) selected @endif value="{{$v->pkNep}}">{{$v->nep_NationalEducationPlanName}}</option>
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
                                                            <option @if($mdata->fkEplEpr == $v->pkEpr) selected @endif value="{{$v->pkEpr}}">{{$v->epr_EducationProfileName}}</option>
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
                                                            <option @if($mdata->fkEplQde == $v->pkQde) selected @endif value="{{$v->pkQde}}">{{$v->qde_QualificationDegreeName}}</option>
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
                                                            <option @if($mdata->fkEplGra == $v->pkGra) selected @endif value="{{$v->pkGra}}">{{$v->gra_GradeName}} ({{$v->gra_GradeNameRoman}})</option>
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
                                  
                                                @foreach($mdata->mandatoryCourse as $k => $v)
                                                <?php $mcdata[] = $v->mandatoryCourseGroup->pkCrs; ?>
                                                <tr class="mcg mcg_{{$v->mandatoryCourseGroup->pkCrs}}">
                                                    <td>{{$k+1}}</td>
                                                    <td>{{$v->mandatoryCourseGroup->crs_CourseName}}</td>
                                                    <td><input onkeyup="cleanHrs(this)" required name="mcg_hrs[]" type="text" id="mcg_hrs_{{$v->mandatoryCourseGroup->pkCrs}}" value="{{$v->emc_hours}}"></td>
                                                    <td><a data-id="{{$v->mandatoryCourseGroup->pkCrs}}" onclick="removeMCG(this)" href="javascript:void(0)" class="theme_btn red_btn min_btn">{{$translations['gn_delete'] ?? 'Delete'}}</a></td>
                                                </tr>
                                                @endforeach
                                                <tr class="mcg mcg_main @if(sizeof($course) <= sizeof($mdata->mandatoryCourse)) hide_content @endif">
                                                    <td>{{sizeof($mdata->mandatoryCourse)+1}}</td>
                                                    <td>
                                                        <select class="form-control icon_control dropdown_control" id="mcg_select">
                                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                            @foreach($course as $k => $v)
                                                                <option @if(in_array($v->pkCrs, $mcdata)) disabled="disabled" @endif value="{{$v->pkCrs}}">{{$v->crs_CourseName}}</option>
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

                                                @foreach($mdata->optionalCourse as $k => $v)
                                                <?php $ocdata[] = $v->optionalCoursesGroup->pkCrs; ?>
                                                <tr class="ocg ocg_{{$v->optionalCoursesGroup->pkCrs}}">
                                                    <td>{{$k+1}}</td>
                                                    <td>{{$v->optionalCoursesGroup->crs_CourseName}}</td>
                                                    <td><input onkeyup="cleanHrs(this)" required name="ocg_hrs[]" type="text" id="ocg_hrs_{{$v->optionalCoursesGroup->pkCrs}}" value="{{$v->eoc_hours}}"></td>
                                                    <td><a data-id="{{$v->optionalCoursesGroup->pkCrs}}" onclick="removeOCG(this)" href="javascript:void(0)" class="theme_btn red_btn min_btn">{{$translations['gn_delete'] ?? 'Delete'}}</a></td>
                                                </tr>
                                                @endforeach
                                                <tr class="ocg ocg_main @if(sizeof($optionalCoursesGroup) <= sizeof($mdata->optionalCourse)) hide_content @endif">
                                                    <td>{{sizeof($mdata->optionalCourse)+1}}</td>
                                                    <td>
                                                        <select class="form-control icon_control dropdown_control" id="ocg_select">
                                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                            @foreach($optionalCoursesGroup as $k => $v)
                                                                <option @if(in_array($v->pkCrs, $ocdata)) disabled="disabled" @endif value="{{$v->pkCrs}}">{{$v->crs_CourseName}}</option>
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
                                                @foreach($mdata->foreignLanguageCourse as $k => $v)
                                                <?php $fcdata[] = $v->foreignLanguageGroup->pkCrs; ?>
                                                <tr class="fcg fcg_{{$v->foreignLanguageGroup->pkCrs}}">
                                                    <td>{{$k+1}}</td>
                                                    <td>{{$v->foreignLanguageGroup->crs_CourseName}}</td>
                                                    <td><input onkeyup="cleanHrs(this)" required name="fcg_hrs[]" type="text" id="fcg_hrs_{{$v->foreignLanguageGroup->pkCrs}}" value="{{$v->efc_hours}}"></td>
                                                    <td><a data-id="{{$v->foreignLanguageGroup->pkCrs}}" onclick="removeFCG(this)" href="javascript:void(0)" class="theme_btn red_btn min_btn">{{$translations['gn_delete'] ?? 'Delete'}}</a></td>
                                                </tr>
                                                @endforeach
                                                <tr class="fcg fcg_main @if(sizeof($foreignLanguageGroup) <= sizeof($mdata->foreignLanguageCourse)) hide_content @endif">
                                                    <td>{{sizeof($mdata->foreignLanguageCourse)+1}}</td>
                                                    <td>
                                                        <select class="form-control icon_control dropdown_control" id="fcg_select">
                                                            <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                            @foreach($foreignLanguageGroup as $k => $v)
                                                                <option @if(in_array($v->pkCrs, $fcdata)) disabled="disabled" @endif value="{{$v->pkCrs}}">{{$v->crs_CourseName}}</option>
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
                                        <button type="submit" class="theme_btn">{{$translations['gn_update'] ?? 'Update'}}</button>
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
    <?php foreach($mdata->mandatoryCourse as $k => $v){?>
        MCG.push('{{$v->mandatoryCourseGroup->pkCrs}}');
    <?php } ?>
    <?php foreach($mdata->optionalCourse as $k => $v){?>
        OCG.push('{{$v->optionalCoursesGroup->pkCrs}}');
    <?php } ?>
    <?php foreach($mdata->foreignLanguageCourse as $k => $v){?>
        FCG.push('{{$v->foreignLanguageGroup->pkCrs}}');
    <?php } ?>
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
            