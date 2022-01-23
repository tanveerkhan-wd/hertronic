<?php
/**
* EmployeeType 
*
* Model for EmployeeType Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeType extends Model
{
	use SoftDeletes;
    protected $table = 'EmployeeTypes';
    public $timestamps = false;

    public function EmployeesEngagement()
    {
        return $this->hasMany('App\Models\EmployeesEngagement', 'fkEenEpty', 'pkEpty');
    }

    protected $fillable = array('pkEpty', 'epty_Name', 'epty_EmpTypeParentId', 'epty_subCatName', 'epty_Notes');
}
