<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OptionalCoursesGroup;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class OptionalCoursesGroupController extends Controller
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
            return \View::make('admin.optionalCoursesGroup.optionalCoursesGroup')->renderSections();
        }
        return view('admin.optionalCoursesGroup.optionalCoursesGroup');
    }


    public function addOptionalCoursesGroup(Request $request)
    {
      /**
       * Used for Add Admin Optional Courses Group
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkOcg'])){
            $checkPrev = OptionalCoursesGroup::where('ocg_Name_'.$this->current_language,$input['ocg_Name_'.$this->current_language])->where('pkOcg','!=',$input['pkOcg'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_ocg_exist'] ?? "Optional Courses Group already exists with this name";
            }else{
        		$id = OptionalCoursesGroup::where('pkOcg', $input['pkOcg'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_ocg_update_success'] ?? "Optional Courses Group Successfully Updated";
            }
    	}else{
            $checkPrev = OptionalCoursesGroup::where('ocg_Name_'.$this->current_language,$input['ocg_Name_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_ocg_exist'] ?? "Optional Courses Group already exists with this name";
            }else{
        		$id = OptionalCoursesGroup::insertGetId($input);
    			if(!empty($id)){
    				$id = OptionalCoursesGroup::where('pkOcg', $id)
    	              ->update(['ocg_Uid' => "OCG".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_ocg_add_success'] ?? "Optional Courses Group Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getOptionalCoursesGroup(Request $request)
    {
      /**
       * Used for Edit Admin Optional Courses Group
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = OptionalCoursesGroup::where('pkOcg','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getOptionalCoursesGroups(Request $request)
    {
      /**
       * Used for Admin Optional Courses Group Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

	    $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

    	$optionalCoursesGroup = new OptionalCoursesGroup;

    	if($filter){
    		$optionalCoursesGroup = $optionalCoursesGroup->where( 'ocg_Uid', 'LIKE', '%' . $filter . '%' )->orWhere( 'ocg_Name_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere( 'ocg_Notes', 'LIKE', '%' . $filter . '%' );
    	}
    	$optionalCoursesGroupQuery = $optionalCoursesGroup;

    	if($sort_col != 0){
    		$optionalCoursesGroupQuery = $optionalCoursesGroupQuery->orderBy($sort_field, $sort_type);
    	}

  		$total_optionalCoursesGroup= $optionalCoursesGroupQuery->count();
  	  	$offset = isset($data['start']) ? $data['start'] : '';
	     
	      $counter = $offset;
	      $optionalCoursesGroup_data = [];
	      $optionalCoursesGroups = $optionalCoursesGroupQuery->offset($offset)->limit($perpage);
	      // var_dump($countries->toSql(),$countries->getBindings());
	      $filtered_optionalCoursesGroups = $optionalCoursesGroupQuery->offset($offset)->limit($perpage)->count();
	      $optionalCoursesGroups = $optionalCoursesGroupQuery->select('*','ocg_Name_'.$this->current_language.' as ocg_Name')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($optionalCoursesGroups as $key => $value) {
	            $value['index'] = $counter+1;
	            // $value['created_at'] = date("jS M, Y", strtotime($value['created_at']));
	            $optionalCoursesGroup_data[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($optionalCoursesGroup_data, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $optionalCoursesGroup_data);
	     	}else{
	     		array_multisort($price, SORT_ASC, $optionalCoursesGroup_data);
	     	}
		}
	      $result = array(
	      	"draw" => isset($data['draw']) ? $data['draw'] :'',
			"recordsTotal" => $total_optionalCoursesGroup,
			"recordsFiltered" => $total_optionalCoursesGroup,
	        'data' => $optionalCoursesGroup_data,
	      );

	       return response()->json($result);
    }

    public function deleteOptionalCoursesGroup(Request $request)
    {
      /**
       * Used for Delete Admin Optional Courses Group
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		OptionalCoursesGroup::where('pkOcg', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }
    
}
