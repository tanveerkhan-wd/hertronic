<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacultativeCoursesGroup extends Model
{
	use SoftDeletes;
    protected $table = 'FacultativeCoursesGroups';
    public $timestamps = false;

    protected $fillable = array('pkFcg', 'fcg_Uid', 'fcg_Name', 'fcg_Notes');	
}
