<?php
/**
* AcademicDegree
*
* Model for AcademicDegree Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicDegree extends Model
{
	use SoftDeletes;
    protected $table = 'AcademicDegrees';
    public $timestamps = false;

    public function employeeEducation()
    {
        return $this->hasMany('App\Models\EmployeesEducationDetail', 'fkEedAcd', 'pkAcd');
    }
    
    protected $fillable = array('pkAcd', 'acd_Uid', 'acd_AcademicDegreeName', 'acd_Notes');
}
