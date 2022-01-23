<?php
/**
* School 
*
* Model for School Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
	use SoftDeletes;
    protected $table = 'Schools';
    public $timestamps = false; 
    protected $primaryKey = 'pkSch';

    public function classCreation()
    {
        return $this->hasMany('App\Models\ClassCreation', 'fkClrVsc', 'pkSch');
    }

    public function schoolEducationPlanAssignment()
    {
        return $this->hasMany('App\Models\SchoolEducationPlanAssignment', 'fkSepSch', 'pkSch');
    }

    public function employeesEngagement()
    {
        return $this->hasMany('App\Models\EmployeesEngagement', 'fkEenSch', 'pkSch');
    }

    public function schoolPhoto()
    {
        return $this->hasMany('App\Models\SchoolPhoto', 'fkSphSch', 'pkSch');
    }

    public function schoolPrincipal()
    {
        return $this->hasMany('App\Models\SchoolPrincipal', 'fkScpSch', 'pkSch');
    }

    public function villageSchool()
    {
        return $this->hasMany('App\Models\VillageSchool', 'fkVscSch', 'pkSch');
    }

    public function mainBook()
    {
        return $this->hasMany('App\Models\MainBook', 'fkMboSch', 'pkSch');
    }

    public function postalCode()
    {
        return $this->belongsTo('App\Models\PostalCode', 'fkSchPof', 'pkPof');
    }

    public function ownershipType()
    {
        return $this->belongsTo('App\Models\OwnershipType', 'fkSchOty', 'pkOty');
    }


    protected $fillable = array('pkSch', 'fkSchPof', 'fkSchOty', 'sch_Uid', 'sch_SchoolLogo', 'sch_SchoolName', 'sch_SchoolId', 'sch_SchoolEmail', 'sch_Founder', 'sch_FoundingDate', 'sch_Address', 'sch_PhoneNumber', 'sch_MinistryApprovalCertificate', 'sch_AboutSchool');
}
