<?php
/**
* Translation 
*
* Model for Translation Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Translation extends Model
{
	use SoftDeletes;
    protected $table = 'Translations';
    public $timestamps = false;

    function scopeCommonData($query, $type){
    	$query->where('section', $type);
    	return $query;
    }
}
