<?php
/**
* SubAdminController 
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
use App\Models\Employee;
use App\Models\Country;
use App\Models\State;
use App\Models\Canton;
use App\Models\Student;
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

    public function subAdmins(Request $request)
    {
        /**
         * Used for Admin Ministries
         * @return redirect to Admin->Ministries
         */
        if (request()->ajax()) {
            return \View::make('admin.subAdmins.subAdmins')->renderSections();
        }
        return view('admin.subAdmins.subAdmins');
    }

    public function addSubAdmin(Request $request)
    {
        /**
         * Used for Add Sub Admin
         * @return redirect to Admin->Sub Admin
         */

        $data = Canton::get();
        if (request()->ajax()) {
            return \View::make('admin.subAdmins.addSubAdmin')->with(['data'=>$data])->renderSections();
        }
        return view('admin.subAdmins.addSubAdmin',['data'=>$data]);
    }

    public function addSubAdminPost(Request $request)
    {
      /**
       * Used for Add Admin SubAdminPost
       */
    	$response = [];
        $input = $request->all();
        $image = $request->file('upload_profile');       

        $temp_pass = FrontHelper::generatePassword(10);
  		$verification_key = md5(FrontHelper::generatePassword(20));
  		

        $emailExist = Admin::where('email','=', $input['email'])->get();
        $govIdExist = Admin::where('adm_GovId','=',$input['adm_GovId'])->get();
        $emailEmpExist = Employee::where('email', '=', $input['email'])->get();
        $checkPrev = Admin::where('adm_Name',$input['fname']." ".$input['lname'])->first();
        $emailStuExist = Student::where('email', '=', $input['email'])->orWhere('stu_ParentsEmail', '=', $input['email'])->get();

        $emailExistCount = $emailExist->count();
        $emailStuExistCount = $emailStuExist->count();
        $emailEmpExistCount = $emailEmpExist->count();
        $govIdExistCount = $govIdExist->count();

        if($emailExistCount != 0 || $emailEmpExistCount != 0 || $emailStuExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_email_exist'] ?? 'Email already exist, Please try with a different email';
            return response()->json($response);
            die();
        }

        if($govIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_govt_id_exist'] ?? 'The Government Id already exist, Please try with a different Government Id';
            return response()->json($response);
            die();
        }

        if(!empty($checkPrev)){
          $response['status'] = false;
          $response['message'] = $this->translations['msg_user_exist'] ?? 'User already exists with this name';
          return response()->json($response);
          die();
        }

        $user = new Admin;
        $user->email = $input['email'];
        $user->adm_Name = $input['fname']." ".$input['lname'];
        $user->adm_Phone = $input['adm_Phone'];
        $user->email_verification_key = $verification_key;
        //$user->password = Hash::make($temp_pass);
        $user->adm_Title = $input['adm_Title'];
        $user->adm_GovId = $input['adm_GovId'];
        $user->adm_Gender = $input['adm_Gender'];
        $user->fkAdmCan = $input['fkAdmCan'];
        $user->adm_Status = $input['adm_Status'];
        $user->adm_Address = $input['adm_Address'];
        $user->type = 'MinistrySubAdmin';
        $user->adm_DOB = date('Y-m-d h:i:s',strtotime($input['adm_DOB']));

        if(!empty($image)){
        	$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        	$destinationPath = public_path('/images/users');
        	$image->move($destinationPath, $input['imagename']);
        	$user->adm_Photo = $input['imagename'];
        }
         
        if($user->save()){
			$id = Admin::where('id', $user->id)
	              ->update(['adm_Uid' => "SBA".$user->id]);
            $current_time = date("Y-m-d H:i:s");
            $reset_pass_token = base64_encode($input['email'].'&&MinistrySubAdmin&&'.$current_time);
            $data = ['email' => $input['email'], 'name'=>$input['fname'], 'verify_key'=>$verification_key,'pass'=>$temp_pass,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New Ministry Sub Admin Credentials'];

            $sendmail = MailHelper::sendNewCredentials($data);
                 
            $response['status'] = true;
            $response['message'] = $this->translations['msg_sub_admin_add_success'] ?? "Sub Admin Successfully Added";
            $response['redirect'] = url('/admin/subAdmins');
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }

        return response()->json($response);
    }

    public function getSubAdmins(Request $request)
    {
      /**
       * Used for SubAdmin Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	
	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$admin = new Admin;

    	if($filter){
    		$admin = $admin->where ( 'adm_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'adm_Name', 'LIKE', '%' . $filter . '%' )->orWhere ( 'email', 'LIKE', '%' . $filter . '%' )->orWhere ( 'adm_GovId', 'LIKE', '%' . $filter . '%' );
    	}
    	$adminQuery = $admin->where('type', '=', 'MinistrySubAdmin');

    	if($sort_col != 0){
    		$adminQuery = $adminQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_admins= $adminQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $admindata = [];
	      $admins = $adminQuery->offset($offset)->limit($perpage);
	      $admins = $adminQuery->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($admins as $key => $value) {
	            $value['index']      = $counter+1;
                $value['adm_Statu'] = $value['adm_Status'];
                if($value['adm_Status']=='Active'){
                    $value['adm_Status'] = $this->translations['gn_active'] ?? "Active";
                }
                else{
                    $value['adm_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
                }
	            $admindata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($admindata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $admindata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $admindata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_admins,
			"recordsFiltered" => $total_admins,
	        "data" => $admindata,
	      );

	       return response()->json($result);
    }

    public function editSubAdmin($id)
    {
      /**
       * Used for Edit SubAdmin
       */

    	$response = [];
    	$cantons = Canton::get();
    	$mdata = Admin::where('id',$id)->first();
    	$mdata['cantons'] = $cantons;
    	$name = explode(" ", $mdata->adm_Name);
    	$mdata['fname'] = $name[0];
    	$mdata['lname'] = $name[1];
        if (request()->ajax()) {
            return \View::make('admin.subAdmins.editSubAdmin')->with(['data'=>$mdata])->renderSections();
        }
    	return view('admin.subAdmins.editSubAdmin',['data'=>$mdata]);
    }

    public function viewSubAdmin($id)
    {
      /**
       * Used for View SubAdmin
       */
    	$mdata = '';
    	if(!empty($id)){
    		$mdata = Admin::where('id','=',$id)->where('deleted_at','=',null)->first();
    		$canton = Canton::select('can_CantonName','fkCanSta')->where('pkCan',$mdata->fkAdmCan)->first();
    		$state = State::select('sta_StateName','fkStaCny')->where('pkSta',$canton->fkCanSta)->first();
    		$country = Country::select('cny_CountryName')->where('pkCny',$state->fkStaCny)->first();
    		$mdata['canton'] = $canton->can_CantonName;
    		$mdata['state'] = $state->sta_StateName;
    		$mdata['country'] = $country->cny_CountryName;
    	}
        if (request()->ajax()) {
            return \View::make('admin.subAdmins.viewSubAdmin')->with(['mdata'=>$mdata])->renderSections();
        }
    	return view('admin.subAdmins.viewSubAdmin',['mdata'=>$mdata]);

    }

    public function editSubAdminPost(Request $request)
    {
      /**
       * Used for Edit Admin SubAdminPost
       */
    	$response = [];
    	$input = $request->all();
    	$image = $request->file('upload_profile');  
    	$id = $input['id'];

        $emailExist = Admin::where('email','=', $input['email'])->where('id','!=',$id)->get();
        $govIdExist = Admin::where('adm_GovId','=',$input['adm_GovId'])->where('id','!=',$id)->get();
        $emailEmpExist = Employee::where('email', '=', $input['email'])->get();
        $emailStuExist = Student::where('email', '=', $input['email'])->orWhere('stu_ParentsEmail', '=', $input['email'])->get();

        $emailExistCount = $emailExist->count();
        $emailEmpExistCount = $emailEmpExist->count();
        $emailStuExistCount = $emailStuExist->count();
        $govIdExistCount = $govIdExist->count();

        if($emailExistCount != 0 || $emailEmpExistCount != 0 || $emailStuExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_email_exist'] ?? 'Email already exist, Please try with a different email';
            return response()->json($response);
            die();
        }

        if($govIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_govt_id_exist'] ?? 'The Government Id already exist, Please try with a different Government Id';
            return response()->json($response);
            die();
        }

        $checkPrev = Admin::where('adm_Name',$input['fname']." ".$input['lname'])->where('id','!=',$id)->first();
        if(!empty($checkPrev)){
          $response['status'] = false;
          $response['message'] = $this->translations['msg_user_exist'] ?? 'User already exists with this name';
          return response()->json($response);
          die();
        }

	    $user = Admin::find($id);
        $user->adm_Name = $input['fname']." ".$input['lname'];
        $user->adm_Phone = $input['adm_Phone'];
        $user->adm_Title = $input['adm_Title'];
        $user->adm_GovId = $input['adm_GovId'];
        $user->adm_Gender = $input['adm_Gender'];
        $user->fkAdmCan = $input['fkAdmCan'];
        $user->adm_Status = $input['adm_Status'];
        $user->adm_Address = $input['adm_Address'];
        $user->adm_DOB = date('Y-m-d h:i:s',strtotime($input['adm_DOB']));

        if(!empty($image)){
        	$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        	$destinationPath = public_path('/images/users');
        	$image->move($destinationPath, $input['imagename']);
            if(!empty($user->adm_Photo)){
                $filepath = public_path('/images/users/').$user->adm_Photo;
                if(file_exists($filepath)) {
                   unlink($filepath);
                }
            }
        	$user->adm_Photo = $input['imagename'];
        }

        if($user->email != $input['email']){
            $current_time = date("Y-m-d H:i:s");
            $verification_key = md5(FrontHelper::generatePassword(20));

            $reset_pass_token = base64_encode($input['email'].'&&MinistrySubAdmin&&'.$current_time);
            $data = ['email' => $input['email'], 'name'=>$input['fname']." ".$input['lname'], 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New Ministry Sub Admin Credentials'];

            $sendmail = MailHelper::sendNewCredentials($data);
            $user->email = $input['email'];
            $user->email_verified_at = null;
            $user->email_verification_key = $verification_key;
        }
         
        if($user->save()){
        	$response['status'] = true;
            $response['message'] = $this->translations['msg_sub_admin_update_success'] ?? "Sub Admin Successfully Updated";
            $response['redirect'] = url('/admin/subAdmins');
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }

        return response()->json($response);
    }

    public function deleteSubAdmin(Request $request)
    {
      /**
       * Used for Delete Admin SubAdminPost
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		Admin::where('id', $cid)->where('type','MinistrySubAdmin')
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }


  
}