<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Student;
use App\Models\Language;
use App\Models\Translation;
use Session;
use Auth;

class CheckStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('current_language')) {
            $current_language = Session::get('current_language');
        }else{
            $current_language = 'en';
        }
        $languages = Language::get();
        $translations = Translation::get()->pluck('value_'.$current_language,'key');

        $isStudent ='';
        $emp_id = Auth::guard('student')->user();
        
        if ($emp_id) {
            $isStudent = Student::where('id',$emp_id->id)->where('stu_StudentID',$emp_id->stu_StudentID)->where('stu_TempCitizenId',$emp_id->stu_TempCitizenId)->where('deleted_at',null)->first();
        }
        
        if(!empty($isStudent)){
            
            return $next($request);
        
        }else{
            $error[] = $translations['msg_access_prohibited'] ?? "Access Prohibited";
            return redirect()->back()->withErrors($error);
        }
    }
}
