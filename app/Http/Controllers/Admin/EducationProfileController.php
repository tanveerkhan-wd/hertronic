<?php
/**
* EducationProfileController 
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
use App\Models\EducationProfile;
use App\Models\EducationPlan;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class EducationProfileController extends Controller
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

    public function educationProfiles(Request $request)
    {
        /**
         * Used for Admin Education Profiles
         * @return redirect to Admin->Education Profiles
         */
        if (request()->ajax()) {
            return \View::make('admin.educationProfiles.educationProfiles')->renderSections();
        }
        return view('admin.educationProfiles.educationProfiles');
    }

    public function addEducationProfile(Request $request)
    {
      /**
       * Used for Add Admin Education Profile
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkEpr'])){
            $checkPrev = EducationProfile::where('epr_EducationProfileName_'.$this->current_language,$input['epr_EducationProfileName_'.$this->current_language])->where('pkEpr','!=',$input['pkEpr'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_education_profile_exist'] ?? "Education Profile already exists with this name";
            }else{
        		$id = EducationProfile::where('pkEpr', $input['pkEpr'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_education_profile_update_success'] ?? "Education Profile Successfully Updated";
            }
    	}else{
            $checkPrev = EducationProfile::where('epr_EducationProfileName_'.$this->current_language,$input['epr_EducationProfileName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_education_profile_exist'] ?? "Education Profile already exists with this name";
            }else{
        		$id = EducationProfile::insertGetId($input);
    			if(!empty($id)){
    				$id = EducationProfile::where('pkEpr', $id)
    	              ->update(['epr_Uid' => "EDP".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_education_profile_add_success'] ?? "Education Profile Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getEducationProfile(Request $request)
    {
      /**
       * Used for Edit Admin Education Profile
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = EducationProfile::where('pkEpr','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getEducationProfiles(Request $request)
    {
      /**
       * Used for Admin Education Profile Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$EducationProfile = new EducationProfile;

    	if($filter){
    		$EducationProfile = $EducationProfile->where ( 'epr_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'epr_EducationProfileName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}
    	$EducationProfileQuery = $EducationProfile;

    	if($sort_col != 0){
    		$EducationProfileQuery = $EducationProfileQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_EducationProfile = $EducationProfileQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $EducationProfileData = [];
	      $EducationProfiles = $EducationProfileQuery->offset($offset)->limit($perpage);
	      // var_dump($EducationProfiles->toSql(),$EducationProfiles->getBindings());
	      $EducationProfiles = $EducationProfileQuery->select('pkEpr','epr_Uid','epr_EducationProfileName_'.$this->current_language.' as epr_EducationProfileName','epr_Notes','epr_Status')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($EducationProfiles as $key => $value) {
	            $value['index']      = $counter+1;
                $value['epr_Statu'] = $value['epr_Status'];
                if($value['epr_Status']=='Active'){
                    $value['epr_Status'] = $this->translations['gn_active'] ?? "Active";
                }
                else{
                    $value['epr_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
                }
	            $EducationProfileData[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($EducationProfileData, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $EducationProfileData);
	     	}else{
	     		array_multisort($price, SORT_ASC, $EducationProfileData);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_EducationProfile,
			"recordsFiltered" => $total_EducationProfile,
	        'data' => $EducationProfileData,
	      );

	       return response()->json($result);
    }


    public function deleteEducationProfile(Request $request)
    {
      /**
       * Used for Delete Admin Education Profile
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $EducationPlan = EducationPlan::where('fkEplEpr',$cid)->get()->count();
            
            if($EducationPlan != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_education_profile_delete_prompt'] ?? "Sorry, the selected education profile cannot be deleted as it is already being used by school education plans";
            }else{ 
        		EducationProfile::where('pkEpr', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_education_profile_delete_success'] ?? "Education Profile Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }


}