<?php
/**
* ReligionController 
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
use App\Models\Religion;
use App\Models\Employee;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class ReligionController extends Controller
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

    public function religions(Request $request)
    {
        /**
         * Used for Admin religions
         * @return redirect to Admin->religions
         */
        if (request()->ajax()) {
            return \View::make('admin.religions.religions')->renderSections();
        }
        return view('admin.religions.religions');
    }

    public function addReligion(Request $request)
    {
      /**
       * Used for Add Admin Religion
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkRel'])){
            $checkPrev = Religion::where('rel_ReligionName_'.$this->current_language,$input['rel_ReligionName_'.$this->current_language])->where('pkRel','!=',$input['pkRel'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_religion_exists'] ?? "Religion already exists with this name";
            }else{
        		$id = Religion::where('pkRel', $input['pkRel'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_religion_update_success'] ?? "Religion Successfully Updated";
            }
    	}else{
            $checkPrev = Religion::where('rel_ReligionName_'.$this->current_language,$input['rel_ReligionName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_religion_exists'] ?? "Religion already exists with this name";
            }else{
        		$id = Religion::insertGetId($input);
    			if(!empty($id)){
    				$id = Religion::where('pkRel', $id)
    	              ->update(['rel_Uid' => "REL".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_religion_add_success'] ?? "Religion Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getReligion(Request $request)
    {
      /**
       * Used for Edit Admin Religion
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Religion::where('pkRel','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getReligions(Request $request)
    {
      /**
       * Used for Admin Religion Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$Religion = new Religion;

    	if($filter){
    		$Religion = $Religion->where ( 'rel_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'rel_ReligionName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}
    	$ReligionQuery = $Religion;

    	if($sort_col != 0){
    		$ReligionQuery = $ReligionQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_religions= $ReligionQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $Religiondata = [];
	      $religions = $ReligionQuery->offset($offset)->limit($perpage);
	      // var_dump($religions->toSql(),$religions->getBindings());
	      $filtered_religions = $ReligionQuery->offset($offset)->limit($perpage)->count();
	      $religions = $ReligionQuery->select('pkRel','rel_Uid','rel_ReligionName_'.$this->current_language.' as rel_ReligionName','rel_Notes')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($religions as $key => $value) {
	            $value['index']      = $counter+1;
	            // $value['created_at'] = date("jS M, Y", strtotime($value['created_at']));
	            $Religiondata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($Religiondata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $Religiondata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $Religiondata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_religions,
			"recordsFiltered" => $total_religions,
	        'data' => $Religiondata,
	      );

	       return response()->json($result);
    }


    public function deleteReligion(Request $request)
    {
      /**
       * Used for Delete Admin Religion
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $Employee = Employee::where('fkEmpRel', $cid)->get()->count();
            $Student = 0;
            //$Student = Student::where('fkStuRel', $cid)->get()->count();
            if($Employee != 0 || $Student != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_religion_delete_prompt'] ?? "Sorry, the selected religion cannot be deleted as it is already being used by the employees, students";
            }else{
        		Religion::where('pkRel', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_religion_delete_success'] ?? "Religion Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }


}