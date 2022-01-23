<?php
/**
* Grade 
*
* Model for Grade Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
	use SoftDeletes;
    protected $table = 'Grades';
    public $timestamps = false;

    public function educationPlan()
    {
        return $this->hasMany('App\Models\EducationPlan', 'fkEplGra', 'pkGra');
    }

    public function enrollStudent()
    {
        return $this->hasMany(EnrollStudent::class, 'fkSteGra', 'pkGra');
    }

    public function classCreationGrade()
    {
        return $this->hasMany(ClassCreationGrades::class, 'fkCcgGra', 'pkGra');
    }

    protected $fillable = array('pkGra', 'gra_Uid', 'gra_GradeName', 'gra_GradeNameRoman', 'gra_Notes');
}
