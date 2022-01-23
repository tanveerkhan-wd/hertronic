<?php
/**
* QualificationDegreeController 
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
use App\Models\QualificationDegree;
use App\Models\EducationPlan;
use App\Models\EmployeesEducationDetail;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class QualificationDegreeController extends Controller
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

    public function qualificationDegrees(Request $request)
    {
        if (request()->ajax()) {
            return \View::make('admin.qualificationDegrees.qualificationDegrees')->renderSections();
        }
        return view('admin.qualificationDegrees.qualificationDegrees');
    }

    public function addQualificationDegree(Request $request)
    {
      /**
       * Used for Add Admin Qualification Degree
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkQde'])){
            $checkPrev = QualificationDegree::where('qde_QualificationDegreeName_'.$this->current_language,$input['qde_QualificationDegreeName_'.$this->current_language])->where('pkQde','!=',$input['pkQde'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_qd_exists'] ?? "Qualification Degree already exists with this name";
            }else{
        		$id = QualificationDegree::where('pkQde', $input['pkQde'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_qd_update_success'] ?? "Qualification Degree Successfully Updated";
            }
    	}else{
            $checkPrev = QualificationDegree::where('qde_QualificationDegreeName_'.$this->current_language,$input['qde_QualificationDegreeName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_qd_exists'] ?? "Qualification Degree already exists with this name";
            }else{
        		$id = QualificationDegree::insertGetId($input);
    			if(!empty($id)){
    				$id = QualificationDegree::where('pkQde', $id)
    	              ->update(['qde_Uid' => "QUD".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_qd_add_success'] ?? "Qualification Degree Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getQualificationDegree(Request $request)
    {
      /**
       * Used for Edit Admin Qualification Degree
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = QualificationDegree::where('pkQde','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getQualificationDegrees(Request $request)
    {
      /**
       * Used for Admin Qualification Degree Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	
	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$QualificationDegree = new QualificationDegree;

    	if($filter){
    		$QualificationDegree = $QualificationDegree->where ( 'qde_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'qde_QualificationDegreeName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}
    	$QualificationDegreeQuery = $QualificationDegree;

    	if($sort_col != 0){
    		$QualificationDegreeQuery = $QualificationDegreeQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_QualificationDegree = $QualificationDegreeQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $QualificationDegreeData = [];
	      $QualificationDegrees = $QualificationDegreeQuery->offset($offset)->limit($perpage);
	      // var_dump($QualificationDegrees->toSql(),$QualificationDegrees->getBindings());
	      $QualificationDegrees = $QualificationDegreeQuery->select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName','qde_Uid','qde_Notes','qde_Status')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($QualificationDegrees as $key => $value) {
	            $value['index']      = $counter+1;
                $value['qde_Statu'] = $value['qde_Status'];
                if($value['qde_Status']=='Active'){
                    $value['qde_Status'] = $this->translations['gn_active'] ?? "Active";
                }
                else{
                    $value['qde_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
                }
	            $QualificationDegreeData[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($QualificationDegreeData, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $QualificationDegreeData);
	     	}else{
	     		array_multisort($price, SORT_ASC, $QualificationDegreeData);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_QualificationDegree,
			"recordsFiltered" => $total_QualificationDegree,
	        'data' => $QualificationDegreeData,
	      );

	       return response()->json($result);
    }


    public function deleteQualificationDegree(Request $request)
    {
      /**
       * Used for Delete Admin Qualification Degree
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{

            $EducationPlan = EducationPlan::where('fkEplQde',$cid)->get()->count();
            $eed = EmployeesEducationDetail::where('fkEedQde',$cid)->get()->count();

            if($EducationPlan != 0 || $eed != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_qualification_degree_delete_prompt'] ?? "Sorry, the selected qualification degree cannot be deleted as it is already being used by school education plans, employees education details";
            }else{ 
        		QualificationDegree::where('pkQde', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_qualification_degree_delete_success'] ?? "Qualification Degree Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }


}