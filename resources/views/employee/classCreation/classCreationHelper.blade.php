@section('step_3')
@if(isset($data3))
    <?php //$i = 1;
    //$grades = [4,3];
    ?>
    @foreach ($grades as $k1 =>$v1)
    @foreach ($data3 as $k => $v)
    <?php //dd($v);?>
    @if($v1==$k)
    <br>
    <p><strong></strong>{{$translations['gn_grade'] ?? 'Grade'}} - {{$v[0]->educationPlan->grades->gra_GradeName}}</p>
    <div class="table-responsive mt-2">
    <table class="color_table">
        <tbody>
            <tr>
                <th>Sr. No</th>
                <th>{{$translations['gn_courses'] ?? 'Courses'}}</th>
                <th>{{$translations['gn_hours'] ?? 'Hours'}}</th>
                <th width="30%">{{$translations['gn_teachers'] ?? 'Teachers'}}</th>
            </tr>
           <!--  @foreach($data3 as $k => $v) -->
                @if($v1==$v[0]->educationPlan->grades->pkGra)
                <?php $i = 1;?>
                @foreach($v[0]->educationPlan->mandatoryCourse as $kc => $vc)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$vc->mandatoryCourseGroup->crs_CourseName}} - {{$v[0]->educationPlan->epl_EducationPlanName}}</td>
                    <td>{{$vc->emc_hours}}</td>
                    <td>
                        <div class="form-group">
                            <input type="hidden" name="courses[]" value="{{$vc->fkEplCrs}}">
                            <select required id="fkCtcEeg_{{$i}}" name="fkCtcEeg_{{$i}}" class="form-control icon_control dropdown_control select2" placeholder="{{$translations['gn_teachers'] ?? 'Teachers'}}">
                                <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                @foreach($employees as $ek => $ev)
                                <option value="{{$ek}}">{{$ev}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
                <?php $i++; ?>
                @endforeach
                @endif
            <!-- @endforeach -->

        </tbody>
    </table>
    @endif
    @endforeach
    @endforeach
@endif
@endsection

@section('step_4')
@if(isset($data4))
    <div class="col-lg-8 offset-lg-2">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{$translations['gn_homeroom_teacher'] ?? 'Homeroom Teacher'}} *</label>
                    <select required id="fkHrtEmp" name="fkHrtEmp" class="form-control icon_control dropdown_control select2">
                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                        @foreach($employees as $k => $v)
                            <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label>{{$translations['gn_hourly_rate'] ?? 'Hourly Rate'}} *</label>
                  <input required type="number" name="hrt_WeeklyHoursRate" id="hrt_WeeklyHoursRate" class="form-control" min="1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label>{{$translations['gn_type_of_engagement'] ?? 'Type of Engagement'}} *</label>
                  <select required id="fkHrtEty" name="fkHrtEty" class="form-control icon_control dropdown_control">
                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                    @foreach($engagementTypes as $k => $v)
                      <option value="{{$v->pkEty}}">{{$v->ety_EngagementTypeName}}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{$translations['gn_date_of_enrollment'] ?? 'Date of Enrollment'}} *</label>
                    <input required type="text" id="start_date" name="start_date" class="form-control datepicker icon_control date_control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{$translations['gn_date_of_engagement_end'] ?? 'Date of Engagement End'}} </label>
                    <input type="text" id="end_date" name="end_date" class="form-control datepicker icon_control date_control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{$translations['gn_chief_student'] ?? 'Chief Student'}} *</label>
                    <select required id="fkClrCsa" name="fkClrCsa" class="form-control icon_control dropdown_control select2">
                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                        @foreach($data4 as $k => $v)
                            <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{$translations['gn_treasure_student'] ?? 'Treasure Student'}} *</label>
                    <select required id="fkClrCsat" name="fkClrCsat" class="form-control icon_control dropdown_control select2">
                        <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                        @foreach($data4 as $k => $v)
                            <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{$translations['gn_note'] ?? 'Note'}}</label>
                    <input type="text" id="hrt_Notes" name="hrt_Notes" class="form-control" placeholder="{{$translations['gn_enter'] ?? 'Enter'}} {{$translations['gn_note'] ?? 'Note'}}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="card">
                      <div class="card-body">
                        <b>{{$translations['gn_note'] ?? 'Note'}}:</b> {{$translations['gn_end_date_note'] ?? 'Only enter "Date of Engagment End" date field if you wish to inactive the employee'}}
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="list-unstyled list-inline btn-flex mt-3" >
         <li><button type="button" class="small_btn theme_btn prev-step" onclick="prevTab(3)">{{$translations['gn_previous'] ?? 'Previous'}}</button></li>
         <li><button type="submit" class="small_btn theme_btn next-step">{{$translations['gn_next'] ?? 'Next'}}</button></li>
        </ul>
   </div>
@endif
@endsection

