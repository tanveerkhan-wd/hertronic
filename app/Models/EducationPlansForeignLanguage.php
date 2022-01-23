<?php
/**
* EducationPlansForeignLanguage 
*
* Model for EducationPlansForeignLanguage Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationPlansForeignLanguage extends Model
{
	use SoftDeletes;
    protected $table = 'EducationPlansForeignLanguage';
    public $timestamps = false;   

    public function educationPlan()
    {
        return $this->belongsTo('App\Models\EducationPlan', 'fkEflEpl', 'pkEpl');
    }

    public function foreignLanguageGroup()
    {
        return $this->belongsTo('App\Models\Course', 'fkEflCrs', 'pkCrs');
    }

    protected $fillable = array('pkEfl', 'fkEflEpl', 'fkEflCrs', 'efc_hours');
}
