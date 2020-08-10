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

        return $this;
    }

    public function disguiseEmail()
    {
        return preg_replace('/(?:^|@).\K|\.[^@]*$(*SKIP)(*F)|.(?=.*?\.)/', '*', $this->email);
    }

    public function createPassword()
    {
        $alphabet = '1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;

        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }

    public function getIIN($IIN)
    {
        return $this->where('IIN', $IIN)->first();
    }

    public function getFullName($firstName, $middleName, $lastName)
    {
        return $this->where('stud_fam', $firstName)->where('stud_name', $middleName)->where('stud_otch', $lastName)
            ->first();
    }
}
