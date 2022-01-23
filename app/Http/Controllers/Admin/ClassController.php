<?php
/**
* ClassController 
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
use App\Models\Classes;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class ClassController extends Controller
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

    public function classes(Request $request)
    {
        /**
         * Used for Admin Classes
         * @return redirect to Admin->Classes
         */
        if (request()->ajax()) {
            return \View::make('admin.classes.classes')->renderSections();
        }
        return view('admin.classes.classes');
    }

    public function addclass(Request $request)
    {
      /**
       * Used for Add Admin Class
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkCla'])){
            $checkPrev = Classes::where('cla_ClassName_'.$this->current_language,$input['cla_ClassName_'.$this->current_language])->where('pkCla','!=',$input['pkCla'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_class_exist'] ?? "Class already exists with this name";
            }else{
        		$id = Classes::where('pkCla', $input['pkCla'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_class_update_success'] ?? "Class Successfully Updated";
            }
    	}else{
            $checkPrev = Classes::where('cla_ClassName_'.$this->current_language,$input['cla_ClassName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_class_exist'] ?? "Class already exists with this name";
            }else{
        		$id = Classes::insertGetId($input);
    			if(!empty($id)){
    				$id = Classes::where('pkCla', $id)
    	              ->update(['cla_Uid' => "CLA".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_class_add_success'] ?? "Class Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getClass(Request $request)
    {
      /**
       * Used for Edit Admin Class
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Classes::where('pkCla','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getClasses(Request $request)
    {
      /**
       * Used for Admin Class Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$class = new Classes;

    	if($filter){
    		$class = $class->where ( 'cla_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'cla_ClassName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}
    	$classQuery = $class;

    	if($sort_col != 0){
    		$classQuery = $classQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_Classes= $classQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $classdata = [];
	      $Classes = $classQuery->offset($offset)->limit($perpage);
	      // var_dump($Classes->toSql(),$Classes->getBindings());
	      $filtered_Classes = $classQuery->offset($offset)->limit($perpage)->count();
	      $Classes = $classQuery->select('pkCla','cla_ClassName_'.$this->current_language.' as cla_ClassName','cla_Notes','cla_Uid')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($Classes as $key => $value) {
	            $value['index']      = $counter+1;
	            $classdata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($classdata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $classdata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $classdata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_Classes,
			"recordsFiltered" => $total_Classes,
	        'data' => $classdata,
	      );

	       return response()->json($result);
    }


    public function deleteClass(Request $request)
    {
      /**
       * Used for Delete Admin Class
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $eed = 0;
            //Attendence::where('fkAtdCla',$cid)->get()->count();
            //PeriodicExam::where('fkPdeCla',$cid)->get()->count();
            //ClassCreation::where('fkClrCla',$cid)->get()->count();

            if($eed != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_class_delete_prompt'] ?? "Sorry, the selected class cannot be deleted as it is already being used by class creation, exams, attendence";
            }else{ 
        		Classes::where('pkCla', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_class_delete_success'] ?? "Class Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }


}