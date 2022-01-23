<?php
/**
* JobAndWorkController 
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
use App\Models\JobAndWork;
use App\Models\Language;
use Validator;
use Carbon\Carbon;
use Auth;
use Hash;
use Redirect;

class JobAndWorkController extends Controller
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
	
    public function jobAndWorks(Request $request)
    {
      /**
       * Used for Admin jobAndWorks
       * @return redirect to Admin->jobAndWorks
       */
      if (request()->ajax()) {
          return \View::make('admin.jobAndWorks.jobAndWorks')->renderSections();
      }
      return view('admin.jobAndWorks.jobAndWorks');
    }

    public function getJobAndWorks(Request $request)
    {
      /**
       * Used for Admin jobAndWorks Listing
       */
        $data =$request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    
        $sort_col =  $data['order'][0]['column'];

        $sort_field = $data['columns'][$sort_col]['data'];

        $academic = new JobAndWork;
          
        if($filter){
            $academic = $academic->where( 'jaw_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'jaw_Name_'.$this->current_language, 'LIKE', '%' . $filter . '%' );
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
          $academics = $academicQuery->select('pkJaw','jaw_Uid','jaw_Name_'.$this->current_language.' as jaw_Name','jaw_Notes','jaw_Status')->offset($offset)->limit($perpage)->get()->toArray();

          foreach ($academics as $key => $value) {
              $value['index'] = $counter+1;
              $value['jaw_Statu'] = $value['jaw_Status'];
              if($value['jaw_Status']=='Active'){
                $value['jaw_Status'] = $this->translations['gn_active'] ?? "Active";
              }
              else{
                $value['jaw_Status'] = $this->translations['gn_inactive'] ?? "Inactive";
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

    public function addJobAndWork(Request $request)
    {
      /**
       * Used for Admin jobAndWorks Add & Update
       */
        $input = $request->all();
        $response = [];
        if(!empty($input['pkJaw'])){
          $checkPrev = JobAndWork::where('jaw_Name_'.$this->current_language,$input['jaw_Name_'.$this->current_language])->where('pkJaw','!=',$input['pkJaw'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_job_work_exist'] ?? "Job work already exists with this name";
            }else{
              $id = JobAndWork::where('pkJaw', $input['pkJaw'])
                    ->update($input);
              $response['status'] = true;
              $response['message'] = $this->translations['msg_job_work_update_success'] ?? "Job Work Successfully Updated";
            }
        }else{
           $checkPrev = JobAndWork::where('jaw_Name_'.$this->current_language,$input['jaw_Name_'.$this->current_language])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_job_work_exist'] ?? "Job work already exists with this name";
            }else{
              $id = JobAndWork::insertGetId($input);
              if(!empty($id)){
                  $id = JobAndWork::where('pkJaw', $id)
                    ->update(['jaw_Uid' => "JOB".$id]);
                  $response['status'] = true;
                  $response['message'] = $this->translations['msg_job_work_add_success'] ?? "Job Work Successfully Added";

              }else{
                  $response['status'] = false;
                  $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
              }
            }
        }
        
        return response()->json($response);
    }

    public function getJobAndWork(Request $request)
    {
      /**
       * Used for Edit jobAndWorks
       */
      $input = $request->all();
      $cid = $input['cid'];
      $response = [];
      $cdata = JobAndWork::where('pkJaw','=',$input['cid'])->first();

      if(empty($cid) || empty($cdata)){
        $response['status'] = false;
      }else{
        $response['status'] = true;
        $response['data'] = $cdata;
      }

      return response()->json($response);

    }

    public function deleteJobAndWork(Request $request)
    {
      /**
       * Used for Delete jobAndWorks
       */
      $input = $request->all();
      $cid = $input['cid'];
      $response = [];

      if(empty($cid)){
        $response['status'] = false;
      }else{
        JobAndWork::where('pkJaw', $cid)
                ->update(['deleted_at' => now()]);
        $response['status'] = true;
        $response['message'] = $this->translations['msg_job_work_delete_success'] ?? "Job & Work Successfully deleted";
      }

      return response()->json($response);
    }
  
}