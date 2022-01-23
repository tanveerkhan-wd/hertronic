<?php
/**
* Citizenship 
*
* Model for Citizenship Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citizenship extends Model
{
	use SoftDeletes;
    protected $table = 'Citizenships';
    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'fkCtzCny', 'pkCny');
    }

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'fkEmpCtz', 'pkCtz');
    }

    protected $fillable = array('pkCtz', 'ctz_Uid', 'fkCtzCny', 'ctz_CitizenshipName', 'ctz_Notes');
}
