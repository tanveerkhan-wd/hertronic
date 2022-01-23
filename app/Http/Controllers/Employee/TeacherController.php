<?php
/**
* TeacherController 
* 
* @package    Laravel
* @subpackage Controller
* @since      1.0
*/

namespace App\Http\Controllers\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FrontHelper;
use App\Helpers\MailHelper;
use App\Models\Admin;
use App\Models\AcademicDegree;
use App\Models\Employee;
use App\Models\Country;
use App\Models\College;
use App\Models\State;
use App\Models\Canton;
use App\Models\QualificationDegree;
use App\Models\EmployeeDesignation;
use App\Models\EmployeesEducationDetail;
use App\Models\EngagementType;
use App\Models\EmployeeType;
use App\Models\EmployeesEngagement;
use App\Models\Municipality;
use App\Models\PostalCode;
use App\Models\School;
use App\Models\Citizenship;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\University;
use Validator;
use Carbon\Carbon;
use Auth;
use Hash;
use Redirect;

class TeacherController extends Controller
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

    public function employees(Request $request)
    {
        /**
         * Used for employees page
         * @return redirect to Admin->employees
         */
        $employeeType = EmployeeType::where('deleted_at',null)->where('epty_Name','!=','SchoolCoordinator')->where('epty_Name','!=','SchoolSubAdmin')->get();
        if (request()->ajax()) {
            return \View::make('employee.employees.employees')->with('employeeType',$employeeType)->renderSections();
        }
        return view('employee.employees.employees',['employeeType'=>$employeeType]);
    }

    public function addEmployee(Request $request)
    {
        /**
         * Used for Add employees
         * @return redirect to employees
         */

        $AcademicDegrees = AcademicDegree::select('pkAcd','acd_AcademicDegreeName_'.$this->current_language.' as acd_AcademicDegreeName')->get();
        $Colleges = College::select('pkCol','col_CollegeName_'.$this->current_language.' as col_CollegeName')->get();
        $Countries = Country::select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName')->get();
        $QualificationDegrees = QualificationDegree::select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName')->get();
        $Municipalities = Municipality::select('pkMun','mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName')->get();
        $PostalCodes = PostalCode::select('pkPof','pof_PostOfficeNumber','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName')->get();
        $Citizenships = Citizenship::select('pkCtz','ctz_CitizenshipName_'.$this->current_language.' as ctz_CitizenshipName')->get();
        $Nationalities = Nationality::select('pkNat','nat_NationalityName_'.$this->current_language.' as nat_NationalityName')->get();
        $Religions = Religion::select('pkRel','rel_ReligionName_'.$this->current_language.' as rel_ReligionName')->get();
        $Universities = University::select('pkUni','uni_UniversityName_'.$this->current_language.' as uni_UniversityName')->get();
        $EmployeeDesignations = EmployeeDesignation::select('pkEde','ede_EmployeeDesignationName_'.$this->current_language.' as ede_EmployeeDesignationName')->get();
        $Schools = School::select('pkSch','sch_SchoolName_'.$this->current_language.' as sch_SchoolName')->get();
        $EngagementTypes = EngagementType::select('pkEty','ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName')->get();

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
        $employeeType  = EmployeeType::select('pkEpty','epty_Name')->where('epty_Name','!=','SchoolSubAdmin')->where('epty_Name','!=','SchoolCoordinator')->get();
        $mainSchool = $mainSchool->fkEenSch;

        if (request()->ajax()) {
            return \View::make('employee.employees.addEmployee')->with(['employeeType'=>$employeeType,'Countries'=>$Countries, 'Municipalities'=>$Municipalities, 'PostalCodes'=>$PostalCodes, 'Citizenships'=>$Citizenships, 'Nationalities'=>$Nationalities, 'Religions'=>$Religions, 'Universities'=>$Universities, 'Colleges'=>$Colleges, 'EmployeeDesignations'=>$EmployeeDesignations, 'QualificationDegrees'=>$QualificationDegrees, 'AcademicDegrees'=>$AcademicDegrees, 'Schools'=>$Schools, 'EngagementTypes'=>$EngagementTypes, 'mainSchool'=>$mainSchool])->renderSections();
        }
        return view('employee.employees.addEmployee',['employeeType'=>$employeeType,'Countries'=>$Countries, 'Municipalities'=>$Municipalities, 'PostalCodes'=>$PostalCodes, 'Citizenships'=>$Citizenships, 'Nationalities'=>$Nationalities, 'Religions'=>$Religions, 'Universities'=>$Universities, 'Colleges'=>$Colleges, 'EmployeeDesignations'=>$EmployeeDesignations, 'QualificationDegrees'=>$QualificationDegrees, 'AcademicDegrees'=>$AcademicDegrees, 'Schools'=>$Schools, 'EngagementTypes'=>$EngagementTypes, 'mainSchool'=>$mainSchool]);
    }

    public function addEmployeePost(Request $request)
    {
      /**
       * Used for Add Employee
       */
    	$response = [];
        $input = $request->all();
        $image = $request->file('upload_profile');       
        $pkSch = $input['sid'];
        // var_dump($input);die();

        $temp_pass = FrontHelper::generatePassword(10);
  		  $verification_key = md5(FrontHelper::generatePassword(20));	

        $emailExist = Employee::where('email','=', $input['email'])->get();
        $govIdExist = Employee::where('emp_EmployeeID','=',$input['emp_EmployeeID'])->get();
        $tempIdExist = Employee::where('emp_TempCitizenId','=',$input['emp_TempCitizenId'])->where('emp_TempCitizenId','!=',null)->get();
        $emailAdmExist = Admin::where('email', '=', $input['email'])->get();
        $checkPrev = Employee::where('emp_EmployeeName',$input['emp_EmployeeName'])->first();

        $emailExistCount = $emailExist->count();
        $emailAdmExistCount = $emailAdmExist->count();
        $tempIdExistCount = $tempIdExist->count();
        $govIdExistCount = $govIdExist->count();

        if($emailExistCount != 0 || $emailAdmExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_email_exist'] ?? 'Email already exist, Please try with a different email';
            return response()->json($response);
            die();
        }

        if($govIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_employee_id_exist'] ?? 'The Employee Id already exists, Please try with a different Employee Id';
            return response()->json($response);
            die();
        }

        if($tempIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_temp_citizen_id_exist'] ?? 'The Temporary Citizen Id already exists, Please try with a different Temp Citizen Id';
            return response()->json($response);
            die();
        }

        if(!empty($checkPrev)){
          $response['status'] = false;
          $response['message'] = $this->translations['msg_user_exist'] ?? 'User already exists with this name';
          return response()->json($response);
          die();
        }

        
        $user = new Employee;
        $user->email = $input['email'];
        $user->emp_EmployeeName = $input['emp_EmployeeName'];
        $user->emp_EmployeeID = $input['emp_EmployeeID'];
        $user->emp_TempCitizenId = $input['emp_TempCitizenId'];
        $user->emp_EmployeeGender = $input['emp_EmployeeGender'];
        $user->emp_DateOfBirth = date('Y-m-d h:i:s',strtotime($input['emp_DateOfBirth']));
        $user->emp_PlaceOfBirth = $input['emp_PlaceOfBirth'];
        $user->emp_Address = $input['emp_Address'];
        $user->emp_PhoneNumber = $input['emp_PhoneNumber'];
        $user->emp_Notes = $input['emp_Notes'];
        $user->fkEmpMun = $input['fkEmpMun'];
        $user->fkEmpPof = $input['fkEmpPof'];
        $user->fkEmpCny = $input['fkEmpCny'];
        $user->fkEmpNat = $input['fkEmpNat'];
        $user->fkEmpRel = $input['fkEmpRel'];
        $user->fkEmpCtz = $input['fkEmpCtz'];
        $user->email_verification_key = $verification_key;

        if(!empty($image)){
            $input['emp_PicturePath'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/users');
            $image->move($destinationPath, $input['emp_PicturePath']);
            $user->emp_PicturePath = $input['emp_PicturePath'];
        }

        $SchoolData = School::select('sch_SchoolName_en')->where('pkSch',$pkSch)->first();
         
        if($user->save()){
            $allowedIn = ['Teacher','Principal','SchoolCoordinator'];
            $EmployeeTypes = EmployeeType::whereIn('epty_Name',$allowedIn)->get();

            $SchoolCoordinator = '';
            $Principal = '';
            $Teacher = '';

            foreach($EmployeeTypes as $k => $v){
                if($v->epty_Name == 'SchoolCoordinator'){
                    $SchoolCoordinator = $v->pkEpty;
                }
                if($v->epty_Name == 'Principal'){
                    $Principal = $v->pkEpty;
                }
                if($v->epty_Name == 'Teacher'){
                    $Teacher = $v->pkEpty;
                }
            }

			      $ee = new EmployeesEngagement;
            $ee->fkEenSch = $pkSch;
            $ee->fkEenEmp = $user->id;
            $ee->fkEenEty = $input['fkEenEty']; 
            $ee->fkEenEpty = $input['fkEenEpty'];
            $ee->een_Notes = $input['een_Notes'];
            $ee->een_WeeklyHoursRate = $input['een_WeeklyHoursRate'];
            $ee->een_DateOfEngagement = date('Y-m-d h:i:s',strtotime($input['start_date']));
            if(isset($input['end_date']) && !empty($input['end_date'])){
                $ee->een_DateOfFinishEngagement = date('Y-m-d h:i:s',strtotime($input['end_date']));
            }
            $ee->save();

            $tdata = $input['total_details'];
            $details = [];
            for ($i=1; $i <=$tdata ; $i++) { 
                $filename = '';
                $image = '';
                if($request->hasFile('eed_DiplomaPicturePath_'.$i)){  
                    $image = $request->file('eed_DiplomaPicturePath_'.$i);
                    $filename = time().$i.'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/files/users');
                    $image->move($destinationPath, $filename);
                }else{
                    $filename = $input['file_name_'.$i];
                }
                $details[] = ['fkEedEmp'=>$user->id, 'fkEedCol'=>$input['fkEedCol_'.$i], 'fkEedUni'=>$input['fkEedUni_'.$i], 'fkEedAcd'=>$input['fkEedAcd_'.$i], 'fkEedQde'=>$input['fkEedQde_'.$i], 'fkEedEde'=>$input['fkEedEde_'.$i], 'eed_ShortTitle'=>$input['eed_ShortTitle_'.$i], 'eed_SemesterNumbers'=>$input['eed_SemesterNumbers_'.$i], 'eed_EctsPoints'=>$input['eed_EctsPoints_'.$i], 'eed_YearsOfPassing'=>$input['eed_YearsOfPassing_'.$i], 'eed_Notes'=>$input['eed_Notes_'.$i], 'eed_PicturePath'=>$filename];
            }
            // var_dump($details);die();

            EmployeesEducationDetail::insert($details);

            $current_time = date("Y-m-d H:i:s");
            $reset_pass_token = base64_encode($input['email'].'&&Teacher&&'.$current_time);
            $data = ['email' => $input['email'], 'name'=>$input['emp_EmployeeName'], 'school'=>$SchoolData->sch_SchoolName_en, 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token];

            if($input['fkEenEpty'] ==  $Principal){
              $data['subject'] = 'New School Principal Credentials';
              $sendmail = MailHelper::sendNewPrincipalCredentials($data);
              EmployeesEngagement::where('fkEenSch', $pkSch)->where('fkEenEpty',$Principal)->where('fkEenEmp','!=', $user->id)->where('een_DateOfFinishEngagement', '=', null)->update(['een_DateOfFinishEngagement'=>date('Y-m-d h:i:s',strtotime($input['start_date']))]);

            }elseif($input['fkEenEpty'] ==  $Teacher){
              $data['subject'] = 'New School Teacher Credentials';
              $sendmail = MailHelper::sendNewTeacherCredentials($data);
            }
                 
            $response['status'] = true;
            $response['message'] = $this->translations['msg_Teacher_add_success'] ?? "Teacher Successfully Added";
            $response['redirect'] = url('/admin/employees');
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }
        // var_dump($response);
        return response()->json($response);
    }

  //   public function getEmployees(Request $request)
  //   {
  //     /**
  //      * Used for Employee listing
  //      */
  //   	$data =$request->all();
	      
	 //    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	 //    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	 //    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	
	 //    $sort_col =  $data['order'][0]['column'];

	 //    $sort_field = $data['columns'][$sort_col]['data'];

  //   	$mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
  //       $mainSchool = $mainSchool->fkEenSch;

  //       $start_date = '';

  //       $end_date = '';

  //       $allowedIn = ['Teacher','Principal','SchoolCoordinator'];
  //       $empType = EmployeeType::select('pkEpty')->whereIn('epty_Name',$allowedIn)->get();

  //       foreach ($empType as $key => $value) {
  //           $allowedTypes[] = $value->pkEpty;
  //       }

  //       $Teacher = Employee::with(["employeesEngagement" => function($q) use ($filter,$allowedTypes,$mainSchool){
  //           $q->where('een_DateOfFinishEngagement', '=', null)->whereIn('fkEenEpty', $allowedTypes)->where('fkEenSch',$mainSchool);
  //           // $q->where('een_DateOfFinishEngagement', '=', null)->whereIn('fkEenEpty', $allowedTypes);
  //       },'employeesEngagement.employeeType','employeesEngagement.engagementType'=> function($query){
  //           $query->select('pkEty', 'ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName');
  //       },
  //       ])->where('id','!=',$this->logged_user->id);

  //       if($filter){
  //           $Teacher = $Teacher->where(function ($query) use ($filter) {
  //               $query->where ( 'emp_EmployeeID', 'LIKE', '%' . $filter . '%' )
  //                   ->orWhere ( 'emp_EmployeeName', 'LIKE', '%' . $filter . '%' )
  //                   ->orWhere ( 'email', 'LIKE', '%' . $filter . '%' );
  //           });   
  //       }

  //   	if($sort_col != 0){
  //   		$Teacher = $Teacher->orderBy($sort_field, $sort_type);
  //   	}


  //       $Teacher = $Teacher->get()->toArray();

  //       $offset = $data['start'];
         
  //       $counter = $offset;
  //       $teacherdata = [];

  //       foreach ($Teacher as $key => $value) {
  //           if(!empty($value['employees_engagement'])){
  //               $value['index']      = $counter+1;
  //               $teacherdata[$counter] = $value;
  //               $counter++;
  //           }
  //       }

  //       $postMain = array_slice($teacherdata,$offset,$perpage);

  //       $total_admins = sizeof($teacherdata);

  //       $price = array_column($teacherdata, 'index');

	 //    if($sort_col == 0){
	 //     	if($sort_type == 'desc'){
	 //     		array_multisort($price, SORT_DESC, $teacherdata);
	 //     	}else{
	 //     		array_multisort($price, SORT_ASC, $teacherdata);
	 //     	}
		// }
	 //      $result = array(
	 //      	"draw" => $data['draw'],
		// 	"recordsTotal" =>$total_admins,
		// 	"recordsFiltered" => $total_admins,
	 //        "data" => $teacherdata,
	 //      );

	 //       return response()->json($result);
  //   }

    public function getEmployees(Request $request)
    {
      /**
       * Used for Employee listing
       */
        $data =$request->all();
        
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    
        $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column'] :'';

        $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] : '';

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
        $mainSchool = $mainSchool->fkEenSch;

        $start_date = '';

        $end_date = '';
        if(isset($data['emp_type']) && !empty($data['emp_type'])){
          $emp_type[] = $data['emp_type'];
        } 
        $allowedIn = isset($data['emp_type']) ? $emp_type :['Teacher','Principal'];
        
        $empType = EmployeeType::select('pkEpty')->whereIn('epty_Name',$allowedIn)->get();

        foreach ($empType as $key => $value) {
            $allowedTypes[] = $value->pkEpty;
        }

        if(isset($data['type']) & empty($filter)){
            $allowedTypes = ['99999999'];
        }

        $Teacher = Employee::with(["employeesEngagement" => function($q) use ($filter,$allowedTypes,$mainSchool){
            $q->where('een_DateOfFinishEngagement', '=', null)->whereIn('fkEenEpty', $allowedTypes)->where('fkEenSch',$mainSchool);
        },'employeesEngagement.employeeType','employeesEngagement.engagementType'=> function($query){
            $query->select('pkEty', 'ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName');
        },
        ])->where('id','!=',$this->logged_user->id);

        
        if($filter){
            $Teacher = $Teacher->where(function ($query) use ($filter) {
                $query->where ( 'emp_EmployeeID', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'emp_TempCitizenId', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'emp_EmployeeName', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'email', 'LIKE', '%' . $filter . '%' );
            });   
        }

        if($sort_col != 0){
            $Teacher = $Teacher->orderBy($sort_field, $sort_type);
        }


        $Teacher = $Teacher->get()->toArray();

        $offset = $data['start'];
         
        $counter = $offset;
        $teacherdata = [];

        foreach ($Teacher as $key => $value) {
            if(!empty($value['employees_engagement'])){
                foreach ($value['employees_engagement'] as $k => $v) {
                    $type = '';
                    $engType = '';
                    if($v['employee_type']['epty_subCatName'] != ''){
                        $type = $v['employee_type']['epty_subCatName'];
                    }else{
                        $type = $v['employee_type']['epty_Name'];
                    }
                    
                    if ($value['emp_Status']=='Active') {
                      $emp_status = $this->translations['gn_active'] ?? "Active";
                    }else{
                      $emp_status = $this->translations['gn_inactive'] ?? "Inactive";
                    }

                    $teacherdata[] = ['index'=>$counter+1,'id'=> $value['id'], 'emp_EmployeeID'=> $value['emp_EmployeeID'], 'type'=>$type, 'engType'=>$v['engagement_type']['ety_EngagementTypeName'], 'eid'=>$v['pkEen'], 'email'=>$value['email'], 'emp_EmployeeName'=>$value['emp_EmployeeName'], 'emp_Status'=>$emp_status];
                    $counter++; 
                }
            }
        }
        //get all employee engage or not engage
        /*foreach ($Teacher as $key => $value) {
            $type1 = [];
                foreach ($value['employees_engagement'] as $k => $v) {
                  if(!empty($value['employees_engagement'])){
                    if($v['employee_type']['epty_subCatName'] != ''){
                        $type = $v['employee_type']['epty_subCatName'];
                    }else{
                        $type = $v['employee_type']['epty_Name'];
                    }
                    $type1[] = $type;
                    if (isset($data['emp_type']) && !empty($data['emp_type']) && empty($data['emp_eng_type'])) {
                      $value['type'] = !empty($type1)?$type1:'';
                      $value['index']      = $counter+1;
                      $teacherdata[$counter] = $value;
                      $counter++;
                    }
                    if ($data['emp_eng_type']==1) {
                      $value['type'] = !empty($type1)?$type1:'';
                      $value['index']      = $counter+1;
                      $teacherdata[$counter] = $value;
                      $counter++; 
                    }
                  }
                }
                
                if(!isset($data['emp_type']) && empty($data['emp_type']) && empty($data['emp_eng_type'])){
                  $value['type'] = !empty($type1)?$type1:'';
                  $value['index']      = $counter+1;
                  $teacherdata[$counter] = $value;
                  $counter++;
                }

                if ($data['emp_eng_type']==2 && empty($value['employees_engagement'])) {
                  $value['type'] = '';
                  $value['index']      = $counter+1;
                  $teacherdata[$counter] = $value;
                  $counter++; 
                }
        }*/
        $postMain = array_slice($teacherdata,$offset,$perpage);

        $total_admins = sizeof($teacherdata);

        $price = array_column($teacherdata, 'index');

        if($sort_col == 0){
            if($sort_type == 'desc'){
                array_multisort($price, SORT_DESC, $teacherdata);
            }else{
                array_multisort($price, SORT_ASC, $teacherdata);
            }
        }
          $result = array(
            "draw" => $data['draw'],
            "recordsTotal" =>$total_admins,
            "recordsFiltered" => $total_admins,
            "data" => $teacherdata,
          );

           return response()->json($result);
    }

    public function getEngageEmployees(Request $request)
    {
      /**
       * Used for Employee listing
       */
        $data =$request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    
        $sort_col =  $data['order'][0]['column'];

        $sort_field = $data['columns'][$sort_col]['data'];

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
        $mainSchool = $mainSchool->fkEenSch;

        $start_date = '';

        $end_date = '';

        if(isset($data['emp_type']) && !empty($data['emp_type'])){
          $emp_type[] = $data['emp_type'];
        } 
        $allowedIn = isset($data['emp_type']) ? $emp_type :['Teacher','Principal','SchoolCoordinator'];

        $empType = EmployeeType::select('pkEpty')->whereIn('epty_Name',$allowedIn)->get();

        foreach ($empType as $key => $value) {
            $allowedTypes[] = $value->pkEpty;
        }

/*        if(isset($data['type']) & empty($filter)){
            $allowedTypes = ['99999999'];
        }*/

        $Teacher = Employee::with(["employeesEngagement" => function($q) use ($filter,$allowedTypes,$mainSchool){
            $q->where('een_DateOfFinishEngagement', '=', null)->whereIn('fkEenEpty', $allowedTypes)->where('fkEenSch',$mainSchool);
        },'employeesEngagement.employeeType','employeesEngagement.engagementType'=> function($query){
            $query->select('pkEty', 'ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName');
        },
        ])->where('id','!=',$this->logged_user->id);

        if (isset($data['emp_type']) && !empty($data['emp_type']) || $data['emp_eng_type']==1){
        
          $Teacher  = $Teacher->whereHas('employeesEngagement', function($query) use ($filter,$allowedTypes,$mainSchool){
              $query->where('een_DateOfFinishEngagement', '=', null)->whereIn('fkEenEpty', $allowedTypes)->where('fkEenSch',$mainSchool);
          });

        }

        

        if($filter){
            $Teacher = $Teacher->where(function ($query) use ($filter) {
                $query->where ( 'emp_EmployeeID', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'emp_EmployeeName', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'email', 'LIKE', '%' . $filter . '%' );
            });   
        }

        if($sort_col != 0){
            $Teacher = $Teacher->orderBy($sort_field, $sort_type);
        }


        $offset = $data['start'];
       
        $counter = $offset;
        $teacherdata = [];
        $Teacher = $Teacher->offset($offset)->limit($perpage);
        
        $Teacher = $Teacher->offset($offset)->limit($perpage)->get()->toArray();
        /*foreach ($Teacher as $key => $value) {
            if(!empty($value['employees_engagement'])){
                foreach ($value['employees_engagement'] as $k => $v) {
                    $type = '';
                    if($v['employee_type']['epty_subCatName'] != ''){
                        $type = $v['employee_type']['epty_subCatName'];
                    }else{
                        $type = $v['employee_type']['epty_Name'];
                    }
                    $teacherdata[] = ['index'=>$counter+1,'id'=> $value['id'], 'emp_EmployeeID'=> $value['emp_EmployeeID'], 'type'=>$type, 'email'=>$value['email'], 'eid'=>$v['pkEen'], 'emp_EmployeeName'=>$value['emp_EmployeeName'], 'emp_Status'=>'Active'];
                    $counter++;
                }
            }
        }*/
        /*foreach ($Teacher as $key => $value) {
            $type1 = [];
            $pkEenId = '';
            if(!empty($value['employees_engagement'])){
                foreach ($value['employees_engagement'] as $k => $v) {
                    if($v['employee_type']['epty_subCatName'] != ''){
                        $type = $v['employee_type']['epty_subCatName'];
                    }else{
                        $type = $v['employee_type']['epty_Name'];
                    }
                    $type1[] = $type;
                    $pkEenId = $v['pkEen'];
                }
            }
            $value['type'] = !empty($type1)?$type1:'Not Engaged';
            $value['eid'] = !empty($pkEenId)?$pkEenId:'';
            $value['index']      = $counter+1;
            $teacherdata[$counter] = $value;
            $counter++;
        }*/
        foreach ($Teacher as $key => $value) {
            $type1 = [];
            $engType = '';
            $engid = '';
            if(!empty($value['employees_engagement'])){
              foreach ($value['employees_engagement'] as $k => $v) {
                if($v['employee_type']['epty_subCatName'] != ''){
                    $type = $v['employee_type']['epty_subCatName'];
                }else{
                    $type = $v['employee_type']['epty_Name'];
                }
                $engType = $v['engagement_type']['ety_EngagementTypeName'];
                $engid = $v['pkEen'];
                $type1[] = $type;
                
                
              }
            }
            if($data['emp_eng_type']!=2) {
              $value['type'] = !empty($type1)?$type1:'';
              $value['engType']      = $engType;
              $value['eid']      = $engid;
              $value['index']      = $counter+1;
              $teacherdata[$counter] = $value;
              $counter++;
            }
            if($data['emp_eng_type']==2 && empty($value['employees_engagement'])) {
              $value['type'] = '';
              $value['engType']      = '';
              $value['eid']      = '';
              $value['index']      = $counter+1;
              $teacherdata[$counter] = $value;
              $counter++; 
            } 
        }
        
        $postMain = array_slice($teacherdata,$offset,$perpage);

        $total_admins = sizeof($teacherdata);

        $price = array_column($teacherdata, 'index');

        if($sort_col == 0){
            if($sort_type == 'desc'){
                array_multisort($price, SORT_DESC, $teacherdata);
            }else{
                array_multisort($price, SORT_ASC, $teacherdata);
            }
        }
          $result = array(
            "draw" => $data['draw'],
            "recordsTotal" =>$total_admins,
            "recordsFiltered" => $total_admins,
            "data" => $teacherdata,
          );

           return response()->json($result);
    }

    public function editEmployee($id)
    {
      /**
       * Used for Edit Employee
       */

    	$response = [];
        $AcademicDegrees = AcademicDegree::select('pkAcd','acd_AcademicDegreeName_'.$this->current_language.' as acd_AcademicDegreeName')->get();
        $Colleges = College::select('pkCol','col_CollegeName_'.$this->current_language.' as col_CollegeName')->get();
        $Countries = Country::select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName')->get();
        $QualificationDegrees = QualificationDegree::select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName')->get();
        $Municipalities = Municipality::select('pkMun','mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName')->get();
        $PostalCodes = PostalCode::select('pkPof','pof_PostOfficeNumber','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName')->get();
        $Citizenships = Citizenship::select('pkCtz','ctz_CitizenshipName_'.$this->current_language.' as ctz_CitizenshipName')->get();
        $Nationalities = Nationality::select('pkNat','nat_NationalityName_'.$this->current_language.' as nat_NationalityName')->get();
        $Religions = Religion::select('pkRel','rel_ReligionName_'.$this->current_language.' as rel_ReligionName')->get();
        $Universities = University::select('pkUni','uni_UniversityName_'.$this->current_language.' as uni_UniversityName')->get();
        $EmployeeDesignations = EmployeeDesignation::select('pkEde','ede_EmployeeDesignationName_'.$this->current_language.' as ede_EmployeeDesignationName')->get();
        $Schools = School::select('pkSch','sch_SchoolName_'.$this->current_language.' as sch_SchoolName')->get();
        $EngagementTypes = EngagementType::select('pkEty','ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName')->get();

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
        $mainSchool = $mainSchool->fkEenSch;

        $employeeType  = EmployeeType::select('pkEpty','epty_Name')->where('epty_Name','!=','SchoolSubAdmin')->where('epty_Name','!=','SchoolCoordinator')->get();
        

        $EmployeesDetail = Employee::with(['employeeEducation'=> function($query){
                //$query->select('pkAcd', 'acd_AcademicDegreeName_'.$this->current_language.' as acd_AcademicDegreeName');
            },
            'employeeEducation.academicDegree'=> function($query){
                $query->select('pkAcd', 'acd_AcademicDegreeName_'.$this->current_language.' as acd_AcademicDegreeName');
            },
            'employeeEducation.college'=> function($query){
                $query->select('pkCol', 'col_CollegeName_'.$this->current_language.' as col_CollegeName');
            },
            'employeeEducation.university'=> function($query){
                $query->select('pkUni', 'uni_UniversityName_'.$this->current_language.' as uni_UniversityName');
            },
            'employeeEducation.university.college'=> function($query){
                // $query->with(['university.college'=> function($q){
                //     $q->select('pkCol', 'col_CollegeName_'.$this->current_language.' as col_CollegeName');
                // }]);
            },
            'employeeEducation.qualificationDegree'=> function($query){
                $query->select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName');
            },
            'employeeEducation.employeeDesignation'=> function($query){
                $query->select('pkEde','ede_EmployeeDesignationName_'.$this->current_language.' as ede_EmployeeDesignationName');
            },
            'municipality'=> function($query){
                $query->select('pkMun', 'mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName');
            },
            'postalCode'=> function($query){
                $query->select('pkPof', 'pof_PostOfficeNumber');
            },
            'country'=> function($query){
                $query->select('pkCny', 'cny_CountryName_'.$this->current_language.' as cny_CountryName');
            },
            'nationality'=> function($query){
                $query->select('pkNat', 'nat_NationalityName_'.$this->current_language.' as nat_NationalityName');
            },
            'religion'=> function($query){
                $query->select('pkRel', 'rel_ReligionName_'.$this->current_language.' as rel_ReligionName');
            },
            'citizenship'=> function($query){
                $query->select('pkCtz', 'ctz_CitizenshipName_'.$this->current_language.' as ctz_CitizenshipName');
            },
            'EmployeesEngagement.engagementType'=> function($query){
                $query->select('pkEty', 'ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName');
            },
            'EmployeesEngagement.school'=> function($query){
                $query->select('pkSch', 'sch_SchoolName_'.$this->current_language.' as sch_SchoolName');
            },
            'EmployeesEngagement.employeeType'=> function($query){
                //$query->select('pkSch', 'sch_SchoolName_'.$this->current_language.' as sch_SchoolName');
            },
            'EmployeesEngagement'=> function($query){
                $query->where('een_DateOfFinishEngagement',null);
            },

        ]);
        $EmployeesDetail = $EmployeesDetail->where('id','=',$id)->first();

        //   $EmployeesDetail = EmployeesEngagement::with(['employee'=> function($query){
        //         //$query->select('pkAcd', 'acd_AcademicDegreeName_'.$this->current_language.' as acd_AcademicDegreeName');
        //     },
        //     'employee.employeeEducation.academicDegree'=> function($query){
        //         $query->select('pkAcd', 'acd_AcademicDegreeName_'.$this->current_language.' as acd_AcademicDegreeName');
        //     },
        //     'employee.employeeEducation.college'=> function($query){
        //         $query->select('pkCol', 'col_CollegeName_'.$this->current_language.' as col_CollegeName');
        //     },
        //     'employee.employeeEducation.university'=> function($query){
        //         $query->select('pkUni', 'uni_UniversityName_'.$this->current_language.' as uni_UniversityName');
        //     },
        //     'employee.employeeEducation.university.college'=> function($query){
        //         // $query->with(['university.college'=> function($q){
        //         //     $q->select('pkCol', 'col_CollegeName_'.$this->current_language.' as col_CollegeName');
        //         // }]);
        //     },
        //     'employee.employeeEducation.qualificationDegree'=> function($query){
        //         $query->select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName');
        //     },
        //     'employee.employeeEducation.employeeDesignation'=> function($query){
        //         $query->select('pkEde','ede_EmployeeDesignationName_'.$this->current_language.' as ede_EmployeeDesignationName');
        //     },
        //     'employee.municipality'=> function($query){
        //         $query->select('pkMun', 'mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName');
        //     },
        //     'employee.postalCode'=> function($query){
        //         $query->select('pkPof', 'pof_PostOfficeNumber');
        //     },
        //     'employee.country'=> function($query){
        //         $query->select('pkCny', 'cny_CountryName_'.$this->current_language.' as cny_CountryName');
        //     },
        //     'employee.nationality'=> function($query){
        //         $query->select('pkNat', 'nat_NationalityName_'.$this->current_language.' as nat_NationalityName');
        //     },
        //     'employee.religion'=> function($query){
        //         $query->select('pkRel', 'rel_ReligionName_'.$this->current_language.' as rel_ReligionName');
        //     },
        //     'employee.citizenship'=> function($query){
        //         $query->select('pkCtz', 'ctz_CitizenshipName_'.$this->current_language.' as ctz_CitizenshipName');
        //     },
        //     'engagementType'=> function($query){
        //         $query->select('pkEty', 'ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName');
        //     },
        //     'school'=> function($query){
        //         $query->select('pkSch', 'sch_SchoolName_'.$this->current_language.' as sch_SchoolName');
        //     },
        //     'employeeType'=> function($query){
        //         //$query->select('pkSch', 'sch_SchoolName_'.$this->current_language.' as sch_SchoolName');
        //     },

        // ]);
        // $EmployeesDetail = $EmployeesDetail->where('pkEen','=',$id)->first();


        //dd($EmployeesDetail);
        /*$allEmpEngagmentData = EmployeesEngagement::where('fkEenSch',$mainSchool)->where('fkEenEmp',$id)->where('deleted_at',null)->get();*/
        if (request()->ajax()) {
            return \View::make('employee.employees.editEmployee')->with(['employeeType'=>$employeeType,'Countries'=>$Countries, 'Municipalities'=>$Municipalities, 'PostalCodes'=>$PostalCodes, 'Citizenships'=>$Citizenships, 'Nationalities'=>$Nationalities, 'Religions'=>$Religions, 'Universities'=>$Universities, 'Colleges'=>$Colleges, 'EmployeeDesignations'=>$EmployeeDesignations, 'QualificationDegrees'=>$QualificationDegrees, 'AcademicDegrees'=>$AcademicDegrees, 'EmployeesDetail'=>$EmployeesDetail, 'Schools'=>$Schools, 'EngagementTypes'=>$EngagementTypes, 'mainSchool'=>$mainSchool])->renderSections();
        }
        return view('employee.employees.editEmployee')->with(['employeeType'=>$employeeType,'Countries'=>$Countries, 'Municipalities'=>$Municipalities, 'PostalCodes'=>$PostalCodes, 'Citizenships'=>$Citizenships, 'Nationalities'=>$Nationalities, 'Religions'=>$Religions, 'Universities'=>$Universities, 'Colleges'=>$Colleges, 'EmployeeDesignations'=>$EmployeeDesignations, 'QualificationDegrees'=>$QualificationDegrees, 'AcademicDegrees'=>$AcademicDegrees, 'EmployeesDetail'=>$EmployeesDetail, 'Schools'=>$Schools, 'EngagementTypes'=>$EngagementTypes, 'mainSchool'=>$mainSchool]);
    }

    public function viewEmployee($id)
    {
      /**
       * Used for View Teacher
       */
        $mdata = '';
        if(!empty($id)){
            /*$mdata = Employee::with('EmployeesEngagement.employeeType','country','EmployeesEngagement.engagementType')->whereHas('EmployeesEngagement', function($q1) use($id){
                $q1->whereHas('employeeType', function ($q2) use($id){
                    // $q2->where('epty_Name', 'SchoolSubAdmin');
                })->where('fkEenEmp',$id);
            })->first();*/
            
            $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
            $mainSchool = $mainSchool->fkEenSch;

            $mdata = Employee::with(['country'=> function($query){
                $query->select('pkCny', 'cny_CountryName_'.$this->current_language.' as cny_CountryName');
            },"employeesEngagement" => function($q) use ($id,$mainSchool){
            $q->where('een_DateOfFinishEngagement', '=', null)->where('fkEenEmp', $id)->where('fkEenSch',$mainSchool);
            },'employeesEngagement.employeeType','employeesEngagement.engagementType'=> function($query){
                $query->select('pkEty', 'ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName');
            },
            ])->where('id',$id)->first();

            /*
            echo"<pre>";
            print_r($mdata);
            die();*/
            

            /*
            $mdata = Employee::with('EmployeesEngagement.employeeType','country','EmployeesEngagement.engagementType')->where('id',$id)->first()->toArray();
            */
            /*$mdata = EmployeesEngagement::with(['employee.country'=> function($query){
                $query->select('pkCny', 'cny_CountryName_'.$this->current_language.' as cny_CountryName');
            },'engagementType'=> function($query){
                $query->select('pkEty', 'ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName');
            },'employeeType'])->where('pkEen',$id)->first();*/

            //dd($mdata);
        }
        if (request()->ajax()) {
            return \View::make('employee.employees.viewEmployee')->with('mdata', $mdata)->renderSections();
        }
        return view('employee.employees.viewEmployee',['mdata'=>$mdata]);

    }

    public function engageEmployee()
    {
      /**
       * Used for Engage Employee
       */

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
        $mainSchool = $mainSchool->fkEenSch;

        $employeeType  = EmployeeType::select('pkEpty','epty_Name')->where('epty_Name','!=','SchoolSubAdmin')->where('epty_Name','!=','SchoolCoordinator')->get();

        $EngagementTypes = EngagementType::select('pkEty','ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName')->get();

        $EmployeeTypes = EmployeeType::where('epty_Name','=','Teacher')->orWhere('epty_Name','=','Principal')->get();


        if (request()->ajax()) {
            return \View::make('employee.employees.engageEmployee')->with(['employeeType'=>$employeeType,'EngagementTypes'=>$EngagementTypes,'EmployeeTypes'=>$EmployeeTypes])->renderSections();
        }
        return view('employee.employees.engageEmployee',['employeeType'=>$employeeType,'EngagementTypes'=>$EngagementTypes,'EmployeeTypes'=>$EmployeeTypes]);

    }

    public function engageEmployeePost(Request $request)
    {
    /**
       * Used for Engage Employee post
       */
        $response = [];
        $input = $request->all();
        
        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
        $mainSchool = $mainSchool->fkEenSch;
        $SchoolData = School::select('sch_SchoolName_en')->where('pkSch',$mainSchool)->first();

        // var_dump($input);die();

        $Principal = EmployeeType::select('pkEpty')->where('epty_Name','=','Principal')->first();

        $Teacher = EmployeeType::select('pkEpty')->where('epty_Name','=','Teacher')->first();

        $EmployeeData = Employee::find($input['eid']);
        
        if (isset($EmployeeData) && $EmployeeData->emp_EmployeeID==null && $EmployeeData->emp_EmployeeID==null) {
            
            $response['status'] = false;
            $response['message'] = $this->translations['msg_id_does_not_exist'] ?? 'Employee Id Does Not exists';
            return response()->json($response);
            die();
        }

        $data = ['email' => $EmployeeData->email, 'name'=>$EmployeeData->emp_EmployeeName, 'school'=>$SchoolData->sch_SchoolName_en];

        // $ee = EmployeesEngagement::where('fkEenSch', $mainSchool)->where('fkEenEpty',$input['fkEenEpty'])->where('fkEenEmp',$input['eid'])->where('een_DateOfFinishEngagement', '=', null)->first();
        if ($input['fkEenEpty'] == $Principal->pkEpty) {
          
          EmployeesEngagement::where('fkEenEpty',$input['fkEenEpty'])->where('fkEenSch',$mainSchool)->update(['een_DateOfFinishEngagement'=>date('Y-m-d h:i:s',strtotime($input['start_date']))]);
        }else{
          EmployeesEngagement::where('fkEenEmp',$input['eid'])->where('fkEenEpty',$input['fkEenEpty'])->where('fkEenSch',$mainSchool)->update(['een_DateOfFinishEngagement'=>date('Y-m-d h:i:s',strtotime($input['start_date']))]);

        }

        $ee = new EmployeesEngagement;
        $ee->fkEenSch = $mainSchool;
        $ee->fkEenEmp = $input['eid'];
        $ee->fkEenEty = $input['fkEenEty']; 
        $ee->fkEenEpty = $input['fkEenEpty'];
        $ee->een_WeeklyHoursRate = $input['een_WeeklyHoursRate'];
        $ee->een_notes = $input['een_notes'];
        $ee->een_DateOfEngagement = date('Y-m-d h:i:s',strtotime($input['start_date']));
        if(isset($input['end_date']) && !empty($input['end_date'])){
            $ee->een_DateOfFinishEngagement = date('Y-m-d h:i:s',strtotime($input['end_date']));
        }

        if($ee->save()){
            if($input['fkEenEpty'] == $Principal->pkEpty){
                $data['subject'] = 'New Principal Assign';
                MailHelper::sendNewPrincipalAssign($data);
            }
            if($input['fkEenEpty'] == $Teacher->pkEpty){
                $data['subject'] = 'New Teacher Assign';
                MailHelper::sendNewTeacherAssign($data);
            }
            $response['status'] = true;
            $response['message'] = $this->translations['msg_employee_engage_success'] ?? "Employee successfully engaged";
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }


        return response()->json($response);
        
    }

    public function editEmployeePost(Request $request)
    {
      /**
       * Used for Edit Employee Post
       */
      	$response = [];
        $input = $request->all();
        
        if (isset($input['emp_engagment_id']) && !empty($input['emp_engagment_id'])) {
          
          $inData = [];
          foreach ($input as $key => $value) {
            foreach ($value as $k => $v) {
              $inData[$k][$key] = $v;
            }
          }
          $engData = [];
            
          foreach ($inData as $key => $inDatav) {
          
            $engData['een_DateOfEngagement'] = date('Y-m-d h:i:s',strtotime($inDatav['start_date']));
            $engData['een_WeeklyHoursRate'] = $inDatav['een_WeeklyHoursRate'];
            $engData['fkEenEty'] = $inDatav['fkEenEty'];
            $engData['fkEenEpty'] = $inDatav['fkEenEpty'];
            $engData['een_Notes'] = $inDatav['een_Notes'];
            if(isset($inDatav['end_date']) && !empty($inDatav['end_date'])){
                $engData['een_DateOfFinishEngagement'] = date('Y-m-d h:i:s',strtotime($inDatav['end_date']));
            }else{
                $engData['een_DateOfFinishEngagement'] = null;
            }

            EmployeesEngagement::where('pkEen', $inDatav['emp_engagment_id'])->update($engData);

          }
          if($inDatav['emp_engagment_id']){
          $response['status'] = true;
            $response['message'] = $this->translations['msg_Teacher_update_success'] ?? "Teacher Successfully Updated";
            $response['redirect'] = url('/employee/employees');
          }else{
              $response['status'] = false;
              $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
          }
          return response()->json($response);          

        }
        
        
        $image = $request->file('upload_profile');  
        $id = $input['id'];
        $pkSch = $input['sid'];
        $pkEen = $input['engid'];

        // var_dump($input);die();

        $emailExist = Employee::where('email','=', $input['email'])->where('id','!=',$id)->get();
        $govIdExist = Employee::where('emp_EmployeeID','=',$input['emp_EmployeeID'])->where('id','!=',$id)->get();
        $tempIdExist = Employee::where('emp_TempCitizenId','=',$input['emp_TempCitizenId'])->where('emp_TempCitizenId', '!=', '')->where('id','!=',$id)->get();
        $emailAdmExist = Admin::where('email', '=', $input['email'])->get();
        $checkPrev = Employee::where('emp_EmployeeName',$input['emp_EmployeeName'])->where('id','!=',$id)->first();

        $emailExistCount = $emailExist->count();
        $emailAdmExistCount = $emailAdmExist->count();
        $tempIdExistCount = $tempIdExist->count();
        $govIdExistCount = $govIdExist->count();

        if($emailExistCount != 0 || $emailAdmExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_email_exist'] ?? 'Email already exist, Please try with a different email';
            return response()->json($response);
            die();
        }

        if($govIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_employee_id_exist'] ?? 'The Employee Id already exists, Please try with a different Employee Id';
            return response()->json($response);
            die();
        }

        if($tempIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_temp_citizen_id_exist'] ?? 'The Temporary Citizen Id already exists, Please try with a different Temp Citizen Id';
            return response()->json($response);
            die();
        }

        if(!empty($checkPrev)){
          $response['status'] = false;
          $response['message'] = $this->translations['msg_user_exist'] ?? 'User already exists with this name';
          return response()->json($response);
          die();
        }

        $user = Employee::find($id);
        $user->emp_EmployeeName = $input['emp_EmployeeName'];
        $user->emp_EmployeeID = $input['emp_EmployeeID'];
        $user->emp_TempCitizenId = $input['emp_TempCitizenId'];
        $user->emp_EmployeeGender = $input['emp_EmployeeGender'];
        $user->emp_DateOfBirth = date('Y-m-d h:i:s',strtotime($input['emp_DateOfBirth']));
        $user->emp_PlaceOfBirth = $input['emp_PlaceOfBirth'];
        $user->emp_Address = $input['emp_Address'];
        $user->emp_PhoneNumber = $input['emp_PhoneNumber'];
        $user->emp_Notes = $input['emp_Notes'];
        $user->fkEmpMun = $input['fkEmpMun'];
        $user->fkEmpPof = $input['fkEmpPof'];
        $user->fkEmpCny = $input['fkEmpCny'];
        $user->fkEmpNat = $input['fkEmpNat'];
        $user->fkEmpRel = $input['fkEmpRel'];
        $user->fkEmpCtz = $input['fkEmpCtz'];
        $user->emp_Status = $input['emp_Status'];

        $empType = EmployeeType::select('pkEpty')->where('epty_Name','=','Teacher')->where('epty_ParentId','=',null)->first();
        $SchoolData = School::select('sch_SchoolName_en')->where('pkSch',$pkSch)->first();

        if(!empty($image)){
            $input['emp_PicturePath'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/users');
            $image->move($destinationPath, $input['emp_PicturePath']);
            if(!empty($user->emp_PicturePath)){
                $filepath = public_path('/images/users/').$user->emp_PicturePath;
                if(file_exists($filepath)) {
                   unlink($filepath);
                }
            }
            $user->emp_PicturePath = $input['emp_PicturePath'];
        }

        $tdata = $input['total_details'];
        $details = [];
        for ($i=1; $i <=$tdata ; $i++) { 
            $filename = '';
            $image = '';
            if($request->hasFile('eed_DiplomaPicturePath_'.$i)){  
                $image = $request->file('eed_DiplomaPicturePath_'.$i);
                $filename = time().$i.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/files/users');
                $image->move($destinationPath, $filename);
            }else{
                $filename = $input['file_name_'.$i];
            }
            $details[] = ['fkEedEmp'=>$user->id, 'fkEedCol'=>$input['fkEedCol_'.$i], 'fkEedUni'=>$input['fkEedUni_'.$i], 'fkEedAcd'=>$input['fkEedAcd_'.$i], 'fkEedQde'=>$input['fkEedQde_'.$i], 'fkEedEde'=>$input['fkEedEde_'.$i], 'eed_ShortTitle'=>$input['eed_ShortTitle_'.$i], 'eed_SemesterNumbers'=>$input['eed_SemesterNumbers_'.$i], 'eed_EctsPoints'=>$input['eed_EctsPoints_'.$i], 'eed_YearsOfPassing'=>$input['eed_YearsOfPassing_'.$i], 'eed_Notes'=>$input['eed_Notes_'.$i], 'eed_PicturePath'=>$filename];
        }
        // var_dump($details);die();
        EmployeesEducationDetail::where('fkEedEmp', $id)->update(['deleted_at' => now()]);

        EmployeesEducationDetail::insert($details);

        if($user->email != $input['email']){
            $current_time = date("Y-m-d H:i:s");
            $verification_key = md5(FrontHelper::generatePassword(20));

            $reset_pass_token = base64_encode($input['email'].'&&Teacher&&'.$current_time);
            $data = ['email' => $input['email'], 'name'=>$input['emp_EmployeeName'], 'school'=>$SchoolData->sch_SchoolName_en, 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New School Teacher Credentials'];

            $sendmail = MailHelper::sendNewTeacherCredentials($data);

            $user->email = $input['email'];
            $user->email_verified_at = null;
            $user->email_verification_key = $verification_key;
        }

        /*$engData = [];

        $engData['een_DateOfEngagement'] = date('Y-m-d h:i:s',strtotime($input['start_date']));
        $engData['een_WeeklyHoursRate'] = $input['een_WeeklyHoursRate'];
        $engData['fkEenEty'] = $input['fkEenEty'];
        $engData['fkEenEpty'] = $input['fkEenEpty'];
        $engData['een_Notes'] = $input['een_Notes'];
        if(isset($input['end_date']) && !empty($input['end_date'])){
            $engData['een_DateOfFinishEngagement'] = date('Y-m-d h:i:s',strtotime($input['end_date']));
        }else{
            $engData['een_DateOfFinishEngagement'] = null;
        }*/

        // EmployeesEngagement::where('fkEenSch', $pkSch)->where('fkEenSch', $pkSch)->where('fkEenEmp', $id)->where('fkEenEpty', $empType->pkEpty)
        //               ->update($engData);

        /*EmployeesEngagement::where('pkEen', $pkEen)
                      ->update($engData);*/
         
        if($user->save()){
        	$response['status'] = true;
            $response['message'] = $this->translations['msg_Teacher_update_success'] ?? "Teacher Successfully Updated";
            $response['redirect'] = url('/employee/employees');
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }

        return response()->json($response);
    }

    public function deleteEmployee(Request $request)
    {
      /**
       * Used for Delete Employee
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		Employee::where('id', $cid)->where('type','TeacherAdmin')
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }


  
}