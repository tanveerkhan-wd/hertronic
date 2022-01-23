<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ForeignLanguageGroup;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class ForeignLanguageGroupController extends Controller
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
            return \View::make('admin.foreignLanguageGroup.foreignLanguageGroup')->renderSections();
        }
        return view('admin.foreignLanguageGroup.foreignLanguageGroup');
    }


    public function addForeignLanguageGroup(Request $request)
    {
      /**
       * Used for Add Admin Foreign Language Group
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkFon'])){
            $checkPrev = ForeignLanguageGroup::where('fon_Name_'.$this->current_language,$input['fon_Name_'.$this->current_language])->where('pkFon','!=',$input['pkFon'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_flg_exist'] ?? "Foreign Language Group already exists with this name";
            }else{
        		$id = ForeignLanguageGroup::where('pkFon', $input['pkFon'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_flg_update_success'] ?? "Foreign Language Group Successfully Updated";
            }
    	}else{
            $checkPrev = ForeignLanguageGroup::where('fon_Name_'.$this->current_language,$input['fon_Name_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_flg_exist'] ?? "Foreign Language Group already exists with this name";
            }else{
        		$id = ForeignLanguageGroup::insertGetId($input);
    			if(!empty($id)){
    				$id = ForeignLanguageGroup::where('pkFon', $id)
    	              ->update(['fon_Uid' => "FLG".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_flg_add_success'] ?? "Foreign Language Group Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getForeignLanguageGroup(Request $request)
    {
      /**
       * Used for Edit Admin Foreign Language Group
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = ForeignLanguageGroup::where('pkFon','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getForeignLanguageGroups(Request $request)
    {
      /**
       * Used for Admin Foreign Language Group Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

	    $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

    	$foreignLanguageGroup = new ForeignLanguageGroup;

    	if($filter){
    		$foreignLanguageGroup = $foreignLanguageGroup->where( 'fon_Uid', 'LIKE', '%' . $filter . '%' )->orWhere( 'fon_Name_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere( 'fon_Notes', 'LIKE', '%' . $filter . '%' );
    	}
    	$foreignLanguageGroupQuery = $foreignLanguageGroup;

    	if($sort_col != 0){
    		$foreignLanguageGroupQuery = $foreignLanguageGroupQuery->orderBy($sort_field, $sort_type);
    	}

  		$total_foreignLanguageGroup= $foreignLanguageGroupQuery->count();
  	  	$offset = isset($data['start']) ? $data['start'] : '';
	     
	      $counter = $offset;
	      $foreignLanguageGroup_data = [];
	      $foreignLanguageGroups = $foreignLanguageGroupQuery->offset($offset)->limit($perpage);
	      // var_dump($countries->toSql(),$countries->getBindings());
	      $filtered_foreignLanguageGroups = $foreignLanguageGroupQuery->offset($offset)->limit($perpage)->count();
	      $foreignLanguageGroups = $foreignLanguageGroupQuery->select('*','fon_Name_'.$this->current_language.' as fon_Name')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($foreignLanguageGroups as $key => $value) {
	            $value['index'] = $counter+1;
	            $foreignLanguageGroup_data[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($foreignLanguageGroup_data, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $foreignLanguageGroup_data);
	     	}else{
	     		array_multisort($price, SORT_ASC, $foreignLanguageGroup_data);
	     	}
		}
	      $result = array(
	      	"draw" => isset($data['draw']) ? $data['draw'] :'',
			"recordsTotal" => $total_foreignLanguageGroup,
			"recordsFiltered" => $total_foreignLanguageGroup,
	        'data' => $foreignLanguageGroup_data,
	      );

	       return response()->json($result);
    }

    public function deleteForeignLanguageGroup(Request $request)
    {
      /**
       * Used for Add Admin Foreign Language Group
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		ForeignLanguageGroup::where('pkFon', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }
     

}