@section('step_5')
@if(isset($data5))
<?php $i = 1;
    $tmpGra = [];
    foreach ($data5->classCreationGrades as $k => $v) {
        $tmpGra[] = $v->grade->gra_GradeName;
    }

    if(!empty($tmpGra)){
        asort($tmpGra);
        $grades = implode(', ', $tmpGra);
    }else{
        $grades = '';
    }
?>
    <div class="col-md-12">
        <div class="card-grey">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <p class="label">{{$translations['gn_school_year'] ?? 'School Year'}} :</p>
                        <p class="value">{{$data5->classCreationSchoolYear->sye_NameNumeric}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <p class="label">{{$translations['gn_homeroom_teacher'] ?? 'Homeroom Teacher'}} :</p>
                        <p class="value">{{$data5->homeRoomTeacher[0]->employee->emp_EmployeeName}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <p class="label">{{$translations['gn_semester'] ?? 'Semester'}} :</p>
                        <p class="value">{{$data5->semester->edp_EducationPeriodName}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <p class="label">{{$translations['gn_school_grade'] ?? 'School Grade'}} :</p>
                        <p class="value">{{$grades}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <p class="label">{{$translations['gn_chief_student'] ?? 'Chief Student'}} :</p>
                        <p class="value">{{$data5->chiefStudent->student->full_name}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <p class="label">{{$translations['gn_treasure_student'] ?? 'Treasure Student'}} :</p>
                        <p class="value">{{$data5->treasureStudent->student->full_name}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <p class="label">{{$translations['gn_class'] ?? 'Class'}} :</p>
                        <p class="value">{{$data5->classCreationClasses->cla_ClassName}}</p>
                    </div>
                </div>
            </div>
        </div>
        <p class="mt-3"><strong>{{$translations['gn_students_of_class'] ?? 'Students of Class'}} {{$data5->classCreationClasses->cla_ClassName}}</strong></p>
        <div class="table-responsive mt-2">
            <table class="color_table">
                <tbody><tr>
                    <th>Sr. No</th>
                    <th>ID</th>
                    <th>{{$translations['gn_name'] ?? 'Name'}}</th>
                    <th>{{$translations['gn_grade'] ?? 'Grade'}}</th>
                    <th>{{$translations['gn_education_plan'] ?? 'Education Plan'}}</th>
                </tr>
                @foreach($students as $k => $v)
                <tr>
                    <td>{{$k+1}}</td>
                    <td>@if($v->studentEnroll->student->stu_StudentID != null) {{$v->studentEnroll->student->stu_StudentID}} @else {{$v->studentEnroll->student->stu_TempCitizenId}} @endif</td>
                    <td>{{$v->studentEnroll->student->full_name}}</td>
                    <td>{{$v->studentEnroll->grade->gra_GradeName}}</td>
                    <td>{{$v->studentEnroll->educationProgram->edp_Name}} - {{$v->studentEnroll->educationPlan->epl_EducationPlanName}}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        <p class="mt-3"><strong>{{$translations['gn_class_creation_step_3_subtext'] ?? 'Allocate Teachers for all Courses'}}</strong></p>
        <div class="table-responsive mt-2">
            <table class="color_table">
                <tbody>
                    <tr>
                        <th>Sr. No</th>
                        <th>{{$translations['gn_courses'] ?? 'Courses'}}</th>
                        <th>{{$translations['gn_hours'] ?? 'Hours'}}</th>
                        <th width="30%">{{$translations['gn_teachers'] ?? 'Teachers'}}</th>
                    </tr>

                @foreach($courses as $k => $v)
                    @foreach($v->educationPlan->mandatoryCourse as $kc => $vc)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$vc->mandatoryCourseGroup->crs_CourseName}} - {{$v->educationPlan->epl_EducationPlanName}}</td>
                        <td>{{$vc->emc_hours}}</td>
                        <td>
                            <div class="form-group">
                                <input type="hidden" name="courses[]" value="{{$vc->fkEplCrs}}">
                                <select required id="fkCtcEeg_{{$i}}" name="fkCtcEeg_{{$i}}" class="form-control icon_control dropdown_control select2" placeholder="{{$translations['gn_teachers'] ?? 'Teachers'}}">
                                    <option value="">{{$translations['gn_select'] ?? 'Select'}}</option>
                                    @foreach($employees as $ek => $ev)
                                    <option @if($selectetTeachers[$vc->fkEplCrs] == $ek) selected @endif value="{{$ek}}">{{$ev}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
        <ul class="list-unstyled list-inline btn-flex mt-3">
            <li><button type="button" class="small_btn theme_btn btn-border prev-step" onclick="prevTab(4)">{{$translations['gn_previous'] ?? 'Previous'}}</button></li>
            <li><button type="submit" class="small_btn theme_btn next-step">{{$translations['gn_submit'] ?? 'Submit'}}</button></li>
        </ul>
    </div>

@endif
@endsection