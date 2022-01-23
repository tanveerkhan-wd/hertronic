<?php
/**
* Class 
*
* Model for Class Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
	use SoftDeletes;
    protected $table = 'Classes';
    public $timestamps = false;

    protected $fillable = array('pkCla', 'cla_Uid', 'cla_ClassName', 'cla_Notes');
}
