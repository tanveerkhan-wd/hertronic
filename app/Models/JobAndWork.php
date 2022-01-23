<?php
/**
* JobAndWork
*
* Model for JobAndWork Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobAndWork extends Model
{
	use SoftDeletes;
    protected $table = 'JobAndWork';
    public $timestamps = false;


    protected $fillable = array('pkJaw', 'jaw_Uid', 'jaw_Name', 'jaw_Notes', 'jaw_Status');
}
