<?php
/**
* ClassTeachersAndCourseAllocation 
*
* Model for ClassTeachersAndCourseAllocation Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTeachersAndCourseAllocation extends Model
{
	use SoftDeletes;
    protected $table = 'ClassTeachersAndCourseAllocation';
    public $timestamps = false;

    public function classCreation()
    {
        return $this->belongsTo('App\Models\ClassCreation', 'fkCtcClr', 'pkClr');
    }

}
