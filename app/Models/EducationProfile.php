<?php
/**
* EducationProfile 
*
* Model for EducationProfile Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationProfile extends Model
{
	use SoftDeletes;
    protected $table = 'EducationProfiles';
    public $timestamps = false;   

    public function educationPlan()
    {
        return $this->hasMany('App\Models\EducationPlan', 'fkEplEpr', 'pkEpr');
    }

    protected $fillable = array('pkEpr', 'nep_Uid', 'epr_EducationProfileName', 'epr_Notes', 'epr_Status');
}
