<?php
/**
* TranslationController 
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
use App\Models\Translation;
use App\Models\Language;
use Validator;
use Carbon\Carbon;
use Auth;
use Redirect;

class TranslationController extends Controller
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

    public function translations(Request $request)
    {
        /**
         * Used for Admin Translations
         * @return redirect to Admin->Translations
         */
        $data = Language::get();
        if (request()->ajax()) {
            return \View::make('admin.translations.translations')->with('data', $data)->renderSections();
        }
        return view('admin.translations.translations',['data'=>$data]);
    }

    public function addTranslation(Request $request)
    {
      /**
       * Used for Add Admin Translation
       */
    	$input = $request->all();
    	$response = [];
    	if(!empty($input['id'])){
            //$checkPrev = Translation::where('section',$input['section'])->where('id','!=',$input['id'])->first();
            $checkPrevKey = Translation::where('key',$input['key'])->where('id','!=',$input['id'])->first();
            // if(!empty($checkPrev)){
            //   $response['status'] = false;
            //   $response['message'] = "Translation already exists with this name";
            // }else
            if(!empty($checkPrevKey)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_translation_exists'] ?? "Translation already exists with this key";
            }else{
        		$id = Translation::where('id', $input['id'])
    	              ->update($input);
                $response['status'] = true;
                $response['message'] = $this->translations['msg_translation_update_success'] ?? "Translation Successfully Updated";
            }
    	}else{
            //$checkPrev = Translation::where('section',$input['section'])->first();
            $checkPrevKey = Translation::where('key',$input['key'])->first();
            // if(!empty($checkPrev)){
            //   $response['status'] = false;
            //   $response['message'] = "Translation already exists with this name";
            // }else
            if(!empty($checkPrevKey)){
              $response['status'] = false;
              $response['message'] = $this->translations['msg_translation_exists'] ?? "Translation already exists with this key";
            }else{
        		$id = Translation::insertGetId($input);
    			if(!empty($id)){
    				$response['status'] = true;
    	            $response['message'] = $this->translations['msg_translation_add_success'] ?? "Translation Successfully Added";

    	        }else{
    	            $response['status'] = false;
    	            $response['message'] = $this->translations['msg_something_wrong'] ?? "Something Wrong Please try again Later";
    	        }
            }
    	}
    	

        return response()->json($response);
    }

    public function getTranslation(Request $request)
    {
      /**
       * Used for Edit Admin Translation
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];
    	$cdata = Translation::where('id','=',$input['cid'])->first();

    	if(empty($cid) || empty($cdata)){
    		$response['status'] = false;
    	}else{
    		$response['status'] = true;
    		$response['data'] = $cdata;
    	}

    	return response()->json($response);

    }

    public function getTranslations(Request $request)
    {
      /**
       * Used for Admin Translation Listing
       */
    	$data =$request->all();
	      
	    $perpage = ! empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
	      
	    $filter = isset( $data['search'] ) && is_string( $data['search'] ) ? $data['search'] : '';

	    $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';	

	    $sort_col =  $data['order'][0]['column'];

	    $sort_field = $data['columns'][$sort_col]['data'];

    	$Translation = new Translation;

    	if($filter){
    		$Translation = $Translation->where ( 'key', 'LIKE', '%' . $filter . '%' )->orWhere ( 'section', 'LIKE', '%' . $filter . '%' )->orWhere ( 'value_en', 'LIKE', '%' . $filter . '%' );
    	}
    	$TranslationQuery = $Translation;

    	if($sort_col != 0){
    		$TranslationQuery = $TranslationQuery->orderBy($sort_field, $sort_type);
    	}

    	$total_Translations= $TranslationQuery->count();

    	  $offset = $data['start'];
	     
	      $counter = $offset;
	      $Translationdata = [];
	      $Translations = $TranslationQuery->offset($offset)->limit($perpage);
	      $filtered_Translations = $TranslationQuery->offset($offset)->limit($perpage)->count();
	      $Translations = $TranslationQuery->offset($offset)->limit($perpage)->get()->toArray();

	       foreach ($Translations as $key => $value) {
	            $value['index']      = $counter+1;
	            $Translationdata[$counter] = $value;
	            $counter++;
	      }

	      $price = array_column($Translationdata, 'index');

	    if($sort_col == 0){
	     	if($sort_type == 'desc'){
	     		array_multisort($price, SORT_DESC, $Translationdata);
	     	}else{
	     		array_multisort($price, SORT_ASC, $Translationdata);
	     	}
		}
	      $result = array(
	      	"draw" => $data['draw'],
			"recordsTotal" =>$total_Translations,
			"recordsFiltered" => $total_Translations,
	        "data" => $Translationdata,
	      );

	       return response()->json($result);
    }


    public function deleteTranslation(Request $request)
    {
      /**
       * Used for Delete Admin Translation
       */
    	$input = $request->all();
    	$cid = $input['cid'];
    	$response = [];

    	if(empty($cid)){
    		$response['status'] = false;
    	}else{
    		Translation::where('id', $cid)
	              ->update(['deleted_at' => now()]);
    		$response['status'] = true;
    	}

    	return response()->json($response);
    }


}