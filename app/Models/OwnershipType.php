<?php
/**
* OwnershipType
*
* Model for OwnershipType Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OwnershipType extends Model
{
	use SoftDeletes;
    protected $table = 'OwnershipTypes';
    public $timestamps = false;

    public function university()
    {
        return $this->hasMany('App\Models\University', 'fkUniOty', 'pkOty');
    }

    public function college()
    {
        return $this->hasMany('App\Models\College', 'fkColOty', 'pkOty');
    }

    public function school()
    {
        return $this->hasMany('App\Models\School', 'fkSchOty', 'pkOty');
    }

    protected $fillable = array('pkOty', 'oty_Uid', 'oty_OwnershipTypeName', 'oty_Notes', 'oty_Status');
}
