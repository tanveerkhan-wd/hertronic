<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\FrontHelper;
use App\Models\Municipality;
use App\Models\PostalCode;
use App\Models\School;
use App\Models\Citizenship;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\University;
use App\Models\EnrollStudent;
use App\Models\Student;
use App\Models\MainBook;
use App\Models\Grade;
use App\Models\EducationProgram;
use App\Models\EducationPlan;
use App\Models\EmployeesEngagement;
use App\Models\SchoolYear;
use App\Models\SchoolEducationPlanAssignment;
use App\Models\Employee;
use Validator;
use Carbon\Carbon;
use Auth;
use Hash;
use Redirect;

class EnrollStudentController extends Controller
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
    public function enrollStudents(Request $request)
    {    	
        /**
         * Used for Enroll Students page
         * @return redirect to Employee->enrollStudents
         */
        $educationPro = [];
        $eduPlan = [];
        $educationPrograms = '';
        $grades = [];
        $input = $request->all();
        //Get School ID
        $schoolDetail = Employee::with('EmployeesEngagement','EmployeesEngagement.employeeType')->whereHas('EmployeesEngagement', function($query) {
            $query->whereHas('employeeType', function ($query) {
                $query->where('epty_Name', 'SchoolCoordinator')->orWhere('epty_Name', 'SchoolSubAdmin');
            })->where('fkEenEmp',$this->logged_user->id)->where(function ($query){
                $query->where('een_DateOfFinishEngagement', '=', null)
                    ->orWhere('een_DateOfFinishEngagement', '>=', now());
            });
        })->first();
        $mainSchool = $schoolDetail->EmployeesEngagement[0]->fkEenSch;

        //Get Education Data
        $sclEduPlnAssinment = SchoolEducationPlanAssignment::where('fkSepSch',$mainSchool)->where('sep_Status','Active')->get()->toArray();
        foreach ($sclEduPlnAssinment as $key => $value) {
            $eduProg[] = $value['fkSepEdp'];
        	$eduPlan[] = $value['fkSepEpl'];
        }
        $educationProg = EducationProgram::select('pkEdp','edp_Uid','edp_Name_'.$this->current_language.' as edp_Name')->whereIn('pkEdp',$eduProg)->get();

        //Get Education Education Program from  SchoolEducationPlanAssignment
        if (isset($input['fkSteEdp']) && $input['fkSteEdp']) {
            $sclEduPlnAssinmen = SchoolEducationPlanAssignment::where('fkSepSch',$mainSchool)->where('fkSepEdp',$input['fkSteEdp'])->where('sep_Status','Active')->get()->toArray();
            foreach ($sclEduPlnAssinmen as $key => $value) {
                $eduPlan1[] = $value['fkSepEpl'];
            }

        	$educationPlans = EducationPlan::select('pkEpl','epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName')->whereIn('pkEpl',$eduPlan1)->get()->toArray();
            
            return response()->json(['status'=>true,'educationPlans'=>$educationPlans]);
        }
        //Get Grade List From Education plan
        if (isset($input['fkSteEpl']) && $input['fkSteEpl']) {

            $gradIdeduPlan = EducationPlan::select('fkEplGra')->where('pkEpl',$input['fkSteEpl'])->first();

            $grades = Grade::select('pkGra','gra_Uid','gra_GradeName_'.$this->current_language.' as gra_GradeName')->where('pkGra',$gradIdeduPlan->fkEplGra)->first()->toArray();
        
            return response()->json(['status'=>true,'grades'=>$grades]);
        }

        $mainBooks = MainBook::select('pkMbo','mbo_Uid','mbo_MainBookNameRoman')->get();

        $schoolYear =SchoolYear::select('pkSye','sye_NameNumeric')->where('deleted_at',null)->get();
        if (request()->ajax()) {
            return \View::make('employee.enrollStudent.enrollStudent')->with(['schoolYear'=>$schoolYear,'mainBooks'=>$mainBooks, 'grades'=>$grades, 'educationPrograms'=>$educationPrograms, 'educationProg'=>$educationProg])->renderSections();
        }
        return view('employee.enrollStudent.enrollStudent',['schoolYear'=>$schoolYear,'mainBooks'=>$mainBooks, 'grades'=>$grades, 'educationPrograms'=>$educationPrograms, 'educationProg'=>$educationProg]);

    }
    
    public function getEnrollStudent(Request $request)
    {

      /**
       * Used for Employee Student listing
       */
        $data =$request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    
        $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column'] : '';

        $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] : '' ;

        $student = new Student;

        if($filter){
            $student = $student->where ( 'stu_StudentID', 'LIKE', '%' . $filter . '%' )->orWhere ( 'stu_StudentName', 'LIKE', '%' . $filter . '%' );
        }
        $studentQuery = $student;

        if($sort_col != 0){
            $studentQuery = $studentQuery->orderBy($sort_field, $sort_type);
        }

        $total_students= $studentQuery->count();

          $offset = $data['start'];
         
          $counter = $offset;
          $studentdata = [];
          $students = $studentQuery->offset($offset)->limit($perpage);
          // var_dump($countries->toSql(),$countries->getBindings());
          $students = $studentQuery->offset($offset)->limit($perpage)->get()->toArray();

           foreach ($students as $key => $value) {
                $value['index']      = $counter+1;
                $studentdata[$counter] = $value;
                $counter++;
          }

          $price = array_column($studentdata, 'index');

        if($sort_col == 0){
            if($sort_type == 'desc'){
                array_multisort($price, SORT_DESC, $studentdata);
            }else{
                array_multisort($price, SORT_ASC, $studentdata);
            }
        }
          $result = array(
            "draw" => $data['draw'],
            "recordsTotal" =>$total_students,
            "recordsFiltered" => $total_students,
            "data" => $studentdata,
          );
          return response()->json($result);
     
    }

    public function enrollStudentPost(Request $request)
    {
    /**
       * Used for Engage Employee post
       */
        $response = [];
        $input = $request->all();
        
        $studentsDet = '';
        if (isset($input['select_student']) && $input['select_student'] != null && !empty($input['select_student']) ) {
        	$studentsDet =Student::select('id','stu_DistanceInKilometers')->where('id',$input['select_student'])->first();
        }else{
        	return response()->json(['status'=>false, 'message'=> $this->translations['msg_please_add_student'] ?? "Please add student"]); 
        }

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();;
        $mainSchool = $mainSchool->fkEenSch;
        
        if (isset($studentsDet) && !empty($studentsDet)) {
            $checkEnroll = EnrollStudent::where('fkSteStu',$studentsDet->id)->where('fkSteSye',$input['fkSteSye'])->where('fkSteSch',$mainSchool)->first();
            if (!empty($checkEnroll)) {
                return response()->json(['status'=>false, 'message'=> $this->translations['msg_student_already_selected_same_school'] ?? "Student already exists in the selected school and school year"]); 
            }
        }

        $ee = new EnrollStudent;
        $ee->fkSteStu = isset($studentsDet->id)?$studentsDet->id:'';
        $ee->fkSteMbo = $input['fkSteMbo'];
        $ee->fkSteGra = $input['fkSteGra'];
        $ee->fkSteEdp = $input['fkSteEdp']; 
        $ee->fkSteEpl = $input['fkSteEpl'];
        $ee->fkSteSye = $input['fkSteSye'];
        $ee->fkSteSch = $mainSchool;
        $ee->ste_DistanceInKilometers = !empty($studentsDet->stu_DistanceInKilometers)?$studentsDet->stu_DistanceInKilometers:'';
        $ee->ste_MainBookOrderNumber = $input['ste_MainBookOrderNumber'];
        $ee->ste_EnrollmentDate = !empty($input['ste_EnrollmentDate']) ? date('Y-m-d h:i:s',strtotime($input['ste_EnrollmentDate'])) : '';
        $ee->ste_EnrollBasedOn = $input['ste_EnrollBasedOn'];
        $ee->ste_Reason = $input['ste_Reason'];
        $ee->ste_FinishingDate = !empty($input['ste_FinishingDate']) ? date('Y-m-d h:i:s',strtotime($input['ste_FinishingDate'])) :null;
        $ee->ste_BreakingDate = !empty($input['ste_BreakingDate']) ? date('Y-m-d h:i:s',strtotime($input['ste_BreakingDate'])) :null;
        $ee->ste_ExpellingDate = !empty($input['ste_ExpellingDate']) ? date('Y-m-d h:i:s',strtotime($input['ste_ExpellingDate'])):null;

        if($ee->save()){
            $response['status'] = true;
            $response['message'] = $this->translations['msg_student_enrolled_success'] ?? "Student successfully enrolled";
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }


        return response()->json($response);
    	
    }

    public function viewEducationPlan($id)
    {
      /**
       * Used for View Education Plan
       */
        $mdata = '';
        if(!empty($id)){
            $mdata = EducationPlan::with(['grades'=> function($query){
                    $query->select('pkGra', 'gra_GradeNameRoman' ,'gra_GradeName_'.$this->current_language.' as gra_GradeName');
                },
                'educationProfile'=> function($query){
                    $query->select('pkEpr', 'epr_EducationProfileName_'.$this->current_language.' as epr_EducationProfileName');
                },
                'educationProgram'=> function($query){
                    $query->select('pkEdp', 'edp_Name_'.$this->current_language.' as edp_Name');
                },
                'nationalEducationPlan'=> function($query){
                    $query->select('pkNep','nep_NationalEducationPlanName_'.$this->current_language.' as nep_NationalEducationPlanName');
                },
                'QualificationDegree'=> function($query){
                    $query->select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName');
                },
                'mandatoryCourse.mandatoryCourseGroup'=> function($query){
                    $query->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','!=','DummyOptionalCourse')->where('crs_CourseType','!=','DummyForeignCourse');
                },
                'optionalCourse.optionalCoursesGroup'=> function($query){
                    $query->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyOptionalCourse');
                },
                'foreignLanguageCourse.foreignLanguageGroup'=> function($query){
                    $query->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyForeignCourse');
                }
            ]);
            $mdata = $mdata->where('pkEpl','=',$id)->where('deleted_at','=',null)->first();

        }
        if (request()->ajax()) {
            return \View::make('employee.enrollStudent.viewEducationPlan')->with('mdata', $mdata)->renderSections();
        }
        return view('employee.enrollStudent.viewEducationPlan',['mdata'=>$mdata]);

    }

}
