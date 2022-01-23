<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExtracurricuralActivityType;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class ExtracurricuralActivityTypeController extends Controller
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
         * Used for Admin Extracurricular 
         * @return redirect to Admin->Extracurricular 
         */
        if (request()->ajax()) {
            return \View::make('admin.extracurricuralActivityType.extracurricuralActivityType')->renderSections();
        }
        return view('admin.extracurricuralActivityType.extracurricuralActivityType');
    }


    public function addExtracurricuralActivityType(Request $request)
    {
      /**
       * Used for Add Admin Extracurricular Activity Type
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkSat'])){
            $checkPrev = ExtracurricuralActivityType::where('sat_StudentExtracurricuralActivityName_'.$this->current_language,$input['sat_StudentExtracurricuralActivityName_'.$this->current_language])->where('pkSat','!=',$input['pkSat'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_extracurricular_exist'] ?? "Extracurricular activity already exists with this name";
            }else{
        		$id = ExtracurricuralActivityType::where('pkSat', $input['pkSat'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_extracurricular_update_success'] ?? "Extracurricular Activity Successfully Updated";
            }
    	}else{
            $checkPrev = ExtracurricuralActivityType::where('sat_StudentExtracurricuralActivityName_'.$this->current_language,$input['sat_StudentExtracurricuralActivityName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_extracurricular_exist'] ?? "Extracurricular activity already exists with this name";
            }else{
        		$id = ExtracurricuralActivityType::insertGetId($input);
    			if(!empty($id)){
    				$id = ExtracurricuralActivityType::where('pkSat', $id)
    	              ->update(['sat_Uid' => "ECA".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_extracurricular_add_success'] ?? "Extracurricular Activity Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getExtracurricuralActivityType(Request $request)
    {
      /**
       * Used for edit Admin Extracurricural Activity Type
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = ExtracurricuralActivityType::where('pkSat','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getExtracurricuralActivityTypes(Request $request)
    {
      /**
       * Used for Admin Extracurricural Activity Type Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

	    $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

    	$extracurricuralActivityType = new ExtracurricuralActivityType;

    	if($filter){
    		$extracurricuralActivityType = $extracurricuralActivityType->where ( 'sat_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'sat_StudentExtracurricuralActivityName_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere ( 'sat_Notes', 'LIKE', '%' . $filter . '%' );
    	}
    	$extracurricuralActivityTypeQuery = $extracurricuralActivityType;

    	if($sort_col != 0){
    		$extracurricuralActivityTypeQuery = $extracurricuralActivityTypeQuery->orderBy($sort_field, $sort_type);
    	}

  		$total_extracurricuralActivityType= $extracurricuralActivityTypeQuery->count();
  	  	$offset = isset($data['start']) ? $data['start'] : '';
	     
	      $counter = $offset;
	      $extracurricuralActivityType_data = [];
	      $extracurricuralActivityTypes = $extracurricuralActivityTypeQuery->offset($offset)->limit($perpage);
	      $filtered_extracurricuralActivityTypes = $extracurricuralActivityTypeQuery->offset($offset)->limit($perpage)->count();
	      $extracurricuralActivityTypes = $extracurricuralActivityTypeQuery->select('*', 'sat_StudentExtracurricuralActivityName_'.$this->current_language.' as sat_StudentExtracurricuralActivityName')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($extracurricuralActivityTypes as $key => $value) {
	            $value['index'] = $counter+1;
	            $extracurricuralActivityType_data[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($extracurricuralActivityType_data, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $extracurricuralActivityType_data);
	     	}else{
	     		array_multisort($price, SORT_ASC, $extracurricuralActivityType_data);
	     	}
		}
	      $result = array(
	      	"draw" => isset($data['draw']) ? $data['draw'] :'',
			"recordsTotal" => $total_extracurricuralActivityType,
			"recordsFiltered" => $total_extracurricuralActivityType,
	        'data' => $extracurricuralActivityType_data,
	      );

	       return response()->json($result);
    }

    public function deleteExtracurricuralActivityType(Request $request)
    {
      /**
       * Used for Delete Admin Extracurricural Activity Type
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		ExtracurricuralActivityType::where('pkSat', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }
}
