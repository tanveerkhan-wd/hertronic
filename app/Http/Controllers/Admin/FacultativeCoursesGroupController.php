<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FacultativeCoursesGroup;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class FacultativeCoursesGroupController extends Controller
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
            return \View::make('admin.facultativeCoursesGroup.facultativeCoursesGroup')->renderSections();
        }
        return view('admin.facultativeCoursesGroup.facultativeCoursesGroup');
    }


    public function addFacultativeCoursesGroup(Request $request)
    {
      /**
       * Used for Add Admin Facultative Courses Group
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkFcg'])){
            $checkPrev = FacultativeCoursesGroup::where('fcg_Name_'.$this->current_language,$input['fcg_Name_'.$this->current_language])->where('pkFcg','!=',$input['pkFcg'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_fcg_exist'] ?? "Facultative Courses Group already exists with this name";
            }else{
        		$id = FacultativeCoursesGroup::where('pkFcg', $input['pkFcg'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_fcg_update_success'] ?? "Facultative Courses Group Successfully Updated";
            }
    	}else{
            $checkPrev = FacultativeCoursesGroup::where('fcg_Name_'.$this->current_language,$input['fcg_Name_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_fcg_exist'] ?? "Facultative Courses Group already exists with this name";
            }else{
        		$id = FacultativeCoursesGroup::insertGetId($input);
    			if(!empty($id)){
    				$id = FacultativeCoursesGroup::where('pkFcg', $id)
    	              ->update(['fcg_Uid' => "FCG".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_fcg_add_success'] ?? "Facultative Courses Group Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getFacultativeCoursesGroup(Request $request)
    {
      /**
       * Used for Edit Admin Facultative Courses Group
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = FacultativeCoursesGroup::where('pkFcg','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getFacultativeCoursesGroups(Request $request)
    {
      /**
       * Used for Admin Facultative Courses Group Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

	    $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

    	$facultativeCoursesGroup = new FacultativeCoursesGroup;

    	if($filter){
    		$facultativeCoursesGroup = $facultativeCoursesGroup->where( 'fcg_Uid', 'LIKE', '%' . $filter . '%' )->orWhere( 'fcg_Name_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere( 'fcg_Notes', 'LIKE', '%' . $filter . '%' );
    	}
    	$facultativeCoursesGroupQuery = $facultativeCoursesGroup;

    	if($sort_col != 0){
    		$facultativeCoursesGroupQuery = $facultativeCoursesGroupQuery->orderBy($sort_field, $sort_type);
    	}

  		$total_facultativeCoursesGroup= $facultativeCoursesGroupQuery->count();
  	  	$offset = isset($data['start']) ? $data['start'] : '';
	     
	      $counter = $offset;
	      $facultativeCoursesGroup_data = [];
	      $facultativeCoursesGroups = $facultativeCoursesGroupQuery->offset($offset)->limit($perpage);
	      // var_dump($countries->toSql(),$countries->getBindings());
	      $filtered_facultativeCoursesGroups = $facultativeCoursesGroupQuery->offset($offset)->limit($perpage)->count();
	      $facultativeCoursesGroups = $facultativeCoursesGroupQuery->select('*','fcg_Name_'.$this->current_language.' as fcg_Name')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($facultativeCoursesGroups as $key => $value) {
	            $value['index'] = $counter+1;
	            $facultativeCoursesGroup_data[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($facultativeCoursesGroup_data, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $facultativeCoursesGroup_data);
	     	}else{
	     		array_multisort($price, SORT_ASC, $facultativeCoursesGroup_data);
	     	}
		}
	      $result = array(
	      	"draw" => isset($data['draw']) ? $data['draw'] :'',
			"recordsTotal" => $total_facultativeCoursesGroup,
			"recordsFiltered" => $total_facultativeCoursesGroup,
	        'data' => $facultativeCoursesGroup_data,
	      );

	       return response()->json($result);
    }

    public function deleteFacultativeCoursesGroup(Request $request)
    {
      /**
       * Used for Delete Admin Facultative Courses Group
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		FacultativeCoursesGroup::where('pkFcg', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }

}
