<?php
/**
* EducationPlansOptionalCourse 
*
* Model for EducationPlansOptionalCourse Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationPlansOptionalCourse extends Model
{
	use SoftDeletes;
    protected $table = 'EducationPlansOptionalCourses';
    public $timestamps = false;   

    public function educationPlan()
    {
        return $this->belongsTo('App\Models\EducationPlan', 'fkEocEpl', 'pkEpl');
    }

    public function optionalCoursesGroup()
    {
        return $this->belongsTo('App\Models\Course', 'fkEocCrs', 'pkCrs');
    }
    
    protected $fillable = array('pkEoc', 'fkEocEpl', 'fkEocCrs', 'eoc_hours');
}
