<?php
/**
* CitizenshipController 
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
use App\Models\Country;
use App\Models\Citizenship;
use App\Models\Employee;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class CitizenshipController extends Controller
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

    public function citizenships(Request $request)
    {
        /**
         * Used for Admin citizenships
         * @return redirect to Admin->citizenships
         */

        $cdata = Country::select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName')->get();
        if (request()->ajax()) {
            return \View::make('admin.citizenships.citizenships')->with('data', $cdata)->renderSections();
        }
        return View('admin.citizenships.citizenships',['data'=>$cdata]);
    }

    public function getCitizenships(Request $request)
    {
      /**
       * Used for Admin Citizenships Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

	    $country_filter = $data['country'];

    	$citizenship = Citizenship::with(array('country'=>function($query){
		    $query->select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName');
		}));

    	if($filter){
    		$citizenship = $citizenship->where ( 'ctz_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'ctz_CitizenshipName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}

    	if($country_filter){
    		$citizenship = $citizenship->where ('fkCtzCny','=',$country_filter);
    	}

    	$citizenshipQuery = $citizenship;

    	if($sort_col != 0){
    		$citizenshipQuery = $citizenshipQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_citizenships= $citizenshipQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $citizenshipdata = [];
	      $citizenships = $citizenshipQuery->offset($offset)->limit($perpage);
	      $filtered_citizenships = $citizenshipQuery->offset($offset)->limit($perpage)->count();
	      $citizenships = $citizenshipQuery->select('pkCtz','ctz_Uid','ctz_CitizenshipName_'.$this->current_language.' as ctz_CitizenshipName','fkCtzCny','ctz_Notes')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($citizenships as $key => $value) {
	            $value['index'] = $counter+1;
	            $citizenshipdata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($citizenshipdata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $citizenshipdata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $citizenshipdata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_citizenships,
			"recordsFiltered" => $total_citizenships,
	        'data' => $citizenshipdata,
	      );

	       return response()->json($result);
    }

    public function addCitizenship(Request $request)
    {
      /**
       * Used for Add Admin Citizenships
       */

    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkCtz'])){
            $checkPrev = Citizenship::where('ctz_CitizenshipName_'.$this->current_language,$input['ctz_CitizenshipName_'.$this->current_language])->where('pkCtz','!=',$input['pkCtz'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_citizenship_exist'] ?? "Citizenship already exists with this name";
            }else{
        		$id = Citizenship::where('pkCtz', $input['pkCtz'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_citizenship_update_success'] ?? "Citizenship Successfully Updated";
            }
    	}else{

            $checkPrev = Citizenship::where('ctz_CitizenshipName_'.$this->current_language,$input['ctz_CitizenshipName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_citizenship_exist'] ?? "Citizenship already exists with this name";
            }else{
        		$id = Citizenship::insertGetId($input);
    			if(!empty($id)){
    				$id = Citizenship::where('pkCtz', $id)
    	              ->update(['ctz_Uid' => "CIZ".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_citizenship_add_success'] ?? "Citizenship Successfully Added";

    	        }else{
    	            $response['status'] = false;
                    $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getCitizenship(Request $request)
    {
      /**
       * Used for Edit Citizenships
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Citizenship::where('pkCtz','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function deleteCitizenship(Request $request)
    {
      /**
       * Used for Delete Admin Citizenships
       */

    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $Employee = Employee::where('fkEmpCtz', $cid)->get()->count();
            $Student = 0;
            //$Student = Student::where('fkStuCtz', $cid)->get()->count();
            if($Employee != 0 || $Student != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_citizenship_delete_prompt'] ?? "Sorry, the selected citizenship cannot be deleted as it is already being used by the employees, students";
            }else{ 
        		Citizenship::where('pkCtz', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_citizenship_delete_success'] ?? "Citizenship Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }

    public function getCitizenshipsByCountry(Request $request)
    {
      /**
       * Used for Get Admin Citizenships By Country
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['cid'])){
    		$sdata = Citizenship::select('pkCtz','ctz_CitizenshipName_'.$this->current_language)->where('fkCtzCny','=',$input['cid'])->get();
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