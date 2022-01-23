<?php
/**
* SchoolEducationPlanAssignment 
*
* Model for SchoolEducationPlanAssignment Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolEducationPlanAssignment extends Model
{
	use SoftDeletes;
    protected $table = 'SchoolEducationPlanAssignment';
    public $timestamps = false;   

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'fkSepSch', 'pkSch');
    }

    public function educationProgram()
    {
        return $this->belongsTo('App\Models\EducationProgram', 'fkSepEdp', 'pkEdp');
    }

    public function educationPlan()
    {
        return $this->belongsTo('App\Models\EducationPlan', 'fkSepEpl', 'pkEpl');
    }
}
