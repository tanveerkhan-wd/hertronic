<?php
/**
* MainBookController 
* 
* @package    Laravel
* @subpackage Controller
* @since      1.0
*/

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FrontHelper;
use App\Helpers\MailHelper;
use App\Models\Employee;
use App\Models\MainBook;
use App\Models\Student;
use App\Models\EnrollStudent;
use App\Models\EmployeesEngagement;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class MainBookController extends Controller
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

    public function mainBooks(Request $request)
    {
        /**
         * Used for MainBooks
         * @return redirect to Employee->MainBooks
         */
        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();;
        $mainSchool = $mainSchool->fkEenSch;

        if (request()->ajax()) {
            return \View::make('employee.mainBook.mainBooks')->with(['mainSchool'=>$mainSchool])->renderSections();
        }
        return view('employee.mainBook.mainBooks')->with(['mainSchool'=>$mainSchool]);
    }

    public function viewMainBook($id)
    {
      /**
       * Used for View School Main Book
       */
        $mdata = '';
        if(!empty($id)){

            // $mdata = Employee::with('EmployeesEngagement.employeeType','country')->whereHas('EmployeesEngagement', function($q1) use($id){
            //     $q1->whereHas('employeeType', function ($q2) use($id){
            //         $q2->where('epty_Name', 'SchoolSubAdmin');
            //     })->where('fkEenEmp',$id);
            // })->first();
        }

        if (request()->ajax()) {
            return \View::make('employee.mainBook.student')->with('mid', $id)->renderSections();
        }
        return view('employee.mainBook.student',['mid'=>$id]);

    }

    public function addMainBook(Request $request)
    {
      /**
       * Used for Add Admin MainBook
       */
    	$input = $request->all();
    	$response = [];
        $input['mbo_OpeningDate'] = date('Y-m-d h:i:s',strtotime($input['mbo_OpeningDate']));
    	if(!empty($input['pkMbo'])){
            $checkPrev = MainBook::where('mbo_MainBookNameRoman',$input['mbo_MainBookNameRoman'])->where('pkMbo','!=',$input['pkMbo'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_main_book_exist'] ?? "Main Book already exists with this name";
            }else{
        		$id = MainBook::where('pkMbo', $input['pkMbo'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_main_book_update_success'] ?? "Main Book Successfully Updated";
            }
    	}else{
            $checkPrev = MainBook::where('mbo_MainBookNameRoman',$input['mbo_MainBookNameRoman'])->first();
            if(!empty($checkPrev)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_main_book_exist'] ?? "MainBook already exists with this name";
            }else{
        		$id = MainBook::insertGetId($input);
    			if(!empty($id)){
    				$id = MainBook::where('pkMbo', $id)
    	              ->update(['mbo_Uid' => "MBN".$id]);
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_main_book_add_success'] ?? "Main Book Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getMainBook(Request $request)
    {
      /**
       * Used for Edit MainBook
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = MainBook::where('pkMbo','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
            $cdata->mbo_OpeningDate = date('m/d/Y',strtotime($cdata->mbo_OpeningDate));
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getMainBookStudents(Request $request)
    {
      /**
       * Used for MainBook Students Listing
       */
        $data = $request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    

        $sort_col =  $data['order'][0]['column'];

        $sort_field = $data['columns'][$sort_col]['data'];

        $date_filter = $data['date_filter'];

        $fkSteMbo = $data['fkSteMbo'];

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();;
        $mainSchool = $mainSchool->fkEenSch;


        // $MainBook = Student::whereHas('enrollStudent', function($q) use ($fkSteMbo,$date_filter){
        //     $q->where('fkSteMbo',$fkSteMbo);
        //     if(!empty($date_filter)){
        //         $q->where('ste_EnrollmentDate',$date_filter)->where('ste_FinishingDate',null);
        //     }
        // })->with(['enrollStudent']);


        $MainBook = EnrollStudent::whereHas('student', function($q) use($filter){
                if(!empty($filter)){
                    $q->where(function ($query) use ($filter) {
                        $query->where ( 'stu_StudentName', 'LIKE', '%' . $filter . '%' )
                            ->orWhere ( 'stu_StudentSurname', 'LIKE', '%' . $filter . '%' )
                            ->orWhere ( 'stu_FatherName', 'LIKE', '%' . $filter . '%' )
                            ->orWhere ( 'stu_MotherName', 'LIKE', '%' . $filter . '%' );
                    });   
                }
            })->with([
            'student',
            'grade'=> function($q){
                $q->select('pkGra', 'gra_GradeName_'.$this->current_language.' as gra_GradeName','gra_GradeNameRoman');
            }
        ])->where('fkSteMbo',$fkSteMbo)->where('ste_FinishingDate',null);



        if($date_filter){
            $MainBook = $MainBook->whereDate('ste_EnrollmentDate','=',date('Y-m-d',strtotime($date_filter)));
        }

        if($sort_col != 0){
            $MainBook = $MainBook->orderBy($sort_field, $sort_type);
        }

        $total_mainBooks= $MainBook->count();

          $offset = $data['start'];
         
          $counter = $offset;
          $MainBookdata = [];
          $mainBooks = $MainBook->offset($offset)->limit($perpage);
          // var_dump($mainBooks->toSql(),$mainBooks->getBindings());
          $filtered_mainBooks = $MainBook->offset($offset)->limit($perpage)->count();
          $mainBooks = $MainBook->offset($offset)->limit($perpage)->get()->toArray();

           foreach ($mainBooks as $key => $value) {
                $value['index'] = $counter+1;
                $value['stu_DateOfBirth'] = date('m/d/Y',strtotime($value['student']['stu_DateOfBirth']));
                $value['ste_EnrollmentDate'] = date('m/d/Y',strtotime($value['ste_EnrollmentDate']));
                $value['ste_status'] = $this->translations['gn_active'] ?? "Active";
                $MainBookdata[$counter] = $value;
                $counter++;
          }

          $price = array_column($MainBookdata, 'index');

        if($sort_col == 0){
            if($sort_type == 'desc'){
                array_multisort($price, SORT_DESC, $MainBookdata);
            }else{
                array_multisort($price, SORT_ASC, $MainBookdata);
            }
        }
          $result = array(
            "draw" => $data['draw'],
            "recordsTotal" =>$total_mainBooks,
            "recordsFiltered" => $total_mainBooks,
            'data' => $MainBookdata,
          );

           return response()->json($result);
    }

    public function getMainBooks(Request $request)
    {
      /**
       * Used for MainBook Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

        $date_filter = $data['date_filter'];

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();;
        $mainSchool = $mainSchool->fkEenSch;

    	$MainBook = new MainBook;

    	if($filter){
    		$MainBook = $MainBook->where ( 'mbo_Uid', 'LIKE', '%' . $filter . '%' )->orWhere ( 'mbo_MainBookNameRoman', 'LIKE', '%' . $filter . '%' );
    	}

        if($date_filter){
            $MainBook = $MainBook->whereDate('mbo_OpeningDate','=',date('Y-m-d',strtotime($date_filter)));
        }

    	$MainBookQuery = $MainBook->where('fkMboSch',$mainSchool);

    	if($sort_col != 0){
    		$MainBookQuery = $MainBookQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_mainBooks= $MainBookQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $MainBookdata = [];
	      $mainBooks = $MainBookQuery->offset($offset)->limit($perpage);
	      // var_dump($mainBooks->toSql(),$mainBooks->getBindings());
	      $filtered_mainBooks = $MainBookQuery->offset($offset)->limit($perpage)->count();
	      $mainBooks = $MainBookQuery->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($mainBooks as $key => $value) {
	            $value['index'] = $counter+1;
                $value['mbo_OpeningDate'] = date('m/d/Y',strtotime($value['mbo_OpeningDate']));
	            $MainBookdata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($MainBookdata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $MainBookdata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $MainBookdata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_mainBooks,
			"recordsFiltered" => $total_mainBooks,
	        'data' => $MainBookdata,
	      );

	       return response()->json($result);
    }


    public function deleteMainBook(Request $request)
    {
      /**
       * Used for Delete MainBook
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		MainBook::where('pkMbo', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }


}