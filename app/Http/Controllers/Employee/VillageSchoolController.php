<?php
/**
* VillageSchoolController 
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
use App\Models\VillageSchool;
use App\Models\Employee;
use App\Models\EmployeesEngagement;
use App\Models\EngagementType;
use App\Models\PostalCode;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class VillageSchoolController extends Controller
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

    public function villageSchools(Request $request)
    {
        /**
         * Used for Village School
         * @return redirect to Employee->Village School
         */

        $PostalCodes = PostalCode::select('pkPof','pof_PostOfficeNumber','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName')->get();

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();
        $mainSchool = $mainSchool->fkEenSch;

        if (request()->ajax()) {
            return \View::make('common.villageSchools.villageSchools')->with(['PostalCodes'=>$PostalCodes, 'mainSchool'=>$mainSchool])->renderSections();
        }
        return view('common.villageSchools.villageSchools')->with(['PostalCodes'=>$PostalCodes, 'mainSchool'=>$mainSchool]);
    }

    public function addVillageSchool(Request $request)
    {
      /**
       * Used for Add Employee Village School
       */
    	$input = $request->all();
    	$response = [];

    	if(!empty($input['pkVsc'])){
            $checkPrev = VillageSchool::where('vsc_VillageSchoolName_'.$this->current_language,$input['vsc_VillageSchoolName_'.$this->current_language])->where('pkVsc','!=',$input['pkVsc'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_village_school_exist'] ?? "Village School already exists with this name";
            }else{
        		$id = VillageSchool::where('pkVsc', $input['pkVsc'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_village_school_update_success'] ?? "Village School Successfully Updated";
            }
    	}else{
            $checkPrev = VillageSchool::where('vsc_VillageSchoolName_'.$this->current_language,$input['vsc_VillageSchoolName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_village_school_exist'] ?? "Village School already exists with this name";
            }else{
        		$id = VillageSchool::insertGetId($input);
    			if(!empty($id)){
    				$id = VillageSchool::where('pkVsc', $id)
    	              ->update(['vsc_Uid' => "VSC".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_village_school_add_success'] ?? "Village School Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getVillageSchool(Request $request)
    {
      /**
       * Used for Edit Village School
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = VillageSchool::where('pkVsc','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getVillageSchools(Request $request)
    {
      /**
       * Used for Get Village School Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

        // $schoolDetail = Employee::with('EmployeesEngagement','EmployeesEngagement.employeeType')->whereHas('EmployeesEngagement', function($query) {
        //     $query->whereHas('employeeType', function ($query) {
        //         $query->where('epty_Name', 'SchoolCoordinator')->orWhere('epty_Name', 'SchoolSubAdmin');
        //     })->where('fkEenEmp',$this->logged_user->id)->where(function ($query){
        //         $query->where('een_DateOfFinishEngagement', '=', null)
        //             ->orWhere('een_DateOfFinishEngagement', '>=', now());
        //     });  
        // })->first();

        // $mainSchool = $schoolDetail->EmployeesEngagement[0]->fkEenSch;

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();;
        $mainSchool = $mainSchool->fkEenSch;

        $VillageSchool = VillageSchool::with('school')->whereHas('school', function($query) use ($mainSchool,$filter){
            if($filter){
                $query->where ( 'sch_SchoolName_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->where('pkSch', $mainSchool);
            }
        });

    	if($filter){
            $VillageSchool = $VillageSchool->orWhere(function ($query) use ($filter) {
                $query->where ( 'vsc_Uid', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'vsc_VillageSchoolName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
            });   
    	}

    	$VSQuery = $VillageSchool->where('fkVscSch', $mainSchool);

    	if($sort_col != 0){
    		$VSQuery = $VSQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_vs= $VSQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $VSdata = [];
	      $countries = $VSQuery->offset($offset)->limit($perpage);
	      $filtered_countries = $VSQuery->offset($offset)->limit($perpage)->count();
	      $countries = $VSQuery->select('*', 'vsc_VillageSchoolName_'.$this->current_language.' as vsc_VillageSchoolName')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($countries as $key => $value) {
	            $value['index']      = $counter+1;
	            $VSdata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($VSdata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $VSdata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $VSdata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_vs,
			"recordsFiltered" => $total_vs,
	        'data' => $VSdata,
	      );

	       return response()->json($result);
    }


    public function deleteVillageSchool(Request $request)
    {
      /**
       * Used for Delete Village School
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		VillageSchool::where('pkVsc', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }


}