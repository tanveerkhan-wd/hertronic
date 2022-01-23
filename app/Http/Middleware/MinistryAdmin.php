<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Language;
use App\Models\Translation;
use Session;
use Closure;
use Auth;

class MinistryAdmin
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

        $data = $request->session()->all();
        $check_emp_type = isset($data['curr_emp_type']) ? true : false;
        if (Auth::guard('admin')->user()) {
            
            if(!empty(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type =='MinistryAdmin' && $check_emp_type==false){
                return $next($request);
            }

        }
        $error = $translations['msg_access_prohibited'] ?? "Access Prohibited";
        return redirect()->back()->with('middleware_error',$error);
        die();
        
    }
}
