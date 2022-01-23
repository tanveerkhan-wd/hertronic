<?php
/**
* Country 
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

class Country extends Model
{
	use SoftDeletes;
    protected $table = 'Countries';
    public $timestamps = false;

    public function state()
    {
        return $this->hasMany('App\Models\State', 'fkStaCny', 'pkCny');
    }

    public function university()
    {
        return $this->hasMany('App\Models\University', 'fkUniCny', 'pkCny');
    }

    public function college()
    {
        return $this->hasMany('App\Models\College', 'fkColCny', 'pkCny');
    }

    public function citizenship()
    {
        return $this->hasMany('App\Models\Citizenship', 'fkCtzCny', 'pkCny');
    }

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'fkEmpCny', 'pkCny');
    }

    public function statesWithCanton(){
	     return $this->state()->with('canton');
	}

    protected $fillable = array('pkCny', 'cny_Uid', 'cny_CountryName_en', 'cny_CountryNameGenitive', 'cny_CountryNameDative', 'cny_CountryNameAdjective', 'cny_Note');
}
