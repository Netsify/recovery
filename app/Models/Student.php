<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'stud_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IIN', 'email',
    ];

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
        $student = $this->where(\DB::raw('TRIM(stud_fam)'), $fullName['first_name'])
                        ->where(\DB::raw('TRIM(stud_name)'), $fullName['middle_name']);
        if (isset($fullName['last_name'])) {
            $student->where(\DB::raw('TRIM(stud_otch)'), $fullName['last_name']);
        }

        return $student->latest($this->primaryKey)->first();
    }
}
