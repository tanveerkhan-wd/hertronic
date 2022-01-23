<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
use App\Models\Language;
use App\Models\Translation;
use App\Models\EmployeeType;
use App\Models\Employee;
use App\Models\EmployeesEngagement;

class CheckEmployee
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

        if (Auth::guard('employee')->user()) {
            $logged_user = Auth::guard('employee')->user();
            $mdata = Employee::with('employeesEngagement.employeeType')->where('id','=',$logged_user->id)->first();
            $logged_user_type = $mdata->employeesEngagement[0]->employeeType->epty_Name;
            
            if (!empty($logged_user_type) && $logged_user_type=="SchoolCoordinator" || $logged_user_type=="Teacher" || $logged_user_type=="SchoolSubAdmin") {
                return $next($request);
            }
        }
        $error = $translations['msg_access_prohibited'] ?? "Access Prohibited";
        return redirect()->back()->with('middleware_error',$error);
        die();
    }
}
