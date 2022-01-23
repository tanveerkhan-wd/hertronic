<?php
/**
* EducationPlansMandatoryCourse 
*
* Model for EducationPlansMandatoryCourse Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationPlansMandatoryCourse extends Model
{
	use SoftDeletes;
    protected $table = 'EducationPlansMandatoryCourses';
    public $timestamps = false;   

    public function educationPlan()
    {
        return $this->belongsTo('App\Models\EducationPlan', 'fkEmcEpl', 'pkEpl');
    }

    public function mandatoryCourseGroup()
    {
        return $this->belongsTo('App\Models\Course', 'fkEplCrs', 'pkCrs');
    }

    protected $fillable = array('pkEmc', 'fkEmcEpl', 'fkEplCrs', 'emc_hours');
}
