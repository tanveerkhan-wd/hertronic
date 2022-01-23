<?php
/**
* EducationProgram 
*
* Model for EducationProgram Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationProgram extends Model
{
    use SoftDeletes;
    protected $table = 'EducationPrograms';
    public $timestamps = false;
	
	//each category might have one parent
    public function parent() {
        return $this->belongsTo(static::class, 'edp_ParentId','pkEdp');
    }

    //each category might have multiple children
    public function children() {
        return $this->hasMany(static::class, 'edp_ParentId')->orderBy('name', 'asc');
    }
    
    public function educationPlan()
    {
        return $this->hasMany('App\Models\EducationPlan', 'fkEplEdp', 'pkEdp');
    }

    public function enrollStudent()
    {
        return $this->hasMany(EnrollStudent::class, 'fkSteEdp', 'pkEdp');
    }

    public function schoolEducationPlanAssignment()
    {
        return $this->hasMany('App\Models\SchoolEducationPlanAssignment', 'fkSepEdp', 'pkEdp');
    }

    protected $fillable = array('pkEdp', 'edp_Uid', 'edp_Name', 'edp_ParentId' ,'edp_Notes');   
}
