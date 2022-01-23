<?php
/**
* Course 
*
* Model for Course Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
	use SoftDeletes;
    protected $table = 'Courses';
    public $timestamps = false;

    public function EPMandatoryCourseGroup()
    {
        return $this->hasMany('App\Models\EducationPlansMandatoryCourse', 'fkEplCrs', 'pkCrs');
    }

    protected $fillable = array('pkCrs', 'crs_Uid', 'crs_CourseName', 'crs_CourseAlternativeName', 'crs_CourseType', 'crs_IsForeignLanguage', 'crs_Notes');
}
