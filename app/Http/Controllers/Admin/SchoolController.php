<?php
/**
* SchoolController 
* 
* @package    Laravel
* @subpackage Controller
* @since      1.0
*/

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FrontHelper;
use App\Helpers\MailHelper;
use App\Models\Admin;
use App\Models\EducationPlan;
use App\Models\EducationProgram;
use App\Models\Employee;
use App\Models\EmployeesEngagement;
use App\Models\EmployeeType;
use App\Models\EngagementType;
use App\Models\MainBook;
use App\Models\VillageSchool;
use App\Models\School;
use App\Models\SchoolEducationPlanAssignment;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class SchoolController extends Controller
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

    public function schools(Request $request)
    {
        /**
         * Used for Admin School
         * @return redirect to Admin->Education Plans
         */
        if (request()->ajax()) {
            return \View::make('admin.schools.schools')->renderSections();
        }
        return view('admin.schools.schools');
    }

    public function addSchool(Request $request)
    {
        /**
         * Used for Add School
         * @return redirect to Admin->School
         */

        $streams = EducationProgram::select('pkEdp','edp_ParentId', 'edp_Name_'.$this->current_language.' as edp_Name')->get()->toArray();
        $educationProgram = FrontHelper::buildtree($streams);   

        if (request()->ajax()) {
            return \View::make('admin.schools.addSchool')->with(['educationProgram'=>$educationProgram])->renderSections();
        }
        return view('admin.schools.addSchool', ['educationProgram'=>$educationProgram]);
    }

    public function addSchoolPost(Request $request)
    {
      /**
       * Used for Add Admin School
       */
    	$input = $request->all();
    	$response = [];
        $PSdata = [];

        $SP = explode(',', $input['SP']);
        $CoordinatorName = $input['sch_CoordName'];
        $CoordinatorEmail = $input['sch_CoordEmail'];
        if(isset($input['sep_Status'])){
            $SepStatus = $input['sep_Status'];
        }else{
            $SepStatus = [];
        }

        unset($input['SP']);
        unset($input['pkSch']);
        unset($input['sch_CoordName']);
        unset($input['sch_CoordEmail']);
        unset($input['sep_Status']);
        unset($input['fkEplEdp']);
        unset($input['eplan']);
        
        $checkPrev = School::where('sch_SchoolName_'.$this->current_language,$input['sch_SchoolName_'.$this->current_language])->first();
        $checkPrevEmp = Employee::where('emp_EmployeeName',$CoordinatorName)->first();
        $checkPrevEmpEmail = Employee::where('email',$CoordinatorEmail)->first();
        $checkPrevEmpEmailAdmin = Admin::where('email',$CoordinatorEmail)->first();
        if(!empty($checkPrev)){
            $response['status'] = false;
            $response['message'] = $this->translations["msg_school_exist"] ?? "School already exist with this name";
        }elseif(!empty($checkPrevEmp)){
            $response['status'] = false;
            $response['message'] = $this->translations["msg_school_coordinator_exists"] ?? "School Coordinator already exist with this name";
        }elseif(!empty($checkPrevEmpEmail) || !empty($checkPrevEmpEmailAdmin)){
            $response['status'] = false;
            $response['message'] = $this->translations["msg_email_already_registered"] ?? "The email is already registered in the system";
        }else{
    		$id = School::insertGetId($input);
			if(!empty($id)){
				School::where('pkSch', $id)
	              ->update(['sch_Uid' => "SCH".$id]);

                foreach($SP as $k => $v){
                    $EProgram = EducationPlan::select('fkEplEdp')->where("pkEpl", '=', $v)->first();
                    $sp_status = 'Inactive';
                    if(in_array($v, $SepStatus)){
                        $sp_status = 'Active';
                    }
                    $PSdata[] = ['fkSepSch'=>$id, 'fkSepEpl'=> $v, 'fkSepEdp'=>$EProgram->fkEplEdp, 'sep_Status'=>$sp_status];
                }

                SchoolEducationPlanAssignment::insert($PSdata);
                $verification_key = md5(FrontHelper::generatePassword(20));
                $user = new Employee;
                $user->email = $CoordinatorEmail;
                $user->emp_EmployeeName = $CoordinatorName;
                $user->email_verification_key = $verification_key;
                $user->save();
                
                $empType = EmployeeType::select('pkEpty')->where('epty_Name','=','SchoolCoordinator')->where('epty_ParentId','=',null)->first();
                $engType = EngagementType::select('pkEty')->where('ety_EngagementTypeName_en','=','Full Time')->first();//Full time
                $current_time = date("Y-m-d H:i:s");

                $ee = new EmployeesEngagement;
                $ee->fkEenSch = $id;
                $ee->fkEenEmp = $user->id;
                $ee->fkEenEty = $engType->pkEty; //Full time
                $ee->fkEenEpty = $empType->pkEpty;
                $ee->een_DateOfEngagement = $current_time;
                $ee->save();

                $reset_pass_token = base64_encode($CoordinatorEmail.'&&SchoolCoordinator&&'.$current_time);
                $data = ['email' => $CoordinatorEmail, 'name'=>$CoordinatorName, 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New School Coordinator Credentials'];

                $sendmail = MailHelper::sendNewCredentials($data);

				$response['status'] = true;
	            $response['message'] = $this->translations['msg_school_add_success'] ?? "School Successfully Added";

	        }else{
	            $response['status'] = false;
	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
	        }
        }
    	
        return response()->json($response);
    }

    public function fetchEducationPlan(Request $request)
    {
        /**
       * Used for Fetching Education Plan by Education program
       */
        $input = $request->all();
        $response = [];
        $EPparent = '-';
        //$mdata = EducationPlan::select('pkEpl','epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName')->where('fkEplEdp','=',$input['pid'])->get();
        $mdata = EducationPlan::with(['nationalEducationPlan'=> function($query){
                $query->select('pkNep', 'nep_NationalEducationPlanName_'.$this->current_language.' as nep_NationalEducationPlanName');
            },
            'QualificationDegree'=> function($query){
                $query->select('pkQde', 'qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName');
            },
            'educationProfile'=> function($query){
                $query->select('pkEpr', 'epr_EducationProfileName_'.$this->current_language.' as epr_EducationProfileName');
            },
            ])->addSelect('*','epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName');
        $mdata = $mdata->where('fkEplEdp','=',$input['pid'])->get();

        $EPmain = EducationProgram::select('edp_ParentId', 'pkEdp', 'edp_Name_'.$this->current_language.' as edp_Name')->where('pkEdp','=',$input['pid'])->first();
        if(!empty($EPmain->edp_ParentId)){
            $EPparent = EducationProgram::select('edp_ParentId', 'pkEdp', 'edp_Name_'.$this->current_language.' as edp_Name')->where('pkEdp','=',$EPmain->edp_ParentId)->first();
            $EPparent = $EPparent->edp_Name;
        }

        if(!empty($mdata)){
            $response['status'] = true;
            $response['data'] = $mdata;
            $response['EPmain'] = $EPmain->edp_Name;
            $response['EPparent'] = $EPparent;
        }else{
            $response['status'] = false;
        }

        return response()->json($response);
    }

    public function editSchool($id)
    {
      /**
       * Used for Edit Admin School
       */

        $streams = EducationProgram::select('pkEdp','edp_ParentId', 'edp_Name_'.$this->current_language.' as edp_Name')->get()->toArray();
        $educationProgram = FrontHelper::buildtree($streams);

    	if(!empty($id)){
            $mdata = School::with('employeesEngagement','employeesEngagement.employee','schoolEducationPlanAssignment.educationPlan.educationProfile','schoolEducationPlanAssignment.educationPlan.QualificationDegree','schoolEducationPlanAssignment.educationPlan.nationalEducationPlan','schoolEducationPlanAssignment.educationProgram.parent')->whereHas('employeesEngagement', function($subQuery) use ($id){
                $subQuery->whereHas('employeeType', function($q){
                    $q->where('epty_Name', 'SchoolCoordinator');
                })
                ->with(['schoolEducationPlanAssignment.educationPlan' => function($q) use($id) {
                    $q->select('*', 'epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName');
                }])
                ->with(['schoolEducationPlanAssignment.educationProgram' => function($q) use($id) {
                    $q->select('*', 'edp_Name_'.$this->current_language.' as edp_Name');
                }]);
                //;
            });
            $mdata = $mdata->where('pkSch','=',$id)->first();

            //dd($mdata);
        }


        if (request()->ajax()) {
            return \View::make('admin.schools.editSchool')->with(['educationProgram'=>$educationProgram, 'mdata'=>$mdata])->renderSections();
        }
        return view('admin.schools.editSchool',['educationProgram'=>$educationProgram, 'mdata'=>$mdata]);


    }

    public function editSchoolPost(Request $request)
    {
        /**
       * Used for Admin School Update
       */
        $input = $request->all();
        $response = [];
        //var_dump($input);die();
        $PSdata = [];

        $SP = explode(',', $input['SP']);
        $CoordinatorName = $input['sch_CoordName'];
        $CoordinatorEmail = $input['sch_CoordEmail'];
        if(isset($input['sep_Status'])){
            $SepStatus = $input['sep_Status'];
        }else{
            $SepStatus = [];
        }

        unset($input['SP']);
        unset($input['sch_CoordName']);
        unset($input['sch_CoordEmail']);
        unset($input['sep_Status']);
        unset($input['fkEplEdp']);
        unset($input['eplan']);

        $prevData = EmployeesEngagement::select('fkEenEmp')->where('fkEenSch',$input['pkSch'])->first();
        $prevEmpData = Employee::where('id',$prevData->fkEenEmp)->first();
        //var_dump($prevEmpData);die();
        
        $checkPrev = School::where('sch_SchoolName_'.$this->current_language, $input['sch_SchoolName_'.$this->current_language])->where('pkSch','!=',$input['pkSch'])->first();
        $checkPrevEmp = Employee::where('emp_EmployeeName', $CoordinatorName)->where('id', "!=", $prevData->fkEenEmp)->first();
        $checkPrevEmpEmail = Employee::where('email', $CoordinatorEmail)->where('id', "!=", $prevData->fkEenEmp)->first();
        $checkPrevEmpEmailAdmin = Admin::where('email', $CoordinatorEmail)->where('id', "!=", $prevData->fkEenEmp)->first();


        if(!empty($checkPrev)){
            $response['status'] = false;
            $response['message'] = $this->translations["msg_school_exist"] ?? "School already exist with this name";
        }elseif(!empty($checkPrevEmp)){
            $response['status'] = false;
            $response['message'] = $this->translations["msg_school_coordinator_exists"] ?? "School Coordinator already exist with this name";
        }elseif(!empty($checkPrevEmpEmail) || !empty($checkPrevEmpEmailAdmin)){
            $response['status'] = false;
            $response['message'] = $this->translations["msg_email_already_registered"] ?? "The email is already registered in the system";
        }else{
            
            School::where('pkSch', $input['pkSch'])
                  ->update($input);

            //SchoolEducationPlanAssignment::where('fkSepSch', $input['pkSch'])->update(['deleted_at' => now()]);
            SchoolEducationPlanAssignment::where('fkSepSch', $input['pkSch'])->forceDelete();

            foreach($SP as $k => $v){
                $EProgram = EducationPlan::select('fkEplEdp')->where("pkEpl", '=', $v)->first();
                $sp_status = 'Inactive';
                if(in_array($v, $SepStatus)){
                    $sp_status = 'Active';
                }
                $PSdata[] = ['fkSepSch'=>$input['pkSch'], 'fkSepEpl'=> $v, 'fkSepEdp'=>$EProgram->fkEplEdp, 'sep_Status'=>$sp_status];
            }

            SchoolEducationPlanAssignment::insert(array_reverse($PSdata));

            if($prevEmpData->email != $CoordinatorEmail){
                $current_time = date("Y-m-d H:i:s");
                $verification_key = md5(FrontHelper::generatePassword(20));
                $reset_pass_token = base64_encode($CoordinatorEmail.'&&SchoolCoordinator&&'.$current_time);
                $data = ['email' => $CoordinatorEmail, 'name'=>$CoordinatorName, 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New School Coordinator Credentials'];

                $sendmail = MailHelper::sendNewMinistryIDPass($data);
                $prevEmpData->email_verified_at = null;
                $prevEmpData->email_verification_key = $verification_key;
            }

            $prevEmpData->email = $CoordinatorEmail;
            $prevEmpData->emp_EmployeeName = $CoordinatorName;
            $prevEmpData->save();

            $response['status'] = true;
            $response['message'] = $this->translations['msg_school_update_success'] ?? "School Successfully Update";

        }
        
        return response()->json($response);
    }

    public function getSchools(Request $request)
    {
      /**
       * Used for Admin School Listing
       */
    	$data = $request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

        $School = School::with('employeesEngagement','employeesEngagement.employee')->whereHas('employeesEngagement', function($subQuery) use ($filter){
            $subQuery->whereHas('employeeType', function($q) use ($filter){
                $q->where( 'epty_Name', '=', 'SchoolCoordinator' );
            })
            ->whereHas('employee', function($q1) use ($filter){
                if($filter){
                    $q1->where( 'emp_EmployeeName', 'LIKE', '%' . $filter . '%' )->orWhere( 'email', 'LIKE', '%' . $filter . '%' );
                }
            });
        });


    	if($filter){
    		$School = $School->orWhere ( 'sch_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'sch_SchoolName_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere ( 'sch_MinistryApprovalCertificate', 'LIKE', '%' . $filter . '%' );
    	}
    	$SchoolQuery = $School;
        //var_dump($SchoolQuery->toSql(),$SchoolQuery->getBindings());

    	if($sort_col != 0){
    		$SchoolQuery = $SchoolQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_School = $SchoolQuery->count();

    	$offset = $data['start'];
	     
	    $counter = $offset;
	    $SchoolData = [];

	    $Schools = $SchoolQuery->select('*','sch_SchoolName_'.$this->current_language.' as sch_SchoolName')->offset($offset)->limit($perpage)->get()->toArray();

        foreach ($Schools as $key => $value) {
            $value['index']      = $counter+1;
            $SchoolData[$counter] = $value;
            $counter++;
        }

	      $price = array_column($SchoolData, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $SchoolData);
	     	}else{
	     		array_multisort($price, SORT_ASC, $SchoolData);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_School,
			"recordsFiltered" => $total_School,
	        "data" => $SchoolData,
	      );

	       return response()->json($result);
    }

    public function viewSchool($id)
    {
      /**
       * Used for View School
       */
        $mdata = '';
        if(!empty($id)){
            $mdata = School::with('employeesEngagement','employeesEngagement.employee','schoolEducationPlanAssignment.educationPlan','schoolEducationPlanAssignment.educationProgram.parent')->whereHas('employeesEngagement', function($subQuery) use ($id){
                $subQuery->whereHas('employeeType', function($q){
                    $q->where('epty_Name', 'SchoolCoordinator');
                })
                ->with(['schoolEducationPlanAssignment.educationPlan' => function($q) use($id) {
                    $q->select('*', 'epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName');
                }])
                ->with(['schoolEducationPlanAssignment.educationProgram' => function($q) use($id) {
                    $q->select('*', 'edp_Name_'.$this->current_language.' as edp_Name');
                }]);
                //;
            });
            $mdata = $mdata->where('pkSch','=',$id)->first();

            // dd($mdata);
        }
        if (request()->ajax()) {
            return \View::make('admin.schools.viewSchool')->with('mdata', $mdata)->renderSections();
        }
        return view('admin.schools.viewSchool',['mdata'=>$mdata]);

    }


    public function deleteSchool(Request $request)
    {
      /**
       * Used for Delete Admin School
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $Employee = Employee::where('fkEmpRel', $cid)->get()->count();
            $EmployeesEngagement = EmployeesEngagement::where('fkEenSch', $cid)->get()->count();
            $VillageSchool = VillageSchool::where('fkVscSch', $cid)->get()->count();
            $MainBook = MainBook::where('fkMboSch', $cid)->get()->count();
            //$Attendance = Attendance::where('fkAtdSch', $cid)->get()->count();
            //$PeriodicExam = PeriodicExam::where('fkAtdSch', $cid)->get()->count();
            //$StudentEnrollments = StudentEnrollments::where('fkSenSch', $cid)->get()->count();
            //$ClassCreation = ClassCreation::where('fkAtdSch', $cid)->get()->count();
            //$PeriodicExam = PeriodicExam::where('fkAtdSch', $cid)->get()->count();
            if($Employee != 0 || $MainBook != 0 || $EmployeesEngagement != 0 || $VillageSchool != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_school_delete_prompt'] ?? "Sorry, the selected school cannot be deleted as it already has employees, village schools, mainbook";
            }else{
        		School::where('pkSch', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_school_delete_success'] ?? "School Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }


}