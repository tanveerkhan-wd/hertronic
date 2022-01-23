<?php
/**
* AcademicDegreeController 
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
use App\Models\AcademicDegree;
use App\Models\EmployeesEducationDetail;
use Validator;
use Carbon\Carbon;
use Auth;
use Hash;
use Redirect;

class AcademicDegreeController extends Controller
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
	
    public function academicDegrees(Request $request)
    {
        /**
         * Used for Admin Education Degrees
         * @return redirect to Admin->Education Degrees
         */
        if (request()->ajax()) {
            return \View::make('admin.academicDegrees.academicDegrees')->renderSections();
        }
        return view('admin.academicDegrees.academicDegrees');
    }

    public function getAcademicDegrees(Request $request)
    {
      /**
       * Used for Admin AcademicDegrees Listing
       */
        $data =$request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    
        $sort_col =  $data['order'][0]['column'];

        $sort_field = $data['columns'][$sort_col]['data'];

        $academic = new AcademicDegree;
          
        if($filter){
            $academic = $academic->where( 'acd_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'acd_AcademicDegreeName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
        }

        $academicQuery = $academic;

        if($sort_col != 0){
            $academicQuery = $academicQuery->orderBy($sort_field, $sort_type);
        }

        $total_academics = $academicQuery->count();

          $offset = $data['start'];
         
          $counter = $offset;
          $academicdata = [];
          $academics = $academicQuery->offset($offset)->limit($perpage);
          $filtered_countries = $academicQuery->offset($offset)->limit($perpage)->count();
          $academics = $academicQuery->select('pkAcd','acd_AcademicDegreeName_'.$this->current_language.' as acd_AcademicDegreeName','acd_Uid','acd_Notes')->offset($offset)->limit($perpage)->get()->toArray();

          foreach ($academics as $key => $value) {
              $value['index'] = $counter+1;
              $academicdata[$counter] = $value;
              $counter++;
          }

          $price = array_column($academicdata, 'index');

          if($sort_col == 0){
              if($sort_type == 'desc'){
                  array_multisort($price, SORT_DESC, $academicdata);
              }else{
                  array_multisort($price, SORT_ASC, $academicdata);
              }
          }

          $result = array(
            "draw" => $data['draw'],
              "recordsTotal" =>$total_academics ,
              "recordsFiltered" => $total_academics ,
             'data' => $academicdata,
          );

          return response()->json($result);
    }

    public function addAcademicDegree(Request $request)
    {
      /**
       * Used for Admin AcademicDegrees Add
       */
        $input = $request->all();
        $response = [];
        if(!empty($input['pkAcd'])){
            $checkPrev = AcademicDegree::where('acd_AcademicDegreeName_'.$this->current_language,$input['acd_AcademicDegreeName_'.$this->current_language])->where('pkAcd','!=',$input['pkAcd'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_academic_degree_exist'] ?? "Academic Degree already exists with this name";
            }else{
              $id = AcademicDegree::where('pkAcd', $input['pkAcd'])
                    ->update($input);
              $response['status'] = true;
              $response['message'] = $this->translations['msg_academic_degree_update_success'] ?? "Academic Degree Successfully Updated";
            }
        }else{
            $checkPrev = AcademicDegree::where('acd_AcademicDegreeName_'.$this->current_language,$input['acd_AcademicDegreeName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_academic_degree_exist'] ?? "Academic Degree already exists with this name";
            }else{
              $id = AcademicDegree::insertGetId($input);
              if(!empty($id)){
                  $id = AcademicDegree::where('pkAcd', $id)
                    ->update(['acd_Uid' => "EDU".$id]);
                  $response['status'] = true;
                  $response['message'] = $this->translations['msg_academic_degree_add_success'] ?? "Academic Degree Successfully Added";

              }else{
                  $response['status'] = false;
                  $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
              }
            }
            
        }
        
        return response()->json($response);
    }

    public function getAcademicDegree(Request $request)
    {
      /**
       * Used for Edit AcademicDegrees 
       */
      $input = $request->all();
      $cid = $input['cid'];
      $response = [];
      $cdata = AcademicDegree::where('pkAcd','=',$input['cid'])->first();

      if(empty($cid) || empty($cdata)){
        $response['status'] = false;
      }else{
        $response['status'] = true;
        $response['data'] = $cdata;
      }

      return response()->json($response);

    }

    public function deleteAcademicDegree(Request $request)
    {
      /**
       * Used for Delete AcademicDegrees 
       */
      $input = $request->all();
      $cid = $input['cid'];
      $response = [];

      if(empty($cid)){
        $response['status'] = false;
      }else{

      	$eed = EmployeesEducationDetail::where('fkEedAcd',$cid)->get()->count();
  		if($eed != 0){
  			$response['status'] = false;
  			$response['message'] = $this->translations['msg_academic_degree_delete_prompt'] ?? "Sorry, the selected academic title cannot be deleted as it is already being used in the employee's education details";
  		}else{
	        AcademicDegree::where('pkAcd', $cid)
	                ->update(['deleted_at' => now()]);
	        $response['status'] = true;
	        $response['message'] = $this->translations['msg_academic_degree_delete_success'] ?? "Academic Degree Successfully Deleted";

  		}
      }

      return response()->json($response);
    }
  
}