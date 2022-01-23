<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeDesignation extends Model
{
    use SoftDeletes;
    protected $table = 'EmployeeDesignations';
    public $timestamps = false;

    public function employeeEducation()
    {
        return $this->hasMany('App\Models\EmployeesEducationDetail', 'fkEedEde', 'pkEde');
    }
    //protected $fillable = array('pkEdp', 'edp_Uid', 'edp_EducationPeriodName', 'edp_EducationPeriodNameAdjective');
}
