<?php
/**
* CountryController 
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
use App\Models\Employee;
use App\Models\University;
use App\Models\College;
use App\Models\Citizenship;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class CountryController extends Controller
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

    public function countries(Request $request)
    {
        /**
         * Used for Admin Countries
         * @return redirect to Admin->Countries
         */
        if (request()->ajax()) {
            return \View::make('admin.countries.countries')->renderSections();
        }
        return view('admin.countries.countries');
    }

    public function addCountry(Request $request)
    {
      /**
       * Used for Add Admin Country
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkCny'])){
            $checkPrev = Country::where('cny_CountryName_'.$this->current_language,$input['cny_CountryName_'.$this->current_language])->where('pkCny','!=',$input['pkCny'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_country_exist'] ?? "Country already exists with this name";
            }else{
        		$id = Country::where('pkCny', $input['pkCny'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_country_update_success'] ?? "Country Successfully Updated";
            }
    	}else{
            $checkPrev = Country::where('cny_CountryName_'.$this->current_language,$input['cny_CountryName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_country_exist'] ?? "Country already exists with this name";
            }else{
        		$id = Country::insertGetId($input);
    			if(!empty($id)){
    				$id = Country::where('pkCny', $id)
    	              ->update(['cny_Uid' => "CON".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_country_add_success'] ?? "Country Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getCountry(Request $request)
    {
      /**
       * Used for Edit Admin Country
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Country::where('pkCny','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getCountries(Request $request)
    {
      /**
       * Used for Get Admin Country Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$country = new Country;

    	if($filter){
    		$country = $country->where ( 'cny_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'cny_CountryName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
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
	      // var_dump($countries->toSql(),$countries->getBindings());
	      $filtered_countries = $countryQuery->offset($offset)->limit($perpage)->count();
	      $countries = $countryQuery->select('pkCny','cny_Uid','cny_CountryName_'.$this->current_language.' as cny_CountryName','cny_Note','cny_Status')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($countries as $key => $value) {
	            $value['index']      = $counter+1;
                $value['cny_Statu'] = $value['cny_Status'];
                if($value['cny_Status']=='Active'){
                    $value['cny_Status'] = $this->translations['gn_active'] ?? "Active";
                }
                else{
                    $value['cny_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
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


    public function deleteCountry(Request $request)
    {
      /**
       * Used for Delete Admin Country
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $Admin = Admin::where('fkAdmCny',$cid)->get()->count();
            $State = State::where('fkStaCny',$cid)->get()->count();
            $Employee = Employee::where('fkEmpCny',$cid)->get()->count();
            $University = University::where('fkUniCny',$cid)->get()->count();
            $College = College::where('fkColCny',$cid)->get()->count();
            $Citizenship = Citizenship::where('fkCtzCny',$cid)->get()->count();

            if($Admin != 0 || $State != 0 || $Employee != 0 || $University != 0 || $College != 0 || $Citizenship != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_country_delete_prompt'] ?? "Sorry, the selected country cannot be deleted as it is already being used by the employees, admins, colleges, citizenships, states, cantons, universities";
            }else{            
        		Country::where('pkCny', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
            }
    	}

    	return response()->json($response);
    }


}