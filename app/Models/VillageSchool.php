<?php
/**
* Village School 
*
* Model for Country Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VillageSchool extends Model
{
	use SoftDeletes;
    protected $table = 'VillageSchools';
    public $timestamps = false;

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'fkVscSch', 'pkSch');
    }

    public function classCreation()
    {
        return $this->hasMany('App\Models\ClassCreation', 'fkClrVsc', 'pkVsc');
    }

}
