<?php
/**
* StateController 
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
use App\Models\Admin;
use App\Models\Country;
use App\Models\State;
use App\Models\Canton;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class StateController extends Controller
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

    public function states(Request $request)
    {
        /**
         * Used for Admin States
         * @return redirect to Admin->States
         */

        $cdata = Country::select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName')->get();
        if (request()->ajax()) {
            return \View::make('admin.states.states')->with('data', $cdata)->renderSections();
        }
        return View('admin.states.states',['data'=>$cdata]);
    }

    public function getStates(Request $request)
    {
      /**
       * Used for Admin States Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

	    $country_filter = $data['country'];

    	$country = State::with(array('country'=>function($query){
		    $query->select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName');
		}));

    	if($filter){
    		$country = $country->where ( 'sta_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'sta_StateName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}

    	if($country_filter){
    		$country = $country->where ('fkStaCny','=',$country_filter);
    	}

    	$countryQuery = $country;

    	if($sort_col != 0){
    		$countryQuery = $countryQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_countries= $countryQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $countrydata = [];
	      $countries = $countryQuery->offset($offset)->limit($perpage);
	      $filtered_countries = $countryQuery->offset($offset)->limit($perpage)->count();
	      $countries = $countryQuery->select('pkSta','sta_Uid','sta_StateName_'.$this->current_language.' as sta_StateName','sta_Note','sta_Status','fkStaCny')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($countries as $key => $value) {
	            $value['index'] = $counter+1;
                $value['sta_Statu'] = $value['sta_Status'];
                if($value['sta_Status']=='Active'){
                    $value['sta_Status'] = $this->translations['gn_active'] ?? "Active";
                }
                else{
                    $value['sta_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
                }
	            $countrydata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($countrydata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $countrydata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $countrydata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			  "recordsTotal" =>$total_countries,
			  "recordsFiltered" => $total_countries,
	         'data' => $countrydata,
	      );

	       return response()->json($result);
    }

    public function addState(Request $request)
    {
      /**
       * Used for Add Admin States
       */
    	$input = $request->all();
        $response = [];
    	if(!empty($input['pkSta'])){
            $checkPrev = State::where('sta_StateName_'.$this->current_language,$input['sta_StateName_'.$this->current_language])->where('pkSta','!=',$input['pkSta'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_state_exist'] ?? "State already exists with this name";
            }else{
        		$id = State::where('pkSta', $input['pkSta'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_state_update_success'] ?? "State Successfully Updated";
            }
    	}else{
            $checkPrev = State::where('sta_StateName_'.$this->current_language,$input['sta_StateName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_state_exist'] ?? "State already exists with this name";
            }else{
        		$id = State::insertGetId($input);
    			if(!empty($id)){
    				$id = State::where('pkSta', $id)
    	              ->update(['sta_Uid' => "STA".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_state_add_success'] ?? "State Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getState(Request $request)
    {
      /**
       * Used for Edit Admin States
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = State::where('pkSta','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function deleteState(Request $request)
    {
      /**
       * Used for Delete Admin States
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            
            $Canton = Canton::where('fkCanSta',$cid)->get()->count();
            if($Canton != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_state_delete_prompt'] ?? "Sorry, the selected state cannot be deleted as it is already being used by cantons";
            }else{
        		State::where('pkSta', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_state_delete_success'] ?? "State Successfully deleted";
        	}
        }

    	return response()->json($response);
    }

    public function getStatesByCountry(Request $request)
    {
      /**
       * Used for Get Admin StatesByCountry
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['cid'])){
    		$sdata = State::select('pkSta','cny_CountryName_'.$this->current_language.' as cny_CountryName')->where('fkStaCny','=',$input['cid'])->get();
    		if(!empty($sdata)){
    			$response['data'] = $sdata;
    			$response['status'] = true;
    		}else{
    			$response['status'] = false;
    		}
    	}else{
    		$response['status'] = false;
	        $response['message'] = "Please select a country";
    	}

    	return response()->json($response);
    }

    
}