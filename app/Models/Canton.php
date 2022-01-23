<?php
/**
* Canton 
*
* Model for Canton Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Canton extends Model
{
	use SoftDeletes;
    protected $table = 'Cantons';
    public $timestamps = false;

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'fkCanSta', 'pkSta');
    }

    public function municipality()
    {
        return $this->hasMany('App\Models\Municipality', 'fkMunCan', 'pkCan');
    }

    protected $fillable = array('pkCan', 'can_Uid', 'fkCanSta', 'can_CantonName_en', 'can_CantonNameGenitive', 'can_Status', 'can_Note');
}
