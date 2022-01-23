<?php
/**
* AdminController 
* 
* @package    Laravel
* @subpackage Controller
* @since      1.0
*/

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Contracts\View\View;
use App\Helpers\FrontHelper;
use App\Helpers\MailHelper;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Country;
use App\Models\State;
use App\Models\Canton;
use Validator;
use Carbon\Carbon;
use Auth;
use Hash;
use View;
use Redirect;

class AdminController extends Controller
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
         * Used for Admin Dashboard
         * @return redirect to Admin->Dashboard
         */

        $user = Auth::guard('admin')->user();
        $SuperAdminCount = 0;
        if($user->type == 'HertronicAdmin' || $user->type == 'MinistryAdmin' || $user->type == 'MinistrySubAdmin'){
            $SuperAdminCount = Admin::where('type','=','HertronicAdmin')->count();
        }
        if (request()->ajax()) {
            return \View::make('admin.dashboard.dashboard')->with(compact('SuperAdminCount'))->renderSections();
        }
        return view('admin.dashboard.dashboard',compact('SuperAdminCount'));
    }

    public function profile(Request $request)
    {
        /**
         * Used for Admin Profile
         * @return redirect to Admin->Profile
         */
        if (request()->ajax()) {
            return \View::make('admin.dashboard.profile')->renderSections();
        }
        return view('admin.dashboard.profile');
    }

    public function editProfile(Request $request){

        $response = [];
        $input = $request->all();
        $image = $request->file('upload_profile');      

        $emailExist = Admin::where('email','=', $input['email'])->where('id','!=', $this->logged_user->id)->get();
        $emailEmpExist = Employee::where('email', '=', $input['email'])->get();
        $govIdExist = Admin::where('adm_GovId','=',$input['govt_id'])->where('id','!=', $this->logged_user->id)->get();

        $emailExistCount = $emailExist->count();
        $emailEmpExistCount = $emailEmpExist->count();
        $govIdExistCount = $govIdExist->count();

        if($emailExistCount != 0 || $emailEmpExistCount != 0){
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

        $checkPrev = Admin::where('adm_Name',$input['name'])->where('id','!=',$this->logged_user->id)->first();
        if(!empty($checkPrev)){
          $response['status'] = false;
          $response['message'] = "Admin already exists with this name";
          return response()->json($response);
          die();
        }

        $user = Admin::findorfail($this->logged_user->id);

        $user->email = $input['email'];
        $user->adm_Name = $input['name'];
        $user->adm_Title = $input['title'];
        $user->adm_Phone = $input['phone'];
        $user->adm_GovId = $input['govt_id'];
        $user->adm_Gender = $input['gender'];
        $user->adm_DOB = date('Y-m-d h:i:s',strtotime($input['dob']));

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
         
        if($user->save()){
        	$this->logged_user = $user;
        	$this->logged_user->type = 'admin';
            //return redirect('logout')->with('success', 'Password Updated Successful');
            $response['status'] = true;
            $response['message'] = $this->translations['msg_profile_update_success'] ?? "Profile Successfully updated";

        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }

        return response()->json($response);
 
    }

    public function fetchContent($slug)
    {
      /**
       * Used for  create slug 
       */
        $response = [];

        $content = '';
        
        if(!empty($slug)){
            $content = View::make('admin.'.$slug.'.'.$slug)->renderSections();
        }
        
        if(!empty($content)){
            $response['status'] = true;
            $response['data'] = $content;
        }else{
            $response['status'] = false;
        }
        return response()->json($response);
    }

   
  
}