<?php
/**
* PostalCodeController 
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
use App\Models\PostalCode;
use App\Models\Employee;
use App\Models\School;
use App\Models\VillageSchool;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class PostalCodeController extends Controller
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

    public function PostalCodes(Request $request)
    {
        /**
         * Used for Admin PostalCodes
         * @return redirect to Admin->PostalCodes
         */

        $cdata = Municipality::select('pkMun','mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName')->get();
        if (request()->ajax()) {
            return \View::make('admin.postalCodes.postalCodes')->with('data', $cdata)->renderSections();
        }
        return View('admin.postalCodes.postalCodes',['data'=>$cdata]);
    }

    public function getPostalCodes(Request $request)
    {
      /**
       * Used for Admin Postal Codes listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

	    $town_filter = $data['town'];

    	$postalCode = PostalCode::with(array('municipality'=>function($query){
		    $query->select('pkMun','mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName');
		}));

    	if($filter){
    		$postalCode = $postalCode->where ( 'pof_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'pof_PostOfficeName_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere ( 'pof_PostOfficeNumber', 'LIKE', '%' . $filter . '%' );
    	}

    	if($town_filter){
    		$town_filter = $postalCode->where ('fkPofMun','=',$town_filter);
    	}

    	$postalCodeQuery = $postalCode;

    	if($sort_col != 0){
    		$postalCodeQuery = $postalCodeQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_postalcodes= $postalCodeQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $postalCodedata = [];
	      $postalcodes = $postalCodeQuery->offset($offset)->limit($perpage);
	      $filtered_postalcodes = $postalCodeQuery->offset($offset)->limit($perpage)->count();
	      $postalcodes = $postalCodeQuery->select('pkPof','pof_Uid','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName','fkPofMun','pof_PostOfficeNumber','pof_Notes')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($postalcodes as $key => $value) {
	            $value['index'] = $counter+1;
	            $postalCodedata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($postalCodedata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $postalCodedata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $postalCodedata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_postalcodes,
			"recordsFiltered" => $total_postalcodes,
	        "data" => $postalCodedata,
	      );

	       return response()->json($result);
    }

    public function addPostalCode(Request $request)
    {
      /**
       * Used for Add Admin Postal Codes
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkPof'])){
            $checkPrev = PostalCode::where('pof_PostOfficeName_'.$this->current_language,$input['pof_PostOfficeName_'.$this->current_language])->where('pkPof','!=',$input['pkPof'])->first();
            $checkPrevCode = PostalCode::where('pof_PostOfficeNumber', $input['pof_PostOfficeNumber'] )->where('pkPof','!=',$input['pkPof'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_postal_name_exist'] ?? "Postal Code already exists with this name";
            }else if(!empty($checkPrevCode)){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_postal_code_exist'] ?? "Postal Code already exists with this code";
            }else{
        		$id = PostalCode::where('pkPof', $input['pkPof'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_postal_code_update_success'] ?? "Postal Code Successfully Updated";
            }
    	}else{
            $checkPrev = PostalCode::where('pof_PostOfficeName_'.$this->current_language,$input['pof_PostOfficeName_'.$this->current_language])->first();
            $checkPrevCode = PostalCode::where('pof_PostOfficeNumber', $input['pof_PostOfficeNumber'] )->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_postal_name_exist'] ?? "Postal Code already exists with this name";
            }else if(!empty($checkPrevCode)){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_postal_code_exist'] ?? "Postal Code already exists with this code";
            }else{
        		$id = PostalCode::insertGetId($input);
    			if(!empty($id)){
    				$id = PostalCode::where('pkPof', $id)
    	              ->update(['pof_Uid' => "ZIP".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_postal_code_add_success'] ?? "Postal Code Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getPostalCode(Request $request)
    {
      /**
       * Used for Edit Admin Postal Codes
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = PostalCode::where('pkPof','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function deletePostalCode(Request $request)
    {
      /**
       * Used for Delete  Admin Postal Codes
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $School = School::where('fkSchPof',$cid)->get()->count();
            $Employee = Employee::where('fkEmpPof',$cid)->get()->count();
            $VillageSchool = VillageSchool::where('fkVscPof',$cid)->get()->count();
            //fkStuPof
            if($School != 0 || $Employee != 0 || $VillageSchool != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_postal_code_delete_prompt'] ?? "Sorry, the selected postal code cannot be deleted as it is already being used by schools, employees, village schools";
            }else{
        		PostalCode::where('pkPof', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_postal_code_delete_success'] ?? "Postal Code Successfully deleted";
            }
    	}

    	return response()->json($response);
    }

    public function getPostalCodesByTown(Request $request)
    {
      /**
       * Used for get Admin Postal Codes by Town
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['cid'])){
    		$sdata = PostalCode::select('pkPof','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName')->where('fkPofMun','=',$input['cid'])->get();
    		if(!empty($sdata)){
    			$response['data'] = $sdata;
    			$response['status'] = true;
    		}else{
    			$response['status'] = false;
    		}
    	}else{
    		$response['status'] = false;
	        $response['message'] = "Please select a town";
    	}

    	return response()->json($response);
    }

    
}