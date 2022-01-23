<?php
/**
* SchoolCoordinatorController 
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
use App\Models\Employee;
use App\Models\Admin;
use App\Models\AcademicDegree;
use App\Models\College;
use App\Models\Country;
use App\Models\QualificationDegree;
use App\Models\EmployeeType;
use App\Models\EmployeesEngagement;
use App\Models\EmployeeDesignation;
use App\Models\EmployeesEducationDetail;
use App\Models\EngagementType;
use App\Models\Municipality;
use App\Models\PostalCode;
use App\Models\School;
use App\Models\SchoolPhoto;
use App\Models\SchoolPrincipal;
use App\Models\OwnershipType;
use Validator;
use Carbon\Carbon;
use Auth;
use Hash;
use View;
use Redirect;

class SchoolCoordinatorController extends Controller
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

    public function mySchool(Request $request)
    {
        /**
         * Used for My School
         * @return redirect to Employee->My School
         */

        $PostalCodes = PostalCode::select('pkPof','pof_PostOfficeNumber','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName')->get();
        $OwnershipTypes = OwnershipType::select('pkOty', 'oty_OwnershipTypeName_'.$this->current_language.' as oty_OwnershipTypeName')->get();

        $SchoolDetail = School::with('schoolPhoto','postalCode','employeesEngagement.employeeType','employeesEngagement.employee','schoolEducationPlanAssignment.educationPlan.educationProfile','schoolEducationPlanAssignment.educationProgram.parent')
        ->with(['employeesEngagement' => function($query) {
            $query->where('een_DateOfFinishEngagement', '=', null);
        }])
        ->whereHas('employeesEngagement', function($subQuery) {
            $subQuery->whereHas('employeeType', function($q){
                $q->where('epty_Name', 'SchoolCoordinator')->orWhere('epty_Name', 'SchoolSubAdmin');
            })->where('fkEenEmp',$this->logged_user->id);

        })->first();
        
        //dd($SchoolDetail);
        if (request()->ajax()) {
            return \View::make('employee.school.mySchool')->with(['SchoolDetail'=>$SchoolDetail, 'PostalCodes'=>$PostalCodes, 'OwnershipTypes'=>$OwnershipTypes])->renderSections();
        }
        return view('employee.school.mySchool',['SchoolDetail'=>$SchoolDetail, 'PostalCodes'=>$PostalCodes, 'OwnershipTypes'=>$OwnershipTypes]);
    }


    public function mySchoolPost(Request $request){

        $response = [];
        $input = $request->all();
        $image = $request->file('upload_profile');    
        $pkSch = $input['sid'];
        
        if(isset($input['sch_images'])){
            $sch_images = $input['sch_images'];
        }else{
            $sch_images = [];
        }
        //Images which need to be deleted
        if(isset($input['old_img'])){
            $old_imgs = $input['old_img'];
        }else{
            $old_imgs = '';
        }

        // var_dump($image);
        //var_dump($input);die();   

       
       //If basic details are updated
       if(isset($input['sch_SchoolEmail'])){

            $emailExist = School::where('sch_SchoolEmail','=', $input['sch_SchoolEmail'])->where('pkSch','!=',$input['sid'])->get();
            $schoolIdExist = School::where('sch_SchoolId','=',$input['sch_SchoolId'])->where('pkSch','!=',$input['sid'])->get();
            $emailAdmExist = Admin::where('email', '=', $input['sch_SchoolEmail'])->get();
            $emailEmpExist = Employee::where('email', '=', $input['sch_SchoolEmail'])->get();
            $checkPrev = School::where('sch_SchoolName_'.$this->current_language, $input['sch_SchoolName_'.$this->current_language])->where('pkSch','!=',$input['sid'])->first();

            $input['sch_FoundingDate'] = date('Y-m-d h:i:s',strtotime($input['sch_FoundingDate']));
            $emailExistCount = $emailExist->count();
            $emailAdmExistCount = $emailAdmExist->count();
            $emailEmpExistCount = $emailEmpExist->count();
            $schoolIdExistCount = $schoolIdExist->count();

            if($emailExistCount != 0 || $emailAdmExistCount != 0 || $emailEmpExistCount != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_email_exist'] ?? 'Email already exist, Please try with a different email';
                return response()->json($response);
                die();
            }

            if($schoolIdExistCount != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_school_id_exist'] ?? 'The School Id already exists, Please try with a different School Id';
                return response()->json($response);
                die();
            }

            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_school_exist'] ?? 'School already exists with this name';
              return response()->json($response);
              die();
            }

            if(!empty($image)){
                $input['sch_SchoolLogo'] = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/schools');
                $image->move($destinationPath, $input['sch_SchoolLogo']);
                $imgData = School::select('sch_SchoolLogo')->where('pkSch', $input['sid'])->first();
                if(!empty($imgData->sch_SchoolLogo)){
                    $filepath = public_path('/images/schools/').$imgData->sch_SchoolLogo;
                    if(file_exists($filepath)) {
                       unlink($filepath);
                    }
                }
            }
        }

        //If Principal is updated
        if(isset($input['principal_email']) && !empty($input['principal_email']) && $input['sel_exists_employee'] == 'No'){

            $emailExist = School::where('sch_SchoolEmail','=', $input['principal_email'])->get();
            $emailAdmExist = Admin::where('email', '=', $input['principal_email'])->get();
            $emailEmpExist = Employee::where('email', '=', $input['principal_email'])->get();
            $checkPrevAdm = Admin::where('adm_Name', $input['principal_name'])->first();
            $checkPrevEmp = Employee::where('emp_EmployeeName', $input['principal_name'])->first();

            $emailExistCount = $emailExist->count();
            $emailAdmExistCount = $emailAdmExist->count();
            $emailEmpExistCount = $emailEmpExist->count();

            if($emailExistCount != 0 || $emailAdmExistCount != 0 || $emailEmpExistCount != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_email_exist'] ?? 'Email already exist, Please try with a different email';
                return response()->json($response);
                die();
            }

            if(!empty($checkPrevEmp) || !empty($checkPrevAdm)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_user_exist'] ?? 'User already exists with this name';
              return response()->json($response);
              die();
            }

            $verification_key = md5(FrontHelper::generatePassword(20));
            $user = new Employee;
            $user->email = $input['principal_email'];
            $user->emp_EmployeeName = $input['principal_name'];
            $user->email_verification_key = $verification_key;
            $user->save();
            
            $empType = EmployeeType::select('pkEpty')->where('epty_Name','=','Principal')->where('epty_ParentId','=',null)->first();
            $engType = EngagementType::select('pkEty')->where('ety_EngagementTypeName_en','=','Full Time')->first();//Full time
            $current_time = date("Y-m-d H:i:s");


            $ee = new EmployeesEngagement;
            $ee->fkEenSch = $pkSch;
            $ee->fkEenEmp = $user->id;
            $ee->fkEenEty = $engType->pkEty; 
            $ee->fkEenEpty = $empType->pkEpty;
            $ee->een_DateOfEngagement = date('Y-m-d h:i:s',strtotime($input['start_date']));
            $ee->save();

            EmployeesEngagement::where('fkEenSch', $pkSch)->where('fkEenEpty',$empType->pkEpty)->where('pkEen','!=', $ee->id)->where('een_DateOfFinishEngagement', '=', null)->update(['een_DateOfFinishEngagement'=>now()]);

            $reset_pass_token = base64_encode($input['principal_email'].'&&Principal&&'.$current_time);
            $SchoolData = School::select('sch_SchoolName_en')->where('pkSch',$pkSch)->first();

            $data = ['email' => $input['principal_email'], 'name'=>$input['principal_name'], 'school'=>$SchoolData->sch_SchoolName_en, 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New School Principal Credentials'];

            $sendmail = MailHelper::sendNewPrincipalCredentials($data);

        }

        if(isset($input['principal_sel']) && !empty($input['principal_sel']) && $input['sel_exists_employee'] == 'Yes'){

            $empType = EmployeeType::select('pkEpty')->where('epty_Name','=','Principal')->where('epty_ParentId','=',null)->first();
            $engType = EngagementType::select('pkEty')->where('ety_EngagementTypeName_en','=','Full Time')->first();//Full time
            $SchoolData = School::select('sch_SchoolName_en')->where('pkSch',$pkSch)->first();
            $EmpData = Employee::select('emp_EmployeeName', 'email')->where('id',$input['principal_sel'])->first();

            $data = ['email' => $EmpData->email, 'name'=>$EmpData->emp_EmployeeName, 'school'=>$SchoolData->sch_SchoolName_en, 'subject'=>'New School Principal Assign'];

            $sendmail = MailHelper::sendNewPrincipalAssign($data);

            $same_principal_exist = EmployeesEngagement::where('fkEenSch', $pkSch)->where('fkEenEpty','=',$empType->pkEpty)->where('fkEenEmp',$input['principal_sel'])->where('een_DateOfFinishEngagement', '=', null)->get();

            $same_principalCount = $same_principal_exist->count();
            //var_dump($same_principal_exist->toSql(),$same_principal_exist->getBindings ());die();

            if($same_principalCount != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_principal_assign_exist'] ?? "The selected employee is already assigned as Principal to the school";
                return response()->json($response);
                die();
            }


            $ee = new EmployeesEngagement;
            $ee->fkEenSch = $pkSch;
            $ee->fkEenEmp = $input['principal_sel'];
            $ee->fkEenEty = $engType->pkEty; 
            $ee->fkEenEpty = $empType->pkEpty;
            $ee->een_DateOfEngagement = date('Y-m-d h:i:s',strtotime($input['start_date']));
            $ee->save();

            EmployeesEngagement::where('fkEenSch', $pkSch)->where('fkEenEpty',$empType->pkEpty)->where('pkEen','!=', $ee->id)->where('een_DateOfFinishEngagement', '=', null)->update(['een_DateOfFinishEngagement'=>now()]);
        }

        if(!empty($old_imgs)){
            $old_imgs = explode(",", $old_imgs);
            $oldImgData = SchoolPhoto::whereIn('pkSph',$old_imgs)->get();
            foreach ($oldImgData as $key => $value) {
                $filepath = public_path('/images/schools/').$value->sph_SchoolPhoto;
                if(file_exists($filepath)) {
                   unlink($filepath);
                }
            }
            $oldImgData = SchoolPhoto::whereIn('pkSph',$old_imgs)->forceDelete();
        }

        if(!empty($sch_images))
        {
            $images = [];
            foreach($sch_images as $key => $image)
            {
                $destinationPath = public_path('/images/schools');
                $filename = time().$key.'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);
                $images[] = ['fkSphSch'=>$pkSch,'sph_SchoolPhoto'=>$filename]; 
            }
            if(!empty($images)){
                $iupdate = SchoolPhoto::insert($images);
            }
        }

        unset($input['sel_exists_employee']);
        unset($input['start_date']);
        unset($input['end_date']);
        unset($input['principal_sel']);
        unset($input['principal_name']);
        unset($input['principal_email']);
        // unset($input['sch_SchoolEmail']);
        unset($input['old_img']);
        unset($input['deleted_file_ids']);
        unset($input['school_imgs']);
        unset($input['sch_images']);
        unset($input['upload_profile']);
        unset($input['sid']);

        if(!empty($input)){
            $fupdate = School::where('pkSch', $pkSch)->update($input);
        }

        $response['status'] = true;
        $response['message'] = $this->translations['msg_school_update_success'] ?? "School Successfully updated";

        return response()->json($response);
 
    }
  
  
}