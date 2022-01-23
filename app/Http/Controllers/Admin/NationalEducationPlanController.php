<?php
/**
* EducationPlanController 
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
use App\Models\NationalEducationPlan;
use App\Models\EducationPlan;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class NationalEducationPlanController extends Controller
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

    public function educationPlans(Request $request)
    {
        /**
         * Used for Admin Education Plans
         * @return redirect to Admin->Education Plans
         */
        if (request()->ajax()) {
            return \View::make('admin.nationalEducationPlans.nationalEducationPlans')->renderSections();
        }
        return view('admin.nationalEducationPlans.nationalEducationPlans');
    }

    public function addEducationPlan(Request $request)
    {
      /**
       * Used for Add Admin Education Plan
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkNep'])){
            $checkPrev = NationalEducationPlan::where('nep_NationalEducationPlanName_'.$this->current_language,$input['nep_NationalEducationPlanName_'.$this->current_language])->where('pkNep','!=',$input['pkNep'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_nep_exist'] ?? "National Education Plan already exists with this name";
            }else{
        		$id = NationalEducationPlan::where('pkNep', $input['pkNep'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_nep_update_success'] ?? "National Education Plan Successfully Updated";
            }
    	}else{
            $checkPrev = NationalEducationPlan::where('nep_NationalEducationPlanName_'.$this->current_language,$input['nep_NationalEducationPlanName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_nep_exist'] ?? "National Education Plan already exists with this name";
            }else{
        		$id = NationalEducationPlan::insertGetId($input);
    			if(!empty($id)){
    				$id = NationalEducationPlan::where('pkNep', $id)
    	              ->update(['nep_Uid' => "NEP".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_nep_add_success'] ?? "National Education Plan Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getEducationPlan(Request $request)
    {
      /**
       * Used for Edit Admin Education Plan
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = NationalEducationPlan::where('pkNep','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getEducationPlans(Request $request)
    {
      /**
       * Used for Admin Education Plan Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$EducationPlan = new NationalEducationPlan;

    	if($filter){
    		$EducationPlan = $EducationPlan->where ( 'nep_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'nep_NationalEducationPlanName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}
    	$EducationPlanQuery = $EducationPlan;

    	if($sort_col != 0){
    		$EducationPlanQuery = $EducationPlanQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_EducationPlan = $EducationPlanQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $EducationPlanData = [];
	      $EducationPlans = $EducationPlanQuery->offset($offset)->limit($perpage);
	      // var_dump($EducationPlans->toSql(),$EducationPlans->getBindings());
	      $EducationPlans = $EducationPlanQuery->select('pkNep','nep_Uid','nep_NationalEducationPlanName_'.$this->current_language.' as nep_NationalEducationPlanName','nep_Notes','nep_Status')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($EducationPlans as $key => $value) {
	            $value['index']      = $counter+1;
                $value['nep_Statu'] = $value['nep_Status'];
                if($value['nep_Status']=='Active'){
                    $value['nep_Status'] = $this->translations['gn_active'] ?? "Active";
                }
                else{
                    $value['nep_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
                }
	            $EducationPlanData[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($EducationPlanData, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $EducationPlanData);
	     	}else{
	     		array_multisort($price, SORT_ASC, $EducationPlanData);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			  "recordsTotal" =>$total_EducationPlan,
			  "recordsFiltered" => $total_EducationPlan,
	         'data' => $EducationPlanData,
	      );

	       return response()->json($result);
    }


    public function deleteEducationPlan(Request $request)
    {
      /**
       * Used for Delete Admin Education Plan
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{

            $EducationPlan = EducationPlan::where('fkEplNep', $cid)->get()->count();

            if($EducationPlan != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_nep_delete_prompt'] ?? "Sorry, the selected national education plan cannot be deleted as it is already being used by school education plans";
            }else{ 
        		NationalEducationPlan::where('pkNep', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_nep_delete_success'] ?? "National Education Plan Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }


}