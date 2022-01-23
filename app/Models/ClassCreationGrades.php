<?php
/**
* ClassCreationGrades 
*
* Model for ClassCreationGrades Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassCreationGrades extends Model
{
	use SoftDeletes;
    protected $table = 'ClassCreationGrades';
    public $timestamps = false;

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'fkCcgGra', 'pkGra');
    }

    public function classCreation()
    {
        return $this->belongsTo('App\Models\ClassCreation', 'fkCcgClr', 'pkCcg');
    }


}
