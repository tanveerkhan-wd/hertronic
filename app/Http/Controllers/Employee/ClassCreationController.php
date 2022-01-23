<?php
/**
* ClassCreationController 
* 
* @package    Laravel
* @subpackage Controller
* @since      1.0
*/

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FrontHelper;
use App\Helpers\MailHelper;
use App\Models\Classes;
use App\Models\ClassCreation;
use App\Models\ClassStudentsAllocation;
use App\Models\ClassTeachersAndCourseAllocation;
use App\Models\ClassCreationGrades;
use App\Models\Employee;
use App\Models\EnrollStudent;
use App\Models\EmployeeType;
use App\Models\EducationPeriod;
use App\Models\EngagementType;
use App\Models\EmployeesEngagement;
use App\Models\Grade;
use App\Models\MainBook;
use App\Models\HomeRoomTeacher;
use App\Models\Student;
use App\Models\SchoolEducationPlanAssignment;
use App\Models\SchoolYear;
use App\Models\VillageSchool;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class ClassCreationController extends Controller
{

	public function __construct()
    {
    	parent::__construct();
    	
        $this->middleware(function ($request, $next) {           
	        if(empty($this->logged_user) || $this->logged_user == 'null')
	    	{
	    		Redirect::to('logout')->send();
	    	}
            return $next($request);
        });
    }

    public function classCreation(Request $request)
    {
        /**
         * Used for Class Creation
         * @return redirect to Employee->Class Creation
         */

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();;
        $mainSchool = $mainSchool->fkEenSch;


        $schoolYears = SchoolYear::select('pkSye','sye_NameNumeric')->get();
        $grades = Grade::select('pkGra','gra_GradeName_'.$this->current_language.' as gra_GradeName')->get();
        $classes = Classes::select('pkCla','cla_ClassName_'.$this->current_language.' as cla_ClassName')->get();
        $semesters = EducationPeriod::select('pkEdp', 'edp_EducationPeriodName_'.$this->current_language.' as edp_EducationPeriodName')->get(); 
        $villageSchools = VillageSchool::select('pkVsc', 'vsc_VillageSchoolName_'.$this->current_language.' as vsc_VillageSchoolName')->where('fkVscSch',$mainSchool)->get();

        if (request()->ajax()) {
            return \View::make('employee.classCreation.classCreation')->with(['classes'=> $classes, 'mainSchool'=>$mainSchool, 'schoolYears'=>$schoolYears, 'grades'=>$grades, 'semesters'=>$semesters, 'villageSchools'=>$villageSchools])->renderSections();
        }
        return view('employee.classCreation.classCreation')->with(['classes'=> $classes, 'mainSchool'=>$mainSchool, 'schoolYears'=>$schoolYears, 'grades'=>$grades, 'semesters'=>$semesters, 'villageSchools'=>$villageSchools]);
    }

    public function viewMainBook($id)
    {
      /**
       * Used for View School Main Book
       */
        $mdata = '';
        if(!empty($id)){

            // $mdata = Employee::with('EmployeesEngagement.employeeType','country')->whereHas('EmployeesEngagement', function($q1) use($id){
            //     $q1->whereHas('employeeType', function ($q2) use($id){
            //         $q2->where('epty_Name', 'SchoolSubAdmin');
            //     })->where('fkEenEmp',$id);
            // })->first();
        }

        if (request()->ajax()) {
            return \View::make('employee.mainBook.student')->with('mid', $id)->renderSections();
        }
        return view('employee.mainBook.student',['mid'=>$id]);

    }

    public function classCreationPost(Request $request)
    {
      /**
       * Used for Add Class
       */
    	$input = $request->all();
    	$response = [];
        // var_dump($input);die();
        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();;
        $mainSchool = $mainSchool->fkEenSch;

        $empType = EmployeeType::select('pkEpty')->where('epty_Name','=','Teacher')->get();

        foreach ($empType as $key => $value) {
            $allowedTypes[] = $value->pkEpty;
        }
        
        $class_step = $input['class_step'];
        $pkClr = $input['pkClr'];

        unset($input['pkClr']);
        unset($input['class_step']);

        if($class_step == 1){
            $grades = $input['fkClrGra'];
            unset($input['fkClrGra']);

            if(!empty($pkClr)){ //if updating existing class creation
                $checkPrev = ClassCreation::select('pkClr')->where('fkClrSye',$input['fkClrSye'])->where('fkClrEdp',$input['fkClrEdp'])->where('fkClrCla',$input['fkClrCla'])->where('fkClrSch',$input['fkClrSch'])->where('pkClr', '!=', $pkClr)->first();
            }else{
                $checkPrev = ClassCreation::select('pkClr')->where('fkClrSye',$input['fkClrSye'])->where('fkClrEdp',$input['fkClrEdp'])->where('fkClrCla',$input['fkClrCla'])->where('fkClrSch',$input['fkClrSch'])->first();
            }


            $checkPrevGrades = 0;
            if(!empty($checkPrev)){  
                $checkPrevGrades = ClassCreationGrades::where('fkCcgClr',$checkPrev->pkClr)->whereIn('fkCcgGra',$grades)->get()->count();
            }

            $checkPrevGrades1 = 0;
            if(!empty($input['fkClrVsc'])){ // If village school is selected

                if(!empty($pkClr)){ //if updating existing class creation
                    $checkPrev1 = ClassCreation::select('pkClr')->where('fkClrSye',$input['fkClrSye'])->where('fkClrEdp',$input['fkClrEdp'])->where('fkClrCla',$input['fkClrCla'])->where('fkClrSch',$input['fkClrSch'])->where('fkClrVsc',$input['fkClrVsc'])->where('pkClr', '!=', $pkClr)->first();
                }else{
                    $checkPrev1 = ClassCreation::select('pkClr')->where('fkClrSye',$input['fkClrSye'])->where('fkClrEdp',$input['fkClrEdp'])->where('fkClrCla',$input['fkClrCla'])->where('fkClrSch',$input['fkClrSch'])->where('fkClrVsc',$input['fkClrVsc'])->first();
                }

                
                if(!empty($checkPrev1)){  
                    $checkPrevGrades1 = ClassCreationGrades::where('fkCcgClr',$checkPrev1->pkClr)->whereIn('fkCcgGra',$grades)->get()->count();
                }
            }


            // if((!empty($checkPrev) && ($checkPrevGrades)) || (!empty($checkPrev1) && ($checkPrevGrades1))){
            if($checkPrevGrades != 0 || $checkPrevGrades1 != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_class_creation_exist'] ?? "Class is already created with the current details";
            }else{

                if(!empty($pkClr)){
                    ClassCreation::where('pkClr', $pkClr)->update($input);
                    $id = $pkClr;
                }else{
                    $id = ClassCreation::insertGetId($input);
                }

                if(!empty($id)){

                    if(!empty($pkClr)){ //if updating existing class creation
                        ClassCreationGrades::where('fkCcgClr', $id)->forceDelete();
                    }

                    foreach($grades as $k => $v){
                        $gradesData[] = ['fkCcgClr'=>$id, 'fkCcgGra'=> $v];
                    }
                    
                    ClassCreationGrades::insert($gradesData);

                    $response['status'] = true;
                    $response['message'] = $this->translations['msg_class_creation_step_1_success'] ?? "Class Creation Step 1 Successful";
                    $response['pkClr'] = $id;

                }else{
                    $response['status'] = false;
                    $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
                }
            }

        }

        if($class_step == 2){
            $stuIds = $input['stu_ids'];
            unset($input['stu_ids']);

            $grades = ClassCreationGrades::where('fkCcgClr',$pkClr)->get()->pluck('fkCcgGra')->toArray();
            asort($grades);
            //var_dump($grades)

            $educationPlanDetails = SchoolEducationPlanAssignment::whereHas('educationPlan', function($q) use($grades){
                $q->whereIn('fkEplGra',$grades);
            })->with([
            'educationPlan.educationProgram'=>function($q){
                $q->select('pkEdp', 'edp_Name_'.$this->current_language.' as edp_Name');
            },
            'educationPlan'=>function($q) use ($grades){
                $q->select('*', 'epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName');
            },
            'educationPlan.grades'=>function($q) use ($grades){
                $q->select('pkGra', 'gra_GradeName_'.$this->current_language.' as gra_GradeName','gra_GradeNameRoman');
            },
            'educationPlan.mandatoryCourse.mandatoryCourseGroup'=> function($q){
                $q->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','!=','DummyOptionalCourse')->where('crs_CourseType','!=','DummyForeignCourse');
            },
            ])->where('fkSepSch',$mainSchool)->where('sep_status','Active')->get()->groupBy('educationPlan.fkEplGra');;

            // $employees = Employee::whereHas('EmployeesEngagement', function($q) use($mainSchool,$allowedTypes){
            //         $q->where('fkEenSch',$mainSchool)->where('een_DateOfFinishEngagement',null)->whereIn('fkEenEpty', $allowedTypes);
            // })->get()->pluck('emp_EmployeeName','id');

            $employees = EmployeesEngagement::with(['employee'=>function($q) {//Employee engagment id with employee
                $q->select('emp_EmployeeName','id');
            }])->where('fkEenSch',$mainSchool)->where('een_DateOfFinishEngagement',null)->whereIn('fkEenEpty', $allowedTypes)->get()->pluck('employee.emp_EmployeeName','pkEen');

            // dd($educationPlanDetails);

            $nextData = \View::make('employee.classCreation.classCreationHelper')->with(['data3'=>$educationPlanDetails, 'employees'=>$employees, 'grades'=>$grades])->renderSections();


            if(!empty($pkClr)){

                //if updating existing class creation
                ClassStudentsAllocation::where('fkCsaClr', $pkClr)->forceDelete();

                foreach($stuIds as $k => $v){
                    $stuData[] = ['fkCsaClr'=>$pkClr, 'fkCsaSen'=> $v];
                }
                
                ClassStudentsAllocation::insert($stuData);


                $response['status'] = true;
                $response['message'] = $this->translations['msg_class_creation_step_2_success'] ?? "Class Creation Step 2 Successful";
                $response['pkClr'] = $pkClr;
                $response['step_3_data'] = $nextData['step_3'];

            }else{
                $response['status'] = false;
                $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
            }

        }
    	
        if($class_step == 3){
            $courses = $input['courses'];
            unset($input['courses']);
            $insert = [];


            // $employees = EmployeesEngagement::with(['employee'=>function($q) {//Employee engagment id with employee
            //     $q->select('emp_EmployeeName','id');
            // }])->where('fkEenSch',$mainSchool)->where('een_DateOfFinishEngagement',null)->whereIn('fkEenEpty', $allowedTypes)->get()->pluck('employee.emp_EmployeeName','pkEen');

            $EngagementTypes = EngagementType::select('pkEty','ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName')->get();

            $employees = Employee::whereHas('EmployeesEngagement', function($q) use($mainSchool,$allowedTypes){
                    $q->where('fkEenSch',$mainSchool)->where('een_DateOfFinishEngagement',null)->whereIn('fkEenEpty', $allowedTypes);
            })->get()->pluck('emp_EmployeeName','id');

            $students = ClassStudentsAllocation::with(['studentEnroll.student'])->where('fkCsaClr',$pkClr)->get()->pluck("studentEnroll.student.full_name", "fkCsaSen");

            $nextData = \View::make('employee.classCreation.classCreationHelper')->with(['data4'=>$students, 'employees'=>$employees, 'engagementTypes'=>$EngagementTypes])->renderSections();

            if(!empty($pkClr)){
                foreach ($courses as $key => $value) {
                    $insert[] = ['fkCtcEeg'=>$input['fkCtcEeg_'.($key+1)], 'fkCtcEmc'=>$value, 'fkCtcClr'=>$pkClr];
                }

                //if updating existing class creation
                ClassTeachersAndCourseAllocation::where('fkCtcClr', $pkClr)->forceDelete();
                // ClassTeachersAndCourseAllocation::where('fkCtcClr', $pkClr)
                //           ->update(['deleted_at' => now()]);
                ClassTeachersAndCourseAllocation::insert($insert);

                $response['status'] = true;
                $response['message'] = $this->translations['msg_class_creation_step_3_success'] ?? "Class Creation Step 3 Successful";
                $response['pkClr'] = $pkClr;
                $response['step_4_data'] = $nextData['step_4'];

            }else{
                $response['status'] = false;
                $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
            }

        }

        if($class_step == 4){

            HomeRoomTeacher::where('fkHrtClr', $pkClr)->forceDelete();

            $ee = new HomeRoomTeacher;
            $ee->fkHrtEmp = $input['fkHrtEmp']; 
            $ee->fkHrtClr = $pkClr;
            $ee->fkHrtEty = $input['fkHrtEty'];
            $ee->hrt_WeeklyHoursRate = $input['hrt_WeeklyHoursRate'];
            $ee->hrt_DateOfEngagement = date('Y-m-d h:i:s',strtotime($input['start_date']));
            $ee->hrt_Notes = $input['hrt_Notes'];
            if(isset($input['end_date']) && !empty($input['end_date'])){
                $ee->hrt_DateOfFinishEngagement = date('Y-m-d h:i:s',strtotime($input['end_date']));
            }
            $ee->save();

            if($ee->save()){
            
                ClassCreation::where('pkClr', $pkClr)
                      ->update(['fkClrCsa' => $input['fkClrCsa'], 'fkClrCsat' => $input['fkClrCsat']]);

                $classData = ClassCreation::whereHas('homeRoomTeacher', function($q) {
                    $q->where('hrt_DateOfFinishEngagement',null);
                })->with([
                    'classCreationSchoolYear'=> function($q){
                        $q->select('pkSye','sye_NameNumeric');
                    },
                    'classCreationGrades.grade'=> function($q){
                        $q->select('pkGra', 'gra_GradeName_'.$this->current_language.' as gra_GradeName','gra_GradeNameRoman');
                    },
                    'homeRoomTeacher.employee'=> function($q){
                        $q->select('id','emp_EmployeeName');
                    },
                    'chiefStudent.student'=> function($q){
                        //$q->select('id','full_name');
                    },
                    'treasureStudent.student'=> function($q){
                        //$q->select('id','full_name');
                    },
                    'classCreationClasses'=> function($q){
                        $q->select('pkCla', 'cla_ClassName_'.$this->current_language.' as cla_ClassName');
                    },
                    'semester'=> function($q){
                        $q->select('pkEdp', 'edp_EducationPeriodName_'.$this->current_language.' as edp_EducationPeriodName');
                    }
                ])->where('pkClr',$pkClr)->first();


                //fetch selected students
                $classStudents = ClassStudentsAllocation::
                // whereHas('student', function($q) {
                //     // if(!empty($filter)){
                //     //     $q->where(function ($query) use ($filter) {
                //     //         $query->where ( 'stu_StudentName', 'LIKE', '%' . $filter . '%' )
                //     //             ->orWhere ( 'stu_StudentSurname', 'LIKE', '%' . $filter . '%' )
                //     //             ->orWhere ( 'stu_StudentID', 'LIKE', '%' . $filter . '%' )
                //     //             ->orWhere ( 'stu_TempCitizenId', 'LIKE', '%' . $filter . '%' );
                //     //     });   
                //     // }
                // })->
                with([
                    'studentEnroll.student',
                    'studentEnroll.grade'=> function($q){
                        $q->select('pkGra', 'gra_GradeName_'.$this->current_language.' as gra_GradeName','gra_GradeNameRoman');
                    },
                    'studentEnroll.educationProgram'=> function($q){
                        $q->select('pkEdp', 'edp_Name_'.$this->current_language.' as edp_Name');
                    },
                    'studentEnroll.educationPlan'=> function($q){
                        $q->select('pkEpl', 'epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName');
                    },
                ])->get();

                $selectetTeachers = ClassTeachersAndCourseAllocation::where('fkCtcClr',$pkClr)->get()->pluck('fkCtcEeg','fkCtcEmc');

                //fetch school courses
                $courses = SchoolEducationPlanAssignment::with([
                    'educationPlan.educationProgram'=>function($q){
                        $q->select('pkEdp', 'edp_Name_'.$this->current_language.' as edp_Name');
                    },
                    'educationPlan'=>function($q){
                        $q->select('*', 'epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName');
                    },
                    'educationPlan.mandatoryCourse.mandatoryCourseGroup'=> function($q){
                        $q->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','!=','DummyOptionalCourse')->where('crs_CourseType','!=','DummyForeignCourse');
                    },
                ])->where('fkSepSch',$mainSchool)->where('sep_status','Active')->get();

                $employees = EmployeesEngagement::with(['employee'=>function($q) {//Employee engagment id with employee
                    $q->select('emp_EmployeeName','id');
                }])->where('fkEenSch',$mainSchool)->where('een_DateOfFinishEngagement',null)->whereIn('fkEenEpty', $allowedTypes)->get()->pluck('employee.emp_EmployeeName','pkEen');


                $nextData = \View::make('employee.classCreation.classCreationHelper')->with(['data5'=>$classData, 'students'=>$classStudents, 'courses'=>$courses, 'employees'=>$employees, 'selectetTeachers'=>$selectetTeachers])->renderSections();

                $response['message'] = $this->translations['msg_class_creation_step_4_success'] ?? "Class Creation Step 4 Successful";
                $response['pkClr'] = $pkClr;
                $response['status'] = true;
                $response['step_5_data'] = $nextData['step_5'];
            }else{
                $response['status'] = false;
                $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
            }


        }

        if($class_step == 5){

            var_dump($input);die();

            $courses = $input['courses'];
            unset($input['courses']);
            $insert = [];

            if(!empty($pkClr)){
                foreach ($courses as $key => $value) {
                    $insert[] = ['fkCtcEeg'=>$input['fkCtcEeg_'.($key+1)], 'fkCtcEmc'=>$value, 'fkCtcClr'=>$pkClr];
                }

                //if updating existing class creation
                ClassTeachersAndCourseAllocation::where('fkCtcClr', $pkClr)->forceDelete();
                // ClassTeachersAndCourseAllocation::where('fkCtcClr', $pkClr)
                //           ->update(['deleted_at' => now()]);
                ClassTeachersAndCourseAllocation::insert($insert);

                $response['status'] = true;
                $response['message'] = $this->translations['msg_class_creation_add_success'] ?? "Class Creation Step 3 Successful";
                $response['pkClr'] = $pkClr;

            }else{
                $response['status'] = false;
                $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
            }
        }
    	

        return response()->json($response);
    }

    public function getMainBook(Request $request)
    {
      /**
       * Used for Edit MainBook
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = MainBook::where('pkMbo','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
            $cdata->mbo_OpeningDate = date('m/d/Y',strtotime($cdata->mbo_OpeningDate));
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getClassStudents(Request $request)
    {
      /**
       * Used for MainBook Students Listing
       */
        $data = $request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    

        $sort_col =  $data['order'][0]['column'];

        $sort_field = $data['columns'][$sort_col]['data'];

        $pkClr = $data['pkClr'];

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();;
        $mainSchool = $mainSchool->fkEenSch;

        $cdata = ClassCreation::where('pkClr',$pkClr)->first();

        if(!empty($cdata)){
            $fkClrSch = $cdata->fkClrSch;
            $fkClrSye = $cdata->fkClrSye;
        }else{
            $fkClrSch = 0;
            $fkClrSye = 0;
        }

        if(!empty($pkClr)){

            $classGradesTmp = ClassCreationGrades::select('fkCcgGra')->where('fkCcgClr', $pkClr)->get();
        }else{
            $classGradesTmp = [];
        }


        $classGrades = [];

        foreach ($classGradesTmp as $key => $value) {
            $classGrades[] = $value->fkCcgGra;
        }

        // $classStudent = Student::whereHas('enrollStudent', function($q) use ($fkSteMbo,$date_filter){
        //     $q->where('fkSteMbo',$fkSteMbo);
        //     if(!empty($date_filter)){
        //         $q->where('ste_EnrollmentDate',$date_filter)->where('ste_FinishingDate',null);
        //     }
        // })->with(['enrollStudent']);


        $classStudent = EnrollStudent::whereHas('student', function($q) use($filter){
                if(!empty($filter)){
                    $q->where(function ($query) use ($filter) {
                        $query->where ( 'stu_StudentName', 'LIKE', '%' . $filter . '%' )
                            ->orWhere ( 'stu_StudentSurname', 'LIKE', '%' . $filter . '%' )
                            ->orWhere ( 'stu_StudentID', 'LIKE', '%' . $filter . '%' )
                            ->orWhere ( 'stu_TempCitizenId', 'LIKE', '%' . $filter . '%' );
                    });   
                }
            })->with([
            'student',
            'grade'=> function($q){
                $q->select('pkGra', 'gra_GradeName_'.$this->current_language.' as gra_GradeName','gra_GradeNameRoman');
            },
            'educationProgram'=> function($q){
                $q->select('pkEdp', 'edp_Name_'.$this->current_language.' as edp_Name');
            },
            'educationPlan'=> function($q){
                $q->select('pkEpl', 'epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName');
            },
        ])->whereIn('fkSteGra',$classGrades)->where('fkSteSch',$fkClrSch)->where('fkSteSye',$fkClrSye)->where('ste_FinishingDate',null);


        if($sort_col != 0){
            $classStudent = $classStudent->orderBy($sort_field, $sort_type);
        }

        $total_mainBooks= $classStudent->count();

          $offset = $data['start'];
         
          $counter = $offset;
          $classStudentdata = [];
          $classStudents = $classStudent->offset($offset)->limit($perpage);
          // var_dump($classStudents->toSql(),$classStudents->getBindings());
          $filtered_mainBooks = $classStudent->offset($offset)->limit($perpage)->count();
          $classStudents = $classStudent->offset($offset)->limit($perpage)->get()->toArray();

           foreach ($classStudents as $key => $value) {
                $value['index'] = $counter+1;
                $value['stu_DateOfBirth'] = date('m/d/Y',strtotime($value['student']['stu_DateOfBirth']));
                $value['ste_EnrollmentDate'] = date('m/d/Y',strtotime($value['ste_EnrollmentDate']));
                $value['ste_status'] = $this->translations['gn_active'] ?? "Active";
                $classStudentdata[$counter] = $value;
                $counter++;
          }

          $price = array_column($classStudentdata, 'index');

        if($sort_col == 0){
            if($sort_type == 'desc'){
                array_multisort($price, SORT_DESC, $classStudentdata);
            }else{
                array_multisort($price, SORT_ASC, $classStudentdata);
            }
        }
          $result = array(
            "draw" => $data['draw'],
            "recordsTotal" =>$total_mainBooks,
            "recordsFiltered" => $total_mainBooks,
            'data' => $classStudentdata,
          );

           return response()->json($result);
    }


    public function deleteMainBook(Request $request)
    {
      /**
       * Used for Delete MainBook
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		MainBook::where('pkMbo', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }

    
    public function classCreations(Request $request)
    {
        /**
         * Used for Class Creations
         * @return redirect to Employee->Class Creation
         */
        $searchSchYear = SchoolYear::select('pkSye','sye_NameNumeric')->get()->toArray();
        $searchGrade = Grade::select('pkGra','gra_GradeName_'.$this->current_language.' as gra_GradeName')->get()->toArray();

        if (request()->ajax()) {
            return \View::make('employee.classCreation.classCreations')->with(['searchSchYear'=>$searchSchYear,'searchGrade'=>$searchGrade])->renderSections();
        }
        return view('employee.classCreation.classCreations')->with(['searchSchYear'=>$searchSchYear,'searchGrade'=>$searchGrade]);
    }

    public function getClassCreations(Request $request)
    {
        /**
         * Used for Class Creations listing
         * @return redirect to Employee->Class Creation listing
         */        
        $data =$request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $filterGra = isset( $data['grade'] ) ? $data['grade'] : '';

        $filterSye = isset( $data['schoolYear'] ) ? $data['schoolYear'] : '';
        
        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    
        $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

        $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data']:'';

        $classCreation = ClassCreation::with(['classCreationGrades.grade'=> function($q){
                $q->select('pkGra', 'gra_GradeName_'.$this->current_language.' as gra_GradeName','gra_Uid');
            },
            'classCreationSchoolYear','classStudentsAllocation','classCreationClasses' => function($q){
                $q->select('pkCla', 'cla_ClassName_'.$this->current_language.' as cla_ClassName','cla_Uid');
            }
        ]);

        if($filter){
            $classCreation = $classCreation->whereHas('classCreationClasses', function($q) use($filter){
                $q->where('cla_ClassName_'.$this->current_language , 'LIKE', '%' . $filter . '%' );
            })->orWhere( 'pkClr', 'LIKE', '%' . $filter . '%' )->orWhereHas('classCreationGrades.grade', function($qe) use($filter){
                $qe->where('gra_GradeName_'.$this->current_language , 'LIKE', '%' . $filter . '%' );
            })->orWhereHas('classCreationSchoolYear', function($qee) use($filter){
                $qee->where('sye_NameNumeric', 'LIKE', '%' . $filter . '%' );
            });
        }

        if ($filterGra) {
            $classCreation = $classCreation->whereHas('classCreationGrades.grade', function($qgra) use($filterGra){
                $qgra->where('gra_GradeName_'.$this->current_language , 'LIKE', '%' . $filterGra . '%' );
            });   
        }

        if ($filterSye) {
            $classCreation = $classCreation->whereHas('classCreationSchoolYear', function($qsye) use($filterSye){
                $qsye->where('sye_NameNumeric', 'LIKE', '%' . $filterSye . '%' );
            });
        }

        $classCreationQuery = $classCreation;

        if($sort_col != 0){
            $classCreationQuery = $classCreationQuery->orderBy($sort_field, $sort_type);
        }

        $total_class_creation = $classCreationQuery->count();

        $offset = isset($data['start']) ? $data['start'] :'';
         
        $counter = $offset;
        $classCreationdata = [];
        $classCreations = $classCreationQuery->offset($offset)->limit($perpage);
        $filtered_countries = $classCreationQuery->offset($offset)->limit($perpage)->count();
        $classCreations = $classCreationQuery->offset($offset)->limit($perpage)->get()->toArray();
        $counter = 0;
        foreach ($classCreations as $key => $value) {
            $aGrade =[];
            foreach ($value['class_creation_grades'] as $v_key => $V_value) {
                $aGrade[] = $V_value['grade']['gra_GradeName'];
            }
            $value['grade'] = isset($aGrade)?$aGrade:'';
            $value['total_stu'] = isset($value['class_students_allocation']) ? count($value['class_students_allocation']):'';
            $value['index'] = $counter+1;
            $classCreationdata[$counter] = $value;
            $counter++;
        }

        $price = array_column($classCreationdata, 'index');

        if($sort_col == 0){
            if($sort_type == 'desc'){
                array_multisort($price, SORT_DESC, $classCreationdata);
            }else{
                array_multisort($price, SORT_ASC, $classCreationdata);
            }
        }
        $result = array(
            "draw" => $data['draw'],
            "recordsTotal" =>$total_class_creation,
            "recordsFiltered" => $total_class_creation,
            'data' => $classCreationdata,
        );

        return response()->json($result);
    }

    public function deleteClassCreations(Request $request)
    {
      /**
       * Used for Delete Employee Class Creation.
       */
        $input = $request->all();
        $cid = $input['cid'];
        $response = [];

        if(empty($cid)){
            $response['status'] = false;
        }else{

            $eed = ClassCreation::where('pkClr', $cid)
                      ->update(['deleted_at' => now()]);

            if($eed){
                $response['status'] = true;
                $response['message'] = $this->translations['msg_class_creation_delete_success'] ?? "Class Creation Successfully Deleted";
            }else{
                $response['status'] = false;
                $response['message'] = $this->translations['msg_class_creation_delete_prompt'] ?? "Sorry, the selected class creation cannot be deleted"; 
            }
        }

        return response()->json($response);
    }


}