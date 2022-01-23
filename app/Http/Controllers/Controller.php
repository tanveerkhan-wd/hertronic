<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Language;
use App\Models\Translation;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\EmployeesEngagement;
use App\Models\EmployeeTypes;
use View;
use Auth;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $logged_user;

    public $admins = ['HertronicAdmin', 'MinistryAdmin', 'MinistrySubAdmin'];

    public $employees = ['Teacher', 'Principal', 'SchoolCoordinator', 'SchoolSubAdmin'];

    public $translations;

    public $languages;

    public function __construct()
    {
    	$this->middleware(function ($request, $next) {
            if (Session::has('current_language')) {
                $this->current_language = Session::get('current_language');
            }else{
                $this->current_language = 'en';
            }

    		if(!empty(Auth::guard('admin')->user()) && empty(Auth::guard('employee')->user())){
	    		$this->logged_user = Auth::guard('admin')->user();
	    		$this->logged_user->utype = 'admin';

	    	}elseif(!empty(Auth::guard('employee')->user())){
                $this->logged_user = Auth::guard('employee')->user();
                $this->logged_user->utype = 'employee';
                $mdata = Employee::with('employeesEngagement.employeeType')->where('id','=',$this->logged_user->id)->first();
                $this->logged_user->type = $mdata->employeesEngagement[0]->employeeType->epty_Name;
                if (Session::has('curr_emp_type')) {
                    $this->logged_user->type = Session::get('curr_emp_type');
                }
                $employeeRoles = Employee::with(['EmployeesEngagement.school'=> function($query){
                        $query->select('pkSch', 'sch_SchoolName_'.$this->current_language.' as sch_SchoolName');
                    },
                    'EmployeesEngagement.employeeType',
                    'EmployeesEngagement'=> function($query){
                        $query->where('een_DateOfFinishEngagement', '=', null);
                    },
                ]);
                $employeeRoles = $employeeRoles->where('id','=',$this->logged_user->id)->first();

                // if(isset($_GET['test'])){
                //     dd($employeeRoles);
                // }

                View::share('employeeRoles', $employeeRoles);

            }elseif(!empty(Auth::guard('student')->user())){
                $this->logged_user = Auth::guard('student')->user();
                $this->logged_user->utype = 'student';
                $this->logged_user->type = 'Student';
            }else{
                //return redirect('logout');
            }

            //dd($this->logged_user);

            $this->languages = Language::get();
            $this->translations = Translation::get()->pluck('value_'.$this->current_language,'key');
            //$translations_header = Translation::CommonData('sidebar')->get();
            View::share('languages', $this->languages);
	        View::share('logged_user', $this->logged_user);
            View::share('current_language',$this->current_language);
            View::share('translations', $this->translations);
            // dd($translations_sidebar,$langValues);
		    return $next($request);
		});
    	
    	
    }

}
