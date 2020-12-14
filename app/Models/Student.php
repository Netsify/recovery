<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

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
        'IIN', 'email'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Return the student's full name.
     *
     * @return string
     */
    public function getFullNameAttribute() : string
    {
        return "{$this->stud_fam} {$this->stud_name} {$this->stud_otch}";
    }

    /**
     * Return the student's specialty.
     *
     * @return HasOne
     */
    public function specialty() : HasOne
    {
        return $this->hasOne(Specialty::class, 'spec_id', 'stud_spec');
    }

    /**
     * Return the student's education form.
     *
     * @return HasOne
     */
    public function educationForm() : HasOne
    {
        return $this->hasOne(EducationForm::class, 'id', 'id_education_form');
    }

    /**
     * Return the student's email changing requests
     *
     * @return HasMany
     */
    public function requests(): HasMany
    {
        return $this->hasMany(EmailChangeRequest::class, 'student_id', 'stud_id');
    }

    /**
     * Return the student's disguised email in a format of a********a@a*.com
     *
     * @return string
     */
    public function disguiseEmail() : string
    {
        return preg_replace('/(?<=.).(?=[^@]+@)|(?<=@.).*(?=.*?\.)/', '*', $this->email);
    }

    /**
     * Return the student's randomly generated numerical password
     *
     * @return string
     */
    #[Pure]
    public function createPassword() : string
    {
        return substr(str_shuffle('0123456789'), 0, 8);
    }

    /**
     * Return the last student record by IIN
     *
     * @param $IIN
     * @return Builder
     */
    public function getByIIN($IIN) : Builder
    {
        return $this->where('IIN', $IIN)->latest($this->primaryKey)->first();
    }

    /**
     * Return the last student record by student's fullname
     *
     * @param $fullName
     * @return Builder
     */
    public function getByFullName($fullName) : Builder
    {
        if (!isset($fullName['last_name'])) {
            $fullName['last_name'] = null;
        }
        $student = $this->where(DB::raw('TRIM(stud_fam)'), $fullName['first_name'])
                        ->where(DB::raw('TRIM(stud_name)'), $fullName['middle_name'])
                        ->where(DB::raw('TRIM(stud_otch)'), $fullName['last_name']);

        return $student->latest($this->primaryKey)->first();
    }

    /**
     * Return the student's fullname
     *
     * @return string
     */
    public function getFullName() : string
    {
        $fullname = $this->stud_fam . ' ' . $this->stud_name;
        if ($this->stud_otch) {
            $fullname .= ' ' . $this->stud_otch;
        }

        return kaz_translit($fullname, true);
    }

    /**
     * Return the student's group
     */
    public function getGroup()
    {
        return DB::selectOne("SELECT get_group_by_student_id(?) `group`", [$this->stud_id])->group;
    }
}
