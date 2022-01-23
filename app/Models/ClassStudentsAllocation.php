<?php
/**
* ClassStudentsAllocation 
*
* Model for ClassStudentsAllocation Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassStudentsAllocation extends Model
{
	use SoftDeletes;
    protected $table = 'ClassStudentsAllocation';
    public $timestamps = false;

    public function classCreation()
    {
        return $this->belongsTo('App\Models\ClassCreation', 'fkCsaClr', 'pkClr');
    }

    public function studentEnroll()
    {
        return $this->belongsTo('App\Models\EnrollStudent', 'fkCsaSen', 'pkSte');
    }

}
