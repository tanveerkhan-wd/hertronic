<?php
/**
* School Principal
*
* Model for SchoolPrincipal Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolPrincipal extends Model
{
	use SoftDeletes;
    protected $table = 'SchoolPrincipals';
    public $timestamps = false; 
    protected $primaryKey = 'pkScp';

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'fkScpSch', 'pkSch');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'fkScpEmp', 'id');
    }

}
