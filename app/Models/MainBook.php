<?php
/**
* Main Book 
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

class MainBook extends Model
{
	use SoftDeletes;
    protected $table = 'MainBooks';
    public $timestamps = false;

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'fkMboSch', 'pkSch');
    }

}
