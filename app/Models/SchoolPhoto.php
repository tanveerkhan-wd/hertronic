<?php
/**
* School Photo 
*
* Model for SchoolPhoto Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolPhoto extends Model
{
	use SoftDeletes;
    protected $table = 'SchoolPhotos';
    public $timestamps = false; 
    protected $primaryKey = 'pkSph';

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'fkSphSch', 'pkSch');
    }

}
