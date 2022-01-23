<?php
/**
* EducationPlanController 
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
use App\Models\NationalEducationPlan;
use App\Models\EducationPlan;
use App\Models\EducationProgram;
use App\Models\EducationProfile;
use App\Models\QualificationDegree;
use App\Models\Grade;
use App\Models\Course;
use App\Models\OptionalCoursesGroup;
use App\Models\ForeignLanguageGroup;
use App\Models\EducationPlansMandatoryCourse;
use App\Models\EducationPlansOptionalCourse;
use App\Models\EducationPlansForeignLanguage;
use App\Models\SchoolEducationPlanAssignment;

use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class EducationPlanController extends Controller
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

    public function educationPlans(Request $request)
    {
        /**
         * Used for Admin Education Plans
         * @return redirect to Admin->Education Plans
         */
        if (request()->ajax()) {
            return \View::make('admin.educationPlans.educationPlans')->renderSections();
        }
        return view('admin.educationPlans.educationPlans');
    }

    public function addEducationPlan(Request $request)
    {
        /**
         * Used for Add Education Plan
         * @return redirect to Admin->Education Plan
         */

        $grade = Grade::select('pkGra', 'gra_GradeNameRoman' ,'gra_GradeName_'.$this->current_language.' as gra_GradeName')->get();
        $course = Course::select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','!=','DummyOptionalCourse')->where('crs_CourseType','!=','DummyForeignCourse')->get();
        $optionalCoursesGroup = Course::select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyOptionalCourse')->get();
        $foreignLanguageGroup = Course::select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyForeignCourse')->get();
        // $educationProgram = EducationProgram::get();
        $streams = EducationProgram::select('pkEdp','edp_ParentId', 'edp_Name_'.$this->current_language.' as edp_Name')->get()->toArray();
        $educationProgram = FrontHelper::buildtree($streams);
        $educationProfile = EducationProfile::select('pkEpr', 'epr_EducationProfileName_'.$this->current_language.' as epr_EducationProfileName')->get();
        $qualificationDegree = QualificationDegree::select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName')->get();
        $nationalEducationPlan = NationalEducationPlan::select('pkNep','nep_NationalEducationPlanName_'.$this->current_language.' as nep_NationalEducationPlanName')->get();


        if (request()->ajax()) {
            return \View::make('admin.educationPlans.addEducationPlan')->with(['grade'=>$grade, 'course'=>$course, 'optionalCoursesGroup'=>$optionalCoursesGroup, 'foreignLanguageGroup'=>$foreignLanguageGroup, 'educationProgram'=>$educationProgram, 'educationProfile'=>$educationProfile, 'qualificationDegree'=>$qualificationDegree, 'nationalEducationPlan'=>$nationalEducationPlan])->renderSections();
        }
        return view('admin.educationPlans.addEducationPlan',['grade'=>$grade, 'course'=>$course, 'optionalCoursesGroup'=>$optionalCoursesGroup, 'foreignLanguageGroup'=>$foreignLanguageGroup, 'educationProgram'=>$educationProgram, 'educationProfile'=>$educationProfile, 'qualificationDegree'=>$qualificationDegree, 'nationalEducationPlan'=>$nationalEducationPlan]);
    }

    public function addEducationPlanPost(Request $request)
    {
      /**
       * Used for Add Admin Education Plan
       */
    	$input = $request->all();
    	$response = [];
        // var_dump($input);die();
        $MCGdata = [];
        $OCGdata = [];
        $FCGdata = [];

        $MCG = explode(',', $input['MCG']);
        $OCG = explode(',', $input['OCG']);
        $FCG = explode(',', $input['FCG']);
        unset($input['MCG']);
        unset($input['OCG']);
        unset($input['FCG']);
        $mcg_hrs = $input['mcg_hrs'];
        $ocg_hrs = $input['ocg_hrs'];
        $fcg_hrs = $input['fcg_hrs'];
        unset($input['mcg_hrs']);
        unset($input['ocg_hrs']);
        unset($input['fcg_hrs']);
        unset($input['pkEpl']);
        
        $checkPrev = EducationPlan::where('epl_EducationPlanName_'.$this->current_language,$input['epl_EducationPlanName_'.$this->current_language])->first();
        if(!empty($checkPrev)){
          $response['status'] = false;
          $response['message'] = $this->translations["sidebar_nav_education_plan"]." ".$this->translations["msg_name_already_exist"];
        }else{
    		$id = EducationPlan::insertGetId($input);
			if(!empty($id)){
				EducationPlan::where('pkEpl', $id)
	              ->update(['epl_Uid' => "EPL".$id]);

                foreach($MCG as $k => $v){
                    $MCGdata[] = ['fkEmcEpl'=>$id, 'fkEplCrs'=> $v, 'emc_hours'=>$mcg_hrs[$k]];
                }
                foreach($OCG as $k => $v){
                    $OCGdata[] = ['fkEocEpl'=>$id, 'fkEocCrs'=> $v, 'eoc_hours'=>$ocg_hrs[$k]];
                }
                foreach($FCG as $k => $v){
                    $FCGdata[] = ['fkEflEpl'=>$id, 'fkEflCrs'=> $v, 'efc_hours'=>$fcg_hrs[$k]];
                }

                EducationPlansMandatoryCourse::insert($MCGdata);
                EducationPlansOptionalCourse::insert($OCGdata);
                EducationPlansForeignLanguage::insert($FCGdata);

				$response['status'] = true;
	            $response['message'] = $this->translations['msg_education_plan_add_success'] ?? "Education Plan Successfully Added";

	        }else{
	            $response['status'] = false;
	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
	        }
        }
    	
        return response()->json($response);
    }

    public function editEducationPlan($id)
    {
      /**
       * Used for Edit Admin Education Plan
       */

    	if(!empty($id)){
            $mdata = EducationPlan::with(['grades'=> function($query){
                    $query->select('pkGra', 'gra_GradeNameRoman' ,'gra_GradeName_'.$this->current_language.' as gra_GradeName');
                },
                'educationProfile'=> function($query){
                    $query->select('pkEpr','epr_EducationProfileName_'.$this->current_language.' as epr_EducationProfileName');
                },
                'educationProgram'=> function($query){
                    $query->select('pkEdp','edp_Name_'.$this->current_language.' as edp_Name');
                },
                'nationalEducationPlan'=> function($query){
                    $query->select('pkNep','nep_NationalEducationPlanName_'.$this->current_language.' as nep_NationalEducationPlanName');
                },
                'QualificationDegree'=> function($query){
                    $query->select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName');
                },
                'mandatoryCourse.mandatoryCourseGroup'=> function($query){
                    $query->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','!=','DummyOptionalCourse')->where('crs_CourseType','!=','DummyForeignCourse');
                },
                'optionalCourse.optionalCoursesGroup'=> function($query){
                    $query->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyOptionalCourse');
                },
                'foreignLanguageCourse.foreignLanguageGroup'=> function($query){
                    $query->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyForeignCourse');
                }
            ]);
            $mdata = $mdata->where('pkEpl','=',$id)->where('deleted_at','=',null)->first();
        }

        $grade = Grade::select('pkGra', 'gra_GradeNameRoman' ,'gra_GradeName_'.$this->current_language.' as gra_GradeName')->get();
        $course = Course::select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','!=','DummyOptionalCourse')->where('crs_CourseType','!=','DummyForeignCourse')->get();
        $optionalCoursesGroup = Course::select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyOptionalCourse')->get();
        $foreignLanguageGroup = Course::select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyForeignCourse')->get();
        $streams = EducationProgram::select('pkEdp','edp_ParentId', 'edp_Name_'.$this->current_language.' as edp_Name')->get()->toArray();
        $educationProgram = FrontHelper::buildtree($streams);
        $educationProfile = EducationProfile::select('pkEpr', 'epr_EducationProfileName_'.$this->current_language.' as epr_EducationProfileName')->get();
        $qualificationDegree = QualificationDegree::select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName')->get();
        $nationalEducationPlan = NationalEducationPlan::select('pkNep','nep_NationalEducationPlanName_'.$this->current_language.' as nep_NationalEducationPlanName')->get();

        if (request()->ajax()) {
            return \View::make('admin.educationPlans.editEducationPlan')->with(['grade'=>$grade, 'course'=>$course, 'optionalCoursesGroup'=>$optionalCoursesGroup, 'foreignLanguageGroup'=>$foreignLanguageGroup, 'educationProgram'=>$educationProgram, 'educationProfile'=>$educationProfile, 'qualificationDegree'=>$qualificationDegree, 'nationalEducationPlan'=>$nationalEducationPlan, 'mdata'=>$mdata])->renderSections();
        }
        return view('admin.educationPlans.editEducationPlan',['grade'=>$grade, 'course'=>$course, 'optionalCoursesGroup'=>$optionalCoursesGroup, 'foreignLanguageGroup'=>$foreignLanguageGroup, 'educationProgram'=>$educationProgram, 'educationProfile'=>$educationProfile, 'qualificationDegree'=>$qualificationDegree, 'nationalEducationPlan'=>$nationalEducationPlan, 'mdata'=>$mdata]);


    }

    public function editEducationPlanPost(Request $request)
    {
        /**
       * Used for Admin Education Plan Update
       */
        $input = $request->all();
        $response = [];
        // var_dump($input);die();
        $MCGdata = [];
        $OCGdata = [];
        $FCGdata = [];

        $MCG = explode(',', $input['MCG']);
        $OCG = explode(',', $input['OCG']);
        $FCG = explode(',', $input['FCG']);
        unset($input['MCG']);
        unset($input['OCG']);
        unset($input['FCG']);
        $mcg_hrs = $input['mcg_hrs'];
        $ocg_hrs = $input['ocg_hrs'];
        $fcg_hrs = $input['fcg_hrs'];
        unset($input['mcg_hrs']);
        unset($input['ocg_hrs']);
        unset($input['fcg_hrs']);
        //unset($input['pkEpl']);
        
        $checkPrev = EducationPlan::where('epl_EducationPlanName_'.$this->current_language,$input['epl_EducationPlanName_'.$this->current_language])->where('pkEpl','!=',$input['pkEpl'])->first();
        if(!empty($checkPrev)){
          $response['status'] = false;
          $response['message'] = $this->translations["sidebar_nav_education_plan"]." ".$this->translations["msg_name_already_exist"];
        }else{
            $id = EducationPlan::where('pkEpl', $input['pkEpl'])
                  ->update($input);

            EducationPlansMandatoryCourse::where('fkEmcEpl', $input['pkEpl'])->forceDelete();
            EducationPlansOptionalCourse::where('fkEocEpl', $input['pkEpl'])->forceDelete();
            EducationPlansForeignLanguage::where('fkEflEpl', $input['pkEpl'])->forceDelete();

            foreach($MCG as $k => $v){
                $MCGdata[] = ['fkEmcEpl'=>$input['pkEpl'], 'fkEplCrs'=> $v, 'emc_hours'=>$mcg_hrs[$k]];
            }
            foreach($OCG as $k => $v){
                $OCGdata[] = ['fkEocEpl'=>$input['pkEpl'], 'fkEocCrs'=> $v, 'eoc_hours'=>$ocg_hrs[$k]];
            }
            foreach($FCG as $k => $v){
                $FCGdata[] = ['fkEflEpl'=>$input['pkEpl'], 'fkEflCrs'=> $v, 'efc_hours'=>$fcg_hrs[$k]];
            }

            EducationPlansMandatoryCourse::insert(array_reverse($MCGdata));
            EducationPlansOptionalCourse::insert(array_reverse($OCGdata));
            EducationPlansForeignLanguage::insert(array_reverse($FCGdata));

            $response['status'] = true;
            $response['message'] = $this->translations['msg_education_plan_update_success'] ?? "Education Plan Successfully Updated";

        }
        
        return response()->json($response);
    }

    public function getEducationPlans(Request $request)
    {
      /**
       * Used for Admin Education Plan Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

        $EducationPlan = EducationPlan::with(['grades'=> function($query){
                // selecting fields from ownership_type table
                $query->select('pkGra', 'gra_GradeNameRoman' ,'gra_GradeName_'.$this->current_language.' as gra_GradeName');
            }
            // ,'country'=> function($query){
            //     // selecting fields from country table
            //     $query->select('pkCny','cny_CountryName');
            // }
        ]);

    	if($filter){
    		$EducationPlan = $EducationPlan->where ( 'epl_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'epl_EducationPlanName_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
    	}
    	$EducationPlanQuery = $EducationPlan;

    	if($sort_col != 0){
    		$EducationPlanQuery = $EducationPlanQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_EducationPlan = $EducationPlanQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $EducationPlanData = [];
	      $EducationPlans = $EducationPlanQuery->offset($offset)->limit($perpage);
	      // var_dump($EducationPlans->toSql(),$EducationPlans->getBindings());
	      $EducationPlans = $EducationPlanQuery->select('*','epl_EducationPlanName_'.$this->current_language.' as epl_EducationPlanName')->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($EducationPlans as $key => $value) {
	            $value['index']      = $counter+1;
	            $EducationPlanData[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($EducationPlanData, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $EducationPlanData);
	     	}else{
	     		array_multisort($price, SORT_ASC, $EducationPlanData);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			  "recordsTotal" =>$total_EducationPlan,
			  "recordsFiltered" => $total_EducationPlan,
	         'data' => $EducationPlanData,
	      );

	       return response()->json($result);
    }

    public function viewEducationPlan($id)
    {
      /**
       * Used for View Education Plan
       */
        $mdata = '';
        if(!empty($id)){
            $mdata = EducationPlan::with(['grades'=> function($query){
                    $query->select('pkGra', 'gra_GradeNameRoman' ,'gra_GradeName_'.$this->current_language.' as gra_GradeName');
                },
                'educationProfile'=> function($query){
                    $query->select('pkEpr', 'epr_EducationProfileName_'.$this->current_language.' as epr_EducationProfileName');
                },
                'educationProgram'=> function($query){
                    $query->select('pkEdp', 'edp_Name_'.$this->current_language.' as edp_Name');
                },
                'nationalEducationPlan'=> function($query){
                    $query->select('pkNep','nep_NationalEducationPlanName_'.$this->current_language.' as nep_NationalEducationPlanName');
                },
                'QualificationDegree'=> function($query){
                    $query->select('pkQde','qde_QualificationDegreeName_'.$this->current_language.' as qde_QualificationDegreeName');
                },
                'mandatoryCourse.mandatoryCourseGroup'=> function($query){
                    $query->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','!=','DummyOptionalCourse')->where('crs_CourseType','!=','DummyForeignCourse');
                },
                'optionalCourse.optionalCoursesGroup'=> function($query){
                    $query->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyOptionalCourse');
                },
                'foreignLanguageCourse.foreignLanguageGroup'=> function($query){
                    $query->select('pkCrs', 'crs_CourseName_'.$this->current_language.' as crs_CourseName')->where('crs_CourseType','=','DummyForeignCourse');
                }
            ]);
            $mdata = $mdata->where('pkEpl','=',$id)->where('deleted_at','=',null)->first();

        }
        if (request()->ajax()) {
            return \View::make('admin.educationPlans.viewEducationPlan')->with('mdata', $mdata)->renderSections();
        }
        return view('admin.educationPlans.viewEducationPlan',['mdata'=>$mdata]);

    }


    public function deleteEducationPlan(Request $request)
    {
      /**
       * Used for Delete Admin Education Plan
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
            $eed = SchoolEducationPlanAssignment::where('fkSepEpl',$cid)->get()->count();
            //StudentEnrollment::where('fkSteEpl',$cid)->get()->count();

            if($eed != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_education_plan_delete_prompt'] ?? "Sorry, the selected education plan cannot be deleted as it is already being used by school education plans, student enrollments";
            }else{ 
        		EducationPlan::where('pkEpl', $cid)
    	              ->update(['deleted_at' => now()]);
        		$response['status'] = true;
                $response['message'] = $this->translations['msg_education_plan_delete_success'] ?? "Education Plan Successfully Deleted";
            }
    	}

    	return response()->json($response);
    }


}