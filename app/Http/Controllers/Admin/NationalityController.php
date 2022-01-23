<?php
/**
* NationalityController 
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
use App\Models\Nationality;
use App\Models\State;
use App\Models\Canton;
use App\Models\Employee;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class NationalityController extends Controller
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

    public function nationalities(Request $request)
    {
        /**
         * Used for Admin nationalities
         * @return redirect to Admin->nationalities
         */
        if (request()->ajax()) {
            return \View::make('admin.nationalities.nationalities')->renderSections();
        }
        return view('admin.nationalities.nationalities');
    }

    public function addNationality(Request $request)
    {
      /**
       * Used for Add Admin Nationalities
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkNat'])){
            $checkPrev = Nationality::where('nat_NationalityName_'.$this->current_language,$input['nat_NationalityName_'.$this->current_language])->where('pkNat','!=',$input['pkNat'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_nationality_exists'] ?? "Nationality already exists with this name";
            }else{
        		$id = Nationality::where('pkNat', $input['pkNat'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_nationality_update_success'] ?? "Nationality Successfully Updated";
            }
    	}else{
            $checkPrev = Nationality::where('nat_NationalityName_'.$this->current_language,$input['nat_NationalityName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_nationality_exists'] ?? "Nationality already exists with this name";
            }else{
        		$id = Nationality::insertGetId($input);
                if(!empty($id)){
    				$id = Nationality::where('pkNat', $id)
    	              ->update(['nat_Uid' => "NTL".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_nationality_add_success'] ?? "Nationality Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getNationality(Request $request)
    {
      /**
       * Used for Edit Admin Nationalities
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Nationality::where('pkNat','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getNationalities(Request $request)
    {
      /**
       * Used for Admin Nationalities Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$Nationality = new Nationality;

    	if($filter){
    		$Nationality = $Nationality->where ( 'nat_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'nat_NationalityName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}
    	$NationalityQuery = $Nationality;

    	if($sort_col != 0){
    		$NationalityQuery = $NationalityQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_nationalities= $NationalityQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $Nationalitydata = [];
	      $nationalities = $NationalityQuery->offset($offset)->limit($perpage);
	      // var_dump($nationalities->toSql(),$nationalities->getBindings());
	      $filtered_nationalities = $NationalityQuery->offset($offset)->limit($perpage)->count();
	      $nationalities = $NationalityQuery->select('pkNat','nat_Uid','nat_NationalityName_'.$this->current_language.' as nat_NationalityName','nat_NationalityNameMale','nat_NationalityNameFemale','nat_Notes')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($nationalities as $key => $value) {
	            $value['index']      = $counter+1;
	            $Nationalitydata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($Nationalitydata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $Nationalitydata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $Nationalitydata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_nationalities,
			"recordsFiltered" => $total_nationalities,
	        'data' => $Nationalitydata,
	      );

	       return response()->json($result);
    }


    public function deleteNationality(Request $request)
    {
      /**
       * Used for Delete Admin Nationalities
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $Employee = Employee::where('fkEmpNat', $cid)->get()->count();
            $Student = 0;
            //$Student = Student::where('fkStuNat', $cid)->get()->count();
            if($Employee != 0 || $Student != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_nationality_delete_prompt'] ?? "Sorry, the selected nationality cannot be deleted as it is already being used by the employees, students";
            }else{ 
        		Nationality::where('pkNat', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_nationality_delete_success'] ?? "Nationality Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }


}