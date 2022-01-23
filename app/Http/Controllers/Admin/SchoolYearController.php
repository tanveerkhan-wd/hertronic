<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class SchoolYearController extends Controller
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
         * Used for School Years
         * @return redirect to Admin->School Years
         */
        if (request()->ajax()) {
            return \View::make('admin.schoolYear.schoolYear')->renderSections();
        }
        return view('admin.schoolYear.schoolYear');
    }


    public function addSchoolYear(Request $request)
    {
      /**
       * Used for Add Admin SchoolYear
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkSye'])){
            $checkPrev = SchoolYear::where('sye_NameCharacter_'.$this->current_language,$input['sye_NameCharacter_'.$this->current_language])->where('pkSye','!=',$input['pkSye'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_school_year_exists'] ?? "School Year already exists with this name";
            }else{
        		$id = SchoolYear::where('pkSye', $input['pkSye'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_school_year_update_success'] ?? "School Year Successfully Updated";
            }
    	}else{
            $checkPrev = SchoolYear::where('sye_NameCharacter_'.$this->current_language,$input['sye_NameCharacter_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_school_year_exists'] ?? "School Year already exists with this name";
            }else{
        		$id = SchoolYear::insertGetId($input);
    			if(!empty($id)){
    				$id = SchoolYear::where('pkSye', $id)
    	              ->update(['sye_Uid' => "SYE".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_school_year_add_success'] ?? "School Year Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getSchoolYear(Request $request)
    {
      /**
       * Used for Edit Admin SchoolYear
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = SchoolYear::where('pkSye','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getSchoolYears(Request $request)
    {
      /**
       * Used for Admin SchoolYear Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column']: '';

	    $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

    	$schoolYear = new SchoolYear;

    	if($filter){
    		$schoolYear = $schoolYear->where ( 'sye_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'sye_NameCharacter_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere ( 'sye_NameNumeric', 'LIKE', '%' . $filter . '%' );
    	}
    	$schoolYearQuery = $schoolYear;

    	if($sort_col != 0){
    		$schoolYearQuery = $schoolYearQuery->orderBy($sort_field, $sort_type);
    	}

  		$total_schoolYear= $schoolYearQuery->count();
  	  	$offset = isset($data['start']) ? $data['start'] : '';
	     
	      $counter = $offset;
	      $schoolYear_data = [];
	      $schoolYears = $schoolYearQuery->offset($offset)->limit($perpage);
	      $filtered_schoolYears = $schoolYearQuery->offset($offset)->limit($perpage)->count();
	      $schoolYears = $schoolYearQuery->select('*','sye_NameCharacter_'.$this->current_language.' as sye_NameCharacter')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($schoolYears as $key => $value) {
	            $value['index'] = $counter+1;
	            $schoolYear_data[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($schoolYear_data, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $schoolYear_data);
	     	}else{
	     		array_multisort($price, SORT_ASC, $schoolYear_data);
	     	}
		}
	      $result = array(
	      	"draw" => isset($data['draw']) ? $data['draw'] :'',
			"recordsTotal" => $total_schoolYear,
			"recordsFiltered" => $total_schoolYear,
	        'data' => $schoolYear_data,
	      );

	       return response()->json($result);
    }

    public function deleteSchoolYear(Request $request)
    {
      /**
       * Used for Delete Admin SchoolYear
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $StudentEnrollment = 0;
            //$StudentEnrollment = StudentEnrollment::where('fkSteSye', $cid)->get()->count();
            if($StudentEnrollment != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_school_year_delete_prompt'] ?? "Sorry, the selected school year cannot be deleted as students are already enrolled in the school year";
            }else{
        		SchoolYear::where('pkSye', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_school_year_delete_success'] ?? "School Year Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }
}
