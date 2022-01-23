<?php
/**
* Nationality 
*
* Model for Nationality Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nationality extends Model
{
	use SoftDeletes;
    protected $table = 'Nationalities';
    public $timestamps = false;

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'fkEmpNat', 'pkNat');
    }

    protected $fillable = array('pkNat', 'nat_Uid', 'nat_NationalityName', 'nat_NationalityNameMale', 'nat_NationalityNameFemale', 'nat_Notes');
}
