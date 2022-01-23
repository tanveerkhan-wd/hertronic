<?php
/**
* UniversityController 
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
use App\Models\OwnershipType;
use App\Models\University;
use App\Models\College;
use App\Models\EmployeesEducationDetail;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class UniversityController extends Controller
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

    public function universities(Request $request)
    {
        /**
         * Used for Admin Universities
         * @return redirect to Admin->Universities
         */
        $cdata = Country::select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName')->get();
        $odata = OwnershipType::select('pkOty','oty_OwnershipTypeName_'.$this->current_language.' as oty_OwnershipTypeName')->get();
        if (request()->ajax()) {
            return \View::make('admin.universities.universities')->with(['country'=>$cdata,'ownership'=>$odata])->renderSections();
        }
        return view('admin.universities.universities',['country'=>$cdata,'ownership'=>$odata]);
    }

    public function getUniversities(Request $request)
    {
      /**
       * Used for Admin University Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	
	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

	    $country_filter = $data['country'];

	    $year_filter = $data['year'];

        $ownership_filter = $data['ownership'];

        $university = University::with(['ownershipType'=> function($query){
                // selecting fields from ownership_type table
                $query->select('pkOty','oty_OwnershipTypeName_'.$this->current_language.' as oty_OwnershipTypeName');
            },'country'=> function($query){
                // selecting fields from country table
                $query->select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName');
            }
        ]);

    	if($filter){
    		$university = $university->where( 'uni_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'uni_UniversityName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}

        if($country_filter){
            $university = $university->where('fkUniCny','=',$country_filter);
        }

    	if($ownership_filter){
    		$university = $university->where('fkUniOty','=',$ownership_filter);
    	}

        if($year_filter){
            $university = $university->where('uni_YearStartedFounded','=',$year_filter);
        }

    	$universityQuery = $university;

    	if($sort_col != 0){
    		$universityQuery = $universityQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_universities = $universityQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $universitydata = [];
	      $universities = $universityQuery->offset($offset)->limit($perpage);
	      $filtered_countries = $universityQuery->offset($offset)->limit($perpage)->count();
	      $universities = $universityQuery->select('pkUni','uni_Uid','uni_UniversityName_'.$this->current_language.' as uni_UniversityName','fkUniCny','fkUniOty','uni_Notes','uni_YearStartedFounded')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($universities as $key => $value) {
	            $value['index'] = $counter+1;
	            $universitydata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($universitydata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $universitydata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $universitydata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_universities,
			"recordsFiltered" => $total_universities,
	        'data' => $universitydata,
	      );

	       return response()->json($result);
    }

    public function addUniversity(Request $request)
    {
      /**
       * Used for Add Admin University
       */
    	$input = $request->all();
        $image = $request->file('upload_profile');
    	$response = [];
        if(!empty($image)){
            $input['uni_PicturePath'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/universities');
            $image->move($destinationPath, $input['uni_PicturePath']);
            $imgData = University::select('uni_PicturePath')->where('pkUni', $input['pkUni'])->first();
            if(!empty($imgData->uni_PicturePath)){
                $filepath = public_path('/images/universities/').$imgData->uni_PicturePath;
                if(file_exists($filepath)) {
                   unlink($filepath);
                }
            }
        }
    	unset($input['upload_profile']);
    	if(!empty($input['pkUni'])){
            $checkPrev = University::where('uni_UniversityName_'.$this->current_language,$input['uni_UniversityName_'.$this->current_language])->where('pkUni','!=',$input['pkUni'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_university_exist'] ?? "University already exists with this name";
            }else{
        		$id = University::where('pkUni', $input['pkUni'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_university_update_success'] ?? "University Successfully Updated";
            }
    	}else{
            $checkPrev = University::where('uni_UniversityName_'.$this->current_language,$input['uni_UniversityName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_university_exist'] ?? "University already exists with this name";
            }else{
        		$id = University::insertGetId($input);
    			if(!empty($id)){
    				$id = University::where('pkUni', $id)
    	              ->update(['uni_Uid' => "UNI".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_university_add_success'] ?? "University Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	
        return response()->json($response);
    }


    public function getUniversity(Request $request)
    {
      /**
       * Used for Edit Admin University
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = University::where('pkUni','=',$input['cid'])->first();
    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
            if(!empty($cdata->uni_PicturePath)){
                $cdata->uni_PicturePath = url('public/images/universities').'/'.$cdata->uni_PicturePath;
            }
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function deleteUniversity(Request $request)
    {
      /**
       * Used for Delete Admin University
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $College = College::where('fkColUni',$cid)->get()->count();
            $eed = EmployeesEducationDetail::where('fkEedUni',$cid)->get()->count();

            if($eed != 0 || $College != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_university_delete_prompt'] ?? "Sorry, the selected university cannot be deleted as it is already being used by the colleges, employees education details";
            }else{ 
        		University::where('pkUni', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_university_delete_success'] ?? "University Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }
}