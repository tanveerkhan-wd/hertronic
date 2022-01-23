@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_class_creation'] ?? 'Class Creation')
@section('script', url('public/js/dashboard/class_creation.js'))
@section('content')	
<!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 mb-3">
               <h2 class="title"><span>{{$translations['sidebar_nav_organization'] ?? 'Organization'}} > </span><a class="ajax_request no_sidebar_active" data-slug="employee/classCreations" href="{{url('/employee/classCreations')}}"><span>{{$translations['sidebar_nav_class_creation'] ?? 'Class Creation'}} > </span></a>{{$translations['gn_add'] ?? 'Add'}}</h2>
            </div> 
        <input type="hidden" id="teacher_txt" value="{{$translations['gn_teacher'] ?? 'Teacher'}}">
        <input type="hidden" id="principal_txt" value="{{$translations['gn_principal'] ?? 'Principal'}}">
        <input type="hidden" id="stu_sel_valid_txt" value="{{$translations['msg_student_select_valid'] ?? 'The student already selected'}}">
        <input type="hidden" id="stu_sel_txt" value="{{$translations['msg_sel_stu'] ?? 'Please select a student'}}">
        <div class="col-12">
            <div class="white_box pt-5 pb-5">
                <div class="container-fliid">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="process">
                                <div class="process-row nav nav-tabs">
                                   <!--  <div class="process-step">
                                        <button type="button" class="btn-round-1 btn-process btn-round active" data-toggle="tab" href="#menu1">1</button>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn-round-2 btn-process btn-round" data-toggle="tab" href="#menu2">2</button>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn-round-3 btn-process btn-round" data-toggle="tab" href="#menu3">3</button>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn-round-4 btn-process btn-round" data-toggle="tab" href="#menu4">4</button>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn-round-5 btn-process btn-round" data-toggle="tab" href="#menu5">5</button>
                                    </div> -->

                                    <div class="process-step">
                                        <button type="button" class="btn-round-1 btn-process btn-round active" href="#menu1">1</button>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn-round-2 btn-process btn-round" href="#menu2">2</button>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn-round-3 btn-process btn-round" href="#menu3">3</button>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn-round-4 btn-process btn-round" href="#menu4">4</button>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn-round-5 btn-process btn-round" href="#menu5">5</button>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="tab-content mt-5">
                                <div id="menu1" class="tab-pane active in">
                                    <form name="class-creation-step-1">
                                        <input type="hidden" id="fkClrSch" value="{{$mainSchool}}">
                                        <input type="hidden" id="pkClr" value=" @if(isset($pkClr)) {{$pkClr}} @endif">
                                        <div class="row">
                                            <div class="col-lg-8 offset-lg-2">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_school_year'] ?? 'School Year'}} *</label>
                                                    <select disabled id="fkClrSye" name="fkClrSye" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($schoolYears as $k => $v)
                                                        <option @if($k == 0) selected @endif value="{{$v->pkSye}}">{{$v->sye_NameNumeric}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{$translations['gn_semester'] ?? 'Semester'}} *</label>
                                                    <select id="fkClrEdp" name="fkClrEdp" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($semesters as $k => $v)
                                                        <option value="{{$v->pkEdp}}">{{$v->edp_EducationPeriodName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{$translations['gn_school_grade'] ?? 'School Grade'}} *</label>
                                                    <select multiple="multiple" required id="fkClrGra" name="fkClrGra[]" class="form-control icon_control dropdown_control select2_drop">
                                                        @foreach($grades as $k => $v)
                                                        <option value="{{$v->pkGra}}">{{$v->gra_GradeName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{$translations['gn_class'] ?? 'Class'}} *</label>
                                                    <select id="fkClrCla" name="fkClrCla" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($classes as $k => $v)
                                                        <option value="{{$v->pkCla}}">{{$v->cla_ClassName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                                    <input type="text" id="clr_Notes" name="clr_Notes" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_note'] ?? 'Note'}}">
                                                </div>
                                                <div class="form-group form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_village_school">
                                                    <label class="custom_checkbox"></label>
                                                    <label class="form-check-label label-text" for="exampleCheck1">{{$translations['gn_is_village_school'] ?? 'is it Village School ?'}}</label>
                                                </div>
                                                <div class="form-group village_schools_drp hide_content">
                                                    <label>{{$translations['gn_village_school'] ?? 'Village School'}} *</label>
                                                    <select id="fkClrVsc" name="fkClrVsc" class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                        @foreach($villageSchools as $k => $v)
                                                        <option value="{{$v->pkVsc}}">{{$v->vsc_VillageSchoolName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <ul class="list-unstyled list-inline btn-flex mt-3" >
                                                 <li style="visibility: hidden;"><button type="button" class="small_btn theme_btn prev-step">{{$translations['gn_previous'] ?? 'Previous'}}</button></li>
                                                 <li><button type="submit" class="small_btn theme_btn next-step">{{$translations['gn_next'] ?? 'Next'}}</button></li>
                                                </ul>
                                           </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <div id="menu2" class="tab-pane fade">
                                    <form name="class-creation-step-2">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>{{$translations['gn_search_student'] ?? 'Search Students'}}</label>
                                                            <input type="text" id="search_student" class="form-control icon_control search_control" placeholder="{{$translations['gn_student'] ?? 'Student'}} ID, {{$translations['gn_name'] ?? 'Name'}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive mt-2">
                                                    <table id="student_listing" class="display" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No.</th>
                                                                <th>Id</th>
                                                                <th>{{$translations['gn_student_name'] ?? 'Student Name'}}</th>
                                                                <th>{{$translations['gn_grade'] ?? 'Grade'}}</th>
                                                                <th>{{$translations['gn_education_plan'] ?? 'Education Plan'}}</th>
                                                                <th><div class="action">{{$translations['gn_action'] ?? 'Action'}}</div></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <p class="mt-2 sel_stu_elem hide_content"><strong>{{$translations['gn_selected_students'] ?? 'Selected Students'}}</strong></p>
                                                <div class="table-responsive mt-2">
                                                    <table class="color_table class_seleted_students sel_stu_elem hide_content">
                                                        <tbody><tr>
                                                            <th>Sr. No.</th>
                                                            <th>Id</th>
                                                            <th>{{$translations['gn_student_name'] ?? 'Student Name'}}</th>
                                                            <th>{{$translations['gn_grade'] ?? 'Grade'}}</th>
                                                            <th>{{$translations['gn_education_plan'] ?? 'Education Plan'}}</th>
                                                            <th><div class="action">{{$translations['gn_action'] ?? 'Action'}}</div></th>
                                                        </tr>

                                                    </tbody>
                                                    </table>
                                                </div>
                                                <ul class="list-unstyled list-inline btn-flex mt-3">
                                                 <li><button type="button" class="small_btn theme_btn btn-border prev-step" onclick="prevTab(1)" data-href="menu1">{{$translations['gn_previous'] ?? 'Previous'}}</button></li>
                                                 <li><button type="submit" class="small_btn theme_btn next-step">{{$translations['gn_next'] ?? 'Next'}}</button></li>
                                                </ul>
                                           </div>
                                       </div>
                                   </form>
                                </div>

                                <div id="menu3" class="tab-pane fade">
                                    <form name="class-creation-step-3">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p><strong>{{$translations['gn_class_creation_step_3_subtext'] ?? 'Allocate Teachers for all Courses'}}</strong></p>
                                                <div class="table-responsive mt-2 step_3_resp">
                                                    <table class="color_table">
                                                        <tbody>
                                                            <tr>
                                                                <th>Sr. No</th>
                                                                <th>{{$translations['gn_courses'] ?? 'Courses'}}</th>
                                                                <th>{{$translations['gn_hours'] ?? 'Hours'}}</th>
                                                                <th>{{$translations['gn_teachers'] ?? 'Teachers'}}</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <ul class="list-unstyled list-inline btn-flex mt-3">
                                                 <li><button type="button" class="small_btn theme_btn btn-border prev-step" onclick="prevTab(2)">{{$translations['gn_previous'] ?? 'Previous'}}</button></li>
                                                 <li><button type="submit" class="small_btn theme_btn next-step">{{$translations['gn_next'] ?? 'Next'}}</button></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="menu4" class="tab-pane fade">
                                    <form name="class-creation-step-4">
                                        <div class="row step_4_resp">
                                            <div class="col-lg-8 offset-lg-2">
                                                <div class="form-group">
                                                    <label>{{$translations['gn_homeroom_teacher'] ?? 'Homeroom Teacher'}} *</label>
                                                    <select class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{$translations['gn_chief_student'] ?? 'Chief Student'}} *</label>
                                                    <select class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{$translations['gn_treasure_student'] ?? 'Treasure Student'}} *</label>
                                                    <select class="form-control icon_control dropdown_control">
                                                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                                                    <input type="text" id="clr_Notes" name="clr_Notes" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_note'] ?? 'Note'}}">
                                                </div>
                                                <ul class="list-unstyled list-inline btn-flex mt-3" >
                                                 <li style="visibility: hidden;"><button type="button" class="small_btn theme_btn prev-step" onclick="prevTab(3)">{{$translations['gn_previous'] ?? 'Previous'}}</button></li>
                                                 <li><button type="submit" class="small_btn theme_btn next-step">{{$translations['gn_next'] ?? 'Next'}}</button></li>
                                                </ul>
                                           </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="menu5" class="tab-pane fade">
                                    <form name="class-creation-step-5">
                                        <div class="row step_5_resp">
                                            <div class="col-md-12">
                                                <div class="card-grey">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <p class="label">{{$translations['gn_school_year'] ?? 'School Year'}} :</p>
                                                                <p class="value">2019/20</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <p class="label">{{$translations['gn_homeroom_teacher'] ?? 'Homeroom Teacher'}} :</p>
                                                                <p class="value">Chinaza Akachi</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <p class="label">{{$translations['gn_semester'] ?? 'Semester'}} :</p>
                                                                <p class="value">1</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <p class="label">{{$translations['gn_school_grade'] ?? 'School Grade'}} :</p>
                                                                <p class="value">5</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <p class="label">{{$translations['gn_chief_student'] ?? 'Chief Student'}} :</p>
                                                                <p class="value">Andrei Masharin</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <p class="label">{{$translations['gn_treasure_student'] ?? 'Treasure Student'}} :</p>
                                                                <p class="value">Maria Trofimova</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <p class="label">{{$translations['gn_class'] ?? 'Class'}} :</p>
                                                                <p class="value">1A</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3"><strong>Students of Class 1A</strong></p>
                                                <div class="table-responsive mt-2">
                                                    <table class="color_table">
                                                        <tbody><tr>
                                                            <th>Sr. No</th>
                                                            <th>ID</th>
                                                            <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                                                            <th>{{$translations['gn_grade'] ?? 'Grade'}}</th>
                                                            <th>{{$translations['gn_education_plan'] ?? 'Education Plan'}}</th>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>
                                                <p class="mt-3"><strong>{{$translations['gn_class_creation_step_3_subtext'] ?? 'Allocate Teachers for all Courses'}}</strong></p>
                                                <div class="table-responsive mt-2">
                                                    <table class="color_table">
                                                        <tbody><tr>
                                                            <th>Sr. No</th>
                                                            <th>{{$translations['gn_courses'] ?? 'Courses'}}</th>
                                                            <th>{{$translations['gn_hours'] ?? 'Hours'}}</th>
                                                            <th>{{$translations['gn_teachers'] ?? 'Teachers'}}</th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <ul class="list-unstyled list-inline btn-flex mt-3">
                                                    <li><button type="button" class="small_btn theme_btn btn-border prev-step" onclick="prevTab(4)">{{$translations['gn_previous'] ?? 'Previous'}}</button></li>
                                                    <li><button type="button" class="small_btn theme_btn next-step">{{$translations['gn_submit'] ?? 'Submit'}}</button></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
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