<?php
/**
* College 
*
* Model for College Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{
	use SoftDeletes;
    protected $table = 'Colleges';
    public $timestamps = false;

    public function employeeEducation()
    {
        return $this->hasMany('App\Models\EmployeesEducationDetail', 'fkEedCol', 'pkCol');
    }

    public function ownershipType()
    {
        return $this->belongsTo('App\Models\OwnershipType', 'fkColOty', 'pkOty');
    }

    public function university()
    {
        return $this->belongsTo('App\Models\University', 'fkColUni', 'pkUni');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'fkColCny', 'pkCny');
    }

    protected $fillable = array('pkCol', 'fkColUni', 'fkColCny', 'fkColOty', 'col_Uid', 'col_CollegeName', 'col_YearStartedFounded', 'col_BelongsToUniversity', 'col_PicturePath', 'col_Notes');
}
