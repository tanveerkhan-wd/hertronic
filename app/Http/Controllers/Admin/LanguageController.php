<?php
/**
* LanguageController 
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
use App\Models\Language;
use App\Models\Translation;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class LanguageController extends Controller
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

    public function languages(Request $request)
    {
        /**
         * Used for Admin languages
         * @return redirect to Admin->languages
         */
        if (request()->ajax()) {
            return \View::make('admin.languages.languages')->renderSections();
        }
        return view('admin.languages.languages');
    }

    public function addLanguage(Request $request)
    {
        /**
       * Used for Admin Language Add & Update
       */
    	$input = $request->all();
        $image = $request->file('upload_flag');
    	$response = [];

        if(!empty($image)){
            $input['flag'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/languages');
            $image->move($destinationPath, $input['flag']);
            $imgData = Language::select('flag')->where('id', $input['id'])->first();
            if(!empty($imgData->col_PicturePath)){
                $filepath = public_path('/images/languages/').$imgData->col_PicturePath;
                if(file_exists($filepath)) {
                   unlink($filepath);
                }
            }
        }
        unset($input['upload_flag']);
        $prev_id = Language::orderBy('id','desc')->first()->language_key;
    	if(!empty($input['id'])){
            $checkPrevKey = Language::where('language_key',$input['language_key'])->where('id','!=',$input['id'])->first();
            $checkPrev = Language::where('language_name',$input['language_name'])->where('id','!=',$input['id'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_language_exists'] ?? "Language already exists with this name";
            }elseif(!empty($checkPrevKey)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_language_key_exists'] ?? "Language already exists with this key";
            }else{
                $old_key = Language::where('id', $input['id'])->first()->language_key;
                FrontHelper::updateLanguageColumn('AcademicDegrees','acd_AcademicDegreeName_'.$old_key,'acd_AcademicDegreeName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('Citizenships','ctz_CitizenshipName_'.$old_key,'ctz_CitizenshipName_'.$input['language_key'],'varchar(50)');
                FrontHelper::updateLanguageColumn('Cantons','can_CantonName_'.$old_key,'can_CantonName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('Classes', 'cla_ClassName_'.$old_key,'cla_ClassName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('Colleges', 'col_CollegeName_'.$old_key,'col_CollegeName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('Countries', 'cny_CountryName_'.$old_key,'cny_CountryName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('Courses', 'crs_CourseName_'.$old_key,'crs_CourseName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('EducationPeriods', 'edp_EducationPeriodName_'.$old_key, 'edp_EducationPeriodName_'.$input['language_key'],'varchar(50)');
                FrontHelper::updateLanguageColumn('EducationPlans', 'epl_EducationPlanName_'.$old_key, 'epl_EducationPlanName_'.$input['language_key'],'varchar(200)');
                FrontHelper::updateLanguageColumn('EducationProfiles', 'epr_EducationProfileName_'.$old_key, 'epr_EducationProfileName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('EducationPrograms', 'edp_Name_'.$old_key, 'edp_Name_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('EngagementTypes', 'ety_EngagementTypeName_'.$old_key, 'ety_EngagementTypeName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('ExtracurricuralActivityTypes', 'sat_StudentExtracurricuralActivityName_'.$old_key, 'sat_StudentExtracurricuralActivityName_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('FacultativeCoursesGroups', 'fcg_Name_'.$old_key, 'fcg_Name_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('ForeignLanguageGroups', 'fon_Name_'.$old_key, 'fon_Name_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('GeneralPurposeGroups', 'gpg_Name_'.$old_key, 'gpg_Name_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('Grades', 'gra_GradeName_'.$old_key, 'gra_GradeName_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('JobAndWork', 'jaw_Name_'.$old_key,'jaw_Name_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('Municipalities', 'mun_MunicipalityName_'.$old_key,'mun_MunicipalityName_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('NationalEducationPlans', 'nep_NationalEducationPlanName_'.$old_key,'nep_NationalEducationPlanName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('Nationalities', 'nat_NationalityName_'.$old_key,'nat_NationalityName_'.$input['language_key'],'varchar(50)');
                FrontHelper::updateLanguageColumn('OptionalCoursesGroups', 'ocg_Name_'.$old_key,'ocg_Name_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('OwnershipTypes', 'oty_OwnershipTypeName_'.$old_key,'oty_OwnershipTypeName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('PostOffices', 'pof_PostOfficeName_'.$old_key,'pof_PostOfficeName_'.$input['language_key'],'varchar(50)');
                FrontHelper::updateLanguageColumn('QualificationsDegrees', 'qde_QualificationDegreeName_'.$old_key,'qde_QualificationDegreeName_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('Religions', 'rel_ReligionName_'.$old_key,'rel_ReligionName_'.$input['language_key'],'varchar(50)');
                FrontHelper::updateLanguageColumn('Schools', 'sch_SchoolName_'.$old_key,'sch_SchoolName_'.$input['language_key'],'varchar(200)');
                FrontHelper::updateLanguageColumn('SchoolYears', 'sye_NameCharacter_'.$old_key,'sye_NameCharacter_'.$input['language_key'],'varchar(11)');
                FrontHelper::updateLanguageColumn('States', 'sta_StateName_'.$old_key,'sta_StateName_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('StudentBehaviours', 'sbe_BehaviourName_'.$old_key,'sbe_BehaviourName_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('StudentDisciplineMeasureTypes', 'smt_DisciplineMeasureName_'.$old_key,'smt_DisciplineMeasureName_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateColumn('Translations', 'value_'.$old_key,'value_'.$input['language_key'],'value_'.$prev_id);
                FrontHelper::updateLanguageColumn('Universities', 'uni_UniversityName_'.$old_key, 'uni_UniversityName_'.$input['language_key'],'varchar(255)');
                FrontHelper::updateLanguageColumn('Vocations', 'vct_VocationName_'.$old_key, 'vct_VocationName_'.$input['language_key'],'varchar(100)');
                FrontHelper::updateLanguageColumn('VillageSchools','vsc_VillageSchoolName_'.$old_key,'vsc_VillageSchoolName_'.$input['language_key'],'varchar(255)');
                $id = Language::where('id', $input['id'])
                      ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_language_update_success'] ?? "Language Successfully Updated";
            }
    	}else{
            $checkPrev = Language::where('language_name',$input['language_name'])->first();
            $checkPrevKey = Language::where('language_key',$input['language_key'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_language_exists'] ?? "Language already exists with this name";
            }elseif(!empty($checkPrevKey)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_language_key_exists'] ?? "Language already exists with this key";
            }else{
        		$id = Language::insertGetId($input);
    			if(!empty($id)){
                    FrontHelper::addLanguageColumn('AcademicDegrees','acd_AcademicDegreeName_'.$input['language_key'],'acd_AcademicDegreeName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('Cantons','can_CantonName_'.$input['language_key'],'can_CantonName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('Citizenships','ctz_CitizenshipName_'.$input['language_key'],'ctz_CitizenshipName_'.$prev_id,'varchar(50)');
                    FrontHelper::addLanguageColumn('Classes','cla_ClassName_'.$input['language_key'],'cla_ClassName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('Colleges','col_CollegeName_'.$input['language_key'],'col_CollegeName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('Countries','cny_CountryName_'.$input['language_key'],'cny_CountryName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('Courses','crs_CourseName_'.$input['language_key'],'crs_CourseName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('EducationPeriods','edp_EducationPeriodName_'.$input['language_key'],'edp_EducationPeriodName_'.$prev_id,'varchar(50)');
                    FrontHelper::addLanguageColumn('EducationPlans','epl_EducationPlanName_'.$input['language_key'],'epl_EducationPlanName_'.$prev_id,'varchar(200)');
                    FrontHelper::addLanguageColumn('EducationProfiles','epr_EducationProfileName_'.$input['language_key'],'epr_EducationProfileName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('EducationPrograms','edp_Name_'.$input['language_key'],'edp_Name_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('EngagementTypes', 'ety_EngagementTypeName_'.$input['language_key'], 'ety_EngagementTypeName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('ExtracurricuralActivityTypes','sat_StudentExtracurricuralActivityName_'.$input['language_key'],'sat_StudentExtracurricuralActivityName_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('FacultativeCoursesGroups','fcg_Name_'.$input['language_key'],'fcg_Name_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('ForeignLanguageGroups','fon_Name_'.$input['language_key'],'fon_Name_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('GeneralPurposeGroups','gpg_Name_'.$input['language_key'],'gpg_Name_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('Grades','gra_GradeName_'.$input['language_key'],'gra_GradeName_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('JobAndWork','jaw_Name_'.$input['language_key'],'jaw_Name_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('Municipalities','mun_MunicipalityName_'.$input['language_key'],'mun_MunicipalityName_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('NationalEducationPlans','nep_NationalEducationPlanName_'.$input['language_key'],'nep_NationalEducationPlanName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('Nationalities','nat_NationalityName_'.$input['language_key'],'nat_NationalityName_'.$prev_id,'varchar(50)');
                    FrontHelper::addLanguageColumn('OptionalCoursesGroups','ocg_Name_'.$input['language_key'],'ocg_Name_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('OwnershipTypes','oty_OwnershipTypeName_'.$input['language_key'],'oty_OwnershipTypeName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('PostOffices','pof_PostOfficeName_'.$input['language_key'],'pof_PostOfficeName_'.$prev_id,'varchar(50)');
                    FrontHelper::addLanguageColumn('QualificationsDegrees','qde_QualificationDegreeName_'.$input['language_key'],'qde_QualificationDegreeName_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('Religions','rel_ReligionName_'.$input['language_key'],'rel_ReligionName_'.$prev_id,'varchar(50)');
                    FrontHelper::addLanguageColumn('Schools','sch_SchoolName_'.$input['language_key'],'sch_SchoolName_'.$prev_id,'varchar(200)');
                    FrontHelper::addLanguageColumn('SchoolYears','sye_NameCharacter_'.$input['language_key'],'sye_NameCharacter_'.$prev_id,'varchar(11)');
                    FrontHelper::addLanguageColumn('States','sta_StateName_'.$input['language_key'],'sta_StateName_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('StudentBehaviours','sbe_BehaviourName_'.$input['language_key'],'sbe_BehaviourName_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('StudentDisciplineMeasureTypes','smt_DisciplineMeasureName_'.$input['language_key'],'smt_DisciplineMeasureName_'.$prev_id,'varchar(100)');
                    FrontHelper::addColumn('Translations','value_'.$input['language_key'],'value_'.$prev_id);
                    FrontHelper::addLanguageColumn('Universities','uni_UniversityName_'.$input['language_key'],'uni_UniversityName_'.$prev_id,'varchar(255)');
                    FrontHelper::addLanguageColumn('Vocations','vct_VocationName_'.$input['language_key'],'vct_VocationName_'.$prev_id,'varchar(100)');
                    FrontHelper::addLanguageColumn('VillageSchools','vsc_VillageSchoolName_'.$input['language_key'],'vsc_VillageSchoolName_'.$prev_id,'varchar(255)');
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_language_add_success'] ?? "Language Successfully Added";
    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getLanguage(Request $request)
    {
        /**
       * Used for Edit Language
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Language::where('id','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
            if(!empty($cdata->flag)){
                $cdata->flag = url('public/images/languages').'/'.$cdata->flag;
            }
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getlanguages(Request $request)
    {
        /**
       * Used for Admin Language Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$Language = new Language;

    	if($filter){
    		$Language = $Language->where ( 'language_key', 'LIKE', '%' . $filter . '%' )->orWhere ( 'language_name', 'LIKE', '%' . $filter . '%' );
    	}
    	$LanguageQuery = $Language;

    	if($sort_col != 0){
    		$LanguageQuery = $LanguageQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_languages= $LanguageQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $Languagedata = [];
	      $languages = $LanguageQuery->offset($offset)->limit($perpage);
	      $filtered_languages = $LanguageQuery->offset($offset)->limit($perpage)->count();
	      $languages = $LanguageQuery->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($languages as $key => $value) {
	            $value['index']      = $counter+1;
	            $Languagedata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($Languagedata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $Languagedata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $Languagedata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_languages,
			"recordsFiltered" => $total_languages,
	        "data" => $Languagedata,
	      );

	       return response()->json($result);
    }


    public function deleteLanguage(Request $request)
    {
        /**
       * Used for Delete Language
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		Language::where('id', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }


}