<?php

namespace App\Http\Controllers\Employee;

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
use App\Models\EmployeesEngagement;
use App\Models\Employee;
use App\Models\Admin;
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

        $mainSchool = EmployeesEngagement::select('fkEenSch')->where('fkEenEmp',$this->logged_user->id)->first();;
        $mainSchool = $mainSchool->fkEenSch;

        $student = Student::whereHas('EnrollStudent', function($q) use($filter,$mainSchool){
            $q->where('fkSteSch',$mainSchool);
        });


        if($filter){
            $student = $student->where(function ($query) use ($filter) {
                $query->where ( 'stu_StudentID', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'stu_StudentName', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'stu_StudentSurname', 'LIKE', '%' . $filter . '%' )
                    ->orWhere ( 'stu_TempCitizenId', 'LIKE', '%' . $filter . '%' );
            });   
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

          // dd($students);

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

    public function addStudent(Request $request)
    {
    	/**
         * Used for Students page
         * @return redirect to Admin->students
         */
    	$municipality = Municipality::select('pkMun','mun_MunicipalityName_'.$this->current_language.' as mun_MunicipalityName')->get();
    	$nationality = Nationality::select('pkNat','nat_NationalityName_'.$this->current_language.' as nat_NationalityName')->get();
    	$citizenship = Citizenship::select('pkCtz','ctz_CitizenshipName_'.$this->current_language.' as ctz_CitizenshipName')->get();
    	$religion = Religion::select('pkRel','rel_ReligionName_'.$this->current_language.' as rel_ReligionName')->get();
    	$postalCode = PostalCode::select('pkPof','pof_PostOfficeNumber','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName')->get();
    	$jawWork = JobAndWork::select('pkJaw','jaw_Name_'.$this->current_language.' as jaw_Name')->get();

    	if (request()->ajax()) {
            return \View::make('employee.student.addStudent')->with(['jawWork'=>$jawWork,'postalCode'=>$postalCode,'municipality'=>$municipality,'nationality'=>$nationality,'citizenship'=>$citizenship,'religion'=>$religion])->renderSections();
        }
        return view('employee.student.addStudent',['jawWork'=>$jawWork,'postalCode'=>$postalCode,'municipality'=>$municipality,'nationality'=>$nationality,'citizenship'=>$citizenship,'religion'=>$religion]);
    }

    public function addStudentPost(Request $request)
    {
      /**
       * Used for Add Empoyee Students
       */
    	$response = [];
        $input = $request->all();
        $image = $request->file('stu_PicturePath');       
		$picturePath = '';

        $emailExist = Student::where('email','=', $input['email'])->get();
        $emailEmpExist = Employee::where('email','=', $input['email'])->get();
        if(isset($input['stu_StudentID']) && !empty($input['stu_StudentID'])){
            $govIdExist = Student::where('stu_StudentID',$input['stu_StudentID'])->get();
            $govIdExistCount = $govIdExist->count();
        }else{
            $govIdExistCount = 0;
        }
        if (isset($input['stu_TempCitizenId']) && !empty($input['stu_TempCitizenId'])) {
            $tempIdExist = Student::where('stu_TempCitizenId','=',$input['stu_TempCitizenId'])->where('stu_TempCitizenId','!=',null)->get();
        }
        $emailAdmExist = Admin::where('email', '=', $input['email'])->get();
        $checkPrev = Student::where('stu_StudentName',$input['stu_StudentName'])->where('stu_StudentSurname',$input['stu_StudentSurname'])->first();

        $emailExistCount = $emailExist->count();
        $emailAdmExistCount = $emailAdmExist->count();
        $emailEmpExistCount = $emailEmpExist->count();
        $tempIdExistCount = isset($tempIdExist) ? $tempIdExist->count() :0;

        if($emailExistCount != 0 || $emailAdmExistCount != 0 || $emailEmpExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_email_exist'] ?? 'Email already exist, Please try with a different email';
            return response()->json($response);
            die();
        }

        if($govIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_student_id_exist'] ?? "Student Id already exists, Please try with a different Student Id";
            return response()->json($response);
            die();
        }

        if($tempIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_temp_citizen_id_exist'] ?? 'The Temporary Citizen Id already exists, Please try with a different Temp Citizen Id';
            return response()->json($response);
            die();
        }

        if(!empty($checkPrev)){
          $response['status'] = false;
          $response['message'] = $this->translations['msg_user_exist'] ?? 'User already exists with this name';
          return response()->json($response);
          die();
        }

        $student = new Student;
        if(!empty($image)){
        	$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        	$destinationPath = public_path('/images/students');
        	$image->move($destinationPath, $input['imagename']);
        	$picturePath = $input['imagename'];
        }


        $current_time = date("Y-m-d H:i:s");
        $verification_key = md5(FrontHelper::generatePassword(20));
        $reset_pass_token = base64_encode($input['email'].'&&Student&&'.$current_time);

        $input['email_verification_key'] = $verification_key;
        $input['stu_PicturePath'] = $picturePath;
        $input['stu_DateOfBirth'] = date('Y-m-d h:i:s',strtotime($input['stu_DateOfBirth']));
        $student->create($input);

        if($student){
            $data = ['email' => $input['email'], 'name'=>$input['stu_StudentName']." ".$input['stu_StudentSurname'], 'verify_key'=>$verification_key,'reset_pass_link'=>$reset_pass_token, 'subject'=>'New Student Credentials'];

            $sendmail = MailHelper::sendNewCredentials($data);

			$response['status'] = true;
            $response['message'] = $this->translations['msg_student_add_success'] ?? "Student Successfully Added";
            $response['redirect'] = url('/employee/addStudent');
        }else{
            $response['status'] = false;
            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
        }

        // var_dump($response);
        return response()->json($response);
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
    	$postalCode = PostalCode::select('pkPof','pof_PostOfficeNumber','pof_PostOfficeName_'.$this->current_language.' as pof_PostOfficeName')->get();
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

        if(isset($input['stu_StudentID']) && !empty($input['stu_StudentID'])){
            $govIdExist = Student::where('stu_StudentID',$input['stu_StudentID'])->where('id','!=', $input['id'])->get();
            $govIdExistCount = $govIdExist->count();
        }else{
            $govIdExistCount = 0;
        }

        $emailExist = Student::where('email','=', $input['email'])->where('id','!=', $input['id'])->get();
        $emailEmpExist = Employee::where('email','=', $input['email'])->get();
        
        if (isset($input['stu_TempCitizenId']) && !empty($input['stu_TempCitizenId'])) {
            $tempIdExist = Student::where('stu_TempCitizenId','=',$input['stu_TempCitizenId'])->where('stu_TempCitizenId','!=',null)->where('id','!=', $input['id'])->get();
        }

        $emailAdmExist = Admin::where('email', '=', $input['email'])->get();
        $checkPrev = Student::where('stu_StudentName',$input['stu_StudentName'])->where('stu_StudentSurname',$input['stu_StudentSurname'])->where('id','!=', $input['id'])->first();

        $emailExistCount = $emailExist->count();
        $emailAdmExistCount = $emailAdmExist->count();
        $emailEmpExistCount = $emailEmpExist->count();
        $tempIdExistCount = isset($tempIdExist) ? $tempIdExist->count() : 0;

        if($emailExistCount != 0 || $emailAdmExistCount != 0 || $emailEmpExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_email_exist'] ?? 'Email already exist, Please try with a different email';
            return response()->json($response);
            die();
        }

        if($govIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_student_id_exist'] ?? "Student Id already exists, Please try with a different Student Id";
            return response()->json($response);
            die();
        }

        if($tempIdExistCount != 0){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_temp_citizen_id_exist'] ?? 'The Temporary Citizen Id already exists, Please try with a different Temp Citizen Id';
            return response()->json($response);
            die();
        }

        if(!empty($checkPrev)){
          $response['status'] = false;
          $response['message'] = $this->translations['msg_user_exist'] ?? 'User already exists with this name';
          return response()->json($response);
          die();
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
            $response['redirect'] = url('/employee/addStudent');
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
