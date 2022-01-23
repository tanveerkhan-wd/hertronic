<?php
/**
* State 
*
* Model for State Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
	use SoftDeletes;
    protected $table = 'States';
    public $timestamps = false;

    /**
     * Get the country that has the state.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'fkStaCny', 'pkCny');
    }

    public function canton()
    {
        return $this->hasMany('App\Models\Canton', 'fkCanSta', 'pkCan');
    }

    protected $fillable = array('pkSta', 'sta_Uid', 'fkStaCny', 'sta_StateName_en', 'sta_StateNameGenitive', 'sta_Status', 'sta_Note');
}
