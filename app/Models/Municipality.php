<?php
/**
* Municipality 
*
* Model for Municipality Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipality extends Model
{
	use SoftDeletes;
    protected $table = 'Municipalities';
    public $timestamps = false;


    public function canton()
    {
        return $this->belongsTo('App\Models\Canton', 'fkMunCan', 'pkCan');
    }

    public function postalCode()
    {
        return $this->hasMany('App\Models\PostalCode', 'fkPofMun', 'pkMun');
    }

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'fkEmpMun', 'pkMun');
    }

    protected $fillable = array('pkMun', 'fkMunCan', 'mun_Uid', 'mun_MunicipalityName', 'mun_MunicipalityNameGenitive', 'mun_Notes');
}
