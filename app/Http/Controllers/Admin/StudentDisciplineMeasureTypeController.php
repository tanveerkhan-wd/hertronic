<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentDisciplineMeasureType;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class StudentDisciplineMeasureTypeController extends Controller
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
            return \View::make('admin.disciplineMeasureType.disciplineMeasureType')->renderSections();
        }
        return view('admin.disciplineMeasureType.disciplineMeasureType');
    }


    public function addDisciplineMeasureType(Request $request)
    {
      /**
       * Used for Add Admin Discipline Measure Type
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkSmt'])){
            $checkPrev = StudentDisciplineMeasureType::where('smt_DisciplineMeasureName_'.$this->current_language,$input['smt_DisciplineMeasureName_'.$this->current_language])->where('pkSmt','!=',$input['pkSmt'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_dmt_exist'] ?? "Discipline Measure Type already exists with this name";
            }else{
        		$id = StudentDisciplineMeasureType::where('pkSmt', $input['pkSmt'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_dmt_update_success'] ?? "Discipline Measure Type Successfully Updated";
            }
    	}else{
            $checkPrev = StudentDisciplineMeasureType::where('smt_DisciplineMeasureName_'.$this->current_language,$input['smt_DisciplineMeasureName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_dmt_exist'] ?? "Discipline Measure Type already exists with this name";
            }else{
        		$id = StudentDisciplineMeasureType::insertGetId($input);
    			if(!empty($id)){
    				$id = StudentDisciplineMeasureType::where('pkSmt', $id)
    	              ->update(['smt_Uid' => "DMT".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_dmt_add_success'] ?? "Discipline Measure Type Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getDisciplineMeasureType(Request $request)
    {
      /**
       * Used for Edit Admin Discipline Measure Type
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = StudentDisciplineMeasureType::where('pkSmt','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getDisciplineMeasureTypes(Request $request)
    {
      /**
       * Used for Admin Discipline Measure Type Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

	    $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

    	$disciplineMeasureType = new StudentDisciplineMeasureType;

    	if($filter){
    		$disciplineMeasureType = $disciplineMeasureType->where ( 'smt_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'smt_DisciplineMeasureName_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere ( 'smt_Notes', 'LIKE', '%' . $filter . '%' );
    	}
    	$disciplineMeasureTypeQuery = $disciplineMeasureType;

    	if($sort_col != 0){
    		$disciplineMeasureTypeQuery = $disciplineMeasureTypeQuery->orderBy($sort_field, $sort_type);
    	}

  		$total_disciplineMeasureType= $disciplineMeasureTypeQuery->count();
  	  	$offset = isset($data['start']) ? $data['start'] : '';
	     
	      $counter = $offset;
	      $disciplineMeasureType_data = [];
	      $disciplineMeasureTypes = $disciplineMeasureTypeQuery->offset($offset)->limit($perpage);
	      // var_dump($countries->toSql(),$countries->getBindings());
	      $filtered_disciplineMeasureTypes = $disciplineMeasureTypeQuery->offset($offset)->limit($perpage)->count();
	      $disciplineMeasureTypes = $disciplineMeasureTypeQuery->select('*','smt_DisciplineMeasureName_'.$this->current_language.' as smt_DisciplineMeasureName')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($disciplineMeasureTypes as $key => $value) {
	            $value['index'] = $counter+1;
	            $disciplineMeasureType_data[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($disciplineMeasureType_data, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $disciplineMeasureType_data);
	     	}else{
	     		array_multisort($price, SORT_ASC, $disciplineMeasureType_data);
	     	}
		}
	      $result = array(
	      	"draw" => isset($data['draw']) ? $data['draw'] :'',
			"recordsTotal" => $total_disciplineMeasureType,
			"recordsFiltered" => $total_disciplineMeasureType,
	        'data' => $disciplineMeasureType_data,
	      );

	       return response()->json($result);
    }

    public function deleteDisciplineMeasureType(Request $request)
    {
      /**
       * Used for Delete Admin Discipline Measure Type
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		StudentDisciplineMeasureType::where('pkSmt', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }
    
}
