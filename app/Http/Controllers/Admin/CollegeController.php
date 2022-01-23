<?php
/**
* CollegeController 
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
use App\Models\College;
use App\Models\OwnershipType;
use App\Models\University;
use App\Models\EmployeesEducationDetail;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class CollegeController extends Controller
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

    public function colleges(Request $request)
    {
        /**
         * Used for Admin Colleges
         * @return redirect to Admin->Colleges
         */
        $cdata = Country::select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName')->get();
        $odata = OwnershipType::select('pkOty','oty_OwnershipTypeName_'.$this->current_language.' as oty_OwnershipTypeName')->get();
        $udata = University::select('pkUni','uni_UniversityName_'.$this->current_language.' as uni_UniversityName')->get();
        if (request()->ajax()) {
            return \View::make('admin.colleges.colleges')->with(['country'=>$cdata,'ownership'=>$odata,'university'=>$udata])->renderSections();
        }
        return view('admin.colleges.colleges',['country'=>$cdata,'ownership'=>$odata,'university'=>$udata]);
    }

    public function getColleges(Request $request)
    {
      /**
       * Used for Get Admin Colleges Listing
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

        $university_filter = $data['university'];

        $college = College::with(['ownershipType'=> function($query){
                // selecting fields from ownership_type table
                $query->select('pkOty','oty_OwnershipTypeName_'.$this->current_language.' as oty_OwnershipTypeName');
            },'country'=> function($query){
                // selecting fields from country table
                $query->select('pkCny','cny_CountryName_'.$this->current_language.' as cny_CountryName');
            },'university'=> function($query){
                // selecting fields from country table
                $query->select('pkUni','uni_UniversityName_'.$this->current_language.' as uni_UniversityName');
            }
        ]);

    	if($filter){
    		$college = $college->where( 'col_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'col_CollegeName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}

        if($country_filter){
            $college = $college->where('fkColCny','=',$country_filter);
        }

    	if($ownership_filter){
    		$college = $college->where('fkColOty','=',$ownership_filter);
    	}

        if($university_filter){
            $college = $college->where('fkColUni','=',$university_filter);
        }

        if($year_filter){
            $college = $college->where('col_YearStartedFounded','=',$year_filter);
        }

    	$collegeQuery = $college;

    	if($sort_col != 0){
    		$collegeQuery = $collegeQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_colleges = $collegeQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $collegedata = [];
	      $colleges = $collegeQuery->offset($offset)->limit($perpage);
	      $filtered_countries = $collegeQuery->offset($offset)->limit($perpage)->count();
	      $colleges = $collegeQuery->select('pkCol','col_Uid','fkColUni','fkColOty','fkColCny','col_YearStartedFounded','col_CollegeName_'.$this->current_language.' as col_CollegeName','col_BelongsToUniversity','col_PicturePath','col_Notes')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($colleges as $key => $value) {
	            $value['index'] = $counter+1;
	            $collegedata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($collegedata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $collegedata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $collegedata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_colleges,
			"recordsFiltered" => $total_colleges,
	        'data' => $collegedata,
	      );

	       return response()->json($result);
    }

    public function addCollege(Request $request)
    {
      /**
       * Used for Add Admin Colleges
       */
    	$input = $request->all();
        $image = $request->file('upload_profile');
    	$response = [];
        if(!empty($image)){
            $input['col_PicturePath'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/colleges');
            $image->move($destinationPath, $input['col_PicturePath']);
            $imgData = College::select('col_PicturePath')->where('pkCol', $input['pkCol'])->first();
            if(!empty($imgData->col_PicturePath)){
                $filepath = public_path('/images/colleges/').$imgData->col_PicturePath;
                if(file_exists($filepath)) {
                   unlink($filepath);
                }
            }
        }
    	unset($input['upload_profile']);
    	if(!empty($input['pkCol'])){
            $checkPrev = College::where('col_CollegeName_'.$this->current_language,$input['col_CollegeName_'.$this->current_language])->where('pkCol','!=',$input['pkCol'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_college_exist'] ?? "College already exists with this name";
            }else{
        		$id = College::where('pkCol', $input['pkCol'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_college_update_success'] ?? "College Successfully Updated";
            }
    	}else{
            $checkPrev = College::where('col_CollegeName_'.$this->current_language,$input['col_CollegeName_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_college_exist'] ?? "College already exists with this name";
            }else{
    		  $id = College::insertGetId($input);
    			if(!empty($id)){
    				$id = College::where('pkCol', $id)
    	              ->update(['col_Uid' => "COL".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_college_add_success'] ?? "College Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	
        return response()->json($response);
    }


    public function getCollege(Request $request)
    {
      /**
       * Used for Edit Admin Colleges
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = College::where('pkCol','=',$input['cid'])->first();
    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
            if(!empty($cdata->col_PicturePath)){
                $cdata->col_PicturePath = url('public/images/colleges').'/'.$cdata->col_PicturePath;
            }
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function deleteCollege(Request $request)
    {
      /**
       * Used for Delete Admin Colleges
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{

            $eed = EmployeesEducationDetail::where('fkEedCol',$cid)->get()->count();

            if($eed != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_college_delete_prompt'] ?? "Sorry, the selected university cannot be deleted as it is already being used by employees education details";
            }else{ 
        		College::where('pkCol', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_college_delete_success'] ?? "College Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }
}