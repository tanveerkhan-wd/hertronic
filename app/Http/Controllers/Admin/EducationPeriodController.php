<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EducationPeriod;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class EducationPeriodController extends Controller
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

    public function index(Request $request){
    	 /**
         * Used for Admin Countries
         * @return redirect to Admin->Countries
         */
        if (request()->ajax()) {
            return \View::make('admin.educationPeriod.educationPeriod')->renderSections();
        }
        return view('admin.educationPeriod.educationPeriod');
    }


    public function addEducationPeriod(Request $request)
    {
      /**
       * Used for Add Admin Education Period
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkEdp'])){
            $checkPrev = EducationPeriod::where('edp_EducationPeriodName_'.$this->current_language,$input['edp_EducationPeriodName_'.$this->current_language])->where('pkEdp','!=',$input['pkEdp'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_education_period_exist'] ?? "Education Period already exists with this name";
            }else{
        		$id = EducationPeriod::where('pkEdp', $input['pkEdp'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_education_period_update_success'] ?? "Education Period Successfully Updated";
            }
    	}else{
            $checkPrev = EducationPeriod::where('edp_EducationPeriodName_'.$this->current_language,$input['edp_EducationPeriodName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_education_period_exist'] ?? "Education Period already exists with this name";
            }else{
        		$id = EducationPeriod::insertGetId($input);
    			if(!empty($id)){
    				$id = EducationPeriod::where('pkEdp', $id)
    	              ->update(['edp_Uid' => "EDP".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_education_period_add_success'] ?? "Education Period Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getEducationPeriod(Request $request)
    {
      /**
       * Used for Edit Admin Education Period
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = EducationPeriod::where('pkEdp','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getEducationPeriods(Request $request)
    {
      /**
       * Used for Admin Education Period Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

	    $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

    	$educationPeriod = new EducationPeriod;

    	if($filter){
    		$educationPeriod = $educationPeriod->where ( 'edp_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'edp_EducationPeriodName_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere ( 'edp_EducationPeriodNameAdjective', 'LIKE', '%' . $filter . '%' );
    	}
    	$educationPeriodQuery = $educationPeriod;

    	if($sort_col != 0){
    		$educationPeriodQuery = $educationPeriodQuery->orderBy($sort_field, $sort_type);
    	}

  		$total_educationPeriod= $educationPeriodQuery->count();
  	  	$offset = isset($data['start']) ? $data['start'] : '';
	     
	      $counter = $offset;
	      $educationPeriod_data = [];
	      $educationPeriods = $educationPeriodQuery->offset($offset)->limit($perpage);
	      // var_dump($countries->toSql(),$countries->getBindings());
	      $filtered_educationPeriods = $educationPeriodQuery->offset($offset)->limit($perpage)->count();
	      $educationPeriods = $educationPeriodQuery->select('*','edp_EducationPeriodName_'.$this->current_language.' as edp_EducationPeriodName')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($educationPeriods as $key => $value) {
	            $value['index'] = $counter+1;
	            $educationPeriod_data[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($educationPeriod_data, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $educationPeriod_data);
	     	}else{
	     		array_multisort($price, SORT_ASC, $educationPeriod_data);
	     	}
		}
	      $result = array(
	      	"draw" => isset($data['draw']) ? $data['draw'] :'',
			"recordsTotal" => $total_educationPeriod,
			"recordsFiltered" => $total_educationPeriod,
	        'data' => $educationPeriod_data,
	      );

	       return response()->json($result);
    }

    public function deleteEducationPeriod(Request $request)
    {
      /**
       * Used for Delete Admin Education Period
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $ClassCreation = 0;
            //$ClassCreation = ClassCreation::where('fkClrEdp', $cid)->get()->count();
            if($ClassCreation != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_school_year_delete_prompt'] ?? "Sorry, the selected school year cannot be deleted as students are already enrolled in the school year";
            }else{
        		EducationPeriod::where('pkEdp', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_school_year_delete_success'] ?? "School Year Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }
}
