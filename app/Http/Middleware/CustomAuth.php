<?php
namespace App\Http\Middleware;
 
use Closure;
 
class CustomAuth
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

        $response = $next($request);
        if ($request->ajax()) {
            $content = $response->getOriginalContent();
            //check for datable ajax
            if (array_key_exists("draw", $content) && array_key_exists("recordsTotal", $content)) {
                $sections = $content;
            }else{
                $sections = $content->renderSections();
            }
            
            $response = $sections;
            return response()->json($response);
        }

        return $response;
         
    }
}