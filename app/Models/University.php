<?php
/**
* University 
*
* Model for University Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
	use SoftDeletes;
    protected $table = 'Universities';
    public $timestamps = false;

    public function ownershipType()
    {
        return $this->belongsTo('App\Models\OwnershipType', 'fkUniOty', 'pkOty');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'fkUniCny', 'pkCny');
    }

    public function college()
    {
        return $this->hasMany('App\Models\College', 'fkColUni', 'pkUni');
    }

    public function employeeEducation()
    {
        return $this->hasMany('App\Models\EmployeesEducationDetail', 'fkEedUni', 'pkUni');
    }

    protected $fillable = array('pkUni', 'fkUniCny', 'fkUniOty', 'uni_Uid', 'uni_UniversityName', 'uni_YearStartedFounded', 'uni_PicturePath', 'uni_Notes');
}
