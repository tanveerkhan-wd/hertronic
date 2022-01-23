<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeesEducationDetail extends Model
{
    use SoftDeletes;
    protected $table = 'EmployeesEducationDetails';
    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'fkEedEmp', 'id');
    }

    public function university()
    {
        return $this->belongsTo('App\Models\University', 'fkEedUni', 'pkUni');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College', 'fkEedCol', 'pkCol');
    }

    public function academicDegree()
    {
        return $this->belongsTo('App\Models\AcademicDegree', 'fkEedAcd', 'pkAcd');
    }

    public function qualificationDegree()
    {
        return $this->belongsTo('App\Models\QualificationDegree', 'fkEedQde', 'pkQde');
    }

    public function employeeDesignation()
    {
        return $this->belongsTo('App\Models\EmployeeDesignation', 'fkEedEde', 'pkEde');
    }

    //protected $fillable = array('pkEdp', 'edp_Uid', 'edp_EducationPeriodName', 'edp_EducationPeriodNameAdjective');
}
