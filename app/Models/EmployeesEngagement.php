<?php
/**
* EmployeesEngagement 
*
* Model for EmployeesEngagement Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeesEngagement extends Model
{
	use SoftDeletes;
    protected $table = 'EmployeesEngagement';
    public $timestamps = false;
    protected $primaryKey = 'pkEen';

    public function employeeType()
    {
        return $this->belongsTo('App\Models\EmployeeType', 'fkEenEpty', 'pkEpty');
    }

    public function engagementType()
    {
        return $this->belongsTo('App\Models\EngagementType', 'fkEenEty', 'pkEty');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'fkEenEmp', 'id');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'fkEenSch', 'pkSch');
    }

    // protected $fillable = array('pkEen', 'fkEenSch', 'fkEenEmp', 'fkEenEty', 'fkEenEpty', 'een_Intern', 'een_DateOfEngagement', 'een_DateOfFinishEngagement', 'een_WeeklyHoursRate', 'een_Notes');
}
