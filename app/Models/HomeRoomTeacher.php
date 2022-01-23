<?php
/**
* Home Room Teacher 
*
* Model for HomeRoomTeacher Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeRoomTeacher extends Model
{
	use SoftDeletes;
    protected $table = 'HomeRoomTeacher';
    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'fkHrtEmp', 'id');
    }

    public function classCreation()
    {
        return $this->belongsTo('App\Models\ClassCreation', 'fkHrtClr', 'pkClr');
    }

    public function engagementType()
    {
        return $this->belongsTo('App\Models\EngagementType', 'fkHrtEty', 'pkEty');
    }

}
