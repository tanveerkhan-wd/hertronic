@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_education_plan'] ?? 'Education Plan')
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_user_management'] ?? 'User Management'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/students" href="{{url('/employee/students')}}"><span>{{$translations['sidebar_nav_students'] ?? 'Students'}} >  </span><a class="ajax_request no_sidebar_active" data-slug="employee/enrollStudents" href="{{url('/employee/enrollStudents')}}"><span>{{$translations['gn_enroll'] ?? 'Enroll'}} > </span></a> {{$translations['gn_view_courses'] ?? 'View Courses'}}</h2>
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
                                            <p>{{$translations['sidebar_nav_education_plan'] ?? 'Education Plan'}} ({{$v->language_name}}) : <label> {{$mdata['epl_EducationPlanName_'.$v->language_key]}}</label></p>
                                        </div>
                                        @endforeach
                                        
                                        <div class="col-md-6">
                                            <p>{{$translations['gn_grade'] ?? 'Grade'}} : <span> {{$mdata->grades->gra_GradeName}}</span></p>
                                        </div>

                                        <div class="col-md-6 text-left">
                                            <p>{{$translations['sidebar_nav_education_plan'] ?? 'Education Plan'}} {{$translations['gn_for'] ?? 'for'}} : <label> {{$mdata->educationProgram->edp_Name}}</label></p>
                                        </div>

                                        <div class="col-md-6">
                                            <p>{{$translations['sidebar_nav_national_education_plan'] ?? 'National Education Plan'}} : <label> {{$mdata->nationalEducationPlan->nep_NationalEducationPlanName}}</label></p>
                                        </div>

                                        <div class="col-md-6 text-left">
                                            <p>{{$translations['sidebar_nav_qualification_degree'] ?? 'Qualification Degree'}} : <label> {{$mdata->QualificationDegree->qde_QualificationDegreeName}}</label></p>
                                        </div>

                                        <div class="col-md-6">
                                            <p>{{$translations['sidebar_nav_education_profile'] ?? 'Education Profile'}} : <label> {{$mdata->educationProfile->epr_EducationProfileName}}</label></p>
                                        </div>

                                        <div class="col-md-12">
                                            <p class="mt-2"><strong>{{$translations['gn_mandatory_courses'] ?? 'Mandatory Courses'}}</strong></p>
                                            <div class="table-responsive mt-2">
                                                <table class="color_table">
                                                    <tr>
                                                        <th>Sr. No</th>
                                                        <th width="60%">{{$translations['gn_courses'] ?? 'Courses'}}</th>
                                                        <th>{{$translations['gn_hours'] ?? 'Hours'}}</th>
                                                    </tr>
                                                    
                                                    @foreach($mdata->mandatoryCourse as $k => $v)
                                                        <tr>
                                                            <td>{{$k+1}}</td>
                                                            <td>{{$v->mandatoryCourseGroup->crs_CourseName}}</td>
                                                            <td>{{$v->emc_hours}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="mt-2"><strong>{{$translations['gn_optional_courses'] ?? 'Optional Courses'}}</strong></p>
                                            <div class="table-responsive mt-2">
                                                <table class="color_table">
                                                    <tr>
                                                        <th>Sr. No</th>
                                                        <th width="60%">{{$translations['gn_courses'] ?? 'Courses'}}</th>
                                                        <th>{{$translations['gn_hours'] ?? 'Hours'}}</th>
                                                    </tr>
                                                    @foreach($mdata->optionalCourse as $k => $v)
                                                        <tr>
                                                            <td>{{$k+1}}</td>
                                                            <td>{{$v->optionalCoursesGroup->crs_CourseName}}</td>
                                                            <td>{{$v->eoc_hours}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="mt-2"><strong>{{$translations['gn_mandatory_foreign_language_courses'] ?? 'Mandatory Foreign Language Courses'}}</strong></p>
                                            <div class="table-responsive mt-2">
                                                <table class="color_table">
                                                    <tr>
                                                        <th>Sr. No</th>
                                                        <th width="60%">{{$translations['gn_courses'] ?? 'Courses'}}</th>
                                                        <th>{{$translations['gn_hours'] ?? 'Hours'}}</th>
                                                    </tr>
                                                    @foreach($mdata->foreignLanguageCourse as $k => $v)
                                                        <tr>
                                                            <td>{{$k+1}}</td>
                                                            <td>{{$v->foreignLanguageGroup->crs_CourseName}}</td>
                                                            <td>{{$v->efc_hours}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
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

            