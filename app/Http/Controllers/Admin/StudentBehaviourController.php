<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentBehaviour;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class StudentBehaviourController extends Controller
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
            return \View::make('admin.studentBehaviour.studentBehaviour')->renderSections();
        }
        return view('admin.studentBehaviour.studentBehaviour');
    }


    public function addStudentBehaviour(Request $request)
    {
      /**
       * Used for Admin StudentBehaviour
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkSbe'])){
            $checkPrev = StudentBehaviour::where('sbe_BehaviourName_'.$this->current_language,$input['sbe_BehaviourName_'.$this->current_language])->where('pkSbe','!=',$input['pkSbe'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_behaviour_exist'] ?? "Student Behavior already exists with this name";
            }else{
        		$id = StudentBehaviour::where('pkSbe', $input['pkSbe'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_behaviour_update_success'] ?? "Student Behavior Successfully Updated";
            }
    	}else{
            $checkPrev = StudentBehaviour::where('sbe_BehaviourName_'.$this->current_language,$input['sbe_BehaviourName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_behaviour_exist'] ?? "Student Behavior already exists with this name";
            }else{
        		$id = StudentBehaviour::insertGetId($input);
    			if(!empty($id)){
    				$id = StudentBehaviour::where('pkSbe', $id)
    	              ->update(['sbe_Uid' => "SBE".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_behaviour_add_success'] ?? "Student Behavior Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getStudentBehaviour(Request $request)
    {
      /**
       * Used Edit Admin StudentBehaviour
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = StudentBehaviour::where('pkSbe','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getStudentBehaviours(Request $request)
    {
      /**
       * Used for Admin StudentBehaviour Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

	    $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

    	$studentBehaviour = new StudentBehaviour;

    	if($filter){
    		$studentBehaviour = $studentBehaviour->where ( 'sbe_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'sbe_BehaviourName_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere ( 'sbe_Notes', 'LIKE', '%' . $filter . '%' );
    	}
    	$studentBehaviourQuery = $studentBehaviour;

    	if($sort_col != 0){
    		$studentBehaviourQuery = $studentBehaviourQuery->orderBy($sort_field, $sort_type);
    	}

  		$total_studentBehaviour= $studentBehaviourQuery->count();
  	  	$offset = isset($data['start']) ? $data['start'] : '';
	     
	      $counter = $offset;
	      $studentBehaviour_data = [];
	      $studentBehaviours = $studentBehaviourQuery->offset($offset)->limit($perpage);
	      $filtered_studentBehaviours = $studentBehaviourQuery->offset($offset)->limit($perpage)->count();
	      $studentBehaviours = $studentBehaviourQuery->select('*','sbe_BehaviourName_'.$this->current_language.' as sbe_BehaviourName')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($studentBehaviours as $key => $value) {
	            $value['index'] = $counter+1;
	            $studentBehaviour_data[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($studentBehaviour_data, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $studentBehaviour_data);
	     	}else{
	     		array_multisort($price, SORT_ASC, $studentBehaviour_data);
	     	}
		}
	      $result = array(
	      	"draw" => isset($data['draw']) ? $data['draw'] :'',
			"recordsTotal" => $total_studentBehaviour,
			"recordsFiltered" => $total_studentBehaviour,
	        'data' => $studentBehaviour_data,
	      );

	       return response()->json($result);
    }

    public function deleteStudentBehaviour(Request $request)
    {
      /**
       * Used for Delete Admin StudentBehaviour
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		StudentBehaviour::where('pkSbe', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }
    
}
