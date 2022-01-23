<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnrollStudent extends Model
{
	use SoftDeletes;
    protected $table = 'StudentEnrollments';
    public $timestamps = false;


    protected $fillable = array('pkSte','fkSteStu','fkSteMbo','fkSteGra','fkSteEdp','fkSteSye','ste_DistanceInKilometers','ste_MainBookOrderNumber','ste_EnrollmentDate','ste_EnrollBasedOn','ste_Reason','ste_FinishingDate','ste_BreakingDate','ste_ExpellingDate');    

    public function student()
    {
        return $this->belongsTo(Student::class, 'fkSteStu', 'id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'fkSteGra', 'pkGra');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'fkSteSch', 'pkSch');
    }

    public function educationProgram()
    {
    	return $this->belongsTo(EducationProgram::class, 'fkSteEdp', 'pkEdp');
    }

    public function educationPlan()
    {
    	return $this->belongsTo(EducationPlan::class, 'fkSteEpl', 'pkEpl');
    }

    public function schoolYear()
    {
    	return $this->belongsTo(SchoolYear::class, 'fkSteSye', 'pkSye');
    }
}
