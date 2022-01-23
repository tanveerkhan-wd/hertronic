<?php
/**
* UserController 
*
* This file is used for Login, Fogot Password and profile
* 
* @package    Laravel
* @subpackage Controller
* @since      1.0
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Controllers\Controller;
use App\Helpers\MailHelper;
use App\Helpers\FrontHelper;
use App\User;
use Hash;
use Carbon\Carbon;
use Validator;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\View\View;
use App\Mail\ForgotPassword;
use Session;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Student;
use App\Models\Country;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct(); 
    }

    public function index(Request $request)
    {
        /**
         * Used for Admin Login
         * @return redirect to Login
         */
      $data = '';
    	$input = $request->all();        
    	return view('login.login',compact('data'));
    }

    public function loginPost(Request $request)
    {
        /**
         * Used for Login Checking
         */

        $loginType = ['admin'=>['HertronicAdmin', 'MinistryAdmin', 'MinistrySubAdmin'], 'employee'=>'employee','teacher'=>'teacher'];

        $input = $request->all();            
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect('/login')
                        ->withErrors($validator)
                        ->withInput();
        }
        $emailCount = Admin::where('email','=',$input['email'])->count();

        $EmpEmailCount = Employee::where('email','=',$input['email'])->count();

        $StuEmailCount = Student::where('email','=',$input['email'])->count();

        $noEmailFound = true;

        if($emailCount != 0){
          $userData = Admin::where('email','=',$input['email'])->first();
          $Name = $userData->adm_Name;
          $noEmailFound = false;
        }elseif($EmpEmailCount != 0){
          $noEmailFound = false;
          $userData = Employee::where('email','=',$input['email'])->first();
          $Name = $userData->emp_EmployeeName;
        }elseif($StuEmailCount != 0){
          $noEmailFound = false;
          $userData = Student::where('email','=',$input['email'])->first();
          $Name = $userData->stu_StudentName." ".$userData->stu_StudentSurname;
        }

        if($noEmailFound){
          $message = $this->translations['msg_no_email_found'] ?? 'No such email found';
          return redirect('login')->withErrors([$message]);
        }

        if($userData->email_verified_at == null){
            $verification_key = md5(FrontHelper::generatePassword(20));
            $userData->email_verification_key = $verification_key;
            $userData->save();
            $data = ['email' => $userData->email, 'name'=>$Name, 'verify_key'=>$verification_key,'subject'=>'Hertronic Email Verification'];

            $sendmail = MailHelper::sendEmailVerification($data);
            $message = $this->translations['msg_email_not_verified'] ?? 'Your email is not verified, a verification link has been sent to your email';
            return redirect('login')
                        ->withErrors([$message]);
        }

        if($userData->adm_Status == 'Inactive' || $userData->emp_Status == 'Inactive'){
            $message = $this->translations['msg_account_inactive'] ?? 'Your account is inactive, please try again after sometime';
            return redirect('login')
                        ->withErrors([$message]);
        }

        $remember = (isset($input['remember_me']) && isset($input['remember_me']) != '')?1:0;

        if($userData->type == 'HertronicAdmin' || $userData->type == 'MinistryAdmin' || $userData->type == 'MinistrySubAdmin'){
            $guard = 'admin';
        }else{
          if($EmpEmailCount != 0){
            $guard = 'employee';
          }elseif($StuEmailCount != 0){
            $guard = 'student';
          }
        }

        if(!empty($guard)){
            if(Auth::guard($guard)->attempt(['email' => $input['email'], 'password' => $input['password']],$remember)){
                //return redirect($userData->type."/dashboard");
               // dd(Auth::guard($guard)->user());
                return redirect($guard."/dashboard");
            }else{
                $message = $this->translations['msg_invalid_password'] ?? 'Please enter valid password';
                return redirect('login')
                        ->withErrors([$message]);
            }
        }


    }   


    public function forgotPass(Request $request)
    {
         /**
         * Used for Forgot Password Page
         * @return redirect to Admin->Forgot Password page
         */
        return view('login.forgot');        
    }

    public function forgotPasswordPost(Request $request)
    {
         /**
         * Used for Forgot Password Check
         * @return redirect to Admin->Forgot Password Check
         */
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        
        if ($validator->fails()) {
            return redirect('/admin/forgotPass')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = Admin::where('email','=',$input['email'])->first();
        $uType = 'Admin';
        if(empty($user)){
          $user = Employee::where('email','=',$input['email'])->first();
          $uType = 'Employee';
        }
        if(empty($user)){
          $user = Student::where('email','=',$input['email'])->first();
          $uType = 'Student';
        }

        if (empty($user)) 
        {
            $message = $this->translations['msg_forgot_pass_fail'] ?? 'Sorry, we can not find this email id in the system. Please try again later';
            return redirect('/forgotPass')
                        ->withErrors([$message])
                        ->withInput();
        }
        else
        { 
           // $user = Admin::where('email','=',$input['email'])->first(); 
          if($uType == 'Admin'){
            $name = $user->adm_Name;
          }
          if($uType == 'Employee'){
            $name = $user->emp_EmployeeName;
          }
          if($uType == 'Student'){
            $name = $user->stu_StudentName." ".$user->stu_StudentSurname;
          }

           $pass = FrontHelper::generatePassword(10);
           $new_pass = Hash::make($pass);

           $current_time = date("Y-m-d H:i:s");
           $reset_pass_token = base64_encode($input['email'].'&&'.$uType."&&".$current_time);

           $data = ['firstname'=> $name, 'pass'=>$pass, 'email'=>$user->email, 'reset_pass_link'=>$reset_pass_token];

           MailHelper::sendForgotPassAdmin($data);
           $message = $this->translations['msg_forgot_pass_success'] ?? 'A password reset link has been sent on your registered Email address';
           return redirect('forgotPass')->with('success', $message);

        }
    }

    public function resetPassword($token)
    {
        $response = [];

        $decoded = base64_decode($token);
        $tmp_dec = explode('&&', $decoded);
        
        if(empty($tmp_dec[0]) || empty($tmp_dec[1]) || empty($tmp_dec[2])){
            $response['status'] = false;
            $response['message'] = 'Invalid reset password token';
            return response()->json($response);
            exit();
        }


        $current_time = date("Y-m-d H:i:s");

        $minuteDiff = round((strtotime($current_time) - strtotime($tmp_dec[2]))/60, 1);


        if($minuteDiff > 30){ //check if link is generated more than 30 mins ago
            $message = $this->translations['msg_reset_pass_link_expire'] ?? 'Sorry, the reset password link is expired please try again';
            return redirect('/forgotPass')
                        ->withErrors([$message])
                        ->withInput();
        }
      
        return view('login.reset_password',['token'=>$token]);
    }

    public function logout(Request $request)
    {
        /**
         * Used for Admin Logout
         * @return redirect to Admin->Logout
         */
        $prevUser = Session::get('previous_user');
        //$currUser = $this->logged_user;
        // var_dump($prevUser->utype);
        // var_dump($this->logged_user->utype);
        // die();
        if(!empty($prevUser)){
          Auth::guard($prevUser->utype)->login($prevUser);
          $uimg = url('public/images/user.png');
          $type = '';
          if(!empty($prevUser->adm_Photo)){
              $uimg = url('public/images/users/').'/'.$prevUser->adm_Photo; 
          }
          if($prevUser->type == 'HertronicAdmin' || $prevUser->type == 'MinistrySubAdmin'){
            $type = 'Hertronic Super Admin';
            $url = url('/admin/dashboard');
          }else if($prevUser->type == 'MinistryAdmin'){
            $type = $this->translations['gn_ministry_super_admin'] ?? 'Ministry Super Admin';
            $url = url('/admin/dashboard');
          }else if($prevUser->type == 'MinistrySubAdmin'){
            $type = 'Ministry Sub Admin';
            $url = url('/admin/dashboard');
          }
          $msg = $this->translations['gn_logged_in_as'] ?? "You are logged in as";
          $msg = $msg." ".$prevUser->adm_Name." - ".$type;
          $data = '<div class="alert alert-warning alert-dismissible fade show loginas-alert" role="alert">
             <div class="profile-cover">
              <img src="'.$uimg.'">
            </div>
             '.$msg.'
            <button data-redir="'.$url.'" type="button" class="remove_scroll theme_btn min_btn ml-md-5" data-dismiss="alert" aria-label="Close">
              Exit
            </button>
          </div><div class="alert-bg"></div>';
          Session::forget('previous_user');
          Session::forget('curr_emp_type');
          Session::flash('previous_login', $data);
          Auth::guard('employee')->logout();
          return redirect($prevUser->utype.'/dashboard');
        }else{
          Auth::guard('admin')->logout();
          Auth::guard('employee')->logout();
          Auth::guard('student')->logout();
          Auth::logout();
          return redirect('login');        
        }
    }

    public function changePasswordPost(Request $request)
    {
         /**
         * Used for Profile Change Password when forgot save
         * @return redirect to Admin->Profile
         */

        $response = [];
        $input = $request->all();

        if(isset($input['old_password']) && $input['old_password'] != null && !empty($input['old_password']))
        {    

            if (Hash::check($input['old_password'], $this->logged_user->password)) {
                // The passwords match...
                if(in_array($this->logged_user->type, $this->admins)){
                    $user = Admin::findorfail($this->logged_user->id);
                }elseif(in_array($this->logged_user->type, $this->employees)){
                    $user = Employee::findorfail($this->logged_user->id);
                }elseif($this->logged_user->type == 'student'){
                    $user = Student::findorfail($this->logged_user->id);
                }

                if(isset($input['new_password']) && $input['new_password'] != null && !empty($input['new_password']))
                {
                    $user->password = Hash::make($input['new_password']);
                }   
                if($user->save()){
                    //return redirect('logout')->with('success', 'Password Updated Successful');
                    $response['status'] = true;
                    $response['message'] = $this->translations['msg_pass_update_success'] ?? "Password updated successfully";
                    $response['redirect'] = url('/logout');

                }else{
                    $response['status'] = false;
                    $response['message'] = $this->translations['msg_something_wrong'] ?? 'Something Wrong Please try again Later';
                }
               
            }else{
                $response['status'] = false;
                $response['message'] = $this->translations['msg_pass_match_fail'] ?? "Entered password is incorrect, Your password doesn't match";
            }
        }

        return response()->json($response);
    }

    public function resetPasswordPost(Request $request)
    {
        $input = $request->all();
        $response = [];
        $decoded = base64_decode($input['token']);
        $tmp_dec = explode('&&', $decoded);

        if(empty($tmp_dec[0]) || empty($tmp_dec[1])){
            $response['status'] = false;
            $response['message'] = $this->translations['msg_invalid_pass_token'] ?? 'Invalid reset password token';
            return response()->json($response);
            exit();
        }

        $new_pass = Hash::make($input['new_password']);

        $user = Admin::where('email', $tmp_dec[0])->first();

        if(empty($user)) {
          $user = Employee::where('email', $tmp_dec[0])->first();
        }

        if(empty($user)) {
          $user = Student::where('email', $tmp_dec[0])->first();
        }


        if(!empty($user)) {
          $user->password = $new_pass;
          $user->save();
          $response['status'] = true;
          $response['message'] = $this->translations['msg_reset_pass_success'] ?? 'Reset Password Successful';
        }else{
          $response['status'] = false;
          $response['message'] = $this->translations['msg_account_not_exist'] ?? 'Sorry, your account does not exist in the system';
        }
        $response['redirect'] = url('login');
        return response()->json($response);
    }

    public function verifyEmail() {
      $key = Input::get('verification-key');
      $user = Admin::where('email_verification_key', $key)->get()->first();
      if(empty($user)) {
        $user = Employee::where('email_verification_key', $key)->get()->first();
      }
      if(empty($user)) {
        $user = Student::where('email_verification_key', $key)->get()->first();
      }
      $message = '';
      $status = '';
      if (!empty($user)) {
         if ($user->email_verified_at) {
            $message = $this->translations['msg_email_already_verify'] ?? 'Your email is already verified. You can login at';
            // $message = $message ." <a href='".url('/')."'>Hertronic</a>";
            $status = true;
         } else {
            $user->email_verification_key = null;
            $user->email_verified_at = now();
            $user->save();
            $message = $this->translations['msg_email_verify_success'] ?? 'Thank you, your email has been verified';
            $status = true;
         }
      } else {
         $message = $this->translations['msg_invalid_verify_key'] ?? "Invalid Verification Key.";
         $status = false;
      }
    
      return view('email_verify', array('message' => $message,'status'=>$status));
    }

    public function generateRandomText($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $randomString; 
    } 

    public function switchLanguage(Request $request){
          $response = [];

          $data = $request->all();

          Session::put('current_language', $data['lang']);
          
          $response['message']="Language changed successfully!";
          $response['status']=true;

        return response()->json($response);
    } 
}