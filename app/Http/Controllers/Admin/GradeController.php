<?php
/**
* GradeController 
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
use App\Models\Grade;
use App\Models\EducationPlan;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class GradeController extends Controller
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

    public function grades(Request $request)
    {
        if (request()->ajax()) {
            return \View::make('admin.grades.grades')->renderSections();
        }
        return view('admin.grades.grades');
    }

    public function addGrade(Request $request)
    {
      /**
       * Used for Add Admin Grade
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkGra'])){
            $checkPrev = Grade::where('gra_GradeName_'.$this->current_language,$input['gra_GradeName_'.$this->current_language])->where('pkGra','!=',$input['pkGra'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_grade_exist'] ?? "Grade already exists with this name";
            }else{
        		$id = Grade::where('pkGra', $input['pkGra'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_grade_update_success'] ?? "Grade Successfully Updated";
            }
    	}else{
            $checkPrev = Grade::where('gra_GradeName_'.$this->current_language,$input['gra_GradeName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_grade_exist'] ?? "Grade already exists with this name";
            }else{
        		$id = Grade::insertGetId($input);
    			if(!empty($id)){
    				$id = Grade::where('pkGra', $id)
    	              ->update(['gra_Uid' => "GRD".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_grade_add_success'] ?? "Grade Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getGrade(Request $request)
    {
      /**
       * Used for Edit Admin Grade
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Grade::where('pkGra','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getGrades(Request $request)
    {
      /**
       * Used for Admin Grade listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$grade = new Grade;

    	if($filter){
    		$grade = $grade->where ( 'gra_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'gra_GradeName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}
    	$gradeQuery = $grade;

    	if($sort_col != 0){
    		$gradeQuery = $gradeQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_grades= $gradeQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $gradedata = [];
	      $grades = $gradeQuery->offset($offset)->limit($perpage);
	      // var_dump($grades->toSql(),$grades->getBindings());
	      $filtered_grades = $gradeQuery->offset($offset)->limit($perpage)->count();
	      $grades = $gradeQuery->select('pkGra','gra_Uid','gra_GradeName_'.$this->current_language.' as gra_GradeName','gra_GradeNameRoman','gra_Notes')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($grades as $key => $value) {
	            $value['index']      = $counter+1;
	            $gradedata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($gradedata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $gradedata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $gradedata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_grades,
			"recordsFiltered" => $total_grades,
	        "data" => $gradedata,
	      );

	       return response()->json($result);
    }


    public function deleteGrade(Request $request)
    {
      /**
       * Used for Delete Admin Grade
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $EducationPlan = EducationPlan::where('fkEplGra',$cid)->get()->count();
            //StudentEnrollment::where('fkSteGra',$cid)->get()->count();
            //Attendence::where('fkAtdGra',$cid)->get()->count();
            //PeriodicExam::where('fkPdeGra',$cid)->get()->count();
            //ClassCreation::where('fkClrGra',$cid)->get()->count();
            //StudentCertificate::where('scr_Grade',$cid)->get()->count();

            if($EducationPlan != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_grade_delete_prompt'] ?? "Sorry, the selected grade cannot be deleted as it is already being used by school education plans";
            }else{ 
        		Grade::where('pkGra', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_grade_delete_success'] ?? "Grade Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }


}