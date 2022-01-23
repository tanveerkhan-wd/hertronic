<?php
/**
* MunicipalityController 
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
use App\Models\Municipality;
use App\Models\Canton;
use App\Models\Employee;
use App\Models\PostalCode;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class MunicipalityController extends Controller
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

    public function municipalities(Request $request)
    {
        /**
         * Used for Admin municipalities
         * @return redirect to Admin->municipalities
         */

        $cdata = Canton::select('pkCan','can_CantonName_'.$this->current_language.' as can_CantonName')->get();
        if (request()->ajax()) {
            return \View::make('admin.municipalities.municipalities')->with('data', $cdata)->renderSections();
        }
        return View('admin.municipalities.municipalities',['data'=>$cdata]);
    }

    public function getMunicipalities(Request $request)
    {
      /**
       * Used for Admin Municipalities Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

	    $canton_filter = $data['canton'];

    	$Municipality = Municipality::with(array('canton'=>function($query){
		    $query->select('pkCan','can_CantonName_'.$this->current_language.' as can_CantonName');
		}));

    	if($filter){
    		$Municipality = $Municipality->where ( 'mun_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'mun_MunicipalityName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}

    	if($canton_filter){
    		$Municipality = $Municipality->where ('fkMunCan','=',$canton_filter);
    	}

    	$MunicipalityQuery = $Municipality;

    	if($sort_col != 0){
    		$MunicipalityQuery = $MunicipalityQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_municipalities= $MunicipalityQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $Municipalitydata = [];
	      $countries = $MunicipalityQuery->offset($offset)->limit($perpage);
	      $filtered_municipalities = $MunicipalityQuery->offset($offset)->limit($perpage)->count();
	      $countries = $MunicipalityQuery->select('pkMun','mun_Uid','mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName','fkMunCan','mun_Notes')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($countries as $key => $value) {
	            $value['index'] = $counter+1;
	            $Municipalitydata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($Municipalitydata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $Municipalitydata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $Municipalitydata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_municipalities,
		    "recordsFiltered" => $total_municipalities,
	        'data' => $Municipalitydata,
	      );

	       return response()->json($result);
    }

    public function addMunicipality(Request $request)
    {
      /**
       * Used for Add Admin Municipalities
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkMun'])){
            $checkPrev = Municipality::where('mun_MunicipalityName_'.$this->current_language,$input['mun_MunicipalityName_'.$this->current_language])->where('pkMun','!=',$input['pkMun'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_municipality_exist'] ?? "Municipality already exists with this name";
            }else{
        		$id = Municipality::where('pkMun', $input['pkMun'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_municipality_update_success'] ?? "Municipality Successfully Updated";
            }
    	}else{
            $checkPrev = Municipality::where('mun_MunicipalityName_'.$this->current_language,$input['mun_MunicipalityName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = "Municipality already exists with this name";
            }else{
        		$id = Municipality::insertGetId($input);
    			if(!empty($id)){
    				$id = Municipality::where('pkMun', $id)
    	              ->update(['mun_Uid' => "MUN".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_municipality_add_success'] ?? "Municipality Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getMunicipality(Request $request)
    {
      /**
       * Used for Edit Admin Municipalities
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Municipality::where('pkMun','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function deleteMunicipality(Request $request)
    {
      /**
       * Used for Delete Admin Municipalities
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $Employee = Employee::where('fkEmpMun',$cid)->get()->count();
            $PostalCode = PostalCode::where('fkPofMun',$cid)->get()->count();

            if($Employee != 0 || $PostalCode != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_municipality_delete_prompt'] ?? "Sorry, the selected municipality cannot be deleted as it is already being used by postal offices, employees";
            }else{
        		Municipality::where('pkMun', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_municipality_delete_success'] ?? "Municipality Successfully deleted";
            }
    	}

    	return response()->json($response);
    }

    public function getMunicipalitiesByCanton(Request $request)
    {
      /**
       * Used for Admin get Municipalities By Canton
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['cid'])){
    		$sdata = Municipality::select('pkMun','mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName')->where('fkMunCan','=',$input['cid'])->get();
    		if(!empty($sdata)){
    			$response['data'] = $sdata;
    			$response['status'] = true;
    		}else{
    			$response['status'] = false;
    		}
    	}else{
    		$response['status'] = false;
	        $response['message'] = "Please select a canton";
    	}

    	return response()->json($response);
    }

    
}