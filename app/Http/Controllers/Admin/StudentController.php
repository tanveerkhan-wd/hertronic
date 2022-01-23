<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FrontHelper;
use App\Helpers\MailHelper;
use App\Models\Municipality;
use App\Models\PostalCode;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\Citizenship;
use App\Models\Student;
use App\Models\JobAndWork;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class StudentController extends Controller
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

    public function student(Request $request)
    {
        /**
         * Used for Students page
         * @return redirect to Employee->students
         */
        $municipality = Municipality::select('pkMun','mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName')->get();
        $nationality = Nationality::select('pkNat','nat_NationalityName_'.$this->current_language.' as nat_NationalityName')->get();
        $citizenship = Citizenship::select('pkCtz','ctz_CitizenshipName_'.$this->current_language.' as ctz_CitizenshipName')->get();
        $religion = Religion::select('pkRel','rel_ReligionName_'.$this->current_language.' as rel_ReligionName')->get();
        $postalCode = PostalCode::select('pkPof','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName')->get();
        $jawWork = JobAndWork::select('pkJaw','jaw_Name_'.$this->current_language.' as jaw_Name')->get();

        if (request()->ajax()) {
            return \View::make('employee.student.student')->with(['jawWork'=>$jawWork,'postalCode'=>$postalCode,'municipality'=>$municipality,'nationality'=>$nationality,'citizenship'=>$citizenship,'religion'=>$religion])->renderSections();
        }
        return view('employee.student.student',['jawWork'=>$jawWork,'postalCode'=>$postalCode,'municipality'=>$municipality,'nationality'=>$nationality,'citizenship'=>$citizenship,'religion'=>$religion]);
    }

    public function getStudent(Request $request)
    {
      /**
       * Used for Employee Student listing
       */
        $data =$request->all();
          
        $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
          
        $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

        $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';    
        $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column'] : '';

        $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] : '' ;

        $student = new Student;

        if($filter){
            $student = $student->where ( 'stu_StudentID', 'LIKE', '%' . $filter . '%' )->orWhere ( 'stu_StudentName', 'LIKE', '%' . $filter . '%' )->orWhere ( 'stu_StudentSurname', 'LIKE', '%' . $filter . '%' )->orWhere ( 'stu_StudentGender', 'LIKE', '%' . $filter . '%' );
        }
        $studentQuery = $student;

        if($sort_col != 0){
            $studentQuery = $studentQuery->orderBy($sort_field, $sort_type);
        }

        $total_students= $studentQuery->count();

          $offset = $data['start'];
         
          $counter = $offset;
          $studentdata = [];
          $students = $studentQuery->offset($offset)->limit($perpage);
          // var_dump($countries->toSql(),$countries->getBindings());
          $students = $studentQuery->offset($offset)->limit($perpage)->get()->toArray();

           foreach ($students as $key => $value) {
                $value['index']      = $counter+1;
                if ($value['stu_StudentGender']=='Male') {
                    $value['stu_StudentGender'] = $this->translations['gn_male'] ??'Male';
                }else{
                    $value['stu_StudentGender'] = $this->translations['gn_female'] ??'Female';
                }
                $studentdata[$counter] = $value;
                $counter++;
          }

          $price = array_column($studentdata, 'index');

        if($sort_col == 0){
            if($sort_type == 'desc'){
                array_multisort($price, SORT_DESC, $studentdata);
            }else{
                array_multisort($price, SORT_ASC, $studentdata);
            }
        }
          $result = array(
            "draw" => $data['draw'],
            "recordsTotal" =>$total_students,
            "recordsFiltered" => $total_students,
            "data" => $studentdata,
          );

           return response()->json($result);
        
    }

    

    public function editStudent(Request $request, $id)
    {
      /**
       * Used for Edit Employee Students
       */
      	

        $municipality = Municipality::select('pkMun','mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName')->get();
    	$nationality = Nationality::select('pkNat','nat_NationalityName_'.$this->current_language.' as nat_NationalityName')->get();
    	$citizenship = Citizenship::select('pkCtz','ctz_CitizenshipName_'.$this->current_language.' as ctz_CitizenshipName')->get();
    	$religion = Religion::select('pkRel','rel_ReligionName_'.$this->current_language.' as rel_ReligionName')->get();
    	$postalCode = PostalCode::select('pkPof','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName')->get();
    	$jawWork = JobAndWork::select('pkJaw','jaw_Name_'.$this->current_language.' as jaw_Name')->get();

        $aStudentData = Student::where('id',$id)->first();
    	
    	if(request()->ajax()){
            return \View::make('employee.student.editStudent')->with(['aStudentData'=> $aStudentData,'jawWork'=>$jawWork,'postalCode'=>$postalCode,'municipality'=>$municipality,'nationality'=>$nationality,'citizenship'=>$citizenship,'religion'=>$religion])->renderSections();
        }
    	return view('employee.student.editStudent',['aStudentData'=>$aStudentData,'jawWork'=>$jawWork,'postalCode'=>$postalCode,'municipality'=>$municipality,'nationality'=>$nationality,'citizenship'=>$citizenship,'religion'=>$religion]);

    }

    public function editStudentPost(Request $request)
    {
      /**
       * Used for Add Empoyee Students
       */
    	$input = $request->all();
        $image = $request->file('stu_PicturePath');
        $response = [];
        
        if(!empty($image)){
            $input['stu_PicturePath'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('images/students');
            $image->move($destinationPath, $input['stu_PicturePath']);
            $imgData = Student::select('stu_PicturePath')->where('id', $input['id'])->first();
            if(!empty($imgData->stu_PicturePath)){
                $filepath = public_path('images/students/').$imgData->stu_PicturePath;        
                if(file_exists($filepath)) {
                   unlink($filepath);
                }
            }
        }
        if(!empty($input['id'])){

            $input['stu_DateOfBirth'] = date('Y-m-d h:i:s',strtotime($input['stu_DateOfBirth']));

            $sdata = Student::where('id', $input['id'])->first();

            if($sdata->email != $input['email']){
                $current_time = date("Y-m-d H:i:s");
                $verification_key = md5(FrontHelper::generatePassword(20));
                $reset_pass_token = base64_encode($input['email'].'&&Student&&'.$current_time);

                $data = ['email' => $input['email'], 'name'=>$input['stu_StudentName']." ".$input['stu_StudentSurname'], 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New Student Credentials'];

                $sendmail = MailHelper::sendNewCredentials($data);
                var_dump($sendmail);die();
                $input['email'];
                $input['email_verified_at'] = null;
                $input['email_verification_key'] = $verification_key;
            }else{
                $verification_key = md5(FrontHelper::generatePassword(20));
                $input['email_verification_key'] = $verification_key;
                $input['email_verified_at'] = null;
            }

            $id = Student::where('id', $input['id'])
                  ->update($input);
            
        }
        
        if($id){
            $response['status'] = true;
            $response['message'] = $this->translations['msg_student_update_success'] ?? "Student Successfully Updated";
            $response['redirect'] = url('admin/students');
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }
        return response()->json($response);
    }

    public function deleteStudent(Request $request)
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

            $eed = Student::where('id', $cid)
                      ->update(['deleted_at' => now()]);

            if($eed){
                $response['status'] = true;
                $response['message'] = $this->translations['msg_student_delete_success'] ?? "Student Successfully Deleted";
            }else{
                $response['status'] = false;
                $response['message'] = $this->translations['msg_student_delete_prompt'] ?? "Sorry, the selected student cannot be deleted"; 
            }
        }

        return response()->json($response);
    }

    public function viewStudent(Request $request, $id)
    {
        $aStudentData = Student::where('id',$id)->first();
        
        if(request()->ajax()){
            return \View::make('employee.student.viewStudent')->with(['mdata'=> $aStudentData])->renderSections();
        }
        return view('employee.student.viewStudent',['mdata'=>$aStudentData]);        
    }

}
