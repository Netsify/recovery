<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'stud_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IIN', 'email',
    ];

    public function specialty()
    {
        return $this->hasOne(Specialty::class, 'spec_id', 'stud_spec');
    }

    public function educationForm()
    {
        return $this->hasOne(EducationForm::class, 'id', 'id_education_form');
    }

    /**
     * Return the student's email changing requests
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class, 'student_id', 'stud_id');
    }

    public function disguiseEmail()
    {
        return preg_replace('/(?<=.).(?=[^@]+@)|(?<=@.).*(?=.*?\.)/', '*', $this->email);
    }

    public function createPassword()
    {
        return substr(str_shuffle('0123456789'), 0, 8);
    }

    public function getByIIN($IIN)
    {
        return $this->where('IIN', $IIN)->latest($this->primaryKey)->first();
    }

    public function getByFullName($fullName)
    {
        if (!isset($fullName['last_name'])) {
            $fullName['last_name'] = null;
        }
        $student = $this->where(DB::raw('TRIM(stud_fam)'), $fullName['first_name'])
                        ->where(DB::raw('TRIM(stud_name)'), $fullName['middle_name'])
                        ->where(DB::raw('TRIM(stud_otch)'), $fullName['last_name']);

        return $student->latest($this->primaryKey)->first();
    }

    public function getFullName()
    {
        $fullname = $this->stud_fam . ' ' . $this->stud_name;
        if ($this->stud_otch) {
            $fullname .= ' ' . $this->stud_otch;
        }

        return kaz_translit($fullname, true);
    }

    public function getGroup()
    {
        return DB::selectOne("SELECT get_group_by_student_id(?) `group`", [$this->stud_id])->group;
    }
}
