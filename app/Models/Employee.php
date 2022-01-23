<?php
/**
* Employee 
*
* Model for Employee Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;	
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Authenticatable
{
	use SoftDeletes;
    protected $table = 'Employees';
    public $timestamps = false;

    public function EmployeesEngagement()
    {
        return $this->hasMany('App\Models\EmployeesEngagement', 'fkEenEmp', 'id');
    }

    public function employeeEducation()
    {
        return $this->hasMany('App\Models\EmployeesEducationDetail', 'fkEedEmp', 'id');
    }

    public function homeRoomTeacher()
    {
        return $this->hasMany('App\Models\HomeRoomTeacher', 'fkHrtEmp', 'id');
    }

    public function municipality()
    {
        return $this->belongsTo('App\Models\Municipality', 'fkEmpMun', 'pkMun');
    }

    public function postalCode()
    {
        return $this->belongsTo('App\Models\PostalCode', 'fkEmpPof', 'pkPof');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'fkEmpCny', 'pkCny');
    }

    public function nationality()
    {
        return $this->belongsTo('App\Models\Nationality', 'fkEmpNat', 'pkNat');
    }

    public function religion()
    {
        return $this->belongsTo('App\Models\Religion', 'fkEmpRel', 'pkRel');
    }

    public function citizenship()
    {
        return $this->belongsTo('App\Models\Citizenship', 'fkEmpCtz', 'pkCtz');
    }

    protected $fillable = array('id', 'fkEmpMun', 'fkEmpPof', 'fkEmpCny', 'fkEmpNat', 'fkEmpRel', 'fkEmpCtz', 'emp_EmployeeID', 'emp_TempCitizenId', 'emp_DateOfBirth', 'emp_PlaceOfBirth', 'emp_EmployeeGender', 'emp_Address', 'email', 'email_verification_key', 'email_verified_at', 'password', 'remember_token', 'emp_PhoneNumber', 'emp_PicturePath', 'emp_Notes');
}
