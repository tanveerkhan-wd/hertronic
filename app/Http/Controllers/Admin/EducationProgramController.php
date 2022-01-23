<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EducationProgram;
use App\Models\SchoolEducationPlanAssignment;
use App\Models\EducationPlan;
use App\Helpers\FrontHelper;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class EducationProgramController extends Controller
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

    public function index(Request $request)
    {
        /**
         * Used for Admin Education Programs
         * @return redirect to Admin->Education Programs
         */
        if (request()->ajax()) {
            return \View::make('admin.educationPrograms.educationPrograms')->renderSections();
        }
        return view('admin.educationPrograms.educationPrograms');
    }

    
    public function addEducationProgram(Request $request)
    {
      /**
       * Used for Craete Admin Education Program
       */
        $streams = EducationProgram::select('pkEdp','edp_Name_'.$this->current_language.' as edp_Name','edp_ParentId')->get()->toArray();
        $tree = FrontHelper::buildtree($streams);
        if (request()->ajax()) {
            return \View::make('admin.educationPrograms.addEducationProgram')->with('educationProgram',$tree)->renderSections();
        }
        return view('admin.educationPrograms.addEducationProgram',['educationProgram'=>$tree]);
    }

    public function editEducationProgram($id)
    {
      /**
       * Used for Edit Admin Education Program
       */
        $streams = EducationProgram::select('edp_Name_'.$this->current_language.' as edp_Name', 'pkEdp' ,'edp_ParentId','edp_Uid')->get()->toArray();
        $tree = FrontHelper::buildtree($streams);

        $data = EducationProgram::where('pkEdp',$id)->first();
        if (request()->ajax()) {
            return \View::make('admin.educationPrograms.editEducationProgram')->with(['educationProgram'=>$tree,'data'=>$data])->renderSections();
        }
        return view('admin.educationPrograms.editEducationProgram',['educationProgram'=>$tree,'data'=>$data]);
    }
    public function addEducationProgramPost(Request $request)
    {
      /**
       * Used for Add Admin Education Program
       */
        $input = $request->all();
        $response = [];
        if(!empty($input['pkEdp'])){
            $checkPrev = EducationProgram::where('edp_Name_'.$this->current_language,$input['edp_Name_'.$this->current_language])->where('pkEdp','!=',$input['pkEdp'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_education_program_exist'] ?? "Education Program already exists with this name";
            }else{
                $id = EducationProgram::where('pkEdp', $input['pkEdp'])
                      ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_education_program_update_success'] ?? "Education Program Successfully Updated";
            }
        }else{
            $checkPrev = EducationProgram::where('edp_Name_'.$this->current_language,$input['edp_Name_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_education_program_exist'] ?? "Education Program already exists with this name";
            }else{
                $id = EducationProgram::insertGetId($input);
                if(!empty($id)){
                    $id = EducationProgram::where('pkEdp', $id)
                      ->update(['edp_Uid' => "EPR".$id]);
                    $response['status'] = true;
                    $response['message'] = $this->translations['msg_education_program_add_success'] ?? "Education Program Successfully Added";

                }else{
                    $response['status'] = false;
                    $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
                }
            }
        }
        

        return response()->json($response);
    }

    public function getEducationProgram(Request $request)
    {
      /**
       * Used for Edit Admin Education Program
       */
        $input = $request->all();
        $cid = $input['cid'];
        $response = [];
        $cdata = EducationProgram::select('edp_Name_'.$this->current_language.' as edp_Name', 'pkEdp' ,'edp_ParentId','edp_Uid')->where('pkEdp','=',$input['cid'])->first();

        if(empty($cid) || empty($cdata)){
            $response['status'] = false;
        }else{
            $response['status'] = true;
            $response['data'] = $cdata;
        }

        return response()->json($response);

    }

    public function getEducationPrograms(Request $request)
    {
      /**
       * Used for Admin Education Program Listing
       */
        $data =$request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    

        $sort_col =  $data['order'][0]['column'];

        $sort_field = $data['columns'][$sort_col]['data'];

        $EducationProgram = new EducationProgram;

        if($filter){
            $EducationProgram = $EducationProgram->where ( 'edp_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'edp_Name_'.$this->current_language, 'LIKE', '%' . $filter . '%' )->orWhere ( 'edp_Notes', 'LIKE', '%' . $filter . '%' );
        }
        $EducationProgramQuery = $EducationProgram;

        if($sort_col != 0){
            $EducationProgramQuery = $EducationProgramQuery->orderBy($sort_field, $sort_type);
        }

        $total_EducationProgram = $EducationProgramQuery->count();

          $offset = $data['start'];
         
          $counter = $offset;
          $EducationProgramData = [];
          $EducationPrograms = $EducationProgramQuery->offset($offset)->limit($perpage);
          // var_dump($EducationPrograms->toSql(),$EducationPrograms->getBindings());
          $EducationPrograms = $EducationProgramQuery->select('edp_Name_'.$this->current_language.' as edp_Name', 'pkEdp' ,'edp_ParentId','edp_Uid','edp_Notes')->offset($offset)->limit($perpage)->with('parent')->get()->toArray();

           foreach ($EducationPrograms as $key => $value) {
                $value['index']      = $counter+1;
                $EducationProgramData[$counter] = $value;
                $counter++;
          }

          $price = array_column($EducationProgramData, 'index');

        if($sort_col == 0){
            if($sort_type == 'desc'){
                array_multisort($price, SORT_DESC, $EducationProgramData);
            }else{
                array_multisort($price, SORT_ASC, $EducationProgramData);
            }
        }
          $result = array(
            "draw" => $data['draw'],
            "recordsTotal" =>$total_EducationProgram,
            "recordsFiltered" => $total_EducationProgram,
            'data' => $EducationProgramData,
          );

           return response()->json($result);
    }


    public function deleteEducationProgram(Request $request)
    {
      /**
       * Used for Delete Admin Education Program
       */
        $input = $request->all();
        $cid = $input['cid'];
        $response = [];

        if(empty($cid)){
            $response['status'] = false;
        }else{
            $EducationPlan = EducationPlan::where('fkEplEdp', $cid)->get()->count();
            $SchoolEducationPlanAssignment = SchoolEducationPlanAssignment::where('fkSepEdp', $cid)->get()->count();
            //StudentEnrollment::where('fkSteEdp', $cid)->get()->count();
            if($EducationPlan != 0 || $SchoolEducationPlanAssignment != 0){
                $response['status'] = false;
                $response['message'] = $this->translations['msg_education_program_delete_prompt'] ?? "Sorry, the selected education program cannot be deleted as it is already being used by schools";
            }else{
              EducationProgram::where('pkEdp', $cid)->orWhere('edp_ParentId',$cid)
                    ->update(['deleted_at' => now()]);
              $response['status'] = true;
              $response['message'] = $this->translations['msg_education_program_delete_success'] ?? "Education Program Successfully Deleted";
            }
        }

        return response()->json($response);
    }

}
