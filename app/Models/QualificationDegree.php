<?php
/**
* QualificationDegree 
*
* Model for QualificationDegree Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QualificationDegree extends Model
{
	use SoftDeletes;
    protected $table = 'QualificationsDegrees';
    public $timestamps = false;   

    public function educationPlan()
    {
        return $this->hasMany('App\Models\EducationPlan', 'fkEplQde', 'pkQde');
    }

    public function employeeEducation()
    {
        return $this->hasMany('App\Models\EmployeesEducationDetail', 'fkEedQde', 'pkQde');
    }

    protected $fillable = array('pkQde', 'qde_Uid', 'qde_QualificationDegreeName', 'qde_Notes', 'qde_Status');
}
