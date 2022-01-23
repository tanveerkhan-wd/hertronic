<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralPurposeGroup;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class GeneralPurposeGroupController extends Controller
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
            return \View::make('admin.generalPurposeGroup.generalPurposeGroup')->renderSections();
        }
        return view('admin.generalPurposeGroup.generalPurposeGroup');
    }


    public function addGeneralPurposeGroup(Request $request)
    {
      /**
       * Used for Add Admin General Purpose Group
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkGpg'])){
            $checkPrev = GeneralPurposeGroup::where('gpg_Name_'.$this->current_language,$input['gpg_Name_'.$this->current_language])->where('pkGpg','!=',$input['pkGpg'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_gpg_exist'] ?? "General Purpose Group already exists with this name";
            }else{
        		$id = GeneralPurposeGroup::where('pkGpg', $input['pkGpg'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_gpg_update_success'] ?? "General Purpose Group Successfully Updated";
            }
    	}else{
            $checkPrev = GeneralPurposeGroup::where('gpg_Name_'.$this->current_language,$input['gpg_Name_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_gpg_exist'] ?? "General Purpose Group already exists with this name";
            }else{
        		$id = GeneralPurposeGroup::insertGetId($input);
    			if(!empty($id)){
    				$id = GeneralPurposeGroup::where('pkGpg', $id)
    	              ->update(['gpg_Uid' => "GPG".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_gpg_add_success'] ?? "General Purpose Group Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getGeneralPurposeGroup(Request $request)
    {
      /**
       * Used for Edit Admin General Purpose Group
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = GeneralPurposeGroup::where('pkGpg','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getGeneralPurposeGroups(Request $request)
    {
      /**
       * Used for Admin General Purpose Group Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

	    $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

    	$generalPurposeGroup = new GeneralPurposeGroup;

    	if($filter){
    		$generalPurposeGroup = $generalPurposeGroup->where( 'gpg_Uid', 'LIKE', '%' . $filter . '%' )->orWhere( 'gpg_Name_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere( 'gpg_Notes', 'LIKE', '%' . $filter . '%' );
    	}
    	$generalPurposeGroupQuery = $generalPurposeGroup;

    	if($sort_col != 0){
    		$generalPurposeGroupQuery = $generalPurposeGroupQuery->orderBy($sort_field, $sort_type);
    	}

  		$total_generalPurposeGroup= $generalPurposeGroupQuery->count();
  	  	$offset = isset($data['start']) ? $data['start'] : '';
	     
	      $counter = $offset;
	      $generalPurposeGroup_data = [];
	      $generalPurposeGroups = $generalPurposeGroupQuery->offset($offset)->limit($perpage);
	      // var_dump($countries->toSql(),$countries->getBindings());
	      $filtered_generalPurposeGroups = $generalPurposeGroupQuery->offset($offset)->limit($perpage)->count();
	      $generalPurposeGroups = $generalPurposeGroupQuery->select('*','gpg_Name_'.$this->current_language.' as gpg_Name')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($generalPurposeGroups as $key => $value) {
	            $value['index'] = $counter+1;
	            $generalPurposeGroup_data[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($generalPurposeGroup_data, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $generalPurposeGroup_data);
	     	}else{
	     		array_multisort($price, SORT_ASC, $generalPurposeGroup_data);
	     	}
		}
	      $result = array(
	      	"draw" => isset($data['draw']) ? $data['draw'] :'',
			"recordsTotal" => $total_generalPurposeGroup,
			"recordsFiltered" => $total_generalPurposeGroup,
	        'data' => $generalPurposeGroup_data,
	      );

	       return response()->json($result);
    }

    public function deleteGeneralPurposeGroup(Request $request)
    {
      /**
       * Used for Delete Admin General Purpose Group
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		GeneralPurposeGroup::where('pkGpg', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }
     
}
