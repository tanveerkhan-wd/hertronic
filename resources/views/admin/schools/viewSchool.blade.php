@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_school_management'] ?? 'School Management')
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>@if(Auth::guard('admin')->user()->type=='HertronicAdmin') {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}} > @endif </span> <a class="ajax_request no_sidebar_active" data-slug="admin/schools" href="{{url('/admin/schools')}}"><span>{{$translations['sidebar_nav_school_management'] ?? 'School Management'}} > </span></a> {{$translations['gn_view_details'] ?? 'View Details'}}</h2>
            </div>   
            <div class="col-12">
                <div class="white_box pt-3 pb-3">
                    <div class="container-fliid">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="pl-5 pr-5">
                                    <div class="row">
                                        @foreach($languages as $k => $v)
                                        <div class="col-md-6">
                                            <p>{{$translations['gn_school'] ?? 'School'}} {{$translations['gn_name'] ?? 'Name'}} ({{$v->language_name}}) : <label> {{$mdata['sch_SchoolName_'.$v->language_key]}}</label></p>
                                        </div>
                                        @endforeach
                                        
                                        <div class="col-md-6">
                                            <p>{{$translations['gn_ministry_license_number'] ?? 'Ministry License Number'}} : <label> {{$mdata->sch_MinistryApprovalCertificate}}</label></p>
                                        </div>

                                        <div class="bg-color-form col-md-12">
                                            <p class="mt-2"><strong>{{$translations['gn_education_plans_n_programs'] ?? 'Education Plans & Programs'}}</strong></p>
                                            <div class="table-responsive mt-2">
                                                <table class="color_table">
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
                                                    @foreach($mdata->schoolEducationPlanAssignment as $k => $v)
                                                        <tr class="sch sch_{{$v->educationPlan->pkEpl}} ">
                                                            <td>{{$k+1}}</td>
                                                            <td>@if($v->educationProgram->edp_ParentId == 0) - @else {{$v->educationProgram->parent['edp_Name_'.$current_language]}} @endif</td>
                                                            <td>{{$v->educationProgram['edp_Name_'.$current_language]}}</td>
                                                            <td>{{$v->educationPlan['epl_EducationPlanName_'.$current_language]}}</td>
                                                            <td>{{$v->educationPlan->nationalEducationPlan['nep_NationalEducationPlanName_'.$current_language]}}</td>
                                                            <td>{{$v->educationPlan->QualificationDegree['qde_QualificationDegreeName_'.$current_language]}}</td>
                                                            <td>{{$v->educationPlan->educationProfile['epr_EducationProfileName_'.$current_language]}}</td>
                                                            <td><a target="_blank" href="{{url('admin/viewEducationPlan/')}}/{{$v->educationPlan->pkEpl}}"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                        <div class="bg-color-form col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>{{$translations['gn_school_coordinator'] ?? 'School Coordinator'}} {{$translations['gn_name'] ?? 'Name'}} : <label> {{$mdata->employeesEngagement[0]->employee->emp_EmployeeName}}</label></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{$translations['gn_school_coordinator'] ?? 'School Coordinator'}} {{$translations['gn_email'] ?? 'Email'}} : <label> {{$mdata->employeesEngagement[0]->employee->email}}</label></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
<!-- End Content Body -->
@endsection

            