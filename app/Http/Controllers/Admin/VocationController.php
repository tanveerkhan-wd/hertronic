<?php
/**
* VocationController 
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
use App\Models\Vocation;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class VocationController extends Controller
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

    public function vocations(Request $request)
    {
        /**
         * Used for Admin vocations
         * @return redirect to Admin->vocations
         */
        if (request()->ajax()) {
            return \View::make('admin.vocations.vocations')->renderSections();
        }
        return view('admin.vocations.vocations');
    }

    public function addVocation(Request $request)
    {
      /**
       * Used for Add Admin Vocation
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkVct'])){
            $checkPrev = Vocation::where('vct_VocationName_'.$this->current_language,$input['vct_VocationName_'.$this->current_language])->where('pkVct','!=',$input['pkVct'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_vocation_exist'] ?? "Vocation already exists with this name";
            }else{
        		$id = Vocation::where('pkVct', $input['pkVct'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_vocation_update_success'] ?? "Vocation Successfully Updated";
            }
    	}else{
            $checkPrev = Vocation::where('vct_VocationName_'.$this->current_language,$input['vct_VocationName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_vocation_exist'] ?? "Vocation already exists with this name";
            }else{
        		$id = Vocation::insertGetId($input);
    			if(!empty($id)){
    				$id = Vocation::where('pkVct', $id)
    	              ->update(['vct_Uid' => "VOC".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_vocation_add_success'] ?? "Vocation Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getVocation(Request $request)
    {
      /**
       * Used for Edit Admin Vocation
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Vocation::where('pkVct','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getVocations(Request $request)
    {
      /**
       * Used for Admin Vocation Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$Vocation = new Vocation;

    	if($filter){
    		$Vocation = $Vocation->where ( 'vct_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'vct_VocationName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}
    	$VocationQuery = $Vocation;

    	if($sort_col != 0){
    		$VocationQuery = $VocationQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_vocations= $VocationQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $Vocationdata = [];
	      $vocations = $VocationQuery->offset($offset)->limit($perpage);
	      // var_dump($vocations->toSql(),$vocations->getBindings());
	      $filtered_vocations = $VocationQuery->offset($offset)->limit($perpage)->count();
	      $vocations = $VocationQuery->select('*','vct_VocationName_'.$this->current_language.' as vct_VocationName')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($vocations as $key => $value) {
	            $value['index'] = $counter+1;
	            $Vocationdata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($Vocationdata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $Vocationdata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $Vocationdata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_vocations,
			"recordsFiltered" => $total_vocations,
	        "data" => $Vocationdata,
	      );

	       return response()->json($result);
    }


    public function deleteVocation(Request $request)
    {
      /**
       * Used for Delete Admin Vocation
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		Vocation::where('pkVct', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }


}