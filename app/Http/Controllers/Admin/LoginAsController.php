<?php
/**
* LoginAsController 
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
use App\Models\EmployeesEngagement;
use App\Models\EmployeeType;
use Validator;
use Carbon\Carbon;
use Auth;
use Hash;
use View;
use Redirect;
use Session;

class LoginAsController extends Controller
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

    public function loginAs(Request $request)
    {
        /**
         * Used for Admin Login As
         * @return redirect to Admin->Login As
         */
        if (request()->ajax()) {
            return \View::make('admin.loginAs.loginAs')->renderSections();
        }
        return view('admin.loginAs.loginAs');
    }

    public function getLoginAs(Request $request)
    {
      /**
       * Used for Login as listing
       */
        $data = $request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    
        $sort_col =  $data['order'][0]['column'];

        $sort_field = $data['columns'][$sort_col]['data'];

        $role_filter = $data['role'];

        $admin = new Admin;

        if($filter){

            $admin = $admin->Where(function ($query) use ($filter) {
                $query->where ( 'adm_Uid', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'email', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'adm_Name', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'adm_GovId', 'LIKE', '%' . $filter . '%' );
                });   
            
        }
        $admin = $admin->where('type', '!=', 'HertronicAdmin')->where('type', '!=', 'MinistrySubAdmin');

        //var_dump($admin->toSql(),$admin->getBindings());

        if($role_filter){
            $admin = $admin->where('type','=',$role_filter);
        }

        if($sort_col != 0){
            $admin = $admin->orderBy($sort_field, $sort_type);
        }

        //$total_admins= $adminQuery->count();

          $offset = $data['start'];
         
          $counter = $offset;
          $admindata = [];
          $admins = $admin->get()->toArray();
          // $admins = $adminQuery->offset($offset)->limit($perpage);
          // $admins = $adminQuery->offset($offset)->limit($perpage)->get()->toArray();

        foreach ($admins as $key => $value) {
            $value['index']      = $counter+1;
            $admindata[$counter] = $value;
            $counter++;
        }

        $empType = EmployeeType::select('pkEpty')->where('epty_Name','=','Principal')->orWhere('epty_Name','=','SchoolSubAdmin')->where('epty_ParentId','=',null)->get();

        foreach ($empType as $key => $value) {
            $notAllowedTypes[] = $value->pkEpty;
        }

        //var_dump($empType);

        // $mdata = Employee::with('employeesEngagement.employeeType')->whereHas('employeesEngagement', function($query) use ($role_filter,$filter){
        //     $query->whereHas('employeeType', function ($query) use ($role_filter,$filter,$notAllowedTypes){
        //         if($role_filter){
        //             $query->where('epty_Name','=',$role_filter);
        //         }
        //         if($filter){
        //             $query->where( 'email', 'LIKE', '%' . $filter . '%' )
        //             ->orWhere ( 'emp_EmployeeName', 'LIKE', '%' . $filter . '%' );
        //         }
                
        //     })->where('een_DateOfFinishEngagement', '=', null)->whereNotIn('fkEenEpty', $notAllowedTypes);
        // })->get()->toArray();

        $mdata = Employee::with(["employeesEngagement" => function($q) use ($role_filter,$filter,$notAllowedTypes){
            $q->whereHas('employeeType', function ($query) use ($role_filter,$filter,$notAllowedTypes){
                if($role_filter){
                    $query->where('epty_Name','=',$role_filter);
                }
            });
            $q->where('een_DateOfFinishEngagement', '=', null)->whereNotIn('fkEenEpty', $notAllowedTypes);
        },'employeesEngagement.employeeType'=> function($query){
                //$query->select('pkUni', 'uni_UniversityName_'.$this->current_language.' as uni_UniversityName');
        },
        ]);

        if($filter){
            $mdata = $mdata->where(function ($query) use ($filter) {
                $query->where ( 'emp_EmployeeName', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'emp_EmployeeID', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'email', 'LIKE', '%' . $filter . '%' );
            });   
        }

        $mdata = $mdata->get()->toArray();


        $counter1 = count($admins);
        $employeesData = [];

        foreach ($mdata as $key => $value) {
            if(isset($value['employees_engagement'])){
                foreach ($value['employees_engagement'] as $k => $v) {
                    $employeesData[] = ['id'=> $value['id'], 'adm_Uid'=> $value['emp_EmployeeID'], 'type'=>$v['employee_type']['epty_Name'], 'email'=>$value['email'], 'adm_Name'=>$value['emp_EmployeeName'], 'adm_Status'=>'Active'];
                }
            }
        }

        foreach ($employeesData as $key => $value) {
            $value['index'] = $counter1+1;
            $admindata[] = $value;
            $counter1++;
        }

        $postMain = array_slice($admindata,$offset,$perpage);

        $total_admins = sizeof($admindata);

        $totalPage = ceil($total_admins / $perpage);

        $price = array_column($postMain, 'index');

        if($sort_col == 0){
            if($sort_type == 'desc'){
                array_multisort($price, SORT_DESC, $postMain);
            }else{
                array_multisort($price, SORT_ASC, $postMain);
            }
        }
          $result = array(
            "draw" => $data['draw'],
            "recordsTotal" =>$total_admins,
            "recordsFiltered" => $total_admins,
            "data" => $postMain,
          );

           return response()->json($result);
    }   

    public function authLoginAs(Request $request)
    {
        /**
       * Used for Login As
       */
        $data = $request->all();
        $response = [];
        $userData = '';
        $uimg = url('public/images/user.png');
        if($data['type'] == 'HertronicAdmin' || $data['type'] == 'MinistryAdmin' || $data['type'] == 'MinistrySubAdmin'){
            $userData = Admin::where('id','=',$data['id'])->first();
            $guard = 'admin';
            $type = $this->translations['gn_ministry_super_admin'] ?? 'Ministry Super Admin';
            $url = url('/admin/dashboard');
            if(!empty($userData->adm_Photo)){
                $uimg = url('public/images/users/').'/'.$userData->adm_Photo; 
            }
            $name = $userData->adm_Name;
        }else{
            $userData = Employee::where('id','=',$data['id'])->first();
            $guard = 'employee';
            if($data['type'] == 'SchoolCoordinator'){
                $type = $this->translations['gn_school_coordinator'] ?? "School Coordinator";
            }elseif($data['type'] == 'Teacher'){
                $type = $this->translations['gn_teacher'] ?? "Teacher";
            }
            $url = url('/employee/dashboard');
            if(!empty($userData->emp_PicturePath)){
                $uimg = url('public/images/users/').'/'.$userData->emp_PicturePath; 
            }
            $name = $userData->emp_EmployeeName;

            Session::put('curr_emp_type', $data['type']);
        }

        $msg = $this->translations['gn_logged_in_as'] ?? "You are logged in as";
        $msg = $msg." ".$name." - ".$type;

        Session::put('previous_user', $this->logged_user);
        $uauth = Auth::guard($guard)->login($userData);

        $data = '<div class="alert alert-warning alert-dismissible fade show loginas-alert" role="alert">
           <div class="profile-cover">
            <img src="'.$uimg.'">
          </div>
           '.$msg.'
          <button data-redir="'.$url.'" type="button" class="login_as_redir theme_btn min_btn ml-md-5" data-dismiss="alert" aria-label="Close">
            Exit
          </button>
        </div><div class="alert-bg"></div>';
        $response['status'] = true;
        $response['message'] = $msg;
        $response['data'] = $data;
        //$response['redirect'] = $url;
        return response()->json($response);

    }
  
}