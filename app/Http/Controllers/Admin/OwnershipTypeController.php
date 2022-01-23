<?php
/**
* OwnershipTypeController 
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
use App\Models\OwnershipType;
use App\Models\College;
use App\Models\School;
use App\Models\University;
use Validator;
use Carbon\Carbon;
use Auth;
use Hash;
use Redirect;

class OwnershipTypeController extends Controller
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
	
    public function ownershipTypes(Request $request)
    {
        /**
         * Used for Admin Ownership Type
         * @return redirect to Admin->Ownership Type
         */
        if (request()->ajax()) {
            return \View::make('admin.ownershipTypes.ownershipTypes')->renderSections();
        }
        return view('admin.ownershipTypes.ownershipTypes');
    }

    public function getOwnershipTypes(Request $request)
    {
      /**
       * Used for Admin Ownership Types listing
       */
        $data =$request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    
        $sort_col =  $data['order'][0]['column'];

        $sort_field = $data['columns'][$sort_col]['data'];

        $academic = new OwnershipType;
          
        if($filter){
            $academic = $academic->where( 'oty_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'oty_OwnershipTypeName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
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
          $academics = $academicQuery->select('*','oty_OwnershipTypeName_'.$this->current_language.' as oty_OwnershipTypeName')->offset($offset)->limit($perpage)->get()->toArray();

          foreach ($academics as $key => $value) {
              $value['index'] = $counter+1;
              $value['oty_Statu'] = $value['oty_Status'];
              if($value['oty_Status']=='Active'){
                $value['oty_Status'] = $this->translations['gn_active'] ?? "Active";
              }
              else{
                $value['oty_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
              }
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

    public function addOwnershipType(Request $request)
    {
      /**
       * Used for Add Admin Ownership Types
       */
        $input = $request->all();
        $response = [];
        if(!empty($input['pkOty'])){
          $checkPrev = OwnershipType::where('oty_OwnershipTypeName_'.$this->current_language,$input['oty_OwnershipTypeName_'.$this->current_language])->where('pkOty','!=',$input['pkOty'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_ownership_type_exist'] ?? "Ownership Type already exists with this name";
            }else{
              $id = OwnershipType::where('pkOty', $input['pkOty'])
                    ->update($input);
              $response['status'] = true;
              $response['message'] = $this->translations['msg_ownership_type_update_success'] ?? "Ownership Type Successfully Updated";
            }
        }else{
          $checkPrev = OwnershipType::where('oty_OwnershipTypeName_'.$this->current_language,$input['oty_OwnershipTypeName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_ownership_type_exist'] ?? "Ownership Type already exists with this name";
            }else{
              $id = OwnershipType::insertGetId($input);
              if(!empty($id)){
                  $id = OwnershipType::where('pkOty', $id)
                    ->update(['oty_Uid' => "OWN".$id]);
                  $response['status'] = true;
                  $response['message'] = $this->translations['msg_ownership_type_add_success'] ?? "Ownership Type Successfully Added";

              }else{
                  $response['status'] = false;
                  $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
              }
            }
        }
        
        return response()->json($response);
    }

    public function getOwnershipType(Request $request)
    {
      /**
       * Used for Edit Admin Ownership Types
       */
      $input = $request->all();
      $cid = $input['cid'];
      $response = [];
      $cdata = OwnershipType::where('pkOty','=',$input['cid'])->first();

      if(empty($cid) || empty($cdata)){
        $response['status'] = false;
      }else{
        $response['status'] = true;
        $response['data'] = $cdata;
      }

      return response()->json($response);

    }

    public function deleteOwnershipType(Request $request)
    {
      /**
       * Used for Delete Admin Ownership Types
       */
      $input = $request->all();
      $cid = $input['cid'];
      $response = [];

      if(empty($cid)){
        $response['status'] = false;
      }else{
        $College = College::where('fkColOty',$cid)->get()->count();
        $University = University::where('fkUniOty',$cid)->get()->count();
        $School = School::where('fkSchOty',$cid)->get()->count();

        if($College != 0 || $School != 0 || $University != 0 ){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_ownershiptype_delete_prompt'] ?? "Sorry, the selected ownership cannot be deleted as it is already being used by the schools, colleges, universities";
        }else{ 
          OwnershipType::where('pkOty', $cid)
                  ->update(['deleted_at' => now()]);
          $response['status'] = true;
          $response['message'] = $this->translations['msg_ownership_delete_success'] ?? "Ownership Successfully deleted";
        }
      }

      return response()->json($response);
    }
  
}