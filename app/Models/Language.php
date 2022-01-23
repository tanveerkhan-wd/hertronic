<?php
/**
* Language 
*
* Model for Language Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
	use SoftDeletes;
    protected $table = 'Languages';
    public $timestamps = false;

    protected $fillable = array('id', 'language_key', 'language_name', 'flag');

}
