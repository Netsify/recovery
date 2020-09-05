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

    public function collectionToSession()
    {
        session()->put('collection', $this);
    }

    public function disguiseEmail()
    {
        return preg_replace('/(?<=.).(?=[^@]+@)|(?<=@.).*(?=.*?\.)/', '*', $this->email);
    }

    public function createPassword()
    {
        return substr(str_shuffle('0123456789'), 0, 8);
    }

    public function getIIN($IIN)
    {
        return $this->where('IIN', $IIN)->first();
    }

    public function getFullNameLong($firstName, $middleName, $lastName)
    {
        $student = $this->where('stud_fam', $firstName)->where('stud_name', $middleName);
        if ($lastName)
            $student->where('stud_otch', $lastName);
        return $student->first();
    }

    public function getFullNameShort($firstName, $middleName)
    {
        return $this->where('stud_fam', $firstName)->where('stud_name', $middleName)->first();
    }
}
