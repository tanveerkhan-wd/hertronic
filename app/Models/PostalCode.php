<?php
/**
* PostalCode 
*
* Model for PostalCode Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostalCode extends Model
{
	use SoftDeletes;
    protected $table = 'PostOffices';
    public $timestamps = false;

    public function municipality()
    {
        return $this->belongsTo('App\Models\Municipality', 'fkPofMun', 'pkMun');
    }

    public function school()
    {
        return $this->hasMany('App\Models\School', 'fkSchPof', 'pkPof');
    }

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'fkEmpPof', 'pkPof');
    }

    protected $fillable = array('pkPof', 'fkPofMun', 'pof_Uid', 'pof_PostOfficeName', 'pof_PostOfficeNumber', 'pof_Notes');
}
