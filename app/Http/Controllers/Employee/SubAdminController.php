<?php
/**
* SubAdminController 
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
use App\Models\Admin;
use App\Models\Employee;
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
use Hash;
use Redirect;

class SubAdminController extends Controller
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

    public function SubAdmins(Request $request)
    {
        /**
         * Used for SubAdmins page
         * @return redirect to Employee->SubAdmins
         */
        if (request()->ajax()) {
            return \View::make('employee.subAdmins.subAdmins')->renderSections();
        }
        return view('employee.subAdmins.subAdmins');
    }

    public function addSubAdmin(Request $request)
    {
        /**
         * Used for Add SubAdmins
         * @return redirect to Employee->SubAdmins
         */
        $EngagementTypes = EngagementType::select('pkEty','ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName')->get();
        $not_show_empType = ['Principal','Teacher','SchoolCoordinator'];
        $employeeType  = EmployeeType::select('pkEpty','epty_Name','epty_subCatName','epty_ParentId')->whereNotIn('epty_Name',$not_show_empType)->get();

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
        $mainSchool = $mainSchool->fkEenSch;

        $Countries = Country::select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName')->get();
        if (request()->ajax()) {
            return \View::make('employee.subAdmins.addSubAdmin')->with(['employeeType'=>$employeeType,'EngagementTypes'=>$EngagementTypes,'Countries'=>$Countries, 'mainSchool'=>$mainSchool])->renderSections();
        }
        return view('employee.subAdmins.addSubAdmin',['employeeType'=>$employeeType,'EngagementTypes'=>$EngagementTypes,'Countries'=>$Countries, 'mainSchool'=>$mainSchool]);
    }

    public function addSubAdminPost(Request $request)
    {
      /**
       * Used for Add SubAdmin
       */
    	$response = [];
        $input = $request->all();
        $image = $request->file('upload_profile');
        $pkSch = $input['sid'];       

        $temp_pass = FrontHelper::generatePassword(10);
  		$verification_key = md5(FrontHelper::generatePassword(20));

        $emailExist = Employee::where('email','=', $input['email'])->get();
        $govIdExist = Employee::where('emp_EmployeeID','=',$input['emp_EmployeeID'])->get();
        $tempIdExist = Employee::where('emp_TempCitizenId','=',$input['emp_TempCitizenId'])->where('emp_TempCitizenId', '!=', '')->get();
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
        $user->emp_Status = $input['emp_Status'];
        $user->emp_Notes = $input['emp_Notes'];
        $user->fkEmpCny = $input['fkEmpCny'];
        $user->email_verification_key = $verification_key;

        if(!empty($image)){
            $input['emp_PicturePath'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/users');
            $image->move($destinationPath, $input['emp_PicturePath']);
            $user->emp_PicturePath = $input['emp_PicturePath'];
        }

        $empType = EmployeeType::select('pkEpty')->where('epty_Name','=','SchoolSubAdmin')->where('epty_ParentId','=',null)->first();
        $engType = EngagementType::select('pkEty')->where('ety_EngagementTypeName_en','=','Full Time')->first();//Full time
        $SchoolData = School::select('sch_SchoolName_en')->where('pkSch',$pkSch)->first();
         
        if($user->save()){

            $ee = new EmployeesEngagement;
            $ee->fkEenSch = $pkSch;
            $ee->fkEenEmp = $user->id;
            $ee->fkEenEty = !empty($input['fkEenEty']) ?$input['fkEenEty']: $engType->pkEty; 
            $ee->fkEenEpty = !empty($input['fkEenEpty']) ?$input['fkEenEpty']:$empType->pkEpty;
            $ee->een_WeeklyHoursRate = !empty($input['een_WeeklyHoursRate']) ?$input['een_WeeklyHoursRate']:'';
            $ee->een_DateOfEngagement = date('Y-m-d h:i:s',strtotime($input['start_date']));
            if(isset($input['end_date']) && !empty($input['end_date'])){
                $ee->een_DateOfFinishEngagement = date('Y-m-d h:i:s',strtotime($input['end_date']));
            }
            $ee->een_Notes = !empty($input['een_Notes']) ? $input['een_Notes']:'';
            $ee->save();

            $current_time = date("Y-m-d H:i:s");
            $reset_pass_token = base64_encode($input['email'].'&&SchoolSubAdmin&&'.$current_time);
            $data = ['email' => $input['email'], 'name'=>$input['emp_EmployeeName'], 'school'=>$SchoolData->sch_SchoolName_en, 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New School Sub Admin Credentials'];

            $sendmail = MailHelper::sendNewSchoolSubAdminCredentials($data);
                 
            $response['status'] = true;
            $response['message'] = $this->translations['msg_sub_admin_add_success'] ?? "Sub Admin Successfully Added";

        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }

        // var_dump($response);
        return response()->json($response);
    }

    public function getSubAdmins(Request $request)
    {
      /**
       * Used for School SubAdmin listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	
	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
        $mainSchool = $mainSchool->fkEenSch;

        $start_date = $data['start_date'];

        $end_date = $data['end_date'];

        $schoolAdmin = Employee::with('EmployeesEngagement.employeeType')->whereHas('EmployeesEngagement', function($q1) use($mainSchool, $start_date, $end_date){
            $q1->whereHas('employeeType', function ($q2) use($mainSchool){
                $q2->where('epty_Name', 'SchoolSubAdmin');
            })->where('fkEenSch',$mainSchool);

            if($start_date && !$end_date){
                $q1->whereDate('een_DateOfEngagement','=',date('Y-m-d',strtotime($start_date)));
            }

            if($end_date && !$start_date){
                $q1->whereDate('een_DateOfFinishEngagement','=',date('Y-m-d',strtotime($end_date)));
            }

            if($start_date && $end_date){
                $q1->whereDate('een_DateOfEngagement','>=',date('Y-m-d',strtotime($start_date)))->whereDate('een_DateOfFinishEngagement','<=',date('Y-m-d',strtotime($end_date)));
            }
        });

    	if($filter){
            $schoolAdmin = $schoolAdmin->where(function ($query) use ($filter) {
                $query->where ( 'emp_EmployeeID', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'email', 'LIKE', '%' . $filter . '%' );
            });   
    	}

    	$schoolAdminQuery = $schoolAdmin;

    	if($sort_col != 0){
    		$schoolAdminQuery = $schoolAdmin->orderBy($sort_field, $sort_type);
    	}

    	$total_admins= $schoolAdminQuery->count();

    	$offset = $data['start'];
	     
	    $counter = $offset;
	    $schoolAdmindata = [];
	    $schoolAdmins = $schoolAdminQuery->offset($offset)->limit($perpage);
	      // var_dump($countries->toSql(),$countries->getBindings());
	    $schoolAdmins = $schoolAdminQuery->offset($offset)->limit($perpage)->get()->toArray();
        
        foreach ($schoolAdmins as $key => $value) {
            $value['index']      = $counter+1;
            $value['end_date'] = '';
            $value['start_date'] = '';
            if(!empty($value['employees_engagement'][0]['een_DateOfEngagement'])){
                $value['start_date'] = date('m/d/Y',strtotime($value['employees_engagement'][0]['een_DateOfEngagement']));
            }
            if(!empty($value['employees_engagement'][0]['een_DateOfFinishEngagement'])){
                $value['end_date'] = date('m/d/Y',strtotime($value['employees_engagement'][0]['een_DateOfFinishEngagement']));
            }
            if ($value['emp_Status']=='Active') {
              $value['emp_Status'] = $this->translations['gn_active'] ?? "Active";
            }else{
              $value['emp_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
            }

            $schoolAdmindata[$counter] = $value;
            $counter++;
        }

	    $price = array_column($schoolAdmindata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $schoolAdmindata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $schoolAdmindata);
	     	}
		}
	      
        $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_admins,
			"recordsFiltered" => $total_admins,
	        "data" => $schoolAdmindata,
	    );

	    return response()->json($result);
    }

    public function editSubAdmin($id)
    {
      /**
       * Used for Edit School SubAdmin
       */

    	$response = [];

        $EngagementTypes = EngagementType::select('pkEty','ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName')->get();
        $not_show_empType = ['Principal','Teacher','SchoolCoordinator'];
        $employeeType  = EmployeeType::select('pkEpty','epty_Name','epty_subCatName','epty_ParentId')->whereNotIn('epty_Name',$not_show_empType)->get();

        $mdata = Employee::with('EmployeesEngagement.employeeType')->whereHas('EmployeesEngagement', function($q1) use($id){
            $q1->whereHas('employeeType', function ($q2) use($id){
                $q2->where('epty_Name', 'SchoolSubAdmin');
            })->where('fkEenEmp',$id);
        })->first();

        $Countries = Country::select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName')->get();

        if (request()->ajax()) {
            return \View::make('employee.subAdmins.editSubAdmin')->with(['employeeType'=>$employeeType,'EngagementTypes'=>$EngagementTypes,'Countries'=>$Countries, 'mdata'=>$mdata])->renderSections();
        }
        return view('employee.subAdmins.editSubAdmin',['employeeType'=>$employeeType,'EngagementTypes'=>$EngagementTypes,'Countries'=>$Countries, 'mdata'=>$mdata]);
    }

    public function viewSubAdmin($id)
    {
      /**
       * Used for View School SubAdmin
       */
    	$mdata = '';
    	/*if(!empty($id)){
    		$mdata = Employee::with('EmployeesEngagement.employeeType','country')->whereHas('EmployeesEngagement', function($q1) use($id){
                $q1->whereHas('employeeType', function ($q2) use($id){
                    $q2->where('epty_Name', 'SchoolSubAdmin');
                })->where('fkEenEmp',$id);
            })->first()->toArray();
        }*/
        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
            $mainSchool = $mainSchool->fkEenSch;

            $mdata = Employee::with(['country'=> function($query){
                $query->select('pkCny', 'cny_CountryName_'.$this->current_language.' as cny_CountryName');
            },"employeesEngagement" => function($q) use ($id,$mainSchool){
            $q->where('fkEenEmp', $id)->where('fkEenSch',$mainSchool);
            },'employeesEngagement.employeeType','employeesEngagement.engagementType'=> function($query){
                $query->select('pkEty', 'ety_EngagementTypeName_'.$this->current_language.' as ety_EngagementTypeName');
            },
            ])->where('id',$id)->first();
        

        if (request()->ajax()) {
            return \View::make('employee.subAdmins.viewSubAdmin')->with('mdata', $mdata)->renderSections();
        }
    	return view('employee.subAdmins.viewSubAdmin',['mdata'=>$mdata]);

    }

    public function editSubAdminPost(Request $request)
    {
      /**
       * Used for Edit School SubAdminPost
       */
    	$response = [];
    	$input = $request->all();
    	$image = $request->file('upload_profile');  
    	$id = $input['id'];
        $pkSch = $input['sid'];

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
        $user->emp_Status = $input['emp_Status'];
        $user->emp_Notes = $input['emp_Notes'];
        $user->fkEmpCny = $input['fkEmpCny'];

        $empType = EmployeeType::select('pkEpty')->where('epty_Name','=','SchoolSubAdmin')->where('epty_ParentId','=',null)->first();
        $engType = EngagementType::select('pkEty')->where('ety_EngagementTypeName_en','=','Full Time')->first();//Full time
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

        if($user->email != $input['email']){
            $current_time = date("Y-m-d H:i:s");
            $verification_key = md5(FrontHelper::generatePassword(20));

            $reset_pass_token = base64_encode($input['email'].'&&SchoolSubAdmin&&'.$current_time);
            $data = ['email' => $input['email'], 'name'=>$input['emp_EmployeeName'], 'school'=>$SchoolData->sch_SchoolName_en, 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New School Sub Admin Credentials'];

            $sendmail = MailHelper::sendNewSchoolSubAdminCredentials($data);

            $user->email = $input['email'];
            $user->email_verified_at = null;
            $user->email_verification_key = $verification_key;
        }

        $engData = [];

        $engData['fkEenEpty'] = $input['fkEenEpty'];
        $engData['een_WeeklyHoursRate'] = $input['een_WeeklyHoursRate'];
        $engData['fkEenEty'] = $input['fkEenEty'];
        $engData['een_Notes'] = $input['een_Notes'];

        $engData['een_DateOfEngagement'] = date('Y-m-d h:i:s',strtotime($input['start_date']));
        if(!empty($input['end_date'])){
            $engData['een_DateOfFinishEngagement'] = date('Y-m-d h:i:s',strtotime($input['end_date']));
        }else{
            $engData['een_DateOfFinishEngagement'] = null;
        }

        $endfg = EmployeesEngagement::where('pkEen',$input['emp_engagment_id'])->update($engData);

        if($user->save()){
        	$response['status'] = true;
            $response['message'] = $this->translations['msg_sub_admin_update_success'] ?? "Sub Admin Successfully Updated";
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }

        return response()->json($response);
    }

    public function deleteSubAdmin(Request $request)
    {
      /**
       * Used for Delete School SubAdmin
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		Employee::where('id', $cid)->update(['deleted_at' => now()]);
            EmployeesEngagement::where('fkEenEmp', $cid)->update(['deleted_at' => now()]);
    		$response['status'] = true;
            $response['message'] = $this->translations['msg_admin_staff_delete_success'] ?? "Admin staff successfully deleted";;
    	}

    	return response()->json($response);
    }


  
}