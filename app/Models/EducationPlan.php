<?php
/**
* EducationPlan 
*
* Model for EducationPlan Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationPlan extends Model
{
	use SoftDeletes;
    protected $table = 'EducationPlans';
    public $timestamps = false;   

    public function mandatoryCourse()
    {
        return $this->hasMany('App\Models\EducationPlansMandatoryCourse', 'fkEmcEpl', 'pkEpl');
    }

    public function optionalCourse()
    {
        return $this->hasMany('App\Models\EducationPlansOptionalCourse', 'fkEocEpl', 'pkEpl');
    }

    public function foreignLanguageCourse()
    {
        return $this->hasMany('App\Models\EducationPlansForeignLanguage', 'fkEflEpl', 'pkEpl');
    }

    public function schoolEducationPlanAssignment()
    {
        return $this->hasMany('App\Models\SchoolEducationPlanAssignment', 'fkSepEpl', 'pkEpl');
    }

    public function enrollStudent()
    {
        return $this->hasMany(EnrollStudent::class, 'fkSteEpl', 'pkEpl');
    }

    public function educationProgram()
    {
        return $this->belongsTo('App\Models\EducationProgram', 'fkEplEdp', 'pkEdp');
    }

    public function nationalEducationPlan()
    {
        return $this->belongsTo('App\Models\NationalEducationPlan', 'fkEplNep', 'pkNep');
    }

    public function educationProfile()
    {
        return $this->belongsTo('App\Models\EducationProfile', 'fkEplEpr', 'pkEpr');
    }

    public function QualificationDegree()
    {
        return $this->belongsTo('App\Models\QualificationDegree', 'fkEplQde', 'pkQde');
    }

    public function grades()
    {
        return $this->belongsTo('App\Models\Grade', 'fkEplGra', 'pkGra');
    }

    protected $fillable = array('pkEpl', 'fkEplEdp', 'fkEplNep', 'fkEplEpr', 'fkEplQde', 'fkEplGra', 'epl_Uid', 'epl_EducationPlanName');
}
