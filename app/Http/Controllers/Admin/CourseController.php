<?php
/**
* CourseController 
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
use App\Models\Course;
use App\Models\EducationPlansMandatoryCourse;
use App\Models\EducationPlansForeignLanguage;
use App\Models\EducationPlansOptionalCourse;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class CourseController extends Controller
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

    public function courses(Request $request)
    {
        /**
         * Used for Admin courses
         * @return redirect to Admin->courses
         */
        if (request()->ajax()) {
            return \View::make('admin.courses.courses')->renderSections();
        }
        return view('admin.courses.courses');
    }

    public function addCourse(Request $request)
    {
      /**
       * Used for Add Admin Course
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['pkCrs'])){
            $checkPrev = Course::where('crs_CourseName_'.$this->current_language,$input['crs_CourseName_'.$this->current_language])->where('pkCrs','!=',$input['pkCrs'])->first();
            $checkPrevUid = Course::where('crs_Uid',$input['crs_Uid'])->where('pkCrs','!=',$input['pkCrs'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_course_exist'] ?? "Course already exists with this name";
            }elseif(!empty($checkPrevUid)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_course_uid_exist'] ?? "Course already exists with this UID";
            }else{
        		$id = Course::where('pkCrs', $input['pkCrs'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_course_update_success'] ?? "Course Successfully Updated";
            }
    	}else{
            $checkPrev = Course::where('crs_CourseName_'.$this->current_language,$input['crs_CourseName_'.$this->current_language])->first();
            $checkPrevUid = Course::where('crs_Uid',$input['crs_Uid'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_course_exist'] ?? "Course already exists with this name";
            }elseif(!empty($checkPrevUid)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_course_uid_exist'] ?? "Course already exists with this UID";
            }else{
        		$id = Course::insertGetId($input);
    			if(!empty($id)){
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_course_add_success'] ?? "Course Successfully Added";
    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getCourse(Request $request)
    {
      /**
       * Used for Edit Admin Course
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Course::where('pkCrs','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getcourses(Request $request)
    {
      /**
       * Used for Get Admin Course Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$Course = new Course;

    	if($filter){
    		$Course = $Course->where ( 'crs_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'crs_CourseName_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere ( 'crs_CourseAlternativeName', 'LIKE', '%' . $filter . '%' );
    	}
    	$CourseQuery = $Course;

    	if($sort_col != 0){
    		$CourseQuery = $CourseQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_courses= $CourseQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $Coursedata = [];
	      $courses = $CourseQuery->offset($offset)->limit($perpage);
	      // var_dump($courses->toSql(),$courses->getBindings());
	      $filtered_courses = $CourseQuery->offset($offset)->limit($perpage)->count();
	      $courses = $CourseQuery->select('pkCrs','crs_Uid','crs_CourseName_'.$this->current_language.' as crs_CourseName','crs_Notes','crs_CourseAlternativeName')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($courses as $key => $value) {
	            $value['index']      = $counter+1;
	            $Coursedata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($Coursedata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $Coursedata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $Coursedata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_courses,
			"recordsFiltered" => $total_courses,
	        'data' => $Coursedata,
	      );

	       return response()->json($result);
    }


    public function deleteCourse(Request $request)
    {
      /**
       * Used for Delete Admin Course
       */

    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{

        $epmc = EducationPlansMandatoryCourse::where('fkEplCrs',$cid)->get()->count();
        $epfc = EducationPlansForeignLanguage::where('fkEflCrs',$cid)->get()->count();
        $epoc = EducationPlansOptionalCourse::where('fkEocCrs',$cid)->get()->count();

        if($epmc != 0 || $epfc != 0 || $epoc != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_course_delete_prompt'] ?? "Sorry, the selected course cannot be deleted as it is already being used by school education plans";
        }else{
      		Course::where('pkCrs', $cid)
  	              ->update(['deleted_at' => now()]);
      		$response['status'] = true;
          $response['message'] = $this->translations['msg_course_delete_success'] ?? "Course Successfully Deleted";
        }
    	}

    	return response()->json($response);
    }


}