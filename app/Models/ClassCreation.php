<?php
/**
* ClassCreation 
*
* Model for ClassCreation Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassCreation extends Model
{
	use SoftDeletes;
    protected $table = 'ClassCreation';
    public $timestamps = false;

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'fkClrVsc', 'pkSch');
    }

    public function villageSchool()
    {
        return $this->belongsTo('App\Models\VillageSchool', 'fkClrVsc', 'pkVsc');
    }

    public function classStudentsAllocation()
    {
        return $this->hasMany('App\Models\ClassStudentsAllocation', 'fkCsaClr', 'pkClr');
    }

    public function classTeachersAndCourseAllocation()
    {
        return $this->hasMany('App\Models\ClassTeachersAndCourseAllocation', 'fkCtcClr', 'pkClr');
    }

    public function classCreationGrades()
    {
        return $this->hasMany('App\Models\ClassCreationGrades', 'fkCcgClr', 'pkClr');
    }

    public function homeRoomTeacher()
    {
        return $this->hasMany('App\Models\HomeRoomTeacher', 'fkHrtClr', 'pkClr');
    }

    public function classCreationClasses()
    {
        return $this->belongsTo('App\Models\Classes', 'fkClrCla', 'pkCla');
    }

    public function classCreationSchoolYear()
    {
        return $this->belongsTo('App\Models\SchoolYear', 'fkClrSye', 'pkSye');
    }

    public function chiefStudent()
    {
        return $this->belongsTo('App\Models\EnrollStudent', 'fkClrCsa', 'pkSte');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\EducationPeriod', 'fkClrEdp', 'pkEdp');
    }

    public function treasureStudent()
    {
        return $this->belongsTo('App\Models\EnrollStudent', 'fkClrCsat', 'pkSte');
    }

}
