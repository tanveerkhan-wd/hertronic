<?php
/**
* NationalEducationPlan 
*
* Model for NationalEducationPlan Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NationalEducationPlan extends Model
{
	use SoftDeletes;
    protected $table = 'NationalEducationPlans';
    public $timestamps = false;   

    public function educationPlan()
    {
        return $this->hasMany('App\Models\NationalEducationPlan', 'fkEplNep', 'pkNep');
    }

    protected $fillable = array('pkNep', 'nep_Uid', 'nep_NationalEducationPlanName', 'nep_Notes', 'nep_Status');
}
