<?php
/**
* EngagementType 
*
* Model for EngagementType Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngagementType extends Model
{
	use SoftDeletes;
    protected $table = 'EngagementTypes';
    public $timestamps = false;

    public function EmployeesEngagement()
    {
        return $this->hasMany('App\Models\EmployeesEngagement', 'fkEenEty', 'pkEty');
    }

    public function homeRoomTeacher()
    {
        return $this->hasMany('App\Models\HomeRoomTeacher', 'fkHrtEty', 'pkEty');
    }

}
