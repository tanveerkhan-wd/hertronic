<?php
/**
* Religion 
*
* Model for Religion Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Religion extends Model
{
	use SoftDeletes;
    protected $table = 'Religions';
    public $timestamps = false;

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'fkEmpRel', 'pkRel');
    }

    protected $fillable = array('pkRel', 'rel_Uid', 'rel_ReligionName', 'rel_ReligionNameAdjective', 'rel_Notes');
}
