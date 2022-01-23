<?php
/**
* Vocation 
*
* Model for Vocation Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vocation extends Model
{
	use SoftDeletes;
    protected $table = 'Vocations';
    public $timestamps = false;
   
    protected $fillable = array('pkVct', 'vct_Uid', 'vct_VocationName', 'vct_Notes');
}
