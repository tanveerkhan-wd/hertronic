<?php
/**
* StudentController 
* 
* @package    Laravel
* @subpackage Controller
* @since      1.0
*/

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FrontHelper;
use App\Helpers\MailHelper;
use App\Models\Employee;
use App\Models\Admin;
use App\Models\AcademicDegree;
use App\Models\College;
use App\Models\Country;
use App\Models\State;
use App\Models\Canton;
use App\Models\QualificationDegree;
use App\Models\EmployeeDesignation;
use App\Models\EmployeesEducationDetail;
use App\Models\EmployeesEngagement;
use App\Models\EngagementType;
use App\Models\EmployeeType;
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
use Session;
use Hash;
use View;
use Redirect;

class StudentController extends Controller
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

    public function dashboard(Request $request)
    {
        /**
         * Used for Dashboard
         * @return redirect to Student->Dashboard
         */

        $SubAdminCount = 0;
        $view = '';

        if($this->logged_user->type=='Student'){
            $data['SubAdminCount'] = $SubAdminCount;
            $view = 'student.dashboard.dashboard';
        }
        if (request()->ajax()) {
            return \View::make($view)->with($data)->renderSections();
        }

        return view($view,$data);
    }

    public function profile(Request $request)
    {
        /**
         * Used for Profile
         * @return redirect to Employee->Profile
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

        $schoolDetail = Employee::with('EmployeesEngagement','EmployeesEngagement.employeeType')->whereHas('EmployeesEngagement', function($query) {
            $query->whereHas('employeeType', function ($query) {
                $query->where('epty_Name', 'SchoolCoordinator')->orWhere('epty_Name', 'SchoolSubAdmin')->orWhere('epty_Name', 'Teacher');
            })->where('fkEenEmp',$this->logged_user->id)->where(function ($query){
                $query->where('een_DateOfFinishEngagement', '=', null)
                    ->orWhere('een_DateOfFinishEngagement', '>=', now());
            });  
        })->first();

        $mainSchool = $schoolDetail->EmployeesEngagement[0]->fkEenSch;
        $EngagementTypes = EngagementType::select('pkEty','ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName')->get();

        $allowedIn = ['Teacher','Principal','SchoolCoordinator'];
        $EmployeeTypes = EmployeeType::whereIn('epty_Name',$allowedIn)->get();

        $currentEmpType = EmployeeType::where('epty_Name',$this->logged_user->type)->first();

        $EmployeesEngagements = EmployeesEngagement::where('fkEenEmp',$this->logged_user->id)->where('fkEenSch',$mainSchool)->where('een_DateOfFinishEngagement',null)->where('fkEenEpty','!=',$currentEmpType->pkEpty)->get();

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

        ]);
        $EmployeesDetail = $EmployeesDetail->where('id','=',$this->logged_user->id)->first();

        //dd($EmployeesEngagements);

        if (request()->ajax()) {
            return \View::make('employee.dashboard.profile')->with(['Countries'=>$Countries, 'Municipalities'=>$Municipalities, 'PostalCodes'=>$PostalCodes, 'Citizenships'=>$Citizenships, 'Nationalities'=>$Nationalities, 'Religions'=>$Religions, 'Universities'=>$Universities, 'Colleges'=>$Colleges, 'EmployeeDesignations'=>$EmployeeDesignations, 'QualificationDegrees'=>$QualificationDegrees, 'AcademicDegrees'=>$AcademicDegrees, 'EmployeesDetail'=>$EmployeesDetail, 'EngagementTypes'=>$EngagementTypes, 'EmployeesEngagements'=>$EmployeesEngagements, 'EmployeeTypes'=>$EmployeeTypes, 'currentEmpType'=>$currentEmpType->pkEpty, 'MainSchool'=>$mainSchool])->renderSections();
        }
        return view('employee.dashboard.profile')->with(['Countries'=>$Countries, 'Municipalities'=>$Municipalities, 'PostalCodes'=>$PostalCodes, 'Citizenships'=>$Citizenships, 'Nationalities'=>$Nationalities, 'Religions'=>$Religions, 'Universities'=>$Universities, 'Colleges'=>$Colleges, 'EmployeeDesignations'=>$EmployeeDesignations, 'QualificationDegrees'=>$QualificationDegrees, 'AcademicDegrees'=>$AcademicDegrees, 'EmployeesDetail'=>$EmployeesDetail, 'EngagementTypes'=>$EngagementTypes, 'EmployeesEngagements'=>$EmployeesEngagements, 'EmployeeTypes'=>$EmployeeTypes, 'currentEmpType'=>$currentEmpType->pkEpty, 'MainSchool'=>$mainSchool]);
    }

    public function editProfile(Request $request){

        $response = [];
        $input = $request->all();
        $image = $request->file('upload_profile');    

        // var_dump($image);
        // var_dump($input);die();   

        $emailExist = Employee::where('email','=', $input['email'])->where('id','!=',$this->logged_user->id)->get();
        $govIdExist = Employee::where('emp_EmployeeID','=',$input['emp_EmployeeID'])->where('id','!=',$this->logged_user->id)->get();
        $tempIdExist = Employee::where('emp_TempCitizenId','=',$input['emp_TempCitizenId'])->where('emp_TempCitizenId','!=','')->where('id','!=',$this->logged_user->id)->get();
        $emailAdmExist = Admin::where('email', '=', $input['email'])->get();
        $checkPrev = Employee::where('emp_EmployeeName',$input['emp_EmployeeName'])->where('id','!=',$this->logged_user->id)->first();

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

        $user = Employee::findorfail($this->logged_user->id);

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
         
        if($user->save()){
        	$this->logged_user = $user;
        	$this->logged_user->utype = 'employee';
            $mdata = Employee::with('employeesEngagement.employeeType')->where('id','=',$this->logged_user->id)->first();
            $this->logged_user->type = $mdata->employeesEngagement[0]->employeeType->epty_Name;
            //return redirect('logout')->with('success', 'Password Updated Successful');
            $response['status'] = true;
            $response['message'] = $this->translations['msg_profile_update_success'] ?? "Profile Successfully updated";

        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }

        return response()->json($response);
 
    }

    public function fetchCollege(Request $request)
    {
      /**
       * Used for Fetching college based on University
       */
        $response = [];

        $data = $request->all();

        $Colleges = College::select('pkCol','col_CollegeName_'.$this->current_language.' as col_CollegeName')->where('fkColUni',$data['cid'])->get();
    
        if(!empty($Colleges)){
            $response['status'] = true;
            $response['data'] = $Colleges;
        }else{
            $response['status'] = false;
        }
        return response()->json($response);
    }


    public function editEducationDetails(Request $request)
    {
     /**
       * Used for Updating employee education details
       */
        $response = [];

        $data = $request->all();
        $tdata = $data['total_details'];
        $details = [];
        for ($i=1; $i <=$tdata ; $i++) { 
            $filename = '';
            $image = '';
            if($request->hasFile('eed_DiplomaPicturePath_'.$i)){  
                $image = $request->file('eed_DiplomaPicturePath_'.$i);
                //$filename = $image->getClientOriginalName();
                $filename = time().$i.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/files/users');
                $image->move($destinationPath, $filename);
            }else{
                $filename = $data['file_name_'.$i];
            }
            $details[] = ['fkEedEmp'=>$this->logged_user->id, 'fkEedCol'=>$data['fkEedCol_'.$i], 'fkEedUni'=>$data['fkEedUni_'.$i], 'fkEedAcd'=>$data['fkEedAcd_'.$i], 'fkEedQde'=>$data['fkEedQde_'.$i], 'fkEedEde'=>$data['fkEedEde_'.$i], 'eed_ShortTitle'=>$data['eed_ShortTitle_'.$i], 'eed_SemesterNumbers'=>$data['eed_SemesterNumbers_'.$i], 'eed_EctsPoints'=>$data['eed_EctsPoints_'.$i], 'eed_YearsOfPassing'=>$data['eed_YearsOfPassing_'.$i], 'eed_Notes'=>$data['eed_Notes_'.$i], 'eed_PicturePath'=>$filename];
        }
        // var_dump($details);die();

        EmployeesEducationDetail::where('fkEedEmp', $this->logged_user->id)->update(['deleted_at' => now()]);

        $id = EmployeesEducationDetail::insert($details);

        if(!empty($id)){
            $response['status'] = true;
            $response['message'] = $this->translations['msg_qualification_update_success'] ?? "Qualification Successfully Updated";
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }
    
        return response()->json($response);
    }

    public function editEngagementDetails(Request $request)
    {
    /**
    * Used for Updating engagment details
    */
        $response = [];
        $data = $request->all();

        $tdata = $data['total_details'];
        $details = [];

        $allowedIn = ['Teacher','Principal','SchoolCoordinator'];
        $EmployeeTypes = EmployeeType::whereIn('epty_Name',$allowedIn)->get();
        $SchoolData = School::select('sch_SchoolName_en')->where('pkSch',$data['sid'])->first();

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

        for ($i=1; $i <=$tdata ; $i++) { 

            // $details[] = ['fkEedEmp'=>$this->logged_user->id, 'fkEedCol'=>$data['fkEedCol_'.$i], 'fkEedUni'=>$data['fkEedUni_'.$i], 'fkEedAcd'=>$data['fkEedAcd_'.$i], 'fkEedQde'=>$data['fkEedQde_'.$i], 'fkEedEde'=>$data['fkEedEde_'.$i], 'eed_ShortTitle'=>$data['eed_ShortTitle_'.$i], 'eed_SemesterNumbers'=>$data['eed_SemesterNumbers_'.$i], 'eed_EctsPoints'=>$data['eed_EctsPoints_'.$i], 'eed_YearsOfPassing'=>$data['eed_YearsOfPassing_'.$i], 'eed_Notes'=>$data['eed_Notes_'.$i], 'eed_PicturePath'=>$filename];
            if($data['fkEenEpty_'.$i] == $Principal){

                $ee = EmployeesEngagement::where('fkEenSch', $data['sid'])->where('fkEenEpty',$Principal)->where('fkEenEmp',$this->logged_user->id)->where('een_DateOfFinishEngagement', '=', null)->first();

                if(!empty($ee)){
                    $ee->fkEenEty = $data['fkEenEty_'.$i]; 
                    $ee->een_WeeklyHoursRate = $data['een_WeeklyHoursRate_'.$i];
                    $ee->een_DateOfEngagement = date('Y-m-d h:i:s',strtotime($data['start_date_'.$i]));
                    $ee->een_Notes = $data['note_'.$i];
                    if(isset($data['end_date_'.$i]) && !empty($data['end_date_'.$i])){
                        $ee->een_DateOfFinishEngagement = date('Y-m-d h:i:s',strtotime($data['end_date_'.$i]));
                    }
                    $ee->save();
                }else{
                    $ee = new EmployeesEngagement;
                    $ee->fkEenSch = $data['sid'];
                    $ee->fkEenEmp = $this->logged_user->id;
                    $ee->fkEenEty = $data['fkEenEty_'.$i]; 
                    $ee->fkEenEpty = $data['fkEenEpty_'.$i];
                    $ee->een_WeeklyHoursRate = $data['een_WeeklyHoursRate_'.$i];
                    $ee->een_DateOfEngagement = date('Y-m-d h:i:s',strtotime($data['start_date_'.$i]));
                    $ee->een_Notes = $data['note_'.$i];
                    if(isset($data['end_date_'.$i]) && !empty($data['end_date_'.$i])){
                        $ee->een_DateOfFinishEngagement = date('Y-m-d h:i:s',strtotime($data['end_date_'.$i]));
                    }
                    $ee->save();

                    EmployeesEngagement::where('fkEenSch', $data['sid'])->where('fkEenEpty',$Principal)->where('pkEen','!=', $ee->id)->where('fkEenEmp','!=', $this->logged_user->id)->where('een_DateOfFinishEngagement', '=', null)->update(['een_DateOfFinishEngagement'=>date('Y-m-d h:i:s',strtotime($data['start_date_'.$i]))]);

                    $dataemp = ['email' => $this->logged_user->email, 'name'=>$this->logged_user->emp_EmployeeName, 'school'=>$SchoolData->sch_SchoolName_en, 'subject'=>'New School Principal Assign'];

                    $sendmail = MailHelper::sendNewPrincipalAssign($dataemp);
                }

            }

            if($data['fkEenEpty_'.$i] == $Teacher){
                $ee = EmployeesEngagement::where('fkEenSch', $data['sid'])->where('fkEenEpty',$Teacher)->where('fkEenEmp',$this->logged_user->id)->where('een_DateOfFinishEngagement', '=', null)->first();

                if(!empty($ee)){
                    $ee->fkEenEty = $data['fkEenEty_'.$i]; 
                    $ee->een_WeeklyHoursRate = $data['een_WeeklyHoursRate_'.$i];
                    $ee->een_DateOfEngagement = date('Y-m-d h:i:s',strtotime($data['start_date_'.$i]));
                    $ee->een_Notes = $data['note_'.$i];
                    if(isset($data['end_date_'.$i]) && !empty($data['end_date_'.$i])){
                        $ee->een_DateOfFinishEngagement = date('Y-m-d h:i:s',strtotime($data['end_date_'.$i]));
                    }
                    $ee->save();
                }else{
                    $ee = new EmployeesEngagement;
                    $ee->fkEenSch = $data['sid'];
                    $ee->fkEenEmp = $this->logged_user->id;
                    $ee->fkEenEty = $data['fkEenEty_'.$i]; 
                    $ee->fkEenEpty = $data['fkEenEpty_'.$i];
                    $ee->een_WeeklyHoursRate = $data['een_WeeklyHoursRate_'.$i];
                    $ee->een_Notes = $data['note_'.$i];
                    $ee->een_DateOfEngagement = date('Y-m-d h:i:s',strtotime($data['start_date_'.$i]));
                    if(isset($data['end_date_'.$i]) && !empty($data['end_date_'.$i])){
                        $ee->een_DateOfFinishEngagement = date('Y-m-d h:i:s',strtotime($data['end_date_'.$i]));
                    }
                    $ee->save();

                    $dataemp = ['email' => $this->logged_user->email, 'name'=>$this->logged_user->emp_EmployeeName, 'school'=>$SchoolData->sch_SchoolName_en, 'subject'=>'New School Teacher Assign'];

                    $sendmail = MailHelper::sendNewTeacherAssign($dataemp);
                }
            }
        }

        //if(!empty($id)){
            $response['status'] = true;
            $response['message'] = $this->translations['msg_work_exp_update_success'] ?? "Work Experience Successfully Updated";
        // }else{
        //     $response['status'] = false;
        //     $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        // }
    
        return response()->json($response);

    }

    public function switchRole(Request $request)
    {
    /**
    * Used for Updating employee role
    */
        $response = [];
        $data = $request->all();

        $this->logged_user->type = $data['role'];
        Session::put('curr_emp_type',$data['role']);
        $response['status'] = true;
        $response['redirect'] = url($this->logged_user->utype.'/dashboard');
        return response()->json($response);

    }
  
}