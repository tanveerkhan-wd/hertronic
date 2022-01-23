<?php
/**
* Student 
*
* Model for Students Table
* 
* @package    Laravel
* @subpackage Model
* @since      1.0
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'Students';
    public $timestamps = false;

    public function getFullNameAttribute()
    {
        return $this->stu_StudentName . ' ' . $this->stu_StudentSurname;
    }
    
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'fkStuMun', 'pkMun');
    }
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'fkStuNat', 'pkNat');
    }
    public function citizenship()
    {
        return $this->belongsTo(Citizenship::class, 'fkStuCtz', 'pkCtz');
    }

    public function riligeion()
    {
        return $this->belongsTo(Religion::class, 'fkStuRel', 'pkRel');
    }
    public function postalCode()
    {
        return $this->belongsTo(PostalCode::class, 'fkStuPof', 'pkPof');
    }

    public function jawFather()
    {
        return $this->belongsTo(JobAndWork::class, 'fkStuFatherJaw', 'pkJaw');
    }

    public function jawMother()
    {
        return $this->belongsTo(JobAndWork::class, 'fkStuMotherJaw', 'pkJaw');
    }

    public function enrollStudent()
    {
        return $this->hasMany(EnrollStudent::class, 'fkSteStu', 'id');
    }

    public function chiefStudent()
    {
        return $this->hasMany(ClassCreation::class, 'fkClrCsa', 'id');
    }

    public function treasureStudent()
    {
        return $this->hasMany(ClassCreation::class, 'fkClrCsat', 'id');
    }

    protected $fillable = array('id', 'fkStuMun', 'fkStuPof', 'fkStuNat', 'fkStuRel', 'fkStuCtz', 'fkStuFatherJaw', 'fkStuMotherJaw', 'stu_StudentID', 'stu_TempCitizenId', 'stu_StudentName', 'stu_StudentSurname', 'stu_DateOfBirth', 'stu_PlaceOfBirth', 'stu_StudentGender', 'stu_Address', 'stu_DistanceInKilometers', 'email', 'stu_PhoneNumber', 'stu_MobilePhoneNumber', 'stu_FatherName', 'stu_MotherName', 'stu_ParentsEmail', 'stu_ParantsPhone', 'stu_DateOfAbandoning', 'stu_DateOfExpelling', 'stu_Reason', 'stu_SpecialNeed', 'stu_PicturePath', 'stu_Note');

    	
}
