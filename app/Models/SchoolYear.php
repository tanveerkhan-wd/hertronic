<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolYear extends Model
{
    use SoftDeletes;
    protected $table = 'SchoolYears';
    public $timestamps = false;


    protected $fillable = array('pkSye', 'sye_Uid', 'sye_NameCharacter', 'sye_NameNumeric');

    public function enrollStudent()
    {
        return $this->hasMany(EnrollStudent::class, 'fkSteSye', 'pkSye');
    }
}
