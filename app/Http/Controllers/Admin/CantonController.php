<?php
/**
* CantonController 
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
use App\Models\Municipality;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class CantonController extends Controller
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

    public function cantons(Request $request)
    {
        /**
         * Used for Admin Cantons
         * @return redirect to Admin->Cantons
         */
        $cdata = Country::select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName')->get();
        if (request()->ajax()) {
            return \View::make('admin.cantons.cantons')->with('data', $cdata)->renderSections();
        }
        return view('admin.cantons.cantons',['data'=>$cdata]);
    }

    public function getCantons(Request $request)
    {
      /**
       * Used for admin Cantons listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	
	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

	    $country_filter = $data['country'];

	    $state_filter = $data['state'];

		$canton = Canton::with('state','state.country')->whereHas('state', function($query) use ($country_filter){
		    $query->whereHas('country', function ($query) use ($country_filter){
		        if($country_filter){
		    		$query->where('pkCny','=',$country_filter);
		    	}
		    });
		});


    	if($filter){
    		$canton = $canton->where( 'can_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'can_CantonName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}


    	if($state_filter){
    		$canton = $canton->where('fkCanSta','=',$state_filter);
    	}

    	$cantonQuery = $canton;

    	if($sort_col != 0){
    		$cantonQuery = $cantonQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_cantons= $cantonQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $cantondata = [];
	      $countries = $cantonQuery->offset($offset)->limit($perpage);
	      $filtered_countries = $cantonQuery->offset($offset)->limit($perpage)->count();
	      $countries = $cantonQuery->select('pkCan','can_Uid','can_CantonName_'.$this->current_language.' as can_CantonName','fkCanSta','can_Note','can_Status')->offset($offset)->limit($perpage)->get()->toArray();

	        foreach ($countries as $key => $value) {
	            $value['index'] = $counter+1;
                $value['can_Statu'] = $value['can_Status'];
                if($value['can_Status']=='Active'){
                    $value['can_Status'] = $this->translations['gn_active'] ?? "Active";
                }
                else{
                    $value['can_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
                }
	            $cantondata[$counter] = $value;
	            $counter++;
	        }

	      $price = array_column($cantondata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $cantondata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $cantondata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_cantons,
			"recordsFiltered" => $total_cantons,
	        "data" => $cantondata,
	      );

	       return response()->json($result);
    }

    public function addCanton(Request $request)
    {
      /**
       * Used for add admin Cantons
       */
    	$input = $request->all();
    	$response = [];
    	unset($input['selCountry']);
    	if(!empty($input['pkCan'])){
            $checkPrev = Canton::where('can_CantonName_'.$this->current_language,$input['can_CantonName_'.$this->current_language])->where('pkCan','!=',$input['pkCan'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_canton_exist'] ?? "Canton already exists with this name";
            }else{
        		$id = Canton::where('pkCan', $input['pkCan'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_canton_update_success'] ?? "Canton Successfully Updated";
            }
    	}else{
            $checkPrev = Canton::where('can_CantonName_'.$this->current_language,$input['can_CantonName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_canton_exist'] ?? "Canton already exists with this name";
            }else{
        		$id = Canton::insertGetId($input);
    			if(!empty($id)){
    				$id = Canton::where('pkCan', $id)
    	              ->update(['can_Uid' => "CAN".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_canton_add_success'] ?? "Canton Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	
        return response()->json($response);
    }

    public function getStatesByCountry(Request $request)
    {
      /**
       * Used for get StatesByCountry
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['cid'])){
    		$sdata = State::select('pkSta','sta_StateName_'.$this->current_language)->where('fkStaCny','=',$input['cid'])->get();
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

    public function getCanton(Request $request)
    {
      /**
       * Used for Edit Canton
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Canton::where('pkCan','=',$input['cid'])->first();
    	$sdata = State::select('fkStaCny')->where('pkSta','=',$cdata['fkCanSta'])->first();
    	$cdata['selCountry'] = $sdata['fkStaCny'];
    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function deleteCanton(Request $request)
    {
      /**
       * Used for Delete Canton
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $Admin = Admin::where('fkAdmCan',$cid)->get()->count();
            $Municipality = Municipality::where('fkMunCan',$cid)->get()->count();
            if($Admin != 0 || $Municipality != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_canton_delete_prompt'] ?? "Sorry, the selected canton cannot be deleted as it is already being used by admins, municipalities";
            }else{
        		Canton::where('pkCan', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_canton_delete_success'] ?? "Canton Successfully deleted";
            }
    	}

    	return response()->json($response);
    }
}